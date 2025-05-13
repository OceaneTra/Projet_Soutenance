<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de Rapport de Stage</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center text-blue-800 mb-8">Plateforme de Création de Rapport de Stage</h1>

        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4 text-blue-700">Instructions</h2>
            <ol class="list-decimal pl-5 space-y-2 text-gray-700">
                <li>Remplissez tous les champs du formulaire avec vos informations personnelles et les détails de votre
                    stage.</li>
                <li>Rédigez le contenu de votre rapport dans les sections fournies.</li>
                <li>Utilisez les outils de mise en forme pour structurer votre contenu.</li>
                <li>Vérifiez l'aperçu de votre rapport avant la soumission.</li>
                <li>Téléchargez votre rapport au format PDF ou soumettez-le directement.</li>
            </ol>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Formulaire -->
            <div class="lg:col-span-1 bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-blue-700">Informations Personnelles</h2>
                <form id="reportForm" class="space-y-4">
                    <!-- Informations étudiant -->
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" id="nom" name="nom"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required>
                    </div>
                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom</label>
                        <input type="text" id="prenom" name="prenom"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required>
                    </div>
                    <div>
                        <label for="filiere" class="block text-sm font-medium text-gray-700">Filière</label>
                        <input type="text" id="filiere" name="filiere"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required>
                    </div>

                    <!-- Informations entreprise -->
                    <h2 class="text-xl font-semibold mt-6 mb-4 text-blue-700">Informations sur l'Entreprise</h2>
                    <div>
                        <label for="entreprise" class="block text-sm font-medium text-gray-700">Nom de
                            l'Entreprise</label>
                        <input type="text" id="entreprise" name="entreprise"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required>
                    </div>
                    <div>
                        <label for="adresse" class="block text-sm font-medium text-gray-700">Adresse</label>
                        <input type="text" id="adresse" name="adresse"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required>
                    </div>
                    <div>
                        <label for="secteur" class="block text-sm font-medium text-gray-700">Secteur d'Activité</label>
                        <input type="text" id="secteur" name="secteur"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required>
                    </div>
                    <div>
                        <label for="encadrant" class="block text-sm font-medium text-gray-700">Encadrant
                            Professionnel</label>
                        <input type="text" id="encadrant" name="encadrant"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required>
                    </div>

                    <!-- Informations stage -->
                    <h2 class="text-xl font-semibold mt-6 mb-4 text-blue-700">Informations sur le Stage</h2>
                    <div>
                        <label for="theme" class="block text-sm font-medium text-gray-700">Thème du Mémoire</label>
                        <input type="text" id="theme" name="theme"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required>
                    </div>
                    <div>
                        <label for="dateDebut" class="block text-sm font-medium text-gray-700">Date de Début</label>
                        <input type="date" id="dateDebut" name="dateDebut"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required>
                    </div>
                    <div>
                        <label for="dateFin" class="block text-sm font-medium text-gray-700">Date de Fin</label>
                        <input type="date" id="dateFin" name="dateFin"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required>
                    </div>
                    <div>
                        <label for="encadrantAcademique" class="block text-sm font-medium text-gray-700">Encadrant
                            Académique</label>
                        <input type="text" id="encadrantAcademique" name="encadrantAcademique"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border" required>
                    </div>
                </form>
            </div>

            <!-- Contenu du rapport -->
            <div class="lg:col-span-2 bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4 text-blue-700">Contenu du Rapport</h2>

                <div class="space-y-4">
                    <!-- Introduction -->
                    <div>
                        <label for="introduction" class="block text-sm font-medium text-gray-700">Introduction</label>
                        <textarea id="introduction" name="introduction" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border"
                            placeholder="Présentez le contexte de votre stage et les objectifs de votre mémoire..."></textarea>
                    </div>

                    <!-- Présentation de l'entreprise -->
                    <div>
                        <label for="presentationEntreprise" class="block text-sm font-medium text-gray-700">Présentation
                            de l'Entreprise</label>
                        <textarea id="presentationEntreprise" name="presentationEntreprise" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border"
                            placeholder="Décrivez l'entreprise, son activité, son organisation..."></textarea>
                    </div>

                    <!-- Missions et tâches -->
                    <div>
                        <label for="missions" class="block text-sm font-medium text-gray-700">Missions et Tâches</label>
                        <textarea id="missions" name="missions" rows="6"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border"
                            placeholder="Détaillez les missions qui vous ont été confiées et les tâches réalisées..."></textarea>
                    </div>

                    <!-- Problématique -->
                    <div>
                        <label for="problematique" class="block text-sm font-medium text-gray-700">Problématique et
                            Méthodologie</label>
                        <textarea id="problematique" name="problematique" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border"
                            placeholder="Exposez la problématique traitée et la méthodologie adoptée..."></textarea>
                    </div>

                    <!-- Résultats -->
                    <div>
                        <label for="resultats" class="block text-sm font-medium text-gray-700">Résultats et
                            Réalisations</label>
                        <textarea id="resultats" name="resultats" rows="6"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border"
                            placeholder="Présentez les résultats obtenus et les solutions développées..."></textarea>
                    </div>

                    <!-- Conclusion -->
                    <div>
                        <label for="conclusion" class="block text-sm font-medium text-gray-700">Conclusion et
                            Perspectives</label>
                        <textarea id="conclusion" name="conclusion" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-2 border"
                            placeholder="Concluez votre rapport et proposez des perspectives d'amélioration..."></textarea>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex flex-col md:flex-row justify-end space-y-2 md:space-y-0 md:space-x-4 mt-6">
                        <button type="button" id="previewBtn"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Aperçu du Rapport
                        </button>
                        <button type="button" id="downloadBtn"
                            class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Télécharger en PDF
                        </button>
                        <button type="button" id="submitBtn"
                            class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Soumettre le Rapport
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aperçu du rapport -->
        <div id="previewContainer"
            class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-4xl max-h-screen overflow-y-auto">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-bold text-blue-800">Aperçu du Rapport</h2>
                    <button id="closePreview" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="reportPreview" class="p-4 border rounded-lg"></div>
                <div class="mt-4 flex justify-end">
                    <button id="confirmDownload"
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline mr-2">
                        Télécharger
                    </button>
                    <button id="editReport"
                        class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Modifier
                    </button>
                </div>
            </div>
        </div>

        <!-- Message de confirmation -->
        <div id="confirmationMessage"
            class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-xl p-6 max-w-md">
                <div class="text-center">
                    <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Rapport Soumis avec Succès!</h2>
                    <p class="text-gray-600 mb-4">Votre rapport a été enregistré et soumis pour évaluation. Vous
                        recevrez une confirmation par email.</p>
                    <button id="closeConfirmation"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Éléments du DOM
        const previewBtn = document.getElementById('previewBtn');
        const downloadBtn = document.getElementById('downloadBtn');
        const submitBtn = document.getElementById('submitBtn');
        const previewContainer = document.getElementById('previewContainer');
        const reportPreview = document.getElementById('reportPreview');
        const closePreview = document.getElementById('closePreview');
        const confirmDownload = document.getElementById('confirmDownload');
        const editReport = document.getElementById('editReport');
        const confirmationMessage = document.getElementById('confirmationMessage');
        const closeConfirmation = document.getElementById('closeConfirmation');

        // Fonction pour générer le contenu du rapport
        function generateReportContent() {
            const nom = document.getElementById('nom').value || '[Nom]';
            const prenom = document.getElementById('prenom').value || '[Prénom]';
            const email = document.getElementById('email').value || '[Email]';
            const filiere = document.getElementById('filiere').value || '[Filière]';
            const entreprise = document.getElementById('entreprise').value || '[Entreprise]';
            const adresse = document.getElementById('adresse').value || '[Adresse]';
            const secteur = document.getElementById('secteur').value || '[Secteur]';
            const encadrant = document.getElementById('encadrant').value || '[Encadrant]';
            const theme = document.getElementById('theme').value || '[Thème]';
            const dateDebut = document.getElementById('dateDebut').value ? new Date(document.getElementById(
                'dateDebut').value).toLocaleDateString('fr-FR') : '[Date début]';
            const dateFin = document.getElementById('dateFin').value ? new Date(document.getElementById(
                'dateFin').value).toLocaleDateString('fr-FR') : '[Date fin]';
            const encadrantAcademique = document.getElementById('encadrantAcademique').value ||
                '[Encadrant académique]';
            const introduction = document.getElementById('introduction').value ||
            'Aucune introduction fournie.';
            const presentationEntreprise = document.getElementById('presentationEntreprise').value ||
                'Aucune présentation fournie.';
            const missions = document.getElementById('missions').value || 'Aucune mission détaillée.';
            const problematique = document.getElementById('problematique').value ||
                'Aucune problématique définie.';
            const resultats = document.getElementById('resultats').value || 'Aucun résultat mentionné.';
            const conclusion = document.getElementById('conclusion').value || 'Aucune conclusion rédigée.';

            // Date actuelle pour le rapport
            const currentDate = new Date().toLocaleDateString('fr-FR');

            // Création du contenu HTML du rapport
            return `
          <div class="p-8 max-w-4xl mx-auto bg-white">
            <div class="text-center mb-8">
              <h1 class="text-2xl font-bold text-blue-800 mb-2">RAPPORT DE STAGE MASTER</h1>
              <h2 class="text-xl font-semibold text-blue-700">${theme}</h2>
              <p class="text-gray-600 mt-2">Rapport soumis le ${currentDate}</p>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-gray-100 rounded-lg">
              <div>
                <p class="font-semibold">Étudiant:</p>
                <p>${prenom} ${nom}</p>
                <p>${email}</p>
                <p>Filière: ${filiere}</p>
              </div>
              <div>
                <p class="font-semibold">Entreprise:</p>
                <p>${entreprise}</p>
                <p>${adresse}</p>
                <p>Secteur: ${secteur}</p>
              </div>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-gray-100 rounded-lg">
              <div>
                <p class="font-semibold">Période de stage:</p>
                <p>Du ${dateDebut} au ${dateFin}</p>
              </div>
              <div>
                <p class="font-semibold">Encadrement:</p>
                <p>Professionnel: ${encadrant}</p>
                <p>Académique: ${encadrantAcademique}</p>
              </div>
            </div>
            
            <div class="mb-6">
              <h3 class="text-lg font-semibold text-blue-700 mb-2">Introduction</h3>
              <div class="p-4 bg-gray-100 rounded-lg">
                <p>${introduction.replace(/\n/g, '<br>')}</p>
              </div>
            </div>
            
            <div class="mb-6">
              <h3 class="text-lg font-semibold text-blue-700 mb-2">Présentation de l'Entreprise</h3>
              <div class="p-4 bg-gray-100 rounded-lg">
                <p>${presentationEntreprise.replace(/\n/g, '<br>')}</p>
              </div>
            </div>
            
            <div class="mb-6">
              <h3 class="text-lg font-semibold text-blue-700 mb-2">Missions et Tâches Réalisées</h3>
              <div class="p-4 bg-gray-100 rounded-lg">
                <p>${missions.replace(/\n/g, '<br>')}</p>
              </div>
            </div>
            
            <div class="mb-6">
              <h3 class="text-lg font-semibold text-blue-700 mb-2">Problématique et Méthodologie</h3>
              <div class="p-4 bg-gray-100 rounded-lg">
                <p>${problematique.replace(/\n/g, '<br>')}</p>
              </div>
            </div>
            
            <div class="mb-6">
              <h3 class="text-lg font-semibold text-blue-700 mb-2">Résultats et Réalisations</h3>
              <div class="p-4 bg-gray-100 rounded-lg">
                <p>${resultats.replace(/\n/g, '<br>')}</p>
              </div>
            </div>
            
            <div class="mb-6">
              <h3 class="text-lg font-semibold text-blue-700 mb-2">Conclusion et Perspectives</h3>
              <div class="p-4 bg-gray-100 rounded-lg">
                <p>${conclusion.replace(/\n/g, '<br>')}</p>
              </div>
            </div>
            
            <div class="text-center mt-8 pt-4 border-t border-gray-300">
              <p class="text-gray-600">Document généré via la Plateforme de Soumission de Rapport de Stage</p>
              <p class="text-gray-600 text-sm">${prenom} ${nom} - ${currentDate}</p>
            </div>
          </div>
        `;
        }

        // Aperçu du rapport
        previewBtn.addEventListener('click', function() {
            reportPreview.innerHTML = generateReportContent();
            previewContainer.classList.remove('hidden');
        });

        // Fermer l'aperçu
        closePreview.addEventListener('click', function() {
            previewContainer.classList.add('hidden');
        });

        // Éditer le rapport (retour au formulaire)
        editReport.addEventListener('click', function() {
            previewContainer.classList.add('hidden');
        });

        // Télécharger le rapport en PDF
        downloadBtn.addEventListener('click', function() {
            const content = generateReportContent();
            const element = document.createElement('div');
            element.innerHTML = content;
            document.body.appendChild(element);

            const options = {
                margin: 10,
                filename: `Rapport_Stage_${document.getElementById('nom').value || 'Etudiant'}.pdf`,
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };

            html2pdf().set(options).from(element).save().then(() => {
                document.body.removeChild(element);
            });
        });

        // Confirmation de téléchargement depuis l'aperçu
        confirmDownload.addEventListener('click', function() {
            const content = reportPreview.innerHTML;
            const element = document.createElement('div');
            element.innerHTML = content;
            document.body.appendChild(element);

            const options = {
                margin: 10,
                filename: `Rapport_Stage_${document.getElementById('nom').value || 'Etudiant'}.pdf`,
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };

            html2pdf().set(options).from(element).save().then(() => {
                document.body.removeChild(element);
                previewContainer.classList.add('hidden');
            });
        });

        // Soumettre le rapport
        submitBtn.addEventListener('click', function() {
            // Vérification basique des champs requis
            const requiredFields = ['nom', 'prenom', 'email', 'filiere', 'entreprise', 'theme'];
            let allValid = true;

            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    input.classList.add('border-red-500');
                    allValid = false;
                } else {
                    input.classList.remove('border-red-500');
                }
            });

            if (!allValid) {
                alert('Veuillez remplir tous les champs obligatoires avant de soumettre.');
                return;
            }

            // Simulation d'envoi au serveur
            setTimeout(() => {
                confirmationMessage.classList.remove('hidden');
            }, 1000);
        });

        // Fermer le message de confirmation
        closeConfirmation.addEventListener('click', function() {
            confirmationMessage.classList.add('hidden');
        });
    });
    </script>
</body>

</html>