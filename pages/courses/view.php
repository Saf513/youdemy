<?php
require_once dirname(__DIR__, 2) . '/classes/Auth/Authentification.php';
require_once dirname(__DIR__, 2) . '/classes/Course/Course.php';
require_once dirname(__DIR__, 2) . '/classes/User/Student.php';
require_once dirname(__DIR__, 2) . '/classes/Database/Database.php';
require_once dirname(__DIR__, 2) . '/classes/Auth/Session.php';

Session::start();

$user = Authentification::getUser();
if (!$user || ($user->getRole() !== 'student' && $user->getRole() !== 'teacher')) {
    header('Location: /pages/auth/login.php');
    exit();
}
$db = new Database('localhost', 'youdemy', 'root', 'root');

$fullId = $_GET['id'] ?? null;

// Séparer le premier ID s'il y a plusieurs "id" dans la chaîne.
if ($fullId) {
    $parts = explode('?', $fullId); // Diviser la chaîne à partir du premier '?'.
    $courseId = $parts[0]; // Obtenir uniquement le premier segment (avant '?').
}

// Validez que l'ID est un entier positif.
if (!$courseId || !ctype_digit($courseId)) {
    header('Location: /pages/student/dashboard.php');
    exit();
}

$courseId = (int)$courseId; // Convertir en entier.
$course = Course::getCourseById($db, $courseId);

if (!$course) {
    header('Location: /pages/student/dashboard.php');
    exit();
}

var_dump($courseId);
if (!$courseId) {
    header('Location: /pages/student/dashboard.php');
    exit();
}

$db = new Database('localhost', 'youdemy', 'root', 'root');
$course = Course::getCourseById($db, $courseId);

$isEnrolled = false;
if ($user->getRole() === 'student') {
    $student = new Student($user->getId());
    $enrolledCourses = $student->getEnrolledCourses();
    $isEnrolled = !empty(array_filter($enrolledCourses, function ($c) use ($course) {
        return $c->getId() === $course->getId();
    }));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course->getTitle()); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .luxury-gradient {
            background: linear-gradient(135deg, #4338ca 0%, #6366f1 100%);
        }
        .card-shadow {
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .module-shadow {
            box-shadow: 0 8px 16px rgba(99,102,241,0.1);
        }
        .content-wrapper {
            background-image: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.9)), 
                            url('<?php echo $course->getContentUrl() ? UPLOAD_URL . htmlspecialchars($course->getContentUrl()) : "/public/assets/img/default-avatar.png"; ?>');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <?php include_once dirname(__DIR__, 1) . '/common/header.php'; ?>

    <!-- Hero Section -->
    <section class="relative luxury-gradient py-24 overflow-hidden">
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-4xl">
                <h1 class="text-5xl font-bold text-white mb-6">
                    <?php echo htmlspecialchars($course->getTitle()); ?>
                </h1>
                <p class="text-xl text-indigo-100 mb-8 leading-relaxed">
                    <?php echo htmlspecialchars($course->getDescription()); ?>
                </p>
                <?php if(!$isEnrolled): ?>
                    <a href="/pages/course/enroll.php?id=<?php echo $course->getId(); ?>" 
                       class="inline-block bg-white text-indigo-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-indigo-50 transition duration-200">
                        Enroll Now
                    </a>
                <?php else: ?>
                    <a href="/pages/courses/enroll.php/?id=<?php echo $course->getId(); ?>" 
                       class="inline-block bg-white text-indigo-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-indigo-50 transition duration-200">
                        Continue Learning
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <div class="absolute inset-0 opacity-10">
            <img src="<?php echo $course->getThumbnailUrl() ? UPLOAD_URL . htmlspecialchars($course->getThumbnailUrl()) : '/public/assets/img/default-avatar.png'; ?>"
                 class="w-full h-full object-cover" alt="Course background">
        </div>
    </section>

    <!-- Course Content -->
    <section class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl card-shadow p-8 mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">Course Content</h2>
                        <div class="space-y-6">
                            <!-- Module -->
                            <div class="border rounded-xl module-shadow">
                                <div class="p-4 bg-gradient-to-r from-indigo-50 to-white flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900">Module 1: Introduction</h3>
                                    <span class="text-indigo-600 font-medium">3 Lessons</span>
                                </div>
                                <ul class="divide-y">
                                    <li class="p-4 hover:bg-gray-50 flex items-center space-x-3">
                                        <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.156.996l3.197-2.132a1 1 0 000-1.664z"/>
                                        </svg>
                                        <span class="text-gray-700">Welcome to the Course</span>
                                    </li>
                                    <li class="p-4 hover:bg-gray-50 flex items-center space-x-3">
                                        <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span class="text-gray-700">Course Overview</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl card-shadow overflow-hidden sticky top-8">
                        <img src="<?php echo $course->getThumbnailUrl() ? UPLOAD_URL . htmlspecialchars($course->getThumbnailUrl()) : '/public/assets/img/default-avatar.png'; ?>"
                             class="w-full h-48 object-cover" alt="Course thumbnail">
                        <div class="p-6">
                            <div class="flex items-center space-x-4 mb-6">
                                <img src="/public/assets/img/default-avatar.png" 
                                     class="w-12 h-12 rounded-full" alt="Instructor">
                                <div>
                                    <h4 class="font-medium text-gray-900">Course Instructor</h4>
                                    <p class="text-gray-<p class="text-gray-600">Professor</p>
                                </div>
                            </div>

                            <div class="space-y-4 mb-6">
                                <div class="flex items-center space-x-3">
                                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-gray-700">6 weeks duration</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-gray-700">Certificate on completion</span>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                                    </svg>
                                    <span class="text-gray-700">Lifetime access</span>
                                </div>
                            </div>

                            <?php if(!$isEnrolled): ?>
                                <a href="/pages/course/enroll.php?id=<?php echo $course->getId(); ?>" 
                                   class="block w-full text-center luxury-gradient text-white py-3 px-6 rounded-lg font-semibold hover:opacity-90 transition duration-200">
                                    Enroll Now
                                </a>
                            <?php else: ?>
                                <a href="/pages/student/my-courses.php?id=<?php echo $course->getId(); ?>" 
                                   class="block w-full text-center luxury-gradient text-white py-3 px-6 rounded-lg font-semibold hover:opacity-90 transition duration-200">
                                    Continue Learning
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Features -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">What You'll Learn</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white rounded-xl p-6 card-shadow">
                    <div class="w-12 h-12 luxury-gradient rounded-lg flex items-center justify-center mb-4">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Expert Knowledge</h3>
                    <p class="text-gray-600">Access comprehensive course materials designed by industry experts.</p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white rounded-xl p-6 card-shadow">
                    <div class="w-12 h-12 luxury-gradient rounded-lg flex items-center justify-center mb-4">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Interactive Learning</h3>
                    <p class="text-gray-600">Engage with hands-on exercises and real-world projects.</p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white rounded-xl p-6 card-shadow">
                    <div class="w-12 h-12 luxury-gradient rounded-lg flex items-center justify-center mb-4">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Learn at Your Pace</h3>
                    <p class="text-gray-600">Access course content anytime, anywhere with lifetime access.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Course Requirements -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Course Requirements</h2>
                <ul class="space-y-4">
                    <li class="flex items-start space-x-3">
                        <svg class="h-6 w-6 text-indigo-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-gray-700">Basic understanding of the subject matter</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <svg class="h-6 w-6 text-indigo-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-gray-700">Access to required software and tools</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <svg class="h-6 w-6 text-indigo-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-gray-700">Dedication to complete all course modules</span>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <?php include_once dirname(__DIR__, 1) . '/common/footer.php'; ?>

    <script>
        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add intersection observer for fade-in animations
        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('opacity-100');
                        entry.target.classList.remove('opacity-0');
                    }
                });
            },
            { threshold: 0.1 }
        );

        document.querySelectorAll('section').forEach((section) => {
            section.classList.add('opacity-0', 'transition-opacity', 'duration-1000');
            observer.observe(section);
        });
    </script>
</body>
</html>