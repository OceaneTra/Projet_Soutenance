<!DOCTYPE html>
<?php
require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/controllers/DashboardScolariteController.php';

$dashboardController = new DashboardScolariteController();
$dashboardData = $dashboardController->getDashboardData();

$stats = $dashboardData['stats'];
$activites = $dashboardData['activites'];
?>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsable Scolarité | Tableau de bord</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
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

    .hover-scale {
        transition: transform 0.3s ease;
    }

    .hover-scale:hover {
        transform: scale(1.03);
    }

    .gradient-blue {
        background: linear-gradient(135deg, #60A5FA 0%, #3B82F6 100%);
    }

    .gradient-green {
        background: linear-gradient(135deg, #34D399 0%, #10B981 100%);
    }

    .gradient-yellow {
        background: linear-gradient(135deg, #FBBF24 0%, #F59E0B 100%);
    }

    .gradient-red {
        background: linear-gradient(135deg, #F87171 0%, #EF4444 100%);
    }

    .gradient-purple {
        background: linear-gradient(135deg, #A78BFA 0%, #8B5CF6 100%);
    }

    .gradient-orange {
        background: linear-gradient(135deg, #FB923C 0%, #F97316 100%);
    }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Main content area -->
        <div class="flex-1 p-4 md:p-6 overflow-y-auto">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Tableau de bord Scolarité</h1>

                <!-- Statistiques principales -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white p-4 rounded-lg shadow-sm hover-scale">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Étudiants inscrits</p>
                                <p class="text-2xl font-bold text-gray-800">
                                    <?php echo number_format($stats['etudiants']); ?></p>
                                <p class="text-xs text-gray-500">Total des inscriptions</p>
                            </div>
                            <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-sm hover-scale">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Nouvelles inscriptions</p>
                                <p class="text-2xl font-bold text-gray-800">
                                    <?php echo number_format($stats['nouvelles_inscriptions']); ?></p>
                                <p class="text-xs text-gray-500">7 derniers jours</p>
                            </div>
                            <div class="p-3 rounded-full bg-green-100 text-green-500">
                                <i class="fas fa-user-plus text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-sm hover-scale">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Notes à valider</p>
                                <p class="text-2xl font-bold text-gray-800">
                                    <?php echo number_format($stats['notes_a_valider']); ?></p>
                                <p class="text-xs text-gray-500">En attente de validation</p>
                            </div>
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                                <i class="fas fa-graduation-cap text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-sm hover-scale">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Paiements en attente</p>
                                <p class="text-2xl font-bold text-gray-800">
                                    <?php echo number_format($stats['paiements_en_attente']); ?></p>
                                <p class="text-xs text-gray-500">Total:
                                    <?php echo number_format($stats['montant_total_paiements'], 2); ?>€</p>
                            </div>
                            <div class="p-3 rounded-full bg-red-100 text-red-500">
                                <i class="fas fa-euro-sign text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Graphiques et statistiques détaillées -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Graphique des inscriptions par niveau -->
                    <div class="lg:col-span-2 bg-white p-4 rounded-lg shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Inscriptions par niveau d'études</h2>
                        <canvas id="inscriptionsChart" height="300"></canvas>
                    </div>

                    <!-- Activités récentes -->
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Activités récentes</h2>
                        <div class="space-y-4">
                            <?php foreach($activites as $activite): ?>
                            <div class="flex items-start">
                                <div
                                    class="flex-shrink-0 h-10 w-10 rounded-full bg-<?php echo $activite['couleur']; ?>-100 flex items-center justify-center text-<?php echo $activite['couleur']; ?>-500 mr-3">
                                    <i class="fas <?php echo $activite['icone']; ?>"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">
                                        <?php echo htmlspecialchars($activite['titre']); ?></p>
                                    <p class="text-xs text-gray-500">
                                        <?php echo htmlspecialchars($activite['description']); ?></p>
                                    <p class="text-xs text-gray-400"><?php echo $activite['date_activite']; ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Statistiques supplémentaires -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <!-- Statistiques des paiements -->
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Statistiques des paiements</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 rounded-lg gradient-blue text-white">
                                <p class="text-sm font-medium">Paiements validés</p>
                                <p class="text-2xl font-bold">
                                    <?php echo number_format($stats['paiements_valides'] ?? 0); ?></p>
                            </div>
                            <div class="p-4 rounded-lg gradient-red text-white">
                                <p class="text-sm font-medium">Paiements en retard</p>
                                <p class="text-2xl font-bold">
                                    <?php echo number_format($stats['paiements_retard'] ?? 0); ?></p>
                            </div>
                            <div class="p-4 rounded-lg gradient-green text-white">
                                <p class="text-sm font-medium">Montant total perçu</p>
                                <p class="text-2xl font-bold">
                                    <?php echo number_format($stats['montant_percu'] ?? 0, 2); ?>€</p>
                            </div>
                            <div class="p-4 rounded-lg gradient-yellow text-white">
                                <p class="text-sm font-medium">Montant en attente</p>
                                <p class="text-2xl font-bold">
                                    <?php echo number_format($stats['montant_attente'] ?? 0, 2); ?>€</p>
                            </div>
                        </div>
                    </div>

                    <!-- Statistiques des notes -->
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Statistiques des notes</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="p-4 rounded-lg gradient-purple text-white">
                                <p class="text-sm font-medium">Moyenne générale</p>
                                <p class="text-2xl font-bold">
                                    <?php echo number_format($stats['moyenne_generale'] ?? 0, 2); ?>/20</p>
                            </div>
                            <div class="p-4 rounded-lg gradient-orange text-white">
                                <p class="text-sm font-medium">Taux de réussite</p>
                                <p class="text-2xl font-bold">
                                    <?php echo number_format($stats['taux_reussite'] ?? 0, 1); ?>%</p>
                            </div>
                            <div class="p-4 rounded-lg gradient-green text-white">
                                <p class="text-sm font-medium">Notes validées</p>
                                <p class="text-2xl font-bold">
                                    <?php echo number_format($stats['notes_validees'] ?? 0); ?></p>
                            </div>
                            <div class="p-4 rounded-lg gradient-red text-white">
                                <p class="text-sm font-medium">Notes en attente</p>
                                <p class="text-2xl font-bold">
                                    <?php echo number_format($stats['notes_en_attente'] ?? 0); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Configuration du graphique des inscriptions
    const ctx = document.getElementById('inscriptionsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['L1', 'L2', 'L3', 'M1', 'M2'],
            datasets: [{
                label: 'Nombre d\'inscriptions',
                data: [65, 59, 80, 81, 56],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.5)',
                    'rgba(16, 185, 129, 0.5)',
                    'rgba(245, 158, 11, 0.5)',
                    'rgba(139, 92, 246, 0.5)',
                    'rgba(239, 68, 68, 0.5)'
                ],
                borderColor: [
                    'rgb(59, 130, 246)',
                    'rgb(16, 185, 129)',
                    'rgb(245, 158, 11)',
                    'rgb(139, 92, 246)',
                    'rgb(239, 68, 68)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
    </script>
</body>

</html>