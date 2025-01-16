<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord enseignant | Youdemy</title>
    <link href="/public/assets/css/style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom style to override Tailwind default rounded corners if needed */
        .rounded-lg-custom {
            border-radius: 1rem; /* Example: Larger rounded corners */
        }
    </style>
</head>
<body class="font-montserrat bg-gray-100">

    <!-- Include header -->
    <?php include_once dirname(__DIR__,1). '/common/header.php' ?>

    <div class="container mx-auto px-6 py-12">
        <h1 class="text-3xl font-playfair font-bold text-center mb-12 text-purple-700">Tableau de bord</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Section -->
            <div class="bg-white rounded-lg-custom shadow-lg p-8 lg:col-span-1">
                <h2 class="text-2xl font-semibold mb-4 text-purple-700">Mon Profil</h2>

                <!-- Profile update success/error messages (PHP will handle these) -->
                <div id="profile-update-success" class="hidden mb-4 p-3 bg-green-100 text-green-700 rounded-md"></div>
                <div id="profile-update-error" class="hidden mb-4 p-3 bg-red-100 text-red-700 rounded-md"></div>

                <form id="profile-form" method="post" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="full_name" class="block text-gray-700 font-medium mb-2">Nom complet</label>
                        <input type="text" id="full_name" name="full_name" class="border border-gray-400 p-2 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                        <input type="email" id="email" name="email" class="border border-gray-400 p-2 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" required>
                    </div>
                    <div class="mb-4">
                        <label for="bio" class="block text-gray-700 font-medium mb-2">Bio</label>
                        <textarea id="bio" name="bio" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Write a few sentences about yourself ..."></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="speciality" class="block text-gray-700 font-medium mb-2">Speciality</label>
                        <input type="text" id="speciality" name="speciality" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="e.g. Web Development, Data Science, etc.">
                    </div>
                    <div class="mb-4">
                        <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                        <input type="file" id="photo" name="photo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                    </div>

                    <button type="submit"  class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                        Mettre à jour le profil
                    </button>
                </form>
            </div>

            <!-- Course Management and Statistics -->
            <div class="bg-white rounded-lg-custom shadow-lg p-8 lg:col-span-2 overflow-x-auto">


                <!-- Course Creation Form -->
                <h2 class="text-2xl font-semibold mb-4 text-purple-700">Créer un cours</h2>
                <div id="course-creation-error" class="hidden mb-4 p-3 bg-red-100 text-red-700 rounded-md"></div> <form id="create-course-form" method="POST">

                    </form>

                <!-- Existing Courses -->
                <h2 class="text-2xl font-semibold mt-8 mb-4 text-purple-700">Mes Cours</h2>
                <div id="existing-courses-list">
                    <ul >
                       <li class="hidden border-b border-gray-200 py-2 template-course">
                </ul>


                </div>

            </div>
        </div>
    </div>


    <?php include_once dirname(__DIR__,1). '/common/footer.php' ?>
    <script src="/public/assets/js/teacher_dashboard.js"></script>

</body>
</html>