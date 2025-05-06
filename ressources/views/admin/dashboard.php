<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soutenance Manager | Paramètres généraux</title>
    <link rel="stylesheet" href="/assets/css/output_dashboard_admin.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased">
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <div class="hidden md:flex md:flex-shrink-0">
        <div class="flex flex-col w-64 border-r border-gray-200 bg-white ">
            <div class="flex items-center justify-center h-16 px-4 bg-green-100 shadow-sm">
                <div class="flex items-center">
                    <span class="text-green-500 font-bold text-xl">Soutenance Manager</span>
                </div>
            </div>
            <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto ">
                <div class="space-y-2 pb-3">
                    <a href="/admin/dashboard" class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                        <i class="fas fa-home mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Tableau de bord
                    </a>
                    <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                        <i class="fas fa-book mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Gestion des étudiants
                    </a>
                    <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                        <i class="fas fa-users mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Gestion des ressources humaines
                    </a>
                    <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                        <i class="fas fa-user mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Gestion des utilisateurs
                    </a>
                    <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                        <i class="fas fa-mask mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Gestion des habilitations et mot de passe
                    </a>
                    <a href="#" class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                        <i class="fas fa-history mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Gestion de la piste d'audit
                    </a>
                    <a href="#"
                       class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                        <i class="fas fa-save mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Sauvegarde et restauration des données
                    </a>
                    <a href="/parametres"
                       class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-white bg-green-500 group">
                        <i class="fas fa-gears mr-3 text-white"></i>
                        Paramètres généraux
                    </a>
                    <a href="/logout"
                       class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                        <i class="fas fa-power-off mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Déconnexion
                    </a>
                </div>
                <div class="mt-auto mb-4">
                    <div class="p-4 bg-green-100 rounded-lg">
                        <h4 class="text-sm font-medium text-green-500">Besoin d'aide ?</h4>
                        <p class="mt-1 text-xs text-green-500">Contactez notre équipe d'assistance pour obtenir de l'aide.</p>
                        <button class="mt-2 w-full inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-green-500 hover:bg-green-600">
                            Contactez l'assistance
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="flex flex-col flex-1 overflow-hidden">
        <!-- Top navigation -->
        <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 bg-green-100 shadow-sm">
            <div class="flex items-center">
                <button class="md:hidden text-gray-500 focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="ml-4 text-lg font-medium text-green-500">Paramètres généraux</h1>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <button class="flex items-center space-x-2 focus:outline-none">
                        <span class="text-m font-medium text-green-500">Bienvenue, Administrateur</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main content area -->
        <div class="flex-1 overflow-auto p-4">
            <?php if(isset($_SESSION['success'])): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p><?= $_SESSION['success']; ?></p>
                    <?php unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <?php if(isset($_SESSION['error'])): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p><?= $_SESSION['error']; ?></p>
                    <?php unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Années académiques -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="rounded-full bg-blue-100 p-3 mr-4">
                                <i class="fas fa-calendar-alt text-blue-500 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Années académiques</h3>
                                <p class="text-sm text-gray-500">Gérer les années académiques</p>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4">Configuration des périodes académiques pour l'organisation des cours et des examens.</p>
                        <a href="/parametres/annee-academique" class="inline-block w-full text-center px-4 py-2 bg-blue-500 text-white font-medium rounded-md hover:bg-blue-600 transition-colors">
                            Gérer les années académiques
                        </a>
                    </div>
                </div>

                <!-- Fonctions -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="rounded-full bg-purple-100 p-3 mr-4">
                                <i class="fas fa-briefcase text-purple-500 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Fonctions</h3>
                                <p class="text-sm text-gray-500">Gérer les fonctions</p>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4">Configuration des fonctions occupées par les enseignants au sein de l'établissement.</p>
                        <a href="/parametres/fonction" class="inline-block w-full text-center px-4 py-2 bg-purple-500 text-white font-medium rounded-md hover:bg-purple-600 transition-colors">
                            Gérer les fonctions
                        </a>
                    </div>
                </div>

                <!-- Grades -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="rounded-full bg-green-100 p-3 mr-4">
                                <i class="fas fa-user-graduate text-green-500 text-2xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Grades</h3>
                                <p class="text-sm text-gray-500">Gérer les grades</p>
                            </div>
                        </div>
                        <p class="text-gray-600 mb-4">Configuration des grades académiques pour les enseignants (professeur, maître de conférences, etc.).</p>
                        <a href="/parametres/grade" class="inline-block w-full text-center px-4 py-2 bg-green-500 text-white font-medium rounded-md hover:bg-green-600 transition-colors">
                            Gérer les grades
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Simple interactive elements
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle mobile menu
        const mobileMenuButton = document.querySelector('.md\\:hidden');
        const sidebar = document.querySelector('.hidden.md\\:flex');

        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');
            });
        }
    });
</script>
</body>
</html>