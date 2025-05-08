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
        <h1 class="text-3xl font-semibold text-gray-800"></h1>
        <div class="mt-2">
            <button onclick="openUserModal(null)"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-150 ease-in-out">
                <i class="fas fa-plus mr-2"></i>Ajouter un Utilisateur
            </button>
        </div>
    </div>

    <!-- Add/Edit User Modal -->
    <div id="userModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center ">
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
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-3 mt-2">Nom
                            d'utilisateur</label>
                        <input type="text" name="username" id="username" required
                            class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-3 mt-2">Email</label>
                        <input type="email" name="email" id="email" required
                            class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="type_utilisateur" class="block text-sm font-medium text-gray-700 mb-3 mt-2">Type
                            utilisateur</label>
                        <input type="type_utilisateur" name="type_utilisateur" id="type_utilisateur"
                            class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">

                    </div>
                    <div>
                        <label for="fonction" class="block text-sm font-medium text-gray-700 mb-3 mt-2">Fonction</label>
                        <select name="fonction" id="fonction" required
                            class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white">
                            <?php foreach($roles as $role): ?>
                            <option value="<?php echo htmlspecialchars($role); ?>">
                                <?php echo htmlspecialchars($role); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="gu" class="block text-sm font-medium text-gray-700 mb-3 mt-2">Groupe
                            utilisateur</label>
                        <select name="gu" id="gu" required
                            class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white">
                            <?php foreach($roles as $role): ?>
                            <option value="<?php echo htmlspecialchars($role); ?>">
                                <?php echo htmlspecialchars($role); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="niveau_acces" class="block text-sm font-medium text-gray-700 mb-3 mt-2">Niveau
                            d'accès</label>
                        <select name="niveau_acces" id="niveau_acces" required
                            class=" focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white">
                            <?php foreach($roles as $role): ?>
                            <option value="<?php echo htmlspecialchars($role); ?>">
                                <?php echo htmlspecialchars($role); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="hidden">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-3 mt-2">Statut</label>
                        <select name="status" id="status" required
                            class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white">
                            <option value="Actif">Actif</option>
                            <option value="Inactif">Inactif</option>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-4 self-end">
                        <button type="button" onclick="closeUserModal()"
                            class="px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600">
                            <i class="fas fa-save mr-2"></i><span id="userModalSubmitButton">Enregistrer</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- Action Bar for Table -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center border-b border-gray-200 pb-4">
        <div style="width: 40%;" class="relative  mb-4 sm:mb-0 md:w-2/3 sm:w-1/3">
            <input type="text" placeholder="Rechercher un utilisateur..."
                class="w-full px-4 py-2 border border-gray-300  focus:outline-none focus:ring-2 focus:ring-green-500">
            <span class="absolute top-0 right-0  mr-3 px-2 py-2 text-white bg-green-500 rounded">
                <i class="fas fa-search "></i>
            </span>
        </div>
        <div>
            <button
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow hover:shadow-md transition-all duration-150 ease-in-out mr-2">
                <i class="fas fa-print mr-2"></i>Imprimer la liste
            </button>
            <button
                class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-4 rounded-lg shadow hover:shadow-md transition-all duration-150 ease-in-out">
                <i class="fas fa-file-export mr-2"></i>Exporter (CSV)
            </button>
            <button
                class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow hover:shadow-md transition-all duration-150 ease-in-out">
                <i class="fas fa-trash-alt mr-2"></i>Supprimer
            </button>
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200 border-collapse">
        <div class="overflow-x-auto">
            <table class="min-w-full w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="w-[5%] px-4 py-3 text-center">
                            <input type="checkbox" id="selectAllCheckbox"
                                class="form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        </th>
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
                        <td scope="col" class="w-[5%] px-4 py-3 text-center">
                            <input type="checkbox" id="selectAllCheckbox"
                                class="text-center form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        </td>
                        <td class="text-center px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo htmlspecialchars($user['id']); ?></td>
                        <td class=" text-center px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($user['username']); ?></td>
                        <td class="text-center px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($user['email']); ?></td>
                        <td class="text-center px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($user['role']); ?></td>
                        <td class="text-center px-6 py-4 whitespace-nowrap text-sm">
                            <span
                                class="px-2 py-1.5 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $user['status'] === 'Actif' ? 'bg-green-300 text-white' : 'bg-red-500 text-white'; ?>">
                                <?php echo htmlspecialchars($user['status']); ?>
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <button onclick='openUserModal(<?php echo json_encode($user); ?>)'
                                class="text-blue-300 hover:text-blue-500 mr-3" title="Modifier">
                                <i class="fas fa-pencil-alt"></i>
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
                    <a href="#" class="px-3 py-1  text-sm text-green-500 font-semibold">Précédent</a>
                    <a href="#"
                        class="px-3 py-1 border-t border-b border-gray-300 text-sm hover:bg-gray-50 bg-green-100 text-green-600">1</a>
                    <a href="#" class="px-3 py-1 border-t border-b border-gray-300 text-sm hover:bg-gray-50">2</a>
                    <a href="#" class="px-3 py-1 text-sm text-green-500 font-semibold">Suivant</a>
                </div>
            </nav>
        </div>
    </div>
</div>



<script>
const userModal = document.getElementById('userModal');
const userForm = document.getElementById('userForm');
const userModalTitle = document.getElementById('userModalTitle');
const userIdField = document.getElementById('userId');
const usernameField = document.getElementById('username');
const emailField = document.getElementById('email');
const fonctionField = document.getElementById('fonction');
const niveau_acces = document.getElementById('niveau_acces');
const guField = document.getElementById('gu');
const typeField = document.getElementById('type_utilisateur');
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
        fonctionField.value = userData.fonction;
        statusField.value = userData.status;
        typeField.value = userData.type;
        guField.value = userData.gu;
        niveau_acces.value = userData.niveau_acces;
    } else {
        userModalTitle.textContent = 'Ajouter un Utilisateur';
        userModalSubmitButton.textContent = 'Enregistrer';
        userIdField.value = '';
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