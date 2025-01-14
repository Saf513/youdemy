<?php

spl_autoload_register(function ($class) {
    $base_dir = __DIR__ . '/'; // Root directory of your project

    // List of directories where your classes are located
    $directories = [
        'classes/',
         'classes/Auth/',
        'classes/Database/',
        'classes/Security/',
         'classes/User/',
         'classes/Utils/',
        'classes/Course/',
    ];
    
    foreach ($directories as $dir) {
        $file = $base_dir . $dir . str_replace('\\', '/', $class) . '.php';
      
        if (file_exists($file)) {
           require_once $file;
            return; // Stop if file is found
        }
    }
});