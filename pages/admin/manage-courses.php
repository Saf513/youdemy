<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Cours | YouDemy</title>
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
            <h1 class="text-3xl font-playfair font-bold mb-8">Gestion des Cours</h1>
             <a href="add-course.html" class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded-md mb-4 inline-block">Ajouter un cours</a>

                 <table class="w-full border-collapse border border-gray-300">
                        <thead>
                             <tr class="bg-gray-200">
                                <th class="border border-gray-300 p-2">ID</th>
                                <th class="border border-gray-300 p-2">Titre</th>
                                 <th class="border border-gray-300 p-2">Catégorie</th>
                                <th class="border border-gray-300 p-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                              <tr>
                                    <td class="border border-gray-300 p-2">1</td>
                                    <td class="border border-gray-300 p-2">Le leadership inspirant</td>
                                     <td class="border border-gray-300 p-2">Leadership</td>
                                    <td class="border border-gray-300 p-2">
                                        <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded mr-2">Modifier</a>
                                         <a href="#" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded">Supprimer</a>
                                    </td>
                                </tr>
                              <tr>
                                    <td class="border border-gray-300 p-2">2</td>
                                    <td class="border border-gray-300 p-2">La communication persuasive</td>
                                     <td class="border border-gray-300 p-2">Communication</td>
                                    <td class="border border-gray-300 p-2">
                                        <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded mr-2">Modifier</a>
                                        <a href="#" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded">Supprimer</a>
                                    </td>
                             </tr>
                              <tr>
                                    <td class="border border-gray-300 p-2">3</td>
                                    <td class="border border-gray-300 p-2">La finance pour les décideurs</td>
                                     <td class="border border-gray-300 p-2">Finance</td>
                                    <td class="border border-gray-300 p-2">
                                         <a href="#" class="bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded mr-2">Modifier</a>
                                        <a href="#" class="bg-red-500 hover:bg-red-700 text-white px-3 py-1 rounded">Supprimer</a>
                                    </td>
                            </tr>
                        </tbody>
                    </table>
        </main>
    </div>
    <script src="../../script.js"></script>
</body>
</html>