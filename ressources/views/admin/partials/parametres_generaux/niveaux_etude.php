<?php
$niveau_a_modifier = $GLOBALS['niveau_a_modifier'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion des niveaux d'études</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
<div class="min-h-screen flex flex-col">
    <main class="flex-grow container mx-auto px-4 py-5">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-700">Gestion des niveaux d'études</h2>
        </div>

        <!-- Formulaire d'ajout/modification -->
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b pb-3">
                <?= isset($_GET['id_niveau_etude']) ? "Modifier le niveau d'étude" : "Ajouter un nouveau niveau d'étude" ?>
            </h3>
            <form method="POST" action="?page=parametres_generaux&action=niveaux_etude">
                <?php if ($niveau_a_modifier): ?>
                    <input type="hidden" name="id_niveau_etude" value="<?= htmlspecialchars($niveau_a_modifier->id_niv_etude) ?>">
                <?php endif; ?>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Libellé du niveau d'étude</label>
                    <input type="text" name="niveau_etude" required
                           value="<?= $niveau_a_modifier ? htmlspecialchars($niveau_a_modifier->lib_niv_etude) : '' ?>"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:outline-none">
                </div>
                <div class="flex space-x-3">
                    <button type="submit" name="btn_add_niveau_etude"
                            class="inline-flex items-center px-6 py-2.5 text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600">
                        <i class="fas fa-<?= $niveau_a_modifier ? 'save' : 'plus' ?> mr-2"></i>
                        <?= $niveau_a_modifier ? 'Modifier' : 'Ajouter' ?>
                    </button>
                    <?php if ($niveau_a_modifier): ?>
                        <a href="?page=parametres_generaux&action=niveaux_etude"
                           class="inline-flex items-center px-6 py-2.5 text-sm font-medium rounded-lg shadow-sm text-white bg-orange-500 hover:bg-orange-600">
                            <i class="fas fa-times mr-2"></i> Annuler
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Tableau de données -->
        <div class="mt-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Liste des niveaux d'études</h3>
            <form method="POST" action="?page=parametres_generaux&action=niveaux_etude" id="formListeNiveaux">
                <div class="flex flex-col lg:flex-row gap-6">
                    <div style="width: 80%;" class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="overflow-x-auto w-full">
                            <table class="w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-center">
                                        <input type="checkbox" id="selectAllCheckbox"
                                               class="form-checkbox text-green-600 border-gray-300 rounded focus:ring-green-500">
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Libellé</th>
                                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <?php $listeNiveaux = $GLOBALS['listeNiveaux'] ?? []; ?>
                                <?php if (!empty($listeNiveaux)): ?>
                                    <?php foreach ($listeNiveaux as $niveau): ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 text-center">
                                                <input type="checkbox" name="selected_ids[]" value="<?= htmlspecialchars($niveau->id_niv_etude) ?>"
                                                       class="form-checkbox text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                <?= htmlspecialchars($niveau->lib_niv_etude) ?>
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <a href="?page=parametres_generaux&action=niveaux_etude&id_niveau_etude=<?= $niveau->id_niv_etude ?>"
                                                   class="text-orange-500 hover:underline">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-sm text-gray-500 py-4">
                                            Aucun niveau enregistré.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Bouton suppression -->
                    <div style="width: 10%;" class="flex flex-col gap-4 justify-center">
                        <button type="submit" name="submit_delete_multiple"
                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600">
                            <i class="fas fa-trash-alt mr-2"></i> Supprimer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>
