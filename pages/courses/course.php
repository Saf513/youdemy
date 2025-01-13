<?php 
require_once '../../pages/common/header.php';

?>

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
                <img src="assets/icons/search.svg" alt="Rechercher" class="absolute right-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400 pointer-events-none">
            </div>
        </div>
    </div>


    <!-- Grille des Cours -->
     <section id="courses-list" class="py-16">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8" id="course-cards">
                <!-- Les cartes de cours seront insérées ici -->
            </div>

          <!-- Pagination -->
          <div class="mt-8 flex justify-center">
                <button id="prev-page" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-md mx-1 hidden">Précédent</button>
               <div id="page-numbers" class="flex"></div>
                <button id="next-page" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded-md mx-1 hidden">Suivant</button>
           </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-8">
        <div class="container mx-auto px-6 text-center">
            <p>© 2024 Académie de Prestige. Tous droits réservés.</p>
        </div>
    </footer>
    <script src="script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const coursesPerPage = 6; // Nombre de cours par page
             let currentPage = 1;
             let courses = [ // Simulez une liste de cours
                     { id: 1, title: 'Le leadership inspirant', category: 'leadership', price: 299, imageUrl: 'assets/images/course-1.jpg', description: "Découvrez les secrets d'un leadership qui motive et inspire les équipes. Stratégies avancées, exemples pratiques." },
                     { id: 2, title: 'La communication persuasive', category: 'communication', price: 349, imageUrl: 'assets/images/course-2.jpg', description: "Maîtrisez l'art de la persuasion. Apprenez à influencer, négocier et convaincre. Techniques et mises en situation réelles." },
                     { id: 3, title: 'La finance pour les décideurs', category: 'finance', price: 499, imageUrl: 'assets/images/course-3.jpg', description: "Acquérez une solide compréhension financière. Prenez des décisions éclairées, gérez vos investissements avec assurance." },
                     { id: 4, title: 'L\'art du storytelling', category: 'communication', price: 249, imageUrl: 'assets/images/course-4.jpg',description:"Découvrez l'art de captiver votre public grâce au storytelling. Une méthode puissante pour communiquer et persuader."},
                     { id: 5, title: 'Gestion stratégique des opérations', category: 'leadership', price: 399, imageUrl: 'assets/images/course-5.jpg',description:"Apprenez à optimiser vos opérations pour une croissance durable. Méthodes et outils pour une gestion efficace."},
                     { id: 6, title: 'Introduction à l\'investissement boursier', category: 'finance', price: 299, imageUrl: 'assets/images/course-6.jpg', description: "Découvrez les bases de l'investissement boursier. Apprenez à faire des choix éclairés et à gérer les risques."},
                    { id: 7, title: 'Le leadership en situation de crise', category: 'leadership', price: 449, imageUrl: 'assets/images/course-7.jpg',description:"Découvrez comment mener votre équipe à travers les crises. Stratégies éprouvées pour les leaders en temps difficiles."},
                     { id: 8, title: 'Communication non verbale', category: 'communication', price: 349, imageUrl: 'assets/images/course-8.jpg',description:"Apprenez l'importance de la communication non verbale. Développez votre charisme et améliorez vos interactions."},
                     { id: 9, title: 'Les fondamentaux de la comptabilité', category: 'finance', price: 299, imageUrl: 'assets/images/course-9.jpg',description: "Apprenez les bases de la comptabilité financière. Comprenez les bilans et les comptes de résultat."}
             ];


             function displayCourses(page){
                const courseCards = document.getElementById('course-cards');
                courseCards.innerHTML = '';

                  const startIndex = (page - 1) * coursesPerPage;
                  const endIndex = startIndex + coursesPerPage;
                  const coursesToShow = courses.slice(startIndex, endIndex);

                coursesToShow.forEach(course => {
                     const courseCard = document.createElement('div');
                     courseCard.classList.add('bg-white', 'shadow-lg', 'rounded-lg', 'overflow-hidden');
                     courseCard.innerHTML = `
                          <img src="${course.imageUrl}" alt="${course.title}" class="w-full h-48 object-cover">
                          <div class="p-6">
                               <h3 class="text-xl font-semibold mb-2">${course.title}</h3>
                                <p class="text-gray-700 mb-4">${course.description}</p>
                               <div class="flex justify-between items-center">
                                   <span class="font-bold text-purple-500">$${course.price}</span>
                                 <a href="#" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-4 py-2 rounded-md transition-colors duration-300">En savoir plus</a>
                               </div>
                           </div>
                        `;
                        courseCards.appendChild(courseCard);
                });
             }

            function updatePagination(){

                 const totalPages = Math.ceil(courses.length / coursesPerPage);
                  const pageNumbersDiv = document.getElementById('page-numbers');
                pageNumbersDiv.innerHTML = '';


                 for (let i = 1; i <= totalPages; i++){
                         const pageNumberButton = document.createElement('button');
                      pageNumberButton.textContent = i;
                      pageNumberButton.classList.add('px-4', 'py-2', 'rounded-md', 'mx-1', 'hover:bg-gray-300', 'transition-colors', 'duration-300');

                      if (i === currentPage){
                          pageNumberButton.classList.add('bg-purple-200');
                      }

                         pageNumberButton.addEventListener('click', () =>{
                             currentPage = i;
                             displayCourses(currentPage);
                             updatePagination();
                             updateButtonsVisibility();
                         });

                      pageNumbersDiv.appendChild(pageNumberButton)
                    }
                }

            function updateButtonsVisibility() {
                 const totalPages = Math.ceil(courses.length / coursesPerPage);
                 const prevButton = document.getElementById('prev-page');
                 const nextButton = document.getElementById('next-page');

                 if (currentPage === 1){
                     prevButton.classList.add('hidden')
                 }else {
                      prevButton.classList.remove('hidden')
                 }

                if (currentPage === totalPages || totalPages === 0){
                    nextButton.classList.add('hidden')
                 }else {
                    nextButton.classList.remove('hidden')
                 }
             }


            function filterCourses(category){

                  if(category === 'all'){
                    courses = [
                        { id: 1, title: 'Le leadership inspirant', category: 'leadership', price: 299, imageUrl: 'assets/images/course-1.jpg', description: "Découvrez les secrets d'un leadership qui motive et inspire les équipes. Stratégies avancées, exemples pratiques." },
                        { id: 2, title: 'La communication persuasive', category: 'communication', price: 349, imageUrl: 'assets/images/course-2.jpg', description: "Maîtrisez l'art de la persuasion. Apprenez à influencer, négocier et convaincre. Techniques et mises en situation réelles." },
                        { id: 3, title: 'La finance pour les décideurs', category: 'finance', price: 499, imageUrl: 'assets/images/course-3.jpg', description: "Acquérez une solide compréhension financière. Prenez des décisions éclairées, gérez vos investissements avec assurance." },
                        { id: 4, title: 'L\'art du storytelling', category: 'communication', price: 249, imageUrl: 'assets/images/course-4.jpg',description:"Découvrez l'art de captiver votre public grâce au storytelling. Une méthode puissante pour communiquer et persuader."},
                        { id: 5, title: 'Gestion stratégique des opérations', category: 'leadership', price: 399, imageUrl: 'assets/images/course-5.jpg',description:"Apprenez à optimiser vos opérations pour une croissance durable. Méthodes et outils pour une gestion efficace."},
                        { id: 6, title: 'Introduction à l\'investissement boursier', category: 'finance', price: 299, imageUrl: 'assets/images/course-6.jpg', description: "Découvrez les bases de l'investissement boursier. Apprenez à faire des choix éclairés et à gérer les risques."},
                         { id: 7, title: 'Le leadership en situation de crise', category: 'leadership', price: 449, imageUrl: 'assets/images/course-7.jpg',description:"Découvrez comment mener votre équipe à travers les crises. Stratégies éprouvées pour les leaders en temps difficiles."},
                        { id: 8, title: 'Communication non verbale', category: 'communication', price: 349, imageUrl: 'assets/images/course-8.jpg',description:"Apprenez l'importance de la communication non verbale. Développez votre charisme et améliorez vos interactions."},
                        { id: 9, title: 'Les fondamentaux de la comptabilité', category: 'finance', price: 299, imageUrl: 'assets/images/course-9.jpg',description: "Apprenez les bases de la comptabilité financière. Comprenez les bilans et les comptes de résultat."}

                      ];
                  } else{
                         courses =  [
                            { id: 1, title: 'Le leadership inspirant', category: 'leadership', price: 299, imageUrl: 'assets/images/course-1.jpg', description: "Découvrez les secrets d'un leadership qui motive et inspire les équipes. Stratégies avancées, exemples pratiques." },
                             { id: 2, title: 'La communication persuasive', category: 'communication', price: 349, imageUrl: 'assets/images/course-2.jpg', description: "Maîtrisez l'art de la persuasion. Apprenez à influencer, négocier et convaincre. Techniques et mises en situation réelles." },
                             { id: 3, title: 'La finance pour les décideurs', category: 'finance', price: 499, imageUrl: 'assets/images/course-3.jpg', description: "Acquérez une solide compréhension financière. Prenez des décisions éclairées, gérez vos investissements avec assurance." },
                            { id: 4, title: 'L\'art du storytelling', category: 'communication', price: 249, imageUrl: 'assets/images/course-4.jpg',description:"Découvrez l'art de captiver votre public grâce au storytelling. Une méthode puissante pour communiquer et persuader."},
                             { id: 5, title: 'Gestion stratégique des opérations', category: 'leadership', price: 399, imageUrl: 'assets/images/course-5.jpg',description:"Apprenez à optimiser vos opérations pour une croissance durable. Méthodes et outils pour une gestion efficace."},
                            { id: 6, title: 'Introduction à l\'investissement boursier', category: 'finance', price: 299, imageUrl: 'assets/images/course-6.jpg', description: "Découvrez les bases de l'investissement boursier. Apprenez à faire des choix éclairés et à gérer les risques."},
                             { id: 7, title: 'Le leadership en situation de crise', category: 'leadership', price: 449, imageUrl: 'assets/images/course-7.jpg',description:"Découvrez comment mener votre équipe à travers les crises. Stratégies éprouvées pour les leaders en temps difficiles."},
                            { id: 8, title: 'Communication non verbale', category: 'communication', price: 349, imageUrl: 'assets/images/course-8.jpg',description:"Apprenez l'importance de la communication non verbale. Développez votre charisme et améliorez vos interactions."},
                            { id: 9, title: 'Les fondamentaux de la comptabilité', category: 'finance', price: 299, imageUrl: 'assets/images/course-9.jpg',description: "Apprenez les bases de la comptabilité financière. Comprenez les bilans et les comptes de résultat."}
                           ].filter(course => course.category === category);
                  }
                  currentPage = 1;
                  displayCourses(currentPage);
                  updatePagination();
                  updateButtonsVisibility();
            }

            document.getElementById('categories').addEventListener('click', function(event) {
                if(event.target.tagName === 'LI'){
                  const category = event.target.dataset.category;
                    filterCourses(category)
                }
            });

             function searchCourses(searchTerm){
                courses =   [
                    { id: 1, title: 'Le leadership inspirant', category: 'leadership', price: 299, imageUrl: 'assets/images/course-1.jpg', description: "Découvrez les secrets d'un leadership qui motive et inspire les équipes. Stratégies avancées, exemples pratiques." },
                    { id: 2, title: 'La communication persuasive', category: 'communication', price: 349, imageUrl: 'assets/images/course-2.jpg', description: "Maîtrisez l'art de la persuasion. Apprenez à influencer, négocier et convaincre. Techniques et mises en situation réelles." },
                    { id: 3, title: 'La finance pour les décideurs', category: 'finance', price: 499, imageUrl: 'assets/images/course-3.jpg', description: "Acquérez une solide compréhension financière. Prenez des décisions éclairées, gérez vos investissements avec assurance." },
                    { id: 4, title: 'L\'art du storytelling', category: 'communication', price: 249, imageUrl: 'assets/images/course-4.jpg',description:"Découvrez l'art de captiver votre public grâce au storytelling. Une méthode puissante pour communiquer et persuader."},
                    { id: 5, title: 'Gestion stratégique des opérations', category: 'leadership', price: 399, imageUrl: 'assets/images/course-5.jpg',description:"Apprenez à optimiser vos opérations pour une croissance durable. Méthodes et outils pour une gestion efficace."},
                    { id: 6, title: 'Introduction à l\'investissement boursier', category: 'finance', price: 299, imageUrl: 'assets/images/course-6.jpg', description: "Découvrez les bases de l'investissement boursier. Apprenez à faire des choix éclairés et à gérer les risques."},
                    { id: 7, title: 'Le leadership en situation de crise', category: 'leadership', price: 449, imageUrl: 'assets/images/course-7.jpg',description:"Découvrez comment mener votre équipe à travers les crises. Stratégies éprouvées pour les leaders en temps difficiles."},
                    { id: 8, title: 'Communication non verbale', category: 'communication', price: 349, imageUrl: 'assets/images/course-8.jpg',description:"Apprenez l'importance de la communication non verbale. Développez votre charisme et améliorez vos interactions."},
                    { id: 9, title: 'Les fondamentaux de la comptabilité', category: 'finance', price: 299, imageUrl: 'assets/images/course-9.jpg',description: "Apprenez les bases de la comptabilité financière. Comprenez les bilans et les comptes de résultat."}

               ].filter(course => course.title.toLowerCase().includes(searchTerm.toLowerCase()));
                    currentPage = 1;
                    displayCourses(currentPage);
                    updatePagination();
                 updateButtonsVisibility();

            }

             const searchInput = document.getElementById('search-input');
              searchInput.addEventListener('input', function(){
                    searchCourses(this.value)
              });


            document.getElementById('prev-page').addEventListener('click', function (){
                 currentPage--;
                 displayCourses(currentPage);
                 updatePagination();
                 updateButtonsVisibility();
            });

              document.getElementById('next-page').addEventListener('click', function (){
                 currentPage++;
                 displayCourses(currentPage);
                 updatePagination();
                 updateButtonsVisibility();
            });


            displayCourses(currentPage);
             updatePagination();
            updateButtonsVisibility();

        });
    </script>
</body>
</html>