<?php
require_once dirname(__DIR__, 2) . '/classes/Auth/Authentification.php';
require_once dirname(__DIR__, 2) . '/classes/User/Teacher.php';
require_once dirname(__DIR__, 2) . '/classes/Database/Database.php';
require_once dirname(__DIR__, 2) . '/classes/Auth/Session.php';
require_once dirname(__DIR__, 2) . '/classes/Course/Category.php';
require_once dirname(__DIR__, 2) . '/classes/Course/Tag.php';
require_once dirname(__DIR__, 2) . '/classes/Security/CSRF.php';


Session::start();

$user = Authentification::getUser(); 

if (!$user || $user->getRole() !== 'teacher') {
    header('Location: /pages/auth/login.php');
    exit();
}

$teacher = new Teacher($user->getId()); 


$db = new Database('localhost', 'youdemy', 'root', 'root');

$courseId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$course = Course::getCourseById($db, $courseId);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $token = $_POST['csrf_token'] ?? '';

    if (!CSRF::validateToken($token)) {
        die('Invalid CSRF token');
    }

    $data = [
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'content' => $_POST['content'] ?? '',
        'category_id' => (int)($_POST['category_id'] ?? 0),
        'content_type' => $_POST['content_type'] ?? '',
        'content_url' => $_POST['content_url'] ?? '',
        'tags' => $_POST['tags'] ?? [],
    ];

    if ($teacher->updateCourse($courseId, $data)) {
        
        header('Location: /pages/teacher/dashboard.php?success=Course updated successfully');
        exit();
    }
}

$categories = Category::getAllCategories($db);
$tags = Tag::getAllTags($db);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course - <?php echo htmlspecialchars($course->getTitle()); ?></title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <?php include_once dirname(__DIR__, 1) . '/common/header.php' ?>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6 text-purple-700">Edit Course</h1>

            <form method="POST" class="space-y-6">
                <input type="hidden" name="csrf_token" value="<?php echo CSRF::generateToken(); ?>">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($course->getTitle()); ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-500" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-500" required><?php echo htmlspecialchars($course->getDescription()); ?></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                    <textarea name="content" rows="8" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-500" required><?php echo htmlspecialchars($course->getContent()); ?></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-500">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category->getId(); ?>" 
                                <?php echo $category->getId() === $course->getCategoryId() ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($category->getName()); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Content Type</label>
                    <select name="content_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-500">
                        <option value="video" <?php echo $course->getContentType() === 'video' ? 'selected' : ''; ?>>Video</option>
                        <option value="text" <?php echo $course->getContentType() === 'text' ? 'selected' : ''; ?>>Text</option>
                        <option value="pdf" <?php echo $course->getContentType() === 'pdf' ? 'selected' : ''; ?>>PDF</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Content URL</label>
                    <input type="url" name="content_url" value="<?php echo htmlspecialchars($course->getContentUrl()); ?>" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                    <select name="tags[]" multiple class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-500">
                        <?php 
                        $courseTags = array_map(function($tag) { return $tag->getId(); }, $course->getTags());
                        foreach ($tags as $tag): 
                        ?>
                            <option value="<?php echo $tag->getId(); ?>" 
                                <?php echo in_array($tag->getId(), $courseTags) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($tag->getName()); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="/pages/teacher/dashboard.php" 
                       class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                        Update Course
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 