<?php
require_once dirname(__DIR__, 2) . '/classes/Auth/Authentification.php';
require_once dirname(__DIR__, 2) . '/classes/Course/Course.php';
require_once dirname(__DIR__, 2) . '/classes/User/Student.php';
require_once dirname(__DIR__, 2) . '/classes/Database/Database.php';
require_once dirname(__DIR__, 2) . '/classes/Auth/Session.php';

Session::start();

$user = Authentification::getUser();

$courseId = $_GET['id'] ?? null;

if (!$courseId) {
    header('Location: /pages/student/dashboard.php');
    exit();
}

$db = new Database('localhost', 'youdemy', 'root', 'root');
$course = Course::getCourseById($db, $courseId);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_enrollment'])) {
    if (!$course) {
        $errorMessage = "Course not found.";
    } elseif (!isset($_POST['terms'])) {
        $errorMessage = "You must agree to the terms and conditions.";
    } else {
        try {
            $student = new Student($user->getId());
            $enrollResult = $student->enrollCourse($course);
            
            if ($enrollResult) {
                header("Location: /pages/courses/view.php?id=" . $course->getId() . "&enrolled=success");
                exit();
            } else {
                $errorMessage = "Enrollment failed. You might already be enrolled in this course.";
            }
        } catch (Exception $e) {
            error_log("Enrollment error: " . $e->getMessage());
            $errorMessage = "An error occurred during enrollment. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll in <?php echo htmlspecialchars($course->getTitle()); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .luxury-gradient {
            background: linear-gradient(135deg, #4338ca 0%, #6366f1 100%);
        }
        .card-shadow {
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php include_once dirname(__DIR__, 1) . '/common/header.php'; ?>

    <main class="min-h-screen py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl card-shadow p-8">
                <div class="mb-10">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Enroll in Course</h1>
                    <p class="text-gray-600">
                        Complete your enrollment for <?php echo htmlspecialchars($course->getTitle()); ?>
                    </p>
                </div>

                <?php if (isset($errorMessage)) : ?>
                    <div class="bg-red-500 text-white p-4 rounded-lg mb-6">
                        <?php echo htmlspecialchars($errorMessage); ?>
                    </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-6">
                        <div class="bg-gray-50 p-6 rounded-xl">
                            <h3 class="font-semibold text-gray-900 mb-4">Course Details</h3>
                            <div class="space-y-3">
                                <p class="text-sm text-gray-600"><span class="font-medium">Duration:</span> 6 weeks</p>
                                <p class="text-sm text-gray-600"><span class="font-medium">Level:</span> All levels</p>
                                <p class="text-sm text-gray-600"><span class="font-medium">Certificate:</span> Yes</p>
                            </div>
                        </div>

                        <form method="POST" class="space-y-6">
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" id="terms" name="terms" required class="h-4 w-4 text-indigo-600 rounded">
                                <label for="terms" class="text-sm text-gray-600">I agree to the course terms and conditions</label>
                            </div>
                            
                            <button type="submit" name="confirm_enrollment"
                                class="w-full luxury-gradient text-white py-3 px-6 rounded-lg font-semibold hover:opacity-90 transition duration-200">
                                Confirm Enrollment
                            </button>
                        </form>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-xl">
                        <h3 class="font-semibold text-gray-900 mb-4">What you'll get</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start space-x-3">
                                <svg class="h-5 w-5 text-indigo-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600">Full lifetime access to course materials</span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <svg class="h-5 w-5 text-indigo-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600">Certificate of completion</span>
                            </li>
                            <li class="flex items-start space-x-3">
                                <svg class="h-5 w-5 text-indigo-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="text-gray-600">Direct access to instructor</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include_once dirname(__DIR__, 1) . '/common/footer.php'; ?>
</body>
</html>
