<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulateur d'éligibilité | Soutenance Manager</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

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
                    </div>

                    <!-- Formulaire -->
                    <form action="<?= base_url('eligibilite/verifier') ?>" method="POST" class="p-6">
                        <!-- Section 1: Informations générales -->
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-info-circle text-green-500 mr-2"></i>
                                Informations générales
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                                    <input type="text" name="nom_complet" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Numéro
                                        d'étudiant</label>
                                    <input type="text" name="numero_etudiant" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Formation</label>
                                    <input type="text" name="formation" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Promotion</label>
                                    <input type="text" name="promotion" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
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
                                <!-- Rapport de stage -->
                                <div class="requirement-item p-4 border rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-gray-800">Rapport de stage déposé</h4>
                                            <p class="text-sm text-gray-600 mt-1">Votre rapport de stage doit être
                                                validé par votre tuteur pédagogique.</p>
                                        </div>
                                        <div class="flex items-center">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="rapport_stage" value="oui"
                                                    class="form-radio text-green-500">
                                                <span class="ml-2">Oui</span>
                                            </label>
                                            <label class="inline-flex items-center ml-4">
                                                <input type="radio" name="rapport_stage" value="non"
                                                    class="form-radio text-red-500">
                                                <span class="ml-2">Non</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Fiche d'évaluation -->
                                <div class="requirement-item p-4 border rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-gray-800">Fiche d'évaluation complétée</h4>
                                            <p class="text-sm text-gray-600 mt-1">Votre tuteur en entreprise doit avoir
                                                complété la fiche d'évaluation.</p>
                                        </div>
                                        <div class="flex items-center">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="fiche_evaluation" value="oui"
                                                    class="form-radio text-green-500">
                                                <span class="ml-2">Oui</span>
                                            </label>
                                            <label class="inline-flex items-center ml-4">
                                                <input type="radio" name="fiche_evaluation" value="non"
                                                    class="form-radio text-red-500">
                                                <span class="ml-2">Non</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Soutenance blanche -->
                                <div class="requirement-item p-4 border rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-gray-800">Soutenance blanche réalisée</h4>
                                            <p class="text-sm text-gray-600 mt-1">Vous devez avoir effectué votre
                                                soutenance blanche avec validation.</p>
                                        </div>
                                        <div class="flex items-center">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="soutenance_blanche" value="oui"
                                                    class="form-radio text-green-500">
                                                <span class="ml-2">Oui</span>
                                            </label>
                                            <label class="inline-flex items-center ml-4">
                                                <input type="radio" name="soutenance_blanche" value="non"
                                                    class="form-radio text-red-500">
                                                <span class="ml-2">Non</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Mémoire -->
                                <div class="requirement-item p-4 border rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-gray-800">Dépôt du mémoire</h4>
                                            <p class="text-sm text-gray-600 mt-1">Votre mémoire doit être déposé et
                                                validé par votre directeur de mémoire.</p>
                                        </div>
                                        <div class="flex items-center">
                                            <label class="inline-flex items-center">
                                                <input type="radio" name="memoire" value="oui"
                                                    class="form-radio text-green-500">
                                                <span class="ml-2">Oui</span>
                                            </label>
                                            <label class="inline-flex items-center ml-4">
                                                <input type="radio" name="memoire" value="non"
                                                    class="form-radio text-red-500">
                                                <span class="ml-2">Non</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Commentaires -->
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-comment-alt text-green-500 mr-2"></i>
                                Commentaires additionnels
                            </h3>
                            <textarea name="commentaires" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="Ajoutez ici toute information supplémentaire que vous souhaitez communiquer à l'administration..."></textarea>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex justify-end space-x-3">
                            <button type="submit"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <i class="fas fa-paper-plane mr-2"></i> Soumettre ma demande
                            </button>
                        </div>
                    </form>
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