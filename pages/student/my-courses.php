<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes cours | YouDemy</title>
     <link rel="stylesheet" href="../../public/assets/css/style.css">
    <link rel="stylesheet" href="../../public/assets/css/responsive.css">
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="font-montserrat bg-gray-50 text-gray-900">
    <div class="flex">
        <?php include '../common/sidebar.html'; ?>
        <main class="flex-1 p-6">
            <h1 class="text-3xl font-playfair font-bold mb-8">Mes Cours</h1>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                  <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="../../public/assets/images/course-1.jpg" alt="Cours 1" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Le leadership inspirant</h3>
                         <p class="text-gray-700 mb-4">Découvrez les secrets d'un leadership qui motive et inspire les équipes. Stratégies avancées, exemples pratiques.</p>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-purple-500">$299</span>
                             <a href="#" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-4 py-2 rounded-md transition-colors duration-300">En savoir plus</a>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="../../public/assets/images/course-2.jpg" alt="Cours 2" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">La communication persuasive</h3>
                         <p class="text-gray-700 mb-4">Maîtrisez l'art de la persuasion. Apprenez à influencer, négocier et convaincre. Techniques et mises en situation réelles.</p>
                         <div class="flex justify-between items-center">
                            <span class="font-bold text-purple-500">$349</span>
                            <a href="#" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-4 py-2 rounded-md transition-colors duration-300">En savoir plus</a>
                        </div>
                    </div>
                </div>
                 <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="../../public/assets/images/course-3.jpg" alt="Cours 3" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">La finance pour les décideurs</h3>
                         <p class="text-gray-700 mb-4">Acquérez une solide compréhension financière. Prenez des décisions éclairées, gérez vos investissements avec assurance.</p>
                        <div class="flex justify-between items-center">
                           <span class="font-bold text-purple-500">$499</span>
                            <a href="#" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-4 py-2 rounded-md transition-colors duration-300">En savoir plus</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
        <script src="../../script.js"></script>
</body>
</html>