<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Enseignant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>

<body class="font-sans bg-[#F8F7FA] text-gray-600 leading-relaxed p-5">

    <div class="container mx-auto px-4 max-w-screen-lg">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-gray-900 text-3xl font-bold">Bonjour, Professeur!</h1>
                <p class="text-gray-400 text-sm mt-1">Bienvenue à nouveau sur votre tableau de bord.</p>
            </div>
            <!-- User Profile -->
            <div class="flex items-center bg-white px-3 py-2 rounded-full shadow-sm text-sm font-medium">
                <img src="https://www.gravatar.com/avatar/?d=mp" alt="User Avatar" class="w-8 h-8 rounded-full mr-2">
                <span class="text-gray-800">Nom de l'enseignant</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="lg:col-span-3">
                <!-- Overview Stats Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-5 mb-6">
                    <!-- Courses Taught Card -->
                    <div
                        class="bg-gradient-to-br from-orange-300 to-amber-400 rounded-xl shadow-md p-5 flex flex-col justify-between transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-lg min-h-[100px]">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-white text-sm font-medium">Cours Enseignés</h3>
                            <i class="fas fa-chalkboard-teacher text-white text-xl opacity-80"></i>
                        </div>
                        <div class="text-white text-3xl font-bold">
                            <p>4</p>
                        </div>
                    </div>
                    <!-- Assignments to Evaluate Card -->
                    <div
                        class="bg-gradient-to-br from-green-400 to-teal-500 rounded-xl shadow-md p-5 flex flex-col justify-between transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-lg min-h-[100px]">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-white text-sm font-medium">Travaux à Évaluer</h3>
                            <i class="fas fa-clipboard-list text-white text-xl opacity-80"></i>
                        </div>
                        <div class="text-white text-3xl font-bold">
                            <p>12</p>
                        </div>
                    </div>
                    <!-- Students Supervised Card -->
                    <div
                        class="bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-md p-5 flex flex-col justify-between transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-lg min-h-[100px]">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-white text-sm font-medium">Étudiants Encadrés</h3>
                            <i class="fas fa-users text-white text-xl opacity-80"></i>
                        </div>
                        <div class="text-white text-3xl font-bold">
                            <p>7</p>
                        </div>
                    </div>
                    <!-- Evaluations Completed Card -->
                    <div
                        class="bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl shadow-md p-5 flex flex-col justify-between transition-transform duration-300 ease-in-out hover:scale-105 hover:shadow-lg min-h-[100px]">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="text-white text-sm font-medium">Évaluations Terminées</h3>
                            <i class="fas fa-check-circle text-white text-xl opacity-80"></i>
                        </div>
                        <div class="text-white text-3xl font-bold">
                            <p>35</p>
                        </div>
                    </div>
                </div>

                <!-- Progress/Summary Section -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6 flex items-center space-x-6">
                    <div class="relative w-20 h-20 flex items-center justify-center">
                        <!-- Outer circle for background -->
                        <div class="absolute inset-0 rounded-full bg-gray-200"></div>
                        <!-- Progress circle (example: 78%) -->
                        <!-- This would typically be dynamic based on actual data -->
                        <div class="absolute inset-0 rounded-full"
                            style="background: conic-gradient(#34C759 78%, transparent 0%);"></div>
                        <!-- Inner circle to mask -->
                        <div
                            class="relative z-10 bg-white w-[calc(100%-16px)] h-[calc(100%-16px)] rounded-full flex items-center justify-center text-gray-900 text-xl font-bold">
                            <span>78%</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-gray-900 text-lg font-semibold mb-1">Progression des Évaluations</h3>
                        <p class="text-gray-500 text-sm">Pour le semestre en cours</p>
                        <div class="flex space-x-4 mt-3 text-sm">
                            <div class="flex items-center">
                                <span class="inline-block w-3 h-3 rounded-full bg-green-500 mr-1"></span> Terminées: 35
                            </div>
                            <div class="flex items-center">
                                <span class="inline-block w-3 h-3 rounded-full bg-blue-500 mr-1"></span> Restantes: 10
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Time Spent Chart Placeholder -->
                <div
                    class="bg-white rounded-xl shadow-md p-6 mb-6 text-center min-h-[200px] flex flex-col justify-center items-center text-gray-400">
                    <i class="fas fa-chart-line text-4xl mb-4"></i>
                    <p class="text-lg">Graphique de l'activité ou du temps passé (À intégrer)</p>
                </div>


                <!-- Recent Activities Section -->
                <div class="dashboard-section bg-white rounded-xl shadow-md p-6 mb-6">
                    <h2 class="text-gray-900 text-xl font-bold mb-4 pb-3 border-b border-gray-200">Activités Récentes
                    </h2>
                    <div class="space-y-4">
                        <!-- Example item (replace with dynamic data) -->
                        <div
                            class="flex justify-between items-center flex-wrap gap-4 pb-4 border-b border-gray-200 last:border-b-0">
                            <div class="flex-1">
                                <h3 class="text-gray-900 text-base font-semibold">Nouveau rapport soumis par Jean Dupont
                                    (Base de Données)</h3>
                                <p class="text-gray-500 text-sm mt-1">Soumis le 15 Mai 2024</p>
                            </div>
                            <div class="flex-shrink-0">
                                <button
                                    class="bg-white border border-gray-300 text-gray-700 text-sm font-medium px-4 py-2 rounded-md transition-colors duration-200 hover:bg-gray-100">Évaluer</button>
                            </div>
                        </div>
                        <div
                            class="flex justify-between items-center flex-wrap gap-4 pb-4 border-b border-gray-200 last:border-b-0">
                            <div class="flex-1">
                                <h3>5 nouveaux devoirs soumis pour le cours de Réseaux</h3>
                                <p class="text-gray-500 text-sm mt-1">Dernière soumission le 14 Mai 2024</p>
                            </div>
                            <div class="flex-shrink-0">
                                <button
                                    class="bg-white border border-gray-300 text-gray-700 text-sm font-medium px-4 py-2 rounded-md transition-colors duration-200 hover:bg-gray-100">Voir
                                    devoirs</button>
                            </div>
                        </div>
                        <div
                            class="flex justify-between items-center flex-wrap gap-4 pb-4 border-b border-gray-200 last:border-b-0">
                            <div class="flex-1">
                                <h3>Demande de rendez-vous de Lucie Durand</h3>
                                <p class="text-gray-500 text-sm mt-1">Reçue le 14 Mai 2024</p>
                            </div>
                            <div class="flex-shrink-0">
                                <button
                                    class="bg-white border border-gray-300 text-gray-700 text-sm font-medium px-4 py-2 rounded-md transition-colors duration-200 hover:bg-gray-100">Voir
                                    message</button>
                            </div>
                        </div>
                        <!-- Add more recent activities here -->
                    </div>
                </div>

                <!-- My Courses Section -->
                <div class="dashboard-section bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-gray-900 text-xl font-bold mb-4 pb-3 border-b border-gray-200">Mes Cours</h2>
                    <div class="space-y-4">
                        <!-- Example item (replace with dynamic data) -->
                        <div
                            class="flex justify-between items-center flex-wrap gap-4 pb-4 border-b border-gray-200 last:border-b-0">
                            <div class="flex-1">
                                <h3 class="text-gray-900 text-base font-semibold">Base de Données Avancées (M2)</h3>
                                <p class="text-gray-500 text-sm mt-1">35 étudiants inscrits</p>
                            </div>
                            <div class="flex-shrink-0">
                                <button
                                    class="bg-white border border-gray-300 text-gray-700 text-sm font-medium px-4 py-2 rounded-md transition-colors duration-200 hover:bg-gray-100">Voir
                                    cours</button>
                            </div>
                        </div>
                        <div
                            class="flex justify-between items-center flex-wrap gap-4 pb-4 border-b border-gray-200 last:border-b-0">
                            <div class="flex-1">
                                <h3>Programmation Web (L3)</h3>
                                <p class="text-gray-500 text-sm mt-1">50 étudiants inscrits</p>
                            </div>
                            <div class="flex-shrink-0">
                                <button
                                    class="bg-white border border-gray-300 text-gray-700 text-sm font-medium px-4 py-2 rounded-md transition-colors duration-200 hover:bg-gray-100">Voir
                                    cours</button>
                            </div>
                        </div>
                        <!-- Add more courses here -->
                    </div>
                </div>

            </div>

            <div class="lg:col-span-1">
                <!-- My Schedule / Upcoming Deadlines Section -->
                <div class="dashboard-section bg-white rounded-xl shadow-md p-6 mb-6">
                    <h2 class="text-gray-900 text-xl font-bold mb-4 pb-3 border-b border-gray-200">Mon Calendrier</h2>
                    <div class="space-y-4">
                        <!-- Example Schedule Items -->
                        <div class="flex items-center space-x-3 p-3 bg-gray-100 rounded-lg shadow-sm">
                            <i class="fas fa-calendar-alt text-orange-500 text-lg"></i>
                            <div class="flex-1">
                                <h4 class="text-gray-900 text-sm font-semibold">Date limite d'évaluation - Rapport BD
                                </h4>
                                <p class="text-gray-500 text-xs mt-0.5">18 Mai 2024</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-3 bg-gray-100 rounded-lg shadow-sm">
                            <i class="fas fa-calendar-alt text-green-500 text-lg"></i>
                            <div class="flex-1">
                                <h4 class="text-gray-900 text-sm font-semibold">Réunion d'équipe pédagogique</h4>
                                <p class="text-gray-500 text-xs mt-0.5">20 Mai 2024</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-3 bg-gray-100 rounded-lg shadow-sm">
                            <i class="fas fa-calendar-alt text-blue-500 text-lg"></i>
                            <div class="flex-1">
                                <h4 class="text-gray-900 text-sm font-semibold">Soutenance de stage - Projet Alpha</h4>
                                <p class="text-gray-500 text-xs mt-0.5">25 Mai 2024</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Optional: Quick Links or other relevant teacher info -->
                <div class="dashboard-section bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-gray-900 text-xl font-bold mb-4 pb-3 border-b border-gray-200">Liens Rapides</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center pb-4 border-b border-gray-200 last:border-b-0">
                            <div>
                                <h3 class="text-gray-900 text-base font-semibold">Ajouter une note</h3>
                            </div>
                            <div>
                                <button class="text-gray-500 hover:text-gray-700 transition-colors duration-200"><i
                                        class="fas fa-chevron-right"></i></button>
                            </div>
                        </div>
                        <div class="flex justify-between items-center pb-4 border-b border-gray-200 last:border-b-0">
                            <div>
                                <h3 class="text-gray-900 text-base font-semibold">Voir les étudiants</h3>
                            </div>
                            <div>
                                <button class="text-gray-500 hover:text-gray-700 transition-colors duration-200"><i
                                        class="fas fa-chevron-right"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</body>

</html>