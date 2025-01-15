<?php
require_once dirname(__DIR__, 2).'/classes/Auth/Authentification.php';
require_once dirname(__DIR__, 2).'\classes\Auth\Session.php';

Session::start();
$isAuthenticated = Authentification::isAuthentificated();
$user = $isAuthenticated ? Authentification::getUser() : null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy</title>
    <link href="style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/public/assets/img/8640011fde624ac191771185fef03908-free.png">


    <script src="https://cdn.tailwindcss.com"></script>

    
</head>
<body class="font-montserrat bg-gray-50 text-gray-900">
    <header class="sticky top-0 bg-white shadow-md z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="#" class="flex items-center">
                <img src="/public/assets/img/8640011fde624ac191771185fef03908-free.png" alt="Logo de l'Académie" class="h-8 mr-2">
                <span class="font-playfair font-bold text-xl">Youdemy</span>
            </a>
            <nav class="hidden md:flex space-x-6">
                <a href="/index.php" class="hover:text-gray-600">Accueil</a>
                <a href="../../pages/courses/course.php" class="hover:text-gray-600">Cours</a>
                <a href="#instructeurs" class="hover:text-gray-600">Instructeurs</a>
                <a href="#temoignages" class="hover:text-gray-600">Témoignages</a>
                
                <?php if ($isAuthenticated && $user): ?>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <?php if ($user->getPhotoUrl()): ?>
                                <img src="<?php echo htmlspecialchars($user->getPhotoUrl()); ?>" alt="Photo de profil" class="h-8 w-8 rounded-full object-cover">
                            <?php else: ?>
                                <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-gray-600 text-sm"><?php echo substr($user->getNom(), 0, 1); ?></span>
                                </div>
                            <?php endif; ?>
                            <span class="font-medium"><?php echo htmlspecialchars($user->getNom()); ?></span>
                        </div>
                        <a href="/logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition-colors duration-300">Déconnexion</a>
                    </div>
                <?php else: ?>
                    <a href="../../pages/auth/signUp.php" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-4 py-2 rounded-md transition-colors duration-300">Inscription</a>
                    <a href="../../pages/auth/login.php" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-4 py-2 rounded-md transition-colors duration-300">Login</a>
                <?php endif; ?>
            </nav>
            
            <!-- Mobile menu button -->
            <button id="menu-toggle" class="md:hidden">
                <img src="assets/icons/menu.svg" alt="Menu" class="h-6 w-6">
            </button>
        </div>
        
        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden absolute top-full left-0 w-full bg-white shadow-md z-10">
            <div class="container mx-auto px-6 py-4 flex flex-col space-y-2">
                <a href="#" class="hover:text-gray-600 block py-2">Accueil</a>
                <a href="#cours" class="hover:text-gray-600 block py-2">Cours</a>
                <a href="#instructeurs" class="hover:text-gray-600 block py-2">Instructeurs</a>
                <a href="#temoignages" class="hover:text-gray-600 block py-2">Témoignages</a>
                
                <?php if ($isAuthenticated && $user): ?>
                    <div class="flex items-center py-2">
                        <?php if ($user->getPhotoUrl()): ?>
                            <img src="<?php echo htmlspecialchars($user->getPhotoUrl()); ?>" alt="Photo de profil" class="h-8 w-8 rounded-full object-cover mr-2">
                        <?php else: ?>
                            <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center mr-2">
                                <span class="text-gray-600 text-sm"><?php echo substr($user->getNom(), 0, 1); ?></span>
                            </div>
                        <?php endif; ?>
                        <span class="font-medium"><?php echo htmlspecialchars($user->getNom()); ?></span>
                    </div>
                    <a href="/logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition-colors duration-300 text-center block">Déconnexion</a>
                <?php else: ?>
                    <a href="../../pages/auth/signUp.php" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-4 py-2 rounded-md transition-colors duration-300 text-center block">Inscription</a>
                    <a href="../../pages/auth/login.php" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-4 py-2 rounded-md transition-colors duration-300 text-center block">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </header>
</body>
</html>