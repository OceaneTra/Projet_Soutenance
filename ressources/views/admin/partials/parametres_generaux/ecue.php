<?php
    $ecue_a_modifier = $GLOBALS['ecue_a_modifier'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Éléments constitutifs (ECUE)</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
</head>

<body class="bg-gray-100">
    <!-- Toast Container -->
    <div id="toastContainer" class="fixed top-4 right-4 z-50"></div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-8 max-w-md mx-auto">
            <h3 class="text-xl font-bold mb-4">Confirmation de suppression</h3>
            <p class="text-gray-600 mb-6">Êtes-vous sûr de vouloir supprimer ces éléments ? Cette action est
                irréversible.</p>
            <div class="flex justify-end space-x-4">
                <button id="cancelDelete"
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                    Annuler
                </button>
                <button id="confirmDelete"
                    class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition-colors">
                    Confirmer
                </button>
            </div>
        </div>
    </div>

    <div class="min-h-screen flex flex-col">
        <main class="flex-grow container mx-auto px-4 py-8">
            <!-- Header Section -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-gray-700">Gestion des Éléments constitutifs (ECUE)</h2>
                    <div class="flex space-x-3">
                        <button id="exportExcel"
                            class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                            <i class="fas fa-file-excel mr-2"></i> Exporter
                        </button>
                        <button id="printTable"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-print mr-2"></i> Imprimer
                        </button>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="relative mb-4">
                    <input type="text" id="searchInput" placeholder="Rechercher un ECUE..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <!-- Form Section with Animation -->
            <div
                class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8 transform transition-all duration-300 hover:shadow-xl">
                <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b pb-3">
                    <?= isset($_GET['id_ecue']) ? "Modifier l'élément constitutif (ECUE)" : "Ajouter un nouvel élément constitutif (ECUE)" ?>
                </h3>

                <form method="POST" action="?page=parametres_generaux&action=ecue" id="ecueForm" class="space-y-6">
                    <?php if($ecue_a_modifier): ?>
                    <input type="hidden" name="id_ecue" value="<?= htmlspecialchars($ecue_a_modifier->id_ecue) ?>">
                    <?php endif ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Unités d'Enseignement(UE) -->
                        <div class="form-group">
                            <label for="ue" class="block text-sm font-medium text-gray-700 mb-1">
                                Unité d'Enseignement (UE) <span class="text-red-500">*</span>
                            </label>
                            <select id="ue" name="ue" required onchange="remplirInfosUE()"
                                class="form-select w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">Sélectionnez une UE</option>
                                <?php foreach ($GLOBALS['listeUes'] as $ue): ?>
                                <option value="<?= $ue->id_ue ?>"
                                    data-semestre="<?= htmlspecialchars($ue->lib_semestre) ?>"
                                    data-niveau="<?= htmlspecialchars($ue->lib_niv_etude) ?>"
                                    data-annee="<?= htmlspecialchars($ue->id_annee_academique) ?>"
                                    <?= ($ecue_a_modifier && $ecue_a_modifier->id_ue == $ue->id_ue) ? 'selected' : '' ?>>
                                    <?= $ue->lib_ue ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="text-red-500 text-sm mt-1 hidden" id="ue-error"></div>
                        </div>

                        <!-- Libellé ECUE -->
                        <div class="form-group">
                            <label for="lib_ecue" class="block text-sm font-medium text-gray-700 mb-1">
                                Libellé de l'ECUE <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="lib_ecue" name="lib_ecue" required
                                value="<?= $ecue_a_modifier ? htmlspecialchars($ecue_a_modifier->lib_ecue) : '' ?>"
                                placeholder="Ex: Mathématiques fondamentales"
                                class="form-input w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <div class="text-red-500 text-sm mt-1 hidden" id="lib_ecue-error"></div>
                        </div>

                        <!-- Crédits -->
                        <div class="form-group">
                            <label for="credits" class="block text-sm font-medium text-gray-700 mb-1">
                                Nombre de crédits <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="credits" name="credits" required min="1" max="9"
                                value="<?= $ecue_a_modifier ? htmlspecialchars($ecue_a_modifier->credit) : '' ?>"
                                placeholder="Ex: 6"
                                class="form-input w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <div class="text-red-500 text-sm mt-1 hidden" id="credits-error"></div>
                        </div>

                        <!-- Semestre -->
                        <div class="form-group">
                            <label for="semestre" class="block text-sm font-medium text-gray-700 mb-1">
                                Semestre
                            </label>
                            <input type="text" id="semestre" name="semestre" readonly
                                value="<?= $ecue_a_modifier ? htmlspecialchars($ecue_a_modifier->lib_semestre) : '' ?>"
                                class="form-input w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm bg-gray-50">
                        </div>

                        <!-- Niveau d'étude -->
                        <div class="form-group">
                            <label for="niveau_etude" class="block text-sm font-medium text-gray-700 mb-1">
                                Niveau d'étude
                            </label>
                            <input type="text" id="niveau_etude" name="niveau_etude" readonly
                                value="<?= $ecue_a_modifier ? htmlspecialchars($ecue_a_modifier->lib_niv_etude) : '' ?>"
                                class="form-input w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm bg-gray-50">
                        </div>

                        <!-- Annee academique -->
                        <div class="form-group">
                            <label for="annee_academique_affiche" class="block text-sm font-medium text-gray-700 mb-1">
                                Année Académique
                            </label>
                            <input type="text" id="annee_academique_affiche" readonly
                                value="<?= $ecue_a_modifier ? htmlspecialchars($ecue_a_modifier->id_annee_academique) : '' ?>"
                                class="form-input w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm bg-gray-50">
                        </div>
                    </div>

                    <div class="flex justify-start space-x-3 mt-6">
                        <?php if (isset($_GET['id_ecue'])): ?>
                        <button type="submit" name="submit_add_ecue"
                            class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-save mr-2"></i> Modifier l'ECUE
                        </button>
                        <button type="submit" name="btn_annuler"
                            class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gray-500 hover:bg-gray-600 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-times mr-2"></i> Annuler
                        </button>
                        <?php else: ?>
                        <button type="submit" name="submit_add_ecue"
                            class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-plus mr-2"></i> Ajouter l'ECUE
                        </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table id="ecueTable" class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="w-[5%] px-4 py-3 text-center">
                                        <input type="checkbox" id="selectAllCheckbox"
                                            class="form-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">UE</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ECUE
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Crédits
                                    </th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                        Actions</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $listeEcues = $GLOBALS['listeEcues'] ?? []; ?>
                                <?php if (!empty($listeEcues)) : ?>
                                <?php foreach ($listeEcues as $ecue) : ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 text-center">
                                        <input type="checkbox" name="selected_ids[]"
                                            value="<?= htmlspecialchars($ecue->id_ecue) ?>"
                                            class="row-checkbox form-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900 font-medium">
                                        <?= htmlspecialchars($ecue->lib_ue) ?></td>
                                    <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($ecue->lib_ecue) ?>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($ecue->credit) ?>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="?page=parametres_generaux&action=ecue&id_ecue=<?= $ecue->id_ecue ?>"
                                                class="text-blue-500 hover:text-blue-700 transition-colors">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button"
                                                class="text-red-500 hover:text-red-700 transition-colors delete-btn"
                                                data-id="<?= $ecue->id_ecue ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center text-sm text-gray-500 py-4">
                                        Aucun élément constitutif enregistré.
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
    $(document).ready(function() {
        // Initialize DataTable
        const table = $('#ecueTable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excel',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    className: 'btn btn-success'
                },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Imprimer',
                    className: 'btn btn-primary'
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json'
            },
            pageLength: 10,
            responsive: true
        });

        // Search functionality
        $('#searchInput').on('keyup', function() {
            table.search(this.value).draw();
        });

        // Form validation
        const form = document.getElementById('ecueForm');
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const fields = ['ue', 'lib_ecue', 'credits'];

            fields.forEach(field => {
                const input = document.getElementById(field);
                const errorDiv = document.getElementById(`${field}-error`);

                if (!input.value) {
                    isValid = false;
                    errorDiv.textContent = 'Ce champ est requis';
                    errorDiv.classList.remove('hidden');
                    input.classList.add('border-red-500');
                } else if (field === 'credits') {
                    const credits = parseInt(input.value);
                    if (credits < 1 || credits > 9) {
                        isValid = false;
                        errorDiv.textContent = 'Le nombre de crédits doit être entre 1 et 9';
                        errorDiv.classList.remove('hidden');
                        input.classList.add('border-red-500');
                    } else {
                        errorDiv.classList.add('hidden');
                        input.classList.remove('border-red-500');
                    }
                } else {
                    errorDiv.classList.add('hidden');
                    input.classList.remove('border-red-500');
                }
            });

            if (!isValid) {
                e.preventDefault();
                showToast('Veuillez corriger les erreurs dans le formulaire', 'error');
            }
        });

        // Delete confirmation
        $('.delete-btn').click(function() {
            const id = $(this).data('id');
            $('#deleteModal').removeClass('hidden').addClass('flex');

            $('#confirmDelete').off('click').on('click', function() {
                // Add your delete logic here
                $('#deleteModal').removeClass('flex').addClass('hidden');
                showToast('Élément supprimé avec succès', 'success');
            });

            $('#cancelDelete').click(function() {
                $('#deleteModal').removeClass('flex').addClass('hidden');
            });
        });

        // Toast notification function
        function showToast(message, type = 'success') {
            Toastify({
                text: message,
                duration: 3000,
                gravity: "top",
                position: 'right',
                backgroundColor: type === 'success' ? '#10B981' : '#EF4444',
                stopOnFocus: true,
            }).showToast();
        }

        // Select all checkbox
        $('#selectAllCheckbox').change(function() {
            $('.row-checkbox').prop('checked', $(this).prop('checked'));
        });

        // Export buttons
        $('#exportExcel').click(function() {
            table.button('.buttons-excel').trigger();
        });

        $('#printTable').click(function() {
            table.button('.buttons-print').trigger();
        });

        // Show success message if form was submitted successfully
        <?php if (isset($_SESSION['success_message'])): ?>
        showToast("<?= $_SESSION['success_message'] ?>", 'success');
        <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        // Show error message if there was an error
        <?php if (isset($_SESSION['error_message'])): ?>
        showToast("<?= $_SESSION['error_message'] ?>", 'error');
        <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>
    });

    // Function to fill UE related fields
    function remplirInfosUE() {
        const selectUE = document.getElementById("ue");
        const selectedOption = selectUE.options[selectUE.selectedIndex];

        const semestre = selectedOption.getAttribute("data-semestre");
        const niveau = selectedOption.getAttribute("data-niveau");
        const annee = selectedOption.getAttribute("data-annee");

        document.getElementById("semestre").value = semestre ?? '';
        document.getElementById("niveau_etude").value = niveau ?? '';
        document.getElementById("annee_academique_affiche").value = annee ?? '';
    }
    </script>
</body>

</html>