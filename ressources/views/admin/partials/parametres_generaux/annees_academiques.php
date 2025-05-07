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

                    <input type="hidden" name="id_annee_acad_edit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Date de début</label>
                            <input type="date" id="" name="" required value=""
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                        </div>
                        <div>
                            <label for="" class="block text-sm font-medium text-gray-600 mb-1">Date de fin</label>
                            <input type="date" id="" name="" required value=""
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                        </div>
                    </div>
                    <div class="flex justify-start space-x-3">
                        <button type="submit" name=""
                            class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white <?= $annee_a_modifier ? 'bg-blue-500 hover:bg-blue-600 focus:ring-blue-500' : 'bg-green-500 hover:bg-green-600 focus:ring-green-500' ?> focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                            <i class="fas <?= $annee_a_modifier ? 'fa-save' : 'fa-plus' ?> mr-2"></i>
                            Ajouter l'année académique
                        </button>

                    </div>
                </form>
            </div>

            <!-- Section Tableau et Actions (si on n'est pas en mode édition) -->

            <div class="mt-8">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Liste des années académiques</h3>
                <!-- Formulaire englobant la table et les boutons d'action groupée -->
                <form method="POST" action="?page=parametres_generaux&action=annees_academiques" id="formListeAnnees">
                    <div class="flex flex-col lg:flex-row lg:gap-6 w-full">
                        <div class="lg:w-2/3 xl:w-[75%] bg-white rounded-xl shadow-lg overflow-hidden mb-6 lg:mb-0">
                            <div class="overflow-x-auto">
                                <table
                                    class="min-w-full w-full divide-y divide-gray-200 table-auto text-sm text-gray-500">
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
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-4 py-3 whitespace-nowrap text-center">
                                                <!-- Le name est important pour que PHP reçoive les IDs cochés -->
                                                <input type="checkbox" name="selected_ids[]" value=""
                                                    class="row-checkbox form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">

                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">

                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">

                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">

                                            </td>

                                        </tr>

                                    </tbody>
                                </table>
                            </div>


                        </div>

                        <!-- Colonne des Actions (toujours visible, largeur fixe ou minimale) -->
                        <div class="lg:flex-grow lg:w-1/3">
                            <!-- Les boutons sont maintenant de type "submit" et ont des "name" distincts -->
                            <button type="submit" name="submit_edit_selected" id="editSelectedBtnPHP"
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <i class="fas fa-edit mr-2"></i>Modifier
                            </button>
                            <button type="submit" name="submit_delete_multiple" id="deleteSelectedBtnPHP"
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                <i class="fas fa-trash-alt mr-2"></i>Supprimer
                            </button>
                        </div>
                    </div>
                </form> <!-- Fin du formulaire englobant -->
            </div>

        </main>
    </div>

</body>

</html>