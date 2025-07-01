<?php
require_once __DIR__ . '/../../app/controllers/ProcessusValidationController.php';

$controller = new ProcessusValidationController();
$donnees = $controller->getDonneesPage();

$statistiques = $donnees['statistiques'];
$rapports = $donnees['rapports'];
$membresCommission = $donnees['membres_commission'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'finaliser') {
    session_start();
    $id_rapport = intval($_POST['id_rapport']);
    $id_enseignant = isset($_SESSION['id_enseignant']) ? intval($_SESSION['id_enseignant']) : null;
    if ($id_enseignant && $id_rapport) {
        $controller->finaliserRapport($id_rapport, $id_enseignant);
        // Redirection pour éviter le resoumission du formulaire
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processus de Validation | Commission de Validation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .header { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .filters { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .filter-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; }
        .filter-grid select, .filter-grid input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .reports { background: transparent; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .report-item { 
            padding: 20px; 
            border-bottom: 1px solid #eee; 
            margin-bottom: 24px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            background: #fff;
            transition: box-shadow 0.2s, background 0.2s;
        }
        .report-item:last-child { border-bottom: none; }
        .report-item:hover {
            box-shadow: 0 4px 16px rgba(0,0,0,0.13);
            background: #f8fafc;
        }
        .report-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .report-title { font-size: 18px; font-weight: bold; margin: 0; }
        .status-badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; }
        .status-en-cours { background: #fff3cd; color: #856404; }
        .status-valide { background: #d4edda; color: #155724; }
        .status-rejete { background: #f8d7da; color: #721c24; }
        .evaluations {
            margin-top: 24px;
            padding-top: 16px;
            border-top: 2px solid #e0e7ef;
            background: none;
        }
        .evaluations h4 {
            margin-top: 0;
            margin-bottom: 12px;
            color: #3c9e5f;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }
        .evaluation-item { background: #f8f9fa; padding: 15px; margin-bottom: 10px; border-radius: 6px; }
        .evaluator { display: flex; align-items: center; margin-bottom: 8px; }
        .evaluator img { width: 24px; height: 24px; border-radius: 50%; margin-right: 8px; }
        .decision-valid { color: #28a745; }
        .decision-reject { color: #dc3545; }
        .decision-pending { color: #6c757d; }
        .actions { display: flex; gap: 10px; }
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .no-reports { text-align: center; padding: 40px; color: #6c757d; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-list-check"></i> Processus de Validation des Rapports</h1>
            <p>Aperçu de tous les rapports approuvés par la chargée de communication et leurs évaluations par les membres de la commission</p>
        </div>

        <div class="stats">
            <div class="stat-card">
                <h3><i class="fas fa-file-alt"></i> Total rapports approuvés</h3>
                <p style="font-size: 24px; font-weight: bold; color: #007bff;"><?= $statistiques['total_rapports'] ?></p>
            </div>
            <div class="stat-card">
                <h3><i class="fas fa-clock"></i> En cours d'évaluation</h3>
                <p style="font-size: 24px; font-weight: bold; color: #ffc107;"><?= $statistiques['en_cours'] ?></p>
            </div>
            <div class="stat-card">
                <h3><i class="fas fa-check"></i> Validés par la commission</h3>
                <p style="font-size: 24px; font-weight: bold; color: #28a745;"><?= $statistiques['valides'] ?></p>
            </div>
            <div class="stat-card">
                <h3><i class="fas fa-times"></i> Rejetés par la commission</h3>
                <p style="font-size: 24px; font-weight: bold; color: #dc3545;"><?= $statistiques['rejetes'] ?></p>
            </div>
        </div>

        <div class="filters">
            <h3><i class="fas fa-filter"></i> Filtres</h3>
            <div class="filter-grid">
                <div>
                    <label>Statut:</label>
                    <select id="statusFilter" onchange="filterReports()">
                        <option value="">Tous les statuts</option>
                        <option value="en_cours">En cours d'évaluation</option>
                        <option value="valide">Validé</option>
                        <option value="rejete">Rejeté</option>
                    </select>
                </div>
                <div>
                    <label>Membre:</label>
                    <select id="memberFilter" onchange="filterReports()">
                        <option value="">Tous les membres</option>
                        <?php foreach ($membresCommission as $membre): ?>
                            <option value="<?= htmlspecialchars($membre['nom_enseignant'] . ' ' . $membre['prenom_enseignant']) ?>">
                                <?= htmlspecialchars($membre['nom_enseignant'] . ' ' . $membre['prenom_enseignant']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label>Recherche:</label>
                    <input type="text" id="searchFilter" placeholder="Rechercher un rapport..." onkeyup="filterReports()">
                </div>
                <div>
                    <label>&nbsp;</label>
                    <button onclick="resetFilters()" class="btn btn-primary">Réinitialiser</button>
                </div>
            </div>
        </div>

        <div class="reports">
            <div style="padding: 20px; border-bottom: 1px solid #eee;">
                <h3><i class="fas fa-list-check"></i> Rapports approuvés en cours de validation</h3>
                <p id="reportCount"><?= count($rapports) ?> rapports trouvés</p>
            </div>

            <?php if (empty($rapports)): ?>
                <div class="no-reports">
                    <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 20px;"></i>
                    <h3>Aucun rapport approuvé</h3>
                    <p>Aucun rapport n'a encore été approuvé par la chargée de communication.</p>
                </div>
            <?php else: ?>
                <?php foreach ($rapports as $rapport): ?>
                    <div class="report-item" data-status="<?= $rapport['statut_vote']['statut'] ?>">
                        <div class="report-header">
                            <h3 class="report-title"><?= htmlspecialchars($rapport['nom_rapport']) ?></h3>
                            <div>
                                <span class="status-badge status-<?= $rapport['statut_vote']['statut'] ?>">
                                    <?= htmlspecialchars($rapport['statut_vote']['message']) ?>
                                </span>
                            </div>
                        </div>
                        <p>
                            <strong>Étudiant:</strong> <?= htmlspecialchars($rapport['nom_etu'] . ' ' . $rapport['prenom_etu']) ?> • 
                            <strong>Promotion:</strong> <?= htmlspecialchars($rapport['promotion_etu']) ?> • 
                            <strong>Date d'approbation:</strong> <?= date('d/m/Y H:i', strtotime($rapport['date_approv'])) ?>
                        </p>
                        <p><strong>Thème:</strong> <?= htmlspecialchars($rapport['theme_rapport']) ?></p>
                        <p><strong>Approuvé par:</strong> <?= htmlspecialchars($rapport['nom_pers_admin'] . ' ' . $rapport['prenom_pers_admin']) ?></p>
                        
                        <div class="evaluations">
                            <h4>Évaluations des membres :</h4>
                            
                            <?php if (empty($rapport['evaluations'])): ?>
                                <div class="evaluation-item">
                                    <p><em>Aucune évaluation effectuée pour le moment.</em></p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($rapport['evaluations'] as $evaluation): ?>
                                    <div class="evaluation-item">
                                        <div class="evaluator">
                                            <img src="https://ui-avatars.com/api/?name=<?= urlencode($evaluation['nom_enseignant'] . ' ' . $evaluation['prenom_enseignant']) ?>&background=random" 
                                                 alt="<?= htmlspecialchars($evaluation['nom_enseignant']) ?>">
                                            <strong><?= htmlspecialchars($evaluation['nom_enseignant'] . ' ' . $evaluation['prenom_enseignant']) ?></strong>
                                            <span class="decision-<?= $evaluation['decision_evaluation'] === 'valider' ? 'valid' : 'reject' ?>" style="margin-left: auto;">
                                                <?= $evaluation['decision_evaluation'] === 'valider' ? '✅ Validé' : '❌ Rejeté' ?>
                                            </span>
                                        </div>
                                        <p><em>"<?= htmlspecialchars($evaluation['commentaire']) ?>"</em></p>
                                        <small>Évalué le <?= date('d/m/Y à H:i', strtotime($evaluation['date_evaluation'])) ?></small>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            
                            <!-- Afficher les membres qui n'ont pas encore évalué -->
                            <?php 
                            $evaluateursIds = array_column($rapport['evaluations'], 'id_evaluateur');
                            foreach ($membresCommission as $membre):
                                if (!in_array($membre['id_enseignant'], $evaluateursIds)):
                            ?>
                                <div class="evaluation-item">
                                    <div class="evaluator">
                                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($membre['nom_enseignant'] . ' ' . $membre['prenom_enseignant']) ?>&background=random" 
                                             alt="<?= htmlspecialchars($membre['nom_enseignant']) ?>">
                                        <strong><?= htmlspecialchars($membre['nom_enseignant'] . ' ' . $membre['prenom_enseignant']) ?></strong>
                                        <span class="decision-pending" style="margin-left: auto;">⏳ En attente</span>
                                    </div>
                                    <p><em>Pas encore évalué</em></p>
                                </div>
                            <?php 
                                endif;
                            endforeach; 
                            ?>
                        </div>
                        
                        <div class="actions" style="margin-top: 15px;">
                            <button onclick="viewReport(<?= $rapport['id_rapport'] ?>)" class="btn btn-primary"><i class="fas fa-file-lines"></i> Consulter</button>
                            <?php if (!$rapport['statut_vote']['finalise']): ?>
                                <form id="form-finaliser-<?= $rapport['id_rapport'] ?>" method="POST" style="display:inline;">
                                    <input type="hidden" name="action" value="finaliser">
                                    <input type="hidden" name="id_rapport" value="<?= $rapport['id_rapport'] ?>">
                                    <button type="button" class="btn btn-success" onclick="confirmerFinalisation(<?= $rapport['id_rapport'] ?>)">Finaliser</button>
                                </form>
                            <?php else: ?>
                                <button class="btn btn-<?= $rapport['statut_vote']['statut'] === 'valide' ? 'success' : 'danger' ?>" disabled>
                                    ⚖️ Finalisé
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function filterReports() {
            const statusFilter = document.getElementById('statusFilter').value;
            const memberFilter = document.getElementById('memberFilter').value;
            const searchFilter = document.getElementById('searchFilter').value.toLowerCase();
            
            const reports = document.querySelectorAll('.report-item');
            let visibleCount = 0;
            
            reports.forEach(report => {
                let show = true;
                
                if (statusFilter && report.dataset.status !== statusFilter) {
                    show = false;
                }
                
                if (memberFilter && !report.textContent.includes(memberFilter)) {
                    show = false;
                }
                
                if (searchFilter && !report.textContent.toLowerCase().includes(searchFilter)) {
                    show = false;
                }
                
                report.style.display = show ? 'block' : 'none';
                if (show) visibleCount++;
            });
            
            document.getElementById('reportCount').textContent = `${visibleCount} rapports trouvés`;
        }
        
        function resetFilters() {
            document.getElementById('statusFilter').value = '';
            document.getElementById('memberFilter').value = '';
            document.getElementById('searchFilter').value = '';
            
            const reports = document.querySelectorAll('.report-item');
            reports.forEach(report => {
                report.style.display = 'block';
            });
            
            document.getElementById('reportCount').textContent = `${reports.length} rapports trouvés`;
        }
        
        function viewReport(reportId) {
            window.location.href = '?page=rapport_a_valider&action=consulter&id=' + reportId;
        }
        
        function confirmerFinalisation(reportId) {
            if (confirm("Voulez-vous vraiment finaliser la décision finale concernant ce rapport ?")) {
                document.getElementById('form-finaliser-' + reportId).submit();
            }
        }
    </script>
</body>
</html> 