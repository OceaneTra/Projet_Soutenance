<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Rendu des Rapports</title>
</head>

<body>
    <div class="container mx-auto px-4 py-8">
        <!-- En-tête avec statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                        <i class="fas fa-file-alt text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Rapports Soumis</h3>
                        <p class="text-2xl font-semibold text-gray-700">12</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Rapports Validés</h3>
                        <p class="text-2xl font-semibold text-gray-700">8</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">En Attente</h3>
                        <p class="text-2xl font-semibold text-gray-700">4</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des rapports avec commentaires -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Liste des Rapports</h2>
            </div>

            <!-- Filtres -->
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-wrap gap-4">
                    <select class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Tous les statuts</option>
                        <option value="valide">Validé</option>
                        <option value="en_attente">En attente</option>
                        <option value="rejete">Rejeté</option>
                    </select>
                    <input type="text" placeholder="Rechercher un rapport..."
                        class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <!-- Liste des rapports -->
            <div class="divide-y divide-gray-200">
                <!-- Rapport 1 -->
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Rapport de Stage - Développement Web</h3>
                            <p class="text-sm text-gray-500">Soumis le 15 Mars 2024</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Validé
                        </span>
                    </div>

                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Commentaires des évaluateurs :</h4>
                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <img src="https://ui-avatars.com/api/?name=Prof+Martin" alt="Avatar"
                                        class="w-8 h-8 rounded-full">
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Prof. Martin</p>
                                        <p class="text-xs text-gray-500">Évaluateur Principal</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600">
                                    "Excellent travail sur la partie méthodologie. La structure est claire et bien
                                    argumentée.
                                    Suggestions d'amélioration : approfondir l'analyse des résultats."
                                </p>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <img src="https://ui-avatars.com/api/?name=Dr+Sophie" alt="Avatar"
                                        class="w-8 h-8 rounded-full">
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Dr. Sophie</p>
                                        <p class="text-xs text-gray-500">Co-évaluateur</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600">
                                    "Bonne présentation des résultats. Points forts : clarté des graphiques et
                                    pertinence des analyses."
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rapport 2 -->
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Mémoire de Master - Intelligence Artificielle
                            </h3>
                            <p class="text-sm text-gray-500">Soumis le 10 Mars 2024</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            En attente
                        </span>
                    </div>

                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Commentaires des évaluateurs :</h4>
                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <img src="https://ui-avatars.com/api/?name=Prof+Jean" alt="Avatar"
                                        class="w-8 h-8 rounded-full">
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Prof. Jean</p>
                                        <p class="text-xs text-gray-500">Évaluateur Principal</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600">
                                    "Travail en cours d'évaluation. Première lecture positive, retour détaillé à venir."
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation des cartes au survol
        const cards = document.querySelectorAll('.bg-white');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-2px)';
                card.style.transition = 'transform 0.2s ease-in-out';
            });

            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
            });
        });

        // Gestion des filtres
        const filterSelect = document.querySelector('select');
        const searchInput = document.querySelector('input[type="text"]');

        filterSelect.addEventListener('change', filterReports);
        searchInput.addEventListener('input', filterReports);

        function filterReports() {
            const status = filterSelect.value;
            const search = searchInput.value.toLowerCase();

            // Logique de filtrage à implémenter
            console.log('Filtrage par:', {
                status,
                search
            });
        }
    });
    </script>
</body>

</html>