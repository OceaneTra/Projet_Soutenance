<?php

$utilisateur_a_modifier = $GLOBALS['utilisateur_a_modifier'];

$utilisateurs = $GLOBALS['utilisateurs'] ?? [];
$niveau_acces = $GLOBALS['niveau_acces'];
$types_utilisateur =$GLOBALS['types_utilisateur'];
$groupes_utilisateur =$GLOBALS['groupes_utilisateur'] ;
$enseignants = $GLOBALS['enseignants'] ;
$etudiants = $GLOBALS['etudiants'];
$pers_admin = $GLOBALS['pers_admin'];


// Pagination
$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;


// Total pages calculation
$total_items = count($utilisateurs);
$total_pages = ceil($total_items / $limit);

// Slice the array for pagination
$utilisateurs = array_slice($utilisateurs, $offset, $limit);


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
    <style>
    /* Styles pour les notifications */
    .notification {
        position: fixed;
        top: 1rem;
        right: 1rem;
        padding: 1rem;
        border-radius: 0.5rem;
        color: white;
        max-width: 24rem;
        z-index: 50;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        animation: slideIn 0.5s ease-out;
    }

    .notification.success {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    }

    .notification.error {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }

        to {
            opacity: 0;
        }
    }
    </style>

</head>

<body class="bg-gray-50">

    <!-- Système de notification -->
    <?php if (!empty($GLOBALS['messageSuccess'])): ?>
    <div id="successNotification" class="notification success animate__animated animate__fadeIn">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <p><?= htmlspecialchars($GLOBALS['messageSuccess']) ?></p>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($GLOBALS['messageErreur'])): ?>
    <div id="errorNotification" class="notification error animate__animated animate__fadeIn">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <p><?= htmlspecialchars($GLOBALS['messageErreur']) ?></p>
        </div>
    </div>
    <?php endif; ?>
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
                <form id="userForm" class="space-y-4" method="POST" action="?page=gestion_utilisateurs">
                    <input type="hidden" id="userId" name="id_utilisateur"
                        value="<?php echo $utilisateur_a_modifier ? $utilisateur_a_modifier->id_utilisateur : ''; ?>">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="nom_utilisateur" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-user text-green-500 mr-2"></i>Nom d'utilisateur
                            </label>
                            <select name="nom_utilisateur" id="nom_utilisateur"
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white transition-all duration-200">
                                <option value="">Sélectionner un nom</option>

                                <?php
                                // Tableau pour stocker les noms déjà ajoutés
                                $noms_ajoutes = array();
                                
                                // Fonction pour vérifier si un nom existe déjà
                                function nomExisteDeja($nom, $prenom, &$noms_ajoutes) {
                                    $nom_complet = strtolower(trim($nom . ' ' . $prenom));
                                    if (isset($noms_ajoutes[$nom_complet])) {
                                        return true;
                                    }
                                    $noms_ajoutes[$nom_complet] = true;
                                    return false;
                                }
                                ?>

                                <!-- Groupe des Enseignants -->
                                <optgroup label="Enseignants">
                                    <?php foreach($enseignants as $enseignant): 
                                        if (!nomExisteDeja($enseignant->nom_enseignant, $enseignant->prenom_enseignant, $noms_ajoutes)): ?>
                                    <option
                                        value="<?php echo htmlspecialchars($enseignant->nom_enseignant . ' ' . $enseignant->prenom_enseignant); ?>"
                                        data-email="<?php echo htmlspecialchars($enseignant->mail_enseignant); ?>"
                                        <?php echo ($utilisateur_a_modifier && $enseignant->id_enseignant == $utilisateur_a_modifier->id_enseignant) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($enseignant->nom_enseignant . ' ' . $enseignant->prenom_enseignant); ?>
                                    </option>
                                    <?php endif; endforeach; ?>
                                </optgroup>

                                <!-- Groupe des Étudiants -->
                                <optgroup label="Étudiants">
                                    <?php foreach($etudiants as $etudiant): 
                                        if (!nomExisteDeja($etudiant->nom_etu, $etudiant->prenom_etu, $noms_ajoutes)): ?>
                                    <option
                                        value="<?php echo htmlspecialchars($etudiant->nom_etu . ' ' . $etudiant->prenom_etu); ?>"
                                        data-email="<?php echo htmlspecialchars($etudiant->login_etu); ?>"
                                        <?php echo ($utilisateur_a_modifier && $etudiant->num_etu == $utilisateur_a_modifier->num_etu) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($etudiant->nom_etu . ' ' . $etudiant->prenom_etu); ?>
                                    </option>
                                    <?php endif; endforeach; ?>
                                </optgroup>

                                <!-- Groupe du Personnel Administratif -->
                                <optgroup label="Personnel Administratif">
                                    <?php foreach($pers_admin as $admin): 
                                        if (!nomExisteDeja($admin->nom_pers_admin, $admin->prenom_pers_admin, $noms_ajoutes)): ?>
                                    <option
                                        value="<?php echo htmlspecialchars($admin->nom_pers_admin . ' ' . $admin->prenom_pers_admin); ?>"
                                        data-email="<?php echo htmlspecialchars($admin->email_pers_admin); ?>"
                                        <?php echo ($utilisateur_a_modifier && $admin->id_pers_admin == $utilisateur_a_modifier->id_pers_admin) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($admin->nom_pers_admin . ' ' . $admin->prenom_pers_admin); ?>
                                    </option>
                                    <?php endif; endforeach; ?>
                                </optgroup>
                            </select>

                        </div>
                        <div class="space-y-2">
                            <label for="login_utilisateur" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-envelope text-green-500 mr-2"></i>Login
                            </label>
                            <input type="email" name="login_utilisateur" id="login_utilisateur" required
                                value="<?php echo $utilisateur_a_modifier ? htmlspecialchars($utilisateur_a_modifier->login_utilisateur) : ''; ?>"
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="id_type_utilisateur" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-id-badge text-green-500 mr-2"></i>Type utilisateur
                            </label>
                            <select name="id_type_utilisateur" id="id_type_utilisateur" required
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white transition-all duration-200">
                                <option value="">Sélectionner un type utilisateur</option>
                                <?php foreach($types_utilisateur as $type): ?>
                                <option value="<?php echo htmlspecialchars($type->id_type_utilisateur); ?>"
                                    <?php echo ($utilisateur_a_modifier && $type->id_type_utilisateur == $utilisateur_a_modifier->id_type_utilisateur) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($type->lib_type_utilisateur); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label for="statut_utilisateur" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-toggle-on text-green-500 mr-2"></i>Statut
                            </label>
                            <select name="statut_utilisateur" id="statut_utilisateur" required
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white transition-all duration-200">
                                <option value="1"
                                    <?php echo ($utilisateur_a_modifier && $utilisateur_a_modifier->statut_utilisateur) ? 'selected' : ''; ?>>
                                    Actif</option>
                                <option value="0"
                                    <?php echo ($utilisateur_a_modifier && !$utilisateur_a_modifier->statut_utilisateur) ? 'selected' : ''; ?>>
                                    Inactif</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="id_GU" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-users text-green-500 mr-2"></i>Groupe utilisateur
                            </label>
                            <select name="id_GU" id="id_GU" required
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white transition-all duration-200">
                                <option value="">Sélectionner un groupe utilisateur</option>
                                <?php foreach($groupes_utilisateur as $groupe): ?>
                                <option value="<?php echo htmlspecialchars($groupe->id_GU); ?>"
                                    <?php echo ($utilisateur_a_modifier && $groupe->id_GU == $utilisateur_a_modifier->id_GU) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($groupe->lib_GU); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label for="id_niveau_acces" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-lock text-green-500 mr-2"></i>Niveau d'accès
                            </label>
                            <select name="id_niveau_acces" id="id_niveau_acces" required
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white transition-all duration-200">
                                <option value="">Sélectionner un niveau</option>
                                <?php foreach($niveau_acces as $niveau): ?>
                                <option value="<?php echo htmlspecialchars($niveau->id_niveau_acces_donnees); ?>"
                                    <?php echo ($utilisateur_a_modifier && $niveau->id_niveau_acces_donnees == $utilisateur_a_modifier->id_niveau_acces) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($niveau->lib_niveau_acces_donnees); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <button type="button" onclick="closeUserModal()"
                            class="px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200">
                            <i class="fas fa-times mr-2"></i>Annuler
                        </button>
                        <button type="submit"
                            name="<?php echo $utilisateur_a_modifier ? 'btn_modifier_utilisateur' : 'btn_add_utilisateur'; ?>"
                            class="px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient hover:shadow-lg transition-all duration-200">
                            <i class="fas fa-save mr-2"></i><span
                                id="userModalSubmitButton"><?php echo $utilisateur_a_modifier ? 'Modifier' : 'Enregistrer'; ?></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bulk Add Users Modal -->
        <div id="bulkUserModal"
            class="fixed inset-0 bg-opacity-50 border border-gray-200 overflow-y-auto h-full w-full z-50 flex hidden items-center justify-center modal-transition">
            <div class="relative p-8 w-full max-w-4xl shadow-2xl rounded-xl bg-white fade-in transform">
                <div class="absolute top-0 right-0 m-3">
                    <button onclick="closeBulkUserModal()"
                        class="text-gray-400 hover:text-gray-600 focus:outline-none btn-icon">
                        <i class="fas fa-times fa-lg"></i>
                    </button>
                </div>
                <div class="flex items-center mb-6 pb-2 border-b border-gray-200">
                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                        <i class="fas fa-users text-blue-500"></i>
                    </div>
                    <h3 class="text-2xl font-semibold text-gray-700">Ajouter des Utilisateurs en masse</h3>
                </div>
                <form id="bulkUserForm" class="space-y-4" method="POST" action="?page=gestion_utilisateurs">
                    <div class="grid grid-cols-1 gap-6">
                        <div class="space-y-2">
                            <label for="userType" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-user-tag text-blue-500 mr-2"></i>Type d'utilisateur
                            </label>
                            <select name="userType" id="userType" required onchange="loadUsersList()"
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition-all duration-200">
                                <option value="">Sélectionner un type d'utilisateur</option>
                                <?php foreach($types_utilisateur as $type): ?>
                                <option value="<?php echo htmlspecialchars($type->id_type_utilisateur); ?>">
                                    <?php echo htmlspecialchars($type->lib_type_utilisateur); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-list text-blue-500 mr-2"></i>Liste des utilisateurs
                            </label>
                            <div class="flex justify-between items-center mb-2">
                                <button type="button" onclick="toggleSelectAll()"
                                    class="text-sm text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-check-square mr-1"></i>Sélectionner tout
                                </button>
                            </div>
                            <div class="border border-gray-300 rounded-lg p-4 max-h-96 overflow-y-auto">
                                <div id="usersList" class="space-y-2">
                                    <?php if (isset($GLOBALS['users_list'])): ?>
                                    <?php if (empty($GLOBALS['users_list'])): ?>
                                    <div class="text-center text-gray-500 py-4">
                                        <i class="fas fa-users text-gray-300 text-4xl mb-2"></i>
                                        <p>Aucun utilisateur disponible pour ce type.</p>
                                    </div>
                                    <?php else: ?>
                                    <?php foreach ($GLOBALS['users_list'] as $user): ?>
                                    <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded">
                                        <input type="checkbox" name="selected_users[]"
                                            value="<?php echo htmlspecialchars($user['id']); ?>"
                                            class="user-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <div class="flex-1">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?php echo htmlspecialchars($user['nom'] . ' ' . $user['prenom']); ?>
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                <?php echo htmlspecialchars($user['email']); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="id_GU" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-users text-blue-500 mr-2"></i>Groupe utilisateur
                            </label>
                            <select name="id_GU" id="id_GU" required
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white transition-all duration-200">
                                <option value="">Sélectionner un groupe utilisateur</option>
                                <?php foreach($groupes_utilisateur as $groupe): ?>
                                <option value="<?php echo htmlspecialchars($groupe->id_GU); ?>">
                                    <?php echo htmlspecialchars($groupe->lib_GU); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-between mt-6">
                        <button type="button" onclick="closeBulkUserModal()"
                            class="px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 transition-all duration-200">
                            <i class="fas fa-times mr-2"></i>Annuler
                        </button>
                        <button type="submit" name="btn_add_bulk_users"
                            class="px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200">
                            <i class="fas fa-save mr-2"></i>Enregistrer
                        </button>
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
                <div class="flex space-x-4">
                    <button onclick="openBulkUserModal()"
                        class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <i class="fas fa-users mr-2"></i>Ajouter en masse
                    </button>
                    <button onclick="openUserModal(null)"
                        class="bg-green-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                        <i class="fas fa-plus mr-2"></i>Ajouter un Utilisateur
                    </button>
                </div>
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
                    <button onclick="printTable()"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg shadow transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                        <i class="fas fa-print mr-2"></i>Imprimer
                    </button>
                    <button onclick="exportToExcel()"
                        class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg shadow transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50">
                        <i class="fas fa-file-export mr-2"></i>Exporter
                    </button>
                    <div class="flex space-x-2">
                        <button id="desactiverButton" type="button"
                            class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-lg shadow transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                            <i class="fa-solid fa-eye-slash mr-2"></i>Désactiver
                        </button>
                        <button id="reactiverButton" type="button"
                            class="bg-green-500 hover:bg-green-600 text-white font-medium py-2 px-4 rounded-lg shadow transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                            <i class="fa-solid fa-eye mr-2"></i>Réactiver
                        </button>
                    </div>
                </div>
            </div>

            <!-- Users Table -->

            <form class="overflow-x-auto" method="POST" action="?page=gestion_utilisateurs" id="formListeUtilisateurs">
                <input type="hidden" name="btn_desactiver_multiple" value="0">
                <input type="hidden" name="btn_reactiver_multiple" value="0">
                <input type="hidden" name="action" id="actionType" value="">
                <input type="hidden" name="selected_users" id="selectedUsers" value="">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-center">
                                <input type="checkbox" id="selectAllCheckbox"
                                    class="form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500 cursor-pointer">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Nom d'utilisateur</span>
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
                                    <span>Groupe utilisateur</span>
                                    <i class="fas fa-sort ml-1 text-gray-400"></i>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <div class="flex items-center">
                                    <span>Statut</span>
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
                                <input type="checkbox" name="userCheckbox[]"
                                    value="<?php echo htmlspecialchars($user->id_utilisateur); ?>"
                                    class="user-checkbox form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500 cursor-pointer">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex items-center">

                                    <span><?php echo htmlspecialchars($user->nom_utilisateur); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex items-center">

                                    <span><?php echo htmlspecialchars($user->role_utilisateur); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex items-center">

                                    <span><?php echo htmlspecialchars($user->lib_GU); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex items-center">

                                    <span><?php echo htmlspecialchars($user->statut_utilisateur); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                    <?php echo htmlspecialchars($user->login_utilisateur); ?>
                                </div>
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
            </form>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
            <div class="bg-white rounded-lg shadow-sm p-4 mt-6">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-sm text-gray-500">
                        Affichage de <?= $offset + 1 ?> à <?= min($offset + $limit, $total_items) ?> sur
                        <?= $total_items ?> entrées
                    </div>
                    <div class="flex flex-wrap justify-center gap-2">
                        <?php if ($page > 1): ?>
                        <a href="?page=gestion_utilisateurs&p=<?= $page - 1 ?>&search=<?= urlencode($search) ?>"
                            class="btn-hover px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            <i class="fas fa-chevron-left mr-1"></i>Précédent
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
                        <a href="?page=gestion_utilisateurs&p=<?= $i ?>&search=<?= urlencode($search) ?>"
                            class="btn-hover px-3 py-2 <?= $i === $page ? 'btn-gradient-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-50' ?> border border-gray-300 rounded-lg text-sm font-medium">
                            <?= $i ?>
                        </a>
                        <?php endfor;

                        if ($end < $total_pages) {
                            echo '<span class="px-3 py-2 text-gray-500">...</span>';
                        }
                        ?>

                        <?php if ($page < $total_pages): ?>
                        <a href="?page=gestion_utilisateurs&p=<?= $page + 1 ?>&search=<?= urlencode($search) ?>"
                            class="btn-hover px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Suivant<i class="fas fa-chevron-right ml-1"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <!-- Footer -->
        <div class="mt-8 text-center text-gray-500 text-sm">
            <p>© 2025 Système de Gestion des Utilisateurs. Tous droits réservés.</p>
        </div>
    </div>

    <!-- Modal de confirmation de désactivation -->
    <div id="confirmDesactivationModal" class="fixed inset-0 shadow-lg bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Confirmer la désactivation</h3>
                        <button type="button" onclick="closeConfirmModal('confirmDesactivationModal')"
                            class="text-gray-400 hover:text-gray-500">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <p class="text-gray-600 mb-6">Êtes-vous sûr de vouloir désactiver les utilisateurs sélectionnés ?
                    </p>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeConfirmModal('confirmDesactivationModal')"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Annuler
                        </button>
                        <button type="button" name="btn_desactiver_utilisateur" id="btn_desactiver_utilisateur"
                            class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-medium hover:bg-red-700">
                            Désactiver
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation d'activation -->
    <div id="confirmActivationModal" class="fixed inset-0 shadow-lg bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Confirmer l'activation</h3>
                        <button type="button" onclick="closeConfirmModal('confirmActivationModal')"
                            class="text-gray-400 hover:text-gray-500">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <p class="text-gray-600 mb-6">Êtes-vous sûr de vouloir activer les utilisateurs sélectionnés ?</p>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeConfirmModal('confirmActivationModal')"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Annuler
                        </button>
                        <button type="submit" form="formListeUtilisateurs" name="btn_reactiver_multiple" value="1"
                            class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700">
                            Activer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Variables pour le modal utilisateur
    const userModal = document.getElementById('userModal');
    const userForm = document.getElementById('userForm');
    const userModalTitle = document.getElementById('userModalTitle');
    const userModalSubmitButton = document.getElementById('userModalSubmitButton');
    const searchInput = document.getElementById('searchInput');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const deleteButton = document.getElementById('desactiverButton');
    const reactiverButton = document.getElementById('reactiverButton');
    const formListeUtilisateurs = document.getElementById('formListeUtilisateurs');

    // Fonction pour ouvrir la modale de modification
    function openUserModal(userData) {
        if (userData) {
            userModalTitle.textContent = 'Modifier l\'Utilisateur';
            userModalSubmitButton.textContent = 'Mettre à jour';

            // Remplir les champs du formulaire avec les données de l'utilisateur
            document.getElementById('userId').value = userData.id_utilisateur;
            document.getElementById('nom_utilisateur').value = userData.nom_utilisateur;
            document.getElementById('login_utilisateur').value = userData.login_utilisateur;
            document.getElementById('id_type_utilisateur').value = userData.id_type_utilisateur;
            document.getElementById('id_GU').value = userData.id_GU;
            document.getElementById('statut_utilisateur').value = userData.statut_utilisateur ? '1' : '0';
            document.getElementById('id_niveau_acces').value = userData.id_niveau_acces;
        } else {
            userModalTitle.textContent = 'Ajouter un Utilisateur';
            userModalSubmitButton.textContent = 'Enregistrer';
            userForm.reset();
        }
        userModal.classList.remove('hidden');
    }

    // Fonction pour fermer la modale
    function closeUserModal() {
        userModal.classList.add('hidden');
        userForm.reset();
    }

    // Fonction pour ouvrir les modales de confirmation
    function openConfirmModal(modalId) {
        const selectedUsers = document.querySelectorAll('.user-checkbox:checked');
        if (selectedUsers.length === 0) {
            alert('Veuillez sélectionner au moins un utilisateur');
            return;
        }
        document.getElementById(modalId).classList.remove('hidden');
    }

    // Fonction pour fermer les modales de confirmation
    function closeConfirmModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Gestionnaire d'événements pour les boutons d'activation/désactivation
    document.getElementById('desactiverButton').addEventListener('click', () => openConfirmModal(
        'confirmDesactivationModal'));
    document.getElementById('reactiverButton').addEventListener('click', () => openConfirmModal(
        'confirmActivationModal'));

    // Gestionnaire d'événements pour le formulaire d'ajout/modification
    userForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('?page=gestion_utilisateurs', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                    closeUserModal();
                    refreshUserList();
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                showNotification('Une erreur est survenue', 'error');
                console.error('Erreur:', error);
            });
    });

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('#usersTableBody tr');

        tableRows.forEach(row => {
            const username = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const email = row.querySelector('td:nth-child(6)').textContent.toLowerCase();

            if (username.includes(searchTerm) || email.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

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

    // Fonction pour exporter en Excel
    function exportToExcel() {
        const table = document.querySelector('table');
        const rows = Array.from(table.querySelectorAll('tr'));

        // Créer le contenu CSV
        let csvContent = "data:text/csv;charset=utf-8,";

        // Ajouter les en-têtes
        const headers = Array.from(rows[0].querySelectorAll('th'))
            .map(header => header.textContent.trim())
            .filter(header => header !== ''); // Exclure la colonne des checkboxes
        csvContent += headers.join(',') + '\n';

        // Ajouter les données
        rows.slice(1).forEach(row => {
            const cells = Array.from(row.querySelectorAll('td'))
                .slice(1, -1) // Exclure la colonne des checkboxes et des actions
                .map(cell => `"${cell.textContent.trim()}"`);
            csvContent += cells.join(',') + '\n';
        });

        // Créer le lien de téléchargement
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement('a');
        link.setAttribute('href', encodedUri);
        link.setAttribute('download', 'utilisateurs.csv');
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }


    // Fonction pour imprimer
    function printTable() {
        const table = document.querySelector('table');
        const printWindow = window.open('', '_blank');

        // Créer une copie de la table pour la modification
        const tableClone = table.cloneNode(true);

        // Supprimer les colonnes ID, Actions et Checkboxes
        const rows = tableClone.querySelectorAll('tr');
        rows.forEach(row => {
            // Supprimer la colonne des checkboxes (première colonne)
            const checkboxCell = row.querySelector('th:first-child, td:first-child');
            if (checkboxCell) checkboxCell.remove();


            // Supprimer la colonne Actions (dernière colonne)
            const actionCell = row.querySelector('th:last-child, td:last-child');
            if (actionCell) actionCell.remove();
        });

        printWindow.document.write(`
            <html>
                <head>
                    <title>Liste des utilisateurs</title>
                    <style>
                        table { width: 100%; border-collapse: collapse; }
                        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                        th { background-color: #f5f5f5; }
                        @media print {
                            body { margin: 0; padding: 15px; }
                        }
                    </style>
                </head>
                <body>
                    <h2>Liste des utilisateurs</h2>
                    ${tableClone.outerHTML}
                </body>
            </html>
        `);

        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
        printWindow.close();
    }


    // Gestion des notifications
    document.addEventListener('DOMContentLoaded', function() {
        const successNotification = document.getElementById('successNotification');
        const errorNotification = document.getElementById('errorNotification');

        if (successNotification) {
            setTimeout(() => {
                successNotification.classList.remove('animate__fadeIn');
                successNotification.classList.add('animate__fadeOut');
                setTimeout(() => {
                    successNotification.remove();
                }, 500);
            }, 5000);
        }

        if (errorNotification) {
            setTimeout(() => {
                errorNotification.classList.remove('animate__fadeIn');
                errorNotification.classList.add('animate__fadeOut');
                setTimeout(() => {
                    errorNotification.remove();
                }, 500);
            }, 5000);
        }
    });

    function openBulkUserModal() {
        document.getElementById('bulkUserModal').classList.remove('hidden');
    }

    function closeBulkUserModal() {
        document.getElementById('bulkUserModal').classList.add('hidden');
    }

    function loadUsersList() {
        const userType = document.getElementById('userType').value;
        const usersList = document.getElementById('usersList');

        if (!userType) {
            usersList.innerHTML = '';
            return;
        }

        // Afficher un indicateur de chargement
        usersList.innerHTML =
            '<div class="text-center py-4"><i class="fas fa-spinner fa-spin text-blue-500 text-2xl"></i><p class="mt-2 text-gray-500">Chargement...</p></div>';

        // Faire une requête AJAX
        fetch(`?page=gestion_utilisateurs&action=get_users&type=${userType}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.type === 'usersList') {
                    usersList.innerHTML = data.content;
                }
            })
            .catch(error => {
                console.error('Erreur lors du chargement des utilisateurs:', error);
                usersList.innerHTML =
                    '<div class="text-center text-red-500 py-4"><i class="fas fa-exclamation-circle text-2xl"></i><p class="mt-2">Erreur lors du chargement des utilisateurs</p></div>';
            });
    }

    // Fonction pour sélectionner/désélectionner tous les utilisateurs
    function toggleSelectAll() {
        const checkboxes = document.querySelectorAll('.user-checkbox');
        const selectAllButton = document.querySelector('button[onclick="toggleSelectAll()"]');
        const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

        checkboxes.forEach(checkbox => {
            checkbox.checked = !allChecked;
        });

        // Mettre à jour le texte du bouton
        selectAllButton.innerHTML = allChecked ?
            '<i class="fas fa-check-square mr-1"></i>Sélectionner tout' :
            '<i class="fas fa-square mr-1"></i>Désélectionner tout';
    }

    // Ajouter un iframe caché pour la soumission du formulaire
    document.addEventListener('DOMContentLoaded', function() {
        const iframe = document.createElement('iframe');
        iframe.name = 'usersListFrame';
        iframe.style.display = 'none';
        document.body.appendChild(iframe);

        // Écouter les messages de l'iframe
        window.addEventListener('message', function(e) {
            if (e.data.type === 'usersList') {
                document.getElementById('usersList').innerHTML = e.data.content;
            }
        });
    });

    // Fonction pour mettre à jour le champ login en fonction de la sélection
    document.getElementById('nom_utilisateur').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const email = selectedOption.getAttribute('data-email');
        const loginField = document.getElementById('login_utilisateur');

        if (email) {
            loginField.value = email;
        } else {
            loginField.value = '';
        }
    });

    // Fonction pour mettre à jour la liste des utilisateurs
    function updateUsersList() {
        const select = document.getElementById('nom_utilisateur');
        const currentValue = select.value;

        // Sauvegarder l'option par défaut
        const defaultOption = select.options[0];

        // Vider le select
        select.innerHTML = '';
        select.appendChild(defaultOption);

        // Recharger la page pour obtenir la liste mise à jour
        window.location.reload();
    }
    </script>
    <?php
    unset($_SESSION['messageSucces'], $_SESSION['messageErreur']);
    ?>
</body>

</html>