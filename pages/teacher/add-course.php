<?php
require_once dirname(__DIR__, 2). '/classes/Course/Course.php';
require_once dirname(__DIR__, 2) . '/classes/Utils/FileUploader.php';
require_once dirname(__DIR__, 2). '/classes/User/Teacher.php';
require_once dirname(__DIR__, 2) . '/classes/Course/Category.php';
require_once dirname(__DIR__, 2) . '/classes/Course/tag.php';
require_once dirname(__DIR__, 2) . '/classes/Auth/Authentification.php';
require_once dirname(__DIR__, 2) . '/classes/Auth/Session.php';
require_once dirname(__DIR__, 2) . '/classes/Security/CSRF.php';
require_once dirname(__DIR__, 2) . '/classes/Security/InputValidator.php';
require_once dirname(__DIR__, 2) . '/classes/Database/Database.php';


session_start();

// --Vérification de l'authentification et du rôle
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'teacher') {
    header('Location: http://localhost:3000/pages/auth/login.php');
    exit();
}

$teacher = new Teacher($_SESSION['user_id']);

$error_message = '';

$success_message = '';

$categories = Category::getAllCategories();

$tags = Tag::getAllTags();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
        $error_message = 'Invalid security token';
    } 
    
    else {
        $courseData = [
            'title' => InputValidator::sanitizeString($_POST['title'] ?? ''),
            'description' => InputValidator::sanitizeString($_POST['description'] ?? ''),
            'content' => InputValidator::sanitizeString($_POST['content'] ?? ''),
            'category_id' => (int)($_POST['category_id'] ?? 0),
            'content_type' => InputValidator::sanitizeString($_POST['content_type'] ?? ''),
            'content_url' => ''
        ];


        $fileUploader = new FileUploader('uploads/courses/');
        
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
            $thumbnailUrl = $fileUploader->uploadFile($_FILES['thumbnail']);
            if ($thumbnailUrl) {
                $courseData['thumbnailUrl'] = $thumbnailUrl;
            } else {
                $error_message = 'Error uploading thumbnail';
            }
        }

        if (isset($_FILES['course_content']) && $_FILES['course_content']['error'] === UPLOAD_ERR_OK) {
            $contentUrl = $fileUploader->uploadFile($_FILES['course_content']);
            if ($contentUrl) {
                $courseData['content_url'] = $contentUrl;
            } else {
                $error_message = 'Error uploading course content';
            }
        }


        if (!empty($_POST['tags'])) {
        
            $tagNames = array_map('trim', explode(',', $_POST['tags']));
            $courseData['tags'] = [];
            foreach ($tagNames as $tagName) {
                $tag = Tag::getTagByName($tagName) ?? new Tag(null, $tagName);
                if ($tag->save()) {
                    $courseData['tags'][] = $tag->getId();
                }
            }
        }

        if (empty($error_message)) {
            if ($teacher->createCourse($courseData)) {
                var_dump($teacher->createCourse($courseData));
                $success_message = 'Course created successfully!';
                header('Location: dashboard.php');
                exit();
            } else {
                $error_message = 'Failed to create course';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Course</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Add New Course</h1>

            <?php if ($error_message): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?= htmlspecialchars($success_message) ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?= CSRF::generateToken() ?>">

                <!-- Thumbnail Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Course Thumbnail</label>
                    <input type="file" name="thumbnail" accept="image/*" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    <p class="mt-1 text-sm text-gray-500">Accepted formats: JPG, PNG, GIF</p>
                </div>

                <!-- Course Content Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Course Content</label>
                    <input type="file" name="course_content" accept="video/mp4,application/pdf" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    <p class="mt-1 text-sm text-gray-500">Accepted formats: MP4, PDF</p>
                </div>

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" name="title" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4" required 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>

                <!-- Content -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                    <textarea name="content" rows="6" required 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="category_id" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
                        <option value="0">Select a category</option>
                        <option value="1"> Développement Web </option>
                        <option value="2"> Intelligence Artificielle</option>
                        <option value="3"> Sécurité Informatique  </option>
                        <option value="4">  Bases de Données </option>
                        <option value="5"> Cloud Computing </option>





                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->getId() ?>">
                                <?= htmlspecialchars($category->getName()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Content Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Content Type</label>
                    <select name="content_type" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
                        <option value="video">Video</option>
                        <option value="document">PDF Document</option>
                    </select>
                </div>

                <!-- Tags -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                    <input type="text" name="tags" placeholder="php, javascript, web development" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500">
                    <p class="mt-1 text-sm text-gray-500">Separate tags with commas</p>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="dashboard.php" 
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                        Create Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>