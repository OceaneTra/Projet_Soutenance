<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsable Scolarité | Tableau de bord</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #f0f9ff 0%, #e6f7ff 100%);
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .hover-scale {
            transition: transform 0.3s ease;
        }
        .hover-scale:hover {
            transform: scale(1.03);
        }
        .sidebar-item.active {
            background-color: #e6f7ff;
            border-left: 4px solid #3b82f6;
            color: #3b82f6;
        }
        .sidebar-item.active i {
            color: #3b82f6;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 border-r border-gray-200 bg-white">
                <div class="flex items-center justify-center h-16 px-4 bg-blue-100 shadow-sm">
                    <div class="flex overflow-hidden items-center">
                        <a href="#" class="text-blue-500 font-bold text-xl">Gestion Scolarité</a>
                    </div>
                </div>
                <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto">
                    <div class="space-y-1 pb-3">
                        <a href="dashboard.html" class="sidebar-item active flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-tachometer-alt mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Tableau de bord
                        </a>
                        <a href="enregistrement.html" class="sidebar-item flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-user-plus mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Enregistrement
                        </a>
                        <a href="Gestion des notes.html" class="sidebar-item flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-graduation-cap mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Saisie des notes
                        </a>
                        <!-- ... autres liens du menu ... -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top navigation -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 bg-blue-100 shadow-sm">
                <div class="flex items-center">
                    <button id="mobileMenuButton" class="md:hidden text-gray-500 focus:outline-none mr-3">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="text-lg font-medium text-blue-500" id="pageTitle">Tableau de bord</h1>
                </div>
                <!-- ... éléments de navigation ... -->
            </div>

            <!-- Main content area -->
            <div class="flex-1 p-4 md:p-6 overflow-y-auto gradient-bg">
                <div class="max-w-7xl mx-auto">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tableau de bord</h1>
                    
                    <!-- Statistiques principales -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                        <div class="bg-white p-4 rounded-lg shadow-sm hover-scale">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Étudiants inscrits</p>
                                    <p class="text-2xl font-bold text-gray-800">1,245</p>
                                    <p class="text-xs text-gray-500">+12% vs l'an dernier</p>
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
                                    <p class="text-2xl font-bold text-gray-800">87</p>
                                    <p class="text-xs text-gray-500">+5 cette semaine</p>
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
                                    <p class="text-2xl font-bold text-gray-800">23</p>
                                    <p class="text-xs text-gray-500">3 en attente > 1 semaine</p>
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
                                    <p class="text-2xl font-bold text-gray-800">15</p>
                                    <p class="text-xs text-gray-500">Total: 12,450€</p>
                                </div>
                                <div class="p-3 rounded-full bg-red-100 text-red-500">
                                    <i class="fas fa-euro-sign text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Graphiques et autres éléments du dashboard -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                        <div class="lg:col-span-2 bg-white p-4 rounded-lg shadow-sm">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Inscriptions par formation</h2>
                            <!-- Placeholder for chart -->
                            <div class="h-64 bg-gray-100 rounded flex items-center justify-center text-gray-400">
                                Graphique des inscriptions
                            </div>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Activités récentes</h2>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500 mr-3">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Nouvel étudiant enregistré</p>
                                        <p class="text-xs text-gray-500">Jean Dupont - Master Informatique</p>
                                        <p class="text-xs text-gray-400">Il y a 2 heures</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-500 mr-3">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Notes validées</p>
                                        <p class="text-xs text-gray-500">UE Programmation Avancée - 25 étudiants</p>
                                        <p class="text-xs text-gray-400">Il y a 5 heures</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-500 mr-3">
                                        <i class="fas fa-euro-sign"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Paiement reçu</p>
                                        <p class="text-xs text-gray-500">Marie Lambert - 850€</p>
                                        <p class="text-xs text-gray-400">Il y a 1 jour</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Quick actions -->
                    <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Actions rapides</h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <a href="enregistrement.html" class="p-3 bg-blue-50 rounded-md text-center hover:bg-blue-100 transition">
                                <i class="fas fa-user-plus text-blue-500 text-xl mb-2"></i>
                                <p class="text-sm font-medium text-gray-800">Nouvel étudiant</p>
                            </a>
                            <a href="note.html" class="p-3 bg-green-50 rounded-md text-center hover:bg-green-100 transition">
                                <i class="fas fa-graduation-cap text-green-500 text-xl mb-2"></i>
                                <p class="text-sm font-medium text-gray-800">Saisir notes</p>
                            </a>
                            <a href="#" class="p-3 bg-purple-50 rounded-md text-center hover:bg-purple-100 transition">
                                <i class="fas fa-file-invoice-dollar text-purple-500 text-xl mb-2"></i>
                                <p class="text-sm font-medium text-gray-800">Générer facture</p>
                            </a>
                            <a href="#" class="p-3 bg-orange-50 rounded-md text-center hover:bg-orange-100 transition">
                                <i class="fas fa-chart-bar text-orange-500 text-xl mb-2"></i>
                                <p class="text-sm font-medium text-gray-800">Voir statistiques</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>