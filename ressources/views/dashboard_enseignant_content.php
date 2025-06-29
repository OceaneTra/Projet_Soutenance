<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Enseignant</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    .stat-card {
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .chart-container {
        position: relative;
        height: 300px;
    }

    .metric-value {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #10b981, #059669);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .trend-up {
        color: #10b981;
    }

    .trend-down {
        color: #ef4444;
    }

    .trend-stable {
        color: #6b7280;
    }
    </style>
</head>

<body class="font-sans bg-[#F8F7FA] text-gray-600 leading-relaxed p-5">

    <div class="container mx-auto px-4 max-w-screen-xl">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-gray-900 text-3xl font-bold">Bonjour, Professeur!</h1>
                <p class="text-gray-400 text-sm mt-1">Bienvenue à nouveau sur votre tableau de bord.</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right">
                    <p class="text-sm text-gray-500"><?php echo date('d/m/Y'); ?></p>
                    <p class="text-sm text-gray-400"><?php echo date('H:i'); ?></p>
                </div>
            </div>
        </div>

        <!-- Statistiques principales -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Cours Enseignés -->
            <div class="stat-card bg-gradient-to-br from-orange-300 to-amber-400 rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-white text-sm font-medium">Cours Enseignés</h3>
                    <i class="fas fa-chalkboard-teacher text-white text-xl opacity-80"></i>
                </div>
                <div class="text-white text-3xl font-bold mb-2">
                    <?php echo $GLOBALS['total_cours'] ?? 0; ?>
                </div>
                <div class="text-white text-xs opacity-80">
                    <i class="fas fa-arrow-up mr-1"></i>
                    +12% ce mois
                </div>
            </div>

            <!-- Travaux à Évaluer -->
            <div class="stat-card bg-gradient-to-br from-green-400 to-teal-500 rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-white text-sm font-medium">Travaux à Évaluer</h3>
                    <i class="fas fa-clipboard-list text-white text-xl opacity-80"></i>
                </div>
                <div class="text-white text-3xl font-bold mb-2">
                    <?php echo $GLOBALS['total_evaluations_a_faire'] ?? 0; ?>
                </div>
                <div class="text-white text-xs opacity-80">
                    <i class="fas fa-clock mr-1"></i>
                    En attente
                </div>
            </div>

            <!-- Étudiants Encadrés -->
            <div class="stat-card bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-white text-sm font-medium">Étudiants Encadrés</h3>
                    <i class="fas fa-users text-white text-xl opacity-80"></i>
                </div>
                <div class="text-white text-3xl font-bold mb-2">
                    <?php echo $GLOBALS['total_etudiants_encadres'] ?? 0; ?>
                </div>
                <div class="text-white text-xs opacity-80">
                    <i class="fas fa-graduation-cap mr-1"></i>
                    En suivi
                </div>
            </div>

            <!-- Évaluations Terminées -->
            <div class="stat-card bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl shadow-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-white text-sm font-medium">Évaluations Terminées</h3>
                    <i class="fas fa-check-circle text-white text-xl opacity-80"></i>
                </div>
                <div class="text-white text-3xl font-bold mb-2">
                    <?php echo $GLOBALS['total_evaluations_terminees'] ?? 0; ?>
                </div>
                <div class="text-white text-xs opacity-80">
                    <i class="fas fa-percentage mr-1"></i>
                    <?php echo $GLOBALS['progression_evaluations'] ?? 0; ?>% complété
                </div>
            </div>
        </div>

        <!-- Graphiques et statistiques avancées -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Graphique des évaluations par mois -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-gray-900 text-lg font-semibold mb-4">
                    <i class="fas fa-chart-line text-blue-500 mr-2"></i>
                    Évaluations par mois
                </h3>
                <div class="chart-container">
                    <canvas id="evaluationsChart"></canvas>
                </div>
            </div>

            <!-- Graphique des types d'évaluations -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-gray-900 text-lg font-semibold mb-4">
                    <i class="fas fa-chart-pie text-green-500 mr-2"></i>
                    Types d'évaluations
                </h3>
                <div class="chart-container">
                    <canvas id="typesEvaluationsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Performance des cours et notes moyennes -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Performance des cours -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-gray-900 text-lg font-semibold mb-4">
                    <i class="fas fa-trophy text-yellow-500 mr-2"></i>
                    Performance des cours
                </h3>
                <div class="space-y-4">
                    <?php if (!empty($GLOBALS['performance_cours'])): ?>
                    <?php foreach (array_slice($GLOBALS['performance_cours'], 0, 5) as $cours): ?>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900"><?php echo htmlspecialchars($cours['nom_cours']); ?>
                            </h4>
                            <p class="text-sm text-gray-500"><?php echo htmlspecialchars($cours['niveau']); ?></p>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-gray-900">
                                <?php echo number_format($cours['moyenne_cours'], 1); ?>/20
                            </div>
                            <div class="text-xs text-gray-500">
                                <?php echo $cours['nombre_etudiants']; ?> étudiants
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <div class="text-center text-gray-500 py-8">
                        <i class="fas fa-chart-bar text-4xl mb-4"></i>
                        <p>Aucune donnée de performance disponible</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Répartition des étudiants par niveau -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-gray-900 text-lg font-semibold mb-4">
                    <i class="fas fa-users text-purple-500 mr-2"></i>
                    Étudiants par niveau
                </h3>
                <div class="chart-container">
                    <canvas id="etudiantsNiveauChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Graphiques supplémentaires -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Statistiques des rapports -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-gray-900 text-lg font-semibold mb-4">
                    <i class="fas fa-file-alt text-indigo-500 mr-2"></i>
                    Statistiques des rapports
                </h3>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="text-center p-4 bg-indigo-50 rounded-lg">
                        <div class="text-2xl font-bold text-indigo-600">
                            <?php echo $GLOBALS['stats_rapports']['total_rapports'] ?? 0; ?>
                        </div>
                        <div class="text-sm text-indigo-500">Total rapports</div>
                    </div>
                    <div class="text-center p-4 bg-green-50 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">
                            <?php echo $GLOBALS['stats_rapports']['rapports_valides'] ?? 0; ?>
                        </div>
                        <div class="text-sm text-green-500">Validés</div>
                    </div>
                    <div class="text-center p-4 bg-yellow-50 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600">
                            <?php echo $GLOBALS['stats_rapports']['rapports_en_cours'] ?? 0; ?>
                        </div>
                        <div class="text-sm text-yellow-500">En cours</div>
                    </div>
                    <div class="text-center p-4 bg-red-50 rounded-lg">
                        <div class="text-2xl font-bold text-red-600">
                            <?php echo $GLOBALS['stats_rapports']['rapports_rejetes'] ?? 0; ?>
                        </div>
                        <div class="text-sm text-red-500">Rejetés</div>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="rapportsChart"></canvas>
                </div>
            </div>

            <!-- Distribution des notes -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-gray-900 text-lg font-semibold mb-4">
                    <i class="fas fa-chart-bar text-teal-500 mr-2"></i>
                    Distribution des notes
                </h3>
                <div class="chart-container">
                    <canvas id="distributionNotesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Échéances et activités récentes -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Échéances prochaines -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-gray-900 text-lg font-semibold mb-4">
                    <i class="fas fa-calendar-alt text-red-500 mr-2"></i>
                    Échéances prochaines
                </h3>
                <div class="space-y-3">
                    <?php if (!empty($GLOBALS['echeances_prochaines'])): ?>
                    <?php foreach (array_slice($GLOBALS['echeances_prochaines'], 0, 5) as $echeance): ?>
                    <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">
                                <?php echo htmlspecialchars($echeance['nom_cours']); ?></h4>
                            <p class="text-sm text-gray-500">
                                <?php echo htmlspecialchars($echeance['type_evaluation']); ?></p>
                        </div>
                        <div class="text-right">
                            <div
                                class="text-sm font-medium <?php echo $echeance['jours_restants'] <= 3 ? 'text-red-600' : 'text-gray-900'; ?>">
                                <?php echo $echeance['jours_restants']; ?> jours
                            </div>
                            <div class="text-xs text-gray-500">
                                <?php echo date('d/m/Y', strtotime($echeance['date_limite'])); ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <div class="text-center text-gray-500 py-8">
                        <i class="fas fa-calendar-check text-4xl mb-4"></i>
                        <p>Aucune échéance prochaine</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Activités récentes -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-gray-900 text-lg font-semibold mb-4">
                    <i class="fas fa-history text-indigo-500 mr-2"></i>
                    Activités récentes
                </h3>
                <div class="space-y-3">
                    <?php if (!empty($GLOBALS['activites_recentes'])): ?>
                    <?php foreach (array_slice($GLOBALS['activites_recentes'], 0, 5) as $activite): ?>
                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="flex-shrink-0">
                            <i
                                class="fas fa-circle text-xs <?php echo $activite['type'] === 'rapport' ? 'text-blue-500' : 'text-green-500'; ?>"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-gray-900"><?php echo htmlspecialchars($activite['description']); ?>
                            </p>
                            <p class="text-xs text-gray-500"><?php echo $activite['date']; ?></p>
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
        </div>

        <!-- Mes cours -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-gray-900 text-xl font-bold mb-4 pb-3 border-b border-gray-200">
                <i class="fas fa-book text-blue-500 mr-2"></i>
                Mes Cours
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php if (!empty($GLOBALS['mes_cours'])): ?>
                <?php foreach ($GLOBALS['mes_cours'] as $cours): ?>
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-gray-900 font-semibold"><?php echo htmlspecialchars($cours['nom']); ?></h3>
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">
                            <?php echo htmlspecialchars($cours['niveau']); ?>
                        </span>
                    </div>
                    <p class="text-gray-500 text-sm mb-3"><?php echo $cours['nombre_etudiants']; ?> étudiants inscrits
                    </p>
                    <button
                        class="w-full bg-blue-500 text-white text-sm font-medium px-4 py-2 rounded-md hover:bg-blue-600 transition-colors">
                        Voir cours
                    </button>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="col-span-full text-center text-gray-500 py-8">
                    <i class="fas fa-chalkboard-teacher text-4xl mb-4"></i>
                    <p>Aucun cours assigné</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Scripts pour les graphiques -->
    <script>
    // Données pour les graphiques (à remplacer par les vraies données PHP)
    const evaluationsData = <?php echo json_encode($GLOBALS['evaluations_par_mois'] ?? []); ?>;
    const typesEvaluationsData = <?php echo json_encode($GLOBALS['types_evaluations'] ?? []); ?>;
    const etudiantsNiveauData = <?php echo json_encode($GLOBALS['etudiants_par_niveau'] ?? []); ?>;
    const distributionNotesData = <?php echo json_encode($GLOBALS['distribution_notes'] ?? []); ?>;

    // Graphique des évaluations par mois
    const evaluationsCtx = document.getElementById('evaluationsChart').getContext('2d');
    new Chart(evaluationsCtx, {
        type: 'line',
        data: {
            labels: evaluationsData.map(item => {
                const mois = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct',
                    'Nov', 'Déc'
                ];
                return mois[item.mois - 1];
            }),
            datasets: [{
                label: 'Évaluations créées',
                data: evaluationsData.map(item => item.nombre_evaluations),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4
            }, {
                label: 'Évaluations terminées',
                data: evaluationsData.map(item => item.evaluations_terminees),
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Graphique des types d'évaluations
    const typesCtx = document.getElementById('typesEvaluationsChart').getContext('2d');
    new Chart(typesCtx, {
        type: 'doughnut',
        data: {
            labels: typesEvaluationsData.map(item => item.type_evaluation),
            datasets: [{
                data: typesEvaluationsData.map(item => item.nombre),
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(251, 191, 36, 0.8)',
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(168, 85, 247, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Graphique des étudiants par niveau
    const etudiantsCtx = document.getElementById('etudiantsNiveauChart').getContext('2d');
    new Chart(etudiantsCtx, {
        type: 'bar',
        data: {
            labels: etudiantsNiveauData.map(item => item.niveau),
            datasets: [{
                label: 'Nombre d\'étudiants',
                data: etudiantsNiveauData.map(item => item.nombre_etudiants),
                backgroundColor: 'rgba(168, 85, 247, 0.8)',
                borderColor: 'rgb(168, 85, 247)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Graphique des rapports
    const rapportsCtx = document.getElementById('rapportsChart').getContext('2d');
    new Chart(rapportsCtx, {
        type: 'doughnut',
        data: {
            labels: ['En attente', 'En cours', 'Validés', 'Rejetés'],
            datasets: [{
                data: [
                    <?php echo $GLOBALS['stats_rapports']['rapports_en_attente'] ?? 0; ?>,
                    <?php echo $GLOBALS['stats_rapports']['rapports_en_cours'] ?? 0; ?>,
                    <?php echo $GLOBALS['stats_rapports']['rapports_valides'] ?? 0; ?>,
                    <?php echo $GLOBALS['stats_rapports']['rapports_rejetes'] ?? 0; ?>
                ],
                backgroundColor: [
                    'rgba(251, 191, 36, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderColor: [
                    'rgb(251, 191, 36)',
                    'rgb(59, 130, 246)',
                    'rgb(34, 197, 94)',
                    'rgb(239, 68, 68)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });

    // Graphique de distribution des notes
    const distributionCtx = document.getElementById('distributionNotesChart').getContext('2d');
    new Chart(distributionCtx, {
        type: 'bar',
        data: {
            labels: ['0-5', '6-10', '11-15', '16-20'],
            datasets: [{
                label: 'Nombre d\'étudiants',
                data: distributionNotesData.map(item => item.nombre_etudiants),
                backgroundColor: [
                    'rgba(239, 68, 68, 0.8)',
                    'rgba(251, 191, 36, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(34, 197, 94, 0.8)'
                ],
                borderColor: [
                    'rgb(239, 68, 68)',
                    'rgb(251, 191, 36)',
                    'rgb(59, 130, 246)',
                    'rgb(34, 197, 94)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Nombre d\'étudiants'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Notes (/20)'
                    }
                }
            }
        }
    });

    // Fonction pour rafraîchir les données en temps réel
    function refreshStats() {
        fetch('?page=dashboard_enseignant&action=get_stats')
            .then(response => response.json())
            .then(data => {
                if (data.stats) {
                    // Mise à jour des statistiques
                    document.querySelector('.bg-gradient-to-br.from-orange-300 .text-3xl').textContent = data.stats
                        .cours.total || 0;
                    document.querySelector('.bg-gradient-to-br.from-green-400 .text-3xl').textContent = data.stats
                        .evaluations.a_faire || 0;
                    document.querySelector('.bg-gradient-to-br.from-blue-400 .text-3xl').textContent = data.stats
                        .etudiants.encadres || 0;
                    document.querySelector('.bg-gradient-to-br.from-purple-400 .text-3xl').textContent = data.stats
                        .evaluations.terminees || 0;
                }
            })
            .catch(error => console.error('Erreur lors du rafraîchissement:', error));
    }

    // Rafraîchir les données toutes les 30 secondes
    setInterval(refreshStats, 30000);
    </script>
</body>

</html>