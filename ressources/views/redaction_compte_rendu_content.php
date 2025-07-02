<?php
$rapports_valides = $GLOBALS['rapports_valides'] ?? [];
$notifType = '';
$notifMsg = '';
if (!empty($_SESSION['success'])) {
    $notifType = 'success';
    $notifMsg = $_SESSION['success'];
    unset($_SESSION['success']);
} elseif (!empty($_SESSION['error'])) {
    $notifType = 'error';
    $notifMsg = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rédaction des Comptes Rendus | Mr. Diarra</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar-hover:hover {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
        }
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .editor-toolbar {
            border-bottom: 1px solid #e5e7eb;
        }
        .editor-button {
            transition: all 0.2s ease;
        }
        .editor-button:hover {
            background-color: #f3f4f6;
            transform: scale(1.05);
        }
        .editor-content {
            min-height: 400px;
            font-family: 'Times New Roman', serif;
        }
        .template-section {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        }
        .progress-step {
            transition: all 0.3s ease;
        }
        .progress-step.active {
            background-color: #f59e0b;
            color: white;
        }
        .progress-step.completed {
            background-color: #10b981;
            color: white;
        }
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
        }
        .preview-content {
            font-family: 'Times New Roman', serif;
            line-height: 1.6;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Main content area -->
            <div class="flex-1 overflow-y-auto bg-gray-50">
                <div class="max-w-7xl mx-auto p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Left column - Report selection and info -->
                        <div class="space-y-6">
                            <!-- Report Selection -->
                            <div class="bg-white rounded-lg shadow p-6 fade-in">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                    <i class="fas fa-file-alt text-blue-600 mr-2"></i>
                                    Sélection des rapports
                                </h3>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Ajouter un rapport</label>
                                        <div class="flex items-center space-x-2">
                                            <select id="reportSelect" class="flex-1 p-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500" style="height:36px; width: 100px;">
                                            <option value="">Sélectionner un rapport...</option>
                                                <?php foreach (
                                                    $rapports_valides as $rapport): ?>
                                                    <option value="<?= htmlspecialchars($rapport['id_rapport']) ?>">
                                                        <?= htmlspecialchars($rapport['theme_rapport']) ?> - <?= htmlspecialchars($rapport['prenom_etu'] . ' ' . $rapport['nom_etu']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                        </select>
                                            <button onclick="addReport()"
                                                class="bg-blue-200 text-gray-700 rounded-full hover:bg-gray-300 focus:ring-2 focus:ring-blue-400 flex items-center justify-center"
                                                style="height:28px; width:28px; min-width:28px;">
                                                <i class="fas fa-plus" style="font-size:14px;"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Liste des rapports sélectionnés -->
                                    <div id="selectedReports" class="space-y-2">
                                        <h4 class="text-sm font-medium text-gray-700 mt-4">Rapports sélectionnés :</h4>
                                        <div id="reportsList" class="space-y-2">
                                            <!-- Les rapports seront ajoutés ici dynamiquement -->
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Report Info -->
                            <div id="reportInfo" class="bg-white rounded-lg shadow p-6 fade-in">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                    <i class="fas fa-info-circle text-green-600 mr-2"></i>
                                    Informations des rapports
                                </h3>
                                <div id="reportDetails" class="space-y-4">
                                    <!-- Content will be loaded dynamically -->
                                </div>
                            </div>

                            <!-- Evaluations Summary -->
                            <div id="evaluationsSummary" class="bg-white rounded-lg shadow p-6 fade-in hidden">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                    <i class="fas fa-users text-purple-600 mr-2"></i>
                                    Résumé des évaluations
                                </h3>
                                <div id="evaluationsContent" class="space-y-3">
                                    <!-- Content will be loaded dynamically -->
                                </div>
                            </div>

                            <!-- Templates -->
                            <div class="template-section p-6 rounded-lg shadow mb-8 text-center">
                                <button onclick="loadTemplate('validation_seance')" class="px-6 py-3 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 transition-colors font-semibold text-lg">
                                    <i class="fas fa-file-import mr-2"></i>Charger le modèle
                                    </button>
                            </div>
                        </div>

                        <!-- Right column - Editor -->
                        <div class="lg:col-span-2">
                            <div class="bg-white rounded-lg shadow overflow-hidden fade-in">
                                <!-- Editor Header -->
                                <div class="editor-toolbar px-6 py-3 bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-lg font-semibold text-gray-800">
                                            <i class="fas fa-edit text-yellow-600 mr-2"></i>
                                            Éditeur de compte rendu
                                        </h3>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-sm text-gray-600">Dernière sauvegarde: </span>
                                            <span id="lastSave" class="text-sm text-green-600">--:--</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Toolbar -->
                                <div class="editor-toolbar px-6 py-3 bg-white">
                                    <div class="flex items-center space-x-2">
                                        <button onclick="formatText('bold')" class="editor-button p-2 rounded hover:bg-gray-100" title="Gras">
                                            <i class="fas fa-bold"></i>
                                        </button>
                                        <button onclick="formatText('italic')" class="editor-button p-2 rounded hover:bg-gray-100" title="Italique">
                                            <i class="fas fa-italic"></i>
                                        </button>
                                        <button onclick="formatText('underline')" class="editor-button p-2 rounded hover:bg-gray-100" title="Souligné">
                                            <i class="fas fa-underline"></i>
                                        </button>
                                        <div class="w-px h-6 bg-gray-300 mx-2"></div>
                                        <button onclick="insertList('ul')" class="editor-button p-2 rounded hover:bg-gray-100" title="Liste à puces">
                                            <i class="fas fa-list-ul"></i>
                                        </button>
                                        <button onclick="insertList('ol')" class="editor-button p-2 rounded hover:bg-gray-100" title="Liste numérotée">
                                            <i class="fas fa-list-ol"></i>
                                        </button>
                                        <div class="w-px h-6 bg-gray-300 mx-2"></div>
                                    </div>
                                </div>

                                <!-- Editor Content -->
                                <div class="p-6">
                                    <div id="editorContent" class="editor-content w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500" contenteditable="true" style="min-height: 500px;">
                                        <div class="text-center mb-8">
                                            <h1 class="text-3xl font-bold mb-3 text-gray-800">COMPTE RENDU D'ÉVALUATION</h1>
                                            <h2 class="text-xl font-semibold text-gray-700 mb-2">Commission de Validation des Rapports de Soutenance</h2>
                                            <p class="text-gray-600 text-lg">Université Félix Houphouët-Boigny</p>
                                            <p class="text-gray-600">Institut de Formation et de Recherche en Informatique</p>
                                            <p class="text-gray-600">Département MIAGE</p>
                                        </div>

                                        <div class="mb-8">
                                            <h3 class="text-xl font-bold border-b-2 border-gray-400 pb-3 mb-4 text-gray-800">I. INFORMATIONS GÉNÉRALES</h3>
                                            <div class="mb-4">
                                                <p><strong class="text-gray-700">Nombre de rapports évalués :</strong><br><span class="text-gray-600">[À compléter]</span></p>
                                                    <p><strong class="text-gray-700">Date d'évaluation :</strong><br><span class="text-gray-600">[À compléter]</span></p>
                                                <p><strong class="text-gray-700">Membres de la commission d'évaluation :</strong><br><span class="text-gray-600">[À compléter]</span></p>
                                                </div>
                                            
                                            <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-500">
                                                <h4 class="font-semibold text-gray-700 mb-2">Rapports évalués :</h4>
                                                <div class="text-gray-600">
                                                    [À compléter]
                                            </div>
                                            </div>
                                        </div>

                                        <div class="mb-8">
                                            <h3 class="text-xl font-bold border-b-2 border-gray-400 pb-3 mb-4 text-gray-800">II. PRÉSENTATION DES TRAVAUX</h3>
                                            <div class="mb-4">
                                                <h4 class="text-lg font-semibold mb-2 text-gray-700">2.1 Contexte général</h4>
                                                <p class="text-gray-600 italic">[Présentation du contexte général et des problématiques abordées dans les rapports...]</p>
                                            </div>
                                            <div class="mb-4">
                                                <h4 class="text-lg font-semibold mb-2 text-gray-700">2.2 Objectifs et méthodologies</h4>
                                                <p class="text-gray-600 italic">[Description des objectifs poursuivis et des méthodologies adoptées dans les différents travaux...]</p>
                                            </div>
                                            <div class="mb-4">
                                                <h4 class="text-lg font-semibold mb-2 text-gray-700">2.3 Résultats obtenus</h4>
                                                <p class="text-gray-600 italic">[Synthèse des principaux résultats obtenus dans l'ensemble des travaux...]</p>
                                            </div>
                                        </div>

                                        <div class="mb-8">
                                            <h3 class="text-xl font-bold border-b-2 border-gray-400 pb-3 mb-4 text-gray-800">III. ÉVALUATIONS PAR RAPPORT</h3>
                                            <p class="text-gray-600 italic mb-4">[Les évaluations détaillées de chaque rapport seront automatiquement insérées ici...]</p>
                                            
                                            <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-blue-500">
                                                <h4 class="font-semibold text-gray-700 mb-2">Résumé global des votes :</h4>
                                                <p class="text-sm text-gray-600">Total des votes favorables : [X]/[Total]</p>
                                                <p class="text-sm text-gray-600">Total des votes défavorables : [X]/[Total]</p>
                                                <p class="text-sm text-gray-600">Taux de validation global : [X]%</p>
                                            </div>
                                        </div>

                                        <div class="mb-8">
                                            <h3 class="text-xl font-bold border-b-2 border-gray-400 pb-3 mb-4 text-gray-800">IV. ANALYSE ET SYNTHÈSE GLOBALES</h3>
                                            <div class="mb-4">
                                                <h4 class="text-lg font-semibold mb-2 text-gray-700">4.1 Points forts de l'ensemble des travaux</h4>
                                                <ul class="list-disc list-inside text-gray-600 ml-4">
                                                    <li>[Point fort global 1]</li>
                                                    <li>[Point fort global 2]</li>
                                                    <li>[Point fort global 3]</li>
                                                </ul>
                                            </div>
                                            <div class="mb-4">
                                                <h4 class="text-lg font-semibold mb-2 text-gray-700">4.2 Points à améliorer</h4>
                                                <ul class="list-disc list-inside text-gray-600 ml-4">
                                                    <li>[Point à améliorer global 1]</li>
                                                    <li>[Point à améliorer global 2]</li>
                                                    <li>[Point à améliorer global 3]</li>
                                                </ul>
                                            </div>
                                            <div class="mb-4">
                                                <h4 class="text-lg font-semibold mb-2 text-gray-700">4.3 Recommandations générales</h4>
                                                <p class="text-gray-600 italic">[Recommandations pour l'amélioration de l'ensemble des travaux...]</p>
                                            </div>
                                        </div>

                                        <div class="mb-8">
                                            <h3 class="text-xl font-bold border-b-2 border-gray-400 pb-3 mb-4 text-gray-800">V. DÉCISIONS DE LA COMMISSION</h3>
                                            <div class="bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-500">
                                                <p class="text-lg font-semibold text-gray-800 mb-2">Décisions finales par rapport :</p>
                                                <div class="text-gray-600">
                                                    [Les décisions finales pour chaque rapport seront ajoutées ici]
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <h4 class="text-lg font-semibold mb-2 text-gray-700">Justification des décisions :</h4>
                                                <p class="text-gray-600 italic">[Justification détaillée des décisions prises par la commission pour chaque rapport...]</p>
                                            </div>
                                        </div>

                                        <div class="mt-12 text-center">
                                            <p class="text-gray-600 mb-4">Fait à Abidjan, le [DATE]</p>
                                            <div class="flex justify-center space-x-8">
                                                <div class="text-center">
                                                    <p class="font-semibold text-gray-700">Président de la Commission</p>
                                                    <p class="text-gray-600">[Signature]</p>
                                                </div>
                                                <div class="text-center">
                                                    <p class="font-semibold text-gray-700">Rapporteur</p>
                                                    <p class="text-gray-600">[Signature]</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <button onclick="saveAsDraft()" class="flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                                                <i class="fas fa-save mr-2"></i>Sauvegarder en brouillon
                                            </button>
                                            <button onclick="autoSave()" class="flex items-center px-3 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700">
                                                <i class="fas fa-clock mr-2"></i>Sauvegarde auto
                                            </button>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <button onclick="previewReport()" class="flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
                                                <i class="fas fa-eye mr-2"></i>Aperçu
                                            </button>
                                            <button onclick="finalizeReport()" class="flex items-center px-4 py-2 bg-yellow-600 text-white text-sm font-medium rounded-md hover:bg-yellow-700">
                                                <i class="fas fa-check mr-2"></i>Finaliser
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity modal-overlay" onclick="closePreviewModal()"></div>
            
            <div class="inline-block w-full max-w-4xl p-0 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-eye text-green-600 mr-2"></i>
                        Aperçu du compte rendu
                    </h3>
                    <div class="flex items-center space-x-2">
                        <button onclick="printReport()" class="px-3 py-1 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                            <i class="fas fa-print mr-1"></i>Imprimer
                        </button>
                        <button onclick="exportToPDF()" class="px-3 py-1 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                            <i class="fas fa-file-pdf mr-1"></i>PDF
                        </button>
                        <button onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <div class="px-8 py-6 max-h-96 overflow-y-auto">
                    <div id="previewContent" class="preview-content">
                        <!-- Preview content will be inserted here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="formCR" method="POST" action="?page=redaction_compte_rendu">
        <input type="hidden" name="num_etu" id="num_etu" value="">
        <input type="hidden" name="nom_CR" id="nom_CR" value="">
        <input type="hidden" name="contenu_CR" id="contenu_CR" value="">
        <div class="flex justify-end mt-6">
            <button type="button" onclick="submitCR()" class="px-6 py-3 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition-colors font-semibold text-lg">
                <i class="fas fa-save mr-2"></i>Enregistrer le compte rendu
            </button>
        </div>
    </form>

    <div id="toastNotif" style="display:none; position:fixed; top:30px; right:30px; z-index:9999; min-width:250px;" class="transition-opacity duration-500">
        <div id="toastContent" class="px-4 py-3 rounded shadow-lg flex items-center">
            <span id="toastIcon" class="mr-3"></span>
            <span id="toastMsg"></span>
        </div>
    </div>

    <script>
        // Variables globales
        let currentReportData = null;
        let autoSaveInterval = null;

        // Variables globales pour gérer les rapports
        let selectedReports = [];
        let currentReportIndex = 0;

        // Tableau associatif des rapports pour accès rapide côté JS
        const rapportsData = <?php echo json_encode($rapports_valides); ?>;

        // Pour retrouver un rapport par son id
        function getRapportById(id) {
            return rapportsData.find(r => r.id_rapport == id);
        }

        // Ajouter un rapport à la liste
        function addReport() {
            const select = document.getElementById('reportSelect');
            const id = select.value;
            if (!id) return;
            if (selectedReports.find(r => r.id_rapport == id)) return;
            const rapport = getRapportById(id);
            if (!rapport) return;
            selectedReports.push(rapport);
            // Ajouter à la liste des rapports sélectionnés (affichage)
            const reportsList = document.getElementById('reportsList');
            const div = document.createElement('div');
            div.id = 'rapport-cas-' + id;
            div.className = 'p-2 bg-gray-100 rounded flex items-center justify-between';
            div.innerHTML = `<span><b>Thème :</b> ${rapport.theme_rapport} <br><b>Étudiant :</b> ${rapport.prenom_etu} ${rapport.nom_etu}</span>
                <button onclick="removeReport('${id}')" class="ml-2 text-red-500 hover:text-red-700"><i class='fas fa-times'></i></button>`;
            reportsList.appendChild(div);
            showReportDetails();
            updateEditorWithReportData();
        }

        // Supprimer un rapport de la liste
        function removeReport(id) {
            selectedReports = selectedReports.filter(r => r.id_rapport != id);
            const div = document.getElementById('rapport-cas-' + id);
            if (div) div.remove();
            showReportDetails();
            updateEditorWithReportData();
        }

        // Mettre à jour la liste des rapports
        function updateReportsList() {
            const reportsList = document.getElementById('reportsList');
            const selectedReportsDiv = document.getElementById('selectedReports');
            
            if (selectedReports.length === 0) {
                selectedReportsDiv.classList.add('hidden');
                return;
            }
            
            selectedReportsDiv.classList.remove('hidden');
            reportsList.innerHTML = '';
            
            selectedReports.forEach((report, index) => {
                const reportElement = document.createElement('div');
                reportElement.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-md border border-gray-200';
                reportElement.innerHTML = `
                    <div class="flex items-center space-x-3">
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">${index + 1}</span>
                        <span class="text-sm text-gray-700">${report.text}</span>
                    </div>
                    <button onclick="removeReport('${report.id}')" class="text-red-600 hover:text-red-800">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                reportsList.appendChild(reportElement);
            });
        }

        // Mettre à jour les informations des rapports
        function updateReportInfo() {
            const reportDetails = document.getElementById('reportDetails');
            const evaluationsSummary = document.getElementById('evaluationsSummary');
            
            if (selectedReports.length === 0) {
                reportDetails.innerHTML = '<p class="text-gray-500 text-sm">Aucun rapport sélectionné</p>';
                evaluationsSummary.classList.add('hidden');
                return;
            }

        // Données simulées des rapports
            const reportData = {
            '1': {
                    title: 'IA Diagnostic Médical',
                student: 'Marie Lambert',
                    supervisor: 'Dr. Martin Dubois',
                    date: '15 Janvier 2025',
                    duration: '45 minutes',
                    grade: '16/20',
                    status: 'Validé',
                evaluations: [
                        { evaluator: 'Dr. Kouassi', decision: 'Validé', comment: 'Excellent travail technique' },
                        { evaluator: 'Dr. Koné', decision: 'Validé', comment: 'Méthodologie solide' },
                        { evaluator: 'Pr. Assan', decision: 'Validé', comment: 'Présentation claire' },
                        { evaluator: 'Dr. Bamba', decision: 'Validé', comment: 'Résultats convaincants' }
                ]
            },
            '2': {
                    title: 'Blockchain Sécurité',
                student: 'Jean Dupont',
                    supervisor: 'Prof. Sophie Martin',
                    date: '12 Janvier 2025',
                    duration: '50 minutes',
                    grade: '14/20',
                    status: 'Validé',
                evaluations: [
                        { evaluator: 'Dr. Kouassi', decision: 'Validé', comment: 'Approche innovante' },
                        { evaluator: 'Dr. Koné', decision: 'Validé', comment: 'Bonne analyse' },
                        { evaluator: 'Pr. Assan', decision: 'Rejeté', comment: 'Manque de profondeur' },
                        { evaluator: 'Dr. Bamba', decision: 'Validé', comment: 'Méthodologie correcte' }
                    ]
                },
                '3': {
                    title: 'Réseaux Neurones',
                    student: 'Thomas Moreau',
                    supervisor: 'Dr. Pierre Rousseau',
                    date: '10 Janvier 2025',
                    duration: '40 minutes',
                    grade: '17/20',
                    status: 'Validé',
                    evaluations: [
                        { evaluator: 'Dr. Kouassi', decision: 'Validé', comment: 'Travail remarquable' },
                        { evaluator: 'Dr. Koné', decision: 'Validé', comment: 'Excellente présentation' },
                        { evaluator: 'Pr. Assan', decision: 'Validé', comment: 'Résultats exceptionnels' },
                        { evaluator: 'Dr. Bamba', decision: 'Validé', comment: 'Méthodologie exemplaire' }
                    ]
                },
                '4': {
                    title: 'Machine Learning',
                    student: 'Sophie Martin',
                    supervisor: 'Dr. Claire Dubois',
                    date: '8 Janvier 2025',
                    duration: '42 minutes',
                    grade: '15/20',
                    status: 'Validé',
                    evaluations: [
                        { evaluator: 'Dr. Kouassi', decision: 'Validé', comment: 'Bon travail' },
                        { evaluator: 'Dr. Koné', decision: 'Validé', comment: 'Approche méthodique' },
                        { evaluator: 'Pr. Assan', decision: 'Validé', comment: 'Résultats satisfaisants' },
                        { evaluator: 'Dr. Bamba', decision: 'Validé', comment: 'Présentation claire' }
                    ]
                },
                '5': {
                    title: 'Cybersécurité',
                    student: 'Pierre Dubois',
                    supervisor: 'Prof. Jean Martin',
                    date: '5 Janvier 2025',
                    duration: '38 minutes',
                    grade: '18/20',
                    status: 'Validé',
                    evaluations: [
                        { evaluator: 'Dr. Kouassi', decision: 'Validé', comment: 'Excellente analyse' },
                        { evaluator: 'Dr. Koné', decision: 'Validé', comment: 'Travail approfondi' },
                        { evaluator: 'Pr. Assan', decision: 'Validé', comment: 'Méthodologie rigoureuse' },
                        { evaluator: 'Dr. Bamba', decision: 'Validé', comment: 'Résultats exceptionnels' }
                    ]
                },
                '6': {
                    title: 'Intelligence Artificielle',
                    student: 'Claire Rousseau',
                    supervisor: 'Dr. Thomas Moreau',
                    date: '3 Janvier 2025',
                    duration: '47 minutes',
                    grade: '16/20',
                    status: 'Validé',
                    evaluations: [
                        { evaluator: 'Dr. Kouassi', decision: 'Validé', comment: 'Travail de qualité' },
                        { evaluator: 'Dr. Koné', decision: 'Validé', comment: 'Approche intéressante' },
                        { evaluator: 'Pr. Assan', decision: 'Validé', comment: 'Bonne présentation' },
                        { evaluator: 'Dr. Bamba', decision: 'Validé', comment: 'Résultats convaincants' }
                    ]
                }
            };
            
            let html = '';
            let allEvaluationsHTML = '';
            
            selectedReports.forEach((report, index) => {
                const data = reportData[report.id];
                if (data) {
                    html += `
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="font-semibold text-gray-800">Rapport ${index + 1} : ${data.title}</h4>
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">${data.status}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div><span class="font-medium text-gray-700">Étudiant :</span> <span class="text-gray-900">${data.student}</span></div>
                                <div><span class="font-medium text-gray-700">Encadrant :</span> <span class="text-gray-900">${data.supervisor}</span></div>
                                <div><span class="font-medium text-gray-700">Date :</span> <span class="text-gray-900">${data.date}</span></div>
                                <div><span class="font-medium text-gray-700">Durée :</span> <span class="text-gray-900">${data.duration}</span></div>
                                <div><span class="font-medium text-gray-700">Note :</span> <span class="text-gray-900 font-semibold">${data.grade}</span></div>
                            </div>
                    </div>
                `;
                
                    // Ajouter les évaluations pour ce rapport
                    allEvaluationsHTML += `
                        <div class="mb-4">
                            <h5 class="font-semibold text-gray-700 mb-2">Évaluations - ${data.title}</h5>
                    `;
                    
                    data.evaluations.forEach(eval => {
                    const bgColor = eval.decision === 'Validé' ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200';
                    const textColor = eval.decision === 'Validé' ? 'text-green-800' : 'text-red-800';
                    
                        allEvaluationsHTML += `
                            <div class="p-3 border rounded-lg ${bgColor} mb-2">
                            <div class="flex items-center justify-between mb-1">
                                <span class="font-medium text-sm">${eval.evaluator}</span>
                                <span class="px-2 py-1 text-xs rounded-full ${bgColor} ${textColor}">
                                    ${eval.decision}
                                </span>
                            </div>
                            <p class="text-xs text-gray-600">${eval.comment}</p>
                        </div>
                    `;
                });
                
                    allEvaluationsHTML += `</div>`;
                }
            });
                
            reportDetails.innerHTML = html;
            document.getElementById('evaluationsContent').innerHTML = allEvaluationsHTML;
                evaluationsSummary.classList.remove('hidden');
                
            // Mettre à jour l'éditeur si le modèle de séance de validation est chargé
            const editor = document.getElementById('editorContent');
            if (editor.innerHTML.includes('Procès-Verbal de séance de validation de thèmes')) {
                updateEditorWithReportData();
            }
        }

        // Mise à jour de l'éditeur avec les données des rapports
        function updateEditorWithReportData() {
            // Génère dynamiquement les cas à partir des rapports sélectionnés
            let casHTML = '';
            selectedReports.forEach((rapport, idx) => {
                casHTML += `
                <div class="cas">
                    <div class="cas-titre">Cas ${idx + 1}</div>
                    <strong>Étudiant :</strong> ${rapport.prenom_etu} ${rapport.nom_etu}<br>
                    <strong>Thème :</strong> ${rapport.theme_rapport}<br>
                    <strong>Recommandations de la commission :</strong>
                    <ul>
                        <li>thème valide</li>
                        <li>bien décrire le processus de règlement de chèques</li>
                        <li>décrire exactement le contexte</li>
                    </ul>
                    <div class="cas-footer">
                        <strong>Directeur de mémoire :</strong> Prof. KOUAKOU Mathias &nbsp;&nbsp;
                        <strong>Encadreur pédagogique :</strong> M. BROU Patrice
                    </div>
                </div>
                `;
            });
            // Remplacer le contenu de #casDynamique dans l'éditeur
            const editor = document.getElementById('editorContent');
            let content = window.baseTemplate;
            content = content.replace('<div id="casDynamique"></div>', `<div id="casDynamique">${casHTML}</div>`);
            editor.innerHTML = content;
        }

        // Chargement des modèles
        function loadTemplate(templateType) {
            const editor = document.getElementById('editorContent');
            let template = `
                <style>
                .editor-content { font-family: 'Times New Roman', Times, serif; }
                .header-logos { width: 100%; margin-bottom: 1em; }
                .header-logos img { height: 60px; }
                .header-logos .left { float: left; }
                .header-logos .right { float: right; }
                .header-logos .center { text-align: center; margin: 0 auto; }
                h1 { font-size: 2.2em; font-weight: bold; margin-bottom: 0.5em; text-align: center; }
                h2 { font-size: 1.5em; font-weight: bold; margin-bottom: 0.5em; text-align: center; }
                h3 { font-size: 1.2em; font-weight: bold; margin-bottom: 0.5em; }
                .section-title { border-bottom: 2px solid #222; margin-bottom: 0.7em; margin-top: 1.5em; }
                p { margin-bottom: 0.7em; }
                ul { margin-left: 1.5em; margin-bottom: 0.7em; }
                .encadre { background: #f6faff; border: 2px solid #b6d4fe; border-radius: 8px; padding: 1em; margin-bottom: 1em; }
                .cas { background: #fff; border: 1px solid #b6d4fe; border-radius: 8px; padding: 1em; margin-bottom: 1em; }
                .cas-titre { font-weight: bold; margin-bottom: 0.5em; }
                .cas-footer { margin-top: 1em; font-size: 1em; }
                .text-center { text-align: center; }
                .italic { font-style: italic; }
                </style>
                <div class="header-logos">
                    <img src="images/FHB.png" class="left" alt="Logo UFHB">
                    <div class="center">
                        <div style="font-size:13px; font-weight:bold; letter-spacing:1px;">REPUBLIQUE DE COTE D'IVOIRE</div>
                        <div style="font-size:12px;">Ministère de l'Enseignement Supérieur et de la Recherche Scientifique</div>
                        </div>
                    <img src="images/logo_mathInfo_fond_blanc.png" class="right" alt="Logo UFR MI">
                        </div>
                <h1>Procès-Verbal de séance de validation de thèmes</h1>
                <h2>Thèmes de Soutenance - Filière MIAGE-GI</h2>
                <div class="text-center" style="margin-bottom:1em;">
                    Université Félix Houphouët-Boigny<br>
                    UFR Mathématiques et Informatique
                        </div>
                <h3 class="section-title">CONTEXTE DE LA SÉANCE</h3>
                <p>Dans le bureau du Prof KOUA Brou à l'UFR MI, le [DATE] s'est tenue de 11 h 00 à 12 h 30 une séance de validation de thèmes de soutenance des étudiants en fin de cycle de la filière MIAGE-GI.</p>
                <p>La réunion était animée par Prof KOUA Brou le responsable de ladite filière. Etaient présents Prof. KOUA Brou, Dr MAMADOU Diarra, M. WAH Médard et M. BROU Patrice. Les membres de la commission de validation ont examiné [N] dossiers.</p>
                <div class="encadre">
                    <strong>Ordre du jour :</strong>
                    <ul>
                        <li>Informations</li>
                        <li>Validation de thèmes</li>
                        <li>Divers</li>
                                </ul>
                            </div>
                <h3 class="section-title">1. INFORMATIONS</h3>
                <p class="italic">[Le responsable de la filière a exposé sur l'intérêt des séances de validation. Il a donné des informations sur le choix des thèmes niveau ingénieur et la tenue mensuelle des séances de validation.]</p>
                <p class="italic">[L'organisation des séances de validation permet de faire le point des encadrements, le contenu potentiel de thèmes, et le suivi des mémoires par des encadreurs pédagogiques.]</p>
                <h3 class="section-title">2. VALIDATION DE THÈMES</h3>
                <div id="casDynamique"></div>
                <h3 class="section-title">3. DIVERS</h3>
                <p class="italic">[La commission a recommandé au Directeur de la filière d'améliorer le partenariat avec les entreprises car elles le souhaitent compte tenu du rendement des stagiaires déjà reçus.]</p>
                <strong>Recommandations aux étudiants :</strong>
                <ul>
                    <li>Respecter toutes les rubriques du template de présentation de thème en possession de la chargée de communication</li>
                    <li>Joindre un CV contenant une photo d'identité</li>
                    <li>Soutenir au plus tard à la session suivante pour ne pas tomber sous le coup d'une pénalité</li>
                                </ul>
                <div class="text-center" style="margin-top:2em;">
                    Les travaux de la commission ont pris fin à 12 h 30.<br>
                    Fait à Abidjan, le [DATE]<br>
                    <strong>La commission</strong>
                        </div>
                    `;
            editor.innerHTML = template;
            window.baseTemplate = template;
                updateEditorWithReportData();
        }

        // Fonctions de formatage de texte
        function formatText(command) {
            document.execCommand(command, false, null);
            document.getElementById('editorContent').focus();
        }

        function insertList(type) {
            const command = type === 'ul' ? 'insertUnorderedList' : 'insertOrderedList';
            document.execCommand(command, false, null);
            document.getElementById('editorContent').focus();
        }

        function insertSection(sectionType) {
            const editor = document.getElementById('editorContent');
            const selection = window.getSelection();
            const range = selection.getRangeAt(0);
            
            let sectionHTML = '';
            switch(sectionType) {
                case 'evaluation':
                    sectionHTML = `
                        <div class="mb-4 p-4 border-l-4 border-blue-500 bg-blue-50">
                            <h4 class="font-semibold text-blue-800 mb-2">Évaluation - [Nom de l'évaluateur]</h4>
                            <p><strong>Décision :</strong> [Validé/Rejeté]</p>
                            <p><strong>Commentaire :</strong> [Commentaire détaillé...]</p>
                        </div>
                    `;
                    break;
                case 'recommendation':
                    sectionHTML = `
                        <div class="mb-4 p-4 border-l-4 border-green-500 bg-green-50">
                            <h4 class="font-semibold text-green-800 mb-2">Recommandation</h4>
                            <p>[Votre recommandation...]</p>
                        </div>
                    `;
                    break;
            }
            
            const div = document.createElement('div');
            div.innerHTML = sectionHTML;
            range.insertNode(div.firstChild);
            editor.focus();
        }

        // Fonctions de sauvegarde
        function saveAsDraft() {
            const content = document.getElementById('editorContent').innerHTML;
            const reportId = document.getElementById('reportSelect').value;
            
            // Simuler la sauvegarde
            localStorage.setItem(`draft_${reportId}`, content);
            updateLastSaveTime();
            
            // Notification
            showNotification('Brouillon sauvegardé avec succès', 'success');
        }

        function autoSave() {
            if (autoSaveInterval) {
                clearInterval(autoSaveInterval);
                autoSaveInterval = null;
                document.querySelector('[onclick="autoSave()"]').innerHTML = '<i class="fas fa-clock mr-2"></i>Sauvegarde auto';
            } else {
                autoSaveInterval = setInterval(() => {
                    saveAsDraft();
                }, 30000); // Sauvegarde toutes les 30 secondes
                document.querySelector('[onclick="autoSave()"]').innerHTML = '<i class="fas fa-check mr-2"></i>Auto: ON';
            }
        }

        function updateLastSaveTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
            document.getElementById('lastSave').textContent = timeString;
        }

        // Aperçu du rapport
        function previewReport() {
            const content = document.getElementById('editorContent').innerHTML;
            document.getElementById('previewContent').innerHTML = content;
            document.getElementById('previewModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePreviewModal() {
            document.getElementById('previewModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Fonctions d'export
        function printReport() {
            const content = document.getElementById('previewContent').innerHTML;
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Compte Rendu d'Évaluation</title>
                    <style>
                        body { font-family: 'Times New Roman', serif; line-height: 1.6; margin: 40px; }
                        h1, h2, h3, h4 { color: #333; }
                        .border-b { border-bottom: 1px solid #ccc; }
                        .mb-6 { margin-bottom: 24px; }
                        .mb-4 { margin-bottom: 16px; }
                        .mb-3 { margin-bottom: 12px; }
                        .mb-2 { margin-bottom: 8px; }
                        .pb-2 { padding-bottom: 8px; }
                        .p-4 { padding: 16px; }
                        .border-l-4 { border-left: 4px solid #3b82f6; }
                        .bg-blue-50 { background-color: #eff6ff; }
                        .bg-green-50 { background-color: #f0fdf4; }
                        .text-center { text-align: center; }
                        .font-bold { font-weight: bold; }
                        .font-semibold { font-weight: 600; }
                    </style>
                </head>
                <body>${content}</body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        }

        function exportToPDF() {
            // Simulation d'export PDF
            showNotification('Export PDF en cours...', 'info');
            setTimeout(() => {
                showNotification('Rapport exporté en PDF avec succès', 'success');
            }, 2000);
        }

        // Finalisation du rapport
        function finalizeReport() {
            const content = document.getElementById('editorContent').innerHTML;
            const reportId = document.getElementById('reportSelect').value;
            
            if (!reportId) {
                showNotification('Veuillez sélectionner un rapport avant de finaliser', 'error');
                return;
            }
            
            if (content.includes('[À compléter]') || content.includes('[Cliquez ici')) {
                if (!confirm('Le rapport contient encore des sections à compléter. Voulez-vous vraiment le finaliser ?')) {
                    return;
                }
            }
            
            if (confirm('Êtes-vous sûr de vouloir finaliser ce compte rendu ? Cette action est irréversible.')) {
                // Simulation de finalisation
                localStorage.setItem(`final_${reportId}`, content);
                localStorage.removeItem(`draft_${reportId}`);
                
                showNotification('Compte rendu finalisé avec succès', 'success');
                
                // Mise à jour des étapes de progression
                updateProgressSteps(4);
            }
        }

        // Mise à jour des étapes de progression
        function updateProgressSteps(currentStep) {
            const steps = document.querySelectorAll('.progress-step');
            steps.forEach((step, index) => {
                step.classList.remove('active', 'completed');
                if (index + 1 < currentStep) {
                    step.classList.add('completed');
                } else if (index + 1 === currentStep) {
                    step.classList.add('active');
                }
            });
        }

        // Système de notifications
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-4 py-2 rounded-md text-white text-sm font-medium z-50 ${
                type === 'success' ? 'bg-green-600' : 
                type === 'error' ? 'bg-red-600' : 
                type === 'info' ? 'bg-blue-600' : 'bg-gray-600'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'} mr-2"></i>
                    ${message}
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {

            // Sauvegarde automatique lors de la saisie
            const editor = document.getElementById('editorContent');
            let saveTimeout;
            
            editor.addEventListener('input', function() {
                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(() => {
                    if (autoSaveInterval) {
                        saveAsDraft();
                    }
                }, 5000); // Sauvegarde 5 secondes après la dernière modification
            });

            // Raccourcis clavier
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey || e.metaKey) {
                    switch(e.key) {
                        case 's':
                            e.preventDefault();
                            saveAsDraft();
                            break;
                        case 'p':
                            e.preventDefault();
                            previewReport();
                            break;
                    }
                }
                
                if (e.key === 'Escape') {
                    closePreviewModal();
                }
            });
        });

        // Charger le modèle de séance de validation par défaut à l'ouverture de la page
        window.addEventListener('DOMContentLoaded', function() {
            loadTemplate('validation_seance');
        });

        // Affiche les infos détaillées de tous les rapports sélectionnés
        function showReportDetails() {
            const reportsList = document.getElementById('reportsList');
            const reportDetails = document.getElementById('reportDetails');
            reportDetails.innerHTML = '';
            const selected = Array.from(reportsList.children).map(div => div.id.replace('rapport-cas-', ''));
            if (selected.length === 0) {
                reportDetails.innerHTML = '<span class="text-gray-400">Aucun rapport sélectionné.</span>';
                return;
            }
            selected.forEach((id, idx) => {
                const rapport = getRapportById(id);
                if (rapport) {
                    reportDetails.innerHTML += `<div class='p-3 mb-2 bg-yellow-50 rounded border border-yellow-200'>
                        <b>Cas ${idx + 1}</b><br>
                        <b>Thème :</b> ${rapport.theme_rapport}<br>
                        <b>Étudiant :</b> ${rapport.prenom_etu} ${rapport.nom_etu}<br>
                        <b>Nom du rapport :</b> ${rapport.nom_rapport}
                    </div>`;
                }
            });
        }

        function submitCR() {
            if (selectedReports.length === 0) {
                alert("Veuillez sélectionner au moins un rapport.");
                return;
            }
            document.getElementById('contenu_CR').value = document.getElementById('editorContent').innerHTML;
            let selected = selectedReports[0] || {};
            document.getElementById('num_etu').value = selected.num_etu || '';
            document.getElementById('nom_CR').value = 'Compte rendu séance du ' + (new Date()).toLocaleDateString('fr-FR');
            let rapportsIds = selectedReports.map(r => r.id_rapport);
            // Supprimer les anciens inputs rapports[]
            document.querySelectorAll('input[name="rapports[]"]').forEach(e => e.remove());
            // Ajouter un input caché pour chaque rapport sélectionné
            let form = document.getElementById('formCR');
            rapportsIds.forEach(id => {
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'rapports[]';
                input.value = id;
                form.appendChild(input);
            });
            console.log("num_etu envoyé :", selected.num_etu);
            document.getElementById('formCR').submit();
        }

        window.addEventListener('DOMContentLoaded', function() {
            var notifType = <?php echo json_encode($notifType); ?>;
            var notifMsg = <?php echo json_encode($notifMsg); ?>;
            if (notifType && notifMsg) {
                var toast = document.getElementById('toastNotif');
                var toastContent = document.getElementById('toastContent');
                var toastIcon = document.getElementById('toastIcon');
                var toastMsg = document.getElementById('toastMsg');
                toastMsg.textContent = notifMsg;
                if (notifType === 'success') {
                    toastContent.className = 'bg-green-500 text-white px-4 py-3 rounded shadow-lg flex items-center';
                    toastIcon.innerHTML = '<i class="fas fa-check-circle"></i>';
                } else {
                    toastContent.className = 'bg-red-500 text-white px-4 py-3 rounded shadow-lg flex items-center';
                    toastIcon.innerHTML = '<i class="fas fa-times-circle"></i>';
                }
                toast.style.display = 'block';
                toast.style.opacity = 1;
                setTimeout(function() {
                    toast.style.opacity = 0;
                    setTimeout(function() { toast.style.display = 'none'; }, 500);
                }, 3000);
            }
        });
    </script>
</body>
</html>