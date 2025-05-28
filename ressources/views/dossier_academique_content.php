<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Scolarité | Dossier Académique</title>
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
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
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
                        <a href="dashboard.html" class="sidebar-item flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-tachometer-alt mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Tableau de bord
                        </a>
                        <a href="enregistrement.html" class="sidebar-item flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-user-plus mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Enregistrement
                        </a>
                        <a href="note.html" class="sidebar-item flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-graduation-cap mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Saisie des notes
                        </a>
                        <a href="#" class="sidebar-item flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-user mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Profil étudiant
                        </a>
                        <a href="dossier_academique.html" class="sidebar-item active flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-folder mr-3 text-blue-500"></i>
                            Dossier académique
                        </a>
                        <a href="scolarite.html" class="sidebar-item flex items-center px-2 py-3 text-sm font-medium rounded-md group text-gray-700 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-euro-sign mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Scolarité
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
                    <h1 class="text-lg font-medium text-blue-500">Dossier Académique</h1>
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
                <div class="max-w-7xl mx-auto">
                    <!-- Header -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Dossier Académique</h1>
                            <p class="text-gray-600">Consultation et gestion des dossiers étudiants</p>
                        </div>
                        <div class="w-full md:w-96">
                            <div class="relative">
                                <input type="text" id="studentSearch" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Rechercher un étudiant...">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Student selection -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-800">Sélectionner un étudiant</h2>
                        </div>
                        <div class="p-4">
                            <select id="studentSelect" class="block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Sélectionner un étudiant...</option>
                                <option value="1">Sophie Martin</option>
                                <option value="2">Jean Dupont</option>
                                <option value="3">Marie Lambert</option>
                            </select>
                        </div>
                    </div>

                    <!-- Academic tabs -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                        <div class="border-b border-gray-200">
                            <nav class="flex -mb-px">
                                <a href="#" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm border-blue-500 text-blue-600">
                                    Informations
                                </a>
                                <a href="#" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    Notes
                                </a>
                                <a href="#" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    Absences
                                </a>
                                <a href="#" class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    Documents
                                </a>
                            </nav>
                        </div>
                        <div class="p-6">
                            <!-- Student information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-800 mb-4">Informations personnelles</h3>
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Nom complet</p>
                                            <p class="text-gray-800">Sophie Martin</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Date de naissance</p>
                                            <p class="text-gray-800">15/03/1998</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Email</p>
                                            <p class="text-gray-800">s.martin@email.com</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Téléphone</p>
                                            <p class="text-gray-800">06 12 34 56 78</p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-800 mb-4">Informations académiques</h3>
                                    <div class="space-y-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Formation</p>
                                            <p class="text-gray-800">Master Informatique</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Promotion</p>
                                            <p class="text-gray-800">2023-2024</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Numéro étudiant</p>
                                            <p class="text-gray-800">E12345678</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Statut</p>
                                            <p class="text-gray-800">Inscrit</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Documents section -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-800 mb-4">Documents</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="border border-gray-200 rounded-lg p-4 hover-scale">
                                        <div class="flex items-center justify-between mb-2">
                                            <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                                            <span class="text-xs text-gray-500">12/10/2023</span>
                                        </div>
                                        <p class="font-medium text-gray-800">Contrat de formation</p>
                                        <p class="text-xs text-gray-500">PDF - 1.2 MB</p>
                                        <div class="mt-3">
                                            <button class="text-sm text-blue-500 hover:text-blue-700">Télécharger</button>
                                        </div>
                                    </div>
                                    <div class="border border-gray-200 rounded-lg p-4 hover-scale">
                                        <div class="flex items-center justify-between mb-2">
                                            <i class="fas fa-file-word text-blue-500 text-xl"></i>
                                            <span class="text-xs text-gray-500">05/09/2023</span>
                                        </div>
                                        <p class="font-medium text-gray-800">CV étudiant</p>
                                        <p class="text-xs text-gray-500">DOCX - 0.5 MB</p>
                                        <div class="mt-3">
                                            <button class="text-sm text-blue-500 hover:text-blue-700">Télécharger</button>
                                        </div>
                                    </div>
                                    <div class="border border-gray-200 rounded-lg p-4 hover-scale">
                                        <div class="flex items-center justify-between mb-2">
                                            <i class="fas fa-file-image text-green-500 text-xl"></i>
                                            <span class="text-xs text-gray-500">20/08/2023</span>
                                        </div>
                                        <p class="font-medium text-gray-800">Photo d'identité</p>
                                        <p class="text-xs text-gray-500">JPG - 0.8 MB</p>
                                        <div class="mt-3">
                                            <button class="text-sm text-blue-500 hover:text-blue-700">Télécharger</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-4">
                        <button class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                            Imprimer le dossier
                        </button>
                        <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Exporter en PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuButton').addEventListener('click', function() {
            // Toggle mobile menu logic here
        });

        // Student search functionality
        document.getElementById('studentSearch').addEventListener('input', function(e) {
            // Search logic here
        });
    </script>
</body>
</html>