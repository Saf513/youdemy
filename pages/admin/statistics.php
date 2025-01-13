<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques | YouDemy</title>
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
            <h1 class="text-3xl font-playfair font-bold mb-8">Statistiques</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
               <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-2xl font-semibold mb-2">Nombre total d'utilisateurs</h3>
                    <p class="text-4xl font-bold text-purple-500">100</p>
                </div>
                 <div class="bg-white shadow-lg rounded-lg p-6 text-center">
                    <h3 class="text-2xl font-semibold mb-2">Nombre total de cours</h3>
                    <p class="text-4xl font-bold text-purple-500">3</p>
                </div>
            </div>
        </main>
    </div>
      <script src="../../script.js"></script>
</body>
</html>