<?php
$action_a_modifier = $GLOBALS['action_a_modifier'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des actions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Le CSS Tailwind est supposé être chargé par le layout principal -->
</head>

<body class="bg-gray-100">
<div class="min-h-screen flex flex-col">
    <main class="flex-grow container mx-auto px-4 py-5">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-700">Gestion des actions</h2>
        </div>

        <!-- Formulaire d'Ajout ou de Modification -->
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b pb-3">
                <?php if (isset($_GET['id_action'])): ?>
                    Modifier l'action
                <?php else: ?>
                    Ajouter une nouvelle action
                <?php endif; ?>
            </h3>
            <form method="POST" action="?page=parametres_generaux&action=actions">
                <?php if ($action_a_modifier): ?>
                    <input type="hidden" name="id_action" value="<?= htmlspecialchars($action_a_modifier->id_action) ?>">
                <?php endif; ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-3 outline-none">Libellé de l'action</label>
                        <input type="text" id="actions" name="action" required
                               value="<?= $action_a_modifier ? htmlspecialchars($action_a_modifier->lib_action) : '' ?>"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 focus:border-0 transition-colors focus:outline-none">
                    </div>
                </div>

                <?php if (isset($_GET['id_action'])): ?>
                    <div class="flex justify-start space-x-3">
                        <button type="submit" name="btn_add_action"
                                class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-500 focus:ring-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Modifier l'action
                        </button>
                        <button type="submit" name="btn_annuler"
                                class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-orange-500 hover:bg-orange-600 focus:ring-orange-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </button>
                    </div>
                <?php else: ?>
                    <div class="flex justify-start space-x-3">
                        <button type="submit" name="btn_add_action"
                                class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600 focus:ring-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter l'action
                        </button>
                    </div>
                <?php endif; ?>
            </form>
        </div>

        <!-- Section Tableau et Actions (si on n'est pas en mode édition) -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Liste des actions</h3>
            <form method="POST" action="?page=parametres_generaux&action=actions" id="formListeActions">
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
                                        Libellé de l'action
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <?php $listeActions = $GLOBALS['listeActions'] ?? []; ?>
                                <?php if (!empty($listeActions)) : ?>
                                    <?php foreach ($listeActions as $action) : ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 whitespace-nowrap text-center">
                                                <input type="checkbox" name="selected_ids[]" value="<?= htmlspecialchars($action->id_action) ?>"
                                                       class="row-checkbox form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <?= htmlspecialchars($action->id_action) ?>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                                <?= htmlspecialchars($action->lib_action) ?>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-center">
                                                <a href="?page=parametres_generaux&action=actions&id_action=<?= $action->id_action ?>"
                                                   class="text-center text-orange-500 hover:underline"><i
                                                            class="fas fa-pen"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-sm text-gray-500 py-4">
                                            Aucune action enregistrée.
                                        </td>
                                    </tr>
                                <?php endif; ?>
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
    </main>
</div>
<script>
    // Script pour le fonctionnement de la sélection "Tout cocher"
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');

        if(selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                rowCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });
        }
    });
</script>
</body>

</html>