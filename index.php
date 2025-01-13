
<?php
require_once './pages/common/header.php' 
?>
    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-100 to-purple-50 py-20 relative overflow-hidden">
        <div class="container mx-auto px-6 text-center md:text-left flex items-center relative z-10">
            <div class="md:w-1/2">
                <h1 class="text-4xl md:text-5xl font-playfair font-bold mb-6">Élevez Votre Potentiel avec Nos Cours d'Excellence</h1>
                <p class="text-lg text-gray-700 mb-8">Découvrez une expérience d'apprentissage unique, conçue pour l'élite de demain. Des instructeurs de renommée mondiale, des contenus exclusifs et une plateforme inégalée.</p>
                <a href="#" class="inline-block bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold py-3 px-6 rounded-md transition-colors duration-300">Explorer nos cours</a>
            </div>
            <div class="md:w-1/2 md:absolute top-0 right-0 z-0 mb-4 hidden md:block">
              <img src="/public/assets/img/e_learning.jpg" alt="Illustration" class="rounded-lg shadow-xl object-cover h-full ">
            </div>
        </div>
        <div class="absolute inset-0 bg-gradient-to-tr from-blue-50 to-purple-50 opacity-20"></div>
    </section>

    <!-- Section Cours -->
    <section id="cours" class="py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-playfair font-bold text-center mb-12">Nos Cours Phares</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
               
              <!-- Carte de cours 1-->
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="assets/images/course-1.jpg" alt="Cours 1" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Le leadership inspirant</h3>
                        <p class="text-gray-700 mb-4">Découvrez les secrets d'un leadership qui motive et inspire les équipes. Stratégies avancées, exemples pratiques.</p>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-purple-500">$299</span>
                            <a href="#" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-4 py-2 rounded-md transition-colors duration-300">En savoir plus</a>
                        </div>
                    </div>
                </div>

                 <!-- Carte de cours 2-->
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="assets/images/course-2.jpg" alt="Cours 2" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">La communication persuasive</h3>
                        <p class="text-gray-700 mb-4">Maîtrisez l'art de la persuasion. Apprenez à influencer, négocier et convaincre. Techniques et mises en situation réelles.</p>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-purple-500">$349</span>
                            <a href="#" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-4 py-2 rounded-md transition-colors duration-300">En savoir plus</a>
                        </div>
                    </div>
                </div>

                 <!-- Carte de cours 3-->
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <img src="assets/images/course-3.jpg" alt="Cours 3" class="w-full h-48 object-cover">
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
        </div>
    </section>

    <!-- Section Instructeurs -->
    <section id="instructeurs" class="bg-gray-100 py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-playfair font-bold text-center mb-12">Nos Instructeurs d'Exception</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
              <!-- Carte instructeur 1-->
              <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                <img src="assets/images/instructor-1.jpg" alt="Instructeur 1" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                <h3 class="text-xl font-semibold mb-2">Dr. Élise Dubois</h3>
                <p class="text-gray-700 mb-4">Experte en leadership avec plus de 20 ans d'expérience.</p>
                <a href="#" class="text-purple-500 hover:text-purple-700 font-medium">En savoir plus</a>
              </div>

                 <!-- Carte instructeur 2-->
              <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                <img src="assets/images/instructor-2.jpg" alt="Instructeur 2" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                <h3 class="text-xl font-semibold mb-2">M. Jean Leclerc</h3>
                <p class="text-gray-700 mb-4">Spécialiste en communication et en négociation.</p>
                <a href="#" class="text-purple-500 hover:text-purple-700 font-medium">En savoir plus</a>
             </div>

                 <!-- Carte instructeur 3-->
              <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                <img src="assets/images/instructor-3.jpg" alt="Instructeur 3" class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                <h3 class="text-xl font-semibold mb-2">Mme. Sofia Martin</h3>
                <p class="text-gray-700 mb-4">Consultante en finance et en stratégie d'entreprise.</p>
                <a href="#" class="text-purple-500 hover:text-purple-700 font-medium">En savoir plus</a>
             </div>
            </div>
        </div>
    </section>

     <!-- Section Témoignages -->
    <section id="temoignages" class="py-16">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-playfair font-bold text-center mb-12">Ce que Nos Étudiants Disent</h2>
              <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Témoignage 1 -->
                  <div class="bg-white shadow-lg rounded-lg p-6">
                      <p class="text-gray-700 italic mb-4">"Les cours de l'Académie ont complètement transformé ma façon de voir le leadership. Les instructeurs sont incroyables et le contenu est pertinent."</p>
                      <div class="flex items-center">
                          <img src="assets/images/student-1.jpg" alt="Étudiant 1" class="w-10 h-10 rounded-full mr-3 object-cover">
                          <div class="">
                                <span class="font-medium">Marie Dupont</span>
                                <br>
                                 <span class="text-gray-500 text-sm">Étudiante en Management</span>
                          </div>
                      </div>
                  </div>

                  <!-- Témoignage 2 -->
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <p class="text-gray-700 italic mb-4">"J'ai adoré le cours sur la communication. Je me sens beaucoup plus confiant pour mes présentations et mes négociations."</p>
                        <div class="flex items-center">
                              <img src="assets/images/student-2.jpg" alt="Étudiant 2" class="w-10 h-10 rounded-full mr-3 object-cover">
                            <div class="">
                                  <span class="font-medium">Luc Martin</span>
                                <br>
                                 <span class="text-gray-500 text-sm">Chef de Projet</span>
                             </div>
                        </div>
                    </div>
              </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8">
        <div class="container mx-auto px-6 text-center">
            <p>© 2024 Académie de Prestige. Tous droits réservés.</p>
        </div>
    </footer>

    <script src="/public/assets/script.js"></script>
</body>
</html>