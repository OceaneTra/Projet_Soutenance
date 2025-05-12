<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Réclamations</title>
</head>

<body class="bg-gradient-to-r from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">

    <div class="container mx-auto py-10">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-10">Gestion des Réclamations</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Soumettre une réclamation -->
            <div
                class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-2 card">
                <div class="flex items-center justify-center w-14 h-14 bg-blue-100 text-blue-500 rounded-full mb-4">
                    <i class="fa-solid fa-circle-exclamation text-2xl"></i>
                </div>
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Soumettre une Réclamation</h2>
                <p class="text-gray-600 mb-6">Déposez une nouvelle réclamation en remplissant le formulaire dédié.</p>
                <a href="/soumettre-reclamation"
                    class="inline-block bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-300">Soumettre</a>
            </div>

            <!-- Suivre mes réclamations -->
            <div
                class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-2 card">
                <div class="flex items-center justify-center w-14 h-14 bg-green-100 text-green-500 rounded-full mb-4">
                    <i class="fa-solid fa-eye text-2xl"></i>
                </div>
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Suivre mes Réclamations</h2>
                <p class="text-gray-600 mb-6">Consultez l'état actuel de vos réclamations en cours.</p>
                <a href="/suivre-reclamations"
                    class="inline-block bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-colors duration-300">Suivre</a>
            </div>

            <!-- Consulter l'historique -->
            <div
                class="bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-2 card">
                <div class="flex items-center justify-center w-14 h-14 bg-purple-100 text-purple-600 rounded-full mb-4">
                    <i class="fa-solid fa-clock-rotate-left text-2xl"></i>
                </div>
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Historique des Réclamations</h2>
                <p class="text-gray-600 mb-6">Accédez à l'historique complet de vos réclamations passées.</p>
                <a href="/historique-reclamations"
                    class="inline-block bg-purple-500 text-white px-6 py-2 rounded-lg hover:bg-purple-600 transition-colors duration-300">Consulter</a>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Animation d'entrée pour les cartes
        gsap.from('.card', {
            duration: 0.8,
            y: 50,
            opacity: 0,
            stagger: 0.2,
            ease: 'power3.out'
        });

        // Animation au survol des cartes
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                gsap.to(card, {
                    scale: 1.05,
                    duration: 0.3
                });
            });

            card.addEventListener('mouseleave', () => {
                gsap.to(card, {
                    scale: 1,
                    duration: 0.3
                });
            });
        });
    });
    </script>
</body>

</html>