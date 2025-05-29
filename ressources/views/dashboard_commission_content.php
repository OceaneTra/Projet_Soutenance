<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques | Mr. Diarra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <style>
        .sidebar-hover:hover {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
        }
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
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
        .progress-ring {
            transition: stroke-dasharray 0.6s ease-in-out;
        }
        .metric-value {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #f59e0b, #d97706);
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
<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 border-r border-gray-200 bg-white">
                <div class="flex items-center justify-center h-16 px-4 bg-yellow-100 shadow-sm">
                    <div class="flex items-center">
                        <i class="fas fa-pen-nib text-yellow-600 mr-2"></i>
                        <span class="text-yellow-600 font-bold">Rédaction CR</span>
                    </div>
                </div>
                <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto">
                    <nav class="space-y-1">
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md sidebar-hover text-gray-700 hover:text-gray-900">
                            <i class="fas fa-edit mr-3 text-gray-500"></i>
                            Nouveau compte rendu
                        </a>
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md sidebar-hover text-gray-700 hover:text-gray-900">
                            <i class="fas fa-file-alt mr-3 text-gray-500"></i>
                            Brouillons
                            <span class="ml-auto bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">3</span>
                        </a>
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md sidebar-hover text-gray-700 hover:text-gray-900">
                            <i class="fas fa-check-circle mr-3 text-gray-500"></i>
                            Comptes rendus finalisés
                        </a>
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md sidebar-hover text-gray-700 hover:text-gray-900">
                            <i class="fas fa-archive mr-3 text-gray-500"></i>
                            Archives
                        </a>
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md sidebar-hover text-gray-700 hover:text-gray-900">
                            <i class="fas fa-template mr-3 text-gray-500"></i>
                            Modèles
                        </a>
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md sidebar-hover text-yellow-700 bg-yellow-50">
                            <i class="fas fa-chart-line mr-3 text-yellow-500"></i>
                            Statistiques
                        </a>
                    </nav>
                    <div class="mt-auto pt-4 border-t border-gray-200">
                        <a href="#" class="flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-3 text-gray-500"></i>
                            Déconnexion
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top navigation -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 bg-white shadow-sm">
                <div class="flex items-center">
                    <button id="mobileMenuButton" class="md:hidden text-gray-500 focus:outline-none mr-3">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="text-xl font-semibold text-gray-800">Tableau de Bord & Statistiques</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <select id="periodSelect" class="px-3 py-1 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                            <option value="7">7 derniers jours</option>
                            <option value="30" selected>30 derniers jours</option>
                            <option value="90">3 derniers mois</option>
                            <option value="365">Année en cours</option>
                        </select>
                        <button onclick="exportStats()" class="flex items-center px-3 py-1 text-sm text-green-600 hover:text-green-800">
                            <i class="fas fa-download mr-1"></i>Exporter
                        </button>
                    </div>
                    <div class="relative">
                        <button class="flex items-center space-x-2 focus:outline-none">
                            <img class="w-8 h-8 rounded-full" src="https://randomuser.me/api/portraits/men/55.jpg" alt="Mr. Diarra">
                            <span class="text-sm font-medium text-gray-700">Mr. Diarra</span>
                            <i class="fas fa-chevron-down text-gray-500 text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <div class="flex-1 overflow-y-auto bg-gray-50">
                <div class="max-w-7xl mx-auto p-6">
                    <!-- KPI Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="stat-card bg-white rounded-lg shadow p-6 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Total Comptes Rendus</p>
                                    <p class="metric-value">24</p>
                                    <div class="flex items-center mt-2">
                                        <i class="fas fa-arrow-up text-sm trend-up mr-1"></i>
                                        <span class="text-sm text-green-600">+12% ce mois</span>
                                    </div>
                                </div>
                                <div class="p-3 rounded-full bg-blue-100">
                                    <i class="fas fa-file-alt text-blue-600 text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="stat-card bg-white rounded-lg shadow p-6 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Taux de Validation</p>
                                    <p class="metric-value">85%</p>
                                    <div class="flex items-center mt-2">
                                        <i class="fas fa-arrow-up text-sm trend-up mr-1"></i>
                                        <span class="text-sm text-green-600">+3% ce mois</span>
                                    </div>
                                </div>
                                <div class="p-3 rounded-full bg-green-100">
                                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="stat-card bg-white rounded-lg shadow p-6 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">Temps Moyen</p>
                                    <p class="metric-value">2.3j</p>
                                    <div class="flex items-center mt-2">
                                        <i class="fas fa-arrow-down text-sm trend-up mr-1"></i>
                                        <span class="text-sm text-green-600">-8% ce mois</span>
                                    </div>
                                </div>
                                <div class="p-3 rounded-full bg-purple-100">
                                    <i class="fas fa-clock text-purple-600 text-2xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="stat-card bg-white rounded-lg shadow p-6 fade-in">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">En Attente</p>
                                    <p class="metric-value">5</p>
                                    <div class="flex items-center mt-2">
                                        <i class="fas fa-minus text-sm trend-stable mr-1"></i>
                                        <span class="text-sm text-gray-600">Stable</span>
                                    </div>
                                </div>
                                <div class="p-3 rounded-full bg-orange-100">
                                    <i class="fas fa-hourglass-half text-orange-600 text-2xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <!-- Evolution Chart -->
                        <div class="bg-white rounded-lg shadow p-6 fade-in">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                                    Évolution des Comptes Rendus
                                </h3>
                                <div class="flex items-center space-x-2 text-sm">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-blue-600 rounded-full mr-1"></div>
                                        <span>Finalisés</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-yellow-600 rounded-full mr-1"></div>
                                        <span>En cours</span>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                <canvas id="evolutionChart"></canvas>
                            </div>
                        </div>

                        <!-- Status Distribution -->
                        <div class="bg-white rounded-lg shadow p-6 fade-in">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    <i class="fas fa-chart-pie text-green-600 mr-2"></i>
                                    Répartition par Statut
                                </h3>
                                <button onclick="refreshCharts()" class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                            <div class="chart-container">
                                <canvas id="statusChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Detailed Stats -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Performance by Category -->
                        <div class="bg-white rounded-lg shadow p-6 fade-in">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                <i class="fas fa-tags text-purple-600 mr-2"></i>
                                Performance par Catégorie
                            </h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-blue-600 rounded-full mr-3"></div>
                                        <span class="text-sm font-medium">Intelligence Artificielle</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-20 bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: 90%"></div>
                                        </div>
                                        <span class="text-sm font-semibold">90%</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-green-600 rounded-full mr-3"></div>
                                        <span class="text-sm font-medium">Blockchain</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-20 bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-600 h-2 rounded-full" style="width: 75%"></div>
                                        </div>
                                        <span class="text-sm font-semibold">75%</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-purple-600 rounded-full mr-3"></div>
                                        <span class="text-sm font-medium">Réseaux</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-20 bg-gray-200 rounded-full h-2">
                                            <div class="bg-purple-600 h-2 rounded-full" style="width: 85%"></div>
                                        </div>
                                        <span class="text-sm font-semibold">85%</span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 bg-orange-600 rounded-full mr-3"></div>
                                        <span class="text-sm font-medium">Sécurité</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-20 bg-gray-200 rounded-full h-2">
                                            <div class="bg-orange-600 h-2 rounded-full" style="width: 80%"></div>
                                        </div>
                                        <span class="text-sm font-semibold">80%</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="bg-white rounded-lg shadow p-6 fade-in">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                <i class="fas fa-history text-indigo-600 mr-2"></i>
                                Activité Récente
                            </h3>
                            <div class="space-y-3">
                                <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg">
                                    <div class="p-2 bg-green-100 rounded-full">
                                        <i class="fas fa-check text-green-600 text-xs"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium">Rapport validé</p>
                                        <p class="text-xs text-gray-500">IA Diagnostic - Marie L.</p>
                                    </div>
                                    <span class="text-xs text-gray-400">2h</span>
                                </div>
                                <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg">
                                    <div class="p-2 bg-blue-100 rounded-full">
                                        <i class="fas fa-edit text-blue-600 text-xs"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium">Brouillon sauvegardé</p>
                                        <p class="text-xs text-gray-500">Blockchain - Jean D.</p>
                                    </div>
                                    <span class="text-xs text-gray-400">4h</span>
                                </div>
                                <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg">
                                    <div class="p-2 bg-orange-100 rounded-full">
                                        <i class="fas fa-redo text-orange-600 text-xs"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium">Révision demandée</p>
                                        <p class="text-xs text-gray-500">Réseaux - Thomas M.</p>
                                    </div>
                                    <span class="text-xs text-gray-400">1j</span>
                                </div>
                                <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg">
                                    <div class="p-2 bg-purple-100 rounded-full">
                                        <i class="fas fa-plus text-purple-600 text-xs"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium">Nouveau rapport</p>
                                        <p class="text-xs text-gray-500">Finance - Sophie D.</p>
                                    </div>
                                    <span class="text-xs text-gray-400">2j</span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-white rounded-lg shadow p-6 fade-in">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                                <i class="fas fa-bolt text-yellow-600 mr-2"></i>
                                Actions Rapides
                            </h3>
                            <div class="space-y-3">
                                <button onclick="generateReport()" class="w-full flex items-center justify-center px-4 py-2 bg-yellow-600 text-white text-sm font-medium rounded-md hover:bg-yellow-700">
                                    <i class="fas fa-chart-bar mr-2"></i>
                                    Générer Rapport Mensuel
                                </button>
                                <button onclick="exportData()" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
                                    <i class="fas fa-download mr-2"></i>
                                    Exporter Données
                                </button>
                                <button onclick="viewArchives()" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
                                    <i class="fas fa-archive mr-2"></i>
                                    Consulter Archives
                                </button>
                                <button onclick="settings()" class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
                                    <i class="fas fa-cog mr-2"></i>
                                    Paramètres
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Performance Table -->
                    <div class="bg-white rounded-lg shadow p-6 fade-in">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-800">
                                <i class="fas fa-table text-gray-600 mr-2"></i>
                                Détails des Performances
                            </h3>
                            <div class="flex items-center space-x-2">
                                <input type="text" placeholder="Rechercher..." class="px-3 py-1 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                <button class="px-3 py-1 text-sm bg-yellow-600 text-white rounded-md hover:bg-yellow-700">
                                    <i class="fas fa-filter"></i>
                                </button>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Étudiant</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sujet</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Temps</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Marie Lambert</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">IA Diagnostic Médical</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Validé</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">23/05/2025</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2.1j</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button class="text-blue-600 hover:text-blue-900 mr-2">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="text-green-600 hover:text-green-900">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Jean Dupont</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Blockchain Sécurité</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejeté</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">22/05/2025</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">3.2j</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button class="text-blue-600 hover:text-blue-900 mr-2">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="text-green-600 hover:text-green-900">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Thomas Moreau</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Réseaux Neurones</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">Révision</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">21/05/2025</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1.8j</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button class="text-blue-600 hover:text-blue-900 mr-2">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="text-green-600 hover:text-green-900">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Sophie Dubois</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">ML Finance</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Validé</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">20/05/2025</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2.5j</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button class="text-blue-600 hover:text-blue-900 mr-2">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="text-green-600 hover:text-green-900">
                                                <i class="fas fa-download"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Variables globales pour les graphiques
        let evolutionChart, statusChart;

        // Données pour les graphiques
        const evolutionData = {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
            datasets: [
                {
                    label: 'Finalisés',
                    data: [12, 15, 18, 22, 24, 20],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'En cours',
                    data: [8, 12, 10, 15, 18, 16],
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        };

        const statusData = {
            labels: ['Validés', 'Rejetés', 'En révision', 'En attente'],
            datasets: [{
                data: [65, 15, 12, 8],
                backgroundColor: [
                    '#10b981',
                    '#ef4444',
                    '#f59e0b',
                    '#6b7280'
                ],
                borderWidth: 0
            }]
        };

        // Initialisation des graphiques
        function initCharts() {
            // Graphique d'évolution
            const evolutionCtx = document.getElementById('evolutionChart').getContext('2d');
            evolutionChart = new Chart(evolutionCtx, {
                type: 'line',
                data: evolutionData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    elements: {
                        point: {
                            radius: 4,
                            hoverRadius: 6
                        }
                    }
                }
            });

            // Graphique de statut
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: statusData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 15
                            }
                        }
                    },
                    cutout: '60%'
                }
            });
        }

        // Fonctions d'action
        function refreshCharts() {
            showNotification('Actualisation des données...', 'info');
            
            // Simuler le rechargement des données
            setTimeout(() => {
                // Mettre à jour les données avec de nouvelles valeurs
                const newEvolutionData = evolutionData.datasets[0].data.map(val => val + Math.floor(Math.random() * 3) - 1);
                evolutionChart.data.datasets[0].data = newEvolutionData;
                evolutionChart.update();
                
                const newStatusData = [68, 12, 15, 5];
                statusChart.data.datasets[0].data = newStatusData;
                statusChart.update();
                
                showNotification('Données actualisées avec succès', 'success');
            }, 1500);
        }

        function exportStats() {
            showNotification('Export des statistiques en cours...', 'info');
            
            setTimeout(() => {
                // Simuler l'export
                const data = {
                    period: document.getElementById('periodSelect').value + ' jours',
                    totalReports: 24,
                    validationRate: '85%',
                    averageTime: '2.3 jours',
                    pending: 5,
                    exportDate: new Date().toLocaleDateString('fr-FR')
                };
                
                const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `statistiques_${new Date().toISOString().slice(0, 10)}.json`;
                a.click();
                URL.revokeObjectURL(url);
                
                showNotification('Statistiques exportées avec succès', 'success');
            }, 2000);
        }

        function generateReport() {
            showNotification('Génération du rapport mensuel...', 'info');
            
            setTimeout(() => {
                showNotification('Rapport mensuel généré avec succès', 'success');
                // Simuler l'ouverture d'un nouveau rapport
            }, 3000);
        }

        function exportData() {
            showNotification('Export des données en cours...', 'info');
            
            setTimeout(() => {
                showNotification('Données exportées au format Excel', 'success');
            }, 2000);
        }

        function viewArchives() {
            showNotification('Redirection vers les archives...', 'info');
            setTimeout(() => {
                // Simuler la navigation
                showNotification('Ouverture de la section archives', 'success');
            }, 1000);
        }

        function settings() {
            showNotification('Ouverture des paramètres...', 'info');
        }

        // Fonction pour changer la période
        function changePeriod() {
            const period = document.getElementById('periodSelect').value;
            showNotification(`Mise à jour des données pour les ${period} derniers jours`, 'info');
            
            setTimeout(() => {
                // Simuler la mise à jour des données
                refreshCharts();
            }, 1000);
        }

        // Système de notifications
        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-4 py-2 rounded-md text-white text-sm font-medium z-50 ${
                type === 'success' ? 'bg-green-600' : 
                type === 'error' ? 'bg-red-600' : 
                type === 'info' ? 'bg-blue-600' : 'bg-gray-600'
            }`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'times' : 'info'} mr-2"></i>
                    ${message}
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Animation des métriques au chargement
        function animateMetrics() {
            const metrics = document.querySelectorAll('.metric-value');
            metrics.forEach((metric, index) => {
                const finalValue = metric.textContent;
                metric.textContent = '0';
                
                setTimeout(() => {
                    const increment = finalValue.includes('%') ? 1 : finalValue.includes('j') ? 0.1 : 1;
                    const target = parseFloat(finalValue);
                    let current = 0;
                    
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }
                        
                        if (finalValue.includes('%')) {
                            metric.textContent = Math.round(current) + '%';
                        } else if (finalValue.includes('j')) {
                            metric.textContent = current.toFixed(1) + 'j';
                        } else {
                            metric.textContent = Math.round(current);
                        }
                    }, 50);
                }, index * 200);
            });
        }

        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser les graphiques
            initCharts();
            
            // Animer les métriques
            animateMetrics();
            
            // Event listeners
            document.getElementById('periodSelect').addEventListener('change', changePeriod);
            
            // Animation d'entrée pour les cartes
            const cards = document.querySelectorAll('.fade-in');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
            
            // Raccourcis clavier
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.key === 'r') {
                    e.preventDefault();
                    refreshCharts();
                }
                if (e.ctrlKey && e.key === 'e') {
                    e.preventDefault();
                    exportStats();
                }
            });
        });

        // Mise à jour automatique des données toutes les 5 minutes
        setInterval(() => {
            refreshCharts();
        }, 300000);
    </script>
</body>
</html>