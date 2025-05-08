<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NeoBank Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #f0f2f5;
        font-family: 'Inter', sans-serif;
    }

    .bank-card {
        transition: all 0.2s ease;
    }

    .bank-card:hover {
        transform: translateY(-5px);
    }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6 max-w-6xl">
        <div class="bg-white rounded-xl p-8 shadow-sm mb-6">
            <!-- Header avec navigation -->
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center">
                    <div
                        class="w-8 h-8 bg-emerald-500 rounded-md flex items-center justify-center text-white font-bold mr-2">
                        N</div>
                    <span class="font-bold">NeoBank</span>
                </div>

                <div class="flex space-x-8">
                    <span class="font-medium text-sm border-b-2 border-emerald-500 text-emerald-500 pb-1">My
                        account</span>
                    <span class="font-medium text-sm text-gray-500">Transactions</span>
                    <span class="font-medium text-sm text-gray-500">Cards</span>
                    <span class="font-medium text-sm text-gray-500">Offers</span>
                    <span class="font-medium text-sm text-gray-500">Investments</span>
                </div>

                <div class="flex items-center space-x-4">
                    <i class="fas fa-search text-gray-400"></i>
                    <i class="far fa-bell text-gray-400"></i>
                    <i class="fas fa-th-large text-gray-400"></i>
                    <div class="flex items-center">
                        <span class="text-sm font-medium mr-2">Dorothy Watkins</span>
                        <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                    </div>
                </div>
            </div>

            <!-- Compte principal -->
            <div class="flex justify-between items-start mb-8">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Main account</p>
                    <h2 class="font-bold text-lg mb-1">NeoBank Savings Account</h2>
                    <p class="text-xs text-gray-400">BE XXXX XXXX XXXX XXXX XXXX</p>
                </div>

                <div class="text-right">
                    <p class="text-sm text-gray-500 mb-1">Available funds</p>
                    <h2 class="font-bold text-2xl">68.789,56 $</h2>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex space-x-4 mb-6">
                <button class="bg-emerald-500 text-white py-2 px-4 rounded-md text-sm font-medium">Transfer
                    money</button>
                <button class="border border-emerald-500 text-emerald-500 py-2 px-4 rounded-md text-sm font-medium">Link
                    accounts</button>
            </div>

            <!-- Section de standing orders -->
            <div class="bg-emerald-50 border border-emerald-100 rounded-lg p-4 flex justify-between items-center">
                <div class="flex-1">
                    <h3 class="font-bold text-emerald-700 mb-2">Define standing orders</h3>
                    <p class="text-xs text-emerald-600 max-w-sm">We have you reminded about recurring payments you make
                        regularly. Standing orders help save time and manage your finances.</p>
                    <button
                        class="mt-4 bg-white border border-emerald-500 text-emerald-500 py-1 px-3 rounded-md text-xs font-medium">Define
                        standing order</button>
                </div>
                <div class="w-16 h-16 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                        <i class="far fa-calendar-alt text-emerald-500 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cartes bancaires -->
        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="bank-card bg-white p-4 rounded-xl shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-medium text-sm">Santander</span>
                    <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                        <span class="text-white text-xs font-bold">S</span>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mb-1">BE XXXX XXXX</p>
                <h3 class="font-bold text-lg">12.220,45 $</h3>
            </div>

            <div class="bank-card bg-white p-4 rounded-xl shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-medium text-sm">CityBank</span>
                    <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                        <span class="text-white text-xs font-bold">C</span>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mb-1">BE XXXX XXXX</p>
                <h3 class="font-bold text-lg">25.070,45 $</h3>
            </div>

            <div class="bank-card bg-white p-4 rounded-xl shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-medium text-sm">Deutsche Bank</span>
                    <div class="w-8 h-8 bg-blue-800 rounded-md flex items-center justify-center">
                        <span class="text-white text-xs font-bold">DB</span>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mb-1">BE XXXX XXXX</p>
                <h3 class="font-bold text-lg">570,00 $</h3>
            </div>

            <div class="bank-card bg-white p-4 rounded-xl shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-medium text-sm">Credit Agricole</span>
                    <div class="w-8 h-8 bg-green-600 rounded-md flex items-center justify-center">
                        <span class="text-white text-xs font-bold">CA</span>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mb-1">BE XXXX XXXX</p>
                <h3 class="font-bold text-lg">2.680,50 $</h3>
            </div>
        </div>

        <!-- Transactions et dépenses -->
        <div class="grid grid-cols-2 gap-6">
            <!-- Dernières transactions -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-lg">Latest transactions</h3>
                    <button class="bg-emerald-50 text-emerald-500 w-8 h-8 rounded-md flex items-center justify-center">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <div class="space-y-4">
                    <!-- Transaction item -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-100 rounded-md flex items-center justify-center mr-3">
                                <i class="fas fa-coffee text-gray-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Starbucks Cafe</p>
                                <p class="text-xs text-gray-400">Today • Card payment</p>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-red-500">- 18,00 $</span>
                    </div>

                    <!-- Transaction item -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-100 rounded-md flex items-center justify-center mr-3">
                                <i class="fas fa-coffee text-gray-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">DP White Outlet Street 47</p>
                                <p class="text-xs text-gray-400">Today • Card payment</p>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-red-500">- 256,45 $</span>
                    </div>

                    <!-- Transaction item -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-orange-100 rounded-md flex items-center justify-center mr-3">
                                <i class="fas fa-film text-orange-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Spotify Premium</p>
                                <p class="text-xs text-gray-400">26.08 • Tax</p>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-red-500">- 10,00 $</span>
                    </div>

                    <!-- Transaction item -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-md flex items-center justify-center mr-3">
                                <i class="fas fa-shopping-bag text-green-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Google Inc</p>
                                <p class="text-xs text-gray-400">26.08 • Transfer</p>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-red-500">- 9.500 $</span>
                    </div>

                    <!-- Transaction item -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-100 rounded-md flex items-center justify-center mr-3">
                                <i class="fas fa-coffee text-gray-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Allegro Sp z.o.o</p>
                                <p class="text-xs text-gray-400">18.08 • Bill</p>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-red-500">- 25,87 $</span>
                    </div>

                    <!-- Transaction item -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-md flex items-center justify-center mr-3">
                                <i class="fas fa-pills text-blue-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Super-Pharm Warsaw</p>
                                <p class="text-xs text-gray-400">16.08 • Bill</p>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-red-500">- 89,95 $</span>
                    </div>

                    <!-- Transaction item -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-100 rounded-md flex items-center justify-center mr-3">
                                <i class="fas fa-utensils text-gray-500 text-xs"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Carrefour Express</p>
                                <p class="text-xs text-gray-400">16.08 • Card payment</p>
                            </div>
                        </div>
                        <span class="text-sm font-medium text-red-500">- 45,78 $</span>
                    </div>
                </div>

                <button class="mt-6 text-emerald-500 text-sm font-medium flex items-center justify-center w-full">
                    See more <i class="fas fa-chevron-down ml-1"></i>
                </button>
            </div>

            <!-- Toutes les dépenses -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-lg">All expenses</h3>
                    <button class="bg-emerald-50 text-emerald-500 w-8 h-8 rounded-md flex items-center justify-center">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-8">
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Daily</p>
                        <p class="font-bold text-lg">275,40 $</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Weekly</p>
                        <p class="font-bold text-lg">1.430,85 $</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 mb-1">Monthly</p>
                        <p class="font-bold text-lg">8.200,00 $</p>
                    </div>
                </div>

                <p class="text-sm font-medium mb-4">Last month</p>

                <!-- Chart représentant les dépenses en cercle -->
                <div class="flex justify-center mb-6">
                    <div class="relative w-40 h-40">
                        <svg viewBox="0 0 36 36" class="w-40 h-40 transform -rotate-90">
                            <!-- Graphique en donut avec différentes sections colorées -->
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none" stroke="#E5E7EB" stroke-width="3" />
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 12 26" fill="none" stroke="#FA8072"
                                stroke-width="3" stroke-dasharray="30, 100" />
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 -12 26" fill="none" stroke="#6366F1"
                                stroke-width="3" stroke-dasharray="25, 100" />
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 -12 -6" fill="none" stroke="#F97316"
                                stroke-width="3" stroke-dasharray="20, 100" />
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 12 -6" fill="none" stroke="#22C55E"
                                stroke-width="3" stroke-dasharray="15, 100" />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center flex-col">
                            <p class="font-bold text-2xl">8.400 $</p>
                        </div>
                    </div>
                </div>

                <!-- Légende du graphique -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-gray-300 mr-2"></div>
                            <span class="text-sm">Other</span>
                        </div>
                        <span class="text-sm font-medium">950 $</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-blue-500 mr-2"></div>
                            <span class="text-sm">Bills</span>
                        </div>
                        <span class="text-sm font-medium">1.500 $</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-red-400 mr-2"></div>
                            <span class="text-sm">Entertainment</span>
                        </div>
                        <span class="text-sm font-medium">2.450 $</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                            <span class="text-sm">Health</span>
                        </div>
                        <span class="text-sm font-medium">1.200 $</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-yellow-500 mr-2"></div>
                            <span class="text-sm">Education</span>
                        </div>
                        <span class="text-sm font-medium">800 $</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-purple-500 mr-2"></div>
                            <span class="text-sm">Clothes</span>
                        </div>
                        <span class="text-sm font-medium">1.500 $</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Placeholder data - in a real application, this would come from your backend
    $stats = [
        ['label' => 'Utilisateurs Actifs', 'value' => 120, 'icon' => 'fa-users', 'color' => 'bg-blue-500'],
        ['label' => 'Étudiants Inscrits', 'value' => 850, 'icon' => 'fa-user-graduate', 'color' => 'bg-green-500'],
        ['label' => 'Employés RH', 'value' => 45, 'icon' => 'fa-id-badge', 'color' => 'bg-yellow-500'],
        ['label' => 'Nouveaux Audits (24h)', 'value' => 78, 'icon' => 'fa-history', 'color' => 'bg-indigo-500'],
    ];

    $quickLinks = [
        ['label' => 'Gérer les Utilisateurs', 'link' => '?page=gestion_utilisateurs', 'icon' => 'fa-user-cog'],
        ['label' => 'Gérer les Étudiants', 'link' => '?page=gestion_etudiants', 'icon' => 'fa-book-reader'],
        ['label' => 'Paramètres Généraux', 'link' => '?page=parametres_generaux', 'icon' => 'fa-gears'],
    ];
    ?>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-semibold text-gray-800 mb-8">Tableau de Bord</h1>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <?php foreach ($stats as $stat): ?>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <div class="flex items-center">
                    <div class="p-3 rounded-full <?php echo htmlspecialchars($stat['color']); ?> text-white mr-4">
                        <i class="fas <?php echo htmlspecialchars($stat['icon']); ?> fa-2x"></i>
                    </div>
                    <div>
                        <p class="text-3xl font-semibold text-gray-700"><?php echo htmlspecialchars($stat['value']); ?>
                        </p>
                        <p class="text-gray-500"><?php echo htmlspecialchars($stat['label']); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Quick Links -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Accès Rapides</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($quickLinks as $link): ?>
                <a href="<?php echo htmlspecialchars($link['link']); ?>"
                    class="bg-white p-6 rounded-lg shadow hover:shadow-xl transition-shadow flex items-center text-green-600 hover:text-green-700">
                    <i class="fas <?php echo htmlspecialchars($link['icon']); ?> fa-2x mr-4"></i>
                    <span class="text-lg font-medium"><?php echo htmlspecialchars($link['label']); ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Placeholder for Charts or other widgets -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Activité Récente (Graphique)</h3>
                <div class="h-64 bg-gray-200 flex items-center justify-center rounded">
                    <p class="text-gray-500">Placeholder pour un graphique</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Notifications</h3>
                <ul class="space-y-2">
                    <li class="text-gray-600"><i class="fas fa-bell text-yellow-500 mr-2"></i>Nouvelle inscription en
                        attente.</li>
                    <li class="text-gray-600"><i class="fas fa-bell text-yellow-500 mr-2"></i>Sauvegarde planifiée ce
                        soir.</li>
                </ul>
            </div>
        </div>

    </div>
</body>

</html>