<?php
$statut_a_modifier = $GLOBALS['statut_a_modifier'] ?? null;

// Pagination
$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

// Filter the list based on search
$listeStatuts = $GLOBALS['listeStatuts'] ?? [];
if (!empty($search)) {
    $listeStatuts = array_filter($listeStatuts, function($statut) use ($search) {
        return stripos($statut->lib_jury, $search) !== false;
    });
}

// Total pages calculation
$total_items = count($listeStatuts);
$total_pages = ceil($total_items / $limit);

// Slice the array for pagination
$listeStatuts = array_slice($listeStatuts, $offset, $limit);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du statut des jury</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>

<body class="bg-gray-100">
    <!-- Notification Toast -->
    <div id="notification" class="fixed top-4 right-4 z-50 hidden">
        <div class="max-w-md bg-white rounded-lg shadow-lg">
            <div class="p-4 flex items-center">
                <div class="flex-shrink-0" id="notificationIcon"></div>
                <div class="ml-3 w-0 flex-1">
                    <p class="text-sm font-medium text-gray-900" id="notificationMessage"></p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button onclick="hideNotification()" class="inline-flex text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                <h3 class="text-base font-semibold leading-6 text-gray-900">Confirmer la suppression</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Êtes-vous sûr de vouloir supprimer ces statuts de jury ? Cette action est irréversible.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" id="confirmDelete" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Supprimer</button>
                        <button type="button" onclick="hideModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Annuler</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="min-h-screen flex flex-col">
        <main class="flex-grow container mx-auto px-4 py-8">
            <div class="mb-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <h2 class="text-2xl font-bold text-gray-700">
                        <i class="fas fa-gavel mr-2 text-green-600"></i>
                        Gestion du statut des jury
                    </h2>
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <form action="" method="GET" class="flex gap-3">
                                <input type="hidden" name="page" value="parametres_generaux">
                                <input type="hidden" name="action" value="statut_jury">
                                <div class="relative">
                                    <input type="text" name="search" value="<?= $search ?>" placeholder="Rechercher un statut..."
                                        class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600">
                                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </form>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="exportToExcel()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-all duration-300 hover:scale-105">
                                <i class="fas fa-file-excel mr-2"></i>Exporter
                            </button>
                            <button onclick="printTable()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform transition-all duration-300 hover:scale-105">
                                <i class="fas fa-print mr-2"></i>Imprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulaire d'Ajout ou de Modification -->
            <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8 transform transition-all duration-300 hover:shadow-xl">
                <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b pb-3">
                    <i class="fas <?= isset($_GET['id_statut_jury']) ? 'fa-edit text-blue-500' : 'fa-plus-circle text-green-500' ?> mr-2"></i>
                    <?php if (isset($_GET['id_statut_jury'])): ?>
                        Modifier le statut du jury
                    <?php else: ?>
                        Ajouter un nouveau statut du jury
                    <?php endif; ?>
                </h3>
                <form method="POST" action="?page=parametres_generaux&action=statut_jury" id="statutJuryForm" class="space-y-6">
                    <?php if ($statut_a_modifier): ?>
                        <input type="hidden" name="id_statut_jury" value="<?= htmlspecialchars($statut_a_modifier->id_jury) ?>">
                    <?php endif; ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Libellé du statut du jury</label>
                            <input type="text" name="statut_jury" required
                                value="<?= $statut_a_modifier ? htmlspecialchars($statut_a_modifier->lib_jury) : '' ?>"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-all"
                                placeholder="Entrez le libellé du statut">
                            <p class="mt-1 text-sm text-gray-500">Le libellé doit être unique et descriptif</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 mt-6">
                        <?php if (isset($_GET['id_statut_jury'])): ?>
                            <button type="submit" name="btn_add_statut_jury"
                                class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform transition-all duration-300 hover:scale-105">
                                <i class="fas fa-save mr-2"></i>Modifier
                            </button>
                            <button type="submit" name="btn_annuler"
                                class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-orange-500 hover:bg-orange-600 focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transform transition-all duration-300 hover:scale-105">
                                <i class="fas fa-times mr-2"></i>Annuler
                            </button>
                        <?php else: ?>
                            <button type="submit" name="btn_add_statut_jury"
                                class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-all duration-300 hover:scale-105">
                                <i class="fas fa-plus mr-2"></i>Ajouter
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Section Tableau -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <form method="POST" action="?page=parametres_generaux&action=statut_jury" id="formListeStatutJury">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="w-12 px-4 py-3 text-center">
                                        <input type="checkbox" id="selectAllCheckbox"
                                            class="form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500 transition-colors">
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-hashtag mr-1"></i>ID
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-gavel mr-1"></i>Statut
                                    </th>
                                    <th scope="col" class="w-20 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-cog mr-1"></i>Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="statutJuryTableBody">
                                <?php if (!empty($listeStatuts)) : ?>
                                    <?php foreach ($listeStatuts as $statut) : ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 whitespace-nowrap text-center">
                                                <input type="checkbox" name="selected_ids[]" value="<?= htmlspecialchars($statut->id_jury) ?>"
                                                    class="row-checkbox form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500 transition-colors">
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <?= htmlspecialchars($statut->id_jury) ?>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                                <?= htmlspecialchars($statut->lib_jury) ?>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-center">
                                                <a href="?page=parametres_generaux&action=statut_jury&id_statut_jury=<?= $statut->id_jury ?>"
                                                   class="text-orange-500 hover:text-orange-600 transition-colors">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">
                                            <i class="fas fa-info-circle mr-2"></i>Aucun statut de jury enregistré.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

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
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    <?php if ($page > 1): ?>
                                        <a href="?page=parametres_generaux&action=statut_jury&p=<?= $page - 1 ?>&search=<?= urlencode($search) ?>"
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
                                        <a href="?page=parametres_generaux&action=statut_jury&p=<?= $i ?>&search=<?= urlencode($search) ?>"
                                           class="relative inline-flex items-center px-4 py-2 border <?= $i === $page ? 'bg-green-50 text-green-600 border-green-500' : 'bg-white text-gray-500 hover:bg-gray-50 border-gray-300' ?>">
                                            <?= $i ?>
                                        </a>
                                    <?php endfor;

                                    if ($end < $total_pages) {
                                        echo '<span class="px-3 py-2 text-gray-500">...</span>';
                                    }
                                    ?>

                                    <?php if ($page < $total_pages): ?>
                                        <a href="?page=parametres_generaux&action=statut_jury&p=<?= $page + 1 ?>&search=<?= urlencode($search) ?>"
                                           class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    <?php endif; ?>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Actions Buttons -->
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="button" id="deleteSelectedBtn"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-trash-alt mr-2"></i>Supprimer la sélection
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
    // Notification System
    function showNotification(message, type = 'success') {
        const notification = document.getElementById('notification');
        const notificationMessage = document.getElementById('notificationMessage');
        const notificationIcon = document.getElementById('notificationIcon');
        
        notificationMessage.textContent = message;
        
        if (type === 'success') {
            notificationIcon.innerHTML = '<i class="fas fa-check-circle text-green-500"></i>';
        } else {
            notificationIcon.innerHTML = '<i class="fas fa-exclamation-circle text-red-500"></i>';
        }
        
        notification.classList.remove('hidden');
        notification.classList.add('animate-fade-in');
        
        setTimeout(() => {
            hideNotification();
        }, 5000);
    }

    function hideNotification() {
        const notification = document.getElementById('notification');
        notification.classList.add('animate-fade-out');
        setTimeout(() => {
            notification.classList.add('hidden');
            notification.classList.remove('animate-fade-out');
        }, 300);
    }

    // Select All Functionality
    document.getElementById('selectAllCheckbox').addEventListener('change', function(e) {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = e.target.checked;
        });
        updateDeleteButton();
    });

    // Update delete button state
    function updateDeleteButton() {
        const selectedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
        const deleteButton = document.getElementById('deleteSelectedBtn');
        deleteButton.disabled = selectedCheckboxes.length === 0;
    }

    // Add change event listener to all checkboxes
    document.querySelectorAll('.row-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateDeleteButton);
    });

    // Initialize delete button state
    updateDeleteButton();

    // Confirmation Modal
    function showModal() {
        document.getElementById('confirmationModal').classList.remove('hidden');
    }

    function hideModal() {
        document.getElementById('confirmationModal').classList.add('hidden');
    }

    // Delete button click handler
    document.getElementById('deleteSelectedBtn').addEventListener('click', function(e) {
        e.preventDefault();
        showModal();
    });

    // Confirm delete handler
    document.getElementById('confirmDelete').addEventListener('click', function() {
        document.getElementById('formListeStatutJury').submit();
    });

    // Export to Excel
    function exportToExcel() {
        // Créer un CSV à partir des données du tableau
        let csv = [];
        const rows = document.querySelectorAll('table tr');

        rows.forEach(row => {
            const cols = row.querySelectorAll('td, th');
            const rowData = Array.from(cols)
                .map(col => col.textContent.trim())
                .filter((col, index) => index !== 0 && index !== 3); // Exclure la colonne checkbox et actions
            if (rowData.length > 0) {
                csv.push(rowData.join(','));
            }
        });

        // Créer et télécharger le fichier CSV
        const csvContent = "data:text/csv;charset=utf-8," + csv.join('\n');
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "statuts_jury.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        showNotification('Export Excel effectué avec succès', 'success');
    }

    // Print Table
    function printTable() {
        window.print();
    }

    // Form Validation
    document.getElementById('statutJuryForm').addEventListener('submit', function(e) {
        const statutInput = this.querySelector('input[name="statut_jury"]');
        if (!statutInput.value.trim()) {
            e.preventDefault();
            showNotification('Le libellé du statut est requis.', 'error');
        }
    });

    // Show success/error messages from PHP if they exist
    <?php if (isset($_SESSION['success_message'])): ?>
        showNotification("<?= htmlspecialchars($_SESSION['success_message']) ?>", 'success');
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        showNotification("<?= htmlspecialchars($_SESSION['error_message']) ?>", 'error');
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    </script>

    <style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-10px); }
    }

    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }

    .animate-fade-out {
        animation: fadeOut 0.3s ease-out forwards;
    }

    @media print {
        .no-print {
            display: none;
        }
        
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

    /* Animations et transitions */
    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }

    .hover\:scale-105:hover {
        transform: scale(1.05);
    }

    /* Style pour le hover des lignes du tableau */
    .hover\:bg-gray-50:hover {
        background-color: #f9fafb;
    }

    /* Style pour les checkboxes */
    .form-checkbox:checked {
        background-color: #22c55e;
        border-color: #22c55e;
    }

    /* Style pour la pagination active */
    .bg-green-50 {
        background-color: #f0fdf4;
    }
    </style>
</body>
</html>