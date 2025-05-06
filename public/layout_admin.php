<?php
// Définir les éléments du menu
// Chaque élément a un 'slug' (utilisé dans l'URL et pour le nom de fichier),
// un 'label' (ce qui est affiché) et optionnellement une 'icon' (classe Font Awesome par exemple)
$menuItems = [
    ['slug' => 'dashboard', 'label' => 'Tableau de bord', 'icon' => 'fa-home'],
    ['slug' => 'gestion_etudiants', 'label' => 'Gestion des étudiants', 'icon' => 'fa-book'],
    ['slug' => 'gestion_rh', 'label' => 'Gestion des ressources humaines', 'icon' => 'fa-users'],
    ['slug' => 'gestion_utilisateurs', 'label' => 'Gestion des utilisateurs', 'icon' => 'fa-user'],
    ['slug' => 'gestion_habilitations', 'label' => 'Gestion des habilitations et mot de passe', 'icon' => 'fa-mask'],
    ['slug' => 'piste_audit', 'label' => 'Gestion de la piste d\'audit', 'icon' => 'fa-history'],
    ['slug' => 'sauvegarde_restauration', 'label' => 'Sauvegarde et restauration des données', 'icon' => 'fa-save'],
    ['slug' => 'parametres_generaux', 'label' => 'Paramètres généraux', 'icon' => 'fa-gears'],
];

// Déterminer la page actuelle du menu principal.
$currentMenuSlug = 'dashboard'; // Page par défaut
$allowedMenuPages = array_column($menuItems, 'slug');
if (isset($_GET['page']) && in_array($_GET['page'], $allowedMenuPages)) {
    $currentMenuSlug = $_GET['page'];
}

// Initialiser les variables
$currentAction = null;
$contentFile = '';
$currentPageLabel = '';


$partialsBasePath ='..' . DIRECTORY_SEPARATOR . 'ressources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR ;
    // Logique spécifique pour la section "Paramètres Généraux"
if ($currentMenuSlug === 'parametres_generaux') {
    if (isset($_GET['action'])) {
        $allowedActions = [
        'annees_academiques', 'grades', 'fonctions', 'specialites', 'niveaux_etude',
        'ue', 'ecue', 'statuts_jury', 'niveaux_approbation', 'semestres',
            'niveaux_acces', 'traitements', 'entreprises', 'actions', 'fonctions_enseignants'
    ];
    if (in_array($_GET['action'], $allowedActions)) {
        $currentAction = $_GET['action'];
            $contentFile = $partialsBasePath .'partials\parametres_generaux'.DIRECTORY_SEPARATOR . $currentAction . '.php';
            // Pour le label, vous voudrez peut-être un mapping plus précis
            // que de simplement formater le slug de l'action.
            // Par exemple, récupérer le titre de la carte correspondante.
            // Pour l'instant, on formate le slug de l'action :
            $currentPageLabel = ucfirst(str_replace('_', ' ', $currentAction));
} else {
            // Action non valide, afficher la page des cartes par défaut ou une erreur
            $contentFile = $partialsBasePath . 'parametres_generaux_content.php';
            $currentPageLabel = 'Paramètres Généraux';
            // Optionnel: afficher un message d'erreur pour action non valide
        }
                } else {
        // Pas d'action spécifiée pour les paramètres généraux, afficher les cartes
        $contentFile = $partialsBasePath . 'parametres_generaux_content.php';
        $currentPageLabel = 'Paramètres Généraux';
    }
} else {
    // Logique pour les autres pages du menu principal (dashboard, users, etc.)
    $contentFile = $partialsBasePath . $currentMenuSlug . '_content.php';
    foreach ($menuItems as $item) {
        if ($item['slug'] === $currentMenuSlug) {
            $currentPageLabel = $item['label'];
            break;
        }
    }
}

// Si aucun label n'a été trouvé (par exemple, pour une page non listée dans $menuItems et sans action)
if (empty($currentPageLabel)) {
    $currentPageLabel = "Soutenance Manager"; // Ou une autre valeur par défaut appropriée
    // Si $contentFile est aussi vide, vous pourriez vouloir charger une page 404 par défaut
    if (empty($contentFile)) {
        // $contentFile = $partialsBasePath . '404_content.php'; // Exemple
    }
}
                ?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soutenance Manager | <?php echo htmlspecialchars($currentPageLabel); ?></title>
    <!-- Chemin vers output.css: si layout_admin.php est dans ressources/views/admin/
         et output.css est dans public/css/, le chemin relatif est ../../../public/css/output.css -->
    <link rel="stylesheet" href="../../../public/css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 border-r border-gray-200 bg-white">
                <div class="flex items-center justify-center h-16 px-4 bg-green-100 shadow-sm">
                    <div class="flex items-center">
                        <a href="?page=dashboard" class="text-green-500 font-bold text-xl">Soutenance Manager</a>
                    </div>
                </div>
                <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto">
                    <div class="space-y-2 pb-3">
                        <?php foreach ($menuItems as $item): ?>
                        <?php
                            // Pour l'état actif, on vérifie si le slug du menu principal correspond.
                            // Si la page actuelle est 'parametres_generaux', elle sera active même si une action est sélectionnée.
                            $isActive = ($currentMenuSlug === $item['slug']);
                            $linkBaseClasses = "flex items-center px-2 py-3 text-sm font-medium rounded-md group";
                            $activeClasses = "text-white bg-green-500";
                            $inactiveClasses = "text-gray-700 hover:text-gray-900 hover:bg-gray-100";
                            $iconBaseClasses = "mr-3";
                            $iconActiveClasses = "text-white";
                            $iconInactiveClasses = "text-gray-400 group-hover:text-gray-500";
                            ?>
                        <a href="?page=<?php echo htmlspecialchars($item['slug']); ?>"
                            class="<?php echo $linkBaseClasses . ' ' . ($isActive ? $activeClasses : $inactiveClasses); ?>">
                            <i
                                class="fas <?php echo htmlspecialchars($item['icon']); ?> <?php echo $iconBaseClasses . ' ' . ($isActive ? $iconActiveClasses : $iconInactiveClasses); ?>"></i>
                            <?php echo htmlspecialchars($item['label']); ?>
                        </a>
                        <?php endforeach; ?>
                        <a href="logout.php"
                            class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 group">
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
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 bg-green-100 shadow-sm">
                <div class="flex items-center">
                    <button id="mobileMenuButton" class="md:hidden text-gray-500 focus:outline-none mr-3">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1 class="text-lg font-medium text-green-500"><?php echo htmlspecialchars($currentPageLabel); ?>
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
            <div class="flex-1 p-4 md:p-6 overflow-y-auto">
                <?php
                // Bouton Retour si on est dans une action spécifique des paramètres généraux
                if ($currentMenuSlug === 'parametres_generaux' && $currentAction):
                ?>
                <div class="mb-6">
                    <a href="?page=parametres_generaux"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-500 rounded-md hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Retour aux Paramètres
                    </a>
                </div>
                <?php endif; ?>

                <?php
                if (!empty($contentFile) && file_exists($contentFile)) {
                    include $contentFile;
                } else {
                    echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative' role='alert'>";
                    echo "<strong class='font-bold'>Erreur de contenu !</strong>";
                    if (empty($contentFile)) {
                        echo "<span class='block sm:inline'> Aucun fichier de contenu n'a été spécifié pour cette vue.</span>";
                    } else {
                        echo "<span class='block sm:inline'> Le fichier de contenu pour '" . htmlspecialchars($currentPageLabel) . "' n'a pas été trouvé.</span>";
                        echo "<p class='text-sm'>Chemin vérifié : " . htmlspecialchars($contentFile) . "</p>";
                    }
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobileMenuButton'); // Utilisation de l'ID
        const sidebar = document.querySelector(
            '.hidden.md\\:flex.md\\:flex-shrink-0 > .flex.flex-col.w-64'); // Sélecteur plus précis

        if (mobileMenuButton && sidebar) {
            mobileMenuButton.addEventListener('click', function() {
                sidebar.classList.toggle('hidden'); // Bascule la classe hidden sur la sidebar elle-même
                // Si vous voulez que la sidebar se superpose sur mobile au lieu de pousser le contenu :
                // sidebar.classList.toggle('absolute');
                // sidebar.classList.toggle('z-20'); // Pour s'assurer qu'elle est au-dessus
            });
        }

        // Le reste de votre JS pour les cartes et la cloche de notification peut rester ici
        const documentCards = document.querySelectorAll('.document-card');
        documentCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
            });
        });

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