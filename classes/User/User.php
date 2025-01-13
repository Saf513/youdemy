<?php

// creation de classe de user 

abstract User 
{

    protected int $id;
    protected string $nom;
    protected string $email;
    protected string $password;
    protected string $role;
    protected bool $isActive;
    protected $createdAt;





}




?>