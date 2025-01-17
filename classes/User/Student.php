<?php
require_once __DIR__ . '\User.php';
require_once dirname(__DIR__, 2) . '/classes/Database/Database.php';
class Student extends User
{
    protected array $enrolledCourses = [];

    public function __construct($id = null, $nom = null, $email = null, $password = null, $role = null, $isActive = true, $createdAt = null, $updatedAt = null)
    {
        parent::__construct($id, $nom, $email, $password, 'student', $isActive, $createdAt, $updatedAt);
        $this->loadEnrolledCourses();
    }

    private function loadEnrolledCourses(): void
    {
        if ($this->id) {
            $db = new Database('localhost', 'youdemy', 'root', 'root');
            $courses = Course::getCoursesByStudentId($db, $this->id);
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
        $db = new Database('localhost', 'youdemy', 'root', 'root');
        $query = "INSERT INTO enrollments (student_id, course_id) VALUES (:student_id, :course_id)";
        $params = ['student_id' => $this->id, 'course_id' => $course->getId()];
        var_dump($this->enrolledCourses);
        if ($db->executeQuery($query, $params)) {
            $this->enrolledCourses[] = $course;
            return true;
        }
        return false;
    }

    public function viewEnrolledCourses(): array
    {
        return $this->enrolledCourses;
    }

    public function updateProfile(array $data, ?array $photoFile = null): bool
    {
        $this->setNom(InputValidator::sanitizeString($data['full_name'] ?? $this->nom));
        $email = InputValidator::sanitizeString($data['email'] ?? $this->email);
        if (!InputValidator::validateEmail($email)) return false;
        $this->setEmail($email);
        $fileUploader = new FileUploader(constant('UPLOAD_DIR') . 'users/');
        if ($photoFile) {
            $uploadedFile = $fileUploader->uploadFile($photoFile);
            if ($uploadedFile) {
                if ($this->photoUrl) {
                    $fileUploader->deleteFile($this->photoUrl);
                }
                $this->setPhotoUrl($uploadedFile);
            }
        }
        return $this->save();
    }

    public function leaveCourse(Course $course): bool
    {
        $db = new Database('localhost', 'youdemy', 'root', 'root');
        $query = "DELETE FROM enrollments WHERE student_id = :student_id AND course_id = :course_id";
        if ($db->executeQuery($query, ['student_id' => $this->id, 'course_id' => $course->getId()])) {
            $this->enrolledCourses = array_filter($this->enrolledCourses, function ($c) use ($course) {
                return $c->getId() !== $course->getId();
            });
            return true;
        }
        return false;
    }

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
