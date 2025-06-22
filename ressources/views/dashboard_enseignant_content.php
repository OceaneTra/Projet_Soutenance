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
                            <p><?php echo $GLOBALS['total_cours'] ?? 0; ?></p>
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
                            <p><?php echo $GLOBALS['total_evaluations_a_faire'] ?? 0; ?></p>
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
                            <p><?php echo $GLOBALS['total_etudiants_encadres'] ?? 0; ?></p>
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
                            <p><?php echo $GLOBALS['total_evaluations_terminees'] ?? 0; ?></p>
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
                            style="background: conic-gradient(#34C759 <?php echo $GLOBALS['progression_evaluations'] ?? 0; ?>%, transparent 0%);">
                        </div>
                        <!-- Inner circle to mask -->
                        <div
                            class="relative z-10 bg-white w-[calc(100%-16px)] h-[calc(100%-16px)] rounded-full flex items-center justify-center text-gray-900 text-xl font-bold">
                            <span><?php echo $GLOBALS['progression_evaluations'] ?? 0; ?>%</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-gray-900 text-lg font-semibold mb-1">Progression des Évaluations</h3>
                        <p class="text-gray-500 text-sm">Pour le semestre en cours</p>
                        <div class="flex space-x-4 mt-3 text-sm">
                            <div class="flex items-center">
                                <span class="inline-block w-3 h-3 rounded-full bg-green-500 mr-1"></span> Terminées:
                                <?php echo $GLOBALS['total_evaluations_terminees'] ?? 0; ?>
                            </div>
                            <div class="flex items-center">
                                <span class="inline-block w-3 h-3 rounded-full bg-blue-500 mr-1"></span> Restantes:
                                <?php echo $GLOBALS['total_evaluations_a_faire'] ?? 0; ?>
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
                        <?php if (!empty($GLOBALS['activites_recentes'])): ?>
                        <?php foreach ($GLOBALS['activites_recentes'] as $activite): ?>
                        <div
                            class="flex justify-between items-center flex-wrap gap-4 pb-4 border-b border-gray-200 last:border-b-0">
                            <div class="flex-1">
                                <h3 class="text-gray-900 text-base font-semibold">
                                    <?php echo htmlspecialchars($activite['description']); ?></h3>
                                <p class="text-gray-500 text-sm mt-1"><?php echo htmlspecialchars($activite['date']); ?>
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <button
                                    class="bg-white border border-gray-300 text-gray-700 text-sm font-medium px-4 py-2 rounded-md transition-colors duration-200 hover:bg-gray-100"><?php echo htmlspecialchars($activite['action']); ?></button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="text-center text-gray-500 py-8">
                            <i class="fas fa-inbox text-4xl mb-4"></i>
                            <p>Aucune activité récente</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- My Courses Section -->
                <div class="dashboard-section bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-gray-900 text-xl font-bold mb-4 pb-3 border-b border-gray-200">Mes Cours</h2>
                    <div class="space-y-4">
                        <?php if (!empty($GLOBALS['mes_cours'])): ?>
                        <?php foreach ($GLOBALS['mes_cours'] as $cours): ?>
                        <div
                            class="flex justify-between items-center flex-wrap gap-4 pb-4 border-b border-gray-200 last:border-b-0">
                            <div class="flex-1">
                                <h3 class="text-gray-900 text-base font-semibold">
                                    <?php echo htmlspecialchars($cours['nom']); ?>
                                    (<?php echo htmlspecialchars($cours['niveau']); ?>)</h3>
                                <p class="text-gray-500 text-sm mt-1"><?php echo $cours['nombre_etudiants']; ?>
                                    étudiants inscrits</p>
                            </div>
                            <div class="flex-shrink-0">
                                <button
                                    class="bg-white border border-gray-300 text-gray-700 text-sm font-medium px-4 py-2 rounded-md transition-colors duration-200 hover:bg-gray-100">Voir
                                    cours</button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="text-center text-gray-500 py-8">
                            <i class="fas fa-chalkboard-teacher text-4xl mb-4"></i>
                            <p>Aucun cours assigné</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-1">
                <!-- My Schedule / Upcoming Deadlines Section -->
                <div class="dashboard-section bg-white rounded-xl shadow-md p-6 mb-6">
                    <h2 class="text-gray-900 text-xl font-bold mb-4 pb-3 border-b border-gray-200">Mon Calendrier</h2>
                    <div class="space-y-4">
                        <?php if (!empty($GLOBALS['calendrier'])): ?>
                        <?php foreach ($GLOBALS['calendrier'] as $evenement): ?>
                        <div class="flex items-center space-x-3 p-3 bg-gray-100 rounded-lg shadow-sm">
                            <i
                                class="fas fa-calendar-alt text-<?php echo $evenement['couleur'] ?? 'blue'; ?>-500 text-lg"></i>
                            <div class="flex-1">
                                <h4 class="text-gray-900 text-sm font-semibold">
                                    <?php echo htmlspecialchars($evenement['titre']); ?></h4>
                                <p class="text-gray-500 text-xs mt-0.5">
                                    <?php echo date('d/m/Y', strtotime($evenement['date'])); ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="text-center text-gray-500 py-4">
                            <i class="fas fa-calendar text-2xl mb-2"></i>
                            <p class="text-sm">Aucun événement à venir</p>
                        </div>
                        <?php endif; ?>
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
                        <div class="flex justify-between items-center pb-4 border-b border-gray-200 last:border-b-0">
                            <div>
                                <h3 class="text-gray-900 text-base font-semibold">Évaluer les rapports</h3>
                                <?php if (($GLOBALS['total_rapports_a_evaluer'] ?? 0) > 0): ?>
                                <span
                                    class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full ml-2">
                                    <?php echo $GLOBALS['total_rapports_a_evaluer']; ?>
                                </span>
                                <?php endif; ?>
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

    <!-- Script pour rafraîchir les données en temps réel -->
    <script>
    // Fonction pour rafraîchir les statistiques
    function refreshStats() {
        fetch('?page=dashboard_enseignant&action=get_stats')
            .then(response => response.json())
            .then(data => {
                // Mise à jour des statistiques
                if (data.stats) {
                    // Mise à jour des cartes de statistiques
                    document.querySelector('.bg-gradient-to-br.from-orange-300 .text-3xl p').textContent = data
                        .stats.cours.total || 0;
                    document.querySelector('.bg-gradient-to-br.from-green-400 .text-3xl p').textContent = data.stats
                        .evaluations.a_faire || 0;
                    document.querySelector('.bg-gradient-to-br.from-blue-400 .text-3xl p').textContent = data.stats
                        .etudiants.encadres || 0;
                    document.querySelector('.bg-gradient-to-br.from-purple-400 .text-3xl p').textContent = data
                        .stats.evaluations.terminees || 0;

                    // Mise à jour de la progression
                    const progressionElement = document.querySelector(
                        '.bg-white.w-\\[calc\\(100\\%-16px\\)\\] span');
                    if (progressionElement) {
                        progressionElement.textContent = (data.stats.evaluations.progression || 0) + '%';
                    }
                }
            })
            .catch(error => console.error('Erreur lors du rafraîchissement:', error));
    }

    // Rafraîchir les données toutes les 30 secondes
    setInterval(refreshStats, 30000);
    </script>
</body>

</html>