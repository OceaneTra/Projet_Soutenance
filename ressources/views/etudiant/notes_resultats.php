<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plateforme de Validation des Soutenances</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <style>
    .card {
        transition: all 0.3s ease;
        transform: translateY(0);
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
    }

    .icon-container {
        transition: transform 0.5s ease;
    }

    .card:hover .icon-container {
        transform: rotate(360deg);
    }

    .card-gradient-1 {
        background: linear-gradient(135deg, #4338ca, #3b82f6);
    }

    .card-gradient-2 {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .card-gradient-3 {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .pulse {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.05);
            opacity: 0.8;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .floating {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-10px);
        }

        100% {
            transform: translateY(0px);
        }
    }

    body {
        background-color: #f9fafb;
        background-image: radial-gradient(#e5e7eb 1px, transparent 1px);
        background-size: 20px 20px;
    }
    </style>
</head>

<body>
    <div class="min-h-screen flex flex-col">
        <header class="bg-white shadow-md py-4">
            <div class="container mx-auto px-4 flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <svg class="h-10 w-10 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                    <h1 class="text-2xl font-bold text-gray-800">UniMaster</h1>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition duration-300">Accueil</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition duration-300">Tableau de bord</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition duration-300">Calendrier</a>
                    <a href="#" class="text-gray-600 hover:text-indigo-600 transition duration-300">Aide</a>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="relative">
                        <button
                            class="flex items-center space-x-1 bg-gray-100 hover:bg-gray-200 rounded-full py-1 px-3 transition duration-300">
                            <span
                                class="h-8 w-8 rounded-full bg-indigo-600 text-white flex items-center justify-center">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <span class="hidden md:inline text-sm font-medium text-gray-700">Mon compte</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-grow container mx-auto px-4 py-12">
            <section class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Gestion des Rapports de Master</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Plateforme dédiée à la soumission, au suivi et à la
                    validation des rapports de master pour la commission de validation des soutenances.</p>
            </section>

            <section class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Carte 1: Créer un rapport -->
                <div class="card card-gradient-1 rounded-xl overflow-hidden shadow-lg text-white cursor-pointer">
                    <div class="p-6 flex flex-col items-center">
                        <div class="icon-container bg-white bg-opacity-20 p-5 rounded-full mb-6">
                            <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Créer un Rapport</h3>
                        <p class="text-white text-opacity-80 mb-6 text-center">Rédigez et soumettez votre rapport de
                            master directement via notre plateforme sécurisée.</p>
                        <div class="mt-auto">
                            <button
                                class="bg-white text-indigo-700 font-semibold py-2 px-6 rounded-lg hover:bg-opacity-90 transition duration-300 pulse">
                                Commencer
                            </button>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-white to-transparent bg-opacity-10 h-1"></div>
                    <div class="px-6 py-4 bg-black bg-opacity-10">
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-white text-opacity-70">Facile à utiliser</span>
                            <span class="text-xs font-medium bg-indigo-800 px-2 py-1 rounded-full">Étape 1</span>
                        </div>
                    </div>
                </div>

                <!-- Carte 2: Suivre l'avancée -->
                <div class="card card-gradient-2 rounded-xl overflow-hidden shadow-lg text-white cursor-pointer">
                    <div class="p-6 flex flex-col items-center">
                        <div class="icon-container bg-white bg-opacity-20 p-5 rounded-full mb-6">
                            <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Suivre l'Avancée</h3>
                        <p class="text-white text-opacity-80 mb-6 text-center">Surveillez l'état de votre soumission en
                            temps réel à chaque étape du processus de validation.</p>
                        <div class="mt-auto">
                            <button
                                class="bg-white text-green-700 font-semibold py-2 px-6 rounded-lg hover:bg-opacity-90 transition duration-300 floating">
                                Consulter
                            </button>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-white to-transparent bg-opacity-10 h-1"></div>
                    <div class="px-6 py-4 bg-black bg-opacity-10">
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-white text-opacity-70">En temps réel</span>
                            <span class="text-xs font-medium bg-green-800 px-2 py-1 rounded-full">Étape 2</span>
                        </div>
                    </div>
                </div>

                <!-- Carte 3: Consulter les commentaires -->
                <div class="card card-gradient-3 rounded-xl overflow-hidden shadow-lg text-white cursor-pointer">
                    <div class="p-6 flex flex-col items-center">
                        <div class="icon-container bg-white bg-opacity-20 p-5 rounded-full mb-6">
                            <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Consulter les Commentaires</h3>
                        <p class="text-white text-opacity-80 mb-6 text-center">Accédez aux retours détaillés des
                            évaluateurs pour améliorer votre travail académique.</p>
                        <div class="mt-auto">
                            <button
                                class="bg-white text-yellow-700 font-semibold py-2 px-6 rounded-lg hover:bg-opacity-90 transition duration-300 pulse">
                                Voir les retours
                            </button>
                        </div>
                    </div>
                    <div class="bg-gradient-to-r from-white to-transparent bg-opacity-10 h-1"></div>
                    <div class="px-6 py-4 bg-black bg-opacity-10">
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-white text-opacity-70">Retours d'experts</span>
                            <span class="text-xs font-medium bg-yellow-800 px-2 py-1 rounded-full">Étape 3</span>
                        </div>
                    </div>
                </div>
            </section>

            <section class="mt-16 max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Processus de validation</h3>
                    <div class="flex flex-wrap">
                        <div class="w-full md:w-1/2">
                            <ol class="relative border-l border-gray-200 ml-3">
                                <li class="mb-10 ml-6">
                                    <span
                                        class="absolute flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full -left-4 ring-4 ring-white">
                                        <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </span>
                                    <h3 class="font-medium text-gray-900">Dépôt du rapport</h3>
                                    <p class="text-sm text-gray-500">L'étudiant rédige et soumet son rapport dans
                                        l'application</p>
                                </li>
                                <li class="mb-10 ml-6">
                                    <span
                                        class="absolute flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full -left-4 ring-4 ring-white">
                                        <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </span>
                                    <h3 class="font-medium text-gray-900">Vérification initiale</h3>
                                    <p class="text-sm text-gray-500">Contrôle anti-plagiat et respect des normes
                                        formelles</p>
                                </li>
                                <li class="ml-6">
                                    <span
                                        class="absolute flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full -left-4 ring-4 ring-white">
                                        <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                    <h3 class="font-medium text-gray-900">Validation par la commission</h3>
                                    <p class="text-sm text-gray-500">Examen par le jury et autorisation de soutenance
                                    </p>
                                </li>
                            </ol>
                        </div>
                        <div class="w-full md:w-1/2 mt-8 md:mt-0">
                            <div class="bg-blue-50 rounded-lg p-6">
                                <h4 class="font-semibold text-blue-800 mb-3">Statistiques actuelles</h4>
                                <div class="space-y-4">
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-medium text-blue-700">Rapports soumis</span>
                                            <span class="text-sm font-medium text-blue-700">75%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 75%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-medium text-blue-700">Rapports validés</span>
                                            <span class="text-sm font-medium text-blue-700">45%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-green-500 h-2.5 rounded-full" style="width: 45%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-medium text-blue-700">En attente de
                                                révision</span>
                                            <span class="text-sm font-medium text-blue-700">30%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-yellow-500 h-2.5 rounded-full" style="width: 30%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <footer class="bg-gray-800 text-white py-8">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-6 md:mb-0">
                        <div class="flex items-center space-x-2">
                            <svg class="h-8 w-8 text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                            <h2 class="text-xl font-bold">UniMaster</h2>
                        </div>
                        <p class="text-gray-400 mt-2">Plateforme de validation des soutenances de master</p>
                    </div>
                    <div class="flex space-x-6">
                        <a href="#" class="text-gray-300 hover:text-white transition duration-300">
                            Mentions légales
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition duration-300">
                            Contact
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white transition duration-300">
                            Aide
                        </a>
                    </div>
                </div>
                <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                    <p>© 2025 UniMaster - Tous droits réservés</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Animation d'entrée pour les cartes
        gsap.from('.card', {
            duration: 0.8,
            y: 50,
            opacity: 0,
            stagger: 0.2,
            ease: 'power3.out'
        });

        // Animation au survol des boutons
        const buttons = document.querySelectorAll('button');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                gsap.to(button, {
                    scale: 1.05,
                    duration: 0.3
                });
            });

            button.addEventListener('mouseleave', () => {
                gsap.to(button, {
                    scale: 1,
                    duration: 0.3
                });
            });
        });

        // Simulation de clic sur les cartes
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('click', function() {
                const title = this.querySelector('h3').textContent;
                const button = this.querySelector('button');

                // Animation de clic
                gsap.to(this, {
                    scale: 0.95,
                    duration: 0.1,
                    onComplete: () => {
                        gsap.to(this, {
                            scale: 1,
                            duration: 0.3
                        });

                        // Simulation de navigation ou d'ouverture de modal
                        alert(
                            `Section "${title}" - Cette fonctionnalité sera bientôt disponible`);
                    }
                });
            });
        });
    });
    </script>
</body>

</html>