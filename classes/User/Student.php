<?php


class Student extends User
{
    protected array $enrolledCourses = [];

    public function __construct($id = null, $nom = null, $email = null, $password = null, $role = null, $isActive = true, $createdAt = null, $updatedAt = null)
    {
        parent::__construct($id, $nom, $email, $password, 'student', $isActive, $createdAt, $updatedAt);
        $this ->loadEnrolledCourses();
    }

  
    private function loadEnrolledCourses(): void
    {
        if ($this->id) {
            $db = new Database('localhost', 'youdemy', 'root', '');
             $courses = Course::getCoursesByStudentId($db,$this->id);
            if ($courses) {
               $this->enrolledCourses = $courses;
            }
        }
    }
    public function getEnrolledCourses(): array
    {
        return $this->enrolledCourses;
    }


    public function enrollCourse(Course $course): bool
    {
        $db = new Database('localhost', 'youdemy', 'root', '');
        $query = "INSERT INTO enrollments (student_id, course_id) VALUES (:student_id, :course_id)";
        $params = ['student_id' => $this->id, 'course_id' => $course->getId()];
      if($db->executeQuery($query, $params)){
        $this->enrolledCourses[] = $course;
          return true;
      }
        return false;
    }

    public function viewEnrolledCourses(): array
    {
         return $this->enrolledCourses;
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

    public function leaveCourse(Course $course): bool
    {
       $db = new Database('localhost', 'youdemy', 'root', '');
       $query = "DELETE FROM enrollments WHERE student_id = :student_id AND course_id = :course_id";
        if($db->executeQuery($query,['student_id' => $this->id, 'course_id' => $course->getId()])) {
            $this->enrolledCourses = array_filter($this->enrolledCourses, function ($c) use ($course) {
               return $c->getId() !== $course->getId();
            });
            return true;
         }
           return false;
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
  


