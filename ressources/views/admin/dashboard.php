<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soutenance Manager | DashBoard</title>
    <link rel="stylesheet" href="/assets/css/output_dashboard_admin.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans antialiased">
<div class="flex h-screen overflow-auto">
    <!-- Sidebar -->
    <div class="hidden md:flex md:flex-shrink-0 fixed top-0 left-0 h-full">
        <div class="flex flex-col w-64 border-r border-gray-200 bg-white ">
            <div class="flex items-center justify-center h-16 px-4 bg-green-100 shadow-sm">
                <div class="flex items-center">
                    <span class="text-green-500 font-bold text-xl">Soutenance Manager</span>
                </div>
            </div>
            <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto ">
                <div class="space-y-2 pb-3">
                    <a href="/admin/dashboard?section=" class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                        <i class="fas fa-home mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Tableau de bord
                    </a>
                    <a href="/admin/dashboard?section=Getud" class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                        <i class="fas fa-book mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Gestion des étudiants
                    </a>
                    <a href="/admin/dashboard?section=Grh" class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                        <i class="fas fa-users mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Gestion des ressources humaines
                    </a>
                    <a href="/admin/dashboard?section=Gutil" class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                        <i class="fas fa-user mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Gestion des utilisateurs
                    </a>
                    <a href="/admin/dashboard?section=Gmdp" class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                        <i class="fas fa-mask mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Gestion des habilitations et mot de passe
                    </a>
                    <a href="/admin/dashboard?section=Gpisteaudit" class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                        <i class="fas fa-history mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Gestion de la piste d'audit
                    </a>
                    <a href="/admin/dashboard?section=Gsauvrest"
                       class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
                        <i class="fas fa-save mr-3 text-gray-400 group-hover:text-gray-500"></i>
                        Sauvegarde et restauration des données
                    </a>
                    <a href="/admin/dashboard?section=Gparam"
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
    <div class="flex flex-col flex-1 overflow-auto">
        <!-- Top navigation -->
        <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 bg-green-100 shadow-sm fixed top-0 right-0 left-64">
            <div class="flex items-center">
                <button class="md:hidden text-gray-500 focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="ml-4 text-lg font-medium text-green-500">
                    <?php
                    // Dynamiser le titre selon la section active
                    if (isset($_GET['section'])) {
                        switch ($_GET['section']) {
                            case 'Getud':
                                echo 'Gestion des etudiants';
                                break;
                            case 'Grh':
                                echo 'Gestion des RH';
                                break;
                            case 'Gutil':
                                echo 'Gestion des utilisateurs';
                                break;
                            case 'Gmdp':
                                echo 'Gestion des mot de passe';
                                break;
                            case 'Gpisteaudit':
                                echo "Gestion de la piste d'audit";
                                break;
                            case 'Gsauvrest':
                                echo 'Gestion des sauvegardes';
                                break;
                            case 'Gparam':
                                echo 'Gestion des parametres generaux';
                                break;
                            default:
                                echo 'Dashboard';
                        }
                    } else {
                        echo 'DashBoard';
                    }
                    ?>
                </h1>
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
        <div class="flex-1 overflow-auto p-4 mt-16">
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

            <?php
            // Déterminer quelle section afficher
            if (isset($_GET['section'])) {
                switch ($_GET['section']) {
                    case 'Getud':
                        include __DIR__ . '/gestion_etudiant/vue_gestion_etude.php';
                        break;
                    case 'Grh':
                        include __DIR__ . '/grh/vue_grh.php';
                        break;
                    case 'Gutil':
                        include __DIR__ . '/gestion_utilisateur/vue_gutilisateur.php';
                        break;
                    case 'Gmdp':
                        include __DIR__ . '/gestion_mdp/vue_gmdp.php';
                        break;
                    case 'Gpisteaudit':
                        include __DIR__ . '/gestion_piste_audite/vue_gpisteaudit.php';
                        break;
                    case 'Gsauvrest':
                        include __DIR__ . '/gestion_sauvrest/vue_gsauvrest.php';
                        break;
                    case 'Gparam':

                        if (isset($_GET['modal'])) {
                            switch ($_GET['modal']) {
                                case 'action':
                                    include __DIR__ . '/paramettre_genereaux/action.php';
                                    break;
                                case 'annee-academique':
                                    include __DIR__ . '/paramettre_genereaux/annee_academique.php';
                                    break;
                                case 'ecue':
                                    include __DIR__ . '/paramettre_genereaux/ecue.php';
                                    break;
                                case 'ue':
                                    include __DIR__ . '/paramettre_genereaux/ue.php';
                                    break;
                                case 'fonction':
                                    include __DIR__ . '/paramettre_genereaux/fonction.php';
                                    break;
                                case 'grade':
                                    include __DIR__ . '/paramettre_genereaux/grade.php';
                                    break;
                                case 'groupes-utilisateurs':
                                    include __DIR__ . '/paramettre_genereaux/groupes_utilisateurs.php';
                                    break;
                                case 'niveaux-acces-donnees':
                                    include __DIR__ . '/paramettre_genereaux/niveaux_acces_donnees.php';
                                    break;
                                case 'niveaux-approbation':
                                    include __DIR__ . '/paramettre_genereaux/niveaux_approbation.php';
                                    break;
                                case 'niveaux-etude':
                                    include __DIR__ . '/paramettre_genereaux/niveaux_etude.php';
                                    break;
                                case 'specialites':
                                    include __DIR__ . '/paramettre_genereaux/specialites.php';
                                    break;
                                case 'statuts-jury':
                                    include __DIR__ . '/paramettre_genereaux/statuts_jury.php';
                                    break;
                                case 'types-utilisateurs':
                                    include __DIR__ . '/paramettre_genereaux/types_utilisateurs.php';
                                    break;
                                default:
                                    include __DIR__ . '/paramettre_genereaux/vue_gparamgen.php';
                            }
                        } else {
                            // Si aucune modal spécifique n'est demandée, afficher la vue principale
                            include __DIR__ . '/paramettre_genereaux/vue_gparamgen.php';
                        }
                        break;
                    default:
                        // Si la section n'est pas reconnue, afficher le dashboard par défaut
                        include __DIR__ . '/dashboard_content.php';
                }
            } else {
                // Si aucune section n'est spécifiée, afficher le dashboard par défaut
                include __DIR__ . '/dashboard_content.php';
            }
            ?>
        </div>
    </div>
</div>

<script>
    // Toggle mobile menu
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.querySelector('.md\\:hidden');
        const sidebar = document.querySelector('.hidden.md\\:flex');

        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');
            });
        }

        // Gestion des modales
        const openModalButtons = document.querySelectorAll('.openModal');
        const closeModalButtons = document.querySelectorAll('.closeModal');

        openModalButtons.forEach(button => {
            button.addEventListener('click', function() {
                const modalId = this.getAttribute('data-modal');
                document.getElementById(modalId).classList.remove('hidden');
            });
        });

        closeModalButtons.forEach(button => {
            button.addEventListener('click', function() {
                const modalId = this.getAttribute('data-modal');
                document.getElementById(modalId).classList.add('hidden');
            });
        });
    });
</script>
</body>
</html>