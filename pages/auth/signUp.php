<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | Académie de Prestige</title>
    <link href="style.css" rel="stylesheet">
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="font-montserrat bg-gray-50 text-gray-900">

    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-purple-50">
        <div class="bg-white shadow-xl rounded-lg p-8 w-full max-w-md relative overflow-hidden">
           <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-tr from-blue-50 to-purple-50 opacity-30 -z-10"></div>
            <h2 class="text-3xl font-playfair font-bold text-center mb-8">Rejoignez notre communauté</h2>
            <form id="signup-form" class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                    <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" required>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" required>
                </div>
                 <div>
                   <label for="passwordConfirm" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                    <input type="password" id="passwordConfirm" name="passwordConfirm" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200 focus:ring-opacity-50" required>
                </div>
                <div>
                    <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white font-bold py-3 rounded-md transition-colors duration-300 focus:outline-none focus:ring focus:ring-purple-200 focus:ring-opacity-50">S'inscrire</button>
                </div>
                 <div class="text-center">
                    <a href="login.html" class="text-purple-500 hover:text-purple-700 font-medium">Déjà inscrit ?</a>
                </div>
            </form>
             <div id="signup-message" class="mt-4 text-center text-red-500 hidden"></div>
        </div>
    </div>
    <script src="script.js"></script>
    <script>
         document.getElementById('signup-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
             const passwordConfirm = document.getElementById('passwordConfirm').value;


            //  Simulez un enregistrement réussi ou échoué
             if (password !== passwordConfirm){
                   const messageDiv =  document.getElementById('signup-message');
                    messageDiv.textContent = 'Les mots de passe ne correspondent pas.';
                    messageDiv.classList.remove('hidden');
                     setTimeout(() => {
                         messageDiv.classList.add('hidden');
                         messageDiv.textContent = '';
                     }, 3000);
             } else {

                 window.location.href = 'index.html'; // Redirection en cas de succès
                 const messageDiv =  document.getElementById('signup-message');
                  messageDiv.textContent = 'Inscription réussite ! Redirection vers l\'accueil...';
                  messageDiv.classList.remove('hidden');

                 setTimeout(() => {
                     window.location.href = 'index.html';
                 }, 1500);

             }


        });
    </script>
</body>
</html>