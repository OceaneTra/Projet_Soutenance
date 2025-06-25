<?php
// Récupérer les données des rapports depuis le contrôleur
$rapports = $GLOBALS['rapports'] ?? [];
$nbRapports = $GLOBALS['nbRapports'] ?? 0;
$statsRapports = $GLOBALS['statsRapports'] ?? [];

// Fonction pour obtenir la classe CSS du statut
function getStatutClass($statut) {
    switch ($statut) {
        case 'valide':
            return 'text-green-500 ';
        case 'rejete':
            return 'text-red-500 ';
        case 'en_revision':
            return 'text-orange-500 ';
        case 'a_corriger':
            return ' text-yelow-500 ';
        default:
            return ' text-blue-500 ';
    }
}

// Fonction pour traduire le statut
function traduireStatut($statut) {
    switch ($statut) {
        case 'valide':
            return 'Validé';
        case 'rejete':
            return 'Rejeté';
        case 'en_revision':
            return 'En révision';
        case 'a_corriger':
            return 'À corriger';
        case 'en_cours':
            return 'En cours';
        default:
            return ucfirst($statut);
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification des rapports étudiants</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --danger-gradient: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
        --info-gradient: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        --card-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        --hover-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    body {
        min-height: 100vh;
    }

    .stat-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 16px;
        padding: 0.5rem;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--hover-shadow);
    }

    .stat-card.blue {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }

    .stat-card.orange {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }



    .search-container {
        position: relative;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        padding: 0.5rem;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    .search-input {
        width: 100%;
        padding: 1rem 1rem 1rem 3rem;
        border: none;
        border-radius: 15px;
        background: transparent;
        font-size: 1rem;
        color: #374151;
        outline: none;
    }

    .search-input::placeholder {
        color: #9ca3af;
    }

    .search-icon {
        position: absolute;
        left: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        color: #667eea;
        font-size: 1.2rem;
    }

    .table-container {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: var(--card-shadow);
    }

    .table-header {
        color: white;
        padding: 1rem;
    }

    .table-header h2 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .table-header p {
        margin: 0.5rem 0 0;
        opacity: 0.9;
        font-size: 1rem;
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table th {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        color: #374151;
        font-weight: 600;
        padding: 1rem;
        text-align: center;
        border-bottom: 2px solid #e2e8f0;
        font-size: 0.9rem;
        text-transform: capitalize;
    }

    .table td {
        padding: 1.2rem 1rem;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        transform: scale(1.01);
    }


    .action-btn {
        padding: 0.6rem 1.2rem;
        border: none;
        border-radius: 12px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin: 0 0.2rem;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    .btn-validate {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .btn-reject {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .btn-detail {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .modal {
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
    }

    .modal-content {
        background: white;
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .table-container {
            overflow-x: auto;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
    </style>
</head>

<body class="min-h-screen p-4 md:p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="glass-card rounded-2xl p-6 md:p-8 mb-8 fade-in">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-clipboard-check text-2xl text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl md:text-4xl font-bold text-green-600">
                            Vérification des Rapports
                        </h1>
                        <p class="text-gray-600 mt-2 text-lg">
                            Gérez et validez les rapports soumis par les étudiants
                        </p>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="stat-card">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm opacity-90">Total</p>
                                <p class="text-2xl font-bold"><?= $nbRapports ?></p>
                            </div>
                            <i class="fas fa-file-alt text-2xl opacity-80"></i>
                        </div>
                    </div>

                    <?php if (!empty($statsRapports)): ?>
                    <div class="stat-card blue">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm opacity-90">En cours</p>
                                <p class="text-2xl font-bold"><?= $statsRapports['en_cours'] ?? 0 ?></p>
                            </div>
                            <i class="fas fa-clock text-2xl opacity-80"></i>
                        </div>
                    </div>

                    <div class="stat-card orange">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm opacity-90">En révision</p>
                                <p class="text-2xl font-bold"><?= $statsRapports['en_revision'] ?? 0 ?></p>
                            </div>
                            <i class="fas fa-search text-2xl opacity-80"></i>
                        </div>
                    </div>

                    <div class="stat-card blue">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm opacity-90">Validés</p>
                                <p class="text-2xl font-bold"><?= $statsRapports['valide'] ?? 0 ?></p>
                            </div>
                            <i class="fas fa-check-circle text-2xl opacity-80"></i>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Search Section -->

        <div class="search-container mb-6">
            <i class="fas fa-search search-icon"></i>
            <input type="text" id="searchInput" class="search-input"
                placeholder="Rechercher par nom d'étudiant, rapport ou thème...">
        </div>


        <!-- Table Section -->
        <div class="table-container fade-in">
            <div class="table-header bg-green-600">
                <h2><i class="fas fa-list-ul mr-3"></i>Liste des Rapports</h2>
                <p>Vérifiez, validez ou rejetez les rapports soumis par les étudiants</p>
            </div>

            <div class="overflow-x-auto">
                <table id="rapportsTable" class="table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user-graduate mr-2"></i>Étudiant</th>
                            <th><i class="fas fa-file-lines mr-2"></i>Rapport</th>
                            <th><i class="fas fa-lightbulb mr-2"></i>Thème</th>
                            <th><i class="fas fa-calendar-day mr-2"></i>Date</th>
                            <th><i class="fas fa-info-circle mr-2"></i>Statut</th>
                            <th class="text-center"><i class="fas fa-cogs mr-2"></i>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($rapports)): ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-file-circle-xmark"></i>
                                    <h3 class="text-xl font-semibold mb-2">Aucun rapport trouvé</h3>
                                    <p class="text-gray-500">Les rapports soumis par les étudiants apparaîtront ici</p>
                                </div>
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($rapports as $i => $rapport): ?>
                        <tr
                            class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300">
                            <td class="font-semibold text-gray-800">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <div class="font-semibold">
                                            <?= htmlspecialchars($rapport->nom_etu . ' ' . $rapport->prenom_etu) ?>
                                        </div>
                                        <div class="text-sm text-gray-500">Étudiant</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="font-bold text-gray-900"><?= htmlspecialchars($rapport->nom_rapport) ?>
                                </div>
                                <div class="text-sm text-gray-500">Rapport de master</div>
                            </td>
                            <td>
                                <div class="italic text-blue-700 max-w-xs truncate">
                                    <?= htmlspecialchars($rapport->theme_rapport) ?></div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-clock text-orange-500"></i>
                                    <span
                                        class="font-semibold text-gray-700"><?= date('d/m/Y', strtotime($rapport->date_rapport)) ?></span>
                                </div>
                            </td>
                            <td>
                                <span class=" <?= getStatutClass($rapport->statut_rapport) ?>">
                                    <?= traduireStatut($rapport->statut_rapport) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="flex items-center justify-center gap-2 action-buttons">
                                    <?php if ($rapport->statut_rapport !== 'valide' && $rapport->statut_rapport !== 'rejete'): ?>
                                    <button onclick="validerRapport(<?= $rapport->id_rapport ?>)"
                                        class="action-btn btn-validate">
                                        <i class="fas fa-check mr-1"></i> Valider
                                    </button>
                                    <button onclick="rejeterRapport(<?= $rapport->id_rapport ?>)"
                                        class="action-btn btn-reject">
                                        <i class="fas fa-times mr-1"></i> Rejeter
                                    </button>
                                    <?php endif; ?>
                                    <button onclick="voirDetail(<?= $rapport->id_rapport ?>)"
                                        class="action-btn btn-detail">
                                        <i class="fas fa-eye mr-1"></i> Détail
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal pour les détails du rapport -->
    <div id="detailModal" class="modal fixed inset-0 hidden z-50 flex items-center justify-center p-4">
        <div class="modal-content max-w-4xl w-full max-h-[90vh] overflow-y-auto rounded-2xl">
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-purple-500 to-blue-600 text-white">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold">Détails du rapport</h3>
                    <button onclick="fermerModal()" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div id="modalContent" class="p-6">
                <!-- Le contenu sera chargé dynamiquement -->
            </div>
        </div>
    </div>

    <script>
    // Recherche dynamique dans le tableau
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function() {
        const term = this.value.toLowerCase();
        const rows = document.querySelectorAll('#rapportsTable tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(term) ? '' : 'none';
        });
    });

    // Fonction pour valider un rapport
    function validerRapport(idRapport) {
        if (confirm('Êtes-vous sûr de vouloir valider ce rapport ?')) {
            fetch('?page=verification_candidatures_soutenance&action=valider', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id_rapport=' + idRapport
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Erreur: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors de la validation');
                });
        }
    }

    // Fonction pour rejeter un rapport
    function rejeterRapport(idRapport) {
        if (confirm('Êtes-vous sûr de vouloir rejeter ce rapport ?')) {
            fetch('?page=verification_candidatures_soutenance&action=rejeter', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id_rapport=' + idRapport
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Erreur: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Erreur lors du rejet');
                });
        }
    }

    // Fonction pour voir les détails d'un rapport
    function voirDetail(idRapport) {
        fetch('?page=verification_candidatures_soutenance&action=detail&id=' + idRapport)
            .then(response => response.text())
            .then(html => {
                document.getElementById('modalContent').innerHTML = html;
                document.getElementById('detailModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors du chargement des détails');
            });
    }

    // Fonction pour fermer le modal
    function fermerModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    // Fermer le modal en cliquant à l'extérieur
    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            fermerModal();
        }
    });
    </script>
</body>

</html>