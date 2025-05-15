<?php
$grade_a_modifier = $GLOBALS['grade_a_modifier'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des grades</title>
</head>

<body class="bg-gray-100">
<div class="min-h-screen flex flex-col">
    <main class="flex-grow container mx-auto px-4 py-5">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-700">Gestion des grades</h2>
        </div>
        <!-- À placer avant ou au début de votre formulaire -->
        <?php if (!empty($GLOBALS['messageErreur'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($GLOBALS['messageErreur']); ?></span>
            </div>
        <?php endif; ?>
        <!-- À placer avant ou au début de votre formulaire -->
        <?php if (!empty($GLOBALS['messageSucces'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                 role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($GLOBALS['messageSucces']); ?></span>
            </div>
        <?php endif; ?>

        <!-- Formulaire d'Ajout ou de Modification -->
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b pb-3">
                <?php if (isset($_GET['id_grade'])): ?>
                    Modifier le grade
                <?php else: ?>
                    Ajouter un nouveau grade
                <?php endif; ?>
            </h3>
            <form method="POST" action="?page=parametres_generaux&action=grades" id="gradeForm">
                <?php if ($grade_a_modifier): ?>
                    <input type="hidden" name="id_grade" value="<?= htmlspecialchars($grade_a_modifier->id_grade) ?>">
                <?php endif; ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-3 outline-none">Libellé du
                            grade</label>
                        <input type="text" id="grades" name="grades" required
                               value="<?= $grade_a_modifier ? htmlspecialchars($grade_a_modifier->lib_grade) : '' ?>"
                               class=" w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 focus:border-0 transition-colors focus:outline-none">
                    </div>

                </div>
                <div class="flex justify-between">
                    <?php if (isset($_GET['id_grade'])): ?>

                        <button type="submit" name="btn_annuler"
                                class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white   bg-orange-500 hover:bg-orange-600 focus:ring-orange-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </button>
                        <button type="submit" id="btnModifier"
                                class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-500 focus:ring-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Modifier le grade
                        </button>
                        <input type="hidden" id="submitModifierHidden" value="0">
                    <?php else: ?>
                        <button type="submit" name="btn_add_grades"
                                class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600 focus:ring-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                            <i class="fa-plus fas mr-2"></i>
                            Ajouter le grade
                        </button>
                    <?php endif; ?>
                </div>


            </form>
        </div>

        <!-- Section Tableau et Actions (si on n'est pas en mode édition) -->

        <div class="mt-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Liste des grades</h3>
            <form method="POST" action="?page=parametres_generaux&action=grades" id="formListeGrades">
                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Table avec largeur fixe -->
                    <div style="width: 80%;"
                         class="border border-collapse border-gray-200 bg-white rounded-xl shadow-lg overflow-hidden mb-6 lg:mb-0">
                        <div class="overflow-x-auto w-full">
                            <table class="w-full divide-y divide-gray-200 text-center">
                                <thead class="bg-gray-50 text-center">
                                <tr>
                                    <th scope="col" class="w-[5%] px-4 py-3 text-center">
                                        <input type="checkbox" id="selectAllCheckbox"
                                               class="form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                    </th>
                                    <th scope="col"
                                        class="w-[25%] px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Libellé du grade
                                    </th>
                                    <th scope="col"
                                        class="w-[25%] px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <?php $listeGrade = $GLOBALS['listeGrade'] ?? []; ?>
                                <?php if (!empty($listeGrade)) : ?>
                                    <?php foreach ($listeGrade as $grade) : ?>
                                        <tr class="hover:bg-gray-50 transition-colors text-center">
                                            <td class="px-4 py-3 whitespace-nowrap ">
                                                <input type="checkbox" name="selected_ids[]"
                                                       value="<?= htmlspecialchars($grade->id_grade) ?>"
                                                       class="text-center row-checkbox form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 text-center">
                                                <?= htmlspecialchars($grade->lib_grade) ?>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-center">
                                                <a href="?page=parametres_generaux&action=grades&id_grade=<?= $grade->id_grade ?>"
                                                   class="text-center text-orange-500 hover:underline"><i
                                                            class="fas fa-pen"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-sm text-gray-500 py-4">
                                            Aucun grade enregistrée.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Boutons avec largeur fixe -->
                    <div style="width: 10%;" class="flex justify-center items-center mb-6 lg:mb-0">
                        <button type="submit" id="deleteSelectedBtn"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            <i class="fas fa-trash-alt mr-2"></i>Supprimer
                        </button>
                        <input type="hidden" name="submit_delete_multiple" id="submitDeleteHidden" value="0">
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<!-- Modale de confirmation de suppression -->
<div id="deleteModal" class="fixed inset-0 bg-gray-500  bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white shadow-sm  rounded-lg p-6 max-w-md w-full mx-4">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Confirmation de suppression</h3>
            <p class="text-sm text-gray-500 mb-4">
                Êtes-vous sûr de vouloir supprimer les années académiques sélectionnées ? Cette action est
                irréversible.
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
                Êtes-vous sûr de vouloir modifier cette année académique ?
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


<script>
    // Gestion des checkboxes et du bouton de suppression
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const deleteButton = document.getElementById('deleteSelectedBtn');
    const deleteModal = document.getElementById('deleteModal');
    const confirmDelete = document.getElementById('confirmDelete');
    const cancelDelete = document.getElementById('cancelDelete');
    const formListeGrades = document.getElementById('formListeGrades');
    const submitDeleteHidden = document.getElementById('submitDeleteHidden');

    // Modale de modification
    const btnModifier = document.getElementById('btnModifier');
    const modifyModal = document.getElementById('modifyModal');
    const confirmModify = document.getElementById('confirmModify');
    const cancelModify = document.getElementById('cancelModify');
    const gradeForm = document.getElementById('gradeForm');
    const submitModifierHidden = document.getElementById('submitModifierHidden');


    // Initialisation de l'état du bouton supprimer
    updateDeleteButtonState();

    // Select all checkboxes
    selectAllCheckbox.addEventListener('change', function () {
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
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('row-checkbox')) {
            updateDeleteButtonState();
            // Also update the "select all" checkbox
            const allCheckboxes = document.querySelectorAll('.row-checkbox');
            const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
            selectAllCheckbox.checked = checkedBoxes.length === allCheckboxes.length && allCheckboxes.length >
                0;
        }
    });

    // Afficher la modale de suppression
    if (deleteButton) {
        deleteButton.addEventListener('click', function () {

            if (!this.disabled) {
                deleteModal.classList.remove('hidden');
            }
        });
    }

    // Confirmer la suppression
    confirmDelete.addEventListener('click', function () {
        submitDeleteHidden.value = '1';
        formListeGrades.submit();
    });

    // Annuler la suppression
    cancelDelete.addEventListener('click', function () {
        deleteModal.classList.add('hidden');
    });

    // Afficher la modale de modification
    if (btnModifier) {
        btnModifier.addEventListener('click', function () {

            modifyModal.classList.remove('hidden');
        });
    }

    // Confirmer la modification
    confirmModify.addEventListener('click', function () {
        submitModifierHidden.value = '1';
        gradeForm.submit();
    });

    // Annuler la modification
    cancelModify.addEventListener('click', function () {
        modifyModal.classList.add('hidden');
    });
</script>

</body>

</html>