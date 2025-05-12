<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Réclamations</title>

</head>

<body class="bg-gray-100">


    <div class="container mx-auto py-10">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Soumettre une réclamation -->
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300">
                <i class="fa-solid fa-circle-exclamation"></i>
                <h2 class="text-xl font-semibold mb-4">Soumettre une Réclamation</h2>
                <p class="text-gray-600 mb-4">Déposez une nouvelle réclamation en remplissant le formulaire dédié.</p>
                <a href="/soumettre-reclamation"
                    class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors duration-300">Soumettre</a>
            </div>

            <!-- Suivre mes réclamations -->
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300">
                <h2 class="text-xl font-semibold mb-4">Suivre mes Réclamations</h2>
                <p class="text-gray-600 mb-4">Consultez l'état actuel de vos réclamations en cours.</p>
                <a href="/suivre-reclamations"
                    class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition-colors duration-300">Suivre</a>
            </div>

            <!-- Consulter l'historique -->
            <div class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300">
                <h2 class="text-xl font-semibold mb-4">Historique des Réclamations</h2>
                <p class="text-gray-600 mb-4">Accédez à l'historique complet de vos réclamations passées.</p>
                <a href="/historique-reclamations"
                    class="inline-block bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600 transition-colors duration-300">Consulter</a>
            </div>
        </div>
    </div>
</body>

</html>