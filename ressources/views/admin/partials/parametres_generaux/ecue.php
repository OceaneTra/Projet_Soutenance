<?php
    $ecue_a_modifier = $GLOBALS['ecue_a_modifier'] ?? null;
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Éléments constitutifs (ECUE)</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Le CSS Tailwind est supposé être chargé par le layout principal -->
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow container mx-auto px-4 py-5">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-700">Gestion des Éléments constitutifs (ECUE)</h2>
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
                    Ajouter un nouvel élément constitutif (ECUE)
                </h3>

                <form method="POST" action="?page=parametres_generaux&action=ecue">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Unités d'Enseignement(UE) -->
                        <div>
                            <label for="ue" class="block text-sm font-medium text-gray-600 mb-3 mt-2">
                                Unité d'Enseignement (UE)
                            </label>
                            <select id="ue" name="ue" required onchange="remplirInfosUE()"
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-colors">
                                <option value="">Sélectionnez une UE</option>
                                <?php foreach ($GLOBALS['listeUes'] as $ue): ?>
                                <option value="<?= $ue->id_ue ?>"
                                    data-semestre="<?= htmlspecialchars($ue->lib_semestre) ?>"
                                    data-niveau="<?= htmlspecialchars($ue->lib_niv_etude) ?>"
                                    data-annee="<?= htmlspecialchars($ue->id_annee_academique) ?>">
                                    <?= $ue->lib_ue ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Libellé ECUE -->
                        <div>
                            <label for="lib_ecue" class="block text-sm font-medium text-gray-600 mb-3 mt-2">
                                Libellé de l'ECUE
                            </label>
                            <input type="text" id="lib_ecue" name="lib_ecue" required
                                placeholder="Ex: Mathématiques fondamentales"
                                class=" focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 focus:border-0 transition-colors">
                        </div>

                        <!-- Crédits -->
                        <div>
                            <label for="credits" class="block text-sm font-medium text-gray-600 mb-3 mt-2">
                                Nombre de crédits
                            </label>
                            <input type="number" id="credits" name="credits" required min="1" max="9"
                                placeholder="Ex: 6"
                                class=" focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 focus:border-0 transition-colors">
                        </div>

                        <!-- Semestre -->
                        <div>
                            <label for="semestre" class="block text-sm font-medium text-gray-600 mb-3 mt-2">
                                Semestre
                            </label>
                            <!--c'est en sortie-->
                            <input type="text" id="semestre" name="semestre" readonly
                                class=" focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 focus:border-0 transition-colors">
                        </div>

                        <!-- Niveau d'étude -->
                        <div>
                            <label for="niveau_etude" class="block text-sm font-medium text-gray-600 mb-3 mt-2">
                                Niveau d'étude
                            </label>
                            <!--c'est en sortie-->
                            <input type="text" id="niveau_etude" name="niveau_etude" readonly
                                class=" focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 focus:border-0 transition-colors">
                        </div>

                        <!-- Annee academique -->
                        <div>
                            <label for="annee_academique_affiche"
                                class="block text-sm font-medium text-gray-600 mb-3 mt-2">
                                Annee Academique
                            </label>
                            <!--c'est en sortie-->
                            <input type="text" id="annee_academique_affiche" readonly
                                class=" focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 focus:border-0 transition-colors">
                        </div>



                    </div>


                    <div class="flex justify-start space-x-3">
                        <button type="submit" name="submit_add_ecue"
                            class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 focus:border-0 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter l'ECUE
                        </button>
                    </div>
                </form>
            </div>

            <!-- Section Tableau et Actions (si on n'est pas en mode édition) -->

            <div class="mt-8">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Liste des Éléments constitutifs</h3>
                <form method="POST" action="?page=parametres_generaux&action=ecue" id="formListeECUE">
                    <div class="flex flex-col lg:flex-row gap-6">
                        <!-- Table avec largeur fixe -->
                        <div style="width: 80%;"
                            class="border border-gray-200 border-collapse bg-white rounded-xl shadow-lg overflow-hidden mb-6 lg:mb-0">
                            <div class="overflow-x-auto w-full">
                                <table class="w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="w-[5%] px-4 py-3 text-center">
                                                <input type="checkbox" id="selectAllCheckbox"
                                                    class="form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            </th>

                                            <th scope="col"
                                                class="w-[25%] px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Libellé de l'UE
                                            </th>
                                            <th scope="col"
                                                class="w-[25%] px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Libellé de l'ECUE
                                            </th>
                                            <th scope="col"
                                                class="w-[25%] px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Crédits
                                            </th>
                                            <th scope="col"
                                                class="w-[25%] px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <?php $listeEcues = $GLOBALS['listeEcues'] ?? []; ?>
                                        <?php if (!empty($listeEcues)) : ?>
                                        <?php foreach ($listeEcues as $ecue) : ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 text-center">
                                                <input type="checkbox" name="selected_ids[]"
                                                    value="<?= htmlspecialchars($ecue->id_ecue) ?>"
                                                    class="form-checkbox text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            </td>
                                            <td class="px-4 py-3 text-sm font-medium text-gray-900">
                                                <?= htmlspecialchars($ecue->lib_ue) ?></td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                <?= htmlspecialchars($ecue->lib_ecue) ?></td>
                                            <td class="px-4 py-3 text-sm text-gray-700">
                                                <?= htmlspecialchars($ecue->credit) ?></td>
                                            <td class="px-4 py-3 text-center">
                                                <a href="?page=parametres_generaux&action=ecue&id_ecue=<?= $ecue->id_ecue ?>"
                                                    class="text-orange-500 hover:underline"><i
                                                        class="fas fa-pen"></i></a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else : ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-sm text-gray-500 py-4">
                                                Aucun élément constitutif enregistré.
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
    function remplirInfosUE() {
        const selectUE = document.getElementById("ue");
        const selectedOption = selectUE.options[selectUE.selectedIndex];

        const semestre = selectedOption.getAttribute("data-semestre");
        const niveau = selectedOption.getAttribute("data-niveau");
        const annee = selectedOption.getAttribute("data-annee");

        document.getElementById("semestre").value = semestre ?? '';
        document.getElementById("niveau_etude").value = niveau ?? '';
        document.getElementById("annee_academique_affiche").value = annee ?? '';
    }
    </script>

</body>

</html>