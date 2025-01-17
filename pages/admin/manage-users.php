<?php
require_once dirname(__DIR__, 2) . '/classes/Auth/Authentification.php';
require_once dirname(__DIR__, 2) . '/classes/User/Admin.php';
require_once dirname(__DIR__, 2) . '/classes/Auth/Session.php';

Session::start();
$db = new Database('localhost', 'youdemy', 'root', 'root');

$user = Authentification::getUser();
$users = [];

if (!$user || $user->getRole() !== 'admin') {
    header('Location: /pages/auth/login.php');
    exit();
}

$admin = new Admin($user->getId());

try {
    // Get users with filters
    $roleFilter = isset($_GET['role']) ? htmlspecialchars($_GET['role']) : '';
    $searchTerm = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
    $statusFilter = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : '';

    $query = "SELECT * FROM users WHERE 1=1";
    $params = [];

    if ($roleFilter) {
        $query .= " AND role = :role";
        $params['role'] = $roleFilter;
    }

    if ($statusFilter) {
        $query .= " AND status = :status";
        $params['status'] = $statusFilter;
    }

    if ($searchTerm) {
        $query .= " AND (full_name LIKE :search OR email LIKE :search)";
        $params['search'] = "%$searchTerm%";
    }

    $result = $db->executeQuery($query, $params);
    $users = is_array($result) ? $result : [];

    if (empty($users)) {
        $_SESSION['info'] = "Aucun utilisateur trouvé avec les critères spécifiés.";
    }

} catch (Exception $e) {
    $_SESSION['error'] = "Une erreur est survenue lors de la récupération des utilisateurs.";
    if (defined('DEBUG') && DEBUG) {
        error_log($e->getMessage());
    }
    $users = []; // Ensure $users is an empty array on error
}

// Handle all user actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['action'])) {
            $userId = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;
            
            switch ($_POST['action']) {
                case 'activate_teacher':
                    $teacher = new Teacher($userId);
                    if ($admin->validateTeacher($teacher)) {
                        $_SESSION['success'] = "Compte professeur activé avec succès";
                    } else {
                        $_SESSION['error'] = "Échec de l'activation du compte professeur";
                    }
                    break;
                    
                case 'update_role':
                    $newRole = isset($_POST['new_role']) ? htmlspecialchars($_POST['new_role']) : '';
                    if ($newRole && in_array($newRole, ['student', 'teacher', 'admin'])) {
                        $query = "UPDATE users SET role = :role WHERE id = :id";
                        if ($db->executeQuery($query, ['role' => $newRole, 'id' => $userId])) {
                            $_SESSION['success'] = "Rôle mis à jour avec succès";
                        } else {
                            $_SESSION['error'] = "Échec de la mise à jour du rôle";
                        }
                    }
                    break;
                    
                case 'delete_user':
                    $query = "DELETE FROM users WHERE id = :id";
                    if ($db->executeQuery($query, ['id' => $userId])) {
                        $_SESSION['success'] = "Utilisateur supprimé avec succès";
                    } else {
                        $_SESSION['error'] = "Échec de la suppression de l'utilisateur";
                    }
                    break;
            }
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Une erreur est survenue lors du traitement de l'action.";
        if (defined('DEBUG') && DEBUG) {
            error_log($e->getMessage());
        }
    }
    
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs | Youdemy</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="/public/assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .luxe-bg {
            background: linear-gradient(to right, #3730a3, #7e22ce);
        }
        .luxe-card {
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.05), 0 6px 6px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body class="font-montserrat bg-gray-100">
    <?php include_once dirname(__DIR__, 1) . '/common/header.php' ?>

    <!-- Notification Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg" id="notification">
            <?= htmlspecialchars($_SESSION['success']) ?>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <!-- Hero Banner -->
    <section class="luxe-bg py-24">
        <div class="container mx-auto px-6">
            <h1 class="text-4xl font-playfair text-white font-bold mb-4 text-center md:text-left">
                Gestion des Utilisateurs
            </h1>
        </div>
    </section>

    <div class="container mx-auto mt-10 px-4 md:px-0">
        <div class="lg:flex">
            <!-- Sidebar -->
            <aside class="w-full lg:w-1/5 bg-white p-6 rounded-lg luxe-card mb-6 lg:mb-0 mr-6">
                <h3 class="text-lg font-bold mb-4">WELCOME <?= htmlspecialchars($user->getNom()) ?></h3>
                <ul class="space-y-2">
                    <li><a href="/pages/admin/index.php" class="flex items-center rounded-md hover:bg-gray-700 hover:text-white transition duration-200 p-2">
                        <i class="fa-solid fa-house"></i><span class="ml-2">Tableau de bord</span>
                    </a></li>
                    <li><a href="/pages/admin/manage-users.php" class="flex items-center rounded-md bg-gray-700 text-white transition duration-200 p-2">
                        <i class="fas fa-users"></i><span class="ml-2">Utilisateurs</span>
                    </a></li>
                    <li><a href="#pending-teachers" class="flex items-center rounded-md hover:bg-gray-700 hover:text-white transition duration-200 p-2">
                        <i class="fas fa-user-clock"></i><span class="ml-2">Demandes en attente</span>
                    </a></li>
                </ul>
            </aside>

            <!-- Main Content -->
            <main class="w-full lg:w-4/5 p-6 bg-white rounded-lg luxe-card">
                <!-- Filters -->
                <div class="mb-6 space-y-4">
                    <h2 class="text-2xl font-bold text-purple-700">Liste des Utilisateurs</h2>
                    <form method="GET" class="flex flex-wrap gap-4">
                        <select name="role" class="rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                            <option value="">Tous les rôles</option>
                            <option value="teacher" <?= $roleFilter === 'teacher' ? 'selected' : '' ?>>Professeurs</option>
                            <option value="student" <?= $roleFilter === 'student' ? 'selected' : '' ?>>Étudiants</option>
                            <option value="admin" <?= $roleFilter === 'admin' ? 'selected' : '' ?>>Administrateurs</option>
                        </select>
                        <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                            <option value="">Tous les statuts</option>
                            <option value="active" <?= $statusFilter === 'active' ? 'selected' : '' ?>>Actif</option>
                            <option value="pending" <?= $statusFilter === 'pending' ? 'selected' : '' ?>>En attente</option>
                        </select>
                        <input type="text" name="search" value="<?= htmlspecialchars($searchTerm) ?>" 
                               placeholder="Rechercher..." 
                               class="rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                        <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700">
                            Filtrer
                        </button>
                    </form>
                </div>

                <!-- Users Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr class="bg-purple-50">
                                <th class="px-6 py-3 border-b-2 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">
                                    Utilisateur
                                </th>
                                <th class="px-6 py-3 border-b-2 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">
                                    Rôle
                                </th>
                                <th class="px-6 py-3 border-b-2 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th class="px-6 py-3 border-b-2 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">
                                    Date d'inscription
                                </th>
                                <th class="px-6 py-3 border-b-2 text-left text-xs font-semibold text-purple-700 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($users && is_array($users)) : ?>
                                <?php foreach ($users as $userData) : ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 border-b border-gray-200">
                                            <div class="flex items-center">
                                                <?php if ($userData['photoUrl']) : ?>
                                                    <img class="h-10 w-10 rounded-full object-cover" 
                                                         src="<?= htmlspecialchars($userData['photoUrl']) ?>" 
                                                         alt="Profile">
                                                <?php else : ?>
                                                    <div class="h-10 w-10 rounded-full bg-purple-200 flex items-center justify-center">
                                                        <span class="text-purple-700 font-bold">
                                                            <?= strtoupper(substr($userData['full_name'], 0, 1)) ?>
                                                        </span>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <?= htmlspecialchars($userData['full_name']) ?>
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        <?= htmlspecialchars($userData['email']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 border-b border-gray-200">
                                            <form method="POST" class="role-form">
                                                <input type="hidden" name="action" value="update_role">
                                                <input type="hidden" name="user_id" value="<?= $userData['id'] ?>">
                                                <select name="new_role" onchange="this.form.submit()" 
                                                        class="rounded text-sm <?= $userData['role'] === 'admin' ? 'bg-purple-100 text-purple-800' : 
                                                                               ($userData['role'] === 'teacher' ? 'bg-blue-100 text-blue-800' : 
                                                                               'bg-green-100 text-green-800') ?>">
                                                    <option value="student" <?= $userData['role'] === 'student' ? 'selected' : '' ?>>Student</option>
                                                    <option value="teacher" <?= $userData['role'] === 'teacher' ? 'selected' : '' ?>>Teacher</option>
                                                    <option value="admin" <?= $userData['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 border-b border-gray-200">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                <?= $userData['status'] === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                                <?= htmlspecialchars($userData['status']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 border-b border-gray-200 text-sm text-gray-500">
                                            <?= htmlspecialchars($userData['created_at']) ?>
                                        </td>
                                        <td class="px-6 py-4 border-b border-gray-200 text-sm">
                                            <div class="flex space-x-2">
                                                <?php if ($userData['role'] === 'teacher' && $userData['status'] === 'pending') : ?>
                                                    <form method="POST" class="inline">
                                                        <input type="hidden" name="action" value="activate_teacher">
                                                        <input type="hidden" name="user_id" value="<?= $userData['id'] ?>">
                                                        <button type="submit" 
                                                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md transition duration-200">
                                                            Approuver
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                
                                                <!-- Delete User -->
                                                <form method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                                    <input type="hidden" name="action" value="delete_user">
                                                    <input type="hidden" name="user_id" value="<?= $userData['id'] ?>">
                                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5" class="px-6 py-4 border-b border-gray-200 text-center text-gray-500">
                        Aucun utilisateur trouvé
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Section des demandes d'inscription en attente -->
     
<!-- Section des demandes d'inscription en attente -->
<div id="pending-teachers" class="mt-8">
    <h3 class="text-xl font-bold text-purple-700 mb-4">Demandes d'inscription des professeurs</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php 
        // Safe array_filter usage with type checking
        $pendingTeachers = is_array($users) ? array_filter($users, function($user) {
            return isset($user['role']) && isset($user['status']) && 
                   $user['role'] === 'teacher' && $user['status'] === 'pending';
        }) : [];
        
        if (!empty($pendingTeachers)) : 
            foreach ($pendingTeachers as $teacher) : ?>
                <!-- ... (rest of the pending teachers display code remains the same) ... -->
            <?php endforeach; ?>
        <?php else : ?>
            <div class="col-span-full text-center py-8 text-gray-500">
                Aucune demande d'inscription en attente
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Add error and info messages display -->
<?php if (isset($_SESSION['error'])): ?>
    <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg" id="error-notification">
        <?= htmlspecialchars($_SESSION['error']) ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['info'])): ?>
    <div class="fixed top-4 right-4 bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg" id="info-notification">
        <?= htmlspecialchars($_SESSION['info']) ?>
        <?php unset($_SESSION['info']); ?>
    </div>
<?php endif; ?>
    <div id="pending-teachers" class="mt-8">
        <h3 class="text-xl font-bold text-purple-700 mb-4">Demandes d'inscription des professeurs</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php 
            $pendingTeachers = array_filter($users, function($user) {
                return $user['role'] === 'teacher' && $user['status'] === 'pending';
            });
            
            if (!empty($pendingTeachers)) : 
                foreach ($pendingTeachers as $teacher) : ?>
                <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
                    <div class="flex items-center space-x-4">
                        <?php if ($teacher['photoUrl']) : ?>
                            <img src="<?= htmlspecialchars($teacher['photoUrl']) ?>" 
                                 alt="Profile" 
                                 class="h-16 w-16 rounded-full object-cover">
                        <?php else : ?>
                            <div class="h-16 w-16 rounded-full bg-purple-200 flex items-center justify-center">
                                <span class="text-purple-700 text-xl font-bold">
                                    <?= strtoupper(substr($teacher['full_name'], 0, 1)) ?>
                                </span>
                            </div>
                        <?php endif; ?>
                        <div>
                            <h4 class="font-semibold text-gray-900">
                                <?= htmlspecialchars($teacher['full_name']) ?>
                            </h4>
                            <p class="text-sm text-gray-500">
                                <?= htmlspecialchars($teacher['email']) ?>
                            </p>
                            <p class="text-xs text-gray-400">
                                Demande envoyée le: <?= htmlspecialchars(date('d/m/Y', strtotime($teacher['created_at']))) ?>
                            </p>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end space-x-2">
                        <form method="POST" class="inline">
                            <input type="hidden" name="action" value="activate_teacher">
                            <input type="hidden" name="user_id" value="<?= $teacher['id'] ?>">
                            <button type="submit" 
                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md transition duration-200">
                                Approuver
                            </button>
                        </form>
                        <form method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir refuser cette demande ?');">
                            <input type="hidden" name="action" value="delete_user">
                            <input type="hidden" name="user_id" value="<?= $teacher['id'] ?>">
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition duration-200">
                                Refuser
                            </button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-span-full text-center py-8 text-gray-500">
                    Aucune demande d'inscription en attente
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>
</div>
</div>

<?php include_once dirname(__DIR__, 1) . '/common/footer.php'; ?>

<script>
// Notification auto-hide
const notification = document.getElementById('notification');
if (notification) {
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.5s ease-out';
        setTimeout(() => notification.remove(), 500);
    }, 3000);
}

// Confirmation pour les actions importantes
document.querySelectorAll('.role-form').forEach(form => {
    form.addEventListener('change', function(e) {
        if (!confirm('Êtes-vous sûr de vouloir modifier le rôle de cet utilisateur ?')) {
            e.preventDefault();
            this.querySelector('select').value = this.querySelector('select').dataset.originalValue;
        }
    });
});

// Search functionality
const searchInput = document.querySelector('input[name="search"]');
searchInput.addEventListener('input', debounce(function(e) {
    const searchTerm = e.target.value;
    if (searchTerm.length >= 2 || searchTerm.length === 0) {
        this.form.submit();
    }
}, 500));

// Debounce helper function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func.apply(this, args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Store original role values
document.querySelectorAll('select[name="new_role"]').forEach(select => {
    select.dataset.originalValue = select.value;
});
</script>

</body>
</html>