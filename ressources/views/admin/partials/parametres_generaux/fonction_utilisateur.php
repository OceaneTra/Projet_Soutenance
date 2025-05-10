<?php
// Assurez-vous que ces variables sont initialisées si elles viennent du contrôleur
// Pour les groupes
$groupes = $groupes ?? [];
$groupe_a_modifier = $groupe_a_modifier ?? null;
$message_groupe = $_SESSION['message_groupe'] ?? '';
$error_groupe = $_SESSION['error_groupe'] ?? '';
unset($_SESSION['message_groupe'], $_SESSION['error_groupe']);

// Pour les types/fonctions utilisateurs
$types_utilisateurs = $types_utilisateurs ?? []; // ou $fonctions_utilisateurs
$type_utilisateur_a_modifier = $type_utilisateur_a_modifier ?? null; // ou $fonction_utilisateur_a_modifier
$message_type_utilisateur = $_SESSION['message_type_utilisateur'] ?? '';
$error_type_utilisateur = $_SESSION['error_type_utilisateur'] ?? '';
unset($_SESSION['message_type_utilisateur'], $_SESSION['error_type_utilisateur']);

// Déterminer l'onglet actif (par défaut 'groupes')
$activeTab = $_GET['tab'] ?? 'groupes';
if (!in_array($activeTab, ['groupes', 'types'])) { // Valider la valeur de l'onglet
    $activeTab = 'groupes';
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des fonctions utilisateurs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Le CSS Tailwind est supposé être chargé par le layout principal -->
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow container mx-auto px-4 py-5">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-700">Gestion des fonctions utilisateurs</h2>
            </div>

            <!-- Système d'onglets -->
            <div class="mb-8">
                <div class="border-b border-gray-300">
                    <nav class="-mb-px flex space-x-4" aria-label="Tabs">
                        <a href="?page=parametres_generaux&action=fonction_utilisateur&tab=groupes"
                            class="tab-button whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm  hover:text-gray-700
                                  <?= ($activeTab === 'groupes') ? 'active border-green-500 text-green-600 bg-green-50' : 'border-transparent hover:border-gray-300' ?>">
                            <i class="fas fa-users-cog mr-2"></i> Groupes d'Utilisateurs
                        </a>
                        <a href="?page=parametres_generaux&action=fonction_utilisateur&tab=types"
                            class="tab-button whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm hover:text-gray-700
                                  <?= ($activeTab === 'types') ? 'active border-green-500 text-green-600 bg-green-50' : 'border-transparent hover:border-gray-300' ?>">
                            <i class="fas fa-user-tag mr-2"></i> Types d'Utilisateurs
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Contenu des onglets -->
            <div>
                <!-- Onglet Groupes d'Utilisateurs -->
                <div id="tab-groupes"
                    class="flex flex-col tab-content <?= ($activeTab === 'groupes') ? 'active' : '' ?>">
                    <?php if (!empty($message_groupe)): ?>
                    <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-md shadow-sm mb-6"
                        role="alert">
                        <p><?= htmlspecialchars($message_groupe) ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($error_groupe)): ?>
                    <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-md shadow-sm mb-6"
                        role="alert">
                        <p><?= htmlspecialchars($error_groupe) ?></p>
                    </div>
                    <?php endif; ?>

                    <h3 class="text-xl font-semibold text-gray-700 mb-4">Gestion des Groupes</h3>
                    <!-- Formulaire d'ajout/modification pour les Groupes -->
                    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8">
                        <h4 class="text-lg font-medium text-gray-600 mb-4">
                            <?= $groupe_a_modifier ? 'Modifier le groupe' : 'Ajouter un nouveau groupe' ?>
                        </h4>
                        <form method="POST" action="?page=parametres_generaux&action=fonction_utilisateur&tab=groupes">
                            <?php if ($groupe_a_modifier): ?>
                            <input type="hidden" name="id_groupe_edit"
                                value="<?= htmlspecialchars($groupe_a_modifier->id_groupe) ?>">
                            <!-- Adaptez le nom de la propriété ID -->
                            <?php endif; ?>
                            <div class="mb-4">
                                <label for="lib_groupe" class="block text-sm font-medium text-gray-600 mb-6">Nom du
                                    Groupe</label>
                                <input type="text" name="lib_groupe" id="lib_groupe" required
                                    value="<?= htmlspecialchars($groupe_a_modifier->lib_groupe ?? '') ?>"
                                    class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 focus:border-0">
                            </div>
                            <!-- Ajoutez ici les champs pour les permissions/droits du groupe si nécessaire -->
                            <div class="flex justify-start">
                                <button type="submit"
                                    name="<?= $groupe_a_modifier ? 'submit_edit_groupe' : 'submit_add_groupe' ?>"
                                    class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600">
                                    <i class="fas <?= $groupe_a_modifier ? 'fa-save' : 'fa-plus' ?> mr-2"></i>
                                    <?= $groupe_a_modifier ? 'Enregistrer' : 'Ajouter Groupe' ?>
                                </button>
                                <?php if ($groupe_a_modifier): ?>
                                <a href="?page=parametres_generaux&action=fonction_utilisateur&tab=groupes"
                                    class="ml-3 inline-flex items-center px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50">
                                    Annuler
                                </a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>

                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">Liste des groupes utilisateurs</h3>
                        <form method="POST" action="?page=parametres_generaux&action=GU" id="formListeGU">
                            <div class="flex flex-col lg:flex-row gap-6">
                                <!-- Table avec largeur fixe -->
                                <div style="width: 80%;"
                                    class="border border-collapse border-gray-200 bg-white rounded-xl shadow-lg overflow-hidden mb-6 lg:mb-0">
                                    <div class="overflow-x-auto w-full">
                                        <table class="w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="w-[5%] px-4 py-3 text-center">
                                                        <input type="checkbox" id="selectAllCheckbox"
                                                            class="form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                                    </th>
                                                    <th scope="col"
                                                        class="w-[10%] px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        ID
                                                    </th>
                                                    <th scope="col"
                                                        class="w-[25%] px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Libellé du goupe utilisateur
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-4 py-3 whitespace-nowrap text-center">
                                                        <input type="checkbox" name="selected_ids[]" value=""
                                                            class="row-checkbox form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                                    </td>
                                                    <td
                                                        class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">

                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">

                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Boutons avec largeur fixe -->
                                <div style="width: 10%;" class="flex flex-col gap-4 justify-center">

                                    <button type="submit" name="submit_delete_multiple" id="deleteSelectedBtnPHP"
                                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                        <i class="fas fa-trash-alt mr-2"></i>Supprimer
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Onglet Types d'Utilisateurs -->
                <div id="tab-types" class="tab-content <?= ($activeTab === 'types') ? 'active' : '' ?>">
                    <?php if (!empty($message_type_utilisateur)): ?>
                    <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-md shadow-sm mb-6"
                        role="alert">
                        <p><?= htmlspecialchars($message_type_utilisateur) ?></p>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($error_type_utilisateur)): ?>
                    <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-md shadow-sm mb-6"
                        role="alert">
                        <p><?= htmlspecialchars($error_type_utilisateur) ?></p>
                    </div>
                    <?php endif; ?>

                    <h3 class="text-xl font-semibold text-gray-700 mb-4">Gestion des Types d'Utilisateurs</h3>
                    <!-- Formulaire d'ajout/modification pour les Types d'Utilisateurs -->
                    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8">
                        <h4 class="text-lg font-medium text-gray-600 mb-4">
                            <?= $type_utilisateur_a_modifier ? 'Modifier le type d\'utilisateur' : 'Ajouter un nouveau type d\'utilisateur' ?>
                        </h4>
                        <form method="POST" action="?page=parametres_generaux&action=fonction_utilisateur&tab=types">
                            <?php if ($type_utilisateur_a_modifier): ?>
                            <input type="hidden" name="id_type_utilisateur_edit"
                                value="<?= htmlspecialchars($type_utilisateur_a_modifier->id_type_utilisateur) ?>">
                            <!-- Adaptez -->
                            <?php endif; ?>
                            <div class="mb-4">
                                <label for="lib_type_utilisateur"
                                    class="mb-2 block text-sm font-medium text-gray-600 ">Nom du Type
                                    d'Utilisateur</label>
                                <input type="text" name="lib_type_utilisateur" id="lib_type_utilisateur" required
                                    value="<?= htmlspecialchars($type_utilisateur_a_modifier->lib_type_utilisateur ?? '') ?>"
                                    class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 focus:border-0">
                            </div>
                            <div class="flex justify-start">
                                <button type="submit"
                                    name="<?= $type_utilisateur_a_modifier ? 'submit_edit_type_utilisateur' : 'submit_add_type_utilisateur' ?>"
                                    class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600">
                                    <i class="fas <?= $type_utilisateur_a_modifier ? 'fa-save' : 'fa-plus' ?> mr-2"></i>
                                    <?= $type_utilisateur_a_modifier ? 'Enregistrer' : 'Ajouter Type' ?>
                                </button>
                                <?php if ($type_utilisateur_a_modifier): ?>
                                <a href="?page=parametres_generaux&action=fonction_utilisateur&tab=types"
                                    class="ml-3 inline-flex items-center px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50">
                                    Annuler
                                </a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>

                    <!-- Tableau des Types d'Utilisateurs -->
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-gray-700 mb-4">Liste des types utilisateurs</h3>
                        <form method="POST" action="?page=parametres_generaux&action=type_utilisateur"
                            id="formListeTypeUtilisateur">
                            <div class="flex flex-col lg:flex-row gap-6">
                                <!-- Table avec largeur fixe -->
                                <div style="width: 80%;"
                                    class="border border-collapse border-gray-200 bg-white rounded-xl shadow-lg overflow-hidden mb-6 lg:mb-0">
                                    <div class="overflow-x-auto w-full">
                                        <table class="w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="w-[5%] px-4 py-3 text-center">
                                                        <input type="checkbox" id="selectAllCheckbox"
                                                            class="form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                                    </th>
                                                    <th scope="col"
                                                        class="w-[10%] px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        ID
                                                    </th>
                                                    <th scope="col"
                                                        class="w-[25%] px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Libellé du type utilisateur
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr class="hover:bg-gray-50 transition-colors">
                                                    <td class="px-4 py-3 whitespace-nowrap text-center">
                                                        <input type="checkbox" name="selected_ids[]" value=""
                                                            class="row-checkbox form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                                    </td>
                                                    <td
                                                        class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">

                                                    </td>
                                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">

                                                    </td>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Boutons avec largeur fixe -->
                                <div style="width: 10%;" class="flex flex-col gap-4 justify-center">

                                    <button type="submit" name="submit_delete_multiple" id="deleteSelectedBtnPHP"
                                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                        <i class="fas fa-trash-alt mr-2"></i>Supprimer
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>

</html>