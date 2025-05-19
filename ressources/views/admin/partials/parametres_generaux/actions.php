<?php
$action_a_modifier = $GLOBALS['action_a_modifier'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des actions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Le CSS Tailwind est supposé être chargé par le layout principal -->
</head>

<body class="bg-gray-100">
<div class="min-h-screen flex flex-col">
    <main class="flex-grow container mx-auto px-4 py-5">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-700">Gestion des actions</h2>
        </div>

        <!-- Formulaire d'Ajout ou de Modification -->
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b pb-3">
                <?php if (isset($_GET['id_action'])): ?>
                    Modifier l'action
                <?php else: ?>
                    Ajouter une nouvelle action
                <?php endif; ?>
            </h3>
            <form method="POST" action="?page=parametres_generaux&action=actions">
                <?php if ($action_a_modifier): ?>
                    <input type="hidden" name="id_action" value="<?= htmlspecialchars($action_a_modifier->id_action) ?>">
                <?php endif; ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-3 outline-none">Libellé de l'action</label>
                        <input type="text" id="actions" name="action" required
                               value="<?= $action_a_modifier ? htmlspecialchars($action_a_modifier->lib_action) : '' ?>"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 focus:border-0 transition-colors focus:outline-none">
                    </div>
                </div>

                <?php if (isset($_GET['id_action'])): ?>
                    <div class="flex justify-start space-x-3">
                        <button type="button" id="btnModifier"
                                class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-500 focus:ring-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Modifier l'action
                        </button>
                        <button type="submit" name="btn_annuler"
                                class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-orange-500 hover:bg-orange-600 focus:ring-orange-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </button>
                        <input type="hidden" name="btn_modifier_action" id="btn_modifier_action_hidden" value="">
                    </div>
                <?php else: ?>
                    <div class="flex justify-start space-x-3">
                        <button type="submit" name="btn_add_action"
                                class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600 focus:ring-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter l'action
                        </button>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <!-- Section Tableau et Actions (si on n'est pas en mode édition) -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Liste des actions</h3>
            <form method="POST" action="?page=parametres_generaux&action=actions" id="formListeActions">
                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Table avec largeur fixe -->
                    <div style="width: 80%;"
                         class="border border-collapse border-gray-200 bg-white rounded-xl shadow-lg overflow-hidden mb-6 lg:mb-0">
                        <div class="overflow-x-auto w-full">
                            <table class="w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="w-[5%] px-4 py-3 text-center">
                                        <input type="checkbox" id="selectAllCheckbox"
                                               class="form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                    </th>
                                    <th scope="col"
                                        class="w-[10%] px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="w-[25%] px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Libellé de l'action
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <?php $listeActions = $GLOBALS['listeActions'] ?? []; ?>
                                <?php if (!empty($listeActions)) : ?>
                                    <?php foreach ($listeActions as $action) : ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 whitespace-nowrap text-center">
                                                <input type="checkbox" name="selected_ids[]" value="<?= htmlspecialchars($action->id_action) ?>"
                                                       class="row-checkbox form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <?= htmlspecialchars($action->id_action) ?>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                                <?= htmlspecialchars($action->lib_action) ?>
                                            </td>
                                            <td class="px-4 py-3 text-left whitespace-nowrap text-sm text-gray-500 text-center">
                                                <a href="?page=parametres_generaux&action=actions&id_action=<?= $action->id_action ?>"
                                                   class="text-center text-orange-500 hover:underline"><i
                                                            class="fas fa-pen"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-sm text-gray-500 py-4">
                                            Aucune action enregistrée.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Boutons avec largeur fixe -->
                    <div style="width: 10%;" class="flex flex-col gap-4 justify-center">
                        <button type="button" id="deleteSelectedBtn"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            <i class="fas fa-trash-alt mr-2"></i>Supprimer
                        </button>
                        <input type="hidden" name="submit_delete_multiple" id="submitDeleteHidden" value="0">
                    </div>
                </div>
            </form>
        </div>
        <div id="deleteModal" class="fixed inset-0 bg-gray-500  bg-opacity-75 flex items-center justify-center z-50 hidden">
            <div class="bg-white shadow-sm  rounded-lg p-6 max-w-md w-full mx-4">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Confirmation de suppression</h3>
                    <p class="text-sm text-gray-500 mb-4">
                        Êtes-vous sûr de vouloir supprimer les actions sélectionnées ? Cette action est irréversible.
                    </p>
                    <div class="mt-5 flex justify-center gap-6">
                        <button type="button" id="confirmDelete"
                                class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Confirmer
                        </button>
                        <button type="button" id="cancelDelete"
                                class="inline-flex justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modale de confirmation de modification -->
        <div id="modifyModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
            <div class="bg-white shadow-sm rounded-lg p-6 max-w-md w-full mx-4">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
                        <i class="fas fa-edit text-blue-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Confirmation de modification</h3>
                    <p class="text-sm text-gray-500 mb-4">
                        Êtes-vous sûr de vouloir modifier cette action ?
                    </p>
                    <div class="mt-5 flex justify-center gap-6">
                        <button type="button" id="confirmModify"
                                class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Confirmer
                        </button>
                        <button type="button" id="cancelModify"
                                class="inline-flex justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script>
    // Gestion des checkboxes et du bouton de suppression
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const deleteButton = document.getElementById('deleteSelectedBtn');
    const deleteModal = document.getElementById('deleteModal');
    const confirmDelete = document.getElementById('confirmDelete');
    const cancelDelete = document.getElementById('cancelDelete');
    const formListeActions = document.getElementById('formListeActions');
    const submitDeleteHidden = document.getElementById('submitDeleteHidden');

    // Modale de modification
    const btnModifier = document.getElementById('btnModifier');
    const modifyModal = document.getElementById('modifyModal');
    const confirmModify = document.getElementById('confirmModify');
    const cancelModify = document.getElementById('cancelModify');
    const actionForm = document.querySelector('form[action="?page=parametres_generaux&action=actions"]');
    const submitModifierHidden = document.getElementById('btn_modifier_action_hidden');

    // Initialisation de l'état du bouton supprimer
    updateDeleteButtonState();

    // Select all checkboxes
    selectAllCheckbox.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateDeleteButtonState();
    });

    // Update delete button state
    function updateDeleteButtonState() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        deleteButton.disabled = checkedBoxes.length === 0;
        deleteButton.classList.toggle('opacity-50', checkedBoxes.length === 0);
        deleteButton.classList.toggle('cursor-not-allowed', checkedBoxes.length === 0);
    }

    // Event listener for checkbox changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('row-checkbox')) {
            updateDeleteButtonState();
            const allCheckboxes = document.querySelectorAll('.row-checkbox');
            const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
            selectAllCheckbox.checked = checkedBoxes.length === allCheckboxes.length && allCheckboxes.length > 0;
        }
    });

    // Afficher la modale de suppression
    if (deleteButton) {
        deleteButton.addEventListener('click', function() {
            if (!this.disabled) {
                deleteModal.classList.remove('hidden');
            }
        });
    }

    // Confirmer la suppression
    confirmDelete.addEventListener('click', function() {
        submitDeleteHidden.value = '1';
        formListeActions.submit();
    });

    // Annuler la suppression
    cancelDelete.addEventListener('click', function() {
        deleteModal.classList.add('hidden');
    });

    // Afficher la modale de modification
    if (btnModifier) {
        btnModifier.addEventListener('click', function() {
            modifyModal.classList.remove('hidden');
        });
    }

    // Confirmer la modification
    if (confirmModify) {
        confirmModify.addEventListener('click', function() {
            submitModifierHidden.value = '1';
            actionForm.submit();
        });
    }

    // Annuler la modification
    if (cancelModify) {
        cancelModify.addEventListener('click', function() {
            modifyModal.classList.add('hidden');
        });
    }
</script>
</body>

</html>