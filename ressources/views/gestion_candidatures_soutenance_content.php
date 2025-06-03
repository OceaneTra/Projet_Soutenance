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
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
        color: white;
    }

    .status-badge.validated {
        background-color: var(--success);
    }

    .status-badge.rejected {
        background-color: var(--danger);
    }

    .status-badge.pending {
        background-color: var(--gray);
    }
    </style>
</head>

<body>
    <div class="container">

        <div class="main-content">
            <div class="filters">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Rechercher un étudiant...">
                </div>
                <select>
                    <option value="pending">Candidatures en attente</option>
                    <option value="all">Toutes les candidatures</option>
                    <option value="validated">Validées</option>
                    <option value="rejected">Rejetées</option>
                </select>
            </div>

            <div class="candidate-list" id="candidateList">
                <!-- Les candidatures seront chargées ici par JavaScript ou PHP -->

                <!-- Exemple de candidature en attente (à remplacer par des données dynamiques) -->
                <div class="candidate-item" data-name="Jean Dupont" data-program="Master 2 Informatique"
                    data-scolarite="true" data-annee="true" data-master2="true" data-stage="false">
                    <div class="candidate-info">
                        <h3>Jean Dupont</h3>
                        <p>Master 2 Informatique - Promotion 2024</p>
                    </div>
                    <button class="btn-examine">Examiner la demande</button>
                </div>

                <!-- Autre exemple (à remplacer par des données dynamiques) -->
                <div class="candidate-item" data-name="Marie Martin" data-program="Master 2 Informatique"
                    data-scolarite="true" data-annee="false" data-master2="true" data-stage="false">
                    <div class="candidate-info">
                        <h3>Marie Martin</h3>
                        <p>Master 2 Informatique - Promotion 2024</p>
                    </div>
                    <button class="btn-examine">Examiner la demande</button>
                </div>

                <!-- Ajoutez d'autres candidatures ici -->

            </div>
        </div>

        <!-- History Section -->
        <div class="history-section">
            <h2>Historique des Demandes</h2>
            <table class="history-table">
                <thead>
                    <tr>
                        <th>Nom de l'Étudiant</th>
                        <th>Programme</th>
                        <th>Date de Soumission</th>
                        <th>Statut Global</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Exemple de données historiques (à remplacer par des données dynamiques) -->
                    <tr>
                        <td>Pierre Dubois</td>
                        <td>Master 2 Génie Logiciel</td>
                        <td>2023-11-15</td>
                        <td><span class="status-badge validated">Validée</span></td>
                    </tr>
                    <tr>
                        <td>Sophie Lefevre</td>
                        <td>Master 2 Cybersécurité</td>
                        <td>2023-10-20</td>
                        <td><span class="status-badge rejected">Rejetée</span></td>
                    </tr>
                    <tr>
                        <td>Ahmed Khan</td>
                        <td>Master 2 Data Science</td>
                        <td>2023-12-01</td>
                        <td><span class="status-badge validated">Validée</span></td>
                    </tr>
                    <!-- Ajoutez d'autres lignes historiques ici -->
                </tbody>
            </table>
        </div>

    </div>

    <!-- The Modal -->
    <div id="examinationModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2 class="modal-title">Examen de la Candidature</h2>

            <div class="step-indicator" id="stepIndicator">
                <div class="step" id="step-scolarite" data-step="0">
                    <div class="step-icon"><i class="fas fa-graduation-cap"></i></div>
                    <div class="step-label">Scolarité</div>
                </div>
                <div class="step" id="step-annee" data-step="1">
                    <div class="step-icon"><i class="fas fa-check"></i></div>
                    <div class="step-label">Validation Année</div>
                </div>
                <div class="step" id="step-master2" data-step="2">
                    <div class="step-icon"><i class="fas fa-user-graduate"></i></div>
                    <div class="step-label">Niveau M2</div>
                </div>
                <div class="step" id="step-stage" data-step="3">
                    <div class="step-icon"><i class="fas fa-briefcase"></i></div>
                    <div class="step-label">Stage 6 mois</div>
                </div>
            </div>

            <div class="modal-body">

                <!-- Student Info (always visible) -->
                <div id="student-info" class="info-section">
                    <h3>Informations Étudiant</h3>
                    <div class="info-item"><strong>Nom Complet:</strong> <span id="student-name"></span></div>
                    <div class="info-item"><strong>Programme:</strong> <span id="student-program"></span></div>
                    <!-- Ajoutez d'autres informations étudiant ici si nécessaire -->
                </div>

                <!-- Step-specific Content -->
                <div id="content-scolarite" class="step-content active">
                    <div class="info-section">
                        <h3>Vérification Scolarité</h3>
                        <p>Statut de la scolarité: <span id="status-scolarite" class="verification-status"></span></p>
                        <!-- Ajoutez ici des détails spécifiques ou des champs pour la vérification de la scolarité -->
                        <!-- Exemple: Afficher un lien vers le dossier de scolarité ou un champ pour noter -->
                        <div class="info-item"><strong>Dernier paiement:</strong> <span>Non disponible (à
                                intégrer)</span></div>
                        <div class="info-item"><strong>Statut administratif:</strong> <span>En règle (à intégrer)</span>
                        </div>
                        <!-- Ajoutez des boutons Valider/Rejeter pour cette étape spécifique si besoin -->
                        <!-- <button class="btn-validate">Valider cette étape</button> <button class="btn-reject">Rejeter cette étape</button> -->
                    </div>
                </div>

                <div id="content-annee" class="step-content">
                    <div class="info-section">
                        <h3>Vérification Validation Année</h3>
                        <p>Validation de l'année: <span id="status-annee" class="verification-status"></span></p>
                        <!-- Ajoutez ici des détails spécifiques ou des champs pour la vérification de l'année -->
                        <!-- Exemple: Afficher les résultats académiques ou un lien vers le relevé de notes -->
                        <div class="info-item"><strong>Moyenne annuelle:</strong> <span>Non disponible (à
                                intégrer)</span></div>
                        <div class="info-item"><strong>Crédits ECTS validés:</strong> <span>Non disponible (à
                                intégrer)</span></div>
                        <!-- Ajoutez des boutons Valider/Rejeter pour cette étape spécifique si besoin -->
                    </div>
                </div>

                <div id="content-master2" class="step-content">
                    <div class="info-section">
                        <h3>Vérification Niveau Master 2</h3>
                        <p>Niveau Master 2: <span id="status-master2" class="verification-status"></span></p>
                        <!-- Ajoutez ici des détails spécifiques ou des champs pour la vérification du niveau -->
                        <div class="info-item"><strong>Inscription en M2:</strong> <span>Confirmée (à intégrer)</span>
                        </div>
                        <!-- Ajoutez des boutons Valider/Rejeter pour cette étape spécifique si besoin -->
                    </div>
                </div>

                <div id="content-stage" class="step-content">
                    <div class="info-section">
                        <h3>Vérification Stage 6 mois</h3>
                        <p>Stage 6 mois effectué: <span id="status-stage" class="verification-status"></span></p>
                        <!-- Ajoutez ici des détails spécifiques ou des champs pour la vérification du stage -->
                        <div class="info-item"><strong>Convention de stage:</strong> <span>Reçue (à intégrer)</span>
                        </div>
                        <div class="info-item"><strong>Dates du stage:</strong> <span>Non disponible (à intégrer)</span>
                        </div>
                        <div class="info-item"><strong>Rapport de stage:</strong> <span>Reçu (à intégrer)</span></div>
                        <!-- Ajoutez des boutons Valider/Rejeter pour cette étape spécifique si besoin -->
                    </div>
                </div>

            </div> <!-- End modal-body -->

            <div class="modal-footer">
                <div class="left-buttons">
                    <button class="btn btn-primary" id="prevStepButton" disabled><i
                            class="fas fa-arrow-left mr-2"></i>Précédent</button>
                    <button class="btn btn-primary" id="nextStepButton">Suivant<i
                            class="fas fa-arrow-right ml-2"></i></button>
                </div>
                <button class="btn-secondary" id="closeModalButton">Fermer</button>
                <!-- Boutons Valider/Rejeter candidature globale ici si besoin -->
                <!-- <button class="btn-validate"><i class="fas fa-check mr-2"></i>Valider Candidature Globale</button>
                 <button class="btn-reject"><i class="fas fa-times mr-2"></i>Rejeter Candidature Globale</button> -->
            </div>
        </div>
    </div>

    <script>
    // Get the modal elements
    var modal = document.getElementById("examinationModal");
    var closeModalButton = document.getElementById("closeModalButton");
    var closeSpan = document.getElementsByClassName("close-button")[0];
    var prevStepButton = document.getElementById("prevStepButton");
    var nextStepButton = document.getElementById("nextStepButton");
    var steps = document.querySelectorAll('.step-indicator .step');
    var stepContents = document.querySelectorAll('.modal-body .step-content');

    let currentStepIndex = 0;
    const stepNames = ['scolarite', 'annee', 'master2', 'stage'];

    // Function to update the modal based on the current step
    function updateModalDisplay() {
        // Update step indicator appearance
        steps.forEach((step, index) => {
            step.classList.remove('active');
            if (index === currentStepIndex) {
                step.classList.add('active');
            }
            // 'completed' or 'rejected' classes are handled by updateVerificationStatus
        });

        // Update step content visibility
        stepContents.forEach((content, index) => {
            content.classList.remove('active');
            if (index === currentStepIndex) {
                content.classList.add('active');
            }
        });

        // Update button states
        prevStepButton.disabled = currentStepIndex === 0;
        nextStepButton.disabled = currentStepIndex === steps.length - 1;

        // Update the step indicator color line based on completed steps
        // This is handled by CSS based on the .completed class, no JS needed here
    }



    // Function to open the modal
    function openModal(candidateData) {
        console.log("Opening modal for:", candidateData);
        document.getElementById('student-name').textContent = candidateData.name;
        document.getElementById('student-program').textContent = candidateData.program;

        // Update verification statuses and step indicator based on initial data
        // This should happen BEFORE setting the current step, so the classes are present
        updateVerificationStatus('scolarite', candidateData.scolarite);
        updateVerificationStatus('annee', candidateData.annee);
        updateVerificationStatus('master2', candidateData.master2);
        updateVerificationStatus('stage', candidateData.stage);

        currentStepIndex = 0; // Start at the first step
        updateModalDisplay(); // Now display the first step

        modal.style.display = "flex"; // Use flex to center the modal
    }

    // Function to close the modal
    function closeModal() {
        modal.style.display = "none";
    }

    // Event listeners for closing the modal
    closeModalButton.addEventListener('click', closeModal);
    closeSpan.addEventListener('click', closeModal);

    // When the user clicks anywhere outside of the modal, close it
    window.addEventListener('click', function(event) {
        if (event.target == modal) {
            closeModal();
        }
    });

    // Event listeners for navigation buttons
    prevStepButton.addEventListener('click', function() {
        if (currentStepIndex > 0) {
            currentStepIndex--;
            updateModalDisplay();
        }
    });

    nextStepButton.addEventListener('click', function() {
        if (currentStepIndex < steps.length - 1) {
            currentStepIndex++;
            updateModalDisplay();
        }
    });


    function updateVerificationStatus(stepName, status) {
        const statusElement = document.getElementById(`status-${stepName}`);
        const stepElement = document.getElementById(`step-${stepName}`);

        // Reset classes and content for status
        stepElement.classList.remove('completed', 'rejected');
        statusElement.innerHTML = '';

        if (status === true) {
            statusElement.innerHTML = '<i class="fas fa-check-circle"></i> Vérifié';
            stepElement.classList.add('completed');
        } else if (status === false) {
            statusElement.innerHTML = '<i class="fas fa-times-circle"></i> Non vérifié';
            stepElement.classList.add('rejected');
        } else {
            statusElement.innerHTML = '<i class="fas fa-clock"></i> En attente';
            // Active class is handled by updateModalDisplay
        }
        // The active state of the step indicator is managed by updateModalDisplay
        // based on the currentStepIndex.
    }

    // Event listeners for 'Examiner la demande' buttons
    document.addEventListener('DOMContentLoaded', function() {
        const examineButtons = document.querySelectorAll('.btn-examine');
        examineButtons.forEach(button => {
            button.addEventListener('click', function() {
                const item = this.closest('.candidate-item');
                // Extract data attributes. Convert string 'true'/'false' to boolean
                const candidateData = {
                    name: item.getAttribute('data-name'),
                    program: item.getAttribute('data-program'),
                    scolarite: item.getAttribute('data-scolarite') === 'true',
                    annee: item.getAttribute('data-annee') === 'true',
                    master2: item.getAttribute('data-master2') === 'true',
                    stage: item.getAttribute('data-stage') === 'true'
                };
                openModal(candidateData);
            });
        });

        // Basic filtering (can be expanded)
        const searchInput = document.querySelector('.filters input[type="text"]');
        const statusSelect = document.querySelector('.filters select');
        const candidateItems = document.querySelectorAll('.candidate-item'); // Get all items initially

        function filterCandidates() {
            const search = searchInput.value.toLowerCase();
            const status = statusSelect.value;

            candidateItems.forEach(item => {
                const name = item.querySelector('.candidate-info h3').textContent.toLowerCase();
                // Basic filtering by name for now
                const matchesSearch = name.includes(search);

                // TODO: Implement status filtering logic here based on how status is stored/indicated in list item
                // const matchesStatus = (status === 'pending' && itemIsPending(item)) || ...
                // For now, only filter by search.

                if (matchesSearch /* && matchesStatus */ ) {
                    item.style.display = 'flex';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterCandidates);
        // statusSelect.addEventListener('change', filterCandidates); // Uncomment and implement logic
    });
    </script>
</body>

</html>