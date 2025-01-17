<?php
require_once dirname(__DIR__, 2) . '/classes/Auth/Authentification.php';
require_once dirname(__DIR__, 2) . '/classes/User/Teacher.php';
require_once dirname(__DIR__, 2) . '/classes/Course/Course.php';
require_once dirname(__DIR__, 2) . '/classes/Database/Database.php';
require_once dirname(__DIR__, 2) . '/classes/Auth/Session.php';
require_once dirname(__DIR__, 2) . '/classes/Utils/Statistics.php';

Session::start();

$user = Authentification::getUser();

if (!$user || $user->getRole() !== 'teacher') {
    header('Location: /pages/auth/login.php');
    exit();
}

$db = new Database('localhost', 'youdemy', 'root', 'root');
$stats = new Statistics($db);
$teacherStats = $stats->getTeacherStatistics($user->getId());
$teacherCourses = Course::getCoursesByTeacherId($db, $user->getId());
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="font-montserrat bg-gray-100">
    <?php include_once dirname(__DIR__, 1) . '/common/header.php' ?>

    <!-- Hero Section -->
    <section class="bg-purple-500 py-16">
        <div class="container mx-auto px-6 flex items-center relative z-10">
            <div class="md:w-1/5 flex flex-col justify-center text-white pl-2">
                <img id="profile-image" src="<?php echo $user->getPhotoUrl() ? $user->getPhotoUrl() : '/public/assets/img/default-avatar.png' ?>" alt="Teacher avatar" class="w-20 h-20 rounded-full border-4 border-white mb-4 object-cover">
                <h2 id="teacher-name" class="text-white text-2xl mb-4">
                    <?php echo $user->getNom() ?>
                </h2>
            </div>
            <div class="md:block md:w-1/3 justify-end items-center flex md:ml-auto pl-4">
                <a href="/pages/teacher/add-course.php" class="text-white bg-purple-700 border px-6 py-2 rounded hover:scale-105 transition-transform duration-300 space-x-2">
                    Create a new Course
                </a>
            </div>
        </div>
    </section>

    <!-- Statistics Cards -->
    <div class="container mx-auto px-4 -mt-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-gray-700 text-lg font-semibold mb-4">Total Courses</h3>
                <p class="text-3xl font-bold text-purple-600"><?php echo $teacherStats['total_courses']; ?></p>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-gray-700 text-lg font-semibold mb-4">Total Students</h3>
                <p class="text-3xl font-bold text-purple-600"><?php echo $teacherStats['total_students']; ?></p>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h3 class="text-gray-700 text-lg font-semibold mb-4">Average Enrollments</h3>
                <p class="text-3xl font-bold text-purple-600"><?php echo $teacherStats['average_enrollments']; ?></p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto mt-10 px-4">
        <div class="lg:flex">
            <!-- Sidebar -->
            <aside class="w-full lg:w-1/4 bg-white p-6 rounded-lg mb-6 lg:mb-0 mr-6 shadow-md">
                <h3 class="text-lg font-bold mb-4">WELCOME <?php echo $user->getNom(); ?></h3>
                <ul class="space-y-2">
                    <li><a href="#" class="flex items-center side_links rounded hover:bg-purple-100"><span>Dashboard</span></a></li>
                    <li><a href="/pages/profile/profile.php" class="flex items-center side_links rounded hover:bg-purple-100"><span>My Profile</span></a></li>
                    <li><a href="#" class="flex items-center side_links rounded hover:bg-purple-100"><span>Messages</span></a></li>
                    <li><a href="#" class="flex items-center side_links rounded hover:bg-purple-100"><span>Reviews</span></a></li>
                    <hr class="my-4 border-gray-200">
                    <li><a href="#" class="flex items-center side_links rounded hover:bg-purple-100"><span>Settings</span></a></li>
                    <li><a href="/pages/auth/logout.php" class="flex items-center side_links rounded hover:bg-purple-100 text-red-500"><span>Logout</span></a></li>
                </ul>
            </aside>

            <!-- Main Content -->
            <main class="w-full lg:w-3/4">
                <!-- Courses List -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold mb-6 text-purple-700">My Courses</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Students</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($teacherStats['courses_details'] as $course): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($course['title']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?php echo $course['enrollment_count']; ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <?php echo ucfirst($course['status']); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo date('Y-m-d', strtotime($course['created_at'])); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="/pages/courses/edit_course.php?id=<?php echo $course['id']; ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="edit_course.php?id=<?php echo $course['id']; ?>" class="text-indigo-600 hover:text-indigo-900">delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Enrollment Chart -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-6 text-purple-700">Enrollment Trends</h2>
                    <canvas id="enrollmentChart"></canvas>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Enrollment chart initialization
        const ctx = document.getElementById('enrollmentChart').getContext('2d');
        const courseData = <?php echo json_encode($teacherStats['courses_details']); ?>;
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: courseData.map(course => course.title),
                datasets: [{
                    label: 'Students Enrolled',
                    data: courseData.map(course => course.enrollment_count),
                    backgroundColor: 'rgba(147, 51, 234, 0.5)',
                    borderColor: 'rgb(147, 51, 234)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>