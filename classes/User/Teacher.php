<?php
require_once __DIR__ . '\User.php';
class Teacher extends User
{
     private array $createdCourses = [];
    public function __construct($id = null, $nom = null, $email = null, $password = null, $isActive = false, $createdAt = null, $updatedAt = null)
    {
        parent::__construct($id, $nom, $email, $password, 'teacher', $isActive, $createdAt, $updatedAt);
           $this->loadCreatedCourses();
    }


    // private function saveCourse(Database $db, Course $course): bool
    // {

    //     if (isset($course->id)) {

    //         $query = "UPDATE courses SET title = :title, description = :description, content = :content, user_id = :user_id, category_id = :category_id, content_type = :content_type, content_url = :content_url, status = :status, thumbnailUrl = :thumbnailUrl WHERE id = :id";
    //          $params = [
    //                 'id' => $course->getId(),
    //                 'title' => $course->getTitle(),
    //                 'description' => $course->getDescription(),
    //                 'content' => $course->getContent(),
    //                 'user_id' => $course->getAuthorId(),
    //                 'category_id' => $course->getCategoryId(),
    //                 'content_type' => $course->getContentType(),
    //                 'content_url' => $course->getContentUrl(),
    //                 'status' => $course->getStatus(),
    //                 'thumbnailUrl' => $course->getThumbnailUrl(),
    //              ];
    //              $result = $db->executeQuery($query, $params);
    //               $this->saveCourseTags($db,$course);
    //              return $result;

    //     } else {
    //         $query = "INSERT INTO courses (title, description, content, user_id, category_id, createdAt, content_type, content_url, status, thumbnailUrl) VALUES (:title, :description, :content, :user_id, :category_id, NOW(), :content_type, :content_url, :status, :thumbnailUrl)";
    //          $params = [
    //                'title' => $course->getTitle(),
    //                 'description' => $course->getDescription(),
    //                 'content' => $course->getContent(),
    //                 'user_id' => $course->getAuthorId(),
    //                 'category_id' => $course->getCategoryId(),
    //                 'content_type' => $course->getContentType(),
    //                 'content_url' => $course->getContentUrl(),
    //                   'status' => $course->getStatus(),
    //                  'thumbnailUrl' => $course->getThumbnailUrl(),
    //               ];
    //          $result =  $db->executeQuery($query, $params);
    //         if($result){
    //              $courseId = $db->getConnection()->lastInsertId();
    //             $course->setId((int)$courseId);  // Set the ID *after* successful insertion
    //              $this->saveCourseTags($db, $course);
    //             $this->createdCourses[] = $course;
    //               return true;
    //         }
    //           return false;

    //     }
    // }


      private function saveCourseTags(dataBase $db, Course $course): void
    {
       if ($course->getId()) { // Check if course ID exists before deleting tags
             $query = "DELETE FROM course_tags WHERE course_id = :course_id";
              $db->executeQuery($query, ['course_id' => $course->getId()]);
           foreach ($course->getTags() as $tag) {
                  $query = "INSERT INTO course_tags (course_id, tag_id) VALUES (:course_id, :tag_id)";
               $db->executeQuery($query, ['course_id' => $course->getId(), 'tag_id' => $tag->getId()]);
            }
        }
    }
   private function loadCreatedCourses(): void
    {
        if ($this->id) {
            $db = new Database('localhost', 'youdemy', 'root', 'root');
             $courses = Course::getCoursesByTeacherId($db, $this->id);
            if ($courses) {
               $this->createdCourses = $courses;
            }
        }
    }
    public function getCreatedCourses(): array
    {
        return $this->createdCourses;
    }

   public function createCourse(array $data): ?Course
   {
       $course = new Course();
       $course->setTitle(InputValidator::sanitizeString($data['title']));
       $course->setDescription(InputValidator::sanitizeString($data['description']));
       $course->setContent(InputValidator::sanitizeString($data['content']));
       $course->setAuthorId($this->id);
       $course->setCategoryId($data['category_id']);
       $course->setContentType($data['content_type']);
       $course->setContentUrl($data['content_url']);
       $course->setThumbnailUrl($data['thumbnailUrl']);
       $tagIds = $data['tags']?? [];
       foreach($tagIds as $tagId){
           $tag = Tag::getTagById($tagId);
           if($tag) $course->addTag($tag);
       }
       $db = new Database('localhost', 'youdemy', 'root', 'root');
     if( $this->saveCourse($db,$course)) {
        $this->createdCourses[] = $course;
         return $course;
         
       }
       return null;
   }



   public function updateCourse(int $courseId, array $data): ?Course
    {
        $db = new Database('localhost', 'youdemy', 'root', '');
        $course = Course::getCourseById($db, $courseId);
        if($course && $course->getAuthorId() == $this->id) {
            $course->setTitle(InputValidator::sanitizeString($data['title'] ?? $course->getTitle()));
            $course->setDescription(InputValidator::sanitizeString($data['description'] ?? $course->getDescription()));
            $course->setContent(InputValidator::sanitizeString($data['content'] ?? $course->getContent()));
            $course->setContentType($data['content_type']?? $course->getContentType());
            $course->setContentUrl($data['content_url']?? $course->getContentUrl());
            if (isset($data['category_id'])) {
                $category = Category::getCategoryById($data['category_id']);
                if ($category) $course->setCategoryId($category->getId());
            }
            $tagIds = $data['tags'] ?? [];
            $course->removeALlTags($db);
            foreach ($tagIds as $tagId) {
                $tag = Tag::getTagById($tagId);
                if ($tag) $course->addTag($tag);
            }
             if($this->saveCourse($db, $course)){
               $this->loadCreatedCourses();
                 return $course;
             }
         }
         return null;
    }

    public function deleteCourse(int $courseId): bool
    {
       $db = new Database('localhost', 'youdemy', 'root', '');
        $course = Course::getCourseById($db, $courseId);
        if ($course && $course->getAuthorId() == $this->id) {
            $result = $course->delete($db);
            if($result) {
                $this->createdCourses = array_filter($this->createdCourses, function($c) use ($course){
                    return $c->getId() !== $course->getId();
                 });
               return true;
             }
        }
       return false;
    }

    public function viewStatistics(int $courseId): array|bool
    {
       $db = new Database('localhost', 'youdemy', 'root', '');
       $query = "SELECT COUNT(*) as total FROM enrollments WHERE course_id = :course_id";
      return  $db->executeQuery($query,['course_id' => $courseId]);
    }
    public function getTeacherStatistics(): array|bool
    {
        // Logic for view teachers statics
        $db = new Database('localhost', 'youdemy', 'root', '');
         $query = "SELECT COUNT(*) as total FROM courses WHERE user_id = :user_id";
         return $db->executeQuery($query,['user_id' => $this->id]);
     }

      public function updateProfile(array $data, ?array $photoFile = null): bool
     {
         $this->setNom(InputValidator::sanitizeString($data['nom'] ?? $this->nom));
         $email =  InputValidator::sanitizeString($data['email'] ?? $this->email);
       if(!InputValidator::validateEmail($email)) return false;
       $this->setEmail($email);
       $fileUploader = new FileUploader(constant('UPLOAD_DIR') .'users/');
         if ($photoFile) {
              $uploadedFile = $fileUploader->uploadFile($photoFile);
              if ($uploadedFile) {
                 if($this->photoUrl){
                     $fileUploader->deleteFile($this->photoUrl);
                 }
                $this->setPhotoUrl($uploadedFile);
              }
            }
        return $this->save();
    }
    private function saveCourse(dataBase $db, Course $course): bool
    {
        if (($course->getId() !== null)) {
             $query = "UPDATE courses SET title = :title, description = :description, content = :content, user_id = :user, category_id = :category_id, content_type = :content_type, content_url = :content_url, status = :status, thumbnailUrl = :thumbnailUrl WHERE id = :id";
             $params = [
                    'id' => $course->getId(),
                    'title' => $course->getTitle(),
                    'description' => $course->getDescription(),
                    'content' => $course->getContent(),
                    'user_id' => $course->getAuthorId(),
                    'category_id' => $course->getCategoryId(),
                    'content_type' => $course->getContentType(),
                    'content_url' => $course->getContentUrl(),
                    'status' => $course->getStatus(),
                    'thumbnailUrl' => $course->getThumbnailUrl(),
                 ];
               $result =  $db->executeQuery($query, $params);
                 $this->saveCourseTags($db,$course);
                return $result;
        } else {
            $query = "INSERT INTO courses (title, description, content, user_id, category_id, created_at, content_type, content_url, status, thumbnailUrl  ) VALUES (:title, :description, :content, :user_id, :category_id, NOW(), :content_type, :content_url, :status, :thumbnailUrl)";
            $params = [
                   'title' => $course->getTitle(),
                    'description' => $course->getDescription(),
                    'content' => $course->getContent(),
                    'user_id' => $course->getAuthorId(),
                    'category_id' => $course->getCategoryId(),
                    'content_type' => $course->getContentType(),
                    'content_url' => $course->getContentUrl(),
                      'status' => $course->getStatus(),
                     'thumbnailUrl' => $course->getThumbnailUrl(),
                ];
             $result = $db->executeQuery($query, $params);
            if($result){
                $course->setId((int) $db->getConnection()->lastInsertId());
                  $this->saveCourseTags($db, $course);
              }
              return $result;
        }
    }
    //     private function saveCourseTags(dataBase $db, Course $course): void
    // {
    //     $query = "DELETE FROM course_tags WHERE course_id = :course_id";
    //      $db->executeQuery($query,['course_id' => $course->getId()]);
    //     foreach($course->getTags() as $tag){
    //       $query = "INSERT INTO course_tags (course_id, tag_id) VALUES (:course_id, :tag_id)";
    //      $db->executeQuery($query,['course_id' => $course->getId(), 'tag_id' => $tag->getId()]);
    //     }
    // }
                                                                                                                                                                                                                                                                                                                                                       
    
 
    protected function saveNew(): bool
    {
        $db = new Database('localhost', 'youdemy', 'root', 'root');
        $query = "INSERT INTO users (full_name, email, password, role, status, created_at, updated_at) 
                VALUES (:full_name, :email, :password, :role, :status, NOW(), NOW())";
        $params = [
            'full_name' => $this->getNom(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'role' => $this->getRole(),
            'status' => $this->isActive() ? 'active' : 'pending'
        ];
        if ($db->executeQuery($query, $params)) {
            $this->id = (int)$db->getConnection()->lastInsertId();
            return true;
        }
        return false;
    }

    public function save(): bool
    {
        if ($this->id === null) {
            return $this->saveNew();
        }

        $db = new Database('localhost', 'youdemy', 'root', 'root');
        $query = "UPDATE users SET full_name = :full_name, email = :email, password = :password, role = :role, status = :status, photoUrl = :photoUrl, updated_at = NOW() WHERE id = :id";
        $params = [
            'id' => $this->id,
            'full_name' => $this->getNom(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'role' => $this->getRole(),
            'status' => $this->isActive() ? 'active' : 'pending',
            'photoUrl' => $this->photoUrl
        ];
        return $db->executeQuery($query, $params);
    }

    public function signUp(array $data): bool
    {
        $this->setNom(InputValidator::sanitizeString($data['full_name'] ?? ''));
        $email = InputValidator::sanitizeString($data['email'] ?? '');
        if (!InputValidator::validateEmail($email)) return false;
        $this->setEmail($email);
        $password = $data['password'] ?? '';
        if (!InputValidator::validatePassword($password)) return false;
        $this->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $this->setIsActive(true);

        return $this->save();
    }
}