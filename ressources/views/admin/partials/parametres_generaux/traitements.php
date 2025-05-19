<?php
$traitement_a_modifier = $GLOBALS['traitement_a_modifier'] ?? null;

// Pagination
$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

// Filter the list based on search
$listeTraitements = $GLOBALS['listeTraitements'] ?? [];
if (!empty($search)) {
    $listeTraitements = array_filter($listeTraitements, function($traitement) use ($search) {
        return stripos($traitement->lib_traitement, $search) !== false;
    });
}

// Total pages calculation
$total_items = count($listeTraitements);
$total_pages = ceil($total_items / $limit);

// Slice the array for pagination
$listeTraitements = array_slice($listeTraitements, $offset, $limit);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Traitements</title>
    <style>
    /* Animations et transitions */
    .animate__animated {
        animation-duration: 0.3s;
    }

    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }

    /* Personnalisation des inputs */
    .form-input:focus {
        border-color: #22c55e;
        box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
        background-color: #f0fdf4;
    }

    /* Style pour le hover des lignes du tableau */
    .table-row:hover {
        background-color: #f0fdf4;
    }

    /* Style pour les checkboxes */
    input[type="checkbox"]:checked {
        background-color: #22c55e;
        border-color: #22c55e;
    }

    /* Style pour la pagination active */
    .pagination-active {
        background-color: #22c55e;
        border-color: #22c55e;
    }

    /* Boutons avec dégradés */
    .btn-gradient-primary {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    }

    .btn-gradient-secondary {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    }

    .btn-gradient-warning {
        background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%);
    }

    .btn-gradient-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    /* Effet de hover sur les boutons */
    .btn-hover {
        transition: all 0.3s ease;
    }

    .btn-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    @media print {
        body * {
            visibility: hidden;
        }

        .container table,
        .container table * {
            visibility: visible;
        }

        .container table {
            position: absolute;
            left: 0;
            top: 0;
        }

        button,
        .actions,
        input[type="checkbox"] {
            display: none !important;
        }
    }

    /* Styles pour les notifications */
    .notification {
        position: fixed;
        top: 1rem;
        right: 1rem;
        padding: 1rem;
        border-radius: 0.5rem;
        color: white;
        max-width: 24rem;
        z-index: 50;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        animation: slideIn 0.5s ease-out;
    }

    .notification.success {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    }

    .notification.error {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }

        to {
            opacity: 0;
        }
    }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Système de notification -->
    <?php if (!empty($GLOBALS['messageSuccess'])): ?>
    <div id="successNotification" class="notification success animate__animated animate__fadeIn">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <p><?= htmlspecialchars($GLOBALS['messageSuccess']) ?></p>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($GLOBALS['messageErreur'])): ?>
    <div id="errorNotification" class="notification error animate__animated animate__fadeIn">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <p><?= htmlspecialchars($GLOBALS['messageErreur']) ?></p>
        </div>
    </div>
    <?php endif; ?>

    <div class="min-h-screen">
        <main class="container mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-600">
                    <i class="fas fa-cogs mr-2 text-green-600"></i>
                    Gestion des Traitements
                </h2>
            </div>

            <!-- Formulaire -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-600 mb-4 flex items-center">
                    <i
                        class="fas <?= isset($_GET['id_traitement']) ? 'fa-edit text-green-500' : 'fa-plus-circle text-green-500' ?> mr-2"></i>
                    <?= isset($_GET['id_traitement']) ? "Modifier le traitement" : "Ajouter un nouveau traitement" ?>
                </h3>

                <form method="POST" action="?page=parametres_generaux&action=traitements" id="traitementForm">
                    <?php if($traitement_a_modifier): ?>
                    <input type="hidden" name="id_traitement"
                        value="<?= htmlspecialchars($traitement_a_modifier->id_traitement) ?>">
                    <?php endif ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Libellé Traitement -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Libellé du traitement</label>
                            <input type="text" id="lib_traitement" name="lib_traitement" required
                                value="<?= $traitement_a_modifier ? htmlspecialchars($traitement_a_modifier->lib_traitement) : '' ?>"
                                placeholder="Ex: gestion_des_traitements"
                                class="form-input w-full px-3 py-2 mb-3 border border-gray-300 rounded-md focus:outline-4 focus:outline-green-300 focus:ring-green-300 focus:border-green-300 focus:ring-opacity-50 transition-all duration-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Label du traitement</label>
                            <input type="text" id="label_traitement" name="label_traitement" required
                                value="<?= $traitement_a_modifier ? htmlspecialchars($traitement_a_modifier->label_traitement) : '' ?>"
                                placeholder="Gestion des traitements"
                                class="form-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-4 focus:outline-green-300 focus:ring-green-300 focus:border-green-300 focus:ring-opacity-50 transition-all duration-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Icone du traitement</label>
                            <input type="text" id="icone_traitement" name="icone_traitement" required
                                value="<?= $traitement_a_modifier ? htmlspecialchars($traitement_a_modifier->icone_traitement) : '' ?>"
                                placeholder="Ex: fa-cogs"
                                class="form-input w-full px-3 mb-3 py-2 border border-gray-300 rounded-md focus:outline-4 focus:outline-green-300 focus:ring-green-300 focus:border-green-300 focus:ring-opacity-50 transition-all duration-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ordre du traitement</label>
                            <input type="text" id="ordre_traitement" name="ordre_traitement" required
                                value="<?= $traitement_a_modifier ? htmlspecialchars($traitement_a_modifier->ordre_traitement) : '' ?>"
                                placeholder="Ex: 1"
                                class="form-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-4 focus:outline-green-300 focus:ring-green-300 focus:border-green-300 focus:ring-opacity-50 transition-all duration-200">
                        </div>
                    </div>

                    <div class="flex justify-between mt-6">
                        <?php if (isset($_GET['id_traitement'])): ?>
                        <button type="button" name="btn_annuler" id="btnAnnuler"
                            onclick="window.location.href='?page=parametres_generaux&action=traitements'"
                            class="btn-hover px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <i class="fas fa-times mr-2"></i>Annuler
                        </button>
                        <button type="button" id="btnModifier" name="btn_modifier_traitement"
                            class="btn-hover px-4 py-2 btn-gradient-primary text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <i class="fas fa-save mr-2"></i>Modifier
                            <input type="hidden" name="btn_modifier_traitement" id="btn_modifier_traitement_hidden"
                                value="0">
                        </button>
                        <?php else: ?>
                        <div></div>
                        <button type="submit" name="btn_add_traitement"
                            class="btn-hover px-4 py-2 btn-gradient-primary text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <i class="fas fa-plus mr-2"></i>Ajouter un traitement
                        </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Liste des traitements -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-600 mb-4 flex items-center">
                    <i class="fas fa-list-ul text-green-500 mr-2"></i>
                    Liste des traitements
                </h3>
                <div class="flex justify-between items-center mb-4">

                    <div class="flex items-center space-x-4">

                        <div class="flex items-center justify-between mb-6">
                            <!-- Barre de recherche -->
                            <div class="flex-1 max-w-md">
                                <form action="" method="GET" class="flex gap-3">
                                    <input type="hidden" name="page" value="parametres_generaux">
                                    <input type="hidden" name="action" value="niveaux_etude">
                                    <div class="relative flex-1">
                                        <i
                                            class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                        <input type="text" name="search" value="<?= $search ?>"
                                            placeholder="Rechercher..."
                                            class="form-input w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none transition-all duration-200">
                                    </div>
                                    <button type="submit"
                                        class="btn-hover px-4 py-2 btn-gradient-secondary text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        <i class="fas fa-search mr-2"></i>Rechercher
                                    </button>
                                </form>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="flex gap-3">
                                <button id="exportBtn" onclick="exportToExcel()"
                                    class="btn-hover px-4 py-2 btn-gradient-warning text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                                    <i class="fas fa-file-export mr-2"></i>Exporter
                                </button>
                                <button id="printBtn" onclick="printTable()"
                                    class="btn-hover px-4 py-2 btn-gradient-secondary text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                    <i class="fas fa-print mr-2"></i>Imprimer
                                </button>
                                <button type="button" id="deleteSelectedBtn" disabled
                                    class="btn-hover px-4 py-2 btn-gradient-danger text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fas fa-trash-alt mr-2"></i>Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <form class="overflow-x-auto" method="POST" action="?page=parametres_generaux&action=traitements"
                    id="traitementForm">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="w-[5%] px-4 py-3 text-center">
                                    <input type="checkbox" id="selectAllCheckbox"
                                        class="form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Libellé</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Label</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Icone
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ordre
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (!empty($listeTraitements)) : ?>
                            <?php foreach ($listeTraitements as $traitement) : ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-center">
                                    <input type="checkbox" name="selected_ids[]"
                                        value="<?= htmlspecialchars($traitement->id_traitement) ?>"
                                        class="row-checkbox form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 font-medium">
                                    <?= htmlspecialchars($traitement->id_traitement) ?>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    <?= htmlspecialchars($traitement->lib_traitement) ?>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    <?= htmlspecialchars($traitement->label_traitement) ?>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    <i
                                        class="text-green-500 fas <?= htmlspecialchars($traitement->icone_traitement) ?>"></i>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700">
                                    <?= htmlspecialchars($traitement->ordre_traitement) ?>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="?page=parametres_generaux&action=traitements&id_traitement=<?= $traitement->id_traitement ?>"
                                            class="text-blue-500 hover:text-blue-700 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else : ?>
                            <tr>
                                <td colspan="4" class="text-center text-sm text-gray-500 py-4">
                                    Aucun traitement enregistré.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </form>

                <!-- Pagination -->
                <?php if ($total_pages > 1): ?>
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Affichage de <span class="font-medium"><?= $offset + 1 ?></span>
                                à <span class="font-medium"><?= min($offset + $limit, $total_items) ?></span>
                                sur <span class="font-medium"><?= $total_items ?></span> résultats
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                aria-label="Pagination">
                                <?php if ($page > 1): ?>
                                <a href="?page=parametres_generaux&action=traitements&p=<?= $page - 1 ?>&search=<?= urlencode($search) ?>"
                                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                                <?php endif; ?>

                                <?php
                                $start = max(1, $page - 2);
                                $end = min($total_pages, $page + 2);
                                
                                if ($start > 1) {
                                    echo '<span class="px-3 py-2 text-gray-500">...</span>';
                                }
                                
                                for ($i = $start; $i <= $end; $i++):
                                ?>
                                <a href="?page=parametres_generaux&action=traitements&p=<?= $i ?>&search=<?= urlencode($search) ?>"
                                    class="relative inline-flex items-center px-4 py-2 border <?= $i === $page ? 'bg-green-50 text-green-600 border-green-500' : 'bg-white text-gray-500 hover:bg-gray-50 border-gray-300' ?>">
                                    <?= $i ?>
                                </a>
                                <?php endfor;

                                if ($end < $total_pages) {
                                    echo '<span class="px-3 py-2 text-gray-500">...</span>';
                                }
                                ?>

                                <?php if ($page < $total_pages): ?>
                                <a href="?page=parametres_generaux&action=traitements&p=<?= $page + 1 ?>&search=<?= urlencode($search) ?>"
                                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                                <?php endif; ?>
                            </nav>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script>
    // Fonction pour l'export Excel
    document.getElementById('exportExcel').addEventListener('click', function() {
        const table = document.querySelector('table');
        const rows = Array.from(table.querySelectorAll('tr'));

        // Créer le contenu CSV
        let csvContent = "data:text/csv;charset=utf-8,";

        // Ajouter les en-têtes
        const headers = Array.from(table.querySelectorAll('th'))
            .map(th => th.textContent.trim())
            .filter(text => text !== '');
        csvContent += headers.join(',') + '\n';

        // Ajouter les données
        rows.slice(1).forEach(row => {
            const cells = Array.from(row.querySelectorAll('td'))
                .map(td => td.textContent.trim())
                .filter(text => text !== '');
            csvContent += cells.join(',') + '\n';
        });

        // Créer le lien de téléchargement
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'traitements.csv');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

    // Fonction pour l'impression
    document.getElementById('printTable').addEventListener('click', function() {
        window.print();
    });

    // Fonction pour la recherche
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchText) ? '' : 'none';
        });
    });

    // Fonction pour la sélection multiple
    document.getElementById('selectAllCheckbox').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // Gestion des notifications
    const notifications = document.querySelectorAll('.notification');
    notifications.forEach(notification => {
        setTimeout(() => {
            notification.style.animation = 'fadeOut 0.5s ease-out forwards';
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    });
    </script>
</body>

</html>