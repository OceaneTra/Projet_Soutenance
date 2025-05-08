<?php

// --- Placeholder data for dropdowns - In a real application, fetch this from your database ---
$groupesUtilisateurs = [
    ['id' => 1, 'nom' => 'Administrateurs'],
    ['id' => 2, 'nom' => 'Gestionnaires RH'],
    ['id' => 3, 'nom' => 'Enseignants'],
    ['id' => 4, 'nom' => 'Étudiants'],
];

$niveauxAcces = [
    ['id' => 'level1', 'nom' => 'Accès Total'],
    ['id' => 'level2', 'nom' => 'Accès Édition'],
    ['id' => 'level3', 'nom' => 'Accès Lecture Seule'],
];

// Placeholder for roles/fonctions (used in both forms)
$roles = ['Administrateur', 'Éditeur', 'Lecteur', 'Membre RH', 'Enseignant', 'Secrétaire', 'Comptable'];

// Placeholder data for users table (used later in the file)
$users = [
    ['id' => 1, 'username' => 'admin_user', 'email' => 'admin@example.com', 'role' => 'Administrateur', 'groupe_utilisateur_id' => 1, 'groupe_utilisateur' => 'Administrateurs', 'niveau_acces_id' => 'level1', 'niveau_acces' => 'Accès Total', 'status' => 'Actif', 'created_at' => '2023-01-15'],
    ['id' => 2, 'username' => 'editor_user', 'email' => 'editor@example.com', 'role' => 'Éditeur', 'groupe_utilisateur_id' => 3, 'groupe_utilisateur' => 'Enseignants', 'niveau_acces_id' => 'level2', 'niveau_acces' => 'Accès Édition', 'status' => 'Actif', 'created_at' => '2023-02-20'],
    ['id' => 3, 'username' => 'viewer_user', 'email' => 'viewer@example.com', 'role' => 'Lecteur', 'groupe_utilisateur_id' => 4, 'groupe_utilisateur' => 'Étudiants', 'niveau_acces_id' => 'level3', 'niveau_acces' => 'Accès Lecture Seule', 'status' => 'Inactif', 'created_at' => '2023-03-10'],
];
// Ensure Font Awesome is linked in your main layout (e.g., layout_admin.php)

// --- Formulaire d'ajout d'utilisateur (NON-MODAL / Formulaire Supérieur) ---
// Ce formulaire est distinct du modal.
?>
<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg my-8 p-6 md:p-8">
    <div class="flex flex-col sm:flex-row justify-between sm:items-center mb-6 border-b border-gray-200 pb-4">
        <h2 class="text-2xl font-semibold text-green-500">Ajouter un Nouvel Utilisateur</h2>
        <div class="mt-3 sm:mt-0 mb-3">
            <label for="top_date_jour" class="block text-sm font-medium text-gray-600 mb-1">Date du jour</label>
            <input type="text" id="top_date_jour" name="top_date_jour" value="<?php echo date('d/m/Y'); ?>" readonly
                class="w-full sm:w-32 px-3 py-2 border border-gray-300 text-sm rounded-md bg-gray-100 focus:outline-none">
        </div>
    </div>

    <form id="topUserAddForm" method="POST" action="votre_script_de_traitement.php " class="flex flex-col space-y-4">
        <?php // Adaptez l'action du formulaire ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mb-6">
            <div>
                <label for="top_add_username" class="block text-sm font-medium text-gray-700 mb-3">Nom Utilisateur <span
                        class="text-red-500">*</span></label>
                <input type="text" id="top_add_username" name="username" required style="width: 80%;"
                    class=" px-3 py-2 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>

            <div>
                <label for="top_add_fonction" class="block text-sm font-medium text-gray-700 mb-3">Fonction (Rôle) <span
                        class="text-red-500">*</span></label>
                <div class="relative" style="width: 80%;">
                    <select id="top_add_fonction" name="fonction" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white appearance-none">
                        <option value="">Sélectionner une fonction...</option>
                        <?php foreach ($roles as $role): ?>
                        <option value="<?php echo htmlspecialchars($role); ?>"><?php echo htmlspecialchars($role); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
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
                <label for="top_add_groupe_utilisateur" class="block text-sm font-medium text-gray-700 mb-3 mt-2">Groupe
                    utilisateur <span class="text-red-500">*</span></label>
                <div class="relative" style="width: 80%;">
                    <select id="top_add_groupe_utilisateur" name="groupe_utilisateur_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white appearance-none">
                        <option value="">Sélectionner un groupe...</option>
                        <?php foreach ($groupesUtilisateurs as $groupe): ?>
                        <option value="<?php echo htmlspecialchars($groupe['id']); ?>">
                            <?php echo htmlspecialchars($groupe['nom']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
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
                <label for="top_add_niveau_acces" class="block text-sm font-medium text-gray-700 mb-3 mt-2">Niveau
                    d'accès
                    <span class="text-red-500">*</span></label>
                <div class="relative" style="width: 80%;">
                    <select id="top_add_niveau_acces" name="niveau_acces_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white appearance-none">
                        <option value="">Sélectionner un niveau...</option>
                        <?php foreach ($niveauxAcces as $niveau): ?>
                        <option value="<?php echo htmlspecialchars($niveau['id']); ?>">
                            <?php echo htmlspecialchars($niveau['nom']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
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
                <label for="top_add_login" class="block text-sm font-medium text-gray-700 mb-3 mt-2">Login (Email) <span
                        class="text-red-500">*</span></label>
                <input type="email" id="top_add_login" name="email" placeholder="utilisateur@example.com" required
                    style="width: 80%;"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>

            <div>
                <label for="top_add_password" class="block text-sm font-medium text-gray-700 mb-3 mt-2">Mot de passe
                    <span class="text-red-500">*</span></label>
                <input type="password" id="top_add_password" name="password" required style="width: 80%;"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>

            <div>
                <label for="top_add_type_utilisateur" class="block text-sm font-medium text-gray-700 mb-3 mt-2">Type
                    Utilisateur</label>
                <input type="text" id="top_add_type_utilisateur" name="type_utilisateur" style="width: 80%;"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>
            <div>
                <label for="top_add_status" class="block text-sm font-medium text-gray-700 mb-3 mt-2">Statut <span
                        class="text-red-500">*</span></label>
                <div class="relative" style="width: 80%;">
                    <select id="top_add_status" name="status" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white appearance-none">
                        <option value="Actif">Actif</option>
                        <option value="Inactif">Inactif</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none font-medium">
                        <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end items-end mt-8">
            <button type="submit"
                class="bg-green-500 text-white px-6 py-2.5 rounded-md text-sm font-medium hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 shadow-sm">
                <i class="fas fa-plus mr-2"></i>Ajouter un utilisateur
            </button>
        </div>
    </form>
</div>
<?php // Fin du formulaire sup��rieur non-modal ?>


<?php // --- LA SUITE DE VOTRE FICHIER (Table, Modal, JavaScript) COMMENCE ICI --- ?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-xl font-semibold text-green-500">Liste des utilisateurs</h2>
        <!-- Action Bar for Table -->
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-center">
            <div class="relative mb-4 sm:mb-0 w-full sm:w-1/3">
                <input type="text" id="userSearchInput" placeholder="Rechercher un utilisateur..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                <span class="absolute top-0 right-0 mt-2 mr-3">
                    <i class="fas fa-search text-gray-400"></i>
                </span>
            </div>
            <div>
                <button onclick="printUserList()"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow hover:shadow-md transition-all duration-150 ease-in-out mr-2">
                    <i class="fas fa-print mr-2"></i>Imprimer la liste
                </button>
                <button onclick="exportUserListCSV()"
                    class="bg-gray-700 hover:bg-gray-800 text-white font-semibold py-2 px-4 rounded-lg shadow hover:shadow-md transition-all duration-150 ease-in-out">
                    <i class="fas fa-file-export mr-2"></i>Exporter (CSV)
                </button>
            </div>
        </div>
    </div>



    <!-- Users Table -->
    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full w-full divide-y divide-gray-200" id="usersTable">
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
                            Groupe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Niveau Accès</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créé
                            le</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="usersTableBody">
                    <?php if (empty($users)): ?>
                    <tr id="noUsersRow">
                        <td colspan="9" class="px-6 py-12 text-center text-gray-500">Aucun utilisateur trouvé.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($users as $user): ?>
                    <tr data-user-id="<?php echo htmlspecialchars($user['id']); ?>">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo htmlspecialchars($user['id']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($user['username']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($user['email']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($user['role']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($user['groupe_utilisateur'] ?? 'N/A'); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($user['niveau_acces'] ?? 'N/A'); ?></td>
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
                            <button
                                onclick="deleteUser(<?php echo htmlspecialchars($user['id']); ?>, '<?php echo htmlspecialchars(addslashes($user['username'])); ?>')"
                                class="text-red-600 hover:text-red-900" title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div> <!-- Closing overflow-x-auto -->
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
    </div> <!-- Closing bg-white shadow-xl rounded-lg overflow-hidden -->
</div> <!-- Closing container mx-auto px-4 py-8 -->

<!-- Add/Edit User Modal -->
<div id="userModal"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden z-50">
    <div class="relative mx-auto p-6 md:p-8 border w-full max-w-2xl shadow-2xl rounded-xl bg-white">
        <div class="flex justify-between items-center mb-6">
            <h3 id="userModalTitle" class="text-2xl font-semibold text-gray-700">Ajouter un Utilisateur</h3>
            <button onclick="closeUserModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times fa-lg"></i>
            </button>
        </div>
        <form id="userForm">
            <input type="hidden" id="userId" name="userId">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Nom d'utilisateur <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="username" id="username" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span
                            class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    </td>