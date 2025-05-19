<?php
$niveau_a_modifier = $GLOBALS['niveau_a_modifier'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Niveaux d'Étude</title>
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
            <p class="text-gray-600 mb-6">Êtes-vous sûr de vouloir supprimer ces éléments ? Cette action est irréversible.</p>
            <div class="flex justify-end space-x-4">
                <button id="cancelDelete" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition-colors">
                    Annuler
                </button>
                <button id="confirmDelete" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition-colors">
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
                    <h2 class="text-2xl font-bold text-gray-700">Gestion des Niveaux d'Étude</h2>
                    <div class="flex space-x-3">
                        <button id="exportExcel" class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                            <i class="fas fa-file-excel mr-2"></i> Exporter
                        </button>
                        <button id="printTable" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-print mr-2"></i> Imprimer
                        </button>
                    </div>
                </div>
                
                <!-- Search Bar -->
                <div class="relative mb-4">
                    <input type="text" id="searchInput" placeholder="Rechercher un niveau d'étude..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <i class="fas fa-search absolute right-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <!-- Form Section with Animation -->
            <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8 transform transition-all duration-300 hover:shadow-xl">
                <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b pb-3">
                    <?= isset($_GET['id_niv_etude']) ? "Modifier le niveau d'étude" : "Ajouter un nouveau niveau d'étude" ?>
                </h3>

                <form method="POST" action="?page=parametres_generaux&action=niveaux_etude" id="niveauForm" class="space-y-6">
                    <?php if($niveau_a_modifier): ?>
                        <input type="hidden" name="id_niv_etude" value="<?= htmlspecialchars($niveau_a_modifier->id_niv_etude) ?>">
                    <?php endif ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Libellé Niveau -->
                        <div class="form-group">
                            <label for="lib_niv_etude" class="block text-sm font-medium text-gray-700 mb-1">
                                Libellé du niveau <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="lib_niv_etude" name="lib_niv_etude" required
                                   value="<?= $niveau_a_modifier ? htmlspecialchars($niveau_a_modifier->lib_niv_etude) : '' ?>"
                                   placeholder="Ex: Licence 1"
                                   class="form-input w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            <div class="text-red-500 text-sm mt-1 hidden" id="lib_niv_etude-error"></div>
                        </div>
                    </div>

                    <div class="flex justify-start space-x-3 mt-6">
                        <?php if (isset($_GET['id_niv_etude'])): ?>
                            <button type="submit" name="submit_edit_niveau"
                                    class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-save mr-2"></i> Modifier le niveau
                            </button>
                            <button type="submit" name="btn_annuler"
                                    class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gray-500 hover:bg-gray-600 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-times mr-2"></i> Annuler
                            </button>
                        <?php else: ?>
                            <button type="submit" name="submit_add_niveau"
                                    class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-plus mr-2"></i> Ajouter le niveau
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table id="niveauTable" class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="w-[5%] px-4 py-3 text-center">
                                        <input type="checkbox" id="selectAllCheckbox"
                                               class="form-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Libellé</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $listeNiveaux = $GLOBALS['listeNiveaux'] ?? []; ?>
                                <?php if (!empty($listeNiveaux)) : ?>
                                    <?php foreach ($listeNiveaux as $niveau) : ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 text-center">
                                                <input type="checkbox" name="selected_ids[]" value="<?= htmlspecialchars($niveau->id_niv_etude) ?>"
                                                       class="row-checkbox form-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900 font-medium"><?= htmlspecialchars($niveau->id_niv_etude) ?></td>
                                            <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($niveau->lib_niv_etude) ?></td>
                                            <td class="px-4 py-3 text-center">
                                                <div class="flex justify-center space-x-2">
                                                    <a href="?page=parametres_generaux&action=niveaux_etude&id_niv_etude=<?= $niveau->id_niv_etude ?>"
                                                       class="text-blue-500 hover:text-blue-700 transition-colors">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="text-red-500 hover:text-red-700 transition-colors delete-btn"
                                                            data-id="<?= $niveau->id_niv_etude ?>">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-sm text-gray-500 py-4">
                                            Aucun niveau d'étude enregistré.
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
            const table = $('#niveauTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
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
            const form = document.getElementById('niveauForm');
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const fields = ['lib_niv_etude'];
                
                fields.forEach(field => {
                    const input = document.getElementById(field);
                    const errorDiv = document.getElementById(`${field}-error`);
                    
                    if (!input.value) {
                        isValid = false;
                        errorDiv.textContent = 'Ce champ est requis';
                        errorDiv.classList.remove('hidden');
                        input.classList.add('border-red-500');
                    } else {
                        errorDiv.classList.add('hidden');
                        input.classList.remove('border-red-500');
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    showToast('Veuillez remplir tous les champs requis', 'error');
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
    </script>
</body>
</html>
