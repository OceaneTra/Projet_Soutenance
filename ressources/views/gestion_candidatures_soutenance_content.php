<?php
// Récupérer les données du contrôleur
$candidatures = $GLOBALS['candidatures_soutenance'] ?? [];
$examiner = $GLOBALS['examiner'] ?? null;
$etape = $GLOBALS['etape'] ?? 1;
$etudiantData = $GLOBALS['etudiantData'] ?? null;
$etapeData = $GLOBALS['etapeData'] ?? null;

// Démarrer la session pour accéder aux étapes validées/rejetées
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$statutFiltre = $_GET['statut'] ?? 'all';
if ($statutFiltre !== 'all') {
    $candidatures = array_filter($candidatures, function($c) use ($statutFiltre) {
        return $c['statut_candidature'] === $statutFiltre;
    });
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Candidatures de Soutenance</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
    :root {
        --primary: #6F42C1;
        /* Purple color from image */
        --secondary: #E9ECEF;
        --success: #10B981;
        --danger: #EF4444;
        --gray: #6B7280;
        --light-gray-bg: #F3F4F6;
        --white-bg: #FFFFFF;
        --border-color: #E5E7EB;
        --text-color-dark: #1F2937;
        --text-color-medium: #4B5563;
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background-color: var(--light-gray-bg);
        margin: 0;

        color: var(--text-color-medium);
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .main-content {
        background: var(--white-bg);
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        padding: 20px;
    }

    .filters {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
        flex-wrap: wrap;
    }

    .search-box {
        position: relative;
        flex: 1;
        min-width: 200px;
        /* Minimum width for search input */
    }

    .search-box input {
        width: 100%;
        padding: 10px 15px 10px 40px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
    }

    .search-box i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray);
    }

    .filters select {
        padding: 10px 15px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        background-color: var(--white-bg);
        cursor: pointer;
    }


    .candidate-list {
        display: grid;
        gap: 15px;
    }

    .candidate-item {
        background: #F9FAFB;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        /* Allow wrapping on smaller screens */
        gap: 10px;
        /* Spacing between flex items */
    }

    .candidate-info h3 {
        margin: 0;
        font-size: 16px;
        color: var(--text-color-dark);
    }

    .candidate-info p {
        margin: 5px 0 0;
        font-size: 14px;
        color: var(--gray);
    }

    .btn-examine {
        background: var(--primary);
        color: white;
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .btn-examine:hover {
        background: #5a37a8;
        /* Darker shade of purple */
    }

    /* Modal */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1000;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
        justify-content: center;
        /* Center horizontal */
        align-items: center;
        /* Center vertical */
    }

    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 30px;
        border-radius: 10px;
        max-width: 700px;
        width: 90%;
        max-height: 90vh;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        position: relative;
        display: flex;
        /* Use flex for internal layout */
        flex-direction: column;
        overflow: hidden;
    }

    .close-button {
        color: #aaa;
        position: absolute;
        top: 15px;
        right: 25px;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close-button:hover,
    .close-button:focus {
        color: #000;
        text-decoration: none;
    }

    .modal-title {
        text-align: center;
        font-size: 24px;
        font-weight: 600;
        color: var(--text-color-dark);
        margin-bottom: 20px;
    }

    .step-indicator {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        position: relative;
    }

    .step-indicator::before {
        content: '';
        position: absolute;
        top: 18px;
        left: 10%;
        /* Adjusted for wider spacing */
        right: 10%;
        /* Adjusted for wider spacing */
        height: 4px;
        background-color: var(--secondary);
        z-index: 1;
    }

    .step {
        flex: 1;
        text-align: center;
        z-index: 2;
        position: relative;
        /* Needed for pseudo-element */
    }

    .step:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 18px;
        right: -50%;
        /* Position the line to the right of the step */
        width: 100%;
        /* Extend the line to the next step */
        height: 4px;
        background-color: var(--secondary);
        z-index: -1;
        /* Behind the steps */
    }

    .step.completed:not(:last-child)::after {
        background-color: var(--primary);
        /* Highlight line if step is completed */
    }


    .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: var(--secondary);
        color: var(--white-bg);
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 5px;
        transition: background-color 0.3s ease;
    }

    .step.active .step-icon {
        background-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.3);
        transform: scale(1.1);
    }

    .step.completed .step-icon {
        background-color: var(--success);
    }

    .step.rejected .step-icon {
        background-color: var(--danger);
    }

    .step-label {
        font-size: 12px;
        color: var(--gray);
    }

    .step.active .step-label,
    .step.completed .step-label,
    .step.rejected .step-label {
        color: var(--text-color-dark);
        font-weight: 500;
    }

    .modal-body {
        flex-grow: 1;
        /* Allows body to take up available space */
        overflow-y: scroll;
        /* Force scrollbar to always show */
        max-height: 70vh;
        /* Limit height for scrolling */
        padding-right: 15px;
        /* Add padding for scrollbar */
        scrollbar-width: thin;
        /* For Firefox */
        scrollbar-color: #888 #f1f1f1;
        /* For Firefox */
    }

    /* Custom scrollbar for Webkit browsers */
    .modal-body::-webkit-scrollbar {
        width: 8px;
    }

    .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .modal-body::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .step-content {
        display: none;
        /* Hide all step content by default */
    }

    .step-content.active {
        display: block;
        /* Show active step content */
    }

    .info-section {
        margin-bottom: 20px;
        padding: 15px;
        background: #F9FAFB;
        border-radius: 8px;
    }

    .info-section h3 {
        font-size: 18px;
        color: var(--text-color-dark);
        margin-top: 0;
        margin-bottom: 10px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 5px;
    }

    .info-item {
        margin-bottom: 10px;
    }

    .info-item strong {
        display: inline-block;
        width: 180px;
        /* Adjust as needed */
        color: var(--text-color-medium);
    }

    .verification-status i {
        margin-right: 5px;
    }

    .verification-status .fa-check-circle {
        color: var(--success);
    }

    .verification-status .fa-times-circle {
        color: var(--danger);
    }

    .verification-status .fa-clock {
        color: var(--gray);
    }


    .modal-footer {
        display: flex;
        justify-content: space-between;
        /* Space out buttons */
        gap: 10px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
    }

    .btn {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
        color: white;
    }

    .btn-secondary {
        background: var(--gray);
    }

    .btn-secondary:hover {
        background: #4B5563;
        /* Darker gray */
    }

    .btn-primary {
        background: var(--primary);
    }

    .btn-primary:hover {
        background: #5a37a8;
    }

    .btn-validate,
    .btn-reject {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.2s;
        color: white;
    }

    .btn-validate {
        background: var(--success);
    }

    .btn-validate:hover {
        background: #059669;
    }

    .btn-reject {
        background: var(--danger);
    }

    .btn-reject:hover {
        background: #DC2626;
    }

    .modal-footer .left-buttons {
        display: flex;
        gap: 10px;
    }


    /* History Table Styles */
    .history-section {
        margin-top: 30px;
        padding: 20px;
        background: var(--white-bg);
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .history-section h2 {
        margin-top: 0;
        color: var(--text-color-dark);
        margin-bottom: 20px;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 10px;
    }

    .history-table {
        width: 100%;
        border-collapse: collapse;
    }

    .history-table th,
    .history-table td {
        text-align: left;
        padding: 12px;
        border-bottom: 1px solid var(--border-color);
    }

    .history-table th {
        background-color: #F9FAFB;
        font-size: 14px;
        color: var(--text-color-dark);
    }

    .history-table td {
        font-size: 14px;
    }

    .history-table tbody tr:last-child td {
        border-bottom: none;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-badge.en_attente {
        background-color: #FEF3C7;
        color: #92400E;
    }

    .status-badge.validee {
        background-color: #D1FAE5;
        color: #065F46;
    }

    .status-badge.rejetee {
        background-color: #FEE2E2;
        color: #991B1B;
    }

    .table-container {
        margin-top: 2rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .table-header {
        background-color: #f8fafc;
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .table-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
    }

    .history-table {
        width: 100%;
        border-collapse: collapse;
    }

    .history-table th,
    .history-table td {
        padding: 0.75rem 1rem;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }

    .history-table th {
        background-color: #f8fafc;
        font-weight: 600;
        color: #475569;
    }

    .history-table tr:hover {
        background-color: #f8fafc;
    }

    .action-badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .action-validation {
        background-color: #dcfce7;
        color: #166534;
    }

    .action-rejet {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .action-verification {
        background-color: #fef3c7;
        color: #92400e;
    }

    /* Styles pour le résumé final */
    .resume-final {
        margin-top: 20px;
    }

    .decision-finale {
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
    }

    .decision-finale.validee {
        background-color: #D1FAE5;
        border: 2px solid var(--success);
        color: #065F46;
    }

    .decision-finale.rejetee {
        background-color: #FEE2E2;
        border: 2px solid var(--danger);
        color: #991B1B;
    }

    .decision-finale h4 {
        margin: 0 0 10px 0;
        font-size: 20px;
        font-weight: 600;
    }

    .decision-finale p {
        margin: 0;
        font-size: 16px;
    }

    .resume-etapes {
        margin-top: 20px;
    }

    .resume-etapes h4 {
        margin-bottom: 15px;
        color: var(--text-color-dark);
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 5px;
    }

    .etape-resume {
        margin-bottom: 15px;
        padding: 15px;
        border-radius: 8px;
        border-left: 4px solid var(--gray);
    }

    .etape-resume.validé {
        background-color: #F0FDF4;
        border-left-color: var(--success);
    }

    .etape-resume.rejeté {
        background-color: #FEF2F2;
        border-left-color: var(--danger);
    }

    .etape-resume h5 {
        margin: 0 0 10px 0;
        color: var(--text-color-dark);
        font-size: 16px;
    }

    .etape-resume h5 i {
        margin-right: 8px;
        color: var(--primary);
    }

    .etape-details p {
        margin: 5px 0;
        font-size: 14px;
    }

    .badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .badge.validé {
        background-color: var(--success);
        color: white;
    }

    .badge.rejeté {
        background-color: var(--danger);
        color: white;
    }

    .badge.non-évalué {
        background-color: var(--gray);
        color: white;
    }

    .email-notification {
        margin-top: 20px;
        padding: 15px;
        background-color: #EFF6FF;
        border: 1px solid #3B82F6;
        border-radius: 8px;
        color: #1E40AF;
    }

    .email-notification p {
        margin: 0;
        font-size: 14px;
    }

    .email-notification i {
        margin-right: 8px;
        color: #3B82F6;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="main-content">
            <h1 class="text-2xl font-bold mb-6">Gestion des Candidatures de Soutenance</h1>

            <!-- Message d'erreur pour les étudiants sans informations de stage -->
            <?php if (isset($_GET['error']) && $_GET['error'] === 'no_stage_info'): ?>
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <strong>Erreur :</strong> Cet étudiant n'a pas rempli ses informations de stage. Il ne peut pas être
                examiné tant qu'il n'a pas complété cette étape.
            </div>
            <?php endif; ?>

            <!-- Filtres -->
            <div class="filters">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" style="outline: none;" placeholder="Rechercher un étudiant...">
                </div>
                <form method="get" id="filterForm" style="margin:0;">
                    <input type="hidden" name="page" value="gestion_candidatures_soutenance">
                    <select name="statut" id="statusFilter" style="outline: none;"
                        onchange="document.getElementById('filterForm').submit()">
                        <option value="all" <?php if(($_GET['statut'] ?? 'all') === 'all') echo 'selected'; ?>>Tous les
                            statuts</option>
                        <option value="En attente"
                            <?php if(($_GET['statut'] ?? '') === 'En attente') echo 'selected'; ?>>En attente</option>
                        <option value="Validée" <?php if(($_GET['statut'] ?? '') === 'Validée') echo 'selected'; ?>>
                            Validée</option>
                        <option value="Rejetée" <?php if(($_GET['statut'] ?? '') === 'Rejetée') echo 'selected'; ?>>
                            Rejetée</option>
                    </select>
                </form>
            </div>

            <!-- Liste des candidatures -->
            <div class="candidate-list">
                <?php if (empty($candidatures)): ?>
                <div class="text-center text-gray-500 py-4">
                    Aucune candidature à afficher
                </div>
                <?php else: ?>
                <?php foreach ($candidatures as $candidature): ?>
                <div class="candidate-item" data-status="<?php echo $candidature['statut_candidature']; ?>">
                    <div class="candidate-info">
                        <h3><?php echo htmlspecialchars($candidature['nom_etu'] . ' ' . $candidature['prenom_etu']); ?>
                        </h3>
                        <p>Numéro étudiant: <?php echo htmlspecialchars($candidature['num_etu']); ?></p>
                        <p>Date de demande: <?php echo date('d/m/Y', strtotime($candidature['date_candidature'])); ?>
                        </p>
                        <p>Statut: <span class="status-badge <?php echo $candidature['statut_candidature']; ?>">
                                <?php echo ucfirst($candidature['statut_candidature']); ?>
                            </span></p>
                    </div>
                    <button class="btn-examine"
                        onclick="window.location.href='?page=gestion_candidatures_soutenance&examiner=<?php echo $candidature['num_etu']; ?>&etape=1'">
                        Examiner
                    </button>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Table d'historique -->
            <div class="table-container">
                <div class="table-header">
                    <h2 class="table-title">Historique des actions</h2>
                </div>
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Action</th>
                            <th>Commentaire</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="historiqueTableBody">
                        <!-- L'historique sera chargé ici -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal d'examen -->
    <?php if ($examiner && $etudiantData): ?>
    <div id="examinationModal" class="modal" style="display: flex;">
        <?php else: ?>
        <div id="examinationModal" class="modal" style="display: none;">
            <?php endif; ?>
            <div class="modal-content">
                <a href="?page=gestion_candidatures_soutenance" class="close-button">&times;</a>
                <h2 class="modal-title">Examen de la Candidature -
                    <?php echo htmlspecialchars($etudiantData['nom_etu'] . ' ' . $etudiantData['prenom_etu']); ?></h2>

                <div class="step-indicator">
                    <div class="step <?php echo isset($_SESSION['etapes_validation'][$examiner][1]) ? $_SESSION['etapes_validation'][$examiner][1] : ($etape == 1 ? 'active' : ''); ?>"
                        id="stepScolarite">
                        <div class="step-icon">
                            <i class="fas fa-money-check"></i>
                        </div>
                        <div class="step-label">Scolarité</div>
                    </div>
                    <div class="step <?php echo isset($_SESSION['etapes_validation'][$examiner][2]) ? $_SESSION['etapes_validation'][$examiner][2] : ($etape == 2 ? 'active' : ''); ?>"
                        id="stepStage">
                        <div class="step-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="step-label">Stage</div>
                    </div>
                    <div class="step <?php echo isset($_SESSION['etapes_validation'][$examiner][3]) ? $_SESSION['etapes_validation'][$examiner][3] : ($etape == 3 ? 'active' : ''); ?>"
                        id="stepSemestre">
                        <div class="step-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="step-label">Semestre</div>
                    </div>
                    <div class="step <?php echo $etape == 4 ? 'active' : ''; ?>" id="stepResume">
                        <div class="step-icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <div class="step-label">Résumé</div>
                    </div>
                </div>

                <?php if ($etapeData): ?>
                <div class="step-content active">
                    <div class="info-section">
                        <?php if ($etape == 4): ?>
                        <!-- Résumé final -->
                        <h3>Résumé de l'évaluation</h3>
                        <div class="resume-final">
                            <?php 
                            $decision = 'Validée';
                            $rejets = 0;
                            foreach ($etapeData as $key => $data) {
                                if ($data['validation'] === 'rejeté') {
                                    $rejets++;
                                    $decision = 'Rejetée';
                                }
                            }
                            ?>
                            <div class="decision-finale <?php echo $decision === 'Validée' ? 'validee' : 'rejetee'; ?>">
                                <h4>Décision finale : <?php echo $decision; ?></h4>
                                <?php if ($decision === 'Validée'): ?>
                                <p>🎉 Félicitations ! Votre candidature a été validée. Vous pouvez procéder à votre
                                    soutenance.</p>
                                <?php else: ?>
                                <p>❌ Votre candidature a été rejetée. Veuillez corriger les problèmes identifiés
                                    ci-dessous.</p>
                                <?php endif; ?>
                            </div>

                            <div class="resume-etapes">
                                <h4>Détail par étape :</h4>

                                <!-- Scolarité -->
                                <div
                                    class="etape-resume <?php echo $etapeData['scolarite']['validation']; ?> flex gap-2 items-center">
                                    <div class="etape-details flex gap-2 items-center">
                                        <h5><i class="fas fa-money-check"></i> Scolarité</h5>
                                        <p><strong>Validation :</strong>
                                            <span class="badge <?php echo $etapeData['scolarite']['validation']; ?>">
                                                <?php echo strtoupper($etapeData['scolarite']['validation']); ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <!-- Stage -->
                                <div
                                    class="etape-resume <?php echo $etapeData['stage']['validation']; ?> flex gap-2 items-center">
                                    <div class="etape-details flex gap-2 items-center mb-2">
                                        <h5><i class="fas fa-briefcase"></i> Stage</h5>
                                        <p><strong>Validation :</strong>
                                            <span class="badge <?php echo $etapeData['stage']['validation']; ?>">
                                                <?php echo strtoupper($etapeData['stage']['validation']); ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <!-- Semestre -->
                                <div
                                    class="etape-resume <?php echo $etapeData['semestre']['validation']; ?> flex gap-2 items-center">

                                    <div class="etape-details flex gap-2 items-center mb-2">
                                        <h5><i class="fas fa-graduation-cap"></i> Semestre</h5>
                                        <p><strong>Validation :</strong>
                                            <span class="badge <?php echo $etapeData['semestre']['validation']; ?>">
                                                <?php echo strtoupper($etapeData['semestre']['validation']); ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <?php if (isset($_GET['email_envoye']) && $_GET['email_envoye'] == '1'): ?>
                            <div class="email-notification"
                                style="background-color: #D1FAE5; border: 1px solid var(--success); color: #065F46;">
                                <p><i class="fas fa-check-circle"></i> <strong>Email envoyé avec succès !</strong> Les
                                    résultats ont été envoyés à l'étudiant.</p>
                            </div>
                            <?php else: ?>
                            <div class="email-notification"
                                style="background-color: #EFF6FF; border: 1px solid #3B82F6; color: #1E40AF;">
                                <p><i class="fas fa-envelope"></i> Cliquez sur "Envoyer les résultats" pour notifier
                                    l'étudiant de la décision finale.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php else: ?>
                        <!-- Contenu normal des étapes -->
                        <h3>
                            <?php 
                        switch($etape) {
                            case 1: echo 'Vérification de la scolarité'; break;
                            case 2: echo 'Vérification du stage'; break;
                            case 3: echo 'Vérification du semestre'; break;
                        }
                        ?>
                        </h3>

                        <?php if ($etape == 1): ?>
                        <div class="info-item">
                            <strong>Statut des paiements:</strong>
                            <span><?php echo htmlspecialchars($etapeData['status']); ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Montant total:</strong>
                            <span><?php echo htmlspecialchars($etapeData['montant']); ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Montant payé:</strong>
                            <span><?php echo htmlspecialchars($etapeData['montant_paye']); ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Dernier paiement:</strong>
                            <span><?php echo htmlspecialchars($etapeData['dernierPaiement']); ?></span>
                        </div>
                        <?php elseif ($etape == 2): ?>
                        <div class="info-item">
                            <strong>Entreprise :</strong>
                            <span><?php echo htmlspecialchars($etapeData['entreprise']); ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Sujet :</strong>
                            <span><?php echo htmlspecialchars($etapeData['sujet']); ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Période :</strong>
                            <span><?php echo htmlspecialchars($etapeData['periode']); ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Encadrant :</strong>
                            <span><?php echo htmlspecialchars($etapeData['encadrant']); ?></span>
                        </div>
                        <?php elseif ($etape == 3): ?>
                        <div class="info-item">
                            <strong>Semestre actuel:</strong>
                            <span><?php echo htmlspecialchars($etapeData['semestre']); ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Moyenne générale:</strong>
                            <span><?php echo htmlspecialchars($etapeData['moyenne']); ?></span>
                        </div>
                        <div class="info-item">
                            <strong>Unités validées:</strong>
                            <span><?php echo htmlspecialchars($etapeData['unites']); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="modal-footer">
                    <div class="left-buttons">
                        <?php if ($etape > 1 && $etape < 4): ?>
                        <a href="?page=gestion_candidatures_soutenance&examiner=<?php echo $examiner; ?>&etape=<?php echo $etape - 1; ?>"
                            class="btn btn-secondary">
                            Précédent
                        </a>
                        <?php endif; ?>

                        <?php if ($etape < 4): ?>
                        <a href="?page=gestion_candidatures_soutenance&examiner=<?php echo $examiner; ?>&etape=<?php echo $etape + 1; ?>"
                            class="btn btn-primary">
                            Suivant
                        </a>
                        <?php endif; ?>
                    </div>
                    <div class="right-buttons">
                        <?php if ($etape < 4): ?>
                        <form method="post"
                            action="?page=gestion_candidatures_soutenance&action=rejeter_etape&examiner=<?php echo $examiner; ?>&etape=<?php echo $etape; ?>"
                            style="display: inline;">
                            <input type="hidden" name="etape" value="<?php echo $etape; ?>">
                            <button type="submit" class="btn-reject">Rejeter</button>
                        </form>
                        <form method="post"
                            action="?page=gestion_candidatures_soutenance&action=valider_etape&examiner=<?php echo $examiner; ?>&etape=<?php echo $etape; ?>"
                            style="display: inline;">
                            <input type="hidden" name="etape" value="<?php echo $etape; ?>">
                            <button type="submit" class="btn-validate">
                                <?php echo $etape == 3 ? 'Terminer l\'évaluation' : 'Valider'; ?>
                            </button>
                        </form>
                        <?php elseif ($etape == 4): ?>
                        <form method="post"
                            action="?page=gestion_candidatures_soutenance&action=envoyer_resultats&examiner=<?php echo $examiner; ?>"
                            style="display: inline;">
                            <button type="submit" class="btn-validate" style="background-color: #059669;">
                                <i class="fas fa-envelope"></i> Envoyer les résultats
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
    // Fonction de recherche
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const items = document.querySelectorAll('.candidate-item');

        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
    </script>
</body>

</html>