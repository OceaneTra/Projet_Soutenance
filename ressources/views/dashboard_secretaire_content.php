<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Secrétariat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f3f4f6;
        /* bg-gray-100 */
    }

    /* Styles personnalisés pour les dégradés et les couleurs spécifiques */
    .sidebar-bg {
        background: linear-gradient(135deg, #7c3aed, #9a67ea);
        /* from-purple-600 to-purple-400 */
    }

    .card-red-gradient {
        background: linear-gradient(135deg, #ef4444, #f87171);
        /* from-red-500 to-red-400 */
    }

    .card-orange-gradient {
        background: linear-gradient(135deg, #fb923c, #fdba74);
        /* from-orange-400 to-orange-300 */
    }

    .chart-placeholder {
        background-color: #f9fafb;
        /* bg-gray-50 */
        border-radius: 0.75rem;
        /* rounded-xl */
    }

    .donut-chart-segment-1 {
        background-color: #8b5cf6;
        /* violet-500 */
    }

    .donut-chart-segment-2 {
        background-color: #6366f1;
        /* indigo-500 */
    }

    .donut-chart-segment-3 {
        background-color: #fcd34d;
        /* amber-300 */
    }

    .donut-chart-segment-4 {
        background-color: #f87171;
        /* red-400 */
    }

    /* Simulation du graphique en anneau (donut chart) avec des divs concentriques pour l'effet visuel */
    .donut-chart-container {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: conic-gradient(#8b5cf6 0% 45%,
                /* Violet-500 */
                #6366f1 45% 65%,
                /* Indigo-500 */
                #fcd34d 65% 85%,
                /* Amber-300 */
                #f87171 85% 100%
                /* Red-400 */
            );
        position: relative;
    }

    .donut-chart-inner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90px;
        /* Ajuster la taille du trou central */
        height: 90px;
        background-color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }
    </style>
</head>

<body class="flex min-h-screen">

    <!-- Barre latérale -->
    <aside
        class="sidebar-bg w-20 md:w-64 flex flex-col items-center py-6 px-2 md:px-4 rounded-r-3xl shadow-xl z-10 transition-all duration-300">
        <div class="mb-10 text-white">
            <!-- Icône Logo Nuage -->
            <svg class="h-10 w-10 md:h-12 md:w-12" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M10 2a8 8 0 100 16A8 8 0 0010 2zm0-2a10 10 0 110 20 10 10 0 010-20zM6 10a4 4 0 108 0 4 4 0 00-8 0z">
                </path>
            </svg>
        </div>
        <nav class="flex-grow w-full space-y-4">
            <!-- Tableau de bord (Actif) -->
            <a href="#"
                class="flex flex-col md:flex-row items-center md:justify-start md:space-x-3 p-2 md:p-3 bg-white bg-opacity-30 rounded-xl text-white font-medium shadow-md">
                <svg class="w-6 h-6 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L14 11.586V8a6 6 0 00-6-6zM12 15.5V14H8v1.5a2 2 0 104 0z">
                    </path>
                </svg>
                <span class="text-xs md:text-sm hidden md:block">Tableau de bord</span>
            </a>
            <!-- Autres éléments de navigation (Icônes de remplacement) -->
            <a href="#"
                class="flex flex-col md:flex-row items-center md:justify-start md:space-x-3 p-2 md:p-3 rounded-xl text-white text-opacity-80 hover:bg-white hover:bg-opacity-20 transition-colors duration-200">
                <svg class="w-6 h-6 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="text-xs md:text-sm hidden md:block">Étudiants</span>
            </a>
            <a href="#"
                class="flex flex-col md:flex-row items-center md:justify-start md:space-x-3 p-2 md:p-3 rounded-xl text-white text-opacity-80 hover:bg-white hover:bg-opacity-20 transition-colors duration-200">
                <svg class="w-6 h-6 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zm3 7a1 1 0 000 2h6a1 1 0 100-2H7z">
                    </path>
                </svg>
                <span class="text-xs md:text-sm hidden md:block">Cours</span>
            </a>
            <a href="#"
                class="flex flex-col md:flex-row items-center md:justify-start md:space-x-3 p-2 md:p-3 rounded-xl text-white text-opacity-80 hover:bg-white hover:bg-opacity-20 transition-colors duration-200">
                <svg class="w-6 h-6 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                    <path fill-rule="evenodd"
                        d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586l-1.414-1.414A.999.999 0 0010 3.536V2h2V1H8v1.536l-1.414 1.414A.999 0 004 5zM12 7a2 2 0 11-4 0 2 2 0 014 0z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="text-xs md:text-sm hidden md:block">Diplômes</span>
            </a>
            <a href="#"
                class="flex flex-col md:flex-row items-center md:justify-start md:space-x-3 p-2 md:p-3 rounded-xl text-white text-opacity-80 hover:bg-white hover:bg-opacity-20 transition-colors duration-200">
                <svg class="w-6 h-6 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 00-2.286.948c-.07.455-.434.786-.937.893a1.532 1.532 0 00-1.579.577 1.532 1.532 0 00-.766 1.43zM10 18a8 8 0 100-16 8 8 0 000 16z"
                        clip-rule="evenodd"></path>
                </svg>
                <span class="text-xs md:text-sm hidden md:block">Paramètres</span>
            </a>
        </nav>
        <div class="mt-auto pt-6 border-t border-white border-opacity-30 w-full flex flex-col items-center">
            <img class="h-10 w-10 md:h-12 md:w-12 rounded-full ring-2 ring-white ring-opacity-50"
                src="https://placehold.co/128x128/9a67ea/ffffff?text=U" alt="Avatar Utilisateur">
            <span class="text-white text-sm font-medium mt-2 hidden md:block">Secrétaire</span>
        </div>
    </aside>

    <!-- Contenu principal -->
    <main class="flex-1 p-6 md:p-8">
        <!-- En-tête -->
        <header class="flex items-center justify-between mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Tableau de bord Secrétariat</h1>
            <div class="flex items-center space-x-4 text-gray-600 text-sm">
                <span>10-06-2020</span>
                <span class="text-gray-400">|</span>
                <span>10-10-2020</span>
                <!-- Peuvent être des sélecteurs de dates réels -->
            </div>
        </header>

        <!-- Cartes de statistiques -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Carte 1: Total Étudiants Inscrits -->
            <div class="bg-white p-6 rounded-xl shadow-lg flex items-center space-x-4">
                <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">1789</div>
                    <div class="text-gray-500 text-sm">Étudiants Inscrits au total</div>
                </div>
            </div>
            <!-- Carte 2: Étudiants Actifs -->
            <div class="bg-white p-6 rounded-xl shadow-lg flex items-center space-x-4">
                <div class="bg-green-100 p-3 rounded-full text-green-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M6.267 18.257a1 1 0 001.314.192l5.06-3.795a1 1 0 000-1.512l-5.06-3.795a1 1 0 00-1.314.192A4 4 0 002 9c0 2.21 1.79 4 4 4a4 4 0 004-4c0-.98-.36-1.898-.975-2.617a1 1 0 00-1.314-.192l-5.06 3.795a1 1 0 000 1.512l5.06 3.795a1 1 0 001.314.192zM17 10a1 1 0 100-2h-1a1 1 0 100 2h1z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">1530</div>
                    <div class="text-gray-500 text-sm">Étudiants Actifs</div>
                </div>
            </div>
            <!-- Carte 3: Demandes d'Admission (Dégradé rouge) -->
            <div class="card-red-gradient p-6 rounded-xl shadow-lg flex items-center space-x-4 text-white">
                <div class="bg-white bg-opacity-30 p-3 rounded-full">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm-7-8a1 1 0 112 0v5a1 1 0 11-2 0v-5zm4 0a1 1 0 112 0v5a1 1 0 11-2 0v-5zm4 0a1 1 0 112 0v5a1 1 0 11-2 0v-5z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold">85+</div>
                    <div class="text-sm text-white text-opacity-80">Demandes d'Admission</div>
                </div>
            </div>
            <!-- Carte 4: Étudiants par Niveau (Dégradé orange) -->
            <div class="card-orange-gradient p-6 rounded-xl shadow-lg flex items-center space-x-4 text-white">
                <div class="bg-white bg-opacity-30 p-3 rounded-full">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M6 6a2 2 0 00-2 2v3a2 2 0 002 2h5a2 2 0 002-2V8a2 2 0 00-2-2H6zm5 3.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold">L3: 600 | M1: 500 | M2: 400</div>
                    <div class="text-sm text-white text-opacity-80">Répartition par Niveau</div>
                </div>
            </div>
        </div>

        <!-- Section Statistiques des Inscriptions & Analytique -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Statistiques des Inscriptions (Gauche) -->
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Statistiques des Inscriptions</h2>
                    <div class="flex space-x-2 text-sm text-gray-600">
                        <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 font-medium">JOURNALIER</span>
                        <span class="px-3 py-1 rounded-full text-gray-600">HEBDOMADAIRE</span>
                        <span class="px-3 py-1 rounded-full text-gray-600">MENSUEL</span>
                        <span class="px-3 py-1 rounded-full text-gray-600">ANNUEL</span>
                    </div>
                </div>

                <div class="flex items-end justify-between mb-4">
                    <div>
                        <div class="text-4xl font-extrabold text-gray-900">120</div>
                        <div class="text-gray-500 text-sm">Nouvelles inscriptions ce mois-ci</div>
                    </div>
                    <div class="text-right">
                        <div class="text-lg font-bold text-gray-900">5</div>
                        <div class="text-gray-500 text-sm">Désinscriptions ce mois-ci</div>
                    </div>
                </div>

                <!-- Espace réservé pour le graphique -->
                <div class="chart-placeholder h-48 md:h-64 mb-6 flex items-center justify-center text-gray-400">
                    <!-- Espace réservé pour un graphique linéaire -->
                    <p>Graphique du Flux d'Inscriptions (Simulation)</p>
                </div>

                <button
                    class="w-full bg-indigo-500 text-white py-3 px-4 rounded-lg font-semibold hover:bg-indigo-600 transition-colors duration-200">
                    Rapport détaillé des inscriptions
                </button>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6 border-t border-gray-200 pt-6">
                    <div class="flex items-center space-x-3">
                        <div class="text-pink-500">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm-7-8a1 1 0 112 0v5a1 1 0 11-2 0v-5zm4 0a1 1 0 112 0v5a1 1 0 11-2 0v-5zm4 0a1 1 0 112 0v5a1 1 0 11-2 0v-5z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-gray-900 font-medium text-sm">Étudiants Licence 3</div>
                            <div class="text-gray-600 text-xs">600 Étudiants</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="text-green-500">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm-7-8a1 1 0 112 0v5a1 1 0 11-2 0v-5zm4 0a1 1 0 112 0v5a1 1 0 11-2 0v-5zm4 0a1 1 0 112 0v5a1 1 0 11-2 0v-5z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-gray-900 font-medium text-sm">Étudiants Master 1</div>
                            <div class="text-gray-600 text-xs">500 Étudiants</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="text-blue-500">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm-7-8a1 1 0 112 0v5a1 1 0 11-2 0v-5zm4 0a1 1 0 112 0v5a1 1 0 11-2 0v-5zm4 0a1 1 0 112 0v5a1 1 0 11-2 0v-5z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-gray-900 font-medium text-sm">Étudiants Master 2</div>
                            <div class="text-gray-600 text-xs">400 Étudiants</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytique (Droite) -->
            <div class="bg-white p-6 rounded-xl shadow-lg flex flex-col items-center">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 text-center">Analytique des Étudiants</h2>
                <div class="donut-chart-container mb-6">
                    <div class="donut-chart-inner">
                        <span class="text-2xl font-bold text-gray-900">80%</span>
                        <span class="text-gray-500 text-xs">Réussite</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm w-full max-w-[200px]">
                    <div class="flex items-center">
                        <span class="w-3 h-3 rounded-full donut-chart-segment-1 mr-2"></span>
                        Présentiel
                    </div>
                    <div class="flex items-center">
                        <span class="w-3 h-3 rounded-full donut-chart-segment-2 mr-2"></span>
                        Alternance
                    </div>
                    <div class="flex items-center">
                        <span class="w-3 h-3 rounded-full donut-chart-segment-3 mr-2"></span>
                        Échange
                    </div>
                    <div class="flex items-center">
                        <span class="w-3 h-3 rounded-full donut-chart-segment-4 mr-2"></span>
                        Diplômés
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Activités Récentes & Suivi des Dossiers -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Activités du Secrétariat (Gauche) -->
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Activités du Secrétariat</h2>
                <div class="space-y-4">
                    <!-- Élément d'activité 1 -->
                    <div class="flex items-start space-x-3">
                        <div
                            class="w-10 h-10 flex-shrink-0 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L14 11.586V8a6 6 0 00-6-6zM12 15.5V14H8v1.5a2 2 0 104 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-900 font-medium">Inscription traitée</p>
                            <p class="text-gray-600 text-sm">Dossier d'inscription de Jean Dupont traité</p>
                            <span class="text-gray-400 text-xs">Il y a 40 minutes</span>
                        </div>
                    </div>
                    <!-- Élément d'activité 2 -->
                    <div class="flex items-start space-x-3">
                        <div
                            class="w-10 h-10 flex-shrink-0 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm-7-8a1 1 0 112 0v5a1 1 0 11-2 0v-5zm4 0a1 1 0 112 0v5a1 1 0 11-2 0v-5zm4 0a1 1 0 112 0v5a1 1 0 11-2 0v-5z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-900 font-medium">Dossier mis à jour</p>
                            <p class="text-gray-600 text-sm">Mise à jour des coordonnées de Marie Curie</p>
                            <span class="text-gray-400 text-xs">Il y a 1 jour</span>
                        </div>
                    </div>
                    <!-- Élément d'activité 3 -->
                    <div class="flex items-start space-x-3">
                        <div
                            class="w-10 h-10 flex-shrink-0 bg-red-100 text-red-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586l-1.414-1.414A.999.999 0 0010 3.536V2h2V1H8v1.536l-1.414 1.414A.999 0 004 5zM12 7a2 2 0 11-4 0 2 2 0 014 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-gray-900 font-medium">Attestation délivrée</p>
                            <p class="text-gray-600 text-sm">Attestation de scolarité pour Paul Dupont</p>
                            <span class="text-gray-400 text-xs">Il y a 40 minutes</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Suivi des Dossiers (Droite) -->
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Suivi des Dossiers</h2>
                <div class="flex mb-4 text-sm border-b border-gray-200">
                    <button class="py-2 px-4 text-gray-700 font-medium border-b-2 border-indigo-500 -mb-px">Demandes
                        récentes</button>
                    <button class="py-2 px-4 text-gray-500 hover:text-gray-700 transition-colors duration-200">Dossiers
                        en attente</button>
                    <button class="py-2 px-4 text-gray-500 hover:text-gray-700 transition-colors duration-200">Dossiers
                        archivés</button>
                </div>

                <div class="mb-4 flex justify-between items-center">
                    <input type="text" placeholder="Rechercher un dossier..."
                        class="p-2 border border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <button
                        class="bg-indigo-500 text-white py-2 px-4 rounded-lg text-sm font-semibold hover:bg-indigo-600 transition-colors duration-200 flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>Nouvelle Demande</span>
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Référence Dossier</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nom Étudiant</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type de Demande</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date Soumission</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">UNI-001A</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">Alice Dupont</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">Inscription L3</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">2023-08-15</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                        En attente
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">UNI-002B</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">Bob Martin</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">Attestation</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">2023-08-10</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Traitée
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">UNI-003C</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">Carla Smith</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">Réinscription M1</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-900">2023-08-18</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        En cours
                                    </span>
                                </td>
                            </tr>
                            <!-- Plus de lignes peuvent être ajoutées ici -->
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex items-center justify-between text-gray-600 text-xs">
                    <span>Affichage de 1 à 20 entrées</span>
                    <div class="flex space-x-1">
                        <button class="p-2 rounded-lg hover:bg-gray-200">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <button class="px-3 py-1 rounded-lg bg-indigo-500 text-white text-sm font-semibold">1</button>
                        <button class="px-3 py-1 rounded-lg hover:bg-gray-200 text-gray-700 text-sm">2</button>
                        <button class="px-3 py-1 rounded-lg hover:bg-gray-200 text-gray-700 text-sm">3</button>
                        <button class="px-3 py-1 rounded-lg hover:bg-gray-200 text-gray-700 text-sm">4</button>
                        <button class="px-3 py-1 rounded-lg hover:bg-gray-200 text-gray-700 text-sm">5</button>
                        <button class="px-3 py-1 rounded-lg hover:bg-gray-200 text-gray-700 text-sm">6</button>
                        <button class="p-2 rounded-lg hover:bg-gray-200">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>