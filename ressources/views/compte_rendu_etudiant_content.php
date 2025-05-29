<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Rendu | Soutenance Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #f0fff4 0%, #e6fffa 100%);
        }
        .progress-ring__circle {
            transition: stroke-dashoffset 0.35s;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .document-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 border-r border-gray-200 bg-white">
                <div class="flex items-center justify-center h-16 px-4 bg-green-100 shadow-sm">
                    <div class="flex overflow-hidden items-center">
                        <a href="?page=dashboard" class="text-green-500 font-bold text-xl">Soutenance Manager</a>
                    </div>
                </div>
                <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto">
                    <div class="space-y-2 pb-3">
                        <a href="?page=candidature_soutenance" class="flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-graduation-cap mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Candidater à la soutenance
                        </a>
                        <a href="?page=gestion_rapport" class="flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-file mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Gestion des rapports/mémoires
                        </a>
                        <a href="?page=gestion_reclamations" class="flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-circle-exclamation mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Réclamations
                        </a>
                        <a href="?page=notes_resultats" class="flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-note-sticky mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Notes & résultats
                        </a>
                        <a href="?page=messagerie" class="flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-envelope mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Messagerie
                        </a>
                        <a href="?page=profil" class="flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-user mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Profil
                        </a>
                        <a href="" class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                            <i class="fas fa-power-off mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Déconnexion
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top navigation -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 bg-green-100 shadow-sm">
                <div class="flex items-center">
                    <button id="mobileMenuButton" class="md:hidden text-gray-500 focus:outline-none mr-3">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="text-lg font-medium text-green-500">Compte rendu de la commission</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="flex items-center space-x-2 focus:outline-none">
                            <span class="text-m font-medium text-green-500">Bienvenue, Étudiant</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <div class="flex-1 p-4 md:p-6 overflow-y-auto gradient-bg">
                <div class="max-w-6xl mx-auto">
                    <!-- Header -->
                    <div class="mb-8 text-center fade-in">
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">Compte rendu de la commission</h1>
                        <p class="text-gray-600 max-w-2xl mx-auto">Voici le détail de l'évaluation de votre dossier par la commission pédagogique.</p>
                    </div>

                    <!-- Status Card -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8 fade-in">
                        <div class="p-6 md:p-8">
                            <div class="flex flex-col md:flex-row items-center">
                                <div class="w-full md:w-1/3 mb-6 md:mb-0 flex justify-center">
                                    <div class="relative w-32 h-32">
                                        <svg class="w-full h-full" viewBox="0 0 100 100">
                                            <!-- Background circle -->
                                            <circle class="text-gray-200" stroke-width="8" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50" />
                                            <!-- Progress circle -->
                                            <circle class="text-green-500" stroke-width="8" stroke-dasharray="251.2" stroke-dashoffset="75.36" stroke-linecap="round" stroke="currentColor" fill="transparent" r="40" cx="50" cy="50" />
                                        </svg>
                                        <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center">
                                            <span class="text-2xl font-bold text-gray-800">70%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full md:w-2/3 md:pl-8">
                                    <h2 class="text-xl font-semibold text-gray-800 mb-2">Statut de votre candidature</h2>
                                    <div class="mb-4">
                                        <div class="flex items-center mb-2">
                                            <span class="inline-block w-3 h-3 rounded-full bg-green-500 mr-2"></span>
                                            <span class="text-gray-700">Dossier complet</span>
                                        </div>
                                        <div class="flex items-center mb-2">
                                            <span class="inline-block w-3 h-3 rounded-full bg-yellow-500 mr-2"></span>
                                            <span class="text-gray-700">En attente de validation finale</span>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="inline-block w-3 h-3 rounded-full bg-red-500 mr-2"></span>
                                            <span class="text-gray-700">Rapport à finaliser</span>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 mb-4">Votre dossier est en cours d'évaluation par la commission. Vous recevrez une notification dès que la décision finale sera prise.</p>
                                    <div class="flex space-x-3">
                                        <button class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                                            <i class="fas fa-download mr-2"></i>Télécharger le rapport
                                        </button>
                                        <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                                            <i class="fas fa-question-circle mr-2"></i>Aide
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Evaluation Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Criteria Evaluation -->
                        <div class="bg-white rounded-xl shadow-md overflow-hidden fade-in" style="animation-delay: 0.1s;">
                            <div class="p-6">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-clipboard-check text-green-500 mr-2"></i>Critères d'évaluation
                                </h2>
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-gray-700">Qualité du mémoire</span>
                                            <span class="text-gray-700">8/10</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: 80%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-gray-700">Originalité du sujet</span>
                                            <span class="text-gray-700">7/10</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: 70%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-gray-700">Méthodologie</span>
                                            <span class="text-gray-700">6/10</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-yellow-500 h-2 rounded-full" style="width: 60%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-gray-700">Présentation</span>
                                            <span class="text-gray-700">9/10</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: 90%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Comments -->
                        <div class="bg-white rounded-xl shadow-md overflow-hidden fade-in" style="animation-delay: 0.2s;">
                            <div class="p-6">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-comment-alt text-blue-500 mr-2"></i>Commentaires de la commission
                                </h2>
                                <div class="space-y-4">
                                    <div class="bg-blue-50 p-4 rounded-lg">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-user-circle text-blue-400 text-xl"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Pr. Dupont</p>
                                                <p class="text-sm text-gray-600">"Le sujet est très pertinent et bien traité. La bibliographie pourrait être plus complète."</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-green-50 p-4 rounded-lg">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-user-circle text-green-400 text-xl"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Dr. Martin</p>
                                                <p class="text-sm text-gray-600">"Excellente présentation des résultats. Les conclusions pourraient être plus développées."</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-purple-50 p-4 rounded-lg">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-user-circle text-purple-400 text-xl"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Mme. Leroy</p>
                                                <p class="text-sm text-gray-600">"La méthodologie est solide mais manque de détails sur certains points techniques."</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Documents Section -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8 fade-in" style="animation-delay: 0.3s;">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-file-alt text-indigo-500 mr-2"></i>Documents associés
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Document 1 -->
                                <div class="document-card bg-gray-50 rounded-lg p-4 border border-gray-200 transition duration-300 ease-in-out hover:shadow-md">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 bg-indigo-100 p-3 rounded-lg">
                                            <i class="fas fa-file-pdf text-indigo-500 text-xl"></i>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-sm font-medium text-gray-900">Rapport d'évaluation</h3>
                                            <p class="text-xs text-gray-500">PDF • 1.2 MB</p>
                                            <div class="mt-2">
                                                <button class="text-xs text-indigo-600 hover:text-indigo-800 flex items-center">
                                                    <i class="fas fa-download mr-1"></i>Télécharger
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Document 2 -->
                                <div class="document-card bg-gray-50 rounded-lg p-4 border border-gray-200 transition duration-300 ease-in-out hover:shadow-md">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 bg-blue-100 p-3 rounded-lg">
                                            <i class="fas fa-file-word text-blue-500 text-xl"></i>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-sm font-medium text-gray-900">Corrections à apporter</h3>
                                            <p class="text-xs text-gray-500">DOCX • 350 KB</p>
                                            <div class="mt-2">
                                                <button class="text-xs text-blue-600 hover:text-blue-800 flex items-center">
                                                    <i class="fas fa-download mr-1"></i>Télécharger
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Document 3 -->
                                <div class="document-card bg-gray-50 rounded-lg p-4 border border-gray-200 transition duration-300 ease-in-out hover:shadow-md">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 bg-green-100 p-3 rounded-lg">
                                            <i class="fas fa-file-excel text-green-500 text-xl"></i>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-sm font-medium text-gray-900">Grille d'évaluation</h3>
                                            <p class="text-xs text-gray-500">XLSX • 580 KB</p>
                                            <div class="mt-2">
                                                <button class="text-xs text-green-600 hover:text-green-800 flex items-center">
                                                    <i class="fas fa-download mr-1"></i>Télécharger
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Next Steps -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden fade-in" style="animation-delay: 0.4s;">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-list-check text-orange-500 mr-2"></i>Prochaines étapes
                            </h2>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex items-center justify-center h-6 w-6 rounded-full bg-green-100">
                                            <i class="fas fa-check text-green-500 text-xs"></i>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Dossier soumis</p>
                                        <p class="text-sm text-gray-500">15/05/2023</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex items-center justify-center h-6 w-6 rounded-full bg-green-100">
                                            <i class="fas fa-check text-green-500 text-xs"></i>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Examen par la commission</p>
                                        <p class="text-sm text-gray-500">22/05/2023</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex items-center justify-center h-6 w-6 rounded-full bg-blue-100">
                                            <i class="fas fa-spinner text-blue-500 text-xs animate-spin"></i>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Validation finale</p>
                                        <p class="text-sm text-gray-500">En cours</p>
                                    </div>
                                </div>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex items-center justify-center h-6 w-6 rounded-full bg-gray-100">
                                            <span class="text-gray-500 text-xs">4</span>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Notification de la décision</p>
                                        <p class="text-sm text-gray-500">À venir</p>
                                    </div>
                                </div>
                            </div>
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
            const sidebar = document.querySelector('.hidden.md\\:flex.md\\:flex-shrink-0 > .flex.flex-col.w-64');

            if (mobileMenuButton && sidebar) {
                mobileMenuButton.addEventListener('click', function() {
                    sidebar.classList.toggle('hidden');
                    sidebar.classList.toggle('absolute');
                    sidebar.classList.toggle('z-20');
                });
            }

            // Document card hover effect
            const documentCards = document.querySelectorAll('.document-card');
            documentCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
                });
            });

            // Animate progress ring
            const progressRing = document.querySelector('.progress-ring__circle');
            if (progressRing) {
                const radius = progressRing.r.baseVal.value;
                const circumference = radius * 2 * Math.PI;
                progressRing.style.strokeDasharray = circumference;
                progressRing.style.strokeDashoffset = circumference - (70 / 100) * circumference;
            }
        });
    </script>
</body>
</html>