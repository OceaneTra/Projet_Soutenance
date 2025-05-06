<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Utilisateurs | ScholarSync</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }
        
        .sidebar-item:hover .sidebar-icon {
            transform: translateX(3px);
        }
        
        .user-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .role-admin { background-color: #3c9e5f; color: white; }
        .role-teacher { background-color: #e7eeea; color: #2d3748; }
        .role-student { background-color: #f0f4f7; color: #2d3748; }
        
        [x-cloak] { display: none !important; }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c7d2fe;
            border-radius: 10px;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 bg-white border-r border-gray-200">
                <div class="flex items-center justify-center h-16 px-4">
                    <div class="flex items-center">
                        <i class="fas fa-graduation-cap text-3c9e5f text-2xl mr-2"></i>
                        <span class="text-gray-800 font-semibold text-xl">ScholarSync</span>
                    </div>
                </div>
                <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto">
                    <!-- Navigation menu -->
                    <div class="space-y-1">
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium text-gray-600 hover:text-3c9e5f hover:bg-e7eeea rounded-lg sidebar-item">
                            <i class="fas fa-home sidebar-icon mr-3"></i>
                            Dashboard
                        </a>
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium text-white bg-3c9e5f rounded-lg group">
                            <i class="fas fa-users sidebar-icon mr-3"></i>
                            Gestion des Utilisateurs
                        </a>
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium text-gray-600 hover:text-3c9e5f hover:bg-e7eeea rounded-lg sidebar-item">
                            <i class="fas fa-user-tie sidebar-icon mr-3"></i>
                            Ressources Humaines
                        </a>
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium text-gray-600 hover:text-3c9e5f hover:bg-e7eeea rounded-lg sidebar-item">
                            <i class="fas fa-book sidebar-icon mr-3"></i>
                            Unités d'Enseignement
                        </a>
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium text-gray-600 hover:text-3c9e5f hover:bg-e7eeea rounded-lg sidebar-item">
                            <i class="fas fa-file-alt sidebar-icon mr-3"></i>
                            Mémoires & Thèses
                        </a>
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium text-gray-600 hover:text-3c9e5f hover:bg-e7eeea rounded-lg sidebar-item">
                            <i class="fas fa-cog sidebar-icon mr-3"></i>
                            Paramètres
                        </a>
                    </div>
                    
                    <!-- Admin panel -->
                    <div class="mt-auto mb-4">
                        <div class="p-4 bg-e7eeea rounded-lg">
                            <h4 class="text-gray-800 text-sm font-medium mb-2">Accès Administrateur</h4>
                            <p class="text-gray-600 text-xs">Vous avez les droits complets sur la plateforme</p>
                            <div class="mt-3 flex items-center text-xs text-gray-600">
                                <i class="fas fa-shield-alt mr-2"></i>
                                <span>Niveau d'accès: Super Admin</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top navigation -->
            <div class="flex items-center justify-between h-16 px-4 bg-white border-b border-gray-200">
                <div class="flex items-center">
                    <button class="md:hidden text-gray-500 focus:outline-none mr-2">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-800">Gestion des Utilisateurs</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Search bar -->
                    <div class="relative">
                        <input type="text" placeholder="Rechercher un utilisateur..." class="pl-8 pr-4 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-3c9e5f focus:border-3c9e5f">
                        <i class="fas fa-search absolute left-3 top-2 text-gray-400"></i>
                    </div>
                    
                    <!-- Notifications -->
                    <div class="relative">
                        <button class="text-gray-500 focus:outline-none">
                            <i class="fas fa-bell"></i>
                        </button>
                        <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                    </div>
                    
                    <!-- User profile -->
                    <div class="flex items-center">
                        <div class="relative">
                            <img class="h-8 w-8 rounded-full object-cover" src="https://randomuser.me/api/portraits/men/32.jpg" alt="User profile">
                            <span class="absolute bottom-0 right-0 h-2 w-2 rounded-full bg-green-500 border border-white"></span>
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-700 hidden md:inline">Admin</span>
                    </div>
                </div>
            </div>
            
            <!-- Main content area -->
            <div class="flex-1 overflow-auto p-4 md:p-6">
                <!-- Action toolbar -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
                    <div class="mb-4 md:mb-0">
                        <h2 class="text-xl font-bold text-gray-800">Liste des Utilisateurs</h2>
                        <p class="text-sm text-gray-600">Gérez les comptes et permissions des utilisateurs</p>
                    </div>
                    <div class="flex space-x-3">
                        <button onclick="openAddUserModal()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-3c9e5f hover:bg-2e7d4f">
                            <i class="fas fa-user-plus mr-2"></i> Ajouter un utilisateur
                        </button>
                        <button class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fas fa-file-export mr-2"></i> Exporter
                        </button>
                        <button class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fas fa-filter mr-2"></i> Filtres avancés
                        </button>
                    </div>
                </div>
                
                <!-- Stats cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <!-- Total users -->
                    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-3c9e5f">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-e7eeea text-3c9e5f mr-4">
                                <i class="fas fa-users text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Utilisateurs totaux</p>
                                <p class="text-2xl font-semibold text-gray-800">356</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Active users -->
                    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-400">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-50 text-green-600 mr-4">
                                <i class="fas fa-user-check text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Utilisateurs actifs</p>
                                <p class="text-2xl font-semibold text-gray-800">312</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Admin users -->
                    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-3c9e5f">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-e7eeea text-3c9e5f mr-4">
                                <i class="fas fa-shield-alt text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Administrateurs</p>
                                <p class="text-2xl font-semibold text-gray-800">15</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Inactive users -->
                    <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-400">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-50 text-yellow-600 mr-4">
                                <i class="fas fa-user-clock text-lg"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Inactifs</p>
                                <p class="text-2xl font-semibold text-gray-800">44</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- User list -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-e7eeea">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Utilisateur
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Groupe
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Login
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Fonction
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Niveau d'accès
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-700 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- User 1 -->
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/women/44.jpg" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Sophie Martin</div>
                                                <div class="text-sm text-gray-500">ID: 45872</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Enseignants
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        smartin
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        sophie.martin@univ.fr
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full role-teacher">
                                            Professeur
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        P
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-3c9e5f hover:text-2e7d4f mr-3"><i class="fas fa-eye"></i></button>
                                        <button class="text-3c9e5f hover:text-2e7d4f mr-3"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                                
                                <!-- User 2 -->
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/32.jpg" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Thomas Leroy</div>
                                                <div class="text-sm text-gray-500">ID: 45873</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Administratif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        tleroy
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        thomas.leroy@univ.fr
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full role-admin">
                                            Administrateur
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        A
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-3c9e5f hover:text-2e7d4f mr-3"><i class="fas fa-eye"></i></button>
                                        <button class="text-3c9e5f hover:text-2e7d4f mr-3"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                                
                                <!-- User 3 -->
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/12.jpg" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Jean Dupont</div>
                                                <div class="text-sm text-gray-500">ID: 45874</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Étudiants
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        jdupont
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        jean.dupont@etu.univ.fr
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full role-student">
                                            Étudiant
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        E
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-3c9e5f hover:text-2e7d4f mr-3"><i class="fas fa-eye"></i></button>
                                        <button class="text-3c9e5f hover:text-2e7d4f mr-3"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                                
                                <!-- User 4 -->
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/women/32.jpg" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Marie Bernard</div>
                                                <div class="text-sm text-gray-500">ID: 45875</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Enseignants
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        mbernard
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        marie.bernard@univ.fr
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full role-teacher">
                                            Maître de conférences
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        P
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-3c9e5f hover:text-2e7d4f mr-3"><i class="fas fa-eye"></i></button>
                                        <button class="text-3c9e5f hover:text-2e7d4f mr-3"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                                
                                <!-- User 5 -->
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full" src="https://randomuser.me/api/portraits/men/44.jpg" alt="">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">Pierre Lambert</div>
                                                <div class="text-sm text-gray-500">ID: 45876</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Direction
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        plambert
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        pierre.lambert@univ.fr
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full role-admin">
                                            Directeur
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        A
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-3c9e5f hover:text-2e7d4f mr-3"><i class="fas fa-eye"></i></button>
                                        <button class="text-3c9e5f hover:text-2e7d4f mr-3"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                        <div class="flex-1 flex justify-between sm:hidden">
                            <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Précédent
                            </a>
                            <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Suivant
                            </a>
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700">
                                    Affichage de <span class="font-medium">1</span> à <span class="font-medium">5</span> sur <span class="font-medium">356</span> utilisateurs
                                </p>
                            </div>
                            <div>
                                <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Précédent</span>
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                    <a href="#" aria-current="page" class="z-10 bg-3c9e5f border-3c9e5f text-white relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        1
                                    </a>
                                    <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        2
                                    </a>
                                    <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        3
                                    </a>
                                    <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                        ...
                                    </span>
                                    <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        72
                                    </a>
                                    <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Suivant</span>
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add User Modal -->
    <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="addUserModal">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-e7eeea text-3c9e5f sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Ajouter un nouvel utilisateur
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Remplissez les informations pour créer un nouveau compte utilisateur.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-5">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <!-- First Name -->
                            <div class="sm:col-span-3">
                                <label for="first-name" class="block text-sm font-medium text-gray-700">Prénom</label>
                                <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="mt-1 focus:ring-3c9e5f focus:border-3c9e5f block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            
                            <!-- Last Name -->
                            <div class="sm:col-span-3">
                                <label for="last-name" class="block text-sm font-medium text-gray-700">Nom</label>
                                <input type="text" name="last-name" id="last-name" autocomplete="family-name" class="mt-1 focus:ring-3c9e5f focus:border-3c9e5f block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            
                            <!-- Email -->
                            <div class="sm:col-span-6">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" autocomplete="email" class="mt-1 focus:ring-3c9e5f focus:border-3c9e5f block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            
                            <!-- Username -->
                            <div class="sm:col-span-3">
                                <label for="username" class="block text-sm font-medium text-gray-700">Nom d'utilisateur</label>
                                <input type="text" name="username" id="username" class="mt-1 focus:ring-3c9e5f focus:border-3c9e5f block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            
                            <!-- Group -->
                            <div class="sm:col-span-3">
                                <label for="group" class="block text-sm font-medium text-gray-700">Groupe</label>
                                <select id="group" name="group" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-3c9e5f focus:border-3c9e5f sm:text-sm">
                                    <option>Sélectionner un groupe</option>
                                    <option>Enseignants</option>
                                    <option>Étudiants</option>
                                    <option>Administratif</option>
                                    <option>Direction</option>
                                    <option>Technique</option>
                                </select>
                            </div>
                            
                            <!-- Role -->
                            <div class="sm:col-span-3">
                                <label for="role" class="block text-sm font-medium text-gray-700">Fonction</label>
                                <select id="role" name="role" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-3c9e5f focus:border-3c9e5f sm:text-sm">
                                    <option>Sélectionner une fonction</option>
                                    <option>Professeur</option>
                                    <option>Maître de conférences</option>
                                    <option>Chargé de cours</option>
                                    <option>Étudiant</option>
                                    <option>Administrateur</option>
                                    <option>Directeur</option>
                                </select>
                            </div>
                            
                            <!-- Access Level -->
                            <div class="sm:col-span-3">
                                <label for="access-level" class="block text-sm font-medium text-gray-700">Niveau d'accès</label>
                                <select id="access-level" name="access-level" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-3c9e5f focus:border-3c9e5f sm:text-sm">
                                    <option>E - Étudiant</option>
                                    <option>P - Professeur</option>
                                    <option>A - Administrateur</option>
                                    <option>S - Super Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-3c9e5f text-base font-medium text-white hover:bg-2e7d4f focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Enregistrer
                    </button>
                    <button type="button" onclick="closeAddUserModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openAddUserModal() {
            document.getElementById('addUserModal').classList.remove('hidden');
        }

        function closeAddUserModal() {
            document.getElementById('addUserModal').classList.add('hidden');
        }
    </script>
</body>
</html>