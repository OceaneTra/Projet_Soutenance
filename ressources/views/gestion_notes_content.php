<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsable Scolarité | Gestion des Étudiants</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #f0f9ff 0%, #e6f7ff 100%);
        }
        .progress-ring__circle {
            transition: stroke-dashoffset 0.35s;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
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
        .note-input:focus {
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .search-container {
            position: relative;
        }
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 10;
            max-height: 300px;
            overflow-y: auto;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .search-item {
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .search-item:hover {
            background-color: #f3f4f6;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
            animation: fadeIn 0.3s ease-in;
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
                        <a href="#dashboard" class="sidebar-item flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-tachometer-alt mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Tableau de bord
                        </a>
                        <a href="#enregistrement" class="sidebar-item flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-user-plus mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Enregistrement
                        </a>
                        <a href="#notes" class="sidebar-item active flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-graduation-cap mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Saisie des notes
                        </a>
                        <a href="#profil" class="sidebar-item flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-user mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Profil étudiant
                        </a>
                        <a href="#dossier" class="sidebar-item flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-folder mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Dossier académique
                        </a>
                        <a href="#scolarite" class="sidebar-item flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-euro-sign mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Scolarité
                        </a>
                        <a href="#statistiques" class="sidebar-item flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-chart-bar mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Statistiques
                        </a>
                        <a href="#parametres" class="sidebar-item flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-cog mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Paramètres
                        </a>
                        <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                            <i class="fas fa-power-off mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Déconnexion
                        </a>
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
                    <h1 class="text-lg font-medium text-blue-500" id="pageTitle">Saisie des notes par UE</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button id="notifButton" class="p-1 text-gray-500 hover:text-gray-700 focus:outline-none relative">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
                        </button>
                    </div>
                    <div class="relative">
                        <button id="userMenuButton" class="flex items-center space-x-2 focus:outline-none">
                            <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Profil">
                            <span class="text-m font-medium text-blue-500">M. Responsable</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <div class="flex-1 p-4 md:p-6 overflow-y-auto gradient-bg">
                <!-- Interface de saisie des notes (optimisée) -->
                <div id="notes" class="tab-content active max-w-7xl mx-auto">
                    <!-- Header with student search -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Gestion des notes</h1>
                            <p class="text-gray-600">Saisie et validation des notes par UE</p>
                        </div>
                        <div class="w-full md:w-96">
                            <div class="search-container relative">
                                <div class="relative">
                                    <input type="text" id="studentSearch" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Rechercher un étudiant..." list="studentList">
                                    <datalist id="studentList">
                                        <option value="Sophie Martin">
                                        <option value="Jean Dupont">
                                        <option value="Marie Leroy">
                                    </datalist>
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Selected student info -->
                    <div id="studentInfo" class="bg-white rounded-lg shadow-sm p-4 mb-6 hidden">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0 h-16 w-16">
                                    <img class="h-16 w-16 rounded-full" id="studentAvatar" src="" alt="">
                                </div>
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800" id="studentName">Sophie Martin</h2>
                                    <p class="text-sm text-gray-600" id="studentProgram">Master Informatique - Promo 2023</p>
                                    <p class="text-sm text-gray-600" id="studentEmail">s.martin@email.com</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="status-badge bg-blue-100 text-blue-800" id="studentStatus">En cours</span>
                                <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition flex items-center justify-center">
                                    <i class="fas fa-print mr-2"></i>Fiche scolaire
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div id="selectedStudentInfo" class="bg-white rounded-lg shadow-sm p-4 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0 h-16 w-16">
                <img class="h-16 w-16 rounded-full" id="selectedStudentAvatar" src="https://randomuser.me/api/portraits/women/44.jpg" alt="">
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-800" id="selectedStudentName">Sophie Martin</h2>
                <p class="text-sm text-gray-600" id="selectedStudentProgram">Master Informatique - Promo 2023</p>
            </div>
        </div>
        <div class="flex space-x-2">
            <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition flex items-center justify-center">
                <i class="fas fa-save mr-2"></i>Enregistrer
            </button>
            <button class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition flex items-center justify-center">
                <i class="fas fa-print mr-2"></i>Imprimer
            </button>
        </div>
    </div>
</div>

                    <!-- UE and grades section -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                        <div class="divide-y divide-gray-200">
                            <!-- Semester 1 -->
                            <div>
                                <div class="px-6 py-3 bg-gray-50 flex justify-between items-center">
                                    <h3 class="text-lg font-medium text-gray-900">Semestre 1</h3>
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-500 mr-2">Moyenne:</span>
                                        <span class="text-lg font-semibold text-blue-600">13.25</span>
                                    </div>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    UE
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Coefficient
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Note
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Statut
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Commentaire
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">UE101 - Algorithmique</div>
                                                    <div class="text-sm text-gray-500">Responsable: Pr. Dupont</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">4</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="number" min="0" max="20" step="0.5" class="note-input w-20 px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="14.5">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="status-badge bg-green-100 text-green-800">Validée</span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <input type="text" class="note-input w-full px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Commentaire...">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">UE102 - Bases de données</div>
                                                    <div class="text-sm text-gray-500">Responsable: Pr. Martin</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">3</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="number" min="0" max="20" step="0.5" class="note-input w-20 px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="12.0">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="status-badge bg-green-100 text-green-800">Validée</span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <input type="text" class="note-input w-full px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Commentaire..." value="Bon travail">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">UE103 - Programmation web</div>
                                                    <div class="text-sm text-gray-500">Responsable: Pr. Leroy</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">3</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="number" min="0" max="20" step="0.5" class="note-input w-20 px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="status-badge bg-yellow-100 text-yellow-800">En attente</span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <input type="text" class="note-input w-full px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Commentaire...">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Semester 2 -->
                            <div>
                                <div class="px-6 py-3 bg-gray-50 flex justify-between items-center">
                                    <h3 class="text-lg font-medium text-gray-900">Semestre 2</h3>
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-500 mr-2">Moyenne:</span>
                                        <span class="text-lg font-semibold text-blue-600">15.50</span>
                                    </div>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    UE
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Coefficient
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Note
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Statut
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Commentaire
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">UE201 - Architecture systèmes</div>
                                                    <div class="text-sm text-gray-500">Responsable: Pr. Bernard</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">4</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="number" min="0" max="20" step="0.5" class="note-input w-20 px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" value="15.5">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="status-badge bg-green-100 text-green-800">Validée</span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <input type="text" class="note-input w-full px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Commentaire..." value="Excellente maîtrise">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">UE202 - Réseaux</div>
                                                    <div class="text-sm text-gray-500">Responsable: Pr. Moreau</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">3</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="number" min="0" max="20" step="0.5" class="note-input w-20 px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="status-badge bg-yellow-100 text-yellow-800">En attente</span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <input type="text" class="note-input w-full px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Commentaire...">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">UE203 - Projet intégré</div>
                                                    <div class="text-sm text-gray-500">Responsable: Pr. Dubois</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">5</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="number" min="0" max="20" step="0.5" class="note-input w-20 px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="status-badge bg-red-100 text-red-800">Non soumis</span>
                                                </td>
                                                <td class="px-6 py-4">
                                                    <input type="text" class="note-input w-full px-3 py-1 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Commentaire...">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary and actions -->
                    <div class="flex flex-col md:flex-row justify-between gap-6">
                        <!-- Summary card -->
                        <div class="bg-white rounded-lg shadow-sm p-6 flex-1">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Résumé académique</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">Moyenne Générale</p>
                                    <p class="text-xl font-semibold text-gray-800">14.38</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Crédits obtenus</p>
                                    <p class="text-xl font-semibold text-gray-800">24/60</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Statut global</p>
                                    <span class="status-badge bg-blue-100 text-blue-800">En cours</span>
                                </div>
                                <div class="pt-4">
                                    <p class="text-sm text-gray-500">Progression</p>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: 40%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">40% du parcours validé</p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions card -->
                        <div class="bg-white rounded-lg shadow-sm p-6 flex-1">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Actions</h3>
                            <div class="space-y-3">
                                <button class="w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition flex items-center justify-center">
                                    <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                                </button>
                                <button class="w-full px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition flex items-center justify-center">
                                    <i class="fas fa-check-circle mr-2"></i>Valider le semestre
                                </button>
                                <button class="w-full px-4 py-2 bg-purple-500 text-white rounded-md hover:bg-purple-600 transition flex items-center justify-center">
                                    <i class="fas fa-envelope mr-2"></i>Notifier l'étudiant
                                </button>
                                <button class="w-full px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle mr-2"></i>Signaler un problème
                                </button>
                                <button class="w-full px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition flex items-center justify-center">
                                    <i class="fas fa-redo mr-2"></i>Réinitialiser
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Interface d'enregistrement d'étudiant -->
                <div id="enregistrement" class="tab-content max-w-7xl mx-auto">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-800">Enregistrement d'un nouvel étudiant</h2>
                            <p class="text-sm text-gray-600">Remplissez les informations de l'étudiant à enregistrer</p>
                        </div>
                        <div class="px-6 py-4">
                            <form>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informations personnelles</h3>
                                        <div class="space-y-4">
                                            <div>
                                                <label for="lastName" class="block text-sm font-medium text-gray-700">Nom</label>
                                                <input type="text" id="lastName" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                            <div>
                                                <label for="firstName" class="block text-sm font-medium text-gray-700">Prénom</label>
                                                <input type="text" id="firstName" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                            <div>
                                                <label for="birthDate" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                                                <input type="date" id="birthDate" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                            <div>
                                                <label for="gender" class="block text-sm font-medium text-gray-700">Genre</label>
                                                <select id="gender" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                    <option value="">Sélectionner...</option>
                                                    <option value="male">Masculin</option>
                                                    <option value="female">Féminin</option>
                                                    <option value="other">Autre</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informations académiques</h3>
                                        <div class="space-y-4">
                                            <div>
                                                <label for="program" class="block text-sm font-medium text-gray-700">Formation</label>
                                                <select id="program" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                    <option value="">Sélectionner une formation...</option>
                                                    <option value="master_info">Master Informatique</option>
                                                    <option value="master_management">Master Management</option>
                                                    <option value="master_marketing">Master Marketing</option>
                                                    <option value="master_finance">Master Finance</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="promotion" class="block text-sm font-medium text-gray-700">Promotion</label>
                                                <select id="promotion" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                    <option value="">Sélectionner une promotion...</option>
                                                    <option value="2023">2023</option>
                                                    <option value="2024">2024</option>
                                                    <option value="2025">2025</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="email" class="block text-sm font-medium text-gray-700">Email universitaire</label>
                                                <input type="email" id="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                            <div>
                                                <label for="studentId" class="block text-sm font-medium text-gray-700">Numéro étudiant</label>
                                                <input type="text" id="studentId" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-8 border-t border-gray-200 pt-6">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informations de contact</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                                            <input type="text" id="address" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                            <input type="tel" id="phone" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label for="emergencyContact" class="block text-sm font-medium text-gray-700">Contact d'urgence</label>
                                            <input type="text" id="emergencyContact" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label for="emergencyPhone" class="block text-sm font-medium text-gray-700">Téléphone d'urgence</label>
                                            <input type="tel" id="emergencyPhone" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-8 flex justify-end space-x-3">
                                    <button type="reset" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                                        Annuler
                                    </button>
                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition flex items-center justify-center">
                                        <i class="fas fa-user-plus mr-2"></i>Enregistrer l'étudiant
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Interface de profil étudiant -->
                <div id="profil" class="tab-content max-w-7xl mx-auto">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800">Profil étudiant</h2>
                                <p class="text-sm text-gray-600">Consulter et modifier les informations d'un étudiant</p>
                            </div>
                            <div class="relative w-64">
                                <input type="text" id="profileSearch" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Rechercher un étudiant...">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4">
                            <div class="flex flex-col md:flex-row gap-6">
                                <div class="md:w-1/3">
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex flex-col items-center">
                                            <img class="h-24 w-24 rounded-full mb-4" src="https://randomuser.me/api/portraits/women/12.jpg" alt="Profil étudiant">
                                            <h3 class="text-lg font-semibold text-gray-800" id="profileName">Sophie Martin</h3>
                                            <p class="text-sm text-gray-600" id="profileProgram">Master Informatique - Promo 2023</p>
                                            <p class="text-sm text-gray-600" id="profileId">ID: ST20230001</p>
                                            <div class="mt-4">
                                                <span class="status-badge bg-green-100 text-green-800">Actif</span>
                                            </div>
                                        </div>
                                        <div class="mt-6">
                                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Contact</h4>
                                            <ul class="space-y-2">
                                                <li class="flex items-center">
                                                    <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                                    <span class="text-sm text-gray-600" id="profileEmail">s.martin@email.com</span>
                                                </li>
                                                <li class="flex items-center">
                                                    <i class="fas fa-phone text-gray-400 mr-2"></i>
                                                    <span class="text-sm text-gray-600" id="profilePhone">06 12 34 56 78</span>
                                                </li>
                                                <li class="flex items-center">
                                                    <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                                                    <span class="text-sm text-gray-600" id="profileAddress">12 Rue de la Paix, Paris</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="mt-6">
                                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Statistiques</h4>
                                            <div class="space-y-3">
                                                <div>
                                                    <p class="text-xs text-gray-500">Moyenne générale</p>
                                                    <p class="text-lg font-semibold text-blue-600">14.38</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500">Crédits obtenus</p>
                                                    <p class="text-lg font-semibold text-gray-800">24/60</p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-500">Progression</p>
                                                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                                        <div class="bg-blue-600 h-2 rounded-full" style="width: 40%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="md:w-2/3">
                                    <div class="bg-white rounded-lg">
                                        <div class="border-b border-gray-200">
                                            <nav class="flex -mb-px">
                                                <button data-tab="profile-info" class="tab-button py-4 px-4 border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                                                    Informations
                                                </button>
                                                <button data-tab="profile-academic" class="tab-button py-4 px-4 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                                    Scolarité
                                                </button>
                                                <button data-tab="profile-documents" class="tab-button py-4 px-4 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                                    Documents
                                                </button>
                                                <button data-tab="profile-history" class="tab-button py-4 px-4 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                                    Historique
                                                </button>
                                            </nav>
                                        </div>
                                        <div id="profile-info" class="tab-content active p-4">
                                            <form>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                    <div>
                                                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informations personnelles</h3>
                                                        <div class="space-y-4">
                                                            <div>
                                                                <label for="profileLastName" class="block text-sm font-medium text-gray-700">Nom</label>
                                                                <input type="text" id="profileLastName" value="Martin" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                            </div>
                                                            <div>
                                                                <label for="profileFirstName" class="block text-sm font-medium text-gray-700">Prénom</label>
                                                                <input type="text" id="profileFirstName" value="Sophie" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                            </div>
                                                            <div>
                                                                <label for="profileBirthDate" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                                                                <input type="date" id="profileBirthDate" value="1998-05-15" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                            </div>
                                                            <div>
                                                                <label for="profileGender" class="block text-sm font-medium text-gray-700">Genre</label>
                                                                <select id="profileGender" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                                    <option value="female" selected>Féminin</option>
                                                                    <option value="male">Masculin</option>
                                                                    <option value="other">Autre</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informations académiques</h3>
                                                        <div class="space-y-4">
                                                            <div>
                                                                <label for="profileProgram" class="block text-sm font-medium text-gray-700">Formation</label>
                                                                <select id="profileProgram" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                                    <option value="master_info" selected>Master Informatique</option>
                                                                    <option value="master_management">Master Management</option>
                                                                    <option value="master_marketing">Master Marketing</option>
                                                                    <option value="master_finance">Master Finance</option>
                                                                </select>
                                                            </div>
                                                            <div>
                                                                <label for="profilePromotion" class="block text-sm font-medium text-gray-700">Promotion</label>
                                                                <select id="profilePromotion" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                                    <option value="2023" selected>2023</option>
                                                                    <option value="2024">2024</option>
                                                                    <option value="2025">2025</option>
                                                                </select>
                                                            </div>
                                                            <div>
                                                                <label for="profileEmail" class="block text-sm font-medium text-gray-700">Email universitaire</label>
                                                                <input type="email" id="profileEmail" value="s.martin@email.com" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                            </div>
                                                            <div>
                                                                <label for="profileStatus" class="block text-sm font-medium text-gray-700">Statut</label>
                                                                <select id="profileStatus" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                                    <option value="active" selected>Actif</option>
                                                                    <option value="inactive">Inactif</option>
                                                                    <option value="graduated">Diplômé</option>
                                                                    <option value="dropped">Abandon</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-8 border-t border-gray-200 pt-6">
                                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informations de contact</h3>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                        <div>
                                                            <label for="profileAddress" class="block text-sm font-medium text-gray-700">Adresse</label>
                                                            <input type="text" id="profileAddress" value="12 Rue de la Paix, Paris" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                        </div>
                                                        <div>
                                                            <label for="profilePhone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                                            <input type="tel" id="profilePhone" value="0612345678" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                        </div>
                                                        <div>
                                                            <label for="profileEmergencyContact" class="block text-sm font-medium text-gray-700">Contact d'urgence</label>
                                                            <input type="text" id="profileEmergencyContact" value="Jean Martin (Père)" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                        </div>
                                                        <div>
                                                            <label for="profileEmergencyPhone" class="block text-sm font-medium text-gray-700">Téléphone d'urgence</label>
                                                            <input type="tel" id="profileEmergencyPhone" value="0612345679" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-8 flex justify-end space-x-3">
                                                    <button type="reset" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                                                        Annuler
                                                    </button>
                                                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition flex items-center justify-center">
                                                        <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                        <div id="profile-academic" class="tab-content p-4">
                                            <div class="mb-6">
                                                <h3 class="text-lg font-medium text-gray-900">Résumé académique</h3>
                                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                                                    <div class="bg-gray-50 p-4 rounded-lg">
                                                        <p class="text-sm text-gray-500">Moyenne générale</p>
                                                        <p class="text-xl font-semibold text-blue-600">14.38</p>
                                                    </div>
                                                    <div class="bg-gray-50 p-4 rounded-lg">
                                                        <p class="text-sm text-gray-500">Crédits obtenus</p>
                                                        <p class="text-xl font-semibold text-gray-800">24/60</p>
                                                    </div>
                                                    <div class="bg-gray-50 p-4 rounded-lg">
                                                        <p class="text-sm text-gray-500">Semestres validés</p>
                                                        <p class="text-xl font-semibold text-gray-800">1/4</p>
                                                    </div>
                                                    <div class="bg-gray-50 p-4 rounded-lg">
                                                        <p class="text-sm text-gray-500">Statut</p>
                                                        <span class="status-badge bg-green-100 text-green-800">En cours</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-medium text-gray-900">Notes par semestre</h3>
                                                <div class="mt-4 space-y-6">
                                                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                                                        <div class="px-4 py-3 bg-gray-50 flex justify-between items-center">
                                                            <h4 class="font-medium text-gray-900">Semestre 1</h4>
                                                            <div class="flex items-center">
                                                                <span class="text-sm font-medium text-gray-500 mr-2">Moyenne:</span>
                                                                <span class="text-lg font-semibold text-blue-600">13.25</span>
                                                            </div>
                                                        </div>
                                                        <div class="overflow-x-auto">
                                                            <table class="min-w-full divide-y divide-gray-200">
                                                                <thead class="bg-gray-50">
                                                                    <tr>
                                                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">UE</th>
                                                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                                                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="bg-white divide-y divide-gray-200">
                                                                    <tr>
                                                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">UE101 - Algorithmique</td>
                                                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">14.5</td>
                                                                        <td class="px-4 py-2 whitespace-nowrap"><span class="status-badge bg-green-100 text-green-800">Validée</span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">UE102 - Bases de données</td>
                                                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">12.0</td>
                                                                        <td class="px-4 py-2 whitespace-nowrap"><span class="status-badge bg-green-100 text-green-800">Validée</span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">UE103 - Programmation web</td>
                                                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">-</td>
                                                                        <td class="px-4 py-2 whitespace-nowrap"><span class="status-badge bg-yellow-100 text-yellow-800">En attente</span></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="border border-gray-200 rounded-lg overflow-hidden">
                                                        <div class="px-4 py-3 bg-gray-50 flex justify-between items-center">
                                                            <h4 class="font-medium text-gray-900">Semestre 2</h4>
                                                            <div class="flex items-center">
                                                                <span class="text-sm font-medium text-gray-500 mr-2">Moyenne:</span>
                                                                <span class="text-lg font-semibold text-blue-600">15.50</span>
                                                            </div>
                                                        </div>
                                                        <div class="overflow-x-auto">
                                                            <table class="min-w-full divide-y divide-gray-200">
                                                                <thead class="bg-gray-50">
                                                                    <tr>
                                                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">UE</th>
                                                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                                                                        <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="bg-white divide-y divide-gray-200">
                                                                    <tr>
                                                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">UE201 - Architecture systèmes</td>
                                                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900">15.5</td>
                                                                        <td class="px-4 py-2 whitespace-nowrap"><span class="status-badge bg-green-100 text-green-800">Validée</span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">UE202 - Réseaux</td>
                                                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">-</td>
                                                                        <td class="px-4 py-2 whitespace-nowrap"><span class="status-badge bg-yellow-100 text-yellow-800">En attente</span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">UE203 - Projet intégré</td>
                                                                        <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500">-</td>
                                                                        <td class="px-4 py-2 whitespace-nowrap"><span class="status-badge bg-red-100 text-red-800">Non soumis</span></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="profile-documents" class="tab-content p-4">
                                            <div class="flex justify-between items-center mb-4">
                                                <h3 class="text-lg font-medium text-gray-900">Documents administratifs</h3>
                                                <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition flex items-center justify-center">
                                                    <i class="fas fa-plus mr-2"></i>Ajouter un document
                                                </button>
                                            </div>
                                            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                                                <ul class="divide-y divide-gray-200">
                                                    <li>
                                                        <div class="px-4 py-4 flex items-center sm:px-6">
                                                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                                                <div class="truncate">
                                                                    <div class="flex text-sm">
                                                                        <p class="font-medium text-blue-600 truncate">Contrat de formation</p>
                                                                        <p class="ml-1 flex-shrink-0 font-normal text-gray-500">(PDF, 1.2MB)</p>
                                                                    </div>
                                                                    <div class="mt-2 flex">
                                                                        <div class="flex items-center text-sm text-gray-500">
                                                                            <i class="fas fa-calendar-alt mr-1"></i>
                                                                            <p>Déposé le <time datetime="2023-09-15">15 septembre 2023</time></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-4 flex-shrink-0 sm:mt-0 sm:ml-5">
                                                                    <div class="flex space-x-3">
                                                                        <span class="status-badge bg-green-100 text-green-800">Validé</span>
                                                                        <button class="text-blue-600 hover:text-blue-900">
                                                                            <i class="fas fa-download"></i>
                                                                        </button>
                                                                        <button class="text-gray-400 hover:text-gray-500">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="px-4 py-4 flex items-center sm:px-6">
                                                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                                                <div class="truncate">
                                                                    <div class="flex text-sm">
                                                                        <p class="font-medium text-blue-600 truncate">Pièce d'identité</p>
                                                                        <p class="ml-1 flex-shrink-0 font-normal text-gray-500">(JPG, 0.8MB)</p>
                                                                    </div>
                                                                    <div class="mt-2 flex">
                                                                        <div class="flex items-center text-sm text-gray-500">
                                                                            <i class="fas fa-calendar-alt mr-1"></i>
                                                                            <p>Déposé le <time datetime="2023-09-10">10 septembre 2023</time></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-4 flex-shrink-0 sm:mt-0 sm:ml-5">
                                                                    <div class="flex space-x-3">
                                                                        <span class="status-badge bg-green-100 text-green-800">Validé</span>
                                                                        <button class="text-blue-600 hover:text-blue-900">
                                                                            <i class="fas fa-download"></i>
                                                                        </button>
                                                                        <button class="text-gray-400 hover:text-gray-500">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="px-4 py-4 flex items-center sm:px-6">
                                                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                                                <div class="truncate">
                                                                    <div class="flex text-sm">
                                                                        <p class="font-medium text-blue-600 truncate">Justificatif de domicile</p>
                                                                        <p class="ml-1 flex-shrink-0 font-normal text-gray-500">(PDF, 0.5MB)</p>
                                                                    </div>
                                                                    <div class="mt-2 flex">
                                                                        <div class="flex items-center text-sm text-gray-500">
                                                                            <i class="fas fa-calendar-alt mr-1"></i>
                                                                            <p>Déposé le <time datetime="2023-09-12">12 septembre 2023</time></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-4 flex-shrink-0 sm:mt-0 sm:ml-5">
                                                                    <div class="flex space-x-3">
                                                                        <span class="status-badge bg-yellow-100 text-yellow-800">En attente</span>
                                                                        <button class="text-blue-600 hover:text-blue-900">
                                                                            <i class="fas fa-download"></i>
                                                                        </button>
                                                                        <button class="text-gray-400 hover:text-gray-500">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="px-4 py-4 flex items-center sm:px-6">
                                                            <div class="min-w-0 flex-1 sm:flex sm:items-center sm:justify-between">
                                                                <div class="truncate">
                                                                    <div class="flex text-sm">
                                                                        <p class="font-medium text-blue-600 truncate">CV</p>
                                                                        <p class="ml-1 flex-shrink-0 font-normal text-gray-500">(PDF, 0.7MB)</p>
                                                                    </div>
                                                                    <div class="mt-2 flex">
                                                                        <div class="flex items-center text-sm text-gray-500">
                                                                            <i class="fas fa-calendar-alt mr-1"></i>
                                                                            <p>Déposé le <time datetime="2023-09-05">5 septembre 2023</time></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-4 flex-shrink-0 sm:mt-0 sm:ml-5">
                                                                    <div class="flex space-x-3">
                                                                        <span class="status-badge bg-red-100 text-red-800">Rejeté</span>
                                                                        <button class="text-blue-600 hover:text-blue-900">
                                                                            <i class="fas fa-download"></i>
                                                                        </button>
                                                                        <button class="text-gray-400 hover:text-gray-500">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div id="profile-history" class="tab-content p-4">
                                            <h3 class="text-lg font-medium text-gray-900 mb-4">Historique des actions</h3>
                                            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                                                <ul class="divide-y divide-gray-200">
                                                    <li>
                                                        <div class="px-4 py-4 sm:px-6">
                                                            <div class="flex items-center justify-between">
                                                                <p class="text-sm font-medium text-blue-600 truncate">Modification des informations personnelles</p>
                                                                <div class="ml-2 flex-shrink-0 flex">
                                                                    <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                        Complété
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="mt-2 sm:flex sm:justify-between">
                                                                <div class="sm:flex">
                                                                    <p class="flex items-center text-sm text-gray-500">
                                                                        <i class="fas fa-user-edit mr-1.5"></i>
                                                                        M. Responsable
                                                                    </p>
                                                                    <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                                                        <i class="fas fa-calendar-alt mr-1.5"></i>
                                                                        <time datetime="2023-10-15">15 octobre 2023</time>
                                                                    </p>
                                                                </div>
                                                                <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                                                    <i class="fas fa-info-circle mr-1.5"></i>
                                                                    Adresse mise à jour
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="px-4 py-4 sm:px-6">
                                                            <div class="flex items-center justify-between">
                                                                <p class="text-sm font-medium text-blue-600 truncate">Validation de notes</p>
                                                                <div class="ml-2 flex-shrink-0 flex">
                                                                    <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                        Complété
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="mt-2 sm:flex sm:justify-between">
                                                                <div class="sm:flex">
                                                                    <p class="flex items-center text-sm text-gray-500">
                                                                        <i class="fas fa-user-edit mr-1.5"></i>
                                                                        Pr. Dupont
                                                                    </p>
                                                                    <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                                                        <i class="fas fa-calendar-alt mr-1.5"></i>
                                                                        <time datetime="2023-10-10">10 octobre 2023</time>
                                                                    </p>
                                                                </div>
                                                                <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                                                    <i class="fas fa-info-circle mr-1.5"></i>
                                                                    UE101 validée avec 14.5/20
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="px-4 py-4 sm:px-6">
                                                            <div class="flex items-center justify-between">
                                                                <p class="text-sm font-medium text-blue-600 truncate">Paiement de scolarité</p>
                                                                <div class="ml-2 flex-shrink-0 flex">
                                                                    <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                        Complété
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="mt-2 sm:flex sm:justify-between">
                                                                <div class="sm:flex">
                                                                    <p class="flex items-center text-sm text-gray-500">
                                                                        <i class="fas fa-user-edit mr-1.5"></i>
                                                                        Service comptabilité
                                                                    </p>
                                                                    <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                                                        <i class="fas fa-calendar-alt mr-1.5"></i>
                                                                        <time datetime="2023-10-05">5 octobre 2023</time>
                                                                    </p>
                                                                </div>
                                                                <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                                                    <i class="fas fa-info-circle mr-1.5"></i>
                                                                    Paiement de 1500€ enregistré
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="px-4 py-4 sm:px-6">
                                                            <div class="flex items-center justify-between">
                                                                <p class="text-sm font-medium text-blue-600 truncate">Inscription administrative</p>
                                                                <div class="ml-2 flex-shrink-0 flex">
                                                                    <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                        Complété
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="mt-2 sm:flex sm:justify-between">
                                                                <div class="sm:flex">
                                                                    <p class="flex items-center text-sm text-gray-500">
                                                                        <i class="fas fa-user-edit mr-1.5"></i>
                                                                        M. Responsable
                                                                    </p>
                                                                    <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                                                        <i class="fas fa-calendar-alt mr-1.5"></i>
                                                                        <time datetime="2023-09-01">1 septembre 2023</time>
                                                                    </p>
                                                                </div>
                                                                <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                                                    <i class="fas fa-info-circle mr-1.5"></i>
                                                                    Inscription validée pour l'année 2023-2024
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Interface de dossier académique -->
                <div id="dossier" class="tab-content max-w-7xl mx-auto">
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800">Dossier académique</h2>
                                <p class="text-sm text-gray-600">Consultation et gestion du dossier complet de l'étudiant</p>
                            </div>
                            <div class="relative w-64">
                                <input type="text" id="dossierSearch" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Rechercher un étudiant...">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4">
                            <div class="flex flex-col md:flex-row gap-6">
                                <div class="md:w-1/4">
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex flex-col items-center">
                                            <img class="h-24 w-24 rounded-full mb-4" src="https://randomuser.me/api/portraits/women/12.jpg" alt="Profil étudiant">
                                            <h3 class="text-lg font-semibold text-gray-800">Sophie Martin</h3>
                                            <p class="text-sm text-gray-600">Master Informatique - Promo 2023</p>
                                            <p class="text-sm text-gray-600">ID: ST20230001</p>
                                            <div class="mt-4">
                                                <span class="status-badge bg-green-100 text-green-800">Actif</span>
                                            </div>
                                        </div>
                                        <div class="mt-6">
                                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Navigation</h4>
                                            <nav class="space-y-1">
                                                <a href="#" class="group flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-900 bg-gray-200">
                                                    <i class="fas fa-info-circle mr-3
<script>
    document.getElementById('studentSearch').addEventListener('input', function(e) {
        const selectedStudentInfo = document.getElementById('selectedStudentInfo');
        if (e.target.value) {
            selectedStudentInfo.classList.remove('hidden');
            document.getElementById('selectedStudentName').textContent = e.target.value;
            document.getElementById('selectedStudentProgram').textContent = 'Master Informatique - Promo 2023';
        } else {
            selectedStudentInfo.classList.add('hidden');
        }
    });
</script>
</html>