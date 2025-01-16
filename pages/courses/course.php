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

$db = new Database('localhost', 'youdemy', 'root', 'root');

define('UPLOAD_PATH', dirname(__DIR__, 2) . '/pages/teacher/uploads/courses/');
define('UPLOAD_URL', '/pages/teacher/uploads/courses/');

$coursesPerPage = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $coursesPerPage;

$categoryId = isset($_GET['category']) ? (int)$_GET['category'] : null;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$query = "SELECT SQL_CALC_FOUND_ROWS c.* FROM courses c";
$params = [];
$conditions = [];

if ($categoryId) {
    $conditions[] = "c.category_id = :category_id";
    $params[':category_id'] = $categoryId;
}

if ($search) {
    $conditions[] = "(c.title LIKE :search OR c.description LIKE :search)";
    $params[':search'] = "%$search%";
}

if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

$query .= " LIMIT :offset, :limit";

$params[':offset'] = (int)$offset;
$params[':limit'] = (int)$coursesPerPage;

try {
    $stmt = $db->getConnection()->prepare($query);
    
    foreach($params as $key => &$value) {
        if ($key === ':offset' || $key === ':limit') {
            $stmt->bindValue($key, $value, PDO::PARAM_INT);
        } else {
            $stmt->bindValue($key, $value);
        }
    }
    
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalStmt = $db->getConnection()->query("SELECT FOUND_ROWS() as total");
    $totalResults = $totalStmt->fetch(PDO::FETCH_ASSOC);
    $totalCourses = $totalResults['total'];
    $totalPages = ceil($totalCourses / $coursesPerPage);
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $courses = [];
    $totalPages = 0;
}

$categories = Category::getAllCategories();

include './../common/header.php';
?>

<!-- Ajout de Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="container mx-auto px-4 py-8">
    <form action="" method="GET" class="mb-8">
        <div class="flex flex-wrap gap-4">
            <div class="flex-1 relative">
                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
                       placeholder="Rechercher un cours..."
                       class="w-full p-2 border rounded pl-10"> <!-- Ajout de pl-10 pour l'espace de l'icône -->
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 cursor-pointer" onclick="submitSearchForm()">
                    <i class="fas fa-search text-gray-400"></i> <!-- Icône de recherche Font Awesome -->
                </span>
            </div>
            <div class="w-48">
                <select name="category" class="w-full p-2 border rounded">
                    <option value="">Toutes les catégories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->getId() ?>" 
                                <?= $categoryId === $category->getId() ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category->getName()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Filtrer
            </button>
        </div>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($courses as $courseData): 
            $course = new Course();
            $course->loadData($courseData, $db);
        ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="aspect-w-16 aspect-h-9">
                    <?php
                    $imageUrl = $course->getThumbnailUrl() 
                        ? UPLOAD_URL . htmlspecialchars($course->getThumbnailUrl())
                        : '/public/assets/img/data_analitic.jpg';
                    ?>
                    <img src="<?= $imageUrl ?>" 
                         alt="<?= htmlspecialchars($course->getTitle()) ?>"
                         class="w-full h-48 object-cover"
                         onerror="this.src='/public/assets/img/default-avatar.png'">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2">
                        <?= htmlspecialchars($course->getTitle()) ?>
                    </h3>
                    <p class="text-gray-600 mb-4">
                        <?= htmlspecialchars(substr($course->getDescription(), 0, 150)) ?>...
                    </p>
                    <div class="flex justify-between items-center">
                        <a href="view.php?id=<?= $course->getId() ?>" 
                           class="text-blue-600 hover:underline">
                            En savoir plus
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center space-x-2 mb-4">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>&category=<?= $categoryId ?>&search=<?= htmlspecialchars($search) ?>" 
               class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100">
                Précédent
            </a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>&category=<?= $categoryId ?>&search=<?= htmlspecialchars($search) ?>" 
               class="px-4 py-2 border <?= $i === $page ? 'bg-blue-600 text-white' : 'border-gray-300 hover:bg-gray-100' ?> rounded">
                <?= $i ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>&category=<?= $categoryId ?>&search=<?= htmlspecialchars($search) ?>" 
               class="px-4 py-2 border border-gray-300 rounded hover:bg-gray-100">
                Suivant
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- JavaScript pour soumettre le formulaire -->
<script>
    function submitSearchForm() {
        document.querySelector('form').submit(); // Soumet le formulaire de recherche
    }
</script>

<?php include '../../pages/common/footer.php'; ?>