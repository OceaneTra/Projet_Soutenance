<?php

$utilisateurs = $GLOBALS['utilisateurs'] ?? [];
$types = $GLOBALS['types'] ?? [];

// Calculer les statistiques
$totalUtilisateurs = count($utilisateurs);
$utilisateursActifs = count(array_filter($utilisateurs, function($u) { return $u->statut_utilisateur === 'Actif'; }));
$utilisateursInactifs = $totalUtilisateurs - $utilisateursActifs;

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>


</head>

<body class="bg-gray-50">
    <div class="relative container mx-auto px-4 py-8">
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
                    <h3 id="userModalTitle" class="text-2xl font-semibold text-gray-700">Ajouter un Utilisateur</h3>
                </div>
                <form id="userForm" class="space-y-4">
                    <input type="hidden" id="userId" name="userId">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="username" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-user text-green-500 mr-2"></i>Nom d'utilisateur
                            </label>
                            <input type="text" name="username" id="username" required
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                        </div>
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-envelope text-green-500 mr-2"></i>Email
                            </label>
                            <input type="email" name="email" id="email" required
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="type_utilisateur" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-id-badge text-green-500 mr-2"></i>Type utilisateur
                            </label>
                            <select name="type_utilisateur" id="type_utilisateur" required
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white transition-all duration-200">
                                <?php foreach($types as $type): ?>
                                <option value="<?php echo htmlspecialchars($type->id_type_utilisateur); ?>">
                                    <?php echo htmlspecialchars($type->lib_type_utilisateur); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label for="fonction" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-briefcase text-green-500 mr-2"></i>Fonction
                            </label>
                            <select name="fonction" id="fonction" required
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white transition-all duration-200">
                                <?php foreach($fonctions as $f): ?>
                                <option value="<?php echo htmlspecialchars($f->id_fonction); ?>">
                                    <?php echo htmlspecialchars($f->lib_fonction); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="gu" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-users text-green-500 mr-2"></i>Groupe utilisateur
                            </label>
                            <select name="gu" id="gu" required
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white transition-all duration-200">
                                <?php foreach($groupes as $groupe): ?>
                                <option value="<?php echo htmlspecialchars($groupe->id_GU); ?>">
                                    <?php echo htmlspecialchars($groupe->lib_GU); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label for="niveau_acces" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-lock text-green-500 mr-2"></i>Niveau d'accès
                            </label>
                            <select name="niveau_acces" id="niveau_acces" required
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white transition-all duration-200">
                                <?php foreach($niveauxAcces as $niveau): ?>
                                <option value="<?php echo htmlspecialchars($niveau->id_niveau_acces_donnees); ?>">
                                    <?php echo htmlspecialchars($niveau->lib_niveau_acces_donnees); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="status" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-toggle-on text-green-500 mr-2"></i>Statut
                            </label>
                            <select name="status" id="status" required
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white transition-all duration-200">
                                <option value="Actif">Actif</option>
                                <option value="Inactif">Inactif</option>
                            </select>
                        </div>
                        <div class="flex justify-end space-x-4 self-end pt-6">
                            <button type="button" onclick="closeUserModal()"
                                class="px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200">
                                <i class="fas fa-times mr-2"></i>Annuler
                            </button>
                            <button type="submit"
                                class="px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient hover:shadow-lg transition-all duration-200">
                                <i class="fas fa-save mr-2"></i><span id="userModalSubmitButton">Enregistrer</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- User Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-card p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 mr-4">
                        <i class="fas fa-users text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Utilisateurs</p>
                        <h3 class="text-2xl font-bold text-gray-800"><?php echo $totalUtilisateurs; ?></h3>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-card p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 mr-4">
                        <i class="fas fa-user-check text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Utilisateurs Actifs</p>
                        <h3 class="text-2xl font-bold text-gray-800"><?php echo $utilisateursActifs; ?></h3>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-card p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 mr-4">
                        <i class="fas fa-user-times text-red-600 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Utilisateurs Inactifs</p>
                        <h3 class="text-2xl font-bold text-gray-800"><?php echo $utilisateursInactifs; ?></h3>
                    </div>
                </div>
            </div>
        </div>


        <!-- Main Content -->
        <div class="bg-white shadow-card rounded-lg overflow-hidden border border-gray-200 mb-8">

            <!-- Dashboard Header -->
            <div class=" bg-gradient-to-r from-green-600 to-green-800 px-6 py-4 flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">Gestion des Utilisateurs</h2>
                <button onclick="openUserModal(null)"
                    class="bg-green-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    <i class="fas fa-plus mr-2"></i>Ajouter un Utilisateur
                </button>
            </div>

            <!-- Action Bar for Table -->
            <div class="px-6 py-4 flex flex-col sm:flex-row justify-between items-center border-b border-gray-200">
                <div class="relative w-full sm:w-1/2 lg:w-1/3 mb-4 sm:mb-0">
                    <input type="text" id="searchInput" placeholder="Rechercher un utilisateur..."
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
                                    <span>Nom d'utilisateur</span>
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Email</span>
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Type utilisateur</span>
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Statut</span>
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                </div>
                            </th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="usersTableBody">
                        <?php if (empty($utilisateurs)): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-users text-gray-300 text-4xl mb-4"></i>
                                    <p>Aucun utilisateur trouvé.</p>
                                    <p class="text-sm mt-2">Ajoutez de nouveaux utilisateurs en cliquant sur le bouton
                                        "Ajouter un Utilisateur"</p>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($utilisateurs as $index => $user): ?>
                        <tr class="table-row-hover">
                            <td class="px-4 py-4 text-center">
                                <input type="checkbox" name="userCheckbox"
                                    value="<?php echo htmlspecialchars($user->id_utilisateur); ?>"
                                    class="user-checkbox form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500 cursor-pointer">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <span
                                    class="bg-gray-100 px-2 py-1 rounded-md"><?php echo htmlspecialchars($user->id_utilisateur); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex items-center">
                                    <div
                                        class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                        <span
                                            class="text-green-600 font-medium"><?php echo substr(htmlspecialchars($user->nom_utilisateur), 0, 1); ?></span>
                                    </div>
                                    <span><?php echo htmlspecialchars($user->nom_utilisateur); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                    <?php echo htmlspecialchars($user->email_utilisateur); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex items-center">
                                    <i class="fas fa-user-tag text-gray-400 mr-2"></i>
                                    <?php echo htmlspecialchars($user->role_utilisateur); ?>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="status-badge px-3 py-1.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?php echo $user->statut_utilisateur === 'Actif' 
                                        ? 'bg-green-100 text-green-800' 
                                        : 'bg-red-100 text-red-800'; ?>">
                                    <i
                                        class="fas <?php echo $user->statut_utilisateur === 'Actif' ? 'fa-check-circle' : 'fa-times-circle'; ?> mr-1 text-center pt-1"></i>
                                    <?php echo htmlspecialchars($user->statut_utilisateur); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex justify-center space-x-3">
                                    <button onclick='openUserModal(<?php echo json_encode($user); ?>)'
                                        class="text-blue-500 hover:text-blue-700 transition-colors btn-icon"
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
                            class="font-medium"><?php echo count($utilisateurs); ?></span> sur <span
                            class="font-medium"><?php echo count($utilisateurs); ?></span> résultats
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
            <p>© 2025 Système de Gestion des Utilisateurs. Tous droits réservés.</p>
        </div>
    </div>

    <script>
    // Variables pour le modal utilisateur
    const userModal = document.getElementById('userModal');
    const userForm = document.getElementById('userForm');
    const userModalTitle = document.getElementById('userModalTitle');
    const userModalSubmitButton = document.getElementById('userModalSubmitButton');
    const userIdField = document.getElementById('userId');
    const usernameField = document.getElementById('username');
    const emailField = document.getElementById('email');
    const fonctionField = document.getElementById('fonction');
    const statusField = document.getElementById('status');
    const typeField = document.getElementById('type_utilisateur');
    const guField = document.getElementById('gu');
    const niveau_acces = document.getElementById('niveau_acces');
    const searchInput = document.getElementById('searchInput');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const deleteButton = document.getElementById('deleteButton');

    // Fonction pour ouvrir le modal
    function openUserModal(userData) {
        if (userData) {
            userModalTitle.textContent = 'Modifier l\'Utilisateur';
            userModalSubmitButton.textContent = 'Mettre à jour';
            userIdField.value = userData.id_utilisateur;
            usernameField.value = userData.nom_utilisateur;
            emailField.value = userData.email_utilisateur;
            fonctionField.value = userData.role_utilisateur;
            statusField.value = userData.statut_utilisateur;
            typeField.value = userData.type_utilisateur || '';
            guField.value = userData.gu || 'Administrateur';
            niveau_acces.value = userData.niveau_acces || 'Administrateur';
        } else {
            userModalTitle.textContent = 'Ajouter un Utilisateur';
            userModalSubmitButton.textContent = 'Enregistrer';
            userForm.reset();
        }
        userModal.classList.remove('hidden');
    }

    // Fonction pour fermer le modal
    function closeUserModal() {
        userModal.classList.add('hidden');
    }

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#usersTableBody tr');

        tableRows.forEach(row => {
            const username = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const email = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

            if (username.includes(searchTerm) || email.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
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
    </script>