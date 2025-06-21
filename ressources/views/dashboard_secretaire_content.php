<?php
if (!isset($stats) || !is_array($stats)) {
    $stats = [
        'etudiants' => 0,
        'enseignants' => 0,
        'rapports' => 0,
        'reclamations' => 0,
        'candidatures' => 0,
        'archives' => 0,
    ];
}
if (!isset($activites) || !is_array($activites)) {
    $activites = [];
}
// ... code existant ...
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Secrétariat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    body {
        background: linear-gradient(120deg, #e0e7ff 0%, #f0fdfa 100%);
        min-height: 100vh;
    }

    .hover-scale {
        transition: transform 0.3s cubic-bezier(.4, 2, .6, 1);
    }

    .hover-scale:hover {
        transform: scale(1.05) translateY(-2px);
        box-shadow: 0 8px 32px 0 rgba(16, 185, 129, 0.15);
    }

    .dashboard-header {
        background: linear-gradient(90deg, #10B981 0%, #3B82F6 100%);
        color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 24px 0 rgba(59, 130, 246, 0.10);
        padding: 2rem 2rem 1.5rem 2rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .dashboard-header i {
        font-size: 2.5rem;
        opacity: 0.85;
    }

    .dashboard-header h1 {
        font-size: 2.2rem;
        font-weight: 700;
        letter-spacing: -1px;
        margin: 0;
    }

    .stat-block {
        position: relative;
        overflow: hidden;
        border-radius: 1rem;
        box-shadow: 0 2px 16px 0 rgba(16, 185, 129, 0.08);
        border: 1px solid #e5e7eb;
    }

    .stat-badge {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 1.1rem;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    .badge-blue {
        background: #3B82F6;
        color: #fff;
    }

    .badge-green {
        background: #10B981;
        color: #fff;
    }

    .badge-yellow {
        background: #F59E0B;
        color: #fff;
    }

    .badge-red {
        background: #EF4444;
        color: #fff;
    }

    .badge-purple {
        background: #8B5CF6;
        color: #fff;
    }

    .badge-orange {
        background: #F97316;
        color: #fff;
    }

    .stat-title {
        font-size: 1.1rem;
        font-weight: 500;
        color: #6b7280;
    }

    .stat-icon {
        font-size: 2.2rem;
        opacity: 0.85;
    }

    .section-title {
        font-size: 1.3rem;
        font-weight: 600;
        color: #2563eb;
        margin-bottom: 1rem;
        letter-spacing: -0.5px;
    }

    .section-card {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 2px 16px 0 rgba(59, 130, 246, 0.07);
        padding: 2rem 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid #e5e7eb;
    }

    .activity-icon {
        font-size: 1.5rem;
        padding: 0.7rem;
        border-radius: 50%;
        margin-right: 1rem;
        color: #fff;
    }

    .activity-green {
        background: #10B981;
    }

    .activity-blue {
        background: #3B82F6;
    }

    .activity-yellow {
        background: #F59E0B;
    }

    .activity-red {
        background: #EF4444;
    }

    .activity-purple {
        background: #8B5CF6;
    }

    .activity-orange {
        background: #F97316;
    }

    .activity-title {
        font-weight: 600;
        color: #374151;
    }

    .activity-desc {
        color: #6b7280;
        font-size: 0.97rem;
    }

    .activity-date {
        color: #9ca3af;
        font-size: 0.85rem;
    }

    hr {
        border: none;
        border-top: 1px solid #e5e7eb;
        margin: 2rem 0;
    }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="flex-1 p-4 md:p-8 overflow-y-auto">
        <div class="max-w-7xl mx-auto">
            <div class="dashboard-header">
                <i class="fas fa-user-cog"></i>
                <h1>Tableau de bord Secrétariat</h1>
            </div>
            <!-- Statistiques principales -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
                <div class="bg-white stat-block hover-scale">
                    <div class="flex items-center justify-between p-6">
                        <div>
                            <div class="stat-title">Étudiants</div>
                            <span class="stat-badge badge-blue"><?php echo number_format($stats['etudiants']); ?></span>
                        </div>
                        <i class="fas fa-users stat-icon text-blue-400"></i>
                    </div>
                </div>
                <div class="bg-white stat-block hover-scale">
                    <div class="flex items-center justify-between p-6">
                        <div>
                            <div class="stat-title">Enseignants</div>
                            <span
                                class="stat-badge badge-green"><?php echo number_format($stats['enseignants']); ?></span>
                        </div>
                        <i class="fas fa-chalkboard-teacher stat-icon text-green-400"></i>
                    </div>
                </div>
                <div class="bg-white stat-block hover-scale">
                    <div class="flex items-center justify-between p-6">
                        <div>
                            <div class="stat-title">Rapports</div>
                            <span
                                class="stat-badge badge-yellow"><?php echo number_format($stats['rapports']); ?></span>
                        </div>
                        <i class="fas fa-file-alt stat-icon text-yellow-400"></i>
                    </div>
                </div>
                <div class="bg-white stat-block hover-scale">
                    <div class="flex items-center justify-between p-6">
                        <div>
                            <div class="stat-title">Réclamations</div>
                            <span
                                class="stat-badge badge-red"><?php echo number_format($stats['reclamations']); ?></span>
                        </div>
                        <i class="fas fa-exclamation-circle stat-icon text-red-400"></i>
                    </div>
                </div>
                <div class="bg-white stat-block hover-scale">
                    <div class="flex items-center justify-between p-6">
                        <div>
                            <div class="stat-title">Candidatures</div>
                            <span
                                class="stat-badge badge-purple"><?php echo number_format($stats['candidatures']); ?></span>
                        </div>
                        <i class="fas fa-file-signature stat-icon text-purple-400"></i>
                    </div>
                </div>
                <div class="bg-white stat-block hover-scale">
                    <div class="flex items-center justify-between p-6">
                        <div>
                            <div class="stat-title">Archives</div>
                            <span
                                class="stat-badge badge-orange"><?php echo number_format($stats['archives']); ?></span>
                        </div>
                        <i class="fas fa-archive stat-icon text-orange-400"></i>
                    </div>
                </div>
            </div>
            <hr>
            <!-- Graphique d'évolution des effectifs -->
            <div class="section-card mb-8">
                <div class="section-title"><i class="fas fa-chart-line mr-2 text-emerald-500"></i>Évolution des
                    effectifs étudiants</div>
                <canvas id="effectifChart" height="120"></canvas>
            </div>
            <!-- Activités récentes -->
            <div class="section-card mb-8">
                <div class="section-title"><i class="fas fa-bolt mr-2 text-yellow-500"></i>Activités récentes</div>
                <div class="space-y-4">
                    <?php foreach($activites as $activite): ?>
                    <div class="flex items-start mb-2">
                        <span class="activity-icon activity-<?php echo $activite['couleur']; ?>">
                            <i class="fas <?php echo $activite['icone']; ?>"></i>
                        </span>
                        <div>
                            <div class="activity-title"><?php echo htmlspecialchars($activite['titre']); ?></div>
                            <div class="activity-desc"><?php echo htmlspecialchars($activite['description']); ?></div>
                            <div class="activity-date"><?php echo $activite['date_activite']; ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <script>
    // Données factices pour le graphique
    const effectifData = {
        labels: ['2019', '2020', '2021', '2022', '2023', '2024'],
        datasets: [{
            label: 'Étudiants',
            data: [180, 200, 220, 250, 300, 320],
            backgroundColor: 'rgba(16, 185, 129, 0.13)',
            borderColor: '#10B981',
            borderWidth: 3,
            fill: true,
            tension: 0.4
        }]
    };
    const ctx = document.getElementById('effectifChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: effectifData,
        options: {
            responsive: true,
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
    </script>
</body>

</html>