<?php
$fonction_a_modifier = $GLOBALS['fonction_a_modifier'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des fonctions </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Le CSS Tailwind est supposé être chargé par le layout principal -->
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow container mx-auto px-4 py-5">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-700">Gestion des fonctions</h2>
            </div>
            <!-- À placer avant ou au début de votre formulaire -->
            <?php if (!empty($GLOBALS['messageErreur'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($GLOBALS['messageErreur']); ?></span>
            </div>
            <?php endif; ?>
            <!-- À placer avant ou au début de votre formulaire -->
            <?php if (!empty($GLOBALS['messageSucces'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($GLOBALS['messageSucces']); ?></span>
            </div>
            <?php endif; ?>

            <!-- Formulaire d'Ajout ou de Modification -->
            <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8">
                <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b pb-3">
                    <?php if (isset($_GET['id_fonction'])): ?>
                        Modifier la fonction
                    <?php else: ?>
                        Ajouter une nouvelle fonction
                    <?php endif; ?>
                </h3>
                <form method="POST" action="?page=parametres_generaux&action=fonctions">
                    <?php if ($fonction_a_modifier): ?>
                        <input type="hidden" name="id_fonction" value="<?= htmlspecialchars($fonction_a_modifier->id_fonction) ?>">
                    <?php endif; ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-3 outline-none">Libellé de la
                                fonction</label>
                            <input type="text" id="fonctions" name="fonction" required
                                   value="<?= $fonction_a_modifier ? htmlspecialchars($fonction_a_modifier->lib_fonction) : '' ?>"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-colors focus:border-0">
                        </div>

                    </div>
                    <?php if (isset($_GET['id_fonction'])): ?>
                        <div class="flex justify-start space-x-3">
                            <button type="submit" name="btn_add_fonction"
                                    class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-500 focus:ring-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                Modifier la fonction
                            </button>
                            <button type="submit" name="btn_annuler"
                                    class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-orange-500 hover:bg-orange-600 focus:ring-orange-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-times mr-2"></i>
                                Annuler
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="flex justify-start space-x-3">
                            <button type="submit" name="btn_add_fonction"
                                    class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600 focus:ring-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                                <i class="fas fa-plus mr-2"></i>
                                Ajouter la fonction
                            </button>
                        </div>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Section Tableau et Actions (si on n'est pas en mode édition) -->

            <div class="mt-8">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Liste des fonctions</h3>
                <form method="POST" action="?page=parametres_generaux&action=fonctions" id="formListeFonctions">
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
                                                Libellé de la fonction
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $listeFonctions = $GLOBALS['listeFonctions'] ?? []; ?>
                                    <?php if (!empty($listeFonctions)) : ?>
                                        <?php foreach ($listeFonctions as $fonction) : ?>
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-4 py-3 whitespace-nowrap text-center">
                                                    <input type="checkbox" name="selected_ids[]" value="<?= htmlspecialchars($fonction->id_fonction) ?>"
                                                           class="row-checkbox form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    <?= htmlspecialchars($fonction->id_fonction) ?>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                                    <?= htmlspecialchars($fonction->lib_fonction) ?>
                                                </td>
                                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-center">
                                                    <a href="?page=parametres_generaux&action=fonctions&id_fonction=<?= $fonction->id_fonction ?>"
                                                       class="text-center text-orange-500 hover:underline"><i
                                                                class="fas fa-pen"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-sm text-gray-500 py-4">
                                                Aucune fonction enregistrée.
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