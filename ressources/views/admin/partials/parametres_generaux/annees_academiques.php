<?php
$annee_a_modifier = $GLOBALS['annee_a_modifier'] ?? null;
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

        <!-- Formulaire d'Ajout ou de Modification -->
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b pb-3">
                Ajouter une nouvelle année académique
            </h3>
            <form method="POST" action="?page=parametres_generaux&action=annees_academiques">
                <?php if ($annee_a_modifier): ?>
                    <input type="hidden" name="id_annee_acad" value="<?= htmlspecialchars($annee_a_modifier->id_annee_acad) ?>">
                <?php endif; ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Date de début</label>
                        <input type="date" id="date_debut" name="date_debut" required
                               value="<?= $annee_a_modifier ? date('Y-m-d', strtotime($annee_a_modifier->date_deb)) : '' ?>"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                    </div>
                    <div>
                        <label for="" class="block text-sm font-medium text-gray-600 mb-1">Date de fin</label>
                        <input type="date" id="date_fin" name="date_fin" required
                               value="<?= $annee_a_modifier ? date('Y-m-d', strtotime($annee_a_modifier->date_fin)) : '' ?>"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                    </div>
                </div>
                <div class="flex justify-start space-x-3">
                    <button type="submit" name="btn_add_annees_academiques"
                            class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white <?= $annee_a_modifier ? 'bg-blue-500 hover:bg-blue-600 focus:ring-blue-500' : 'bg-green-500 hover:bg-green-600 focus:ring-green-500' ?> focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                        <i class="fas mr-2"></i>
                        <?php if(isset($_GET['id_annee_acad'])): ?>
                            <i class="fas fa-save mr-2"></i>
                            Modifier
                        <?php else: ?>
                            <i class="fa-plus fas mr-2"></i>
                            Ajouter l'année académique
                        <?php endif;?>
                    </button>

                </div>
            </form>
        </div>

        <!-- Section Tableau et Actions (si on n'est pas en mode édition) -->

        <div class="mt-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Liste des années académiques</h3>
            <form method="POST" action="?page=parametres_generaux&action=annees_academiques" id="formListeAnnees">
                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Table avec largeur fixe -->
                    <div style="width: 80%;"
                         class="border border-collapse bg-white rounded-xl shadow-lg overflow-hidden mb-6 lg:mb-0">
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
                                        Année académique
                                    </th>
                                    <th scope="col"
                                        class="w-[30%] px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date de début
                                    </th>
                                    <th scope="col"
                                        class="w-[30%] px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date de fin
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <?php $listeAnnees = $GLOBALS['listeAnnees'] ?? []; ?>
                                <?php if (!empty($listeAnnees)) : ?>
                                    <?php foreach ($listeAnnees as $annee) : ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 whitespace-nowrap text-center">
                                                <input type="checkbox" name="selected_ids[]" value="<?= htmlspecialchars($annee->id_annee_acad) ?>"
                                                       class="row-checkbox form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <?= htmlspecialchars($annee->id_annee_acad) ?>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                                <?= date('Y', strtotime($annee->date_deb)) . '-' . date('Y', strtotime($annee->date_fin)) ?>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                <?= date('d/m/Y', strtotime($annee->date_deb)) ?>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                <?= date('d/m/Y', strtotime($annee->date_fin)) ?>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                                <a href="?page=parametres_generaux&action=annees_academiques&id_annee_acad=<?= $annee->id_annee_acad ?>"
                                                   class="text-blue-500 hover:underline"><i class="fas fa-pen"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-sm text-gray-500 py-4">
                                            Aucune année académique enregistrée.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Boutons avec largeur fixe -->
                    <div style="width: 10%;" class="flex flex-col gap-4">
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

</body>

</html>