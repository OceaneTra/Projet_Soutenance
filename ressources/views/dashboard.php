<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soutenance Manager</title>
    <link rel="stylesheet" href="/../dist/output.css">
    <link rel="stylesheet" href="/../src/input.css">
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
                        <a href="#"
                            class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-white bg-green-500 group">
                            <i class="fas fa-home mr-3 text-white"></i>
                            Tableau de bord
                        </a>
                        <a href="#"
                            class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                            <i class="fas fa-book mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Gestion des étudiants
                        </a>
                        <a href=""
                            class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                            <i class="fas fa-users mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Gestion des ressources humaines
                        </a>
                        <a href="#"
                            class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                            <i class="fas fa-user mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Gestion des utilisateurs
                        </a>
                        <a href="#"
                            class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                            <i class="fas fa-mask mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Gestion des habilitations et mot de passe
                        </a>
                        <a href="#"
                            class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                            <i class="fas fa-history mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Gestion de la piste d'audit
                        </a>
                        <a href="#"
                            class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                            <i class="fas fa-save mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Sauvegarde et restauration des données
                        </a>
                        <a href="#"
                            class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                            <i class="fas fa-gears mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Paramètres généraux
                        </a>
                        <a href="#"
                            class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                            <i class="fas fa-power-off mr-3 text-gray-400 group-hover:text-gray-500"></i>
                            Déconnexion
                        </a>
                    </div>
                    <div class="mt-auto mb-4">
                        <div class="p-4 bg-green-100 rounded-lg">
                            <h4 class="text-sm font-medium text-green-500">Besoin d'aide ?</h4>
                            <p class="mt-1 text-xs text-green-500">Contactez notre équipe d'assistance pour obtenir de
                                l'aide .</p>
                            <button
                                class="mt-2 w-full inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-green-500 hover:bg-green-600">
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
                    <h1 class="ml-4 text-lg font-medium text-green-500">Tableau de bord</h1>
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
            <div>
                <!-- This is where the main content will be included -->
            </div>


        </div>
    </div>
    <div class="bg-red-500 text-white text-center p-4 rounded">
        Test Tailwind fonctionne
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

        // Document card hover effects
        const documentCards = document.querySelectorAll('.document-card');
        documentCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
            });
        });

        // Notification bell animation
        const notificationBell = document.querySelector('.fa-bell');
        if (notificationBell) {
            notificationBell.addEventListener('click', function() {
                this.classList.add('animate-pulse');
                setTimeout(() => {
                    this.classList.remove('animate-pulse');
                }, 2000);
            });
        }
    });
    </script>
</body>

</html>