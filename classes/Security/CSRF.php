<?php

                  /*=====================/*
                          classe csrf
                  /*=====================*/

class CSRF
{

    /*====================================/*
      fonction pour generer un csrf token
    /*====================================*/
    public static  function generateToken(): string
    {
        $session = new Session();
        if (!$session->get('csrf_token')) {
            $token = bin2hex(random_bytes(32));
            $session->set('csrf_token', $token);
            return $token;
        }
        return $session->get('csrf_token');
    }


    /*=============================/*
     fonction pour valider le token
    /*=============================*/
    public static function validateToken(string $token): bool
    {
        $session = new Session();
        $storedToken = $session->get('csrf_token');
        if (!$storedToken) return false;
        return hash_equals($storedToken, $token);
    }

     /*===============================/*
      fonction pour detruire le token 
     /*===============================*/
    public static function unsetToken(): void
    {
        $session = new Session();
        $session->set('csrf_token', null);
    }
}
