<?php
// Supposons que $reclamationsEnCours et $reclamationsTraitees sont passés par le contrôleur
// $reclamationsEnCours : réclamations statut 'en attente' ou 'en cours'
// $reclamationsTraitees : réclamations statut 'traitée' ou 'clôturée'
?>
<div class="container mx-auto p-4">

    <!-- Barre de recherche et actions -->
    <div class="flex flex-wrap items-center justify-between mb-4 gap-2">
        <input type="text" id="searchInput" placeholder="Rechercher..."
            class="outline-green-500 border border-green-500 px-3 py-2 rounded w-64 focus:ring-green-500 focus:border-green-500 bg-green-50"
            onkeyup="filterReclamations()">
        <div class="flex gap-2">
            <button onclick="exportCSV()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"><i
                    class="fa fa-file-csv mr-1"></i>Exporter CSV</button>
            <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-green-800"><i
                    class="fa fa-print mr-1"></i>Imprimer</button>
        </div>
    </div>

    <!-- Liste des réclamations en cours -->
    <div class="mb-8 rounded-lg">
        <h3 class="text-xl font-semibold mb-2 text-green-700">Réclamations à traiter</h3>
        <table class="min-w-full bg-white rounded-lg shadow" id="tableReclamationsEnCours">
            <thead class="bg-green-100">
                <tr>
                    <th class="px-3 py-2 text-green-800">#</th>
                    <th class="px-3 py-2 text-green-800">Étudiant</th>
                    <th class="px-3 py-2 text-green-800">Objet</th>
                    <th class="px-3 py-2 text-green-800">Message</th>
                    <th class="px-3 py-2 text-green-800">Date</th>
                    <th class="px-3 py-2 text-green-800">Statut</th>
                    <th class="px-3 py-2 text-green-800">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($reclamationsEnCours)): ?>
                <?php foreach ($reclamationsEnCours as $i => $rec): ?>
                <tr class="even:bg-green-50 hover:bg-green-100">
                    <td class="border px-3 py-2 border-green-100"><?= $i+1 ?></td>
                    <td class="border px-3 py-2 border-green-100">
                        <?= htmlspecialchars($rec->nom_etu . ' ' . $rec->prenom_etu) ?></td>
                    <td class="border px-3 py-2 border-green-100"><?= htmlspecialchars($rec->titre_reclamation) ?></td>
                    <td class="border px-3 py-2 border-green-100"><?= htmlspecialchars($rec->description_reclamation) ?>
                    </td>
                    <td class="border px-3 py-2 border-green-100"><?= htmlspecialchars($rec->date_creation) ?></td>
                    <td class="border px-3 py-2 border-green-100">
                        <span class="inline-block px-2 py-1 rounded text-xs 
                            <?php if($rec->statut_reclamation === 'en attente') echo 'bg-yellow-200 text-yellow-800';
                                  elseif($rec->statut_reclamation === 'en cours') echo 'bg-green-200 text-green-800';
                                  ?>">
                            <?= htmlspecialchars($rec->statut_reclamation) ?>
                        </span>
                    </td>
                    <td class="border px-3 py-2 border-green-100 flex gap-2">
                        <form method="post"
                            action="?page=gestion_reclamations_scolarite&action=changer_statut&id=<?= $rec->id_reclamation ?>"
                            style="display:inline;">
                            <select name="nouveau_statut"
                                class="border rounded px-2 py-1 border-green-300 focus:ring-green-500 focus:border-green-500">
                                <option value="en attente"
                                    <?= $rec->statut_reclamation === 'en attente' ? 'selected' : '' ?>>En
                                    attente</option>
                                <option value="en cours"
                                    <?= $rec->statut_reclamation === 'en cours' ? 'selected' : '' ?>>En cours
                                </option>
                                <option value="traitée">Traitée</option>
                                <option value="clôturée">Clôturée</option>
                            </select>
                            <button type="submit"
                                class="ml-2 px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700">Valider</button>
                        </form>
                        <button type="button"
                            onclick='showReclamationDetails(<?= json_encode($rec, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'
                            class="px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600">
                            <i class="fa fa-eye"></i> Voir détails
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center py-4 text-green-700">Aucune réclamation à traiter.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Historique des réclamations -->
    <div class="rounded-lg">
        <h3 class="text-xl font-semibold mb-2 text-green-700">Historique des réclamations</h3>
        <table class="min-w-full bg-white rounded-lg shadow" id="tableReclamationsTraitees">
            <thead class="bg-green-100">
                <tr>
                    <th class="px-3 py-2 text-green-800">#</th>
                    <th class="px-3 py-2 text-green-800">Étudiant</th>
                    <th class="px-3 py-2 text-green-800">Objet</th>
                    <th class="px-3 py-2 text-green-800">Message</th>
                    <th class="px-3 py-2 text-green-800">Date</th>
                    <th class="px-3 py-2 text-green-800">Statut</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($reclamationsTraitees)): ?>
                <?php foreach ($reclamationsTraitees as $i => $rec): ?>
                <tr class="even:bg-green-50 hover:bg-green-100">
                    <td class="border px-3 py-2 border-green-100"><?= $i+1 ?></td>
                    <td class="border px-3 py-2 border-green-100">
                        <?= htmlspecialchars($rec->nom_etu . ' ' . $rec->prenom_etu) ?></td>
                    <td class="border px-3 py-2 border-green-100"><?= htmlspecialchars($rec->objet) ?></td>
                    <td class="border px-3 py-2 border-green-100"><?= htmlspecialchars($rec->message) ?></td>
                    <td class="border px-3 py-2 border-green-100"><?= htmlspecialchars($rec->date_reclamation) ?></td>
                    <td class="border px-3 py-2 border-green-100">
                        <span class="inline-block px-2 py-1 rounded text-xs 
                            <?php if($rec->statut_reclamation === 'traitée') echo 'bg-green-300 text-green-900';
                                  else echo 'bg-gray-200 text-gray-800'; ?>">
                            <?= htmlspecialchars($rec->statut_reclamation) ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center py-4 text-green-700">Aucun historique de réclamation.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="flex justify-center my-4 gap-2 rounded-lg p-2 text-green-700" id="pagination">
        </div>
    </div>
</div>

<!-- Modal détails réclamation -->
<div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg relative">
        <button onclick="closeDetailsModal()"
            class="absolute top-2 right-2 text-gray-500 hover:text-green-700 text-xl">&times;</button>
        <h3 class="text-xl font-bold mb-4 text-green-700">Détails de la réclamation</h3>
        <div id="detailsContent" class="space-y-2 text-sm"></div>
    </div>
</div>

<script>
function filterReclamations() {
    var input = document.getElementById('searchInput');
    var filter = input.value.toLowerCase();
    var tables = [document.getElementById('tableReclamationsEnCours'), document.getElementById(
        'tableReclamationsTraitees')];
    tables.forEach(function(table) {
        var trs = table.getElementsByTagName('tr');
        for (var i = 1; i < trs.length; i++) {
            var tds = trs[i].getElementsByTagName('td');
            var show = false;
            for (var j = 0; j < tds.length; j++) {
                if (tds[j].textContent.toLowerCase().indexOf(filter) > -1) {
                    show = true;
                    break;
                }
            }
            trs[i].style.display = show ? '' : 'none';
        }
    });
}

function exportCSV() {
    var csv = '';
    var tables = [document.getElementById('tableReclamationsEnCours'), document.getElementById(
        'tableReclamationsTraitees')];
    tables.forEach(function(table) {
        var rows = table.querySelectorAll('tr');
        rows.forEach(function(row) {
            var cols = row.querySelectorAll('th,td');
            var rowData = [];
            cols.forEach(function(col) {
                rowData.push('"' + col.innerText.replace(/"/g, '""') + '"');
            });
            csv += rowData.join(',') + '\n';
        });
        csv += '\n';
    });
    var blob = new Blob([csv], {
        type: 'text/csv'
    });
    var link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = 'reclamations.csv';
    link.click();
}

// Pagination pour l'historique
const rowsPerPage = 10;
const table = document.getElementById('tableReclamationsTraitees');
const tbody = table ? table.querySelector('tbody') : null;
const pagination = document.getElementById('pagination');
if (tbody && pagination) {
    const rows = Array.from(tbody.querySelectorAll('tr'));
    let currentPage = 1;

    function showPage(page) {
        currentPage = page;
        const start = (page - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        rows.forEach((row, i) => {
            row.style.display = (i >= start && i < end) ? '' : 'none';
        });
        renderPagination();
    }

    function renderPagination() {
        pagination.innerHTML = '';
        const pageCount = Math.ceil(rows.length / rowsPerPage);
        for (let i = 1; i <= pageCount; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.className = (i === currentPage ? 'active' : '');
            btn.disabled = (i === currentPage);
            btn.onclick = () => showPage(i);
            pagination.appendChild(btn);
        }
    }
    showPage(1);
}

function showReclamationDetails(rec) {
    let html = '';
    html += `<div><b>Étudiant :</b> ${rec.nom_etu} ${rec.prenom_etu}</div>`;
    html += `<div><b>Objet :</b> ${rec.objet}</div>`;
    html += `<div><b>Message :</b> ${rec.message}</div>`;
    html += `<div><b>Date :</b> ${rec.date ? rec.date : (rec.date_reclamation ? rec.date_reclamation : '')}</div>`;
    html += `<div><b>Statut :</b> ${rec.statut}</div>`;
    document.getElementById('detailsContent').innerHTML = html;
    document.getElementById('detailsModal').classList.remove('hidden');
}

function closeDetailsModal() {
    document.getElementById('detailsModal').classList.add('hidden');
}
</script>