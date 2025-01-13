<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un cours | YouDemy</title>
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
             <h1 class="text-3xl font-playfair font-bold mb-8">Ajouter un cours</h1>
              <form class="space-y-6">
                 <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Titre du cours</label>
                         <input type="text" id="title" name="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" required>
                    </div>
                 <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description du cours</label>
                         <textarea  id="description" name="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" required></textarea>
                    </div>
                   <div>
                    <label for="category" class