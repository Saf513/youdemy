<?php
 require_once dirname(__DIR__, 2).'/classes/Database/Database.php';

class Authentification
{

/*==============/*
fonction de login 
/*=============*/

    public static function login(string $email, string $password): ?User
    {
        $db = new Database('localhost', 'youdemy', 'root', 'root');
        $query = "SELECT * FROM users WHERE zmail = :email";
        $result = $db->executeQuery($query, ['email' => $email]);

        if ($result && count($result) > 0) {

            $user =  $result[0];
            if (password_verify($password, $user['password'])) {
                $role = $user['role'];
                $userClass = match ($role) {
                    'admin' => new Admin(),
                    'teacher' => new Teacher(),
                    'student' => new Student(),
                    'default' => null,
                };
                if ($userClass) {
                    $userClass->loadData($user);
                    return $userClass;
                }
            }
        }
        return NULL;
    }


/*==================/*
  fonction de logout 
/*==================*/
    public static function lougout(): void
    {
        ((new Session())->destroy());
    }

 /*========================================/*
  fonction de verifier authentification
/*========================================*/

    public static function isAuthentificated(): bool
    {
        return (new Session())->has('user_id');
    }

/*======================/*
   fonction de grtUser
/*======================*/

    public static function getUser(): ?User
    {
        if (self::isAuthentificated()) {
            $userId = (new Session())->get('user_id');
            $db = new Database('localhost', 'youdemy', 'root', 'root');
            $query = "SELECT * FROM users WHERE id = :id";
            $result = $db->executeQuery($query, ['id' => $userId]);
            if ($result && count($result) > 0) {
                $user = $result[0];
                $role = $user['role'];
                $userClass = match ($role) {
                    'admin' => new Admin(),
                    'teacher' => new Teacher(),
                    'student' => new Student(),
                    default => null,
                };
                if ($userClass) {
                    $userClass->loadData($user);
                    return $userClass;
                }
            }
        }
        return null;
    }

/*================/*
fonction hasrole
/*================*/
    public static function hasRole(string $role): bool
    {
        $user = self::getUser();
        return $user && $user->getRole() === $role;
    }

/*==================================/*
fonction de verifier l autorization
/*=================================*/
    public static function isAuthorized(array $allowedRoles): bool
    {
        if (!self::isAuthentificated()) return false;

        foreach ($allowedRoles as $allowedRole) {
            if (self::hasRole($allowedRole)) {
                return true;
            }
        }
        return false;
    }
}
