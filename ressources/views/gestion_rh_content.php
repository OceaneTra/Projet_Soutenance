<?php
// Déterminer l'onglet actif (par défaut 'pers_admin')
$activeTab = $_GET['tab'] ?? 'pers_admin';
if (!in_array($activeTab, ['pers_admin', 'enseignant'])) { // Valider la valeur de l'onglet
    $activeTab = 'pers_admin';
}

// Messages et erreurs (simulés - à remplacer par votre logique)
$message_pers_admin = $_GET['message_admin'] ?? '';
$error_pers_admin = $_GET['error_admin'] ?? '';
$message_enseignant = $_GET['message_ens'] ?? '';
$error_enseignant = $_GET['error_ens'] ?? '';

// Simulation de données pour le personnel administratif
$personnel_admin = [
    ['id' => 1, 'nom' => 'Dupont', 'prenom' => 'Marie', 'email' => 'marie.dupont@ecole.fr', 'fonction' => 'Secrétaire', 'telephone' => '01 23 45 67 89'],
    ['id' => 2, 'nom' => 'Martin', 'prenom' => 'Jean', 'email' => 'jean.martin@ecole.fr', 'fonction' => 'Comptable', 'telephone' => '01 98 76 54 32'],
    ['id' => 3, 'nom' => 'Bernard', 'prenom' => 'Lucie', 'email' => 'lucie.bernard@ecole.fr', 'fonction' => 'Administrateur', 'telephone' => '01 45 67 89 01']
];

// Simulation de données pour les enseignants
$enseignants = [
    ['id' => 1, 'nom' => 'Leroy', 'prenom' => 'Thomas', 'email' => 'thomas.leroy@ecole.fr', 'login' => 'thomas.leroy@ecole.fr', 'specialite' => 'Histoire-Géographie'],
    ['id' => 2, 'nom' => 'Petit', 'prenom' => 'Sophie', 'email' => 'sophie.petit@ecole.fr', 'login' => 'sophie.petit@ecole.fr', 'specialite' => 'Histoire-Géographie'],
    ['id' => 3, 'nom' => 'Moreau', 'prenom' => 'Paul', 'email' => 'paul.moreau@ecole.fr', 'login' => 'sophie.petit@ecole.fr', 'specialite' => 'Histoire-Géographie']
];

// Gestion des actions CRUD (à implémenter selon votre logique backend)
$action = $_GET['action'] ?? '';
$id = $_GET['id'] ?? null;

// Structure pour le formulaire d'édition
$admin_edit = ['id' => '', 'nom' => '', 'prenom' => '', 'email' => '', 'fonction' => '', 'telephone' => ''];
$enseignant_edit = ['id' => '', 'nom' => '', 'prenom' => '', 'email' => '', 'login' => '', 'specialite' => ''];

// Simuler la récupération des données pour édition
if ($action === 'edit') {
    if ($activeTab === 'pers_admin' && $id !== null) {
        foreach ($personnel_admin as $person) {
            if ($person['id'] == $id) {
                $admin_edit = $person;
                break;
            }
        }
    } elseif ($activeTab === 'enseignant' && $id !== null) {
        foreach ($enseignants as $enseignant) {
            if ($enseignant['id'] == $id) {
                $enseignant_edit = $enseignant;
                break;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des ressources humaines</title>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow container mx-auto px-4 py-5">

            <!-- Système d'onglets -->
            <div class="mb-8">
                <div class="border-b border-gray-300">
                    <nav class="-mb-px flex space-x-4" aria-label="Tabs">
                        <a href="?page=gestion_rh&tab=pers_admin"
                            class="tab-button whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm  hover:text-gray-700
                                  <?= ($activeTab === 'pers_admin') ? 'active border-green-500 text-green-600 bg-green-50' : 'border-transparent hover:border-gray-300' ?>">
                            <i class="fas fa-users-cog mr-2"></i> Personnel administratif
                        </a>
                        <a href="?page=gestion_rh&tab=enseignant"
                            class="tab-button whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm hover:text-gray-700
                                  <?= ($activeTab === 'enseignant') ? 'active border-green-500 text-green-600 bg-green-50' : 'border-transparent hover:border-gray-300' ?>">
                            <i class="fas fa-user-tag mr-2"></i> Enseignants
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Contenu des onglets -->
            <div>
                <!-- Onglet Personnel administratif -->
                <div id="tab-pers-admin"
                    class="flex flex-col tab-content <?= ($activeTab === 'pers_admin') ? 'active' : '' ?>">
                    <?php if (!empty($message_pers_admin)): ?>
                    <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-md shadow-sm mb-6"
                        role="alert">
                        <p><?= htmlspecialchars($message_pers_admin) ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($error_pers_admin)): ?>
                    <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-md shadow-sm mb-6"
                        role="alert">
                        <p><?= htmlspecialchars($error_pers_admin) ?></p>
                    </div>
                    <?php endif; ?>

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-700">Gestion du personnel administratif</h3>
                        <button id="btn-add-admin" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow-sm
                                       transition duration-150 ease-in-out flex items-center">
                            <i class="fas fa-plus mr-2"></i> Ajouter un personnel
                        </button>
                    </div>
                    <!-- Action Bar for Table -->
                    <div
                        class="px-6 py-4 flex flex-col sm:flex-row justify-between items-center border-b border-gray-200">
                        <div class="relative w-full sm:w-1/2 lg:w-1/3 mb-4 sm:mb-0">
                            <input type="text" id="searchInput" placeholder="Rechercher un personnel..."
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

                    <!-- Table de listing du personnel administratif -->
                    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-center">
                                            <input type="checkbox" id="selectAllCheckbox"
                                                class="form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500 cursor-pointer">
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nom</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Prénom</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Fonction</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Téléphone</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($personnel_admin as $admin): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-4 text-center">
                                            <input type="checkbox" name="userCheckbox"
                                                value="<?php echo htmlspecialchars($admin['id']); ?>"
                                                class="user-checkbox form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500 cursor-pointer">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= htmlspecialchars($admin['id']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <?= htmlspecialchars($admin['nom']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <?= htmlspecialchars($admin['prenom']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= htmlspecialchars($admin['email']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= htmlspecialchars($admin['fonction']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= htmlspecialchars($admin['telephone']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2 justify-center">
                                                <a href="?page=gestion_rh&tab=pers_admin&action=edit&id=<?= $admin['id'] ?>"
                                                    class="text-indigo-600 hover:text-indigo-900">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Formulaire pour ajouter/modifier un personnel administratif -->
                    <div id="modal-admin" class="modal">
                        <div class="modal-content bg-white rounded-lg shadow-xl p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-700">
                                    <?= $admin_edit['id'] ? 'Modifier un membre du personnel' : 'Ajouter un membre du personnel' ?>
                                </h3>
                                <button class="modal-close text-gray-400 hover:text-gray-500">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <form action="?page=gestion_rh&tab=pers_admin" method="post" class="space-y-4">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($admin_edit['id']) ?>">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="nom"
                                            class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                                        <input type="text" name="nom" id="nom"
                                            value="<?= htmlspecialchars($admin_edit['nom']) ?>"
                                            class=" focus:outline-none mt-1 px-4 py-2.5 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            required>
                                    </div>

                                    <div>
                                        <label for="prenom"
                                            class="mb-2 block text-sm font-medium text-gray-700">Prénom</label>
                                        <input type="text" name="prenom" id="prenom"
                                            value="<?= htmlspecialchars($admin_edit['prenom']) ?>"
                                            class=" focus:outline-none mt-1 px-4 py-2.5 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            required>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="email"
                                            class="mb-2 block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" name="email" id="email"
                                            value="<?= htmlspecialchars($admin_edit['email']) ?>"
                                            class="focus:outline-none mt-1 px-4 py-2.5 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            required>
                                    </div>
                                    <div>
                                        <label for="tel"
                                            class="mb-2 block text-sm font-medium text-gray-700">Téléphone</label>
                                        <input type="phone" name="tel" id="tel"
                                            value="<?= htmlspecialchars($admin_edit['telephone']) ?>"
                                            class="focus:outline-none px-4 py-2.5 mt-1 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            required>
                                    </div>
                                </div>
                                <div>
                                    <label for="fonction"
                                        class="block text-sm font-medium text-gray-700 mb-2">Fonction</label>
                                    <select name="fonction" id="fonction" required
                                        class=" focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 bg-white transition-all duration-200  focus:outline-0 focus:border-0">
                                        <option value="">Secrétaire</option>
                                        <option value="">Comptable</option>
                                        <option value="">Responsable scolarité</option>
                                    </select>

                                </div>

                                <div class="flex justify-end pt-2">
                                    <button type="button"
                                        class="modal-close bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg mr-2">
                                        Annuler
                                    </button>
                                    <button type="submit" name="submit_admin"
                                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                                        <?= $admin_edit['id'] ? 'Modifier' : 'Enregistrer' ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Onglet Enseignants  -->
                <div id="tab-enseignant" class="tab-content <?= ($activeTab === 'enseignant') ? 'active' : '' ?>">
                    <?php if (!empty($message_enseignant)): ?>
                    <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-md shadow-sm mb-6"
                        role="alert">
                        <p><?= htmlspecialchars($message_enseignant) ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($error_enseignant)): ?>
                    <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-md shadow-sm mb-6"
                        role="alert">
                        <p><?= htmlspecialchars($error_enseignant) ?></p>
                    </div>
                    <?php endif; ?>

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-700">Gestion des enseignants</h3>
                        <button id="btn-add-enseignant" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow-sm
                                       transition duration-150 ease-in-out flex items-center">
                            <i class="fas fa-plus mr-2"></i> Ajouter un enseignant
                        </button>
                    </div>
                    <!-- Action Bar for Table -->
                    <div
                        class="px-6 py-4 flex flex-col sm:flex-row justify-between items-center border-b border-gray-200">
                        <div class="relative w-full sm:w-1/2 lg:w-1/3 mb-4 sm:mb-0">
                            <input type="text" id="searchInput" placeholder="Rechercher un enseignant..."
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

                    <!-- Table de listing des enseignants -->
                    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">

                                    <tr>
                                        <th scope="col" class="px-4 py-3 text-center">
                                            <input type="checkbox" id="selectAllCheckbox"
                                                class="form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500 cursor-pointer">
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nom</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Prénom</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Email</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Login</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Spécialité</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($enseignants as $enseignant): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-4 text-center">
                                            <input type="checkbox" name="userCheckbox"
                                                value="<?php echo htmlspecialchars($admin['id']); ?>"
                                                class="user-checkbox form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500 cursor-pointer">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= htmlspecialchars($enseignant['id']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <?= htmlspecialchars($enseignant['nom']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <?= htmlspecialchars($enseignant['prenom']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= htmlspecialchars($enseignant['email']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= htmlspecialchars($enseignant['login']) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= htmlspecialchars($enseignant['specialite']) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">

                                            <a href="?page=gestion_rh&tab=enseignant&action=edit&id=<?= $enseignant['id'] ?>"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Formulaire pour ajouter/modifier un enseignant -->
                    <div id="modal-enseignant" class="modal">
                        <div class="modal-content bg-white rounded-lg shadow-xl p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-700">
                                    <?= $enseignant_edit['id'] ? 'Modifier un enseignant' : 'Ajouter un enseignant' ?>
                                </h3>
                                <button class="modal-close text-gray-400 hover:text-gray-500">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                            <form action="?page=gestion_rh&tab=enseignant" method="post" class="space-y-4">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($enseignant_edit['id']) ?>">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="nom_enseignant"
                                            class="block text-sm font-medium text-gray-700 mb-2">Nom</label>
                                        <input type="text" name="nom" id="nom_enseignant"
                                            value="<?= htmlspecialchars($enseignant_edit['nom']) ?>"
                                            class="focus:outline-none mt-1 px-4 py-2.5 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            required>
                                    </div>

                                    <div>
                                        <label for="prenom_enseignant"
                                            class="block text-sm font-medium text-gray-700 mb-2">Prénom</label>
                                        <input type="text" name="prenom" id="prenom_enseignant"
                                            value="<?= htmlspecialchars($enseignant_edit['prenom']) ?>"
                                            class=" focus:outline-none mt-1 px-4 py-2.5 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            required>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="email_enseignant"
                                            class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" name="email" id="email_enseignant"
                                            value="<?= htmlspecialchars($enseignant_edit['email']) ?>"
                                            class=" focus:outline-none mt-1 px-4 py-2.5 focus:ring-green-500 focus:border-green-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            required>
                                    </div>

                                    <div>
                                        <label for="login"
                                            class="block text-sm font-medium text-gray-700 mb-2">Login</label>
                                        <input type="text" name="login" id="login"
                                            value="<?= htmlspecialchars($enseignant_edit['login']) ?>"
                                            class="mt-1 px-4 py-2.5 focus:ring-green-500 focus:border-green-500 block w-full focus:outline-none shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            required>
                                    </div>
                                </div>


                                <div>
                                    <label for="specialite_enseignant"
                                        class="block text-sm font-medium text-gray-700 mb-2">Spécialité</label>
                                    <select name="specialite" id="specialite" required
                                        class=" w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 bg-white transition-all duration-200 focus:outline-0 focus:border-0">
                                        <option value="">Mathématiques</option>
                                        <option value="">Mathématiques</option>
                                        <option value="">Mathématiques</option>
                                        <option value="">Mathématiques</option>

                                    </select>

                                </div>

                                <div class="flex justify-end pt-2">
                                    <button type="button"
                                        class="modal-close bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg mr-2">
                                        Annuler
                                    </button>
                                    <button type="submit" name="submit_enseignant"
                                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                                        <?= $enseignant_edit['id'] ? 'Modifier' : 'Ajouter' ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal de confirmation pour la suppression -->
    <div id="modal-confirm-delete" class="modal">
        <div class="modal-content bg-white rounded-lg shadow-xl p-6 max-w-md mx-auto">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Confirmer la suppression</h3>
                <p class="text-sm text-gray-500 mb-6">
                    Êtes-vous sûr de vouloir supprimer cet élément ? Cette action est irréversible.
                </p>
                <div class="flex justify-center space-x-3">
                    <button type="button"
                        class="modal-close bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">
                        Annuler
                    </button>
                    <form id="delete-form" action="" method="post" class="inline">
                        <input type="hidden" name="delete_id" id="delete_id" value="">
                        <input type="hidden" name="delete_type" id="delete_type" value="">
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Gestion des modaux
    const modals = {
        admin: document.getElementById('modal-admin'),
        enseignant: document.getElementById('modal-enseignant'),
        confirmDelete: document.getElementById('modal-confirm-delete')
    };

    // Boutons d'ouverture des modaux
    document.getElementById('btn-add-admin').addEventListener('click', () => {
        modals.admin.style.display = 'block';
    });

    document.getElementById('btn-add-enseignant').addEventListener('click', () => {
        modals.enseignant.style.display = 'block';
    });


    // Fermeture des modaux
    document.querySelectorAll('.modal-close').forEach(button => {
        button.addEventListener('click', () => {
            for (const key in modals) {
                modals[key].style.display = 'none';
            }
        });
    });

    // Fermer le modal quand on clique à l'extérieur
    window.addEventListener('click', (event) => {
        for (const key in modals) {
            if (event.target === modals[key]) {
                modals[key].style.display = 'none';
            }
        }
    });

    // Ouvrir automatiquement le modal d'édition si action=edit
    <?php if ($action === 'edit'): ?>
    <?php if ($activeTab === 'pers_admin'): ?>
    modals.admin.style.display = 'block';
    <?php elseif ($activeTab === 'enseignant'): ?>
    modals.enseignant.style.display = 'block';
    <?php endif; ?>
    <?php endif; ?>

    updateDeleteButtonState();

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