<?php

$stat_etudiants = $GLOBALS['stats_etudiants'] ?? [
    'total' => 0,
    'actifs' => 0,
    'inactifs' => 0,
    'taux_activite' => 0
];

$stat_enseignants = $GLOBALS['stats_enseignants'] ?? [
    'total' => 0,
    'actifs' => 0,
    'inactifs' => 0,
    'taux_activite' => 0
];
$stat_personnel = $GLOBALS['stats_personnel'] ?? [
    'total' => 0,
    'actifs' => 0,
    'inactifs' => 0,
    'taux_activite' => 0
];
$stat_utilisateurs = $GLOBALS['stats_utilisateurs'] ?? [
    'total' => 0,
    'actifs' => 0,
    'inactifs' => 0,
    'taux_activite' => 0
];



?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    .gradient-purple {
        background: linear-gradient(135deg, #A78BFA 0%, #8B5CF6 100%);
    }

    .gradient-blue {
        background: linear-gradient(135deg, #60A5FA 0%, #3B82F6 100%);
    }

    .gradient-red {
        background: linear-gradient(135deg, #F87171 0%, #EF4444 100%);
    }

    .gradient-orange {
        background: linear-gradient(135deg, #FB923C 0%, #F97316 100%);
    }

    .gradient-bg {
        background: linear-gradient(135deg, #F3F4F6 0%, #E5E7EB 100%);
    }

    .card-hover {
        transition: all 0.3s ease;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .btn-tab {
        transition: all 0.3s ease;
    }

    .btn-tab.active {
        background-color: #4F46E5;
        color: white;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .calendar-day {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        border-radius: 9999px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .calendar-day:hover {
        background-color: #EEF2FF;
    }

    .calendar-day.today {
        background: linear-gradient(135deg, #4F46E5 0%, #6366F1 100%);
        color: white;
    }

    .calendar-day.selected {
        background: linear-gradient(135deg, #8B5CF6 0%, #6D28D9 100%);
        color: white;
    }

    .calendar-day.other-month {
        color: #9CA3AF;
    }

    .calendar-header {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .calendar-header div {
        text-align: center;
        font-size: 0.75rem;
        color: #4F46E5;
        font-weight: 500;
    }

    .stats-table th {
        background-color: #F3F4F6;
        color: #4F46E5;
        font-weight: 600;
        padding: 1rem;
        text-align: left;
    }

    .stats-table td {
        padding: 1rem;
        border-bottom: 1px solid #E5E7EB;
    }

    .stats-table tr:hover {
        background-color: #F9FAFB;
    }
    </style>
</head>

<body class="gradient-bg font-sans">

    <div class="flex min-h-screen">

        <!-- Main Content -->
        <div class="flex-grow">

            <!-- Main Dashboard Content -->
            <div class="container mx-auto p-6">

                <!-- Date et Calendrier -->
                <div class="flex justify-between items-center mb-6">
                    <div class="bg-amber-500 rounded-xl shadow-lg p-4 text-white">
                        <?php
                        $date = new DateTime();
                        $jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
                        $mois = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
                        $date_fr = $jours[$date->format('w')] . ' ' . $date->format('d') . ' ' . $mois[$date->format('n')-1] . ' ' . $date->format('Y');
                        $heure = $date->format('H:i');
                        ?>
                        <h2 class="text-lg font-bold text-white"><?php echo $date_fr; ?></h2>
                        <p class="text-sm text-white opacity-90"><?php echo $heure; ?></p>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <!-- Étudiants Card -->
                    <div class="gradient-purple rounded-xl p-4 text-white shadow-lg card-hover">
                        <div class="flex justify-between items-center">
                            <div class="bg-white bg-opacity-20 w-12 h-12 rounded-xl flex items-center justify-center">
                                <i class="fas fa-user-graduate text-purple-500 text-xl"></i>
                            </div>
                            <div class="text-right">
                                <h3 class="text-3xl font-bold"><?php echo $stat_etudiants['total']; ?></h3>
                                <p class="text-sm opacity-90">Étudiants</p>
                            </div>
                        </div>
                    </div>

                    <!-- Enseignants Card -->
                    <div class="gradient-blue rounded-xl p-4 text-white shadow-lg card-hover">
                        <div class="flex justify-between items-center">
                            <div class="bg-white bg-opacity-20 w-12 h-12 rounded-xl flex items-center justify-center">
                                <i class="fas fa-chalkboard text-blue-500 text-xl"></i>
                            </div>
                            <div class="text-right">
                                <h3 class="text-3xl font-bold"><?php echo $stat_enseignants['total']; ?></h3>
                                <p class="text-sm opacity-90">Enseignants</p>
                            </div>
                        </div>
                    </div>

                    <!-- Personnel Card -->
                    <div class="gradient-red rounded-xl p-4 text-white shadow-lg card-hover">
                        <div class="flex justify-between items-center">
                            <div class="bg-white bg-opacity-20 w-12 h-12 rounded-xl flex items-center justify-center">
                                <i class="fas fa-user-tie text-red-500 text-xl"></i>
                            </div>
                            <div class="text-right">
                                <h3 class="text-3xl font-bold"><?php echo $stat_personnel['total']; ?></h3>
                                <p class="text-sm opacity-90">Personnels Administratifs</p>
                            </div>
                        </div>
                    </div>

                    <!-- Utilisateurs Card -->
                    <div class="gradient-orange rounded-xl p-4 text-white shadow-lg card-hover">
                        <div class="flex justify-between items-center">
                            <div class="bg-white bg-opacity-20 w-12 h-12 rounded-xl flex items-center justify-center">
                                <i class="fas fa-users text-orange-500 text-xl"></i>
                            </div>
                            <div class="text-right">
                                <h3 class="text-3xl font-bold"><?php echo $stat_utilisateurs['total']; ?></h3>
                                <p class="text-sm opacity-90">Utilisateurs</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column - Graphiques et Tableau -->
                    <div class="lg:col-span-2">
                        <!-- Graphique d'évolution -->
                        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 card-hover">
                            <div class="flex justify-between items-center mb-6">
                                <div>
                                    <h2 class="text-lg font-bold text-green-800">Évolution des utilisateurs</h2>
                                    <p class="text-sm text-indigo-500">Sur les 6 derniers mois</p>
                                </div>
                                <div class="flex space-x-1 text-xs bg-indigo-50 rounded-lg p-1">
                                    <button class="btn-tab px-3 py-1 rounded-md"
                                        data-type="etudiants">ÉTUDIANTS</button>
                                    <button class="btn-tab px-3 py-1 rounded-md"
                                        data-type="enseignants">ENSEIGNANTS</button>
                                    <button class="btn-tab active px-3 py-1 rounded-md"
                                        data-type="utilisateurs">UTILISATEURS</button>
                                    <button class="btn-tab px-3 py-1 rounded-md" data-type="personnels">PERSONNEL
                                        ADMINISTRATIF</button>
                                </div>
                            </div>
                            <div class="h-80">
                                <canvas id="evolutionChart"></canvas>
                            </div>
                        </div>

                        <!-- Tableau des statistiques -->
                        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                            <h2 class="text-lg font-bold text-green-800 mb-4">Statistiques détaillées</h2>
                            <div class="overflow-x-auto">
                                <table class="stats-table w-full">
                                    <thead>
                                        <tr>
                                            <th>Catégorie</th>
                                            <th>Total</th>
                                            <th>Actifs</th>
                                            <th>Inactifs</th>
                                            <th>Taux d'activité</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-purple-600">Étudiants</td>
                                            <td><?php echo $stat_etudiants['total']; ?></td>
                                            <td><?php echo $stat_etudiants['actifs']; ?></td>
                                            <td><?php echo $stat_etudiants['inactifs']; ?></td>
                                            <td><?php echo $stat_etudiants['taux_activite']; ?>%</td>
                                        </tr>
                                        <tr>
                                            <td class="text-blue-600">Enseignants</td>
                                            <td><?php echo $stat_enseignants['total']; ?></td>
                                            <td><?php echo $stat_enseignants['actifs']; ?></td>
                                            <td><?php echo $stat_enseignants['inactifs']; ?></td>
                                            <td><?php echo $stat_enseignants['taux_activite']; ?>%</td>
                                        </tr>
                                        <tr>
                                            <td class="text-red-600">Personnel Administratif</td>
                                            <td><?php echo $stat_personnel['total']; ?></td>
                                            <td><?php echo $stat_personnel['actifs']; ?></td>
                                            <td><?php echo $stat_personnel['inactifs']; ?></td>
                                            <td><?php echo $stat_personnel['taux_activite']; ?>%</td>
                                        </tr>
                                        <tr>
                                            <td class="text-orange-600">Utilisateurs</td>
                                            <td><?php echo $stat_utilisateurs['total']; ?></td>
                                            <td><?php echo $stat_utilisateurs['actifs']; ?></td>
                                            <td><?php echo $stat_utilisateurs['inactifs']; ?></td>
                                            <td><?php echo $stat_utilisateurs['taux_activite']; ?>%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Calendrier et Activités -->
                    <div class="lg:col-span-1">
                        <!-- Calendrier -->
                        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 card-hover">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-lg font-bold text-green-800">Calendrier</h2>
                                <div class="flex space-x-2">
                                    <button id="prevMonth"
                                        class="w-8 h-8 rounded-md bg-indigo-50 flex items-center justify-center text-indigo-500 hover:bg-indigo-100">
                                        <i class="fas fa-chevron-left text-xs"></i>
                                    </button>
                                    <button id="nextMonth"
                                        class="w-8 h-8 rounded-md bg-indigo-50 flex items-center justify-center text-indigo-500 hover:bg-indigo-100">
                                        <i class="fas fa-chevron-right text-xs"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="text-center mb-4">
                                <h3 id="currentMonth" class="text-md font-medium text-indigo-800"></h3>
                            </div>

                            <!-- Calendar Grid -->
                            <div class="calendar-header">
                                <div>Lu</div>
                                <div>Ma</div>
                                <div>Me</div>
                                <div>Je</div>
                                <div>Ve</div>
                                <div>Sa</div>
                                <div>Di</div>
                            </div>
                            <div id="calendarDays" class="calendar-grid"></div>
                        </div>

                        <!-- Activités récentes -->
                        <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                            <div class="flex justify-between items-center mb-6">
                                <h2 class="text-lg font-bold text-green-800">Activités récentes</h2>
                                <button class="text-indigo-400 hover:text-indigo-600">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>

                            <div class="space-y-4">
                                <?php if (isset($GLOBALS['activites_recentes']) && !empty($GLOBALS['activites_recentes'])): ?>
                                <?php foreach ($GLOBALS['activites_recentes'] as $activite): ?>
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-8 h-8 rounded-full <?php echo $activite['type'] === 'utilisateur' ? 'bg-indigo-100' : 'bg-green-100'; ?> flex items-center justify-center">
                                            <i
                                                class="fas <?php echo $activite['type'] === 'utilisateur' ? 'fa-user' : 'fa-cog'; ?> text-sm <?php echo $activite['type'] === 'utilisateur' ? 'text-indigo-600' : 'text-green-600'; ?>"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm text-indigo-800">
                                            <?php echo htmlspecialchars($activite['description']); ?></p>
                                        <p class="text-xs text-indigo-500">
                                            <?php echo htmlspecialchars($activite['date']); ?></p>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <div class="text-center py-8 text-indigo-500">
                                    <i class="fas fa-history text-4xl mb-2"></i>
                                    <p>Aucune activité récente</p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Données pour le graphique
    const chartData = {
        etudiants: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
            data: [120, 150, 180, 200, 220, 250]
        },
        enseignants: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
            data: [20, 25, 30, 35, 40, 45]
        },
        utilisateurs: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
            data: [140, 175, 210, 235, 260, 295]
        },
        personnels: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
            data: [142, 169, 255, 235, 240, 356]
        }
    };

    // Graphique d'évolution
    const evolutionCtx = document.getElementById('evolutionChart').getContext('2d');
    let evolutionChart = new Chart(evolutionCtx, {
        type: 'line',
        data: {
            labels: chartData.utilisateurs.labels,
            datasets: [{
                label: 'Utilisateurs',
                data: chartData.utilisateurs.data,
                borderColor: '#8B5CF6',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: '#4F46E5',
                        font: {
                            size: 12
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(79, 70, 229, 0.1)'
                    },
                    ticks: {
                        color: '#4F46E5'
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(79, 70, 229, 0.1)'
                    },
                    ticks: {
                        color: '#4F46E5'
                    }
                }
            }
        }
    });

    // Gestion des onglets du graphique
    document.querySelectorAll('.btn-tab').forEach(button => {
        button.addEventListener('click', () => {
            // Mise à jour des classes actives
            document.querySelectorAll('.btn-tab').forEach(btn => {
                btn.classList.remove('active');
            });
            button.classList.add('active');

            // Mise à jour des données du graphique
            const type = button.dataset.type;
            evolutionChart.data.labels = chartData[type].labels;
            evolutionChart.data.datasets[0].data = chartData[type].data;
            evolutionChart.data.datasets[0].label = type.charAt(0).toUpperCase() + type.slice(1);
            evolutionChart.update();
        });
    });

    // Calendar functionality
    let currentDate = new Date();
    let selectedDate = new Date();

    function updateCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();

        // Update month display
        const monthNames = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre",
            "Octobre", "Novembre", "Décembre"
        ];
        document.getElementById('currentMonth').textContent = `${monthNames[month]} ${year}`;

        // Get first day of month and total days
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const startingDay = firstDay.getDay() || 7; // Convert Sunday (0) to 7
        const totalDays = lastDay.getDate();

        // Get previous month's days
        const prevMonthLastDay = new Date(year, month, 0).getDate();
        const prevMonthDays = Array.from({
            length: startingDay - 1
        }, (_, i) => prevMonthLastDay - i).reverse();

        // Get next month's days
        const remainingDays = 42 - (prevMonthDays.length + totalDays); // 42 = 6 rows * 7 days
        const nextMonthDays = Array.from({
            length: remainingDays
        }, (_, i) => i + 1);

        // Combine all days
        const allDays = [
            ...prevMonthDays.map(day => ({
                day,
                isCurrentMonth: false
            })),
            ...Array.from({
                length: totalDays
            }, (_, i) => ({
                day: i + 1,
                isCurrentMonth: true
            })),
            ...nextMonthDays.map(day => ({
                day,
                isCurrentMonth: false
            }))
        ];

        // Generate calendar HTML
        const calendarHTML = allDays.map(({
            day,
            isCurrentMonth
        }) => {
            const isToday = isCurrentMonth && day === new Date().getDate() &&
                month === new Date().getMonth() &&
                year === new Date().getFullYear();
            const isSelected = isCurrentMonth && day === selectedDate.getDate() &&
                month === selectedDate.getMonth() &&
                year === selectedDate.getFullYear();

            let classes = 'calendar-day';
            if (!isCurrentMonth) classes += ' other-month';
            if (isToday) classes += ' today';
            if (isSelected) classes += ' selected';

            return `<div class="${classes}" data-date="${year}-${month + 1}-${day}">${day}</div>`;
        }).join('');

        document.getElementById('calendarDays').innerHTML = calendarHTML;

        // Add click event listeners
        document.querySelectorAll('.calendar-day').forEach(day => {
            day.addEventListener('click', () => {
                const [year, month, day] = day.dataset.date.split('-').map(Number);
                selectedDate = new Date(year, month - 1, day);
                updateCalendar();
            });
        });
    }

    // Initialize calendar
    updateCalendar();

    // Add month navigation
    document.getElementById('prevMonth').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        updateCalendar();
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        updateCalendar();
    });
    </script>
</body>

</html>