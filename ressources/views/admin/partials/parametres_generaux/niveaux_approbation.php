<?php
$niveau_a_modifier = $GLOBALS['niveau_a_modifier'] ?? null;

// Pagination
$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

// Filter the list based on search
$listeNiveaux = $GLOBALS['listeNiveaux'] ?? [];
if (!empty($search)) {
    $listeNiveaux = array_filter($listeNiveaux, function($niveau) use ($search) {
        return stripos($niveau->lib_approb, $search) !== false;
    });
}

// Total pages calculation
$total_items = count($listeNiveaux);
$total_pages = ceil($total_items / $limit);

// Slice the array for pagination
$listeNiveaux = array_slice($listeNiveaux, $offset, $limit);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Niveaux d'Approbation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
                    <i class="fas fa-layer-group mr-2 text-green-600"></i>
                    Gestion des Niveaux d'Approbation
                </h2>
            </div>

            <!-- Formulaire -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-600 mb-4 flex items-center">
                    <i
                        class="fas <?= isset($_GET['id_approb']) ? 'fa-edit text-green-500' : 'fa-plus-circle text-green-500' ?> mr-2"></i>
                    <?= isset($_GET['id_approb']) ? 'Modifier le niveau' : 'Ajouter un nouveau niveau' ?>
                </h3>

                <form method="POST" action="?page=parametres_generaux&action=niveaux_approbation" id="niveauForm">
                    <?php if($niveau_a_modifier): ?>
                    <input type="hidden" name="id_approb"
                        value="<?= htmlspecialchars($niveau_a_modifier->id_approb) ?>">
                    <?php endif; ?>

                    <div class="mb-4">
                        <label for="lib_approb" class="block text-sm font-medium text-gray-700 mb-2">Libellé du
                            niveau</label>
                        <input type="text" name="niveaux_approbation" id="lib_approb" required
                            value="<?= $niveau_a_modifier ? htmlspecialchars($niveau_a_modifier->lib_approb) : '' ?>"
                            class="form-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-4 focus:outline-green-300 focus:ring-green-300 focus:border-green-300 focus:ring-opacity-50 transition-all duration-200">
                    </div>

                    <div class="flex justify-between mt-6">
                        <?php if (isset($_GET['id_approb'])): ?>
                        <button type="button" name="btn_annuler" id="btnAnnuler"
                            onclick="window.location.href='?page=parametres_generaux&action=niveaux_approbation'"
                            class="btn-hover px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <i class="fas fa-times mr-2"></i>Annuler
                        </button>
                        <button type="button" id="btnModifier" name="btn_modifier_niveau_approbation"
                            class="btn-hover px-4 py-2 btn-gradient-primary text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <i class="fas fa-save mr-2"></i>Modifier
                            <input type="hidden" name="btn_modifier_niveau_approbation"
                                id="btn_modifier_niveau_approbation_hidden" value="0">
                        </button>
                        <?php else: ?>
                        <div></div>
                        <button type="submit" name="btn_add_niveau_approbation"
                            class="btn-hover px-4 py-2 btn-gradient-primary text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <i class="fas fa-plus mr-2"></i>Ajouter un niveau
                        </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Zone de recherche et actions -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-600 mb-4 flex items-center">
                    <i class="fas fa-list-ul text-green-500 mr-2"></i>
                    Liste des niveaux d'approbation
                </h3>
                <div class="flex items-center justify-between mb-6">
                    <!-- Barre de recherche -->
                    <div class="flex-1 max-w-md">
                        <form action="" method="GET" class="flex gap-3">
                            <input type="hidden" name="page" value="parametres_generaux">
                            <input type="hidden" name="action" value="niveaux_approbation">
                            <div class="relative flex-1">
                                <i
                                    class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" name="search" value="<?= $search ?>" placeholder="Rechercher..."
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

                <!-- Tableau -->
                <div class="overflow-x-auto">
                    <form method="POST" action="?page=parametres_generaux&action=niveaux_approbation"
                        id="formListeNiveaux">
                        <input type="hidden" name="submit_delete_multiple" id="submitDeleteHidden" value="0">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="w-12 px-3 py-3">
                                        <input type="checkbox" id="selectAllCheckbox"
                                            class="rounded border-gray-300 text-green-600 focus:ring-green-500 transition-all duration-200">
                                    </th>
                                    <th
                                        class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-hashtag mr-1"></i>ID
                                    </th>
                                    <th
                                        class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-layer-group mr-1"></i>Niveau
                                    </th>
                                    <th
                                        class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-cog mr-1"></i>Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php if (!empty($listeNiveaux)) : ?>
                                <?php foreach ($listeNiveaux as $niveau) : ?>
                                <tr class="hover:bg-green-50 transition-colors duration-200">
                                    <td class="px-3 py-4">
                                        <input type="checkbox" name="selected_ids[]"
                                            value="<?= htmlspecialchars($niveau->id_approb) ?>"
                                            class="row-checkbox rounded border-gray-300 text-green-600 focus:ring-green-500 transition-all duration-200">
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-900 text-center">
                                        <?= htmlspecialchars($niveau->id_approb) ?>
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-900 font-medium text-center">
                                        <?= htmlspecialchars($niveau->lib_approb) ?>
                                    </td>
                                    <td class="px-3 py-4 text-sm text-center">
                                        <a href="?page=parametres_generaux&action=niveaux_approbation&id_approb=<?= $niveau->id_approb ?>"
                                            class="text-blue-600 hover:text-blue-800 mr-3 transition-colors duration-200">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else : ?>
                                <tr>
                                    <td colspan="4" class="px-3 py-4 text-sm text-gray-500 text-center">
                                        <i class="fas fa-info-circle mr-2"></i>Aucun niveau enregistré.
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <div class="bg-white rounded-lg shadow-sm p-4 mt-6">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-500">
                        Affichage de <?= $offset + 1 ?> à <?= min($offset + $limit, $total_items) ?> sur
                        <?= $total_items ?> entrées
                    </div>
                    <div class="flex flex-wrap justify-center gap-2">
                        <?php if ($page > 1): ?>
                        <a href="?page=parametres_generaux&action=niveaux_approbation&p=<?= $page - 1 ?>&search=<?= urlencode($search) ?>"
                            class="btn-hover px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-chevron-left mr-1"></i>Précédent
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
                        <a href="?page=parametres_generaux&action=niveaux_approbation&p=<?= $i ?>&search=<?= urlencode($search) ?>"
                            class="btn-hover px-3 py-2 <?= $i === $page ? 'btn-gradient-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-50' ?> border border-gray-300 rounded-lg text-sm font-medium">
                            <?= $i ?>
                        </a>
                        <?php endfor;

                        if ($end < $total_pages) {
                            echo '<span class="px-3 py-2 text-gray-500">...</span>';
                        }
                        ?>

                        <?php if ($page < $total_pages): ?>
                        <a href="?page=parametres_generaux&action=niveaux_approbation&p=<?= $page + 1 ?>&search=<?= urlencode($search) ?>"
                            class="btn-hover px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Suivant<i class="fas fa-chevron-right ml-1"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- Modale de confirmation de suppression -->
    <div id="deleteModal"
        class="fixed inset-0 flex items-center justify-center z-50 hidden animate__animated animate__fadeIn">
        <div class="bg-white rounded-lg p-6 max-w-sm w-full mx-4 animate__animated animate__zoomIn">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Confirmation de suppression</h3>
                <p class="text-sm text-gray-500 mb-6">
                    <i class="fas fa-info-circle mr-2"></i>
                    Êtes-vous sûr de vouloir supprimer les niveaux sélectionnés ?
                </p>
                <div class="flex justify-center gap-4">
                    <button type="button" id="confirmDelete"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200">
                        <i class="fas fa-check mr-2"></i>Confirmer
                    </button>
                    <button type="button" id="cancelDelete"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modale de confirmation de modification -->
    <div id="modifyModal"
        class="fixed inset-0 flex items-center justify-center z-50 hidden animate__animated animate__fadeIn">
        <div class="bg-white rounded-lg p-6 max-w-sm w-full mx-4 animate__animated animate__zoomIn">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
                    <i class="fas fa-edit text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Confirmation de modification</h3>
                <p class="text-sm text-gray-500 mb-6">
                    <i class="fas fa-info-circle mr-2"></i>
                    Êtes-vous sûr de vouloir modifier ce niveau ?
                </p>
                <div class="flex justify-center gap-4">
                    <button type="button" id="confirmModify"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                        <i class="fas fa-check mr-2"></i>Confirmer
                    </button>
                    <button type="button" id="cancelModify"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Gestion des checkboxes et du bouton de suppression
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const deleteButton = document.getElementById('deleteSelectedBtn');
    const deleteModal = document.getElementById('deleteModal');
    const confirmDelete = document.getElementById('confirmDelete');
    const cancelDelete = document.getElementById('cancelDelete');
    const formListeNiveaux = document.getElementById('formListeNiveaux');
    const submitDeleteHidden = document.getElementById('submitDeleteHidden');
    const btnModifier = document.getElementById('btnModifier');
    const modifyModal = document.getElementById('modifyModal');
    const confirmModify = document.getElementById('confirmModify');
    const cancelModify = document.getElementById('cancelModify');
    const niveauForm = document.getElementById('niveauForm');
    const submitModifierHidden = document.getElementById('btn_modifier_niveau_approbation_hidden');

    // Initialisation
    updateDeleteButtonState();

    // Select all checkboxes
    selectAllCheckbox.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        updateDeleteButtonState();
    });

    // Update delete button state
    function updateDeleteButtonState() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        deleteButton.disabled = checkedBoxes.length === 0;
    }


    // Checkbox change events
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('row-checkbox')) {
            updateDeleteButtonState();
            const allCheckboxes = document.querySelectorAll('.row-checkbox');
            const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
            selectAllCheckbox.checked = checkedBoxes.length === allCheckboxes.length && allCheckboxes.length >
                0;
        }
    });



    // Gestion de la suppression
    deleteButton?.addEventListener('click', function(e) {
        e.preventDefault();
        deleteModal.classList.remove('hidden');
    });

    confirmDelete?.addEventListener('click', function() {
        submitDeleteHidden.value = '1';
        formListeNiveaux.submit();
    });

    cancelDelete?.addEventListener('click', function() {
        deleteModal.classList.add('hidden');
    });

    // Gestion de la modification
    btnModifier?.addEventListener('click', function() {
        modifyModal.classList.remove('hidden');
    });

    confirmModify?.addEventListener('click', function() {
        submitModifierHidden.value = '1';
        niveauForm.submit();
    });

    cancelModify?.addEventListener('click', function() {
        modifyModal.classList.add('hidden');
    });

    // Fermeture des modales en cliquant en dehors
    window.addEventListener('click', function(e) {
        if (e.target === deleteModal) {
            deleteModal.classList.add('hidden');
        }
        if (e.target === modifyModal) {
            modifyModal.classList.add('hidden');
        }
    });

    // Fonction pour exporter en Excel
    function exportToExcel() {
        const table = document.querySelector('table');
        const rows = Array.from(table.querySelectorAll('tr'));

        // Créer le contenu CSV
        let csvContent = "data:text/csv;charset=utf-8,";

        // Ajouter les en-têtes
        const headers = Array.from(rows[0].querySelectorAll('th'))
            .map(header => header.textContent.trim())
            .filter(header => header !== ''); // Exclure la colonne des checkboxes
        csvContent += headers.join(',') + '\n';

        // Ajouter les données
        rows.slice(1).forEach(row => {
            const cells = Array.from(row.querySelectorAll('td'))
                .slice(1, -1) // Exclure la colonne des checkboxes et des actions
                .map(cell => `"${cell.textContent.trim()}"`);
            csvContent += cells.join(',') + '\n';
        });

        // Créer le lien de téléchargement
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'niveau_approbation.csv');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }


    // Fonction pour imprimer
    function printTable() {
        const table = document.querySelector('table');
        const printWindow = window.open('', '_blank');

        // Créer une copie de la table pour la modification
        const tableClone = table.cloneNode(true);

        // Supprimer les colonnes ID, Actions et Checkboxes
        const rows = tableClone.querySelectorAll('tr');
        rows.forEach(row => {
            // Supprimer la colonne des checkboxes (première colonne)
            const checkboxCell = row.querySelector('th:first-child, td:first-child');
            if (checkboxCell) checkboxCell.remove();

            // Supprimer la colonne ID (maintenant première colonne)
            const idCell = row.querySelector('th:first-child, td:first-child');
            if (idCell) idCell.remove();

            // Supprimer la colonne Actions (dernière colonne)
            const actionCell = row.querySelector('th:last-child, td:last-child');
            if (actionCell) actionCell.remove();
        });

        printWindow.document.write(`
            <html>
                <head>
                    <title>Liste des niveaux d'approbation</title>
                    <style>
                        table { width: 100%; border-collapse: collapse; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        th { background-color: #f5f5f5; }
                        @media print {
                            body { margin: 0; padding: 15px; }
                        }
                    </style>
                </head>
                <body>
                    <h2>Liste des niveaux d'approbation</h2>
                    ${tableClone.outerHTML}
                </body>
            </html>
        `);

        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }


    // Gestion des notifications
    const successNotification = document.getElementById('successNotification');
    const errorNotification = document.getElementById('errorNotification');

    if (successNotification) {
        setTimeout(() => {
            successNotification.style.animation = 'fadeOut 0.5s ease-out forwards';
            setTimeout(() => successNotification.remove(), 500);
        }, 3000);
    }

    if (errorNotification) {
        setTimeout(() => {
            errorNotification.style.animation = 'fadeOut 0.5s ease-out forwards';
            setTimeout(() => errorNotification.remove(), 500);
        }, 3000);
    }
    </script>
</body>

</html>