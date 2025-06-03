<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des rapports</title>

</head>

<body class="min-h-screen">


    <section class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
        <!-- Carte 1: Créer un rapport -->
        <div class="card rounded-xl overflow-hidden shadow-lg text-white cursor-pointer">
            <div class="p-6 flex flex-col items-center card-gradient-1">
                <div class="icon-container card-gradient-1 bg-opacity-20 p-5 rounded-full mb-6">
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
                        <a href="?page=gestion_rapports&action=creer_rapport">Commencer</a>
                    </button>
                </div>
            </div>
            <div class="bg-gradient-to-r from-white to-transparent bg-opacity-10 h-1"></div>
            <div class="px-6 py-4 bg-indigo-500 bg-opacity-10">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-white text-opacity-70">Facile à utiliser</span>
                    <span class="text-xs font-medium bg-indigo-800 px-2 py-1 rounded-full">Étape 1</span>
                </div>
            </div>
        </div>

        <!-- Carte 2: Suivre l'avancée -->
        <div class="card rounded-xl overflow-hidden shadow-lg text-white cursor-pointer">
            <div class="p-6 flex flex-col items-center card-gradient-2">
                <div class="icon-container card-gradient-2 bg-opacity-20 p-5 rounded-full mb-6">
                    <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="white">
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
                        <a href="?page=gestion_rapports&action=suivi_rapport">Consulter</a>
                    </button>
                </div>
            </div>
            <div class="bg-gradient-to-r from-white to-transparent bg-opacity-10 h-1"></div>
            <div class="px-6 py-4 bg-green-500 bg-opacity-10">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-white text-opacity-70">En temps réel</span>
                    <span class="text-xs font-medium bg-green-800 px-2 py-1 rounded-full">Étape 2</span>
                </div>
            </div>
        </div>

        <!-- Carte 3: Consulter les commentaires -->
        <div class="card rounded-xl overflow-hidden shadow-lg text-white cursor-pointer">
            <div class="p-6 flex flex-col items-center card-gradient-3">
                <div class="icon-container card-gradient-3 bg-opacity-20 p-5 rounded-full mb-6">
                    <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Consulter les commentaires</h3>
                <p class="text-white text-opacity-80 mb-6 text-center">Accédez aux retours détaillés des
                    évaluateurs pour améliorer votre travail académique.</p>
                <div class="mt-auto">
                    <button
                        class="bg-white text-yellow-700 font-semibold py-2 px-6 rounded-lg hover:bg-opacity-90 transition duration-300 pulse">
                        <a href="?page=gestion_rapports&action=compte_rendu_rapport"> Voir les retours</a>

                    </button>
                </div>
            </div>
            <div class="bg-gradient-to-r from-white to-transparent bg-opacity-10 h-1"></div>
            <div class="px-6 py-4 bg-yellow-500 bg-opacity-10">
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
                                <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
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
                                <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </span>
                            <h3 class="font-medium text-gray-900">Vérification initiale</h3>
                            <p class="text-sm text-gray-500">vérification de son admissibilité et respect des normes
                                formelles</p>
                        </li>
                        <li class="ml-6">
                            <span
                                class="absolute flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full -left-4 ring-4 ring-white">
                                <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
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

            </div>
        </div>
    </section>





    <script>
    document.addEventListener('DOMContentLoaded', () => {


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
                            `Section "${title}" - Cette fonctionnalité sera bientôt disponible`
                        );
                    }
                });
            });
        });
    });
    </script>
</body>

</html>