<?php
require_once dirname(__DIR__, 2) . '/classes/Auth/Authentification.php';
require_once dirname(__DIR__, 2) . '/classes/Course/Course.php';
require_once dirname(__DIR__, 2) . '/classes/User/Student.php';
require_once dirname(__DIR__, 2) . '/classes/Database/Database.php';
require_once dirname(__DIR__, 2) . '/classes/Auth/Session.php';


Session::start();
$user = Authentification::getUser();
$db = new Database('localhost', 'youdemy', 'root', 'root');

$courseId = $_GET['id'] ?? null;
// if (!$courseId) {
//     header('Location: /pages/courses/index.php');
//     exit();
// }

$course = Course::getCourseById($db, $courseId);
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
        header("Location: /pages/student/course-view.php?id=" . $course->getId());
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
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
<a href="./../student/my-courses.php"></a>             enroll now
               </button>
                        </form>
                    <?php else: ?>
                        <a href="../../pages/student/my-courses.php ?id=<?= $courseId ?>" 
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
                                    <svg class="w-6 h-6 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Duration: 6 weeks</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-6 h-6 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Certificate of completion</span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-6 h-6 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                                    </svg>
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
                                    <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1