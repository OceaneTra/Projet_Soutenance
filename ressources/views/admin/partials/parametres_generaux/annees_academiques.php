<?php
$annee_a_modifier = $GLOBALS['annee_a_modifier'] ?? null;
$listeAnnees = $GLOBALS['listeAnnees'] ?? [];
$itemsPerPage = 10; // Nombre d'éléments par page
$currentPage = isset($_GET['page_num']) ? max(1, intval($_GET['page_num'])) : 1;
$totalItems = count($listeAnnees);
$totalPages = ceil($totalItems / $itemsPerPage);
$paginatedItems = array_slice($listeAnnees, ($currentPage - 1) * $itemsPerPage, $itemsPerPage)

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
            <!-- À placer avant ou au début de votre formulaire -->
            <?php if (!empty($GLOBALS['messageErreur'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 alert-message"
                role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($GLOBALS['messageErreur']); ?></span>
            </div>
            <?php endif; ?>

            <!-- À placer avant ou au début de votre formulaire -->
            <?php if (!empty($GLOBALS['messageSucces'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 alert-message"
                role="alert">
                <span class="block sm:inline"><?php echo htmlspecialchars($GLOBALS['messageSucces']); ?></span>
            </div>
            <?php endif; ?>

            <!-- Formulaire d'Ajout ou de Modification -->
            <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8">
                <h3 class="text-xl font-semibold text-gray-700 mb-6 border-b border-gray-200 pb-3">
                    <?php if(isset($_GET['id_annee_acad'])): ?>
                    Modifier l'année académique
                    <?php else: ?>
                    Ajouter l'année académique
                    <?php endif;?>
                </h3>
                <form method="POST" action="?page=parametres_generaux&action=annees_academiques" id="anneeForm">
                    <?php if ($annee_a_modifier): ?>
                    <input type="hidden" name="id_annee_acad"
                        value="<?= htmlspecialchars($annee_a_modifier->id_annee_acad) ?>">
                    <?php endif; ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-3">Date de début</label>
                            <input type="date" id="date_deb" name="date_deb" required
                                value="<?= $annee_a_modifier ? date('Y-m-d', strtotime($annee_a_modifier->date_deb)) : '' ?>"
                                class="focus:outline-none w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-colors focus:border-0">
                        </div>
                        <div>
                            <label for="" class="block text-sm font-medium text-gray-600 mb-3">Date de fin</label>
                            <input type="date" id="date_fin" name="date_fin" required
                                value="<?= $annee_a_modifier ? date('Y-m-d', strtotime($annee_a_modifier->date_fin)) : '' ?>"
                                class=" focus:border-0 focus:outline-none  w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-600 focus:outline-green-600 transition-colors">
                        </div>
                    </div>
                    <div class="flex justify-between space-x-3">
                        <?php if(!isset($_GET['id_annee_acad'])): ?>
                        <div></div>
                        <button type="submit" name="btn_add_annees_academiques"
                            class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600 focus:ring-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                            <i class="fa-plus fas mr-2"></i>
                            Ajouter l'année académique
                        </button>
                        <?php else: ?>
                        <button type="submit" name="btn_annuler"
                            class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-orange-500 hover:bg-orange-600 focus:ring-orange-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </button>
                        <button type="submit" id="editBtn" name="btn_add_annees_academiques"
                            class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-500 focus:ring-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Modifier l'année
                        </button>
                        <input type="hidden" name="submitModifierHidden" value="1">
                        <?php endif;?>
                    </div>
                </form>
            </div>

            <!-- Section Tableau et Actions (si on n'est pas en mode édition) -->
            <div class="mt-8">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Liste des années académiques</h3>
                <!-- Action Bar for Table -->
                <div
                    class="px-6 py-4 flex flex-col sm:flex-row justify-between items-center border-b border-gray-200 mb-3">
                    <div class="relative w-full sm:w-1/2 lg:w-1/3 mb-4 sm:mb-0">
                        <input type="text" id="searchInput" placeholder="Rechercher une année académique..."
                            class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-2 justify-center sm:justify-end">
                        <button id="printBtn"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg shadow transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            <i class="fas fa-print mr-2"></i>Imprimer
                        </button>
                        <button id="exportCsvBtn"
                            class="bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg shadow transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-opacity-50">
                            <i class="fas fa-file-export mr-2"></i>Exporter
                        </button>
                        <div>
                            <button type="button" id="deleteSelectedBtn"
                                class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-trash-alt mr-2"></i>Supprimer
                            </button>

                        </div>
                    </div>
                </div>
                <!-- Tableau -->
                <form method="POST" action="?page=parametres_generaux&action=annees_academiques" id="formListeAnnees"
                    class="border-0">
                    <input type="hidden" name="submit_delete_multiple" value="1">
                    <!-- Supprimer les classes border et border-collapse -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
                        <div class="overflow-x-auto w-full">
                            <!-- Ajouter border-0 pour s'assurer qu'aucune bordure ne s'applique -->
                            <table id="anneesTable" class="w-full divide-y divide-gray-200 border-0">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="w-[5%] px-4 py-3 text-center border-0">
                                            <input type="checkbox" id="selectAllCheckbox"
                                                class="form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                        </th>
                                        <th scope="col"
                                            class="w-[10%] px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-0">
                                            ID
                                        </th>
                                        <th scope="col"
                                            class="w-[25%] px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-0">
                                            Année académique
                                        </th>
                                        <th scope="col"
                                            class="w-[20%] px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-0">
                                            Date de début
                                        </th>
                                        <th scope="col"
                                            class="w-[20%] px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-0">
                                            Date de fin
                                        </th>
                                        <th scope="col"
                                            class="w-[20%] px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-0">
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($paginatedItems)) : ?>
                                    <?php foreach ($paginatedItems as $annee) : ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-4 py-3 whitespace-nowrap text-center border-0">
                                            <input type="checkbox" name="selected_ids[]"
                                                value="<?= htmlspecialchars($annee->id_annee_acad) ?>"
                                                class="row-checkbox form-checkbox h-4 w-4 sm:h-5 sm:w-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
                                        </td>
                                        <td
                                            class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 text-center border-0">
                                            <?= htmlspecialchars($annee->id_annee_acad) ?>
                                        </td>
                                        <td
                                            class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 text-center border-0">
                                            <?= date('Y', strtotime($annee->date_deb)) . '-' . date('Y', strtotime($annee->date_fin)) ?>
                                        </td>
                                        <td
                                            class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-center border-0">
                                            <?= date('d/m/Y', strtotime($annee->date_deb)) ?>
                                        </td>
                                        <td
                                            class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-center border-0">
                                            <?= date('d/m/Y', strtotime($annee->date_fin)) ?>
                                        </td>
                                        <td
                                            class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-center border-0">
                                            <a href="?page=parametres_generaux&action=annees_academiques&id_annee_acad=<?= $annee->id_annee_acad ?>"
                                                class="hover:underline text-orange-400"><i
                                                    class="fas fa-pen text-orange-500"></i></a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else : ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-sm text-gray-500 py-4 border-0">
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
                                class="px-3 py-1 border border-gray-200 rounded <?= $currentPage == 1 ? 'bg-gray-100 cursor-not-allowed' : 'bg-white hover:bg-gray-50' ?>">
                                <i class="fas fa-chevron-left rounded-sm text-green-500"></i>
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
                                $activeClass = $i == $currentPage ? 'bg-green-500 text-white' : 'bg-white hover:bg-green-600';
                                echo '<a href="?page=parametres_generaux&action=annees_academiques&page_num='.$i.'" class="px-3 py-1 border rounded '.$activeClass.'">'.$i.'</a>';
                            }
                            
                            if ($endPage < $totalPages) {
                                if ($endPage < $totalPages - 1) echo '<span class="px-3 py-1">...</span>';
                                echo '<a href="?page=parametres_generaux&action=annees_academiques&page_num='.$totalPages.'" class="px-3 py-1 border rounded bg-white hover:bg-gray-50">'.$totalPages.'</a>';
                            }
                            ?>

                            <!-- Bouton Suivant -->
                            <a href="?page=parametres_generaux&action=annees_academiques&page_num=<?= min($totalPages, $currentPage + 1) ?>"
                                class="px-3 py-1 border border-gray-200 rounded <?= $currentPage == $totalPages ? 'bg-gray-100 cursor-not-allowed' : 'bg-white hover:bg-gray-50' ?>">
                                <i class="fas fa-chevron-right text-green-500"></i>
                            </a>
                        </div>
                    </div>

                </form>

        </main>
    </div>


    <!-- Modale de confirmation de suppression -->
    <div id="deleteModal" class="fixed inset-0 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white shadow-sm  rounded-lg p-6 max-w-md w-full mx-4">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Confirmation de suppression</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Êtes-vous sûr de vouloir supprimer les années académiques sélectionnées ? Cette action est
                    irréversible.
                </p>
                <div class="mt-5 flex justify-center gap-6">
                    <button type="button" id="confirmDelete"
                        class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Confirmer
                    </button>
                    <button type="button" id="cancelDelete"
                        class="inline-flex justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modale de confirmation de modification -->
    <div id="modifyModal" class="fixed inset-0  bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white shadow-sm rounded-lg p-6 max-w-md w-full mx-4">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 mb-4">
                    <i class="fas fa-edit text-blue-600 text-xl"></i>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Confirmation de modification</h3>
                <p class="text-sm text-gray-500 mb-4">
                    Êtes-vous sûr de vouloir modifier cette année académique ?
                </p>
                <div class="mt-5 flex justify-center gap-6">
                    <button type="button" id="confirmModify"
                        class="inline-flex justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Confirmer
                    </button>
                    <button type="button" id="cancelModify"
                        class="inline-flex justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
    // Gestion des checkboxes et du bouton de suppression
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const deleteButton = document.getElementById('deleteSelectedBtn');
    const deleteModal = document.getElementById('deleteModal');
    const confirmDelete = document.getElementById('confirmDelete');
    const cancelDelete = document.getElementById('cancelDelete');
    const formListeAnnees = document.getElementById('formListeAnnees');

    // Modale de modification
    const btnModifier = document.getElementById('editBtn');
    const modifyModal = document.getElementById('modifyModal');
    const confirmModify = document.getElementById('confirmModify');
    const cancelModify = document.getElementById('cancelModify');
    const anneeForm = document.getElementById('anneeForm');

    // Initialisation de l'état du bouton supprimer
    updateDeleteButtonState();

    // Select all checkboxes
    selectAllCheckbox.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateDeleteButtonState();
    });

    // Update delete button state
    function updateDeleteButtonState() {
        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        deleteButton.disabled = checkedBoxes.length === 0;
        deleteButton.classList.toggle('opacity-50', checkedBoxes.length === 0);
        deleteButton.classList.toggle('cursor-not-allowed', checkedBoxes.length === 0);
    }

    // Event listener for checkbox changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('row-checkbox')) {
            updateDeleteButtonState();
            // Also update the "select all" checkbox
            const allCheckboxes = document.querySelectorAll('.row-checkbox');
            const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
            selectAllCheckbox.checked = checkedBoxes.length === allCheckboxes.length && allCheckboxes.length >
                0;
        }
    });

    // Afficher la modale de suppression
    if (deleteButton) {
        deleteButton.addEventListener('click', function(e) {
            e.preventDefault();
            if (!this.disabled) {
                deleteModal.classList.remove('hidden');
            }
        });
    }

    // Confirmer la suppression
    confirmDelete.addEventListener('click', function() {
        formListeAnnees.submit();
    });

    // Annuler la suppression
    cancelDelete.addEventListener('click', function() {
        deleteModal.classList.add('hidden');
    });

    // Afficher la modale de modification
    if (btnModifier) {
        btnModifier.addEventListener('click', function(e) {
            e.preventDefault();
            modifyModal.classList.remove('hidden');
        });
    }

    // Confirmer la modification
    if (confirmModify) {
        confirmModify.addEventListener('click', function(e) {
            e.preventDefault();
            const form = document.getElementById('anneeForm');
            if (form) {
                form.submit();
            }
        });
    }

    // Annuler la modification
    if (cancelModify) {
        cancelModify.addEventListener('click', function() {
            modifyModal.classList.add('hidden');
        });
    }

    // Fermer les modales lorsqu'on clique en dehors
    window.addEventListener('click', function(e) {
        if (e.target === deleteModal) {
            deleteModal.classList.add('hidden');
        }
        if (e.target === modifyModal) {
            modifyModal.classList.add('hidden');
        }
    });

    // Faire disparaître les messages après 5 secondes
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert-message');
        if (alerts.length > 0) {
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 1s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        if (alert.parentNode) {
                            alert.parentNode.removeChild(alert);
                        }
                    }, 1000);
                }, 5000); // 5 secondes avant de commencer à disparaître
            });
        }
    });

    // Fonction de recherche
    function filterTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('anneesTable');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) { // Commence à 1 pour sauter l'en-tête
            let found = false;
            const tds = tr[i].getElementsByTagName('td');

            for (let j = 1; j < tds.length -
                1; j++) { // Parcours toutes les colonnes sauf la première (checkbox) et la dernière (actions)
                const td = tds[j];
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
            }

            tr[i].style.display = found ? '' : 'none';
        }
    }

    // Fonction pour obtenir les données visibles du tableau
    function getVisibleTableData() {
        const visibleRows = [];
        const table = document.getElementById('anneesTable');
        const rows = table.querySelectorAll('tbody tr:not([style*="display: none"])');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            visibleRows.push({
                id: cells[1].textContent,
                annee: cells[2].textContent,
                date_debut: cells[3].textContent,
                date_fin: cells[4].textContent
            });
        });

        return visibleRows;
    }

    // Export CSV des données visibles
    $('#exportCsvBtn').click(function() {
        const visibleData = getVisibleTableData();
        let csv = 'ID,Annee academique,Date de debut,Date de fin\n';

        visibleData.forEach(row => {
            csv += `${row.id} ${row.annee} ${row.date_debut} ${row.date_fin} \n`;
        });

        const blob = new Blob([csv], {
            type: 'text/csv;charset=utf-8;'
        });
        const url = URL.createObjectURL(blob);
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', `annees_academiques_${new Date().toISOString().split('T')[0]}.csv`);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

    // Impression des données visibles
    $('#printBtn').click(function() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF();
        const visibleData = getVisibleTableData();

        // Titre
        doc.setFontSize(18);
        doc.text('Liste des années académiques', 14, 15);

        // Date d'impression
        doc.setFontSize(10);
        doc.text(`Imprimé le: ${new Date().toLocaleString()}`, 14, 22);

        // Préparation des données pour le PDF
        const pdfData = visibleData.map(row => [
            row.id,
            row.annee,
            row.date_debut,
            row.date_fin
        ]);

        // Tableau
        doc.autoTable({
            head: [
                ['ID', 'Année académique', 'Date début', 'Date fin']
            ],
            body: pdfData,
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

        doc.save(`annees_academiques_${new Date().toISOString().split('T')[0]}.pdf`);
    });

    // Fonction de recherche mise à jour
    function filterTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('anneesTable');
        const tr = table.querySelectorAll('tbody tr');

        tr.forEach(row => {
            let found = false;
            const tds = row.querySelectorAll('td');

            // On vérifie seulement les colonnes de données (ID, Année, Dates)
            for (let j = 1; j < tds.length - 1; j++) {
                const td = tds[j];
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().includes(filter)) {
                        found = true;
                        break;
                    }
                }
            }

            row.style.display = found ? '' : 'none';
        });
    }

    // Écouteur d'événement pour la recherche
    document.getElementById('searchInput').addEventListener('input', filterTable);
    </script>
</body>

</html>