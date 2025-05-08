<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-8">
                    <button class="py-4 px-2 border-b-0 text-gray-500 font-medium">User Profile</button>
                    <button class="py-4 px-2 border-b-2 border-blue-500 text-blue-500 font-medium">Gestion des
                        utilisateurs</button>
                    <button class="py-4 px-2 border-b-0 text-gray-500 font-medium">Piste D'AUDIT</button>
                </div>
            </div>
        </div>
    </div>

    <!-- User Management Interface -->
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg my-8 p-8">
        <h1 class="text-xl font-bold border-b pb-3 mb-6">Gestion des utilisateurs</h1>

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium mb-1">Nom Utilisateur</label>
                <div class="relative">
                    <input type="text"
                        class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div class="absolute inset-y-0 right-0 flex items-center px-2">
                        <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Fonction</label>
                <input type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Groupe utilisateur</label>
                <div class="relative">
                    <input type="text"
                        class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div class="absolute inset-y-0 right-0 flex items-center px-2">
                        <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Niveau d'accès</label>
                <div class="relative">
                    <input type="text"
                        class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div class="absolute inset-y-0 right-0 flex items-center px-2">
                        <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Login</label>
                <input type="email" placeholder="@mail.com"
                    class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Mot de passe</label>
                <input type="password"
                    class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Type</label>
                <input type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Date du jour</label>
                <input type="text"
                    class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="flex justify-center mt-4 mb-8">
            <button
                class="bg-blue-500 text-white px-6 py-2 rounded text-sm font-medium hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">VALIDER</button>
        </div>

        <h2 class="text-lg font-medium border-t border-b py-2 mb-4">Liste des utilisateurs</h2>

        <div class="flex justify-between mb-4">
            <button
                class="bg-gray-200 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Exporter</button>

            <div class="flex items-center">
                <input type="text"
                    class="w-48 px-3 py-1 border border-gray-300 rounded-l text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button
                    class="bg-gray-200 text-gray-700 px-3 py-1 rounded-r text-sm border border-gray-300 border-l-0 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>

            <button
                class="bg-gray-200 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Imprimer</button>
        </div>

        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="py-2 px-4 text-left text-sm">Nom Utilisateur</th>
                    <th class="py-2 px-4 text-left text-sm">Fonction</th>
                    <th class="py-2 px-4 text-left text-sm">Type</th>
                    <th class="py-2 px-4 text-left text-sm">GU</th>
                    <th class="py-2 px-4 text-left text-sm">NA</th>
                    <th class="py-2 px-4 text-left text-sm">Login</th>
                    <th class="py-2 px-4 text-left text-sm">MdP</th>
                    <th class="py-2 px-4 text-left text-sm">Modifier</th>
                </tr>
            </thead>
            <tbody>
                <!-- Empty rows would go here -->
                <tr class="border-b">
                    <td class="py-2 px-4 text-sm" colspan="8">No data available</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Add/Edit User Modal -->
    <div id="userModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden z-50">
        <div class="relative mx-auto p-8 border w-full max-w-2xl shadow-2xl rounded-xl bg-white">
            <div class="flex justify-between items-center mb-6">
                <h3 id="userModalTitle" class="text-2xl font-semibold text-gray-700">Ajouter un Utilisateur</h3>
                <button onclick="closeUserModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times fa-lg"></i>
                </button>
            </div>
            <form id="userForm">
                <input type="hidden" id="userId" name="userId">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Nom
                            d'utilisateur</label>
                        <input type="text" name="username" id="username" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" id="email" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <small id="passwordHelp" class="text-xs text-gray-500">Laissez vide si vous ne souhaitez pas le
                            modifier.</small>
                    </div>
                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Rôle</label>
                        <select name="role" id="role" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white">
                            <?php foreach($roles as $role): ?>
                            <option value="<?php echo htmlspecialchars($role); ?>">
                                <?php echo htmlspecialchars($role); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select name="status" id="status" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white">
                            <option value="Actif">Actif</option>
                            <option value="Inactif">Inactif</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeUserModal()"
                        class="px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50">
                        Annuler
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600">
                        <i class="fas fa-save mr-2"></i><span id="userModalSubmitButton">Enregistrer</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    const userModal = document.getElementById('userModal');
    const userForm = document.getElementById('userForm');
    const userModalTitle = document.getElementById('userModalTitle');
    const userIdField = document.getElementById('userId');
    const usernameField = document.getElementById('username');
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    const passwordHelp = document.getElementById('passwordHelp');
    const passwordConfirmationField = document.getElementById('password_confirmation');
    const roleField = document.getElementById('role');
    const statusField = document.getElementById('status');
    const userModalSubmitButton = document.getElementById('userModalSubmitButton');

    function openUserModal(userData = null) {
        userForm.reset(); // Reset form fields
        if (userData) {
            userModalTitle.textContent = 'Modifier l\'Utilisateur';
            userModalSubmitButton.textContent = 'Mettre à jour';
            userIdField.value = userData.id;
            usernameField.value = userData.username;
            emailField.value = userData.email;
            roleField.value = userData.role;
            statusField.value = userData.status;
            passwordField.placeholder = "Laissez vide pour ne pas changer";
            passwordConfirmationField.placeholder = "Laissez vide pour ne pas changer";
            passwordField.required = false; // Not required on edit unless changing
            passwordHelp.classList.remove('hidden');
        } else {
            userModalTitle.textContent = 'Ajouter un Utilisateur';
            userModalSubmitButton.textContent = 'Enregistrer';
            userIdField.value = '';
            passwordField.placeholder = "";
            passwordConfirmationField.placeholder = "";
            passwordField.required = true; // Required on add
            passwordHelp.classList.add('hidden');
        }
        userModal.classList.remove('hidden');
    }

    function closeUserModal() {
        userModal.classList.add('hidden');
    }

    userForm.addEventListener('submit', function(event) {
        event.preventDefault();
        // Here you would typically send the data via AJAX
        const formData = new FormData(userForm);
        const data = Object.fromEntries(formData.entries());
        console.log('Submitting user data:', data);
        alert((data.userId ? 'Modification' : 'Ajout') + ' de l\'utilisateur ' + data.username + ' simulé.');
        closeUserModal();
        // Potentially reload or update the table data here
    });

    // Close modal if escape key is pressed
    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !userModal.classList.contains('hidden')) {
            closeUserModal();
        }
    });
    </script>
</body>

</html>

<?php
// Placeholder data for users
$users = [
    ['id' => 1, 'username' => 'admin_user', 'email' => 'admin@example.com', 'role' => 'Administrateur', 'status' => 'Actif', 'created_at' => '2023-01-15'],
    ['id' => 2, 'username' => 'editor_user', 'email' => 'editor@example.com', 'role' => 'Éditeur', 'status' => 'Actif', 'created_at' => '2023-02-20'],
    ['id' => 3, 'username' => 'viewer_user', 'email' => 'viewer@example.com', 'role' => 'Lecteur', 'status' => 'Inactif', 'created_at' => '2023-03-10'],
];

// Placeholder for roles/groups
$roles = ['Administrateur', 'Éditeur', 'Lecteur', 'Membre'];
?>

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-semibold text-gray-800">Gestion des Utilisateurs</h1>
        <div>
            <button onclick="openUserModal(null)"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-150 ease-in-out">
                <i class="fas fa-plus mr-2"></i>Ajouter un Utilisateur
            </button>
        </div>
    </div>

    <!-- Action Bar for Table -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center">
        <div class="relative mb-4 sm:mb-0 w-full sm:w-1/3">
            <input type="text" placeholder="Rechercher un utilisateur..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
            <span class="absolute top-0 right-0 mt-2 mr-3">
                <i class="fas fa-search text-gray-400"></i>
            </span>
        </div>
        <div>
            <button
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow hover:shadow-md transition-all duration-150 ease-in-out mr-2">
                <i class="fas fa-print mr-2"></i>Imprimer la liste
            </button>
            <button
                class="bg-gray-700 hover:bg-gray-800 text-white font-semibold py-2 px-4 rounded-lg shadow hover:shadow-md transition-all duration-150 ease-in-out">
                <i class="fas fa-file-export mr-2"></i>Exporter (CSV)
            </button>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom
                            d'utilisateur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créé
                            le</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">Aucun utilisateur trouvé.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo htmlspecialchars($user['id']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($user['username']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($user['email']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($user['role']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $user['status'] === 'Actif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                <?php echo htmlspecialchars($user['status']); ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($user['created_at']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <button onclick='openUserModal(<?php echo json_encode($user); ?>)'
                                class="text-indigo-600 hover:text-indigo-900 mr-3" title="Modifier">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');"
                                class="text-red-600 hover:text-red-900" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <!-- Pagination (Placeholder) -->
        <div class="px-6 py-4 border-t border-gray-200">
            <nav class="flex items-center justify-between">
                <p class="text-sm text-gray-700">
                    Affichage de <span class="font-medium">1</span> à <span
                        class="font-medium"><?php echo count($users); ?></span> sur <span
                        class="font-medium"><?php echo count($users); ?></span> résultats
                </p>
                <div class="flex">
                    <a href="#"
                        class="px-3 py-1 border border-gray-300 rounded-l-md text-sm hover:bg-gray-50">Précédent</a>
                    <a href="#"
                        class="px-3 py-1 border-t border-b border-gray-300 text-sm hover:bg-gray-50 bg-green-100 text-green-600">1</a>
                    <a href="#" class="px-3 py-1 border-t border-b border-gray-300 text-sm hover:bg-gray-50">2</a>
                    <a href="#"
                        class="px-3 py-1 border border-gray-300 rounded-r-md text-sm hover:bg-gray-50">Suivant</a>
                </div>
            </nav>
        </div>
    </div>
</div>