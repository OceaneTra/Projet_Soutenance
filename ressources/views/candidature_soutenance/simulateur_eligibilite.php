<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulateur d'éligibilité | Soutenance Manager</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
    .floating-shape {
        position: fixed;
        border-radius: 50%;
        opacity: 0.1;
        z-index: -1;
    }

    .shape-1 {
        width: 300px;
        height: 300px;
        background: linear-gradient(135deg, #10B981, #3B82F6);
        top: -100px;
        right: -100px;
    }

    .shape-2 {
        width: 400px;
        height: 400px;
        background: linear-gradient(135deg, #3B82F6, #8B5CF6);
        bottom: -150px;
        left: -150px;
    }

    .progress-bar {
        transition: width 0.5s ease-in-out;
    }

    .requirement-item {
        transition: all 0.3s ease;
    }

    .requirement-item:hover {
        transform: translateX(5px);
    }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">


        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">


            <!-- Main content area -->
            <div class="flex-1 p-4 md:p-6 overflow-y-auto">
                <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
                    <!-- En-tête avec progression -->
                    <div class="p-6 bg-gradient-to-r from-green-50 to-blue-50 border-b border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Vérification d'éligibilité</h2>
                        <p class="text-gray-600 mb-4">Vérifiez si vous remplissez toutes les conditions pour candidater
                            à la soutenance.</p>

                        <div class="mb-4">
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Progression de vérification</span>
                                <span class="text-sm font-medium text-green-600">60%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="progress-bar bg-green-500 h-2.5 rounded-full" style="width: 60%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Contenu principal -->
                    <div class="p-6">
                        <!-- Section 1: Informations générales -->
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-info-circle text-green-500 mr-2"></i>
                                Informations générales
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                                    <p class="text-gray-900 font-medium">Jean Dupont</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Numéro
                                        d'étudiant</label>
                                    <p class="text-gray-900 font-medium">ETU123456</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Formation</label>
                                    <p class="text-gray-900 font-medium">Master Informatique</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Promotion</label>
                                    <p class="text-gray-900 font-medium">2022-2023</p>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Exigences de soutenance -->
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-clipboard-check text-green-500 mr-2"></i>
                                Exigences pour la soutenance
                            </h3>

                            <div class="space-y-4">
                                <!-- Item 1 -->
                                <div class="requirement-item p-4 border rounded-lg flex items-start" id="req1">
                                    <div class="mr-3 mt-1">
                                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="font-medium text-gray-800">Rapport de stage déposé</h4>
                                        <p class="text-sm text-gray-600 mt-1">Votre rapport de stage doit être validé
                                            par votre tuteur pédagogique.</p>
                                        <div class="mt-2 text-sm text-green-600 font-medium">
                                            <i class="fas fa-check mr-1"></i> Condition remplie
                                        </div>
                                    </div>
                                </div>

                                <!-- Item 2 -->
                                <div class="requirement-item p-4 border rounded-lg flex items-start" id="req2">
                                    <div class="mr-3 mt-1">
                                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="font-medium text-gray-800">Fiche d'évaluation complétée</h4>
                                        <p class="text-sm text-gray-600 mt-1">Votre tuteur en entreprise doit avoir
                                            complété la fiche d'évaluation.</p>
                                        <div class="mt-2 text-sm text-green-600 font-medium">
                                            <i class="fas fa-check mr-1"></i> Condition remplie
                                        </div>
                                    </div>
                                </div>

                                <!-- Item 3 -->
                                <div class="requirement-item p-4 border rounded-lg flex items-start bg-yellow-50"
                                    id="req3">
                                    <div class="mr-3 mt-1">
                                        <i class="fas fa-exclamation-circle text-yellow-500 text-xl"></i>
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="font-medium text-gray-800">Soutenance blanche réalisée</h4>
                                        <p class="text-sm text-gray-600 mt-1">Vous devez avoir effectué votre soutenance
                                            blanche avec validation.</p>
                                        <div class="mt-2 text-sm text-yellow-600 font-medium">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> En attente de validation
                                        </div>
                                        <div class="mt-2 text-xs text-gray-500">
                                            Votre soutenance blanche est prévue pour le 15/06/2023.
                                        </div>
                                    </div>
                                </div>

                                <!-- Item 4 -->
                                <div class="requirement-item p-4 border rounded-lg flex items-start bg-red-50"
                                    id="req4">
                                    <div class="mr-3 mt-1">
                                        <i class="fas fa-times-circle text-red-500 text-xl"></i>
                                    </div>
                                    <div class="flex-grow">
                                        <h4 class="font-medium text-gray-800">Dépôt du mémoire</h4>
                                        <p class="text-sm text-gray-600 mt-1">Votre mémoire doit être déposé et validé
                                            par votre directeur de mémoire.</p>
                                        <div class="mt-2 text-sm text-red-600 font-medium">
                                            <i class="fas fa-times mr-1"></i> Condition non remplie
                                        </div>
                                        <div class="mt-2">
                                            <a href="#"
                                                class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center">
                                                <i class="fas fa-upload mr-1"></i> Déposer mon mémoire
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Résumé d'éligibilité -->
                        <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-clipboard-list text-blue-500 mr-2"></i>
                                Résumé de votre éligibilité
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                                    <div class="text-3xl font-bold text-green-500 mb-1">2</div>
                                    <div class="text-sm text-gray-600">Conditions remplies</div>
                                </div>
                                <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                                    <div class="text-3xl font-bold text-yellow-500 mb-1">1</div>
                                    <div class="text-sm text-gray-600">En attente</div>
                                </div>
                                <div class="bg-white p-4 rounded-lg shadow-sm text-center">
                                    <div class="text-3xl font-bold text-red-500 mb-1">1</div>
                                    <div class="text-sm text-gray-600">Non remplies</div>
                                </div>
                            </div>

                            <div class="bg-white p-4 rounded-lg shadow-sm">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium text-gray-800">Statut actuel :</span>
                                            Vous ne pouvez pas encore candidater à la soutenance.
                                            <span class="font-medium">1 condition manquante</span> et
                                            <span class="font-medium">1 en attente de validation</span>.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                            <button
                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <i class="fas fa-download mr-2"></i> Exporter en PDF
                            </button>
                            <button
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50"
                                disabled>
                                <i class="fas fa-paper-plane mr-2"></i> Candidater à la soutenance
                            </button>
                        </div>
                    </div>
                </div>

                <!-- FAQ Section -->
                <div class="max-w-4xl mx-auto mt-8 bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-question-circle text-green-500 mr-2"></i>
                            Questions fréquentes
                        </h3>

                        <div class="space-y-4">
                            <div class="border-b border-gray-200 pb-4">
                                <button
                                    class="faq-question flex justify-between items-center w-full text-left font-medium text-gray-700 hover:text-green-600 focus:outline-none">
                                    <span>Que faire si une condition n'est pas remplie ?</span>
                                    <i
                                        class="fas fa-chevron-down text-gray-400 transform transition-transform duration-200"></i>
                                </button>
                                <div class="faq-answer mt-2 text-gray-600 hidden">
                                    <p>Si une condition n'est pas remplie, vous verrez un lien ou une indication sur la
                                        marche à suivre pour la remplir. Dans certains cas, vous devrez contacter votre
                                        tuteur ou l'administration.</p>
                                </div>
                            </div>

                            <div class="border-b border-gray-200 pb-4">
                                <button
                                    class="faq-question flex justify-between items-center w-full text-left font-medium text-gray-700 hover:text-green-600 focus:outline-none">
                                    <span>Combien de temps prend la validation d'une condition ?</span>
                                    <i
                                        class="fas fa-chevron-down text-gray-400 transform transition-transform duration-200"></i>
                                </button>
                                <div class="faq-answer mt-2 text-gray-600 hidden">
                                    <p>Le temps de validation dépend de la condition. Pour les validations par un
                                        enseignant, cela peut prendre jusqu'à 5 jours ouvrés. Nous vous recommandons de
                                        ne pas attendre la dernière minute pour remplir vos obligations.</p>
                                </div>
                            </div>

                            <div class="border-b border-gray-200 pb-4">
                                <button
                                    class="faq-question flex justify-between items-center w-full text-left font-medium text-gray-700 hover:text-green-600 focus:outline-none">
                                    <span>Puis-je candidater si une condition est en attente ?</span>
                                    <i
                                        class="fas fa-chevron-down text-gray-400 transform transition-transform duration-200"></i>
                                </button>
                                <div class="faq-answer mt-2 text-gray-600 hidden">
                                    <p>Non, toutes les conditions doivent être validées (statut vert) avant de pouvoir
                                        candidater. Les validations en cours (statut orange) ne permettent pas encore de
                                        soumettre votre candidature.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shapes d'arrière-plan -->
    <div class="floating-shape shape-1"></div>
    <div class="floating-shape shape-2"></div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion du menu mobile
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const sidebar = document.querySelector('.hidden.md\\:flex.md\\:flex-shrink-0 > .flex.flex-col.w-64');

        if (mobileMenuButton && sidebar) {
            mobileMenuButton.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('absolute');
                sidebar.classList.toggle('z-20');
            });
        }

        // Gestion des FAQ
        const faqQuestions = document.querySelectorAll('.faq-question');
        faqQuestions.forEach(question => {
            question.addEventListener('click', function() {
                const answer = this.nextElementSibling;
                const icon = this.querySelector('i');

                answer.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });

        // Animation des éléments de la page
        const requirements = document.querySelectorAll('.requirement-item');
        requirements.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateY(20px)';

            setTimeout(() => {
                item.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                item.style.opacity = '1';
                item.style.transform = 'translateY(0)';
            }, 100 * index);
        });
    });
    </script>
</body>

</html>