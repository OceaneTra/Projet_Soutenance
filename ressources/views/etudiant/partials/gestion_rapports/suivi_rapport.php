<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi de l'avancé - Soutenance Manager</title>
    <style src="public/css/output.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <style>
    .progress-bar {
        height: 8px;
        border-radius: 4px;
        background-color: #e5e7eb;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.6s ease;
    }

    .timeline-item {
        position: relative;
        padding-left: 2rem;
        margin-bottom: 2rem;
    }

    .timeline-item:before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #e5e7eb;
        border: 4px solid white;
    }

    .timeline-item.completed:before {
        background-color: #10b981;
    }

    .timeline-item.current:before {
        background-color: #3b82f6;
        animation: pulse 2s infinite;
    }

    .timeline-connector {
        position: absolute;
        left: 9px;
        top: 20px;
        bottom: -2rem;
        width: 2px;
        background-color: #e5e7eb;
    }

    .timeline-item:last-child .timeline-connector {
        display: none;
    }

    .timeline-item.completed .timeline-connector {
        background-color: #10b981;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
        }
    }

    .document-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }

    .floating {
        animation: floating 3s ease-in-out infinite;
    }

    @keyframes floating {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-8px);
        }

        100% {
            transform: translateY(0px);
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
                <!-- Header with progress -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="mb-4 md:mb-0">
                            <h2 class="text-2xl font-bold text-gray-800">Rapport de Master</h2>
                            <p class="text-gray-600">Suivi de la validation de votre mémoire</p>
                        </div>
                        <div class="w-full md:w-1/3">
                            <div class="flex justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700">Progression globale</span>
                                <span class="text-sm font-medium text-green-600">60%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill bg-green-500" style="width: 60%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Timeline section -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-6">Processus de validation</h3>

                            <div class="space-y-6">
                                <!-- Étape 1 -->
                                <div class="timeline-item completed">
                                    <div class="timeline-connector"></div>
                                    <div class="bg-white p-4 rounded-lg">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="font-semibold text-gray-800">Dépôt initial</h4>
                                            <span
                                                class="text-xs font-medium bg-green-100 text-green-800 px-2 py-1 rounded-full">Complété</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-3">Vous avez soumis la première version de
                                            votre rapport le 15/10/2023</p>
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            <span>Validé par l'encadrant le 18/10/2023</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Étape 2 -->
                                <div class="timeline-item completed">
                                    <div class="timeline-connector"></div>
                                    <div class="bg-white p-4 rounded-lg">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="font-semibold text-gray-800">Corrections initiales</h4>
                                            <span
                                                class="text-xs font-medium bg-green-100 text-green-800 px-2 py-1 rounded-full">Complété</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-3">Vous avez soumis la version corrigée le
                                            25/10/2023</p>
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                            <span>Validé par le directeur de mémoire le 28/10/2023</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Étape 3 -->
                                <div class="timeline-item current">
                                    <div class="timeline-connector"></div>
                                    <div class="bg-white p-4 rounded-lg">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="font-semibold text-gray-800">Validation administrative</h4>
                                            <span
                                                class="text-xs font-medium bg-blue-100 text-blue-800 px-2 py-1 rounded-full">En
                                                cours</span>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-3">Votre rapport est en cours de vérification
                                            par le service administratif</p>
                                        <div class="flex items-center text-sm text-gray-500">
                                            <i class="fas fa-clock text-blue-500 mr-2"></i>
                                            <span>En attente depuis le 29/10/2023</span>
                                        </div>
                                        <div class="mt-3 text-xs text-gray-500">
                                            <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                                            <span>Délai moyen de traitement : 5 jours ouvrés</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Étape 4 -->
                                <div class="timeline-item">
                                    <div class="bg-white p-4 rounded-lg">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="font-semibold text-gray-800">Examen par le jury</h4>
                                            <span
                                                class="text-xs font-medium bg-gray-100 text-gray-800 px-2 py-1 rounded-full">À
                                                venir</span>
                                        </div>
                                        <p class="text-sm text-gray-600">Cette étape débutera après la validation
                                            administrative</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right sidebar with documents and deadlines -->
                    <div class="lg:col-span-1">
                        <!-- Documents section -->
                        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Documents</h3>
                            <div class="space-y-4">
                                <div
                                    class="document-card border border-gray-200 rounded-lg p-4 transition-all duration-300 hover:shadow-md">
                                    <div class="flex items-start">
                                        <div class="bg-blue-100 p-3 rounded-lg mr-4">
                                            <i class="fas fa-file-pdf text-blue-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-800">Rapport_v2.pdf</h4>
                                            <p class="text-sm text-gray-600">Version soumise le 25/10/2023</p>
                                            <div class="flex space-x-3 mt-2">
                                                <button
                                                    class="text-xs text-blue-600 hover:text-blue-800 flex items-center">
                                                    <i class="fas fa-eye mr-1"></i> Voir
                                                </button>
                                                <button
                                                    class="text-xs text-green-600 hover:text-green-800 flex items-center">
                                                    <i class="fas fa-download mr-1"></i> Télécharger
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div
                                    class="document-card border border-gray-200 rounded-lg p-4 transition-all duration-300 hover:shadow-md">
                                    <div class="flex items-start">
                                        <div class="bg-green-100 p-3 rounded-lg mr-4">
                                            <i class="fas fa-file-word text-green-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-800">Commentaires_encadrant.docx</h4>
                                            <p class="text-sm text-gray-600">Reçu le 18/10/2023</p>
                                            <div class="flex space-x-3 mt-2">
                                                <button
                                                    class="text-xs text-blue-600 hover:text-blue-800 flex items-center">
                                                    <i class="fas fa-eye mr-1"></i> Voir
                                                </button>
                                                <button
                                                    class="text-xs text-green-600 hover:text-green-800 flex items-center">
                                                    <i class="fas fa-download mr-1"></i> Télécharger
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button
                                class="mt-4 w-full bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                                <i class="fas fa-plus mr-2"></i> Ajouter un document
                            </button>
                        </div>

                        <!-- Deadlines section -->
                        <div class="bg-white rounded-xl shadow-md p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Échéances</h3>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="bg-yellow-100 p-2 rounded-full mr-4 mt-1">
                                        <i class="fas fa-exclamation text-yellow-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">Dépôt final</h4>
                                        <p class="text-sm text-gray-600">Date limite : 15/11/2023</p>
                                        <div class="mt-1">
                                            <span
                                                class="text-xs font-medium bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full">Dans
                                                12 jours</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="bg-purple-100 p-2 rounded-full mr-4 mt-1">
                                        <i class="fas fa-calendar-alt text-purple-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">Soutenance</h4>
                                        <p class="text-sm text-gray-600">Date prévue : 05/12/2023</p>
                                        <div class="mt-1">
                                            <span
                                                class="text-xs font-medium bg-purple-100 text-purple-800 px-2 py-1 rounded-full">À
                                                confirmer</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="font-medium text-blue-800 mb-2 flex items-center">
                                    <i class="fas fa-info-circle mr-2"></i> Prochaine étape
                                </h4>
                                <p class="text-sm text-blue-700">
                                    Après la validation administrative, vous recevrez les commentaires du jury pour les
                                    corrections finales.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action buttons -->
                <div class="mt-8 flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <button
                        class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                        <i class="fas fa-sync-alt mr-2"></i> Vérifier les mises à jour
                    </button>
                    <button
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                        <i class="fas fa-question-circle mr-2"></i> Demander de l'aide
                    </button>
                    <button
                        class="flex-1 bg-white border border-gray-300 hover:bg-gray-50 text-gray-800 font-medium py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                        <i class="fas fa-history mr-2"></i> Voir l'historique complet
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation for timeline items
        gsap.from(".timeline-item", {
            duration: 0.8,
            opacity: 0,
            y: 20,
            stagger: 0.2,
            ease: "power2.out"
        });

        // Animation for document cards
        gsap.from(".document-card", {
            duration: 0.6,
            opacity: 0,
            x: -20,
            stagger: 0.15,
            ease: "back.out(1.2)",
            delay: 0.4
        });

        // Floating animation for current step
        gsap.to(".timeline-item.current", {
            y: -5,
            duration: 2,
            repeat: -1,
            yoyo: true,
            ease: "sine.inOut"
        });

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

        // Hover effects for buttons
        const buttons = document.querySelectorAll('button');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                gsap.to(button, {
                    scale: 1.02,
                    duration: 0.2
                });
            });

            button.addEventListener('mouseleave', () => {
                gsap.to(button, {
                    scale: 1,
                    duration: 0.2
                });
            });
        });
    });
    </script>
</body>

</html>