<?php
$specialite_a_modifier = $GLOBALS['specialite_a_modifier'] ?? null;

// Pagination
$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';

// Filter the list based on search
$listeSpecialites = $GLOBALS['listeSpecialites'] ?? [];
if (!empty($search)) {
    $listeSpecialites = array_filter($listeSpecialites, function($specialite) use ($search) {
        return stripos($specialite->lib_specialite, $search) !== false;
    });
}

// Total pages calculation
$total_items = count($listeSpecialites);
$total_pages = ceil($total_items / $limit);

// Slice the array for pagination
$listeSpecialites = array_slice($listeSpecialites, $offset, $limit);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Spécialités</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
    .animate__animated {
        animation-duration: 0.3s;
    }

    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }

    .form-input:focus {
        border-color: #22c55e;
        box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
        background-color: #f0fdf4;
    }

    .table-row:hover {
        background-color: #f0fdf4;
    }

    input[type="checkbox"]:checked {
        background-color: #22c55e;
        border-color: #22c55e;
    }
    </style>
</head>

<body>
    <div class="min-h-screen">
        <main class="container mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-600">
                    <i class="fas fa-graduation-cap mr-2 text-green-600"></i>
                    Gestion des Spécialités
                </h2>
            </div>

            <!-- Formulaire -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-600 mb-4 flex items-center">
                    <i
                        class="fas <?= isset($_GET['id_specialite']) ? 'fa-edit text-green-500' : 'fa-plus-circle text-green-500' ?> mr-2"></i>
                    <?php if(isset($_GET['id_specialite'])): ?>
                    Modifier la spécialité
                    <?php else: ?>
                    Ajouter une spécialité
                    <?php endif;?>
                </h3>

                <form method="POST" action="?page=parametres_generaux&action=specialites" id="specialiteForm"
                    class="space-y-6">
                    <?php if ($specialite_a_modifier): ?>
                    <input type="hidden" name="id_specialite"
                        value="<?= htmlspecialchars($specialite_a_modifier->id_specialite) ?>">
                    <?php endif; ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Libellé de la spécialité</label>
                            <input type="text" name="specialite" required
                                value="<?= $specialite_a_modifier ? htmlspecialchars($specialite_a_modifier->lib_specialite) : '' ?>"
                                class="form-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-4 focus:outline-green-300 focus:ring-green-300 focus:border-green-300 focus:ring-opacity-50 transition-all duration-200"
                                placeholder="Entrez le libellé de la spécialité">
                        </div>
                    </div>

                    <div>
                        <?php if(isset($_GET['id_specialite'])): ?>
                        <button type="submit" name="btn_annuler"
                            class="btn-hover px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <i class="fas fa-times mr-2"></i>Annuler
                        </button>
                        <button type="submit" name="btn_add_specialite"
                            class="btn-hover px-4 py-2 btn-gradient-primary text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <i class="fas fa-save mr-2"></i>Modifier
                        </button>
                        <?php else: ?>
                        <div></div>
                        <button type="submit" name="btn_add_specialite"
                            class="btn-hover px-4 py-2 btn-gradient-primary text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <i class="fas fa-plus mr-2"></i>Ajouter une spécialité
                        </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Zone de recherche et actions -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <!-- Barre de recherche -->
                    <div class="flex-1 max-w-md">
                        <form action="" method="GET" class="flex gap-3">
                            <input type="hidden" name="page" value="parametres_generaux">
                            <input type="hidden" name="action" value="specialites">
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
                    <!-- Bouton de suppression multiple -->
                    <div class="flex items-center space-x-4">
                        <button id="deleteSelectedBtn" disabled
                            class="btn-hover px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200">
                            <i class="fas fa-trash-alt mr-2"></i>Supprimer la sélection
                        </button>
                    </div>
                </div>

                <!-- Tableau -->
                <div class="overflow-x-auto">
                    <form method="POST" action="?page=parametres_generaux&action=specialites" id="formListeSpecialites">
                        <input type="hidden" name="submit_delete_multiple" id="submitDeleteHidden" value="0">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="w-12 px-3 py-3">
                                        <input type="checkbox" id="selectAllCheckbox"
                                            class="rounded border-gray-300 text-green-600 focus:ring-green-500 transition-all duration-200">
                                    </th>
                                    <th
                                        class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-graduation-cap mr-1"></i>Spécialité
                                    </th>
                                    <th
                                        class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-cog mr-1"></i>Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php if (!empty($listeSpecialites)) : ?>
                                <?php foreach ($listeSpecialites as $specialite) : ?>
                                <tr class="hover:bg-green-50 transition-colors duration-200">
                                    <td class="px-3 py-4">
                                        <input type="checkbox" name="selected_ids[]"
                                            value="<?= htmlspecialchars($specialite->id_specialite) ?>"
                                            class="row-checkbox text-center rounded border-gray-300 text-green-600 focus:ring-green-500 transition-all duration-200">
                                    </td>
                                    <td class="px-3 py-4 text-sm text-gray-900">
                                        <?= htmlspecialchars($specialite->lib_specialite) ?>
                                    </td>
                                    <td class="px-3 py-4 text-sm text-center">
                                        <a href="?page=parametres_generaux&action=specialites&id_specialite=<?= $specialite->id_specialite ?>"
                                            class="text-blue-600 hover:text-blue-800 mr-3 transition-colors duration-200">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else : ?>
                                <tr>
                                    <td colspan="3" class="px-3 py-4 text-sm text-gray-500 text-center">
                                        <i class="fas fa-info-circle mr-2"></i>Aucune spécialité enregistrée.
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
                        <a href="?page=parametres_generaux&action=specialites&p=<?= $page - 1 ?>&search=<?= urlencode($search) ?>"
                            class="btn-hover px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-chevron-left mr-1"></i>Précédent
                        </a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=parametres_generaux&action=specialites&p=<?= $i ?>&search=<?= urlencode($search) ?>"
                            class="btn-hover px-3 py-2 <?= $i === $page ? 'bg-green-500 text-white' : 'bg-white text-gray-700 border border-gray-300' ?> rounded-lg text-sm font-medium hover:bg-gray-50">
                            <?= $i ?>
                        </a>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                        <a href="?page=parametres_generaux&action=specialites&p=<?= $page + 1 ?>&search=<?= urlencode($search) ?>"
                            class="btn-hover px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Suivant<i class="fas fa-chevron-right ml-1"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Modal de confirmation -->
            <div id="confirmationModal"
                class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3 text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                            <i class="fas fa-exclamation-triangle text-red-600"></i>
                        </div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Confirmation de suppression</h3>
                        <div class="mt-2 px-7 py-3">
                            <p class="text-sm text-gray-500">
                                Êtes-vous sûr de vouloir supprimer les spécialités sélectionnées ?
                            </p>
                        </div>
                        <div class="items-center px-4 py-3">
                            <button id="confirmDelete"
                                class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                                Confirmer
                            </button>
                            <button onclick="hideModal()"
                                class="ml-3 px-4 py-2 bg-gray-100 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Annuler
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
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

    // Modal functions
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
        document.getElementById('submitDeleteHidden').value = '1';
        document.getElementById('formListeSpecialites').submit();
    });
    </script>
</body>

</html>