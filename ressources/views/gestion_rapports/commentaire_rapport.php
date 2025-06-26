<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Rendu des Rapports</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>
    <div class="container mx-auto px-4 py-8">
        <!-- En-tête avec statistiques -->
        <?php if (isset($statistiquesCompteRendu)): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                        <i class="fas fa-file-alt text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Total Rapports</h3>
                        <p class="text-2xl font-semibold text-gray-700"><?= $statistiquesCompteRendu['total'] ?? 0 ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Cette semaine</h3>
                        <p class="text-2xl font-semibold text-gray-700"><?= $statistiquesCompteRendu['semaine'] ?? 0 ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                        <i class="fas fa-calendar-alt text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Ce mois</h3>
                        <p class="text-2xl font-semibold text-gray-700"><?= $statistiquesCompteRendu['mois'] ?? 0 ?></p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Liste des rapports avec commentaires -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">Liste des Rapports</h2>
            </div>

            <!-- Filtres -->
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <form method="GET" class="flex flex-wrap gap-4">
                    <input type="hidden" name="page" value="gestion_rapports">
                    <input type="hidden" name="action" value="compte_rendu_rapport">

                    <select name="statut"
                        class="px-4 py-2  rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Tous les statuts</option>
                        <option value="en_cours">En cours</option>
                        <option value="en_revision">En révision</option>
                        <option value="valide">Validé</option>
                        <option value="a_corriger">À corriger</option>
                    </select>

                    <input type="text" name="search" placeholder="Rechercher un rapport..."
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                        <i class="fas fa-search mr-2"></i>Filtrer
                    </button>
                </form>
            </div>

            <!-- Liste des rapports -->
            <div class="divide-y divide-gray-200">
                <?php if (isset($rapports) && !empty($rapports)): ?>
                <?php foreach ($rapports as $rapport): ?>
                <div class="p-6 hover:bg-gray-50 transition-colors">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">
                                <?= htmlspecialchars($rapport['nom_rapport']) ?>
                            </h3>
                            <p class="text-sm text-gray-600 mb-2">
                                <strong>Thème:</strong> <?= htmlspecialchars($rapport['theme_rapport']) ?>
                            </p>
                            <p class="text-sm text-gray-500">
                                Soumis le <?= date('d/m/Y à H:i', strtotime($rapport['date_rapport'])) ?>
                            </p>
                            <?php if (isset($rapport['nom_etu']) && isset($rapport['prenom_etu'])): ?>
                            <p class="text-sm text-gray-500">
                                Étudiant: <?= htmlspecialchars($rapport['prenom_etu'] . ' ' . $rapport['nom_etu']) ?>
                            </p>
                            <?php endif; ?>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            En cours
                        </span>
                    </div>

                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Actions :</h4>
                        <div class="flex space-x-2">
                            <a href="?page=gestion_rapports&action=commentaire_rapport&id=<?= $rapport['id_rapport'] ?>"
                                class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                                <i class="fas fa-eye"></i> Voir détails
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="p-8 text-center text-gray-500">
                    <i class="fas fa-file-alt text-4xl mb-4"></i>
                    <p class="text-lg font-medium mb-2">Aucun rapport trouvé</p>
                    <p class="text-sm">Aucun rapport disponible pour le moment.</p>
                </div>
                <?php endif; ?>
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