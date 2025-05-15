<?php
    $ue_a_modifier = $GLOBALS['ue_a_modifier'] ?? null;;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Unités d'Enseignement (UE)</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Le CSS Tailwind est supposé être chargé par le layout principal -->
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow container mx-auto px-4 py-5">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-700">Gestion des Unités d'Enseignement (UE)</h2>
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
                    <?= isset($_GET['id_ue']) ? "Modifier l'Unité d'Enseignement (UE)" : "Ajouter une nouvelle Unité d'Enseignement (UE)" ?>
                </h3>

                <form method="POST" action="?page=parametres_generaux&action=ue">
                    <?php if($ue_a_modifier): ?>
                    <input type="hidden" name="id_ue" value="<?= htmlspecialchars($ue_a_modifier->id_ue) ?>">
                    <?php endif ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Année académique -->
                        <div>
                            <label for="annee_academique" class="block text-sm font-medium text-gray-600 mb-1">
                                Année académique
                            </label>
                            <select id="annee_academique" name="annee_academiques" required
                                class=" focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 focus:border-0 transition-colors">
                                <option value="">Sélectionnez une année academique</option>
                                <?php foreach ($GLOBALS['listeAnnees'] as $annee): ?>
                                <option value="<?= $annee->id_annee_acad ?>"
                                    <?= $ue_a_modifier && $ue_a_modifier->id_annee_academique == $annee->id_annee_acad ? 'selected' : '' ?>>
                                    <?= date('Y', strtotime($annee->date_deb)) . ' - ' . date('Y', strtotime($annee->date_fin)) ?>
                                </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <!-- Libellé UE -->
                        <div>
                            <label for="lib_ue" class="block text-sm font-medium text-gray-600 mb-1">
                                Libellé de l'UE
                            </label>
                            <input type="text" id="lib_ue" name="lib_ue" required
                                value="<?= $ue_a_modifier ? htmlspecialchars($ue_a_modifier->lib_ue) : '' ?>"
                                placeholder="Ex: Mathématiques fondamentales"
                                class=" focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 focus:border-0 transition-colors">
                        </div>

                        <!-- Crédits -->
                        <div>
                            <label for="credits" class="block text-sm font-medium text-gray-600 mb-1">
                                Nombre de crédits
                            </label>
                            <input type="number" id="credits" name="credits"
                                value="<?= $ue_a_modifier ? htmlspecialchars($ue_a_modifier->credit) : '' ?>" required
                                min="1" max="9" placeholder="Ex: 6"
                                class=" focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 focus:border-0 transition-colors">
                        </div>

                        <!-- Semestre -->
                        <div>
                            <label for="semestre" class="block text-sm font-medium text-gray-600 mb-1">
                                Semestre
                            </label>
                            <select id="semestre" name="semestre" required
                                class=" focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 focus:border-0 transition-colors">
                                <option value="">Sélectionnez un semestre</option>
                                <?php foreach ($GLOBALS['listeSemestres'] as $sem): ?>
                                <option value="<?= $sem->id_semestre ?>"
                                    <?= $ue_a_modifier && $ue_a_modifier->id_semestre == $sem->id_semestre ? 'selected' : '' ?>>
                                    <?= $sem->lib_semestre ?>
                                </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <!-- Niveau d'étude -->
                        <div>
                            <label for="niveau" class="block text-sm font-medium text-gray-600 mb-1">
                                Niveau d'étude
                            </label>
                            <select id="niveau" name="niveau" required
                                class=" focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 focus:border-0 transition-colors">
                                <option value="">Sélectionnez un niveau</option>
                                <?php foreach ($GLOBALS['listeNiveauxEtude'] as $niv): ?>
                                <option value="<?= $niv->id_niv_etude ?>"
                                    <?= $ue_a_modifier && $ue_a_modifier->id_niveau_etude == $niv->id_niv_etude ? 'selected' : '' ?>>
                                    <?= $niv->lib_niv_etude ?>
                                </option>
                                <?php endforeach; ?>

                            </select>
                        </div>


                    </div>


                    <div class="flex justify-start space-x-3">
                        <?php if (isset($_GET['id_ue'])): ?>
                        <button type="submit" name="submit_add_ue"
                            class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-500 focus:ring-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Modifier l'UE
                        </button>
                        <button type="submit" name="btn_annuler"
                            class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white   bg-orange-500 hover:bg-orange-600 focus:ring-orange-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-remove mr-2"></i>
                            Annuler
                        </button>
                        <?php else: ?>
                        <button type="submit" name="submit_add_ue"
                            class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600 focus:ring-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                            <i class="fa-plus fas mr-2"></i>
                            Ajouter l'UE
                        </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Section Tableau et Actions (si on n'est pas en mode édition) -->

            <div class="mt-8">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Liste des Unités d'Enseignement </h3>
                <form method="POST" action="?page=parametres_generaux&action=ue" id="formListeUE">
                    <div class="flex flex-col lg:flex-row gap-6">
                        <!-- Table avec largeur fixe -->
                        <div style="width: 80%;"
                            class="border border-collapse border-gray-200 bg-white rounded-xl shadow-lg overflow-hidden mb-6 lg:mb-0">
                            <div class="overflow-x-auto w-full">
                                <table class="w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="w-[5%] px-4 py-3 text-center">
                                                <input type="checkbox" id="selectAllCheckbox"
                                                    class="form-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            </th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                ID</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Libellé UE</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Crédits</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Année académique</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Semestre</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Niveau d'étude</th>
                                            <th
                                                class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">
                                                Action</th>
                                        </tr>
                                    </thead>

                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php $listeUes = $GLOBALS['listeUes'] ?? []; ?>
                                        <?php if (!empty($listeUes)) : ?>
                                        <?php foreach ($listeUes as $ue) : ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 text-center">
                                                <input type="checkbox" name="selected_ids[]"
                                                    value="<?= htmlspecialchars($ue->id_ue) ?>"
                                                    class="row-checkbox form-checkbox text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            </td>
                                            <td class="px-4 py-3 text-sm text-gray-900 font-medium">
                                                <?= htmlspecialchars($ue->id_ue) ?></td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                <?= htmlspecialchars($ue->lib_ue) ?></td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                <?= htmlspecialchars($ue->credit) ?></td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                <?= htmlspecialchars($ue->id_annee_academique) ?></td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                <?= htmlspecialchars($ue->lib_semestre) ?></td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                <?= htmlspecialchars($ue->lib_niv_etude) ?></td>
                                            <td class="px-4 py-3 text-center">
                                                <a href="?page=parametres_generaux&action=ue&id_ue=<?= $ue->id_ue ?>"
                                                    class="text-orange-500 hover:underline"><i
                                                        class="fas fa-pen"></i></a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else : ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-sm text-gray-500 py-4">
                                                Aucune Unité d’Enseignement enregistrée.
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
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <i class="fas fa-print mr-2"></i>Imprimer
                            </button>

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