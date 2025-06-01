<?php
$listeEtudiants = $listeEtudiants ?? [];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des étudiants</title>


</head>

<body class="bg-gray-50">
    <div class="relative container mx-auto px-4 py-8">
        <!-- Messages d'alerte pour les succès/erreurs -->
        <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo htmlspecialchars($_SESSION['success']); ?></span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>
        <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo htmlspecialchars($_SESSION['error']); ?></span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>
        <?php unset($_SESSION['error']); ?>
        <?php endif; ?>



        <!-- Add/Edit User Modal -->
        <div id="userModal"
            class="fixed inset-0 bg-opacity-50 border border-gray-200 overflow-y-auto h-full w-full z-50 flex hidden items-center justify-center modal-transition">
            <div class="relative p-8  w-full max-w-2xl shadow-2xl rounded-xl bg-white fade-in transform">
                <div class="absolute top-0 right-0 m-3">
                    <button onclick="closeUserModal(null)"
                        class="text-gray-400 hover:text-gray-600 focus:outline-none btn-icon">
                        <i class="fas fa-times fa-lg"></i>
                    </button>
                </div>
                <div class="flex items-center mb-6 pb-2 border-b border-gray-200">
                    <div class="bg-green-100 p-2 rounded-full mr-3">
                        <i class="fas fa-user-plus text-green-500"></i>
                    </div>
                    <h3 id="userModalTitle" class="text-2xl font-semibold text-gray-700">Ajouter un étudiant</h3>
                </div>
                <form id="userForm" class="space-y-4" method="post" action="?page=gestion_etudiants">
                    <input type="hidden" id="userId" name="userId">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="num_etu" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-book text-green-500 mr-2"></i>Numéro étudiant
                            </label>
                            <input type="text" name="num_etu" id="num_etu" required
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                        </div>
                        <div class="space-y-2">
                            <label for="login_etu" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-envelope text-green-500 mr-2"></i>Login
                            </label>
                            <input type="email" name="login_etu" id="login" required
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="nom_etu" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-user text-green-500 mr-2"></i>Nom
                            </label>
                            <input type="text" name="nom_etu" id="nom" required
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                        </div>
                        <div class="space-y-2">
                            <label for="prenom_etu" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-user text-green-500 mr-2"></i>Prénom
                            </label>
                            <input type="text" name="prenom_etu" id="prenom" required
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div class="space-y-2">
                            <label for="date_naiss_etu" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-calendar text-green-500 mr-2"></i>Date de naissance
                            </label>
                            <input type="date" name="date_naiss_etu" id="date_naiss"
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                        </div>

                        <div class="space-y-2">
                            <label for="genre_etu" class="block text-sm font-medium text-gray-700">
                                <i class="fa-solid fa-venus-mars text-green-500 mr-2"></i>Genre
                            </label>
                            <select name="genre_etu" id="genre" required
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white transition-all duration-200">
                                <option value="Femme">Féminin</option>
                                <option value="Homme">Masculin</option>
                                <option value="Neutre">Neutre</option>
                            </select>
                        </div>

                    </div>
                    <div class="flex justify-end space-x-4 self-end pt-6">
                        <button type="button" onclick="closeUserModal()"
                            class="px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200">
                            <i class="fas fa-times mr-2"></i>Annuler
                        </button>
                        <button type="submit" name="submit_add_etudiant"
                            class="px-6 py-2.5 text-sm font-medium rounded-lg shadow-sm text-white bg-gradient from-green-600 to-green-800 hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-save mr-2"></i><span id="userModalSubmitButton">Enregistrer</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white shadow-card rounded-lg overflow-hidden border border-gray-200 mb-8">
            <!-- Dashboard Header -->
            <div class=" bg-gradient-to-r from-green-600 to-green-800 px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">Gestion des étudiants</h2>
                <button onclick="openUserModal(null)"
                    class="bg-green-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    <i class="fas fa-plus mr-2"></i>Ajouter un étudiant
                </button>
            </div>

            <!-- Action Bar for Table -->
            <div class="px-6 py-4 flex flex-col sm:flex-row justify-between items-center border-b border-gray-200">
                <div class="relative w-full sm:w-1/2 lg:w-1/3 mb-4 sm:mb-0">
                    <input type="text" id="searchInput" placeholder="Rechercher un étudiant..."
                        class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </span>
                </div>
                <div class="flex flex-wrap gap-2 justify-center sm:justify-end">
                    <button
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg shadow transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <i class="fas fa-print mr-2"></i>Imprimer
                    </button>
                    <button
                        class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg shadow transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50">
                        <i class="fas fa-file-export mr-2"></i>Exporter
                    </button>
                    <button id="deleteButton"
                        class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg shadow transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                        <i class="fas fa-trash-alt mr-2"></i>Supprimer
                    </button>
                </div>
            </div>

            <!-- Users Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-center">
                                <input type="checkbox" id="selectAllCheckbox"
                                    class="form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500 cursor-pointer">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>ID</span>
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Numéro étudiant</span>
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Nom</span>
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Prénom</span>
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Date de naissance</span>
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Genre</span>
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Login</span>
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                </div>
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="usersTableBody">
                        <?php if (empty($listeEtudiants)) : ?>
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                                    <p>Aucun étudiant trouvé.</p>
                                    <p class="text-sm mt-2">Ajoutez de nouveaux étudiants en cliquant sur le bouton
                                        "Ajouter un étudiant"</p>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($listeEtudiants as $etudiant): ?>
                        <tr class="table-row-hover">
                            <td class="px-4 py-4 text-center">
                                <input type="checkbox" name="userCheckbox"
                                    value="<?php echo htmlspecialchars($etudiant->num_etu); ?>"
                                    class="user-checkbox form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500 cursor-pointer">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <span
                                    class="bg-gray-100 px-2 py-1 rounded-md"><?php echo htmlspecialchars($etudiant->num_etu); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex items-center">
                                    <span><?php echo htmlspecialchars($etudiant->num_etu); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex items-center">
                                    <i class=" text-gray-400 mr-2"></i>
                                    <?php echo htmlspecialchars($etudiant->nom_etu); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex items-center">
                                    <i class=" text-gray-400 mr-2"></i>
                                    <?php echo htmlspecialchars($etudiant->prenom_etu); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex items-center">
                                    <i class=" text-gray-400 mr-2"></i>
                                    <?php echo htmlspecialchars($etudiant->date_naiss_etu); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <?php echo htmlspecialchars($etudiant->genre_etu); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <?php echo htmlspecialchars($etudiant->login_etu); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex justify-center space-x-3">
                                    <button onclick='openUserModal(<?php echo json_encode([
                                        "num_etu" => $etudiant->num_etu,
                                        "nom" => $etudiant->nom_etu,
                                        "prenom" => $etudiant->prenom_etu,
                                        "date_naiss" => $etudiant->date_naiss_etu,
                                        "genre" => $etudiant->genre_etu,
                                        "login" => $etudiant->login_etu
                                    ]); ?>)' class="text-blue-500 hover:text-blue-700 transition-colors btn-icon"
                                        title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-700">
                        Affichage de <span class="font-medium">1</span> à <span
                            class="font-medium"><?php echo !empty($listeEtudiants) ? count($listeEtudiants) : 0; ?></span>
                        sur <span
                            class="font-medium"><?php echo !empty($listeEtudiants) ? count($listeEtudiants) : 0; ?></span>
                        résultats
                    </p>
                    <div class="flex items-center space-x-1">
                        <button
                            class="px-3 py-1 rounded-md bg-white border border-gray-300 text-sm text-green-600 hover:bg-green-50 transition-colors">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button
                            class="px-3 py-1 rounded-md bg-green-500 text-white border border-green-500 text-sm hover:bg-green-600 transition-colors">
                            1
                        </button>
                        <button
                            class="px-3 py-1 rounded-md bg-white border border-gray-300 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            2
                        </button>
                        <button
                            class="px-3 py-1 rounded-md bg-white border border-gray-300 text-sm text-green-600 hover:bg-green-50 transition-colors">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Footer -->
        <div class="mt-8 text-center text-gray-500 text-sm">
            <p>© 2025 Système de Gestion des étudiants. Tous droits réservés.</p>
        </div>
    </div>
    <script>
    // Manage the user modal
    const userModal = document.getElementById('userModal');
    const userForm = document.getElementById('userForm');
    const userModalTitle = document.getElementById('userModalTitle');
    const userIdField = document.getElementById('userId');

    const nomField = document.getElementById('nom');
    const prenomField = document.getElementById('prenom');
    const loginField = document.getElementById('login');
    const date_naiss = document.getElementById('date_naiss');
    const genreField = document.getElementById('genre');
    const num_etuField = document.getElementById('num_etu');

    const userModalSubmitButton = document.getElementById('userModalSubmitButton');
    const searchInput = document.getElementById('searchInput');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const deleteButton = document.getElementById('deleteButton');

    function openUserModal(userData = null) {
        userForm.reset();
        if (userData) {
            userModalTitle.textContent = 'Modifier l\'étudiant';
            userModalSubmitButton.textContent = 'Mettre à jour';


            userIdField.value = userData.num_etu;
            nomField.value = userData.nom;
            prenomField.value = userData.prenom;
            loginField.value = userData.login;
            date_naiss.value = userData.date_naiss;
            genreField.value = userData.genre;
            num_etuField.value = userData.num_etu;
            num_etuField.readOnly = true;
        } else {
            userModalTitle.textContent = 'Ajouter un étudiant';
            userModalSubmitButton.textContent = 'Enregistrer';
            userIdField.value = '';
            num_etuField.readOnly = false;
        }
        userModal.classList.remove('hidden');
    }

    function closeUserModal() {
        userModal.classList.add('hidden');
    }

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#usersTableBody tr');

        tableRows.forEach(row => {
            // Si vous n'avez pas de ligne vide
            if (row.querySelector('td:nth-child(2)')) {
                const num_etu = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const nom = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                const prenom = row.querySelector('td:nth-child(5)').textContent.toLowerCase();
                const login = row.querySelector('td:nth-child(8)').textContent.toLowerCase();

                if (num_etu.includes(searchTerm) ||
                    nom.includes(searchTerm) ||
                    prenom.includes(searchTerm) ||
                    login.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    });

    // Select all checkboxes
    selectAllCheckbox.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateDeleteButtonState();
    });

    // Update delete button state
    function updateDeleteButtonState() {
        const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
        deleteButton.disabled = checkedBoxes.length === 0;
        deleteButton.classList.toggle('opacity-50', checkedBoxes.length === 0);
        deleteButton.classList.toggle('cursor-not-allowed', checkedBoxes.length === 0);
    }

    // Event listener for checkbox changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('user-checkbox')) {
            updateDeleteButtonState();
            // Also update the "select all" checkbox
            const allCheckboxes = document.querySelectorAll('.user-checkbox');
            const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
            selectAllCheckbox.checked = checkedBoxes.length === allCheckboxes.length && allCheckboxes.length >
                0;
        }
    });

    // ============ AJOUT : Nouvelles fonctionnalités ============
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion de la soumission du formulaire
        userForm.addEventListener('submit', function(e) {
            // Déterminer le nom du bouton submit selon l'action
            const submitButton = userIdField.value ?
                '<input type="hidden" name="submit_update_etudiant" value="1">' :
                '<input type="hidden" name="submit_add_etudiant" value="1">';

            this.insertAdjacentHTML('beforeend', submitButton);
        });

        // Gestion de la suppression multiple
        deleteButton.addEventListener('click', function() {
            const checkedBoxes = document.querySelectorAll('.user-checkbox:checked');
            if (checkedBoxes.length === 0) {
                alert('Veuillez sélectionner au moins un étudiant à supprimer.');
                return;
            }

            if (confirm(`Êtes-vous sûr de vouloir supprimer ${checkedBoxes.length} étudiant(s) ?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '?page=gestion_etudiants';

                // Ajouter un champ caché pour l'action
                const actionInput = document.createElement('input');
                actionInput.type = 'hidden';
                actionInput.name = 'delete_selected';
                actionInput.value = '1';
                form.appendChild(actionInput);

                // Ajouter les numéros étudiants sélectionnés
                checkedBoxes.forEach(checkbox => {
                    const idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = 'selected_ids[]';
                    idInput.value = checkbox.value;
                    form.appendChild(idInput);
                });

                document.body.appendChild(form);
                form.submit();
            }
        });

        // Gestion de l'exportation
        const exportButton = document.querySelector('button:has(.fa-file-export)');
        if (exportButton) {
            exportButton.addEventListener('click', function() {
                window.location.href = '?page=gestion_etudiants&action=export';
            });
        }
    });
    </script>
</body>

</html>