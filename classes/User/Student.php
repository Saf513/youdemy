<?php 
require_once '../../classes/User/User.php';
require_once '../../classes/Course/Course.php';
require_once '../../classes/Database/Database.php';
require_once '../../classes/Auth/Authentification.php';

class Student extends User
{
 protected array $enrolledCourses = [];

public function __construct($id = null, $nom = null, $email = null, $password = null, $role = null, $isActive = true, $createdAt = null, $updatedAt = null)
{
    parent::__construct($id, $nom, $email, $password, $role, $isActive, $createdAt, $updatedAt); 
}

 public function login() : bool {

    return true ;
 }

public function logout() : void {

}

public function updateProfile(array $data): bool
{
    return true ;
}

public function SignUp(): void {

}

}



?>