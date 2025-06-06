<?php

$candidatures = $GLOBALS['candidatures_soutenance'] ?? [];


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
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        position: relative;
        display: flex;
        /* Use flex for internal layout */
        flex-direction: column;
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
        overflow-y: auto;
        /* Enable scrolling if content overflows */
        max-height: 400px;
        /* Limit height for scrolling */
        padding-right: 15px;
        /* Add padding for scrollbar */
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

    .modal-footer .right-button {
        /* For the Close button */
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
    </style>
</head>

<body>
    <div class="container">
        <div class="main-content">
            <h1 class="text-2xl font-bold mb-6">Gestion des Candidatures de Soutenance</h1>

            <!-- Filtres -->
            <div class="filters">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Rechercher un étudiant...">
                </div>
                <select id="statusFilter">
                    <option value="all">Tous les statuts</option>
                    <option value="en_attente">En attente</option>
                    <option value="validee">Validée</option>
                    <option value="rejetee">Rejetée</option>
                </select>
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
                    <button onclick="examinerCandidature('<?php echo $candidature['num_etu']; ?>')" class="btn-examine">
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
    <div id="examinationModal" class="modal">
        <div class="modal-content">
            <button type="button" class="close-button" onclick="closeModal()">&times;</button>
            <h2 class="modal-title">Examen de la Candidature</h2>

            <div class="step-indicator">
                <div class="step" id="stepInscription">
                    <div class="step-icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div class="step-label">Inscription</div>
                </div>
                <div class="step" id="stepScolarite">
                    <div class="step-icon">
                        <i class="fas fa-money-check"></i>
                    </div>
                    <div class="step-label">Scolarité</div>
                </div>
                <div class="step" id="stepSemestre">
                    <div class="step-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="step-label">Semestre</div>
                </div>
            </div>

            <div class="step-content" id="stepInscriptionContent">
                <div class="info-section">
                    <h3>Vérification de l'inscription</h3>
                    <div class="info-item">
                        <strong>Statut d'inscription:</strong>
                        <span id="inscriptionStatus"></span>
                    </div>
                    <div class="info-item">
                        <strong>Date d'inscription:</strong>
                        <span id="inscriptionDate"></span>
                    </div>
                    <div class="info-item">
                        <strong>Filière:</strong>
                        <span id="inscriptionFiliere"></span>
                    </div>
                </div>
            </div>

            <div class="step-content" id="stepScolariteContent">
                <div class="info-section">
                    <h3>Vérification de la scolarité</h3>
                    <div class="info-item">
                        <strong>Statut des paiements:</strong>
                        <span id="scolariteStatus"></span>
                    </div>
                    <div class="info-item">
                        <strong>Montant total:</strong>
                        <span id="scolariteMontant"></span>
                    </div>
                    <div class="info-item">
                        <strong>Dernier paiement:</strong>
                        <span id="scolariteDernierPaiement"></span>
                    </div>
                </div>
            </div>

            <div class="step-content" id="stepSemestreContent">
                <div class="info-section">
                    <h3>Vérification du semestre</h3>
                    <div class="info-item">
                        <strong>Semestre actuel:</strong>
                        <span id="semestreActuel"></span>
                    </div>
                    <div class="info-item">
                        <strong>Moyenne générale:</strong>
                        <span id="semestreMoyenne"></span>
                    </div>
                    <div class="info-item">
                        <strong>Unités validées:</strong>
                        <span id="semestreUnites"></span>
                    </div>
                </div>
            </div>

            <div class="step-content" id="stepResumeContent">
                <div class="info-section">
                    <h3>Résumé de l'examen</h3>
                    <div id="resumeContent"></div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="left-buttons">
                    <button id="btnPrevious" class="btn btn-secondary" onclick="previousStep()" style="display: none;">
                        Précédent
                    </button>
                    <button id="btnNext" class="btn btn-primary" onclick="nextStep()">
                        Suivant
                    </button>
                </div>
                <div class="right-buttons">
                    <button id="btnReject" class="btn-reject" onclick="rejectStep()">
                        Rejeter
                    </button>
                    <button id="btnValidate" class="btn-validate" onclick="validateStep()">
                        Valider
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    let currentNumEtu = null;
    let currentStep = 1;
    let totalSteps = 3;
    let stepResults = {
        inscription: {
            status: null,
            comment: ''
        },
        scolarite: {
            status: null,
            comment: ''
        },
        semestre: {
            status: null,
            comment: ''
        }
    };

    function examinerCandidature(numEtu) {
        currentNumEtu = numEtu;
        currentStep = 1;
        document.getElementById('examinationModal').style.display = 'flex';
        showStep(currentStep);
        loadStepData(currentStep);
    }

    function showStep(step) {
        document.querySelectorAll('.step-content').forEach(content => {
            content.style.display = 'none';
        });
        document.getElementById(`step${getStepName(step)}Content`).style.display = 'block';

        document.getElementById('btnPrevious').style.display = step > 1 ? 'block' : 'none';
        document.getElementById('btnNext').style.display = step < totalSteps ? 'block' : 'none';

        document.querySelectorAll('.step').forEach((s, index) => {
            s.classList.remove('active');
            if (index + 1 === step) {
                s.classList.add('active');
            }
        });
    }

    function getStepName(step) {
        const steps = ['Inscription', 'Scolarite', 'Semestre'];
        return steps[step - 1];
    }

    function loadStepData(step) {
        fetch(`?page=gestion_candidatures&action=verifier_etape&num_etu=${currentNumEtu}&etape=${step}`)
            .then(response => response.json())
            .then(data => {
                updateStepContent(step, data);
            });
    }

    function updateStepContent(step, data) {
        const stepName = getStepName(step).toLowerCase();
        switch (step) {
            case 1:
                document.getElementById('inscriptionStatus').textContent = data.status;
                document.getElementById('inscriptionDate').textContent = data.date;
                document.getElementById('inscriptionFiliere').textContent = data.filiere;
                break;
            case 2:
                document.getElementById('scolariteStatus').textContent = data.status;
                document.getElementById('scolariteMontant').textContent = data.montant;
                document.getElementById('scolariteDernierPaiement').textContent = data.dernierPaiement;
                break;
            case 3:
                document.getElementById('semestreActuel').textContent = data.semestre;
                document.getElementById('semestreMoyenne').textContent = data.moyenne;
                document.getElementById('semestreUnites').textContent = data.unites;
                break;
        }
    }

    function previousStep() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    }

    function nextStep() {
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
            loadStepData(currentStep);
        }
    }

    function validateStep() {
        const stepName = getStepName(currentStep).toLowerCase();
        stepResults[stepName] = {
            status: 'validé',
            comment: 'Étape validée avec succès'
        };

        if (currentStep === totalSteps) {
            showResume();
        } else {
            nextStep();
        }
    }

    function rejectStep() {
        const stepName = getStepName(currentStep).toLowerCase();
        stepResults[stepName] = {
            status: 'rejeté',
            comment: 'Étape rejetée'
        };
        showResume();
    }

    function showResume() {
        const resumeContent = document.getElementById('resumeContent');
        let html = '<div class="resume-section">';

        for (const [step, result] of Object.entries(stepResults)) {
            html += `
                <div class="resume-item">
                    <h4>${step.charAt(0).toUpperCase() + step.slice(1)}</h4>
                    <p>Statut: <span class="status-badge ${result.status}">${result.status}</span></p>
                    <p>Commentaire: ${result.comment}</p>
                </div>
            `;
        }

        html += '</div>';
        resumeContent.innerHTML = html;

        document.querySelectorAll('.step-content').forEach(content => {
            content.style.display = 'none';
        });
        document.getElementById('stepResumeContent').style.display = 'block';

        document.getElementById('btnPrevious').style.display = 'none';
        document.getElementById('btnNext').style.display = 'none';
        document.getElementById('btnReject').style.display = 'none';
        document.getElementById('btnValidate').style.display = 'none';

        const footer = document.querySelector('.modal-footer');
        footer.innerHTML = `
            <button class="btn btn-primary" onclick="envoyerResultat()">
                Envoyer le résultat
            </button>
        `;
    }

    function envoyerResultat() {
        fetch(`?page=gestion_candidatures&action=envoyer_resultat&num_etu=${currentNumEtu}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(stepResults)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Le résultat a été envoyé avec succès à l\'étudiant.');
                    closeModal();
                    window.location.reload();
                } else {
                    alert('Une erreur est survenue lors de l\'envoi du résultat.');
                }
            });
    }

    function closeModal() {
        const modal = document.getElementById('examinationModal');
        modal.style.display = 'none';
        currentNumEtu = null;
        currentStep = 1;
        stepResults = {
            inscription: {
                status: null,
                comment: ''
            },
            scolarite: {
                status: null,
                comment: ''
            },
            semestre: {
                status: null,
                comment: ''
            }
        };
    }

    // Fermer la modale si on clique en dehors
    window.onclick = function(event) {
        const modal = document.getElementById('examinationModal');
        if (event.target === modal) {
            closeModal();
        }
    }

    // Ajouter un gestionnaire d'événements pour la touche Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });

    // Fonction de recherche
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const items = document.querySelectorAll('.candidate-item');

        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Fonction de filtrage par statut
    document.getElementById('statusFilter').addEventListener('change', function(e) {
        const status = e.target.value;
        const items = document.querySelectorAll('.candidate-item');

        items.forEach(item => {
            if (status === 'all' || item.dataset.status === status) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // Fonction pour charger l'historique
    function chargerHistorique() {
        fetch('?page=gestion_candidatures&action=historique')
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('historiqueTableBody');
                tbody.innerHTML = data.map(item => `
                    <tr>
                        <td>${item.nom_etu} ${item.prenom_etu}</td>
                        <td>
                            <span class="action-badge action-${item.action}">
                                ${item.action}
                            </span>
                        </td>
                        <td>${item.commentaire || '-'}</td>
                        <td>${new Date(item.date_action).toLocaleString()}</td>
                    </tr>
                `).join('');
            });
    }

    // Charger l'historique au chargement de la page
    document.addEventListener('DOMContentLoaded', chargerHistorique);
    </script>
</body>

</html>