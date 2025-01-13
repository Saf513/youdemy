<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du cours | YouDemy</title>
     <link rel="stylesheet" href="../../public/assets/css/style.css">
    <link rel="stylesheet" href="../../public/assets/css/responsive.css">
      <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="font-montserrat bg-gray-50 text-gray-900">
<?php include '../common/header.html'; ?>
    <!-- Course Details -->
    <section class="py-16">
        <div class="container mx-auto px-6">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col md:flex-row">
                <div class="md:w-1/2">
                    <img id="course-image" src="../../public/assets/images/course-1.jpg" alt="Image du cours" class="w-full h-full object-cover">
                </div>
                <div class="md:w-1/2 p-8">
                    <h1 id="course-title" class="text-3xl font-playfair font-bold mb-4">Titre du cours</h1>
                    <p id="course-description" class="text-gray-700 mb-6">Description du cours. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <div class="mb-4">
                        <strong class="block text-gray-700 mb-2">Instructeur :</strong>
                        <p id="course-instructor" class="text-gray-700">Nom de l'instructeur</p>
                    </div>
                    <div class="mb-4">
                        <strong class="block text-gray-700 mb-2">Prix :</strong>
                        <p class="text-purple-500 font-bold text-xl" >$<span id="course-price">Prix du cours</span></p>
                    </div>
                   <a href="#" class="inline-block bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold py-3 px-6 rounded-md transition-colors duration-300">S'inscrire au cours</a>
                </div>
            </div>
        </div>
    </section>
 <?php include '../common/footer.html'; ?>
</body>
</html>