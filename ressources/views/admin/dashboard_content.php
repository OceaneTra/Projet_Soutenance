<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body class="bg-gray-50 font-sans">

<div class="flex min-h-screen">

    <!-- Main Content -->
    <div class="flex-grow">
        <!-- Top Navigation Bar -->
        <header class="bg-white shadow-sm p-4">
            <div class="container mx-auto flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <button class="md:hidden text-gray-500 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-xl font-bold text-gray-800">Tableau de bord</h1>
                </div>

                <div class="flex items-center space-x-4">


                    <!-- Notifications -->
                    <div class="tooltip">
                        <button
                                class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-500 relative">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-1 right-1 bg-red-500 w-2 h-2 rounded-full"></span>
                        </button>

                    </div>

                    <!-- Messages -->
                    <div class="tooltip">
                        <button
                                class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-500">
                            <i class="fas fa-envelope"></i>
                        </button>

                    </div>

                    <!-- User Profile -->
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-indigo-600 rounded-full overflow-hidden block md:hidden">
                            <img src="/api/placeholder/40/40" alt="User profile"
                                 class="w-full h-full object-cover"/>
                        </div>
                        <div class="hidden md:block">
                            <h3 class="text-sm font-medium">Thomas Martin</h3>
                            <p class="text-xs text-gray-500">Admin</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Dashboard Content -->
        <div class="container mx-auto p-6">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800">Bonjour, Thomas 👋</h2>
                <p class="text-gray-600">Voici votre résumé de performance pour cette semaine</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                <!-- Users Projects Card -->
                <div class="gradient-purple rounded-xl p-6 text-white shadow-lg card-hover">
                    <div class="flex justify-between mb-4">
                        <div class="bg-white bg-opacity-20 w-12 h-12 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-white text-lg"></i>
                        </div>
                        <div class="tooltip">
                            <button class="text-white opacity-70 hover:opacity-100">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <span class="tooltiptext">Plus d'options</span>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold mb-1">178<span class="text-xl font-normal">+</span></h3>
                    <p class="text-sm opacity-80">Projets Utilisateurs</p>
                    <div class="mt-6 flex items-center text-sm">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>4.7% ce mois</span>
                    </div>
                </div>

                <!-- Stock Products Card -->
                <div class="gradient-blue rounded-xl p-6 text-white shadow-lg card-hover">
                    <div class="flex justify-between mb-4">
                        <div class="bg-white bg-opacity-20 w-12 h-12 rounded-xl flex items-center justify-center">
                            <i class="fas fa-cube text-white text-lg"></i>
                        </div>
                        <div class="tooltip">
                            <button class="text-white opacity-70 hover:opacity-100">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <span class="tooltiptext">Plus d'options</span>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold mb-1">20<span class="text-xl font-normal">+</span></h3>
                    <p class="text-sm opacity-80">Produits en Stock</p>
                    <div class="mt-6 flex items-center text-sm">
                        <i class="fas fa-arrow-down mr-1"></i>
                        <span>2.3% ce mois</span>
                    </div>
                </div>

                <!-- Sales Products Card -->
                <div class="gradient-red rounded-xl p-6 text-white shadow-lg card-hover">
                    <div class="flex justify-between mb-4">
                        <div class="bg-white bg-opacity-20 w-12 h-12 rounded-xl flex items-center justify-center">
                            <i class="fas fa-shopping-bag text-white text-lg"></i>
                        </div>
                        <div class="tooltip">
                            <button class="text-white opacity-70 hover:opacity-100">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <span class="tooltiptext">Plus d'options</span>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold mb-1">190<span class="text-xl font-normal">+</span></h3>
                    <p class="text-sm opacity-80">Ventes de Produits</p>
                    <div class="mt-6 flex items-center text-sm">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>8.2% ce mois</span>
                    </div>
                </div>

                <!-- Job Applications Card -->
                <div class="gradient-orange rounded-xl p-6 text-white shadow-lg card-hover">
                    <div class="flex justify-between mb-4">
                        <div class="bg-white bg-opacity-20 w-12 h-12 rounded-xl flex items-center justify-center">
                            <i class="fas fa-briefcase text-white text-lg"></i>
                        </div>
                        <div class="tooltip">
                            <button class="text-white opacity-70 hover:opacity-100">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <span class="tooltiptext">Plus d'options</span>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold mb-1">12<span class="text-xl font-normal">+</span></h3>
                    <p class="text-sm opacity-80">Candidatures</p>
                    <div class="mt-6 flex items-center text-sm">
                        <i class="fas fa-equals mr-1"></i>
                        <span>Stable ce mois</span>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Dashboard Stats -->
                <div class="bg-white rounded-xl shadow-sm p-6 lg:col-span-2 card-hover">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Revenus & Ventes</h2>
                            <p class="text-sm text-gray-500">Vue d'ensemble du mois en cours</p>
                        </div>
                        <div class="flex space-x-1 text-xs bg-gray-100 rounded-lg p-1">
                            <button class="btn-tab px-3 py-1 rounded-md">JOUR</button>
                            <button class="btn-tab px-3 py-1 rounded-md">SEMAINE</button>
                            <button class="btn-tab active px-3 py-1 rounded-md">MOIS</button>
                            <button class="btn-tab px-3 py-1 rounded-md">ANNÉE</button>
                        </div>
                    </div>

                    <!-- Revenue and Sales Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex justify-between items-center mb-2">
                                <p class="text-sm text-gray-500">Revenus</p>
                                <span
                                        class="text-xs bg-green-100 text-green-600 py-1 px-2 rounded-full flex items-center">
                                        <i class="fas fa-arrow-up text-xs mr-1"></i> 12.5%
                                    </span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">6,468.96€</h3>
                            <p class="text-xs text-gray-500">vs 5,489.20€ mois dernier</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex justify-between items-center mb-2">
                                <p class="text-sm text-gray-500">Ventes</p>
                                <span
                                        class="text-xs bg-green-100 text-green-600 py-1 px-2 rounded-full flex items-center">
                                        <i class="fas fa-arrow-up text-xs mr-1"></i> 5.7%
                                    </span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">82</h3>
                            <p class="text-xs text-gray-500">vs 76 mois dernier</p>
                        </div>

                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex justify-between items-center mb-2">
                                <p class="text-sm text-gray-500">Panier Moyen</p>
                                <span
                                        class="text-xs bg-green-100 text-green-600 py-1 px-2 rounded-full flex items-center">
                                        <i class="fas fa-arrow-up text-xs mr-1"></i> 3.2%
                                    </span>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">78.89€</h3>
                            <p class="text-xs text-gray-500">vs 76.45€ mois dernier</p>
                        </div>
                    </div>

                    <!-- Chart -->
                    <div class="chart-container mb-6">
                        <canvas id="earningsChart"></canvas>
                    </div>

                    <!-- Bottom Stats Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <!-- Wallet Balance -->
                        <div class="flex items-center bg-gray-50 p-3 rounded-xl">
                            <div
                                    class="h-10 w-10 rounded-full bg-pink-500 flex items-center justify-center mr-3 shrink-0">
                                <i class="fas fa-wallet text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Solde</p>
                                <p class="text-sm font-semibold">3,567.50€</p>
                            </div>
                        </div>

                        <!-- Referral Earning -->
                        <div class="flex items-center bg-gray-50 p-3 rounded-xl">
                            <div
                                    class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center mr-3 shrink-0">
                                <i class="fas fa-users text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Parrainage</p>
                                <p class="text-sm font-semibold">1,599.93€</p>
                            </div>
                        </div>

                        <!-- Estimate Sales -->
                        <div class="flex items-center bg-gray-50 p-3 rounded-xl">
                            <div
                                    class="h-10 w-10 rounded-full bg-purple-500 flex items-center justify-center mr-3 shrink-0">
                                <i class="fas fa-chart-line text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Prévisions</p>
                                <p class="text-sm font-semibold">2,955.00€</p>
                            </div>
                        </div>

                        <!-- Earning -->
                        <div class="flex items-center bg-gray-50 p-3 rounded-xl">
                            <div
                                    class="h-10 w-10 rounded-full bg-blue-400 flex items-center justify-center mr-3 shrink-0">
                                <i class="fas fa-euro-sign text-white"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Total</p>
                                <p class="text-sm font-semibold">93,987.54€</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Analytics & Recent Activities -->
                <div class="lg:col-span-1">
                    <!-- Analytics -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 card-hover">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-bold text-gray-800">Analytics</h2>
                            <div class="flex items-center">
                                <label class="switch mr-3">
                                    <input type="checkbox" checked>
                                    <span class="slider"></span>
                                </label>
                                <button class="text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-col items-center">
                            <!-- Donut Chart -->
                            <div class="w-40 h-40 mx-auto">
                                <canvas id="analyticsChart"></canvas>
                            </div>

                            <!-- Percentage -->
                            <div class="text-center mt-4">
                                <h3 class="text-3xl font-bold text-gray-800">80%</h3>
                                <p class="text-sm text-gray-500">Taux de conversion</p>
                            </div>
                        </div>

                        <!-- Legend -->
                        <div class="flex justify-center space-x-6 mt-6">
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full bg-indigo-600 mr-2"></div>
                                <span class="text-sm">Ventes</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full bg-yellow-400 mr-2"></div>
                                <span class="text-sm">Distribution</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-4 h-4 rounded-full bg-red-400 mr-2"></div>
                                <span class="text-sm">Retours</span>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activities -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 card-hover">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-lg font-bold text-gray-800">Activités Récentes</h2>
                            <button class="text-indigo-600 text-sm hover:underline">Voir tout</button>
                        </div>

                        <div class="activity-timeline relative">
                            <!-- Activity Item -->
                            <div class="flex mb-6 activity-item">
                                <div class="flex flex-col items-center mr-4">
                                    <div
                                            class="w-10 h-10 rounded-full bg-pink-500 flex items-center justify-center">
                                        <i class="fas fa-tasks text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-center">
                                        <h4 class="text-sm font-semibold text-gray-800">Tâche mise à jour</h4>
                                        <span class="text-xs text-gray-400 ml-2">il y a 40 min</span>
                                    </div>
                                    <p class="text-sm text-gray-600">Nicolas a mis à jour une tâche sur le projet
                                        "Redesign Dashboard"</p>
                                </div>
                            </div>

                            <!-- Activity Item -->
                            <div class="flex mb-6 activity-item">
                                <div class="flex flex-col items-center mr-4">
                                    <div
                                            class="w-10 h-10 rounded-full bg-indigo-600 flex items-center justify-center">
                                        <i class="fas fa-handshake text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-center">
                                        <h4 class="text-sm font-semibold text-gray-800">Nouveau contrat</h4>
                                        <span class="text-xs text-gray-400 ml-2">il y a 1 jour</span>
                                    </div>
                                    <p class="text-sm text-gray-600">Pamela a ajouté un nouveau contrat avec le
                                        client Acme Inc.</p>
                                </div>
                            </div>

                            <!-- Activity Item -->
                            <div class="flex activity-item">
                                <div class="flex flex-col items-center mr-4">
                                    <div
                                            class="w-10 h-10 rounded-full bg-blue-400 flex items-center justify-center">
                                        <i class="fas fa-newspaper text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex items-center">
                                        <h4 class="text-sm font-semibold text-gray-800">Article publié</h4>
                                        <span class="text-xs text-gray-400 ml-2">il y a 2 jours</span>
                                    </div>
                                    <p class="text-sm text-gray-600">Daniel a publié l'article "Comment augmenter
                                        vos ventes"</p>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <!-- Bottom Section -->
            <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Team Members -->
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold text-gray-800">Équipe</h2>
                        <button
                                class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <!-- Team member -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full overflow-hidden mr-3">
                                    <img src="/api/placeholder/40/40" alt="Nicolas Durand"
                                         class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium">Nicolas Durand</h3>
                                    <p class="text-xs text-gray-500">Chef de projet</p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button
                                        class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200">
                                    <i class="fas fa-comment-alt text-xs"></i>
                                </button>
                                <button
                                        class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200">
                                    <i class="fas fa-phone text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Team member -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full overflow-hidden mr-3">
                                    <img src="/api/placeholder/40/40" alt="Pamela Martin"
                                         class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium">Pamela Martin</h3>
                                    <p class="text-xs text-gray-500">Commerciale</p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button
                                        class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200">
                                    <i class="fas fa-comment-alt text-xs"></i>
                                </button>
                                <button
                                        class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200">
                                    <i class="fas fa-phone text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Team member -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full overflow-hidden mr-3">
                                    <img src="/api/placeholder/40/40" alt="Daniel Lefebvre"
                                         class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium">Daniel Lefebvre</h3>
                                    <p class="text-xs text-gray-500">Marketing</p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button
                                        class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200">
                                    <i class="fas fa-comment-alt text-xs"></i>
                                </button>
                                <button
                                        class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200">
                                    <i class="fas fa-phone text-xs"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Team member -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full overflow-hidden mr-3">
                                    <img src="/api/placeholder/40/40" alt="Sophie Bernard"
                                         class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium">Sophie Bernard</h3>
                                    <p class="text-xs text-gray-500">Designer UI/UX</p>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <button
                                        class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200">
                                    <i class="fas fa-comment-alt text-xs"></i>
                                </button>
                                <button
                                        class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200">
                                    <i class="fas fa-phone text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendar -->
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold text-gray-800">Calendrier</h2>
                        <div class="flex space-x-2">
                            <button
                                    class="w-8 h-8 rounded-md bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200">
                                <i class="fas fa-chevron-left text-xs"></i>
                            </button>
                            <button
                                    class="w-8 h-8 rounded-md bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-gray-200">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <div class="text-center mb-4">
                        <h3 class="text-md font-medium text-gray-800">Octobre 2020</h3>
                    </div>

                    <!-- Calendar Grid -->
                    <div class="grid grid-cols-7 gap-2 text-center">
                        <!-- Day Names -->
                        <div class="text-xs text-gray-500 font-medium">Lu</div>
                        <div class="text-xs text-gray-500 font-medium">Ma</div>
                        <div class="text-xs text-gray-500 font-medium">Me</div>
                        <div class="text-xs text-gray-500 font-medium">Je</div>
                        <div class="text-xs text-gray-500 font-medium">Ve</div>
                        <div class="text-xs text-gray-500 font-medium">Sa</div>
                        <div class="text-xs text-gray-500 font-medium">Di</div>

                        <!-- Days -->
                        <div class="h-8 flex items-center justify-center text-sm text-gray-400">28</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-400">29</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-400">30</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">1</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">2</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">3</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">4</div>

                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">5</div>
                        <div
                                class="h-8 flex items-center justify-center text-sm bg-indigo-100 text-indigo-600 rounded-full">
                            6
                        </div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">7</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">8</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">9</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">10</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">11</div>

                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">12</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">13</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">14</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">15</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">16</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">17</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">18</div>

                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">19</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">20</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">21</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">22</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">23</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">24</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">25</div>

                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">26</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">27</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">28</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">29</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">30</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-600">31</div>
                        <div class="h-8 flex items-center justify-center text-sm text-gray-400">1</div>
                    </div>

                    <!-- Upcoming Events -->
                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-gray-800 mb-3">Événements à venir</h3>

                        <div class="space-y-3">
                            <!-- Event -->
                            <div class="flex items-center bg-indigo-50 rounded-lg p-3">
                                <div
                                        class="w-8 h-8 rounded-md bg-indigo-600 flex items-center justify-center text-white mr-3">
                                    <i class="fas fa-video"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium">Réunion équipe</h4>
                                    <p class="text-xs text-gray-500">Aujourd'hui • 14:00</p>
                                </div>
                            </div>

                            <!-- Event -->
                            <div class="flex items-center bg-pink-50 rounded-lg p-3">
                                <div
                                        class="w-8 h-8 rounded-md bg-pink-500 flex items-center justify-center text-white mr-3">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium">Réunion client</h4>
                                    <p class="text-xs text-gray-500">Demain • 10:30</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Order Status -->
                <div class="bg-white rounded-xl shadow-sm p-6 card-hover">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Statut des Commandes</h2>
                            <p class="text-xs text-gray-500">Vue d'ensemble du mois en cours</p>
                        </div>
                        <div class="flex space-x-2">
                            <button
                                    class="w-8 h-8 bg-indigo-600 rounded-md flex items-center justify-center text-white">
                                <i class="fas fa-filter text-xs"></i>
                            </button>
                            <button
                                    class="w-8 h-8 bg-gray-200 hover:bg-gray-300 rounded-md flex items-center justify-center text-gray-600">
                                <i class="fas fa-sync-alt text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Search -->
                    <div class="mb-4 relative">
                        <input type="text" placeholder="Rechercher une commande..."
                               class="w-full bg-gray-100 rounded-lg py-2 pl-10 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-search"></i>
                            </span>
                    </div>

                    <!-- Orders -->
                    <div class="max-h-64 overflow-y-auto scrollbar-hide">
                        <table class="w-full text-sm table-hover">
                            <thead class="bg-gray-50 sticky top-0">
                            <tr class="text-gray-500 uppercase text-xs">
                                <th class="py-3 pl-4 pr-2 text-left">N°</th>
                                <th class="py-3 px-2 text-left">Client</th>
                                <th class="py-3 px-2 text-left">Région</th>
                                <th class="py-3 px-2 text-left">Montant</th>
                                <th class="py-3 px-2 text-left">Statut</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 pl-4 pr-2">12396</td>
                                <td class="py-3 px-2">
                                    <div class="flex items-center">
                                        <div
                                                class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center mr-2">
                                            <span class="text-xs font-medium text-purple-600">CJ</span>
                                        </div>
                                        <span>Christy Jean</span>
                                    </div>
                                </td>
                                <td class="py-3 px-2">Russie</td>
                                <td class="py-3 px-2 font-medium">2 652€</td>
                                <td class="py-3 px-2">
                                            <span
                                                    class="px-3 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-600">
                                                En cours
                                            </span>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 pl-4 pr-2">12398</td>
                                <td class="py-3 px-2">
                                    <div class="flex items-center">
                                        <div
                                                class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-2">
                                            <span class="text-xs font-medium text-blue-600">LM</span>
                                        </div>
                                        <span>Luc Moreau</span>
                                    </div>
                                </td>
                                <td class="py-3 px-2">France</td>
                                <td class="py-3 px-2 font-medium">1 845€</td>
                                <td class="py-3 px-2">
                                            <span
                                                    class="px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-600">
                                                En attente
                                            </span>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 pl-4 pr-2">12401</td>
                                <td class="py-3 px-2">
                                    <div class="flex items-center">
                                        <div
                                                class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center mr-2">
                                            <span class="text-xs font-medium text-green-600">AD</span>
                                        </div>
                                        <span>Alain Dupont</span>
                                    </div>
                                </td>
                                <td class="py-3 px-2">Belgique</td>
                                <td class="py-3 px-2 font-medium">3 205€</td>
                                <td class="py-3 px-2">
                                            <span
                                                    class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-600">
                                                Livré
                                            </span>
                                </td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="py-3 pl-4 pr-2">12405</td>
                                <td class="py-3 px-2">
                                    <div class="flex items-center">
                                        <div
                                                class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center mr-2">
                                            <span class="text-xs font-medium text-red-600">MB</span>
                                        </div>
                                        <span>Marie Blanc</span>
                                    </div>
                                </td>
                                <td class="py-3 px-2">Suisse</td>
                                <td class="py-3 px-2 font-medium">1 276€</td>
                                <td class="py-3 px-2">
                                            <span
                                                    class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-600">
                                                Expédié
                                            </span>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-between items-center mt-4">
                        <div class="text-xs text-gray-500">
                            Affichage de 1-4 sur 28 commandes
                        </div>
                        <div class="flex space-x-1">
                            <button
                                    class="w-8 h-8 flex items-center justify-center rounded-md bg-gray-100 text-gray-600 hover:bg-gray-200">
                                <i class="fas fa-chevron-left text-xs"></i>
                            </button>
                            <button
                                    class="w-8 h-8 flex items-center justify-center rounded-md bg-indigo-600 text-white">
                                1
                            </button>
                            <button
                                    class="w-8 h-8 flex items-center justify-center rounded-md bg-gray-100 text-gray-600 hover:bg-gray-200">
                                2
                            </button>
                            <button
                                    class="w-8 h-8 flex items-center justify-center rounded-md bg-gray-100 text-gray-600 hover:bg-gray-200">
                                3
                            </button>
                            <button
                                    class="w-8 h-8 flex items-center justify-center rounded-md bg-gray-100 text-gray-600 hover:bg-gray-200">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>

<script>
    // Area Chart for Earnings
    const earningsCtx = document.getElementById('earningsChart').getContext('2d');
    const earningsChart = new Chart(earningsCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct'],
            datasets: [{
                label: 'Revenus',
                data: [3200, 3800, 3000, 5000, 4500, 6000, 7000, 6500, 5800, 6468],
                borderColor: '#EC4899',
                backgroundColor: 'rgba(236, 72, 153, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 2
            },
                {
                    label: 'Ventes',
                    data: [2800, 3200, 2500, 4000, 3800, 5000, 5800, 5200, 4800, 5200],
                    borderColor: '#4F46E5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    padding: 10,
                    titleColor: '#111827',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyColor: '#4B5563',
                    bodyFont: {
                        size: 12
                    },
                    backgroundColor: '#FFF',
                    borderColor: '#E5E7EB',
                    borderWidth: 1,
                    displayColors: true,
                    callbacks: {
                        label: function (context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat('fr-FR', {
                                    style: 'currency',
                                    currency: 'EUR'
                                }).format(context.parsed.y);
                            }
                            return label;
                        }
                    }
                },
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: {
                        boxWidth: 12,
                        padding: 20,
                        usePointStyle: true
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 10
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#F3F4F6'
                    },
                    ticks: {
                        font: {
                            size: 10
                        },
                        callback: function (value) {
                            return value + '€';
                        }
                    }
                }
            },
            elements: {
                point: {
                    radius: 0,
                    hoverRadius: 6,
                    hitRadius: 6
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // Donut Chart for Analytics
    const analyticsCtx = document.getElementById('analyticsChart').getContext('2d');
    const analyticsChart = new Chart(analyticsCtx, {
        type: 'doughnut',
        data: {
            labels: ['Ventes', 'Distribution', 'Retours'],
            datasets: [{
                data: [55, 25, 20],
                backgroundColor: [
                    '#4F46E5',
                    '#FBBF24',
                    '#F87171'
                ],
                borderWidth: 0,
                cutout: '75%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    padding: 10,
                    titleColor: '#111827',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyColor: '#4B5563',
                    bodyFont: {
                        size: 12
                    },
                    backgroundColor: '#FFF',
                    borderColor: '#E5E7EB',
                    borderWidth: 1,
                    displayColors: true
                }
            }
        }
    });

    // Initialize tabs
    document.querySelectorAll('.btn-tab').forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            document.querySelectorAll('.btn-tab').forEach(btn => {
                btn.classList.remove('active');
            });
            // Add active class to clicked button
            button.classList.add('active');
        });
    });
</script>