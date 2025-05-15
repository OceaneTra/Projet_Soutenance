<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation des Commentaires - Soutenance Manager</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    .comment-card {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }

    .comment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .comment-encadrant {
        border-left-color: #3b82f6;
    }

    .comment-jury {
        border-left-color: #10b981;
    }

    .comment-important {
        border-left-color: #ef4444;
        background-color: #fef2f2;
    }

    .tag {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
    }

    .tag-encadrant {
        background-color: #dbeafe;
        color: #1d4ed8;
    }

    .tag-jury {
        background-color: #dcfce7;
        color: #047857;
    }

    .tag-important {
        background-color: #fee2e2;
        color: #b91c1c;
    }

    .marker {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }

    .marker-encadrant {
        background-color: #3b82f6;
    }

    .marker-jury {
        background-color: #10b981;
    }

    .marker-important {
        background-color: #ef4444;
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">


        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">


            <!-- Main content area -->
            <div class="flex-1 p-4 md:p-6 overflow-y-auto">
                <!-- Header with filters -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="mb-4 md:mb-0">
                            <h2 class="text-2xl font-bold text-gray-800">Commentaires sur votre mémoire</h2>
                            <p class="text-gray-600">Consultez les retours de vos encadrants et du jury</p>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button
                                class="filter-btn active px-4 py-2 bg-green-500 text-white rounded-full text-sm font-medium"
                                data-filter="all">
                                Tous les commentaires
                            </button>
                            <button
                                class="filter-btn px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-medium"
                                data-filter="encadrant">
                                <i class="fas fa-user-tie mr-1"></i> Encadrant
                            </button>
                            <button
                                class="filter-btn px-4 py-2 bg-green-100 text-green-800 rounded-full text-sm font-medium"
                                data-filter="jury">
                                <i class="fas fa-users mr-1"></i> Jury
                            </button>
                            <button
                                class="filter-btn px-4 py-2 bg-red-100 text-red-800 rounded-full text-sm font-medium"
                                data-filter="important">
                                <i class="fas fa-exclamation-circle mr-1"></i> Importants
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Stats cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                <i class="fas fa-comment-dots text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500">Commentaires encadrant</p>
                                <h3 class="text-2xl font-bold text-gray-800">12</h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                <i class="fas fa-comments text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500">Commentaires jury</p>
                                <h3 class="text-2xl font-bold text-gray-800">8</h3>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                                <i class="fas fa-exclamation-triangle text-xl"></i>
                            </div>
                            <div>
                                <p class="text-gray-500">Commentaires importants</p>
                                <h3 class="text-2xl font-bold text-gray-800">5</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments section -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <!-- Tabs -->
                    <div class="border-b border-gray-200">
                        <nav class="flex -mb-px">
                            <button
                                class="tab-btn active py-4 px-6 text-sm font-medium text-center border-b-2 border-green-500 text-green-600">
                                <i class="fas fa-list-ul mr-2"></i> Tous les commentaires
                            </button>
                            <button
                                class="tab-btn py-4 px-6 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                <i class="fas fa-check-circle mr-2"></i> Résolus
                            </button>
                            <button
                                class="tab-btn py-4 px-6 text-sm font-medium text-center border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                <i class="fas fa-clock mr-2"></i> En attente
                            </button>
                        </nav>
                    </div>

                    <!-- Comments list -->
                    <div class="divide-y divide-gray-200" id="comments-container">
                        <!-- Comment 1 (Important) -->
                        <div class="comment-card comment-important p-6 fade-in" data-category="encadrant important">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <span class="tag tag-important mr-2">
                                        <i class="fas fa-exclamation-circle mr-1"></i> Important
                                    </span>
                                    <span class="tag tag-encadrant">
                                        <i class="fas fa-user-tie mr-1"></i> Encadrant
                                    </span>
                                </div>
                                <span class="text-sm text-gray-500">15/10/2023</span>
                            </div>
                            <h3 class="font-bold text-lg text-gray-800 mb-2">Problème de méthodologie</h3>
                            <div class="prose max-w-none text-gray-600 mb-4">
                                <p>La méthodologie employée dans le chapitre 3 n'est pas suffisamment détaillée. Il
                                    manque une justification claire des choix méthodologiques et une description plus
                                    précise des outils utilisés.</p>
                                <p class="mt-2">Veuillez ajouter :</p>
                                <ul class="list-disc pl-5 mt-1">
                                    <li>Un tableau comparatif des méthodes envisagées</li>
                                    <li>Une justification du choix final</li>
                                    <li>Les limites de la méthode choisie</li>
                                </ul>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Page: 45</span>
                                    <span class="mx-2 text-gray-400">•</span>
                                    <span class="text-sm font-medium text-gray-700">Version: 1.2</span>
                                </div>
                                <div class="flex space-x-2">
                                    <button
                                        class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm hover:bg-green-200 transition">
                                        <i class="fas fa-check mr-1"></i> Marquer comme résolu
                                    </button>
                                    <button
                                        class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm hover:bg-blue-200 transition">
                                        <i class="fas fa-reply mr-1"></i> Répondre
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Comment 2 (Jury) -->
                        <div class="comment-card comment-jury p-6 fade-in" data-category="jury">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <span class="tag tag-jury">
                                        <i class="fas fa-users mr-1"></i> Jury
                                    </span>
                                </div>
                                <span class="text-sm text-gray-500">22/10/2023</span>
                            </div>
                            <h3 class="font-bold text-lg text-gray-800 mb-2">Précision des résultats</h3>
                            <div class="prose max-w-none text-gray-600 mb-4">
                                <p>Les résultats présentés dans la section 4.2 nécessitent plus de précision. Certains
                                    chiffres semblent arrondis sans justification. Veuillez :</p>
                                <ul class="list-disc pl-5 mt-1">
                                    <li>Ajouter les valeurs exactes avec leurs décimales</li>
                                    <li>Préciser les unités de mesure</li>
                                    <li>Inclure les intervalles de confiance le cas échéant</li>
                                </ul>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Page: 78-79</span>
                                    <span class="mx-2 text-gray-400">•</span>
                                    <span class="text-sm font-medium text-gray-700">Version: 1.5</span>
                                </div>
                                <div class="flex space-x-2">
                                    <button
                                        class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm hover:bg-green-200 transition">
                                        <i class="fas fa-check mr-1"></i> Marquer comme résolu
                                    </button>
                                    <button
                                        class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm hover:bg-blue-200 transition">
                                        <i class="fas fa-reply mr-1"></i> Répondre
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Comment 3 (Encadrant) -->
                        <div class="comment-card comment-encadrant p-6 fade-in" data-category="encadrant">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <span class="tag tag-encadrant">
                                        <i class="fas fa-user-tie mr-1"></i> Encadrant
                                    </span>
                                </div>
                                <span class="text-sm text-gray-500">28/10/2023</span>
                            </div>
                            <h3 class="font-bold text-lg text-gray-800 mb-2">Bibliographie incomplète</h3>
                            <div class="prose max-w-none text-gray-600 mb-4">
                                <p>La bibliographie ne mentionne pas plusieurs références importantes dans le domaine.
                                    Veuillez ajouter au minimum les 5 références suivantes :</p>
                                <ol class="list-decimal pl-5 mt-1">
                                    <li>Smith et al. (2020) - "Advances in Research Methods"</li>
                                    <li>Johnson (2019) - "Modern Approaches to..."</li>
                                    <li>Brown (2018) - Journal of Applied Sciences</li>
                                    <li>Taylor & Wilson (2021) - Conference Proceedings</li>
                                    <li>Lee (2017) - "Methodological Considerations"</li>
                                </ol>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Annexe B</span>
                                    <span class="mx-2 text-gray-400">•</span>
                                    <span class="text-sm font-medium text-gray-700">Version: 2.0</span>
                                </div>
                                <div class="flex space-x-2">
                                    <button
                                        class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm cursor-default">
                                        <i class="fas fa-check mr-1"></i> Résolu
                                    </button>
                                    <button
                                        class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm hover:bg-blue-200 transition">
                                        <i class="fas fa-reply mr-1"></i> Répondre
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Comment 4 (Important - Jury) -->
                        <div class="comment-card comment-important p-6 fade-in" data-category="jury important">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <span class="tag tag-important mr-2">
                                        <i class="fas fa-exclamation-circle mr-1"></i> Important
                                    </span>
                                    <span class="tag tag-jury">
                                        <i class="fas fa-users mr-1"></i> Jury
                                    </span>
                                </div>
                                <span class="text-sm text-gray-500">02/11/2023</span>
                            </div>
                            <h3 class="font-bold text-lg text-gray-800 mb-2">Modification structurelle requise</h3>
                            <div class="prose max-w-none text-gray-600 mb-4">
                                <p>La structure du chapitre 5 doit être revue pour améliorer la logique de présentation.
                                    Nous suggérons de :</p>
                                <ul class="list-disc pl-5 mt-1">
                                    <li>Déplacer la section 5.3 avant la section 5.1</li>
                                    <li>Fusionner les sections 5.4 et 5.5</li>
                                    <li>Ajouter un sous-chapitre pour les perspectives futures</li>
                                </ul>
                                <p class="mt-2">Cette modification est essentielle pour la clarté de votre
                                    argumentation.</p>
                            </div>
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Chapitre 5</span>
                                    <span class="mx-2 text-gray-400">•</span>
                                    <span class="text-sm font-medium text-gray-700">Version: 2.1</span>
                                </div>
                                <div class="flex space-x-2">
                                    <button
                                        class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm hover:bg-green-200 transition">
                                        <i class="fas fa-check mr-1"></i> Marquer comme résolu
                                    </button>
                                    <button
                                        class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm hover:bg-blue-200 transition">
                                        <i class="fas fa-reply mr-1"></i> Répondre
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Legend -->
                <div class="mt-6 bg-white rounded-xl shadow-md p-4">
                    <div class="flex flex-wrap items-center justify-center gap-4">
                        <div class="flex items-center">
                            <span class="marker marker-encadrant"></span>
                            <span class="text-sm text-gray-700">Commentaire encadrant</span>
                        </div>
                        <div class="flex items-center">
                            <span class="marker marker-jury"></span>
                            <span class="text-sm text-gray-700">Commentaire jury</span>
                        </div>
                        <div class="flex items-center">
                            <span class="marker marker-important"></span>
                            <span class="text-sm text-gray-700">Commentaire important</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const sidebar = document.querySelector('.hidden.md\\:flex.md\\:flex-shrink-0');

        if (mobileMenuButton && sidebar) {
            mobileMenuButton.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');
                sidebar.classList.toggle('absolute');
                sidebar.classList.toggle('z-20');
            });
        }

        // Filter comments
        const filterButtons = document.querySelectorAll('.filter-btn');
        const comments = document.querySelectorAll('.comment-card');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active', 'bg-green-500',
                    'text-white'));
                filterButtons.forEach(btn => {
                    if (!btn.classList.contains('active')) {
                        const color = btn.classList.contains('bg-blue-100') ? 'blue' :
                            btn.classList.contains('bg-green-100') ? 'green' :
                            btn.classList.contains('bg-red-100') ? 'red' : 'gray';
                        btn.classList.add(`bg-${color}-100`, `text-${color}-800`);
                    }
                });

                // Add active class to clicked button
                this.classList.add('active', 'bg-green-500', 'text-white');
                this.classList.remove('bg-blue-100', 'text-blue-800', 'bg-green-100',
                    'text-green-800', 'bg-red-100', 'text-red-800');

                const filter = this.getAttribute('data-filter');

                comments.forEach(comment => {
                    const categories = comment.getAttribute('data-category').split(' ');

                    if (filter === 'all' || categories.includes(filter)) {
                        comment.style.display = 'block';
                    } else {
                        comment.style.display = 'none';
                    }
                });
            });
        });

        // Tab switching
        const tabButtons = document.querySelectorAll('.tab-btn');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                tabButtons.forEach(btn => btn.classList.remove('active', 'border-green-500',
                    'text-green-600'));
                tabButtons.forEach(btn => btn.classList.add('border-transparent',
                    'text-gray-500'));

                this.classList.add('active', 'border-green-500', 'text-green-600');
                this.classList.remove('border-transparent', 'text-gray-500');

                // In a real app, you would load different comments here
                // For this demo, we're just showing all comments
                comments.forEach(comment => comment.style.display = 'block');
            });
        });

        // Mark as resolved
        const resolveButtons = document.querySelectorAll('[class*="bg-green-100"]:not(.cursor-default)');

        resolveButtons.forEach(button => {
            button.addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-check mr-1"></i> Résolu';
                this.classList.remove('bg-green-100', 'text-green-700', 'hover:bg-green-200');
                this.classList.add('bg-gray-100', 'text-gray-700', 'cursor-default');

                // Find the parent comment card
                let card = this.closest('.comment-card');
                if (card) {
                    card.classList.remove('comment-important');
                    card.classList.add('opacity-75');
                }
            });
        });
    });
    </script>
</body>

</html>