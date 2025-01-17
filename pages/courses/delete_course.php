<?php
// Inclusion des fichiers nécessaires
require_once dirname(__DIR__, 2) . '/classes/Auth/Authentification.php';
require_once dirname(__DIR__, 2) . '/classes/User/Teacher.php';
require_once dirname(__DIR__, 2) . '/classes/Course/Course.php';
require_once dirname(__DIR__, 2) . '/classes/Database/Database.php';
require_once dirname(__DIR__, 2) . '/classes/Auth/Session.php';
require_once dirname(__DIR__, 2) . '/classes/Security/CSRF.php';

Session::start();

$user = Authentification::getUser();

if (!$user || $user->getRole() !== 'teacher') {
    header('Location: /pages/auth/login.php');
    exit();
}

$teacher = new Teacher($user->getId());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validation du token CSRF
    $token = $_POST['csrf_token'] ?? '';
    if (!CSRF::validateToken($token)) {
        die('Invalid CSRF token');
    }

    // Récupérer l'ID du cours
    $courseId = isset($_POST['course_id']) ? (int)$_POST['course_id'] : 0;
    
    // Vérification si l'ID est valide et suppression du cours
    var_dump($teacher->deleteCourse($courseId));
    if ($courseId > 0 && $teacher->deleteCourse($courseId)) {
        header('Location: /pages/teacher/dashboard.php?success=Course deleted successfully');
    } else {
        header('Location: /pages/teacher/dashboard.php?error=Failed to delete course');
    }
    exit();
}

// Vérification de l'ID du cours depuis l'URL (doit être un entier positif)
$courseId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($courseId <= 0) {
    header('Location: /pages/teacher/dashboard.php');
    exit();
}

$db = new Database('localhost', 'youdemy', 'root', 'root');
$course = Course::getCourseById($db, $courseId);

// Vérifier que le cours appartient bien à l'utilisateur
if (!$course || $course->getAuthorId() !== $user->getId()) {
    header('Location: /pages/teacher/dashboard.php');
    exit();
}
ini_set('display_errors', 1);
error_reporting(E_ALL);

?>

<!-- Page HTML pour confirmation -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer le Cours - <?php echo htmlspecialchars($course->getTitle()); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <?php include_once dirname(__DIR__, 1) . '/common/header.php' ?>

    <div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6 text-red-600">Supprimer le Cours</h1>

        <div class="mb-6">
            <p class="text-gray-700 mb-4">Êtes-vous sûr de vouloir supprimer le cours suivant ?</p>
            <h2 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($course->getTitle()); ?></h2>
            <p class="text-gray-600"><?php echo htmlspecialchars($course->getDescription()); ?></p>
        </div>

        <!-- Un seul formulaire -->
        <form method="POST" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?php echo CSRF::generateToken(); ?>">
            <input type="hidden" name="course_id" value="<?php echo $course->getId(); ?>">

            <!-- Message d'avertissement -->
            <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                <p class="text-red-700 text-sm">
                    <strong>Attention :</strong> Cette action est irréversible. Tout le contenu du cours, y compris les progrès des étudiants et les inscriptions, sera définitivement supprimé.
                </p>
            </div>

            <!-- Champ de confirmation -->
            <div class="mb-6">
                <label for="course_name" class="block text-gray-700">Veuillez taper le nom du cours pour confirmer :</label>
                <input type="text" name="course_name" id="course_name" class="border rounded-md p-2 w-full mt-2" required>
            </div>

            <!-- Boutons de confirmation -->
            <div class="flex justify-end space-x-4">
                <a href="/pages/teacher/dashboard.php" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Annuler
                </a>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Supprimer le Cours
                </button>
            </div>
        </form>
    </div>
</div>
        </div>
    </div>
</body>
</html>
