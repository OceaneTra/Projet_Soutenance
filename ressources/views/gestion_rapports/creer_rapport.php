<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditeur de Rapport de Stage</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.4.2/tinymce.min.js"></script>
    <style>
        .loader {
            border-top-color: #3498db;
            animation: spinner 1.5s linear infinite;
        }

        @keyframes spinner {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* TinyMCE customizations */
        .tox-tinymce {
            border-radius: 0.5rem !important;
            border: 1px solid #e2e8f0 !important;
        }

        .document-loaded {
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }

        .document-loading {
            opacity: 0.6;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Éditeur de Rapport de Stage</h1>
            <p class="text-gray-600 mt-2">Créez et modifiez votre rapport facilement</p>
        </div>
        <div class="flex space-x-3 mt-4 md:mt-0">
            <a href="?page=gestion_rapports"
               class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour
            </a>
            <button id="saveBtn"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                </svg>
                Enregistrer
            </button>
            <button id="exportBtn"
                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Exporter
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <?php if (isset($erreurs) && !empty($erreurs)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <strong>Erreurs de validation :</strong>
                <ul class="mt-2 list-disc list-inside">
                    <?php foreach ($erreurs as $erreur): ?>
                        <li><?= htmlspecialchars($erreur) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Formulaire principal -->
        <form id="rapportForm" method="POST" onsubmit="return false;">
            <input type="hidden" name="action" value="save_rapport">
            <?php if (isset($isEditMode) && $isEditMode && isset($rapport)): ?>
                <input type="hidden" name="edit_id" value="<?= $rapport['id_rapport'] ?>">
            <?php endif; ?>
            <!-- Toolbar -->
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Informations du rapport</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nom_rapport" class="block text-sm font-medium text-gray-700 mb-2">
                            Nom du rapport <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="nom_rapport"
                               name="nom_rapport"
                               value="<?= isset($rapport) ? htmlspecialchars($rapport['nom_rapport']) : '' ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Ex: Rapport de stage - Développement Web"
                               required>
                    </div>
                    <div>
                        <label for="theme_rapport" class="block text-sm font-medium text-gray-700 mb-2">
                            Thème du rapport <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="theme_rapport"
                               name="theme_rapport"
                               value="<?= isset($rapport) ? htmlspecialchars($rapport['theme_rapport']) : '' ?>"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Ex: Intégration d'un système CRM"
                               required>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 border-b border-gray-200 p-4 flex flex-wrap justify-between items-center">
                <div class="flex items-center space-x-4 mb-3 md:mb-0">
                    <button id="loadTemplateBtn"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Charger le Modèle
                    </button>
                    <span id="loadingIndicator" class="hidden">
                        <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-6 w-6"></div>
                        <span class="ml-2 text-gray-600">Chargement...</span>
                    </span>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <select id="fontSelector"
                                class="bg-white border border-gray-300 text-gray-700 py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="Arial, sans-serif">Arial</option>
                            <option value="Times New Roman, serif">Times New Roman</option>
                            <option value="Calibri, sans-serif">Calibri</option>
                            <option value="Georgia, serif">Georgia</option>
                            <option value="Verdana, sans-serif">Verdana</option>
                        </select>
                    </div>
                    <div class="relative">
                        <select id="fontSize"
                                class="bg-white border border-gray-300 text-gray-700 py-2 pl-3 pr-8 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="12pt">12pt</option>
                            <option value="14pt">14pt</option>
                            <option value="16pt">16pt</option>
                            <option value="18pt">18pt</option>
                            <option value="20pt">20pt</option>
                            <option value="24pt">24pt</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Editor Area -->
            <div id="editorContainer" class="p-6 document-loading">
                <div id="documentStatusMessage" class="text-center py-8 text-gray-500">
                    Veuillez charger le modèle pour commencer l'édition
                </div>
                <textarea id="editor" name="contenu_rapport" class="hidden"></textarea>
            </div>
    </div>
    </form>

    <!-- Footer -->
    <div class="mt-6 text-center text-gray-600 text-sm">
        <p>© 2025 - Éditeur de Rapport de Stage | Développé pour faciliter la création de rapports professionnels
        </p>
    </div>
</div>

<!-- Notifications -->
<div id="notification"
     class="fixed top-4 right-4 max-w-md bg-white shadow-lg rounded-lg pointer-events-auto hidden overflow-hidden transform transition-all duration-300">
    <div class="p-4 flex">
        <div id="notificationIcon" class="flex-shrink-0">
            <!-- Icon will be inserted here -->
        </div>
        <div class="ml-3 w-0 flex-1">
            <p id="notificationMessage" class="text-sm font-medium text-gray-900">
                <!-- Message will be inserted here -->
            </p>
        </div>
        <div class="ml-4 flex-shrink-0 flex">
            <button id="closeNotification" class="inline-flex text-gray-400 hover:text-gray-500 focus:outline-none">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadTemplateBtn = document.getElementById('loadTemplateBtn');
        const saveBtn = document.getElementById('saveBtn');
        const exportBtn = document.getElementById('exportBtn');
        const editorContainer = document.getElementById('editorContainer');
        const documentStatusMessage = document.getElementById('documentStatusMessage');
        const loadingIndicator = document.getElementById('loadingIndicator');
        const fontSelector = document.getElementById('fontSelector');
        const fontSize = document.getElementById('fontSize');

        let editor;

        // Initialize TinyMCE editor
        tinymce.init({
            selector: '#editor',
            height: 800,
            menubar: true,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }',
            setup: function(ed) {
                editor = ed;

                ed.on('init', function() {
                    document.getElementById('editor').classList.remove('hidden');

                    <?php if (isset($isEditMode) && $isEditMode && !empty($contenuRapport)): ?>
                    // Mode édition : charger le contenu du rapport
                    setTimeout(function() {
                        editor.setContent(<?= json_encode($contenuRapport) ?>);
                        editorContainer.classList.remove('document-loading');
                        editorContainer.classList.add('document-loaded');
                        documentStatusMessage.classList.add('hidden');
                        showNotification('info', 'Rapport chargé en mode édition');
                    }, 500);
                    <?php else: ?>
                    // Mode création : ne rien charger, laisser l'éditeur vide
                    editor.setContent('');
                    editorContainer.classList.remove('document-loaded');
                    editorContainer.classList.add('document-loading');
                    documentStatusMessage.classList.remove('hidden');
                    <?php endif; ?>
                });
            }
        });

        // Template content - based on the provided document
        const templateContent = `
                <h1 style="text-align: center;">MINISTERE DE L'ENSEIGNEMENT SUPERIEUR ET DE LA RECHERCHE SCIENTIFIQUE</h1>

                <div style="text-align: center; margin: 20px 0;">
                    <p>[LOGO UNIVERSITÉ]</p>
                </div>

                <h2 style="text-align: center;">UNIVERSITE FELIX HOUPHOUET BOIGNY</h2>
                <h3 style="text-align: center;">UFR MATHEMATIQUES ET INFORMATIQUE FILLIERES PROFESSIONNALISEES MIAGE-GI</h3>

                <div style="text-align: center; margin: 20px 0;">
                    <p>REPUBLIQUE DE COTE D'IVOIRE</p>
                    <p>UNION - DICIPLINE - TRAVAIL</p>
                </div>

                <div style="text-align: center; margin: 20px 0;">
                    <p>[LOGO BOA]</p>
                    <p>[LOGO KYRIA]</p>
                </div>

                <h2 style="text-align: center;">KYRIA CONSULTANCY SERVICES</h2>

                <p style="text-align: center;">Mémoire de fin de cycle pour l'obtention du :</p>
                <p style="text-align: center; font-weight: bold;">Diplôme d'ingénieur de conception en informatique</p>
                <p style="text-align: center;">Option Méthodes Informatiques Appliquées à la Gestion des Entreprises</p>

                <h2 style="text-align: center;">Thème :</h2>
                <p style="text-align: center; font-weight: bold;">MISE EN PLACE D'UN MODULE D'INTEGRATION ENTRE ATLANTIS CRM ET ATLANTIS SGO :</p>
                <p style="text-align: center; font-weight: bold;">CAS DE LA BOA CAPITAL ASSET MANAGEMENT</p>

                <p style="text-align: center; text-decoration: underline;">PRESENTE PAR :</p>
                <p style="text-align: center;">M. KOET BI BOH CHABEL BAHI</p>

                <h1>PRESENTATION DU CADRE DE REFERENCE</h1>
                <p>KYRIA CONSULTANCY SERVICES (KYRIA-CS) est une société d'ingénierie financière spécialisée dans le conseil et la stratégie, qui a développé des compétences complémentaires pour répondre aux besoins spécifiques de ses clients et à leur évolution.</p>

                <p>Créée en Mai 2019, KYRIA-CS fournit un conseil et un accompagnement qui s'articulent autour d'une idée forte qui est de transformer une vision stratégique en actions et en processus. Elle s'appuie sur les connaissances professionnelles de ces ingénieurs, qui peuvent pleinement appréhender le système d'information de l'entreprise, à savoir la rédaction du cahier des charges, le développement logiciel et l'ingénierie. Elle accompagne surtout les entreprises présentent dans les domaines de la Finance, l'assurance, la mutualité, l'industrie et l'audit.</p>

                <p>Organisation, technologie et créativité représentent le point culminant des réflexions de l'entreprise. L'objectif de KYRIA est de fournir dans la durée, un service qui apportent une réelle valeur ajoutée aux entreprises. L'ensemble des méthodes de travail, des outils utilisés et des programmes de formation vont dans le sens de l'innovation collaborative et assurent ainsi la pérennité de notre qualité de service.</p>

                <p>KYRIA organise ses activités métiers autour de quatre pôles d'expertises :</p>
                <ul>
                    <li><strong>La Stratégie</strong> : Stratégie opérationnelle, technologique ou commerciale</li>
                    <li><strong>Le Conseil</strong> : Transformation des entreprises et des administrations dans le contexte de la révolution numérique</li>
                    <li><strong>Le Numérique</strong> : Relation client, marketing numérique, big data, technologies mobiles, gestion de contenus, e-commerce</li>
                    <li><strong>La Technologie</strong> : Services technologiques, conseil, Logiciels sectoriels, recherche et développement</li>
                </ul>

                <p>Pour la « valeur ajoutée », KYRIA nous donnons à ses prestations :</p>
                <ul>
                    <li>Un accompagnement personnalisé</li>
                    <li>Un conseil de proximité fourni par des professionnels expérimentés</li>
                    <li>Une approche personnalisée de niveau international.</li>
                </ul>

                <h1>INTRODUCTION : GENERALITE & PROBLEMATIQUE</h1>
                <h2>Généralités</h2>
                <p>Dans le contexte actuel de la transformation numérique, les entreprises cherchent constamment à améliorer leurs processus de gestion pour rester compétitives et répondre aux besoins de leurs clients. Le secteur financier n'échappe pas à cette réalité. Les institutions financières, telles que les banques et les sociétés de gestion d'actifs, adoptent de plus en plus de solutions technologiques avancées pour gérer efficacement leurs relations avec les clients et les opérations d'investissement. Les systèmes de gestion de la relation client (CRM) et les logiciels de gestion d'actifs sont devenus des outils essentiels pour assurer la compétitivité et la pérennité des institutions financières sur les marchés globalisés.</p>

                <p>Sur le plan international, l'intégration des systèmes CRM avec d'autres systèmes de gestion, comme les logiciels de gestion d'actifs, est devenue une nécessité pour garantir une vue unifiée et cohérente des opérations clients. Cette intégration permet non seulement de rationaliser les processus internes, mais aussi d'offrir une meilleure expérience client, en centralisant les informations et en facilitant l'accès à des données cruciales pour la prise de décision.</p>

                <p>Au niveau national, dans des pays comme la Côte d'Ivoire où l'industrie des services financiers est en pleine expansion, les entreprises de gestion d'actifs commencent à investir dans ces technologies pour répondre aux besoins croissants du marché. Cette tendance se reflète en effet dans les stratégies adoptées par des sociétés telles que BOA Capital Asset Management, qui cherchent à intégrer des modules sophistiqués pour relier leurs systèmes CRM à leurs logiciels de gestion de placements.</p>

                <p>Dans ce contexte, notre mémoire se focalisera sur le thème suivant : MISE EN PLACE D'UN MODULE D'INTEGRATION ENTRE ATLANTIS CRM ET ATLANTIS SGO : CAS DE LA BOA CAPITAL ASSET MANAGEMENT.</p>

                <h2>Problématique</h2>
                <p>Dans un environnement où l'efficacité et la réactivité sont des critères déterminants de succès, la mise en place d'une solution intégrée entre un système de gestion de la relation client (CRM) et un logiciel de gestion de placement collectif en valeurs mobilières (SGO) se pose comme un défi majeur. BOA Capital Asset Management se trouve confrontée à la difficulté de gérer efficacement les données client tout en assurant une gestion rigoureuse des placements financiers. L'absence d'une intégration harmonieuse entre le logiciel de CRM (Atlantis CRM) et celui de gestion d'OPCVM (Atlantis SGO) entraîne des redondances de données, des inefficacités dans le traitement des informations, et par conséquent, une diminution de la qualité du service client.</p>

                <p>La problématique à laquelle répond notre projet est donc la suivante : <strong>Comment concevoir et implémenter un module d'intégration efficace entre Atlantis CRM et Atlantis SGO pour améliorer la gestion des relations client et des placements financiers ?</strong></p>

                <h1>OBJECTIFS GENERAUX ET SPECIFIQUES</h1>
                <h2>1. Objectif général</h2>
                <p>L'objectif principal est de concevoir et de mettre en œuvre un module d'intégration entre Atlantis CRM et Atlantis SGO, qui permettra de synchroniser les données client avec les informations de gestion des placements financiers, afin d'améliorer la qualité du service client et l'efficacité opérationnelle.</p>

                <h2>2. Objectifs spécifiques</h2>
                <ul>
                    <li>Automatisation des flux de données : Développer des processus automatisés pour le transfert et la synchronisation des données entre Atlantis CRM et Atlantis SGO</li>
                    <li>Amélioration de l'expérience utilisateur : Optimiser l'interface utilisateur pour permettre un accès facile et rapide aux informations intégrées, facilitant ainsi la prise de décision pour les gestionnaires de portefeuille et les équipes de service client.</li>
                    <li>Renforcement de la sécurité et de l'intégrité des données : Mettre en place des mécanismes robustes pour assurer la protection des données sensibles échangées entre les deux systèmes et leur non redondance.</li>
                </ul>

                <h1>METHODOLOGIE</h1>
                <p>Suite à la problématique, le déroulement de notre projet comportera trois (3) grandes parties.</p>

                <p>En Première Partie, <em>L'Approche Méthodologique</em>, dans laquelle nous présenterons la structure d'accueil, le cadre de référence ainsi que le projet.</p>

                <p>En deuxième Partie, nous déroulerons la conception du système, quitte à définir la méthode d'étude, de modélisation et de réalisation du projet.</p>

                <p>Enfin la Troisième Partie qui est la Réalisation de la solution. Dans cette partie nous déroulerons les différents outils utilisés, le système de gestion de base de données et scripts utilisés pour la réalisation de la solution cible.</p>
            `;

        // Load template button event
        loadTemplateBtn.addEventListener('click', function(e) {
            e.preventDefault(); // IMPORTANT : Empêcher la soumission du formulaire

            loadingIndicator.classList.remove('hidden');
            documentStatusMessage.textContent = 'Chargement du modèle en cours...';

            setTimeout(function() {
                if (editor) {
                    editor.setContent(templateContent);
                    editorContainer.classList.remove('document-loading');
                    editorContainer.classList.add('document-loaded');
                    documentStatusMessage.classList.add('hidden');
                }
                loadingIndicator.classList.add('hidden');
                showNotification('success', 'Modèle chargé avec succès!');
            }, 1500);
        });

        // Font selector event
        fontSelector.addEventListener('change', function() {
            if (editor) {
                editor.execCommand('fontName', false, this.value);
            }
        });

        // Font size selector event
        fontSize.addEventListener('change', function() {
            if (editor) {
                editor.execCommand('fontSize', false, this.value);
            }
        });

        // Save button event
        saveBtn.addEventListener('click', function(e) {
            e.preventDefault(); // CRUCIAL
            e.stopPropagation(); // Empêcher la propagation

            if (!editor) {
                showNotification('error', 'Éditeur non initialisé');
                return false;
            }

            // Validation des champs requis
            const nomRapport = document.getElementById('nom_rapport').value.trim();
            const themeRapport = document.getElementById('theme_rapport').value.trim();
            const content = editor.getContent();

            if (!nomRapport || nomRapport.length < 5) {
                showNotification('error', 'Le nom du rapport doit contenir au moins 5 caractères');
                return false;
            }

            if (!themeRapport || themeRapport.length < 10) {
                showNotification('error', 'Le thème du rapport doit contenir au moins 10 caractères');
                return false;
            }

            if (!content || content.trim() === '' || content.replace(/<[^>]*>/g, '').trim().length < 50) {
                showNotification('error', 'Le contenu du rapport doit contenir au moins 50 caractères');
                return false;
            }

            // Créer FormData manuellement
            const formData = new FormData();
            formData.append('action', 'save_rapport');
            formData.append('nom_rapport', nomRapport);
            formData.append('theme_rapport', themeRapport);
            formData.append('contenu_rapport', content);

            // Ajouter edit_id si existe
            const editId = document.querySelector('input[name="edit_id"]');
            if (editId) {
                formData.append('edit_id', editId.value);
            }

            // Afficher indicateur de chargement
            saveBtn.disabled = true;
            saveBtn.innerHTML = '<svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"></circle><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" class="opacity-75"></path></svg>Enregistrement...';

            fetch(window.location.href, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest' // Important pour identifier AJAX côté serveur
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur réseau');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showNotification('success', data.message);
                        setTimeout(() => {
                            window.location.href = '?page=gestion_rapports';
                        }, 2000);
                    } else {
                        showNotification('error', data.message || 'Erreur lors de la sauvegarde');
                        if (data.errors) {
                            console.log('Erreurs de validation:', data.errors);
                        }
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    showNotification('error', 'Erreur lors de la sauvegarde');
                })
                .finally(() => {
                    // Restaurer le bouton
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>Enregistrer';
                });

            return false;
        });


        // Export button event
        exportBtn.addEventListener('click', function() {
            if (editor) {
                const content = editor.getContent();
                const blob = new Blob([
                    `<!DOCTYPE html><html><head><title>Rapport de Stage</title></head><body>${content}</body></html>`
                ], {
                    type: 'text/html'
                });
                const link = document.createElement('a');
                link.href = URL.createObjectURL(blob);
                link.download = 'Rapport_de_Stage.html';
                link.click();
                URL.revokeObjectURL(link.href);
                showNotification('success', 'Rapport exporté avec succès!');
            }
        });

        // Close notification
        document.getElementById('closeNotification').addEventListener('click', function() {
            document.getElementById('notification').classList.add('hidden');
        });

        // Utility function to show notifications
        function showNotification(type, message) {
            const notification = document.getElementById('notification');
            const notificationMessage = document.getElementById('notificationMessage');
            const notificationIcon = document.getElementById('notificationIcon');

            // Set message
            notificationMessage.textContent = message;

            // Set icon based on type
            let iconHTML = '';
            let bgColor = '';

            if (type === 'success') {
                iconHTML =
                    '<svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                bgColor = 'bg-green-50';
            } else if (type === 'error') {
                iconHTML =
                    '<svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
                bgColor = 'bg-red-50';
            } else if (type === 'info') {
                iconHTML =
                    '<svg class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                bgColor = 'bg-blue-50';
            }

            notificationIcon.innerHTML = iconHTML;
            notification.className =
                `fixed top-4 right-4 max-w-md ${bgColor} shadow-lg rounded-lg pointer-events-auto overflow-hidden transform transition-all duration-300`;

            // Show notification
            notification.classList.remove('hidden');

            // Hide after 3 seconds
            setTimeout(function() {
                notification.classList.add('hidden');
            }, 3000);
        }
    });
</script>
</body>

</html>