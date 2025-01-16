<?php
require_once dirname(__DIR__, 2) . '/classes/Auth/Authentification.php';
require_once dirname(__DIR__, 2) . '/classes/Course/Course.php';
require_once dirname(__DIR__, 2) . '/classes/User/Student.php';
require_once dirname(__DIR__, 2) . '/classes/User/Teacher.php';
require_once dirname(__DIR__, 2) . '/classes/Auth/Session.php';
require_once dirname(__DIR__, 2) . '/classes/Database/Database.php';

$db = new Database('localhost', 'youdemy', 'root', 'root');

$courseId = $_GET['id'] ?? null;

// if ($courseId === null || !is_numeric($courseId)) {
//     header('Location: http://localhost:3000/pages/courses/course.php'); 
//     exit();
// }

// Convertir en entier
$courseId = (int)$courseId;

// Récupérer le cours
$course = Course::getCourseById($db, $courseId);

if (!$course) {
    // Si le cours n'existe pas, rediriger ou afficher un message d'erreur
    header('Location: /pages/courses/index.php');
    exit();
}

// Afficher les détails du cours ou effectuer d'autres opérations

Session::start();
$user = Authentification::getUser();
$db = new Database('localhost', 'youdemy', 'root', 'root');

$courseId = $_GET['id'] ?? null;
// if (!$courseId) {
//     header('Location: /pages/courses/index.php');
//     exit();
// }

// $course = Course::getCourseById($db, $courseId);
// if (!$course) {
//     header('Location: /pages/courses/index.php');
//     exit();
// }

$isEnrolled = false;
if ($user && $user->getRole() === 'student') {
    $student = new Student($user->getId());
    $enrolledCourses = $student->getEnrolledCourses();
    $isEnrolled = array_filter($enrolledCourses, function($c) use ($course) {
        return $c->getId() === $course->getId();
    });
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enroll'])) {
    if (!$user) {
        header('Location: /pages/auth/login.php');
        exit();
    }

    $student = new Student($user->getId());
    if ($student->enrollCourse($course)) {
        // Ajouter le cours à l'enseignant
        $teacher = new Teacher($course->getAuthorId());
        // $teacher->loadCreatedCourses(); // Recharger les cours créés par l'enseignant
        header("Location: /pages/student/course-view.php?id=" . $course->getId());
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll in Course | YouDemy</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <?php include_once dirname(__DIR__, 1) . '/common/header.php' ?>

    <!-- Course Hero Section -->
    <section class="relative bg-gradient-to-r from-purple-600 to-indigo-600 py-32">
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap items-center">
                <div class="w-full lg:w-3/5 text-white">
                    <h1 class="text-5xl font-bold mb-6"><?php echo htmlspecialchars($course->getTitle()) ?></h1>
                    <p class="text-xl mb-8 opacity-90"><?php echo htmlspecialchars($course->getDescription()) ?></p>
                    <?php if (!$isEnrolled): ?>
                        <form method="POST" class="inline">
                            <button type="submit" name="enroll" 
                                    class="bg-white text-purple-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition-colors">
                                Enroll Now
                            </button>
                        </form>
                    <?php else: ?>
                        <a href="/pages/student/course-view.php?id=<?php echo $course->getId() ?>" 
                           class="bg-white text-purple-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition-colors inline-block">
                            Continue Learning
                        </a>
                    <?php endif; ?>
                </div>
                <div class="w-full lg:w-2/5 mt-10 lg:mt-0">
                    <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
                        <img src="<?php echo $course->getThumbnailUrl() ?? '/public/assets/img/default-course.jpg' ?>" 
                             alt="Course Preview" 
                             class="w-full h-64 object-cover">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center">
                                    <img src="/public/assets/img/default-avatar.png" alt="Instructor" 
                                         class="w-12 h-12 rounded-full">
                                    <div class="ml-4">
                                        <p class="text-gray-900 font-medium">Instructor</p>
                                        <p class="text-gray-600">Professor</p>
                                    </div>
                                </div>
                            </div>
                            <ul class="space-y-4">
                                <li class="flex items-center">
                                    <i class="fas fa-clock text-purple-600 mr-2"></i>
                                    <span>Duration: 6 weeks</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-certificate text-purple-600 mr-2"></i>
                                    <span>Certificate of completion</span>
                                </li>
                                <li class="flex items-center">
                                    <i class="fas fa-infinity text-purple-600 mr-2"></i>
                                    <span>Full lifetime access</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Content -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap -mx-4">
                <div class="w-full lg:w-2/3 px-4">
                    <h2 class="text-3xl font-bold mb-8">Course Content</h2>
                    <div class="space-y-6">
                        <div class="border rounded-lg overflow-hidden">
                            <div class="p-4 bg-gray-50 flex items-center justify-between">
                                <h3 class="text-lg font-semibold">Module 1: Introduction</h3>
                                <span class="text-gray-600">3 lessons</span>
                            </div>
                            <div class="p-4 space-y-2">
                                <div class="flex items-center">
                                    <i class="fas fa-play-circle text-purple-600 mr-2"></i>
                                    <span>Lesson 1: Introduction to the Course</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-play-circle text-purple-600 mr-2"></i>
                                    <span>Lesson 2: Course Objectives</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-play-circle text-purple-600 mr-2"></i>
                                    <span>Lesson 3: Getting Started</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include_once dirname(__DIR__, 1) . '/common/footer.php' ?>
</body>
</html>