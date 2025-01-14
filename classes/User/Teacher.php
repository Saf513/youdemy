<?php

class Teacher extends User
{
     private array $createdCourses = [];
    public function __construct($id = null, $nom = null, $email = null, $password = null, $isActive = false, $createdAt = null, $updatedAt = null)
    {
        parent::__construct($id, $nom, $email, $password, 'teacher', $isActive, $createdAt, $updatedAt);
           $this->loadCreatedCourses();
    }

   private function loadCreatedCourses(): void
    {
        if ($this->id) {
            $db = new Database('localhost', 'youdemy', 'root', '');
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
       $tagIds = $data['tags']?? [];
       foreach($tagIds as $tagId){
           $tag = Tag::getTagById($tagId);
           if($tag) $course->addTag($tag);
       }
       $db = new Database('localhost', 'youdemy', 'root', '');
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
         $query = "SELECT COUNT(*) as total FROM courses WHERE teacher_id = :teacher_id";
         return $db->executeQuery($query,['teacher_id' => $this->id]);
     }

      public function updateProfile(array $data, array $photoFile = null): bool
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
        if (isset($course->getId())) {
             $query = "UPDATE courses SET title = :title, description = :description, content = :content, teacher_id = :teacher_id, category_id = :category_id, content_type = :content_type, content_url = :content_url, status = :status, thumbnailUrl = :thumbnailUrl WHERE id = :id";
             $params = [
                    'id' => $course->getId(),
                    'title' => $course->getTitle(),
                    'description' => $course->getDescription(),
                    'content' => $course->getContent(),
                    'teacher_id' => $course->getAuthorId(),
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
            $query = "INSERT INTO courses (title, description, content, teacher_id, category_id, createdAt, content_type, content_url, status, thumbnailUrl) VALUES (:title, :description, :content, :teacher_id, :category_id, NOW(), :content_type, :content_url, :status, :thumbnailUrl)";
            $params = [
                   'title' => $course->getTitle(),
                    'description' => $course->getDescription(),
                    'content' => $course->getContent(),
                    'teacher_id' => $course->getAuthorId(),
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
        private function saveCourseTags(dataBase $db, Course $course): void
    {
        $query = "DELETE FROM course_tags WHERE course_id = :course_id";
         $db->executeQuery($query,['course_id' => $course->getId()]);
        foreach($course->getTags() as $tag){
          $query = "INSERT INTO course_tags (course_id, tag_id) VALUES (:course_id, :tag_id)";
         $db->executeQuery($query,['course_id' => $course->getId(), 'tag_id' => $tag->getId()]);
        }
    }
                                                                                                                                                                                                                                                                                                                                                       
     public function save(): bool
    {
        $db = new Database('localhost', 'youdemy', 'root', '');
        $query = "UPDATE users SET full_name = :full_name, email = :email, password = :password, role = :role, status = :status, photoUrl = :photoUrl,  updated_at = NOW() WHERE id = :id";
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
          $this->setNom(InputValidator::sanitizeString($data['nom'] ?? ''));
          $email = InputValidator::sanitizeString($data['email'] ?? '');
          if(!InputValidator::validateEmail($email)) return false;
          $this->setEmail($email);
          $password = $data['password'] ?? '';
           if(!InputValidator::validatePassword($password)) return false;
          $this->setPassword(password_hash($password, PASSWORD_DEFAULT));
          $this->setIsActive(true);

          return $this->save();
   }
}