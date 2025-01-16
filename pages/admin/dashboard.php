<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Admin | YouDemy</title>
    <link rel="stylesheet" href="../../public/assets/css/style.css">
    <link rel="stylesheet" href="../../public/assets/css/responsive.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Ajouts pour une ambiance plus luxe */
        .shadow-xl {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1), 0 6px 6px rgba(0, 0, 0, 0.1) !important;
        }

        .bg-gradient-to-r {
            background-image: linear-gradient(to right, var(--tw-gradient-stops));
        }
    </style>
</head>

<body class="font-montserrat bg-gray-100 text-gray-800">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="bg-gray-900 text-white w-64 flex-shrink-0 shadow-lg">
            <div class="p-4">
                <h2 class="text-2xl font-bold mb-6 text-center font-playfair">YouDemy Admin</h2>
                <nav>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="flex items-center py-2 px-4 rounded-md hover:bg-gray-800">
                                <i class="fas fa-home mr-2"></i>Tableau de bord
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center py-2 px-4 rounded-md hover:bg-gray-800">
                                <i class="fas fa-users mr-2"></i>Utilisateurs
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center py-2 px-4 rounded-md hover:bg-gray-800">
                                <i class="fas fa-book mr-2"></i>Cours
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center py-2 px-4 rounded-md hover:bg-gray-800">
                                <i class="fas fa-chart-bar mr-2"></i>Statistiques
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center py-2 px-4 rounded-md hover:bg-gray-800">
                                <i class="fas fa-comments mr-2"></i>Avis
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center py-2 px-4 rounded-md hover:bg-gray-800">
                                <i class="fas fa-money-bill-wave mr-2"></i>Paiements
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center py-2 px-4 rounded-md hover:bg-gray-800">
                                <i class="fas fa-cog mr-2"></i>Paramètres
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="mt-8 border-t border-gray-700 pt-4">
                    <a href="../../pages/admin/profile.php" class="flex items-center py-2 px-4 rounded-md hover:bg-gray-800">
                        <i class="fas fa-user mr-2"></i>Profil
                    </a>
                    <a href="../../pages/auth/logout.php" class="flex items-center py-2 px-4 rounded-md hover:bg-gray-800">
                        <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-y-auto">
            <h1 class="text-4xl font-playfair font-bold mb-8 text-gray-900">Tableau de Bord Admin</h1>

            <!-- Dashboard Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Card 1: Total Users -->
                <div class="bg-white p-6 rounded-xl shadow-xl overflow-hidden relative">
                    <div class="text-3xl font-bold mb-2 text-gray-900">1500</div>
                    <div class="text-gray-500 text-sm uppercase tracking-wider mb-4">Utilisateurs Totaux</div>
                    <div class="absolute bottom-0 right-0 h-16 w-16 rounded-full bg-gradient-to-tr from-blue-500 to-blue-300">
                    </div>
                    <span
                        class="absolute bottom-0 right-0 m-2 w-12 h-12 flex justify-center items-center text-white text-2xl"><i
                            class="fas fa-users"></i></span>
                </div>

                <!-- Card 2: Total Courses -->
                <div class="bg-white p-6 rounded-xl shadow-xl overflow-hidden relative">
                    <div class="text-3xl font-bold mb-2 text-gray-900">350</div>
                    <div class="text-gray-500 text-sm uppercase tracking-wider mb-4">Cours Disponibles</div>
                    <div class="absolute bottom-0 right-0 h-16 w-16 rounded-full bg-gradient-to-tr from-green-500 to-green-300">
                    </div>
                    <span
                        class="absolute bottom-0 right-0 m-2 w-12 h-12 flex justify-center items-center text-white text-2xl"><i
                            class="fas fa-book-open"></i></span>
                </div>

                <!-- Card 3: Active Users -->
                <div class="bg-white p-6 rounded-xl shadow-xl overflow-hidden relative">
                    <div class="text-3xl font-bold mb-2 text-gray-900">800</div>
                    <div class="text-gray-500 text-sm uppercase tracking-wider mb-4">Utilisateurs Actifs</div>
                    <div
                        class="absolute bottom-0 right-0 h-16 w-16 rounded-full bg-gradient-to-tr from-yellow-500 to-yellow-300">
                    </div>
                    <span
                        class="absolute bottom-0 right-0 m-2 w-12 h-12 flex justify-center items-center text-white text-2xl"><i
                            class="fas fa-user-check"></i></span>
                </div>

                <!-- Card 4: Revenue -->
                <div class="bg-white p-6 rounded-xl shadow-xl overflow-hidden relative">
                    <div class="text-3xl font-bold mb-2 text-gray-900">$55,000</div>
                    <div class="text-gray-500 text-sm uppercase tracking-wider mb-4">Revenu Total</div>
                    <div
                        class="absolute bottom-0 right-0 h-16 w-16 rounded-full bg-gradient-to-tr from-purple-500 to-purple-300">
                    </div>
                    <span
                        class="absolute bottom-0 right-0 m-2 w-12 h-12 flex justify-center items-center text-white text-2xl"><i
                            class="fas fa-dollar-sign"></i></span>
                </div>

                <!-- Card 5: new Users -->
                <div class="bg-white p-6 rounded-xl shadow-xl overflow-hidden relative">
                    <div class="text-3xl font-bold mb-2 text-gray-900">120</div>
                    <div class="text-gray-500 text-sm uppercase tracking-wider mb-4">Nouveaux utilisateurs</div>
                    <div
                        class="absolute bottom-0 right-0 h-16 w-16 rounded-full bg-gradient-to-tr from-indigo-500 to-indigo-300">
                    </div>
                    <span
                        class="absolute bottom-0 right-0 m-2 w-12 h-12 flex justify-center items-center text-white text-2xl"><i
                            class="fas fa-user-plus"></i></span>
                </div>

                <!-- Card 6: Completion rate -->
                <div class="bg-white p-6 rounded-xl shadow-xl overflow-hidden relative">
                    <div class="text-3xl font-bold mb-2 text-gray-900">70%</div>
                    <div class="text-gray-500 text-sm uppercase tracking-wider mb-4">Taux de Complétion</div>
                    <div
                        class="absolute bottom-0 right-0 h-16 w-16 rounded-full bg-gradient-to-tr from-pink-500 to-pink-300">
                    </div>
                    <span
                        class="absolute bottom-0 right-0 m-2 w-12 h-12 flex justify-center items-center text-white text-2xl"><i
                            class="fas fa-percent"></i></span>
                </div>

                <!-- Card 7: Feedback count -->
                <div class="bg-white p-6 rounded-xl shadow-xl overflow-hidden relative">
                    <div class="text-3xl font-bold mb-2 text-gray-900">80</div>
                    <div class="text-gray-500 text-sm uppercase tracking-wider mb-4">Avis reçus</div>
                    <div
                        class="absolute bottom-0 right-0 h-16 w-16 rounded-full bg-gradient-to-tr from-teal-500 to-teal-300">
                    </div>
                    <span
                        class="absolute bottom-0 right-0 m-2 w-12 h-12 flex justify-center items-center text-white text-2xl"><i
                            class="fas fa-comment"></i></span>
                </div>

                <!-- Card 8: pending payments -->
                <div class="bg-white p-6 rounded-xl shadow-xl overflow-hidden relative">
                    <div class="text-3xl font-bold mb-2 text-gray-900">15</div>
                    <div class="text-gray-500 text-sm uppercase tracking-wider mb-4">Paiements en attente</div>
                    <div
                        class="absolute bottom-0 right-0 h-16 w-16 rounded-full bg-gradient-to-tr from-orange-500 to-orange-300">
                    </div>
                    <span
                        class="absolute bottom-0 right-0 m-2 w-12 h-12 flex justify-center items-center text-white text-2xl"><i
                            class="fas fa-exclamation-triangle"></i></span>
                </div>
            </div>

            <!-- Data Tables -->
             <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
                <div>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900">Utilisateurs Récents</h2>
                    <div class="shadow-xl rounded-lg overflow-hidden">
                        <table class="min-w-full leading-normal table-auto">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th
                                        class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Nom</th>
                                    <th
                                        class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Email</th>
                                    <th
                                        class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Inscription</th>
                                        <th
                                        class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                   <td class="px-6 py-4 border-b border-gray-200 text-sm">John Doe</td>
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">john.doe@example.com</td>
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">15/01/2024</td>
                                     <td class="px-6 py-4 border-b border-gray-200 text-sm">
                                         <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-200 rounded-full">Actif</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">Jane Smith</td>
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">jane.smith@example.com</td>
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">20/01/2024</td>
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">
                                          <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-200 rounded-full">Inactif</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <h2 class="text-2xl font-bold mb-4 text-gray-900">Cours Récents</h2>
                    <div class="shadow-xl rounded-lg overflow-hidden">
                        <table class="min-w-full leading-normal table-auto">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th
                                        class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Titre du cours</th>
                                    <th
                                        class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Auteur</th>
                                    <th
                                        class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Date de publication</th>
                                          <th
                                        class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">Développement Web</td>
                                     <td class="px-6 py-4 border-b border-gray-200 text-sm">Sarah Leduc</td>
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">25/01/2024</td>
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-200 rounded-full">Publié</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">Photographie numérique</td>
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">Michel Lambert</td>
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">30/01/2024</td>
                                    <td class="px-6 py-4 border-b border-gray-200 text-sm">
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-200 rounded-full">Non publié</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Charts section -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold mb-4 text-gray-900">Visualisation des données</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                     <div class="bg-white shadow-xl rounded-xl p-6">
                        <h3 class="text-xl font-semibold mb-4 text-gray-900">Répartition des cours par catégorie</h3>
                        <canvas id="courseCategoryChart"></canvas>
                      </div>
                      <div class="bg-white shadow-xl rounded-xl p-6">
                            <h3 class="text-xl font-semibold mb-4 text-gray-900">Nombre d'utilisateurs par rôle</h3>
                           <canvas id="userRoleChart"></canvas>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../script.js"></script>
    <script>
        const courseCategoryChartCanvas = document.getElementById('courseCategoryChart');
        const userRoleChartCanvas = document.getElementById('userRoleChart');

         // Données d'exemple pour le graphique des catégories de cours
        const courseCategoryData = {
            labels: ['Développement Web', 'Marketing Digital', 'Design Graphique', 'Photographie'],
            datasets: [{
                label: 'Nombre de cours',
                data: [120, 80, 50, 100],
                backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)', 'rgb(75, 192, 192)'],
            }]
        };
         // Données d'exemple pour le graphique du nombre d'utilisateurs par rôle
        const userRoleData = {
             labels: ['Étudiant', 'Formateur', 'Admin'],
             datasets: [{
                label: 'Nombre d\'utilisateurs',
                data: [1200, 300, 10],
                backgroundColor: ['rgb(54, 162, 235)', 'rgb(75, 192, 192)', 'rgb(255, 99, 132)'],
             }]
        };


       new Chart(courseCategoryChartCanvas, {
            type: 'pie',
            data: courseCategoryData,
             options: {
                   responsive: true,
                  maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                        title: {
                          display: true,
                          text: 'Répartition des cours par catégorie'
                      }
                  }
              }
          });
       new Chart(userRoleChartCanvas, {
            type: 'bar',
            data: userRoleData,
           options: {
                responsive: true,
               maintainAspectRatio: false,
              plugins: {
                  legend: {
                        display: false
                  },
                  title: {
                      display: true,
                      text: 'Nombre d\'utilisateurs par rôle'
                  }
              },
              scales: {
                y: {
                    beginAtZero: true
                  }
              }
           }
      });
    </script>
</body>

</html>