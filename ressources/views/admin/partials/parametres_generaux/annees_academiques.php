<?php


// Assurez-vous que ces variables sont initialisées
$annees ??= [];
$message ??= '';
$error ??= '';
$annee_a_modifier = $annee_a_modifier ?? null;
if (!function_exists('format_annee_academique')) {
    function format_annee_academique($date_deb, $date_fin)
    {
        if (empty($date_deb) || empty($date_fin)) return '';
        $annee_debut = date('Y', strtotime($date_deb));
        $annee_fin = date('Y', strtotime($date_fin));
        if ($annee_debut == $annee_fin) {
            return $annee_debut;
        }
        return $annee_debut . ' - ' . $annee_fin;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Années Académiques</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Le CSS Tailwind est supposé être chargé par le layout principal -->
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow container mx-auto px-4 py-5">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-700">Gestion des Années Académiques</h2>
            </div>

            <?php if (!empty($message)): ?>
                <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-md shadow-sm mb-6"
                    role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 mr-4"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path
                                    d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                            </svg></div>
                        <div>
                            <p class="font-bold">Succès</p>
                            <p class="text-sm"><?= htmlspecialchars($message) ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-md shadow-sm mb-6" role="alert">
                    <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-red-500 mr-4"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path
                                    d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                            </svg></div>
                        <div>
                            <p class="font-bold">Erreur</p>
                            <p class="text-sm"><?= htmlspecialchars($error) ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Formulaire d'Ajout ou de Modification -->
            <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8">
                <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b pb-3">
                    <?= $annee_a_modifier ? 'Modifier l\'année académique' : 'Ajouter une nouvelle année académique' ?>
                </h3>
                <form method="POST" action="?page=parametres_generaux&action=annees_academiques">
                    <?php if ($annee_a_modifier): ?>
                        <input type="hidden" name="id_annee_acad_edit"
                            value="<?= htmlspecialchars($annee_a_modifier->id_annee_acad) ?>">
                    <?php endif; ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="<?= $annee_a_modifier ? 'date_deb_edit' : 'date_deb' ?>"
                                class="block text-sm font-medium text-gray-600 mb-1">Date de début</label>
                            <input type="date" id="<?= $annee_a_modifier ? 'date_deb_edit' : 'date_deb' ?>"
                                name="<?= $annee_a_modifier ? 'date_deb_edit' : 'date_deb' ?>" required
                                value="<?= htmlspecialchars($annee_a_modifier->date_deb ?? '') ?>"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                        </div>
                        <div>
                            <label for="<?= $annee_a_modifier ? 'date_fin_edit' : 'date_fin' ?>"
                                class="block text-sm font-medium text-gray-600 mb-1">Date de fin</label>
                            <input type="date" id="<?= $annee_a_modifier ? 'date_fin_edit' : 'date_fin' ?>"
                                name="<?= $annee_a_modifier ? 'date_fin_edit' : 'date_fin' ?>" required
                                value="<?= htmlspecialchars($annee_a_modifier->date_fin ?? '') ?>"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                        </div>
                    </div>
                    <div class="flex justify-start space-x-3">
                        <button type="submit" name="<?= $annee_a_modifier ? 'submit_edit_annee' : 'submit_add_annee' ?>"
                            class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white <?= $annee_a_modifier ? 'bg-blue-500 hover:bg-blue-600 focus:ring-blue-500' : 'bg-green-500 hover:bg-green-600 focus:ring-green-500' ?> focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                            <i class="fas <?= $annee_a_modifier ? 'fa-save' : 'fa-plus' ?> mr-2"></i>
                            <?= $annee_a_modifier ? 'Enregistrer les modifications' : 'Ajouter l\'année' ?>
                        </button>
                        <?php if ($annee_a_modifier): ?>
                            <a href="?page=parametres_generaux&action=annees_academiques"
                                class="inline-flex items-center px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                                Annuler
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Section Tableau et Actions (si on n'est pas en mode édition) -->
            <?php if (!$annee_a_modifier): ?>
                <div class="mt-8">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">Liste des années académiques</h3>
                    <!-- Formulaire englobant la table et les boutons d'action groupée -->
                    <form method="POST" action="?page=parametres_generaux&action=annees_academiques" id="formListeAnnees">
                        <div class="flex flex-col lg:flex-row lg:gap-6 w-full">
                            <div class="lg:w-[70%] xl:w-[75%] bg-white rounded-xl shadow-lg overflow-hidden mb-6 lg:mb-0">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-4 py-3 text-center w-10 sm:w-12">
                                                    <input type="checkbox" id="selectAllCheckbox"
                                                        class="form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                                </th>
                                                <th scope="col"
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    ID</th>
                                                <th scope="col"
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Année académique</th>
                                                <th scope="col"
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Date de début</th>
                                                <th scope="col"
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Date de fin</th>
                                                <th scope="col"
                                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <?php if (empty($annees)): ?>
                                                <tr>
                                                    <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">Aucune
                                                        année académique trouvée.</td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($annees as $annee): ?>
                                                    <tr class="hover:bg-gray-50 transition-colors">
                                                        <td class="px-4 py-3 whitespace-nowrap text-center">
                                                            <!-- Le name est important pour que PHP reçoive les IDs cochés -->
                                                            <input type="checkbox" name="selected_ids[]"
                                                                value="<?= htmlspecialchars($annee->id_annee_acad ?? '') ?>"
                                                                class="row-checkbox form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                                        </td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                            <?= htmlspecialchars($annee->id_annee_acad ?? '') ?>
                                                        </td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                                            <?= htmlspecialchars(format_annee_academique($annee->date_deb ?? '', $annee->date_fin ?? '')) ?>
                                                        </td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                            <?= htmlspecialchars(date('d/m/Y', strtotime($annee->date_deb ?? ''))) ?>
                                                        </td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                            <?= htmlspecialchars(date('d/m/Y', strtotime($annee->date_fin ?? ''))) ?>
                                                        </td>
                                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                                            <a href="?page=parametres_generaux&action=annees_academiques&sub_action=edit&id_annee_acad=<?= htmlspecialchars($annee->id_annee_acad ?? '') ?>"
                                                                class="text-blue-600 hover:text-blue-900"
                                                                title="Modifier cette ligne">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php if (!empty($annees)): ?>
                                    <div class="px-6 py-3 border-t border-gray-200">
                                        <p class="text-sm text-gray-500">
                                            Affichage de <span class="font-medium"><?= count($annees) ?></span> années
                                            académiques.
                                        </p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Colonne des Actions (toujours visible, largeur fixe ou minimale) -->
                            <div class="lg:flex-grow lg:w-1/3">
                                <div class="bg-white rounded-xl shadow-lg p-4 space-y-3 sticky top-4">
                                    <h4 class="text-md font-semibold text-gray-600 border-b pb-2 mb-3">Actions Groupées</h4>
                                    <p class="text-xs text-gray-500 mb-3">
                                        Cochez des lignes dans le tableau puis choisissez une action.
                                    </p>
                                    <!-- Les boutons sont maintenant de type "submit" et ont des "name" distincts -->
                                    <button type="submit" name="submit_edit_selected" id="editSelectedBtnPHP"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                        <i class="fas fa-edit mr-2"></i>Modifier Sélection
                                    </button>
                                    <button type="submit" name="submit_delete_multiple" id="deleteSelectedBtnPHP"
                                        class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                        <i class="fas fa-trash-alt mr-2"></i>Supprimer Sélection
                                    </button>
                                    <p class="text-xs text-gray-500 mt-2 text-center" id="selectionInfoPHP">
                                        (L'action "Modifier" ne s'appliquera qu'à la première ligne cochée si plusieurs sont
                                        sélectionnées)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form> <!-- Fin du formulaire englobant -->
                </div>
            <?php endif; ?>
            <!-- Fin de if (!$annee_a_modifier) -->
        </main>
    </div>

    <script>
        // JavaScript minimal pour la fonctionnalité "Tout sélectionner"
        // et pour désactiver les boutons si la sélection est inappropriée (optionnel mais recommandé)
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const rowCheckboxes = document.querySelectorAll('.row-checkbox');
            const editSelectedBtnPHP = document.getElementById('editSelectedBtnPHP');
            const deleteSelectedBtnPHP = document.getElementById('deleteSelectedBtnPHP');
            const selectionInfoPHP = document.getElementById('selectionInfoPHP');

            function updateButtonStatesPHP() {
                const selectedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
                const count = selectedCheckboxes.length;

                if (editSelectedBtnPHP) {
                    editSelectedBtnPHP.disabled = count !== 1; // Actif seulement si 1 sélectionné
                }
                if (deleteSelectedBtnPHP) {
                    deleteSelectedBtnPHP.disabled = count === 0; // Actif si au moins 1 sélectionné
                }

                if (selectionInfoPHP) {
                    if (count === 0) {
                        selectionInfoPHP.textContent =
                            "(L'action \"Modifier\" ne s'appliquera qu'à la première ligne cochée si plusieurs sont sélectionnées)";
                    } else if (count === 1) {
                        selectionInfoPHP.textContent = "1 élément sélectionné.";
                    } else {
                        selectionInfoPHP.textContent = count + " éléments sélectionnés.";
                    }
                }
            }

            if (selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    rowCheckboxes.forEach(checkbox => {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                    updateButtonStatesPHP();
                });
            }

            rowCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (!checkbox.checked) {
                        if (selectAllCheckbox) selectAllCheckbox.checked = false;
                    } else {
                        let allChecked = true;
                        rowCheckboxes.forEach(cb => {
                            if (!cb.checked) allChecked = false;
                        });
                        if (selectAllCheckbox) selectAllCheckbox.checked = allChecked;
                    }
                    updateButtonStatesPHP();
                });
            });

            // Appel initial pour définir l'état des boutons
            updateButtonStatesPHP();
        });
    </script>
</body>

</html>