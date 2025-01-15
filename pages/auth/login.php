<?php
require_once dirname(__DIR__, 2) . '/classes/Auth/Authentification.php';
require_once dirname(__DIR__, 2) . '/classes/Auth/Session.php';
require_once dirname(__DIR__, 2) . '/classes/Security/CSRF.php';
require_once dirname(__DIR__, 2) . '/classes/Security/InputValidator.php';
require_once dirname(__DIR__, 2) . '/classes/Database/Database.php';

Session::start();

// Redirect if already authenticated
if (Authentification::isAuthentificated()) {
    header('Location: /index.php');
    exit();
}

$error = '';
$csrfToken = CSRF::generateToken();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate CSRF token first
        $submittedToken = $_POST['csrf_token'] ?? '';
        if (!CSRF::validateToken($submittedToken)) {
            throw new Exception("Token de sécurité invalide. Veuillez réessayer.");
        }

        // Sanitize and validate inputs
        $email = InputValidator::sanitizeString($_POST['email'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Format d'email invalide.");
        }

        $password = $_POST['password'] ?? '';
        if (empty($password)) {
            throw new Exception("Le mot de passe est requis.");
        }

        // Attempt login
        $user = Authentification::login($email, $password);
        
        if ($user) {
            // Set session data
            Session::set('user_id', $user->getId());
            
            // Clean up
            CSRF::unsetToken();
            
            // Redirect to home
            header('Location: /index.php');
            exit();
        } else {
            throw new Exception('Identifiants incorrects. Veuillez réessayer.');
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
        // Generate new CSRF token after error
        $csrfToken = CSRF::generateToken();
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Youdemy</title>
    <link href="/public/assets/css/style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-montserrat bg-gray-50 text-gray-900">
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-purple-50">
        <div class="bg-white shadow-xl rounded-lg p-8 w-full max-w-md relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-tr from-blue-50 to-purple-50 opacity-30 -z-10"></div>
            <h2 class="text-3xl font-playfair font-bold text-center mb-8">Bienvenue à nouveau</h2>

            <?php if ($error): ?>
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6" novalidate>
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" 
                        required
                        autocomplete="email"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                    >
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" 
                        required
                        autocomplete="current-password"
                    >
                </div>
                <div>
                    <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold py-3 rounded-md transition-colors duration-300 focus:outline-none focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                        Se connecter
                    </button>
                </div>
                <div class="text-center">
                    <a href="/pages/auth/signUp.php" class="text-purple-500 hover:text-purple-700 font-medium">
                        Pas encore inscrit ?
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>