<?php
// Assurez-vous que ces variables sont initialisées
$annees = $annees ?? [];
$message = $message ?? '';
$error = $error ?? '';

if (!function_exists('format_annee_academique')) {
    function format_annee_academique($date_deb, $date_fin) {
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

            <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8">
                <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b pb-3">Ajouter une nouvelle année académique
                </h3>
                <form method="POST" action="?page=parametres_generaux&action=annees_academiques">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="date_deb" class="block text-sm font-medium text-gray-600 mb-1">Date de
                                début</label>
                            <input type="date" id="date_deb" name="date_deb" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                        </div>
                        <div>
                            <label for="date_fin" class="block text-sm font-medium text-gray-600 mb-1">Date de
                                fin</label>
                            <input type="date" id="date_fin" name="date_fin" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                        </div>
                    </div>
                    <div class="flex justify-start">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter l'année
                        </button>
                    </div>
                </form>
            </div>

            <div class="mt-8">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Liste des années académiques</h3>
                <div class="flex flex-col lg:flex-row gap-6 ">
                    <div class="lg:flex-grow bg-white rounded-xl shadow-lg overflow-hidden">
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
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php if (empty($annees)): ?>
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                                            Aucune année académique trouvée.
                                        </td>
                                    </tr>
                                    <?php else: ?>
                                    <?php foreach ($annees as $annee): ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap text-center">
                                            <input type="checkbox" name="selected_ids[]"
                                                value="<?= htmlspecialchars($annee['id_annee_acad'] ?? ($annee->id_annee_acad ?? '')) ?>"
                                                class="row-checkbox form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <?= htmlspecialchars($annee['id_annee_acad'] ?? ($annee->id_annee_acad ?? '')) ?>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">
                                            <?= htmlspecialchars(format_annee_academique($annee['date_deb'] ?? ($annee->date_deb ?? ''), $annee['date_fin'] ?? ($annee->date_fin ?? ''))) ?>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                            <?= htmlspecialchars(date('d/m/Y', strtotime($annee['date_deb'] ?? ($annee->date_deb ?? '')))) ?>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                            <?= htmlspecialchars(date('d/m/Y', strtotime($annee['date_fin'] ?? ($annee->date_fin ?? '')))) ?>
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
                                Affichage de <span class="font-medium"><?= count($annees) ?></span> années académiques.
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div>
                        <button id="editSelectedBt"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                            <i class="fas fa-edit mr-2"></i>
                            Modifier
                        </button>
                        <button id="deleteSelectedBtn"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Supprimer

                    </div>


                </div>
            </div>
        </main>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAllCheckbox = document.getElementById('selectAllCheckbox');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        const editSelectedBtn = document.getElementById('editSelectedBtn');
        const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
        const selectionInfo = document.getElementById('selectionInfo'); // Le paragraphe d'info

        function updateButtonStates() {
            const selectedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
            const count = selectedCheckboxes.length;

            if (editSelectedBtn) {
                editSelectedBtn.disabled = count !== 1;
            }
            if (deleteSelectedBtn) {
                deleteSelectedBtn.disabled = count === 0;
            }

            if (selectionInfo) {
                if (count === 0) {
                    selectionInfo.textContent = "Sélectionnez des lignes pour agir.";
                } else if (count === 1) {
                    selectionInfo.textContent = "1 élément sélectionné.";
                } else {
                    selectionInfo.textContent = count + " éléments sélectionnés.";
                }
            }
        }

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                rowCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateButtonStates();
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
                updateButtonStates();
            });
        });

        if (editSelectedBtn) {
            editSelectedBtn.addEventListener('click', function() {
                if (this.disabled) return;
                const selectedCheckbox = document.querySelector('.row-checkbox:checked');
                if (selectedCheckbox) {
                    const id = selectedCheckbox.value;
                    console.log('Modifier ID:', id);
                    // Redirigez vers votre page/route d'édition
                    window.location.href =
                        `?page=parametres_generaux&action=annees_academiques_edit&id_annee_acad=${id}`;
                }
            });
        }

        if (deleteSelectedBtn) {
            deleteSelectedBtn.addEventListener('click', function() {
                if (this.disabled) return;
                const selectedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
                const idsToDelete = Array.from(selectedCheckboxes).map(cb => cb.value);
                if (idsToDelete.length > 0) {
                    if (confirm('Êtes-vous sûr de vouloir supprimer les ' + idsToDelete.length +
                            ' éléments sélectionnés ?')) {
                        console.log('Supprimer IDs:', idsToDelete);

                        // Création d'un formulaire pour envoyer les IDs via POST
                        const form = document.createElement('form');
                        form.method = 'POST';
                        // Adaptez cette URL à votre route de suppression multiple côté serveur
                        form.action =
                            '?page=parametres_generaux&action=annees_academiques_delete_multiple';

                        idsToDelete.forEach(id => {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name =
                                'selected_ids[]'; // Le serveur s'attendra à un tableau 'selected_ids'
                            input.value = id;
                            form.appendChild(input);
                        });
                        // Ajouter un champ pour identifier l'action de suppression si nécessaire côté serveur
                        const actionInput = document.createElement('input');
                        actionInput.type = 'hidden';
                        actionInput.name =
                            'submit_delete_multiple'; // Nom spécifique pour le traitement
                        actionInput.value = '1';
                        form.appendChild(actionInput);

                        document.body.appendChild(form);
                        form.submit();
                    }
                }
            });
        }
        // Appel initial pour définir l'état des boutons au chargement de la page
        updateButtonStates();
    });
    </script>
</body>

</html>