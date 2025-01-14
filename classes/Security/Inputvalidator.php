<?php

                   /*================================/*
                     classe de valisation des input 
                    /*==============================*/

class InputValidator
{
/*======================================/*
  fonction pour desinfecter les inputes
/*=====================================*/      

    public static function sanitizeString(string $data): string
    {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

/*======================================/*
  fonction pour valider les emailes
/*=====================================*/        

    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

/*======================================/*
  fonction pour valider les mots de passe
/*=====================================*/    
    public static function validatePassword(string $password): bool
    {
        return strlen($password) >= 8;
    }

/*======================================/*
  fonction pour valider les nombres
/*=====================================*/  

    public static function validateNumber(int|string $number): bool
    {
        return filter_var($number, FILTER_VALIDATE_INT) !== false;
    }

/*=================================/*
  fonction pour valider les dates
/*=================================*/      
    public static function validateDate(string $date, string $format = 'Y-m-d H:i:s'): bool
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}
