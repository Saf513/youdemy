<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tous les cours | YouDemy</title>
     <link rel="stylesheet" href="../../public/assets/css/style.css">
    <link rel="stylesheet" href="../../public/assets/css/responsive.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="font-montserrat bg-gray-50 text-gray-900">
<?php include '../common/header.html'; ?>
     <!-- Filtres et Barre de Recherche -->
    <div class="bg-gray-100 py-6">
        <div class="container mx-auto px-6 flex flex-col md:flex-row items-center justify-between">
            <div class="mb-4 md:mb-0">
                <ul id="categories" class="flex space-x-4">
                    <li class="cursor-pointer hover:text-purple-500 transition-colors duration-300" data-category="all">Tous</li>
                    <li class="cursor-pointer hover:text-purple-500 transition-colors duration-300" data-category="leadership">Leadership</li>
                    <li class="cursor-pointer hover:text-purple-500 transition-colors duration-300" data-category="communication">Communication</li>
                    <li class="cursor-pointer hover:text-purple-500 transition-colors duration-300" data-category="finance">Finance</li>
                   
                </ul>
            </div>
            <div class="relative">
                <input type="text" id="search-input" placeholder="Rechercher un cours..." class="border border-gray-300 rounded-md px-4 py-2 focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50 w-full md:w-64">
                <img src="../../public/assets/icons/search.svg" alt="Rechercher" class="absolute right-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400 pointer-events-none">
            </div>
        </div>
    </div>


    <!-- Grille des Cours -->
     <section id="courses-list" class="py-16">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8" id="course-cards">
                 <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="../../public/assets/images/course-1.jpg" alt="Cours 1" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Le leadership inspirant</h3>
                         <p class="text-gray-700 mb-4">Découvrez les secrets d'un leadership qui motive et inspire les équipes. Stratégies avancées, exemples pratiques.</p>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-purple-500">$299</span>
                             <a href="view.html" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-4 py-2 rounded-md transition-colors duration-300">En savoir plus</a>
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
                            <a href="view.html" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-4 py-2 rounded-md transition-colors duration-300">En savoir plus</a>
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
                            <a href="view.html" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-4 py-2 rounded-md transition-colors duration-300">En savoir plus</a>
                        </div>
                    </div>
                </div>
            </div>

          <!-- Pagination -->
          <div class="mt-8 flex justify-center">
                <button id="prev-page" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-md mx-1 hidden">Précédent</button>
               <div id="page-numbers" class="flex">
                   <button class="px-4 py-2 rounded-md mx-1 hover:bg-gray-300 transition-colors duration-300 bg-purple-200">1</button>
                   <button class="px-4 py-2 rounded-md mx-1 hover:bg-gray-300 transition-colors duration-300 ">2</button>
               </div>
                <button id="next-page" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-md mx-1 ">Suivant</button>
           </div>
        </div>
    </section>
<?php include '../common/footer.html'; ?>
 <script src="../../script.js"></script>
</body>
</html>