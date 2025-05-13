<?php
$annee_a_modifier = $GLOBALS['annee_a_modifier'] ?? null;
$listeAnnees = $GLOBALS['listeAnnees'] ?? [];
$itemsPerPage = 10; // Nombre d'éléments par page
$currentPage = isset($_GET['page_num']) ? max(1, intval($_GET['page_num'])) : 1;
$totalItems = count($listeAnnees);
$totalPages = ceil($totalItems / $itemsPerPage);
$paginatedItems = array_slice($listeAnnees, ($currentPage - 1) * $itemsPerPage, $itemsPerPage);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Années Académiques</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <main class="flex-grow container mx-auto px-4 py-5">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-700">Gestion des Années Académiques</h2>
            </div>

            <!-- Messages d'alerte -->
            <?php if (!empty($GLOBALS['messageErreur'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 alert-message"
                role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($GLOBALS['messageErreur']); ?></span>
            </div>
            <?php endif; ?>
            <?php if (!empty($GLOBALS['messageSucces'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 alert-message"
                role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($GLOBALS['messageSucces']); ?></span>
            </div>
            <?php endif; ?>

            <!-- Formulaire d'Ajout/Modification -->
            <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8">
                <!-- ... (contenu existant du formulaire) ... -->
            </div>

            <!-- Section Tableau et Actions -->
            <div class="mt-8">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Liste des années académiques</h3>

                <!-- Barre d'outils (Recherche, Export, Impression) -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-4">
                    <!-- Barre de recherche -->
                    <div class="w-full md:w-1/3">
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Rechercher..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'export et impression -->
                    <div class="flex flex-wrap gap-2 w-full md:w-auto">
                        <button id="exportCsvBtn"
                            class="flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                            <i class="fas fa-file-csv mr-2"></i> Exporter CSV
                        </button>
                        <button id="printBtn"
                            class="flex items-center px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-colors">
                            <i class="fas fa-print mr-2"></i> Imprimer
                        </button>
                    </div>
                </div>

                <!-- Tableau -->
                <form method="POST" action="?page=parametres_generaux&action=annees_academiques" id="formListeAnnees">
                    <div
                        class="border border-collapse border-gray-200 bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                        <div class="overflow-x-auto w-full">
                            <table id="anneesTable" class="w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="w-[5%] px-4 py-3 text-center">
                                            <input type="checkbox" id="selectAllCheckbox"
                                                class="form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                        </th>
                                        <th scope="col"
                                            class="w-[10%] px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID
                                        </th>
                                        <th scope="col"
                                            class="w-[25%] px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Année académique
                                        </th>
                                        <th scope="col"
                                            class="w-[20%] px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date de début
                                        </th>
                                        <th scope="col"
                                            class="w-[20%] px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date de fin
                                        </th>
                                        <th scope="col"
                                            class="w-[20%] px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php if (!empty($paginatedItems)) : ?>
                                    <?php foreach ($paginatedItems as $annee) : ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap text-center">
                                            <input type="checkbox" name="selected_ids[]"
                                                value="<?= htmlspecialchars($annee->id_annee_acad) ?>"
                                                class="row-checkbox form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                        </td>
                                        <td
                                            class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center">
                                            <?= htmlspecialchars($annee->id_annee_acad) ?>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 text-center">
                                            <?= date('Y', strtotime($annee->date_deb)) . '-' . date('Y', strtotime($annee->date_fin)) ?>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-center">
                                            <?= date('d/m/Y', strtotime($annee->date_deb)) ?>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-center">
                                            <?= date('d/m/Y', strtotime($annee->date_fin)) ?>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-center">
                                            <a href="?page=parametres_generaux&action=annees_academiques&id_annee_acad=<?= $annee->id_annee_acad ?>"
                                                class="hover:underline text-orange-400"><i
                                                    class="fas fa-pen text-orange-500"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-sm text-gray-500 py-4">
                                            Aucune année académique enregistrée.
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="flex flex-col md:flex-row justify-between items-center mt-4">
                        <div class="mb-4 md:mb-0">
                            <span class="text-sm text-gray-700">
                                Affichage de <span
                                    class="font-medium"><?= (($currentPage - 1) * $itemsPerPage) + 1 ?></span>
                                à <span class="font-medium"><?= min($currentPage * $itemsPerPage, $totalItems) ?></span>
                                sur <span class="font-medium"><?= $totalItems ?></span> résultats
                            </span>
                        </div>

                        <div class="flex gap-1">
                            <!-- Bouton Précédent -->
                            <a href="?page=parametres_generaux&action=annees_academiques&page_num=<?= max(1, $currentPage - 1) ?>"
                                class="px-3 py-1 border rounded <?= $currentPage == 1 ? 'bg-gray-100 cursor-not-allowed' : 'bg-white hover:bg-gray-50' ?>">
                                <i class="fas fa-chevron-left"></i>
                            </a>

                            <!-- Numéros de page -->
                            <?php 
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($totalPages, $currentPage + 2);
                            
                            if ($startPage > 1) {
                                echo '<a href="?page=parametres_generaux&action=annees_academiques&page_num=1" class="px-3 py-1 border rounded bg-white hover:bg-gray-50">1</a>';
                                if ($startPage > 2) echo '<span class="px-3 py-1">...</span>';
                            }
                            
                            for ($i = $startPage; $i <= $endPage; $i++) {
                                $activeClass = $i == $currentPage ? 'bg-blue-500 text-white' : 'bg-white hover:bg-gray-50';
                                echo '<a href="?page=parametres_generaux&action=annees_academiques&page_num='.$i.'" class="px-3 py-1 border rounded '.$activeClass.'">'.$i.'</a>';
                            }
                            
                            if ($endPage < $totalPages) {
                                if ($endPage < $totalPages - 1) echo '<span class="px-3 py-1">...</span>';
                                echo '<a href="?page=parametres_generaux&action=annees_academiques&page_num='.$totalPages.'" class="px-3 py-1 border rounded bg-white hover:bg-gray-50">'.$totalPages.'</a>';
                            }
                            ?>

                            <!-- Bouton Suivant -->
                            <a href="?page=parametres_generaux&action=annees_academiques&page_num=<?= min($totalPages, $currentPage + 1) ?>"
                                class="px-3 py-1 border rounded <?= $currentPage == $totalPages ? 'bg-gray-100 cursor-not-allowed' : 'bg-white hover:bg-gray-50' ?>">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Bouton Supprimer -->
                    <div class="flex justify-end mt-4">
                        <button type="button" id="deleteSelectedBtn"
                            class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-trash-alt mr-2"></i>Supprimer
                        </button>
                        <input type="hidden" name="submit_delete_multiple" id="submitDeleteHidden" value="0">
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Modales (contenu existant) -->
    <!-- ... -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        // Initialisation de DataTables pour la recherche et le tri
        $('#anneesTable').DataTable({
            searching: false, // On utilise notre propre champ de recherche
            paging: false, // On utilise notre propre pagination
            info: false, // On utilise notre propre affichage d'information
            ordering: true, // Permettre le tri
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json'
            }
        });

        // Recherche personnalisée
        $('#searchInput').keyup(function() {
            $('#anneesTable').DataTable().search($(this).val()).draw();
        });

        // Export CSV
        $('#exportCsvBtn').click(function() {
            let csv = 'ID,Année académique,Date de début,Date de fin\n';

            <?php foreach ($listeAnnees as $annee): ?>
            csv += '<?= $annee->id_annee_acad ?>,';
            csv +=
                '"<?= date('Y', strtotime($annee->date_deb)) . '-' . date('Y', strtotime($annee->date_fin)) ?>",';
            csv += '"<?= date('d/m/Y', strtotime($annee->date_deb)) ?>",';
            csv += '"<?= date('d/m/Y', strtotime($annee->date_fin)) ?>"\n';
            <?php endforeach; ?>

            const blob = new Blob([csv], {
                type: 'text/csv;charset=utf-8;'
            });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.setAttribute('download', 'annees_academiques_<?= date('Y-m-d') ?>.csv');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });

        // Impression
        $('#printBtn').click(function() {
            const {
                jsPDF
            } = window.jspdf;
            const doc = new jsPDF();

            // Titre
            doc.setFontSize(18);
            doc.text('Liste des années académiques', 14, 15);

            // Date d'impression
            doc.setFontSize(10);
            doc.text('Imprimé le: <?= date("d/m/Y H:i") ?>', 14, 22);

            // Tableau
            doc.autoTable({
                head: [
                    ['ID', 'Année académique', 'Date début', 'Date fin']
                ],
                body: [
                    <?php foreach ($listeAnnees as $annee): ?>[
                        '<?= $annee->id_annee_acad ?>',
                        '<?= date('Y', strtotime($annee->date_deb)) . '-' . date('Y', strtotime($annee->date_fin)) ?>',
                        '<?= date('d/m/Y', strtotime($annee->date_deb)) ?>',
                        '<?= date('d/m/Y', strtotime($annee->date_fin)) ?>'
                    ],
                    <?php endforeach; ?>
                ],
                startY: 30,
                theme: 'grid',
                headStyles: {
                    fillColor: [41, 128, 185],
                    textColor: 255,
                    fontStyle: 'bold'
                },
                alternateRowStyles: {
                    fillColor: [245, 245, 245]
                }
            });

            doc.save('annees_academiques_<?= date("Y-m-d") ?>.pdf');
        });

        // ... (le reste de votre script existant)
    });
    </script>
</body>

</html>