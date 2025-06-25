<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants Encadrés</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
    /* Custom styles if needed (keep minimal, prefer Tailwind utilities) */
    .table-row-hover:hover {
        background-color: #f7fafc;
    }

    .filter-section {
        transition: all 0.3s ease;
    }

    .filter-section.collapsed {
        max-height: 0;
        overflow: hidden;
    }

    .pagination-link {
        transition: all 0.2s ease;
    }

    .pagination-link:hover {
        transform: translateY(-1px);
    }
    </style>
</head>

<body class="font-sans bg-gray-100 text-gray-800 min-h-screen p-6">

    <div class="container mx-auto px-4 max-w-screen-xl">

        <div class="bg-white rounded-lg shadow-lg p-6">

            <!-- Section Header and Controls -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 border-b border-gray-200 pb-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 md:mb-0">
                    <i class="fas fa-users mr-2 text-green-600"></i>
                    Étudiants Encadrés
                </h2>

                <!-- Toggle Filter Button -->
                <button id="toggleFilters"
                    class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700 transition-colors duration-200">
                    <i class="fas fa-filter mr-2"></i> Filtres
                </button>
            </div>

            <!-- Filter Section -->
            <div id="filterSection" class="filter-section mb-6 bg-gray-50 rounded-lg p-4">
                <form method="GET" action="" class="space-y-4">
                    <!-- Champ caché pour préserver le paramètre page -->
                    <input type="hidden" name="page" value="liste_etudiants_ens_simple">

                    <!-- Search and Filters Row -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Search Bar -->
                        <div class="relative">
                            <input type="text" name="search" placeholder="Rechercher un étudiant..."
                                value="<?php echo htmlspecialchars($GLOBALS['filtres']['search'] ?? ''); ?>"
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 text-sm">
                            <i
                                class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>

                        <!-- UE Filter -->
                        <div>
                            <select name="filter_ue"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 text-sm">
                                <option value="0">Toutes les UE</option>
                                <?php if (!empty($GLOBALS['uesEnseignant'])): ?>
                                <?php foreach ($GLOBALS['uesEnseignant'] as $ue): ?>
                                <option value="<?php echo $ue->id_ue; ?>"
                                    <?php echo ($GLOBALS['filtres']['filterUe'] ?? 0) == $ue->id_ue ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($ue->lib_ue); ?>
                                </option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- ECUE Filter -->
                        <div>
                            <select name="filter_ecue"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-green-500 focus:border-green-500 text-sm">
                                <option value="0">Tous les ECUE</option>
                                <?php if (!empty($GLOBALS['ecuesEnseignant'])): ?>
                                <?php foreach ($GLOBALS['ecuesEnseignant'] as $ecue): ?>
                                <option value="<?php echo $ecue->id_ecue; ?>"
                                    <?php echo ($GLOBALS['filtres']['filterEcue'] ?? 0) == $ecue->id_ecue ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($ecue->lib_ecue . ' (' . $ecue->lib_ue . ')'); ?>
                                </option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <button type="submit"
                                class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-700 transition-colors duration-200">
                                <i class="fas fa-search mr-2"></i> Rechercher
                            </button>
                            <a href="?page=liste_etudiants_ens_simple"
                                class="bg-gray-500 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-gray-600 transition-colors duration-200">
                                <i class="fas fa-times mr-2"></i> Réinitialiser
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Students Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nom Étudiant
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Numéro Étudiant
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Niveau
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Semestre
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                UE/ECUE
                            </th>


                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (!empty($GLOBALS['etudiants'])): ?>
                        <?php foreach ($GLOBALS['etudiants'] as $etudiant): ?>
                        <tr class="table-row-hover">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?php echo htmlspecialchars($etudiant->prenom_etu . ' ' . $etudiant->nom_etu); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?php echo htmlspecialchars($etudiant->num_etu); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?php echo htmlspecialchars($etudiant->lib_niv_etude); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?php echo htmlspecialchars($etudiant->lib_semestre); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <div class="space-y-1">
                                    <div class="font-medium text-purple-600">
                                        <?php echo htmlspecialchars($etudiant->lib_ue); ?>
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        <?php echo htmlspecialchars($etudiant->lib_ecue); ?>
                                    </div>
                                </div>
                            </td>

                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="8" class="px-6 py-8 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-users text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">Aucun étudiant trouvé</p>
                                    <p class="text-sm">Essayez de modifier vos critères de recherche</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if (!empty($GLOBALS['pagination']) && $GLOBALS['pagination']['totalPages'] > 1): ?>
            <div class="mt-6 flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    Page <?php echo $GLOBALS['pagination']['currentPage']; ?> sur
                    <?php echo $GLOBALS['pagination']['totalPages']; ?>
                </div>

                <div class="flex items-center space-x-2">
                    <!-- Previous Button -->
                    <?php if ($GLOBALS['pagination']['currentPage'] > 1): ?>
                    <?php 
                    $prevParams = $_GET;
                    $prevParams['p'] = $GLOBALS['pagination']['currentPage'] - 1;
                    $prevParams['page'] = 'liste_etudiants_ens_simple';
                    ?>
                    <a href="?<?php echo http_build_query($prevParams); ?>"
                        class="pagination-link relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-chevron-left mr-2"></i> Précédent
                    </a>
                    <?php else: ?>
                    <span
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                        <i class="fas fa-chevron-left mr-2"></i> Précédent
                    </span>
                    <?php endif; ?>

                    <!-- Page Numbers -->
                    <div class="flex space-x-1">
                        <?php for ($i = $GLOBALS['pagination']['start']; $i <= $GLOBALS['pagination']['end']; $i++): ?>
                        <?php if ($i == $GLOBALS['pagination']['currentPage']): ?>
                        <span
                            class="relative inline-flex items-center px-4 py-2 border border-purple-500 text-sm font-medium rounded-md text-white bg-purple-600">
                            <?php echo $i; ?>
                        </span>
                        <?php else: ?>
                        <?php 
                        $pageParams = $_GET;
                        $pageParams['p'] = $i;
                        $pageParams['page'] = 'liste_etudiants_ens_simple';
                        ?>
                        <a href="?<?php echo http_build_query($pageParams); ?>"
                            class="pagination-link relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            <?php echo $i; ?>
                        </a>
                        <?php endif; ?>
                        <?php endfor; ?>
                    </div>

                    <!-- Next Button -->
                    <?php if ($GLOBALS['pagination']['currentPage'] < $GLOBALS['pagination']['totalPages']): ?>
                    <?php 
                    $nextParams = $_GET;
                    $nextParams['p'] = $GLOBALS['pagination']['currentPage'] + 1;
                    $nextParams['page'] = 'liste_etudiants_ens_simple';
                    ?>
                    <a href="?<?php echo http_build_query($nextParams); ?>"
                        class="pagination-link relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Suivant <i class="fas fa-chevron-right ml-2"></i>
                    </a>
                    <?php else: ?>
                    <span
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-400 bg-gray-100 cursor-not-allowed">
                        Suivant <i class="fas fa-chevron-right ml-2"></i>
                    </span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>

    </div>

    <script>
    // Toggle filter section
    document.getElementById('toggleFilters').addEventListener('click', function() {
        const filterSection = document.getElementById('filterSection');
        filterSection.classList.toggle('collapsed');

        // Change button text
        const icon = this.querySelector('i');
        if (filterSection.classList.contains('collapsed')) {
            icon.className = 'fas fa-filter mr-2';
            this.innerHTML = '<i class="fas fa-filter mr-2"></i> Afficher Filtres';
        } else {
            icon.className = 'fas fa-filter mr-2';
            this.innerHTML = '<i class="fas fa-filter mr-2"></i> Masquer Filtres';
        }
    });

    // Auto-submit form when filters change (avec préservation du paramètre page)
    document.querySelectorAll('select[name="filter_ue"], select[name="filter_ecue"]').forEach(function(select) {
        select.addEventListener('change', function() {
            // Créer un formulaire temporaire pour préserver tous les paramètres
            const form = this.closest('form');
            const formData = new FormData(form);

            // S'assurer que le paramètre page est présent
            if (!formData.has('page')) {
                formData.append('page', 'liste_etudiants_ens_simple');
            }

            // Réinitialiser la pagination à la page 1
            formData.set('p', '1');

            // Construire l'URL avec tous les paramètres
            const params = new URLSearchParams(formData);
            window.location.href = '?' + params.toString();
        });
    });

    // Add loading state to search button
    document.querySelector('button[type="submit"]').addEventListener('click', function() {
        this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Recherche...';
        this.disabled = true;
    });
    </script>

    <script src="public/js/liste_etudiants_enseignant.js"></script>

</body>

</html>