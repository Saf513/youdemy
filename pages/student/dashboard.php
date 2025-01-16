<?php
require_once dirname(__DIR__, 2) . '/classes/Auth/Authentification.php';
require_once dirname(__DIR__, 2) . '/classes/User/Student.php';
require_once dirname(__DIR__, 2) . '/classes/Course/Course.php';
require_once dirname(__DIR__, 2) . '/classes/Database/Database.php';
require_once dirname(__DIR__, 2) . '/classes/Auth/Session.php';
require_once dirname(__DIR__, 2) . '/classes/Utils/Statistics.php';

Session::start();

$user = Authentification::getUser();

if (!$user || $user->getRole() !== 'student') {
    header('Location: /pages/auth/login.php');
    exit();
}

$db = new Database('localhost', 'youdemy', 'root', 'root');

$student = new Student($user->getId());

$enrolledCourses = $student->getEnrolledCourses();

$progress = []; // You'll need to implement a progress tracking system

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-50">
    <?php include_once dirname(__DIR__, 1) . '/common/header.php' ?>

    <!-- Hero Section with Profile -->
    <section class="bg-gradient-to-r from-purple-600 to-indigo-600 py-20">
        <div class="container mx-auto px-6">
            <div class="flex items-center">
                <div class="w-1/4">
                    <img src="<?php echo $user->getPhotoUrl() ?? '/public/assets/img/default-avatar.png' ?>" 
                         alt="Profile" 
                         class="w-32 h-32 rounded-full border-4 border-white shadow-lg">
                </div>
                <div class="w-3/4 text-white">
                    <h1 class="text-4xl font-bold mb-2"><?php echo $user->getNom() ?></h1>
                    <p class="text-xl opacity-90"><?php echo $user->getEmail() ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container mx-auto px-6 -mt-10">
        <div class="flex flex-wrap">
            <!-- Sidebar -->
            <div class="w-full md:w-1/4 mb-8">
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <nav class="space-y-4">
                        <a href="#" class="block py-2 px-4 rounded-lg bg-purple-100 text-purple-700 font-medium">Dashboard</a>
                        <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-purple-50 rounded-lg">My Profile</a>
                        <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-purple-50 rounded-lg">Learning Path</a>
                        <a href="#" class="block py-2 px-4 text-gray-700 hover:bg-purple-50 rounded-lg">Certificates</a>
                        <hr class="my-4">
                        <a href="/pages/auth/logout.php" class="block py-2 px-4 text-red-600 hover:bg-red-50 rounded-lg">Logout</a>
                    </nav>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="w-full md:w-3/4 pl-0 md:pl-8">
                <!-- Progress Overview -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <h2 class="text-2xl font-bold mb-6">Learning Progress</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-purple-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-purple-700 mb-2">Enrolled Courses</h3>
                            <p class="text-3xl font-bold"><?php echo count($enrolledCourses) ?></p>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-blue-700 mb-2">Completed</h3>
                            <p class="text-3xl font-bold">0</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-green-700 mb-2">Certificates</h3>
                            <p class="text-3xl font-bold">0</p>
                        </div>
                    </div>
                </div>

                <!-- Enrolled Courses -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <h2 class="text-2xl font-bold mb-6">My Courses</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($enrolledCourses as $course): ?>
                        <div class="bg-white border rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                            <img src="<?php echo $course->getThumbnailUrl() ?? '/public/assets/img/default-course.jpg' ?>" 
                                 alt="<?php echo htmlspecialchars($course->getTitle()) ?>" 
                                 class="w-full h-48 object-cover">
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($course->getTitle()) ?></h3>
                                <p class="text-gray-600 mb-4"><?php echo htmlspecialchars(substr($course->getDescription(), 0, 100)) ?>...</p>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-purple-600 h-2.5 rounded-full" style="width: <?php echo $progress[$course->getId()] ?? 0 ?>%"></div>
                                        </div>
                                        <span class="ml-2 text-sm text-gray-600"><?php echo $progress[$course->getId()] ?? 0 ?>%</span>
                                    </div>
                                    <a href="course-details.php?id=<?php echo $course->getId() ?>" 
                                       class="text-purple-600 hover:text-purple-700 font-medium">Continue</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>