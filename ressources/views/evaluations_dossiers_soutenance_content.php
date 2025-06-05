<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Évaluations des Dossiers | Mr. Diarra</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .metric-value {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .trend-up { color: #10b981; }
        .trend-down { color: #ef4444; }
        .trend-stable { color: #6b7280; }
        .evaluation-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
<div class="flex h-screen overflow-hidden">
    <!-- Main content area -->
    <div class="flex-1 overflow-y-auto bg-gray-50">
        <div class="max-w-7xl mx-auto p-6">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-file-alt text-yellow-600 mr-2"></i>
                    Évaluations des Dossiers de Soutenance
                </h1>
                <div class="flex space-x-3">
                    <div class="relative">
                        <select class="appearance-none bg-white border border-gray-300 rounded-md pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                            <option>Tous les dossiers</option>
                            <option>En attente</option>
                            <option>Validés</option>
                            <option>À corriger</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                    <button class="px-4 py-2 bg-yellow-600 text-white text-sm font-medium rounded-md hover:bg-yellow-700 flex items-center">
                        <i class="fas fa-plus mr-2"></i>
                        Nouvelle évaluation
                    </button>
                </div>
            </div>

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card bg-white rounded-lg shadow p-6 fade-in">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Dossiers à évaluer</p>
                            <p class="metric-value">12</p>
                            <div class="flex items-center mt-2">
                                <i class="fas fa-arrow-up text-sm trend-up mr-1"></i>
                                <span class="text-sm text-green-600">+3 cette semaine</span>
                            </div>
                        </div>
                        <div class="p-3 rounded-full bg-blue-100">
                            <i class="fas fa-inbox text-blue-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-lg shadow p-6 fade-in">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Dossiers validés</p>
                            <p class="metric-value">28</p>
                            <div class="flex items-center mt-2">
                                <i class="fas fa-arrow-up text-sm trend-up mr-1"></i>
                                <span class="text-sm text-green-600">+5 cette semaine</span>
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
                            <p class="text-sm font-medium text-gray-600">Dossiers à corriger</p>
                            <p class="metric-value">7</p>
                            <div class="flex items-center mt-2">
                                <i class="fas fa-arrow-down text-sm trend-down mr-1"></i>
                                <span class="text-sm text-red-600">-2 cette semaine</span>
                            </div>
                        </div>
                        <div class="p-3 rounded-full bg-red-100">
                            <i class="fas fa-exclamation-circle text-red-600 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-white rounded-lg shadow p-6 fade-in">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Moyenne d'évaluation</p>
                            <p class="metric-value">14.5/20</p>
                            <div class="flex items-center mt-2">
                                <i class="fas fa-arrow-up text-sm trend-up mr-1"></i>
                                <span class="text-sm text-green-600">+0.8 ce mois</span>
                            </div>
                        </div>
                        <div class="p-3 rounded-full bg-purple-100">
                            <i class="fas fa-chart-line text-purple-600 text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Evaluation Grid -->
            <div class="evaluation-grid mb-8">
                <!-- Dossier Card 1 -->
                <div class="bg-white rounded-lg shadow overflow-hidden fade-in hover:shadow-lg transition-shadow duration-300">
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">Système de recommandation IA</h3>
                                <p class="text-sm text-gray-500">Étudiant: Marie Lambert</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Nouveau</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Mémoire de 45 pages sur les systèmes de recommandation basés sur l'apprentissage profond.</p>

                        <div class="flex items-center justify-between text-sm mb-4">
                            <div>
                                <p class="font-medium text-gray-700">Date de dépôt:</p>
                                <p class="text-gray-500">25/05/2025</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">Promotion:</p>
                                <p class="text-gray-500">M2 IA 2025</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-700 mb-1">Progression:</p>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-yellow-600 h-2 rounded-full" style="width: 75%"></div>
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <button class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-3 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-eye mr-1"></i> Consulter
                            </button>
                            <button class="flex-1 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 py-2 px-3 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-download mr-1"></i> Télécharger
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Dossier Card 2 -->
                <div class="bg-white rounded-lg shadow overflow-hidden fade-in hover:shadow-lg transition-shadow duration-300">
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">Blockchain pour la santé</h3>
                                <p class="text-sm text-gray-500">Étudiant: Jean Dupont</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Validé</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Implémentation d'une blockchain privée pour le partage sécurisé de dossiers médicaux.</p>

                        <div class="flex items-center justify-between text-sm mb-4">
                            <div>
                                <p class="font-medium text-gray-700">Date de dépôt:</p>
                                <p class="text-gray-500">20/05/2025</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">Promotion:</p>
                                <p class="text-gray-500">M2 Blockchain 2025</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-700 mb-1">Note:</p>
                            <div class="flex items-center">
                                <span class="text-lg font-bold text-yellow-600 mr-2">16.5/20</span>
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: 82%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <button class="flex-1 bg-white border border-yellow-600 hover:bg-yellow-50 text-yellow-600 py-2 px-3 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-edit mr-1"></i> Modifier
                            </button>
                            <button class="flex-1 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 py-2 px-3 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-print mr-1"></i> Imprimer
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Dossier Card 3 -->
                <div class="bg-white rounded-lg shadow overflow-hidden fade-in hover:shadow-lg transition-shadow duration-300">
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">Cybersécurité IoT</h3>
                                <p class="text-sm text-gray-500">Étudiant: Thomas Moreau</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">À corriger</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Analyse des vulnérabilités dans les réseaux IoT industriels et propositions de solutions.</p>

                        <div class="flex items-center justify-between text-sm mb-4">
                            <div>
                                <p class="font-medium text-gray-700">Date de dépôt:</p>
                                <p class="text-gray-500">18/05/2025</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">Promotion:</p>
                                <p class="text-gray-500">M2 Cybersécurité 2025</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-700 mb-1">Retours:</p>
                            <div class="flex items-center text-sm text-orange-600">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                <span>3 corrections demandées</span>
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <button class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-3 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-eye mr-1"></i> Voir retours
                            </button>
                            <button class="flex-1 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 py-2 px-3 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-envelope mr-1"></i> Notifier
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Dossier Card 4 -->
                <div class="bg-white rounded-lg shadow overflow-hidden fade-in hover:shadow-lg transition-shadow duration-300">
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-bold text-lg text-gray-800">Analyse de sentiment</h3>
                                <p class="text-sm text-gray-500">Étudiant: Sophie Dubois</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">En cours</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-4">Comparaison des modèles de NLP pour l'analyse de sentiment sur les réseaux sociaux.</p>

                        <div class="flex items-center justify-between text-sm mb-4">
                            <div>
                                <p class="font-medium text-gray-700">Date de dépôt:</p>
                                <p class="text-gray-500">15/05/2025</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">Promotion:</p>
                                <p class="text-gray-500">M2 Data Science 2025</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm font-medium text-gray-700 mb-1">Évaluation:</p>
                            <div class="flex items-center text-sm text-blue-600">
                                <i class="fas fa-user-edit mr-1"></i>
                                <span>En cours par M. Dupont</span>
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <button class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white py-2 px-3 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-play mr-1"></i> Reprendre
                            </button>
                            <button class="flex-1 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 py-2 px-3 rounded-md text-sm font-medium transition-colors">
                                <i class="fas fa-share-alt mr-1"></i> Partager
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Table -->
            <div class="bg-white rounded-lg shadow p-6 fade-in">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-table text-gray-600 mr-2"></i>
                        Détails des évaluations
                    </h3>
                    <div class="flex items-center space-x-2">
                        <input type="text" placeholder="Rechercher un dossier..." class="px-3 py-1 text-sm border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promotion</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-600 font-medium">ML</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">Marie Lambert</div>
                                        <div class="text-sm text-gray-500">marie.lambert@edu.fr</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Système de recommandation IA</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">M2 IA 2025</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Nouveau</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-yellow-600 hover:text-yellow-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-download"></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                        <span class="text-green-600 font-medium">JD</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">Jean Dupont</div>
                                        <div class="text-sm text-gray-500">jean.dupont@edu.fr</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Blockchain pour la santé</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">M2 Blockchain 2025</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Validé</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600">16.5/20</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-yellow-600 hover:text-yellow-900 mr-3">
                                    <i class="fas fa-print"></i>
                                </button>
                                <button class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-purple-600 hover:text-purple-900">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center">
                                        <span class="text-orange-600 font-medium">TM</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">Thomas Moreau</div>
                                        <div class="text-sm text-gray-500">thomas.moreau@edu.fr</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Cybersécurité IoT</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">M2 Cybersécurité 2025</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">À corriger</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-orange-600">10.5/20</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-yellow-600 hover:text-yellow-900 mr-3">
                                    <i class="fas fa-redo"></i>
                                </button>
                                <button class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-envelope"></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                        <span class="text-purple-600 font-medium">SD</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">Sophie Dubois</div>
                                        <div class="text-sm text-gray-500">sophie.dubois@edu.fr</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Analyse de sentiment</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">M2 Data Science 2025</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">En cours</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">-</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button class="text-yellow-600 hover:text-yellow-900 mr-3">
                                    <i class="fas fa-play"></i>
                                </button>
                                <button class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="text-gray-600 hover:text-gray-900">
                                    <i class="fas fa-comment"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-between mt-4">
                    <div class="text-sm text-gray-500">
                        Affichage de 1 à 4 sur 12 dossiers
                    </div>
                    <div class="flex space-x-2">
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Précédent
                        </button>
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700">
                            1
                        </button>
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            2
                        </button>
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            3
                        </button>
                        <button class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Suivant
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Notes Distribution -->
                <div class="bg-white rounded-lg shadow p-6 fade-in">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-chart-bar text-blue-600 mr-2"></i>
                            Distribution des notes
                        </h3>
                        <div class="flex items-center space-x-2 text-sm">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-blue-600 rounded-full mr-1"></div>
                                <span>2025</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-gray-300 rounded-full mr-1"></div>
                                <span>2024</span>
                            </div>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="gradesChart"></canvas>
                    </div>
                </div>

                <!-- Status Evolution -->
                <div class="bg-white rounded-lg shadow p-6 fade-in">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">
                            <i class="fas fa-chart-line text-green-600 mr-2"></i>
                            Évolution des évaluations
                        </h3>
                        <button onclick="refreshCharts()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                    <div class="chart-container">
                        <canvas id="statusEvolutionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialisation des graphiques
    document.addEventListener('DOMContentLoaded', function() {
        // Graphique de distribution des notes
        const gradesCtx = document.getElementById('gradesChart').getContext('2d');
        const gradesChart = new Chart(gradesCtx, {
            type: 'bar',
            data: {
                labels: ['0-5', '5-10', '10-12', '12-14', '14-16', '16-18', '18-20'],
                datasets: [{
                    label: '2025',
                    data: [2, 5, 8, 12, 15, 10, 3],
                    backgroundColor: '#3b82f6',
                    borderColor: '#2563eb',
                    borderWidth: 1
                }, {
                    label: '2024',
                    data: [3, 7, 10, 14, 12, 8, 2],
                    backgroundColor: '#e5e7eb',
                    borderColor: '#d1d5db',
                    borderWidth: 1
                }]
            },
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
                }
            }
        });

        // Graphique d'évolution des statuts
        const statusCtx = document.getElementById('statusEvolutionChart').getContext('2d');
        const statusChart = new Chart(statusCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai'],
                datasets: [{
                    label: 'Nouveaux',
                    data: [5, 8, 12, 15, 18],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Validés',
                    data: [3, 6, 10, 14, 20],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'À corriger',
                    data: [2, 4, 5, 8, 7],
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
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

        // Animation des métriques
        const metrics = document.querySelectorAll('.metric-value');
        metrics.forEach((metric, index) => {
            const finalValue = metric.textContent;
            metric.textContent = '0';

            setTimeout(() => {
                const increment = finalValue.includes('/') ? 0.5 : 1;
                const target = parseFloat(finalValue);
                let current = 0;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }

                    if (finalValue.includes('/')) {
                        metric.textContent = current.toFixed(1) + '/20';
                    } else {
                        metric.textContent = Math.round(current);
                    }
                }, 50);
            }, index * 200);
        });

        // Animation d'entrée pour les éléments
        const elements = document.querySelectorAll('.fade-in');
        elements.forEach((el, index) => {
            setTimeout(() => {
                el.style.opacity = '1';
                el.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });

    // Fonction de rafraîchissement
    function refreshCharts() {
        // Simuler le rafraîchissement
        console.log("Actualisation des graphiques...");
        // En réalité, ici vous feriez une requête AJAX pour récupérer les nouvelles données
    }
</script>
</body>
</html>