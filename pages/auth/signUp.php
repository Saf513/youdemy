<?php
require_once  '../../autoload/autoload.php';
// require_once dirname(__DIR__, 2) . '/classes/Security/CSRF.php';
// require_once dirname(__DIR__, 2) . '/classes/Security/InputValidator.php';
require_once '../../classes/Auth/Session.php';
require_once '../../classes/Security/CSRF.php';
require_once '../../classes/Security/Inputvalidator.php';
 Session::start();
$error = '';
  $csrfToken = CSRF::generateToken();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = InputValidator::sanitizeString($_POST['full_name'] ?? '');
    $email = InputValidator::sanitizeString($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['passwordConfirm'] ?? '';
    $csrfToken = $_POST['csrf_token'] ?? '';


        if(!CSRF::validateToken($csrfToken)){
           $error = "Invalid CSRF token.";
        } else  if(empty($fullName)){
           $error = "Full Name cannot be empty.";
        }
        else if (!InputValidator::validateEmail($email)) {
           $error = "Invalid email format.";
         }
         else if(!InputValidator::validatePassword($password)){
            $error = "Password must be at least 8 characters.";
         }  else if ($password !== $passwordConfirm){
           $error = "Passwords do not match.";
         }
           else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $student = new Student();
            $student->setNom($fullName);
            $student->setEmail($email);
            $student->setPassword($hashedPassword);
             if ($student->save()) {
                CSRF::unsetToken();
                 header('Location: login.php');
                 exit;
              } else {
                 $error = "Registration failed.";
             }
         }

}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | Youdemy</title>
    <link href="style.css" rel="stylesheet">
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="font-montserrat bg-gray-50 text-gray-900">

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-purple-50">
        <div class="bg-white shadow-xl rounded-lg p-8 w-full max-w-md relative overflow-hidden">
           <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-tr from-blue-50 to-purple-50 opacity-30 -z-10"></div>
            <h2 class="text-3xl font-playfair font-bold text-center mb-8">Rejoignez notre communauté</h2>
            <form id="signup-form" class="space-y-6" method="post">
              <input type="hidden" name="csrf_token" value="<?=$csrfToken ?>">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                    <input type="text" id="name" name="full_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" required>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" required>
                </div>
                 <div>
                   <label for="passwordConfirm" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                    <input type="password" id="passwordConfirm" name="passwordConfirm" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" required>
                </div>
                <div>
                     <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold py-3 rounded-md transition-colors duration-300 focus:outline-none focus:ring focus:ring-purple-200 focus:ring-opacity-50">S'inscrire</button>
                </div>
                 <div class="text-center">
                    <a href="login.php" class="text-purple-500 hover:text-purple-700 font-medium">Déjà inscrit ?</a>
                </div>
                <?php if($error):?>
                     <div id="signup-message" class="mt-4 text-center text-red-500">
                          <?php echo $error;?>
                     </div>
              <?php endif;?>
            </form>
        </div>
    </div>

</body>
</html>