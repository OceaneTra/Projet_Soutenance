<?php
// Placeholder data for roles and permissions
$rolesData = [
    ['id' => 1, 'nom_role' => 'Administrateur', 'description' => 'Accès total au système', 'permissions_count' => 25],
    ['id' => 2, 'nom_role' => 'Éditeur de Contenu', 'description' => 'Peut créer et modifier le contenu', 'permissions_count' => 10],
    ['id' => 3, 'nom_role' => 'Membre Standard', 'description' => 'Accès limité en lecture seule', 'permissions_count' => 5],
];
$availablePermissions = [
    'create_user', 'edit_user', 'delete_user', 'view_reports', 'manage_settings',
    'publish_content', 'edit_own_profile', 'access_audit_log'
    // ... more permissions
];
?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-semibold text-gray-800">Gestion des Habilitations (Rôles & Permissions)</h1>
        <div>
            <button onclick="openRoleModal(null)"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md">
                <i class="fas fa-plus mr-2"></i>Ajouter un Rôle
            </button>
        </div>
    </div>

    <!-- Roles Table -->
    <div class="bg-white shadow-xl rounded-lg overflow-hidden mb-12">
        <div class="overflow-x-auto">
            <table class="min-w-full w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID
                            Rôle</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom
                            du Rôle</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nb.
                            Permissions</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($rolesData as $roleItem): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo htmlspecialchars($roleItem['id']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($roleItem['nom_role']); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-700 max-w-xs truncate">
                            <?php echo htmlspecialchars($roleItem['description']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($roleItem['permissions_count']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <button onclick='openRoleModal(<?php echo json_encode($roleItem); ?>)'
                                class="text-indigo-600 hover:text-indigo-900 mr-3" title="Modifier"><i
                                    class="fas fa-pencil-alt"></i></button>
                            <button onclick="return confirm('Supprimer ce rôle ?');"
                                class="text-red-600 hover:text-red-900" title="Supprimer"><i
                                    class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Password Policy Section (Example) -->
    <div class="bg-white shadow-xl rounded-lg p-6 md:p-8">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Politique des Mots de Passe</h2>
        <form id="passwordPolicyForm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label for="min_length" class="block text-sm font-medium text-gray-700 mb-1">Longueur
                        minimale</label>
                    <input type="number" name="min_length" id="min_length" value="8"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label for="expire_days" class="block text-sm font-medium text-gray-700 mb-1">Expiration (jours, 0
                        pour jamais)</label>
                    <input type="number" name="expire_days" id="expire_days" value="90"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                </div>
            </div>
            <div class="mb-6 space-y-2">
                <p class="block text-sm font-medium text-gray-700 mb-1">Exigences de complexité :</p>
                <label class="flex items-center">
                    <input type="checkbox" name="req_uppercase" checked
                        class="form-checkbox h-5 w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                    <span class="ml-2 text-sm text-gray-700">Majuscule</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" name="req_lowercase" checked
                        class="form-checkbox h-5 w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                    <span class="ml-2 text-sm text-gray-700">Minuscule</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" name="req_number" checked
                        class="form-checkbox h-5 w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                    <span class="ml-2 text-sm text-gray-700">Chiffre</span>
                </label>
                <label class="flex items-center">
                    <input type="checkbox" name="req_symbol"
                        class="form-checkbox h-5 w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                    <span class="ml-2 text-sm text-gray-700">Symbole</span>
                </label>
            </div>
            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600">
                    <i class="fas fa-save mr-2"></i>Enregistrer la Politique
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add/Edit Role Modal -->
<div id="roleModal"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden z-50">
    <div class="relative mx-auto p-8 border w-full max-w-3xl shadow-2xl rounded-xl bg-white">
        <div class="flex justify-between items-center mb-6">
            <h3 id="roleModalTitle" class="text-2xl font-semibold text-gray-700">Ajouter un Rôle</h3>
            <button onclick="closeRoleModal()" class="text-gray-400 hover:text-gray-600"><i
                    class="fas fa-times fa-lg"></i></button>
        </div>
        <form id="roleForm">
            <input type="hidden" id="roleId" name="roleId">
            <div class="mb-4">
                <label for="nom_role" class="block text-sm font-medium text-gray-700 mb-1">Nom du Rôle</label>
                <input type="text" name="nom_role" id="nom_role" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
            </div>
            <div class="mb-4">
                <label for="description_role" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description_role" id="description_role" rows="3"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500"></textarea>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Permissions</label>
                <div
                    class="max-h-60 overflow-y-auto border border-gray-300 rounded-lg p-4 grid grid-cols-2 sm:grid-cols-3 gap-x-6 gap-y-2">
                    <?php foreach($availablePermissions as $permission): ?>
                    <label class="flex items-center">
                        <input type="checkbox" name="permissions[]" value="<?php echo htmlspecialchars($permission); ?>"
                            class="form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        <span
                            class="ml-2 text-sm text-gray-700"><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $permission))); ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" onclick="closeRoleModal()"
                    class="px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50">Annuler</button>
                <button type="submit"
                    class="px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600"><i
                        class="fas fa-save mr-2"></i><span id="roleModalSubmitButton">Enregistrer</span></button>
            </div>
        </form>
    </div>
</div>
<script>
// JavaScript for Role Modal
const roleModal = document.getElementById('roleModal');
const roleForm = document.getElementById('roleForm');
const roleModalTitle = document.getElementById('roleModalTitle');
const roleModalSubmitButton = document.getElementById('roleModalSubmitButton');

function openRoleModal(roleData = null) {
    roleForm.reset();
    // Uncheck all permission checkboxes
    roleForm.querySelectorAll('input[name="permissions[]"]').forEach(checkbox => checkbox.checked = false);

    if (roleData) {
        roleModalTitle.textContent = 'Modifier le Rôle';
        roleModalSubmitButton.textContent = 'Mettre à jour';
        document.getElementById('roleId').value = roleData.id;
        document.getElementById('nom_role').value = roleData.nom_role;
        document.getElementById('description_role').value = roleData.description;
        // In a real app, you'd fetch and check the role's specific permissions
        // For this example, let's assume roleData.permissions is an array of permission strings
        if (roleData.permissions && Array.isArray(roleData.permissions)) {
            roleData.permissions.forEach(perm => {
                const checkbox = roleForm.querySelector(`input[name="permissions[]"][value="${perm}"]`);
                if (checkbox) checkbox.checked = true;
            });
        }
    } else {
        roleModalTitle.textContent = 'Ajouter un Rôle';
        roleModalSubmitButton.textContent = 'Enregistrer';
        document.getElementById('roleId').value = '';
    }
    roleModal.classList.remove('hidden');
}

function closeRoleModal() {
    roleModal.classList.add('hidden');
}

roleForm.addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(roleForm);
    const data = {
        roleId: formData.get('roleId'),
        nom_role: formData.get('nom_role'),
        description_role: formData.get('description_role'),
        permissions: formData.getAll('permissions[]')
    };
    console.log('Submitting role data:', data);
    alert((data.roleId ? 'Modification' : 'Ajout') + ' du rôle ' + data.nom_role + ' simulé.');
    closeRoleModal();
});

document.getElementById('passwordPolicyForm').addEventListener('submit', function(event) {
    event.preventDefault();
    alert('Politique des mots de passe enregistrée (simulation).');
});
window.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && !roleModal.classList.contains('hidden')) {
        closeRoleModal();
    }
});
</script>