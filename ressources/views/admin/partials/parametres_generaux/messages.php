<?php
$message_a_modifier = $GLOBALS['message_a_modifier'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Messages</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
                    <h2 class="text-2xl font-bold text-gray-700">Gestion des Messages</h2>
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
                    <form action="" method="GET" class="flex gap-3">
                        <input type="hidden" name="page" value="parametres_generaux">
                        <input type="hidden" name="action" value="messages">
                        <div class="relative">
                            <input type="text" name="search" value="<?= $search ?>" placeholder="Rechercher un message..."
                                class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <div class="flex space-x-3">
                            <button id="exportExcel" class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                                <i class="fas fa-file-excel mr-2"></i> Exporter
                            </button>
                            <button id="printTable" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                <i class="fas fa-print mr-2"></i> Imprimer
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Form Section with Animation -->
            <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8 transform transition-all duration-300 hover:shadow-xl">
                <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b pb-3">
                    <?= isset($_GET['id_message']) ? "Modifier le message" : "Ajouter un nouveau message" ?>
                </h3>

                <form method="POST" action="?page=parametres_generaux&action=messages" id="messageForm" class="space-y-6">
                    <?php if($message_a_modifier): ?>
                        <input type="hidden" name="id_message" value="<?= htmlspecialchars($message_a_modifier->id_message) ?>">
                    <?php endif ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Contenu Message -->
                        <div class="form-group">
                            <label for="contenu_message" class="block text-sm font-medium text-gray-700 mb-1">
                                Contenu du message <span class="text-red-500">*</span>
                            </label>
                            <textarea id="contenu_message" name="message" required rows="4"
                                   class="form-input w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   placeholder="Saisissez votre message ici..."><?= $message_a_modifier ? htmlspecialchars($message_a_modifier->contenu_message) : '' ?></textarea>
                            <div class="text-red-500 text-sm mt-1 hidden" id="contenu_message-error"></div>
                        </div>
                    </div>

                    <div class="flex justify-start space-x-3 mt-6">
                        <?php if (isset($_GET['id_message'])): ?>
                            <button type="submit" name="btn_add_message"
                                    class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-save mr-2"></i> Modifier le message
                            </button>
                            <button type="submit" name="btn_annuler"
                                    class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gray-500 hover:bg-gray-600 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-times mr-2"></i> Annuler
                            </button>
                        <?php else: ?>
                            <button type="submit" name="btn_add_message"
                                    class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-plus mr-2"></i> Ajouter le message
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table id="messageTable" class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="w-[5%] px-4 py-3 text-center">
                                        <input type="checkbox" id="selectAllCheckbox"
                                               class="form-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contenu</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $listeMessages = $GLOBALS['listeMessages'] ?? []; ?>
                                <?php if (!empty($listeMessages)) : ?>
                                    <?php foreach ($listeMessages as $message) : ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 text-center">
                                                <input type="checkbox" name="selected_ids[]" value="<?= htmlspecialchars($message->id_message) ?>"
                                                       class="row-checkbox form-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900 font-medium"><?= htmlspecialchars($message->id_message) ?></td>
                                            <td class="px-4 py-3 text-sm text-gray-700"><?= htmlspecialchars($message->contenu_message) ?></td>
                                            <td class="px-4 py-3 text-center">
                                                <div class="flex justify-center space-x-2">
                                                    <a href="?page=parametres_generaux&action=messages&id_message=<?= $message->id_message ?>"
                                                       class="text-blue-500 hover:text-blue-700 transition-colors">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="text-red-500 hover:text-red-700 transition-colors delete-btn"
                                                            data-id="<?= $message->id_message ?>">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-sm text-gray-500 py-4">
                                            Aucun message enregistré.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                                <a href="?page=parametres_generaux&action=messages&p=<?= $page - 1 ?>&search=<?= urlencode($search) ?>"
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
                                <a href="?page=parametres_generaux&action=messages&p=<?= $i ?>&search=<?= urlencode($search) ?>"
                                   class="relative inline-flex items-center px-4 py-2 border <?= $i === $page ? 'bg-green-50 text-green-600 border-green-500' : 'bg-white text-gray-500 hover:bg-gray-50 border-gray-300' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor;

                            if ($end < $total_pages) {
                                echo '<span class="px-3 py-2 text-gray-500">...</span>';
                            }
                            ?>

                            <?php if ($page < $total_pages): ?>
                                <a href="?page=parametres_generaux&action=messages&p=<?= $page + 1 ?>&search=<?= urlencode($search) ?>"
                                   class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            <?php endif; ?>
                        </nav>
                    </div>
                </div>
            </div>
            <?php endif; ?>
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
            const table = $('#messageTable').DataTable({
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
            const form = document.getElementById('messageForm');
            form.addEventListener('submit', function(e) {
                let isValid = true;
                const fields = ['contenu_message'];
                
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

    <!-- Notification System -->
    <div id="notification" class="fixed top-4 right-4 z-50 hidden">
        <div class="bg-white rounded-lg p-4 shadow-lg">
            <div class="flex items-center">
                <div id="notificationIcon" class="text-2xl mr-4">
                    <!-- Notification icon will be dynamically inserted here -->
                </div>
                <div id="notificationMessage">
                    <!-- Notification message will be dynamically inserted here -->
                </div>
            </div>
        </div>
    </div>

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
    </style>
</body>
</html>