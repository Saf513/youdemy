<?php

class Admin extends User
{
    public function __construct($id = null, $nom = null, $email = null, $password = null, $isActive = true, $createdAt = null, $updatedAt = null)
    {
        parent::__construct($id, $nom, $email, $password, 'admin', $isActive, $createdAt, $updatedAt);
    }

     public function validateTeacher(Teacher $teacher): bool
    {
       $teacher->setIsActive(true);
       // Assuming a save method in Teacher class to update DB
       return $teacher->save();
    }


      public function manageUsers(): array|bool
    {
         $db = new Database('localhost', 'youdemy', 'root', '');
       $query = "SELECT * FROM users";
       return  $db->executeQuery($query, []);
    }

     public function manageContent(): array
    {
         //logic for managing Content
         return ['message' => 'manage content by admin'];
    }

     public function viewGlobalStats(): array|bool
    {
        //logic for global statics
         $db = new Database('localhost', 'youdemy', 'root', '');
        $query = "SELECT COUNT(*) as total FROM courses";
        return $db->executeQuery($query, []);
    }

      public function manageTags(): array
    {
        // Logic for managing tags
       return  ['message' => 'manage tag by admin'];
    }

    public function manageCategories(): array
    {
          // Logic for managing Categories
         return ['message' => 'manage categories by admin'];
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
}