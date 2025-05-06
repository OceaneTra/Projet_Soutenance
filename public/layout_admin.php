<?php
// Définir les éléments du menu
// Chaque élément a un 'slug' (utilisé dans l'URL et pour le nom de fichier),
// un 'label' (ce qui est affiché) et optionnellement une 'icon' (classe Font Awesome par exemple)
$menuItems = [
    ['slug' => 'dashboard',         'label' => 'Tableau de bord', 'icon' => 'fa-home'],
    ['slug' => 'gestion_etudiants', 'label' => 'Gestion des étudiants', 'icon' => 'fa-book'],
    ['slug' => 'gestion_rh',        'label' => 'Gestion des ressources humaines', 'icon' => 'fa-users'],
    ['slug' => 'gestion_utilisateurs', 'label' => 'Gestion des utilisateurs', 'icon' => 'fa-user'],
    ['slug' => 'gestion_habilitations', 'label' => 'Gestion des habilitations et mot de passe', 'icon' => 'fa-mask'], // ou fa-key, fa-user-shield
    ['slug' => 'piste_audit',       'label' => 'Gestion de la piste d\'audit', 'icon' => 'fa-history'],
    ['slug' => 'sauvegarde_restauration', 'label' => 'Sauvegarde et restauration des données', 'icon' => 'fa-save'], // ou fa-database
    ['slug' => 'parametres_generaux', 'label' => 'Paramètres généraux', 'icon' => 'fa-gears'], // ou fa-cogs
    // Le lien de déconnexion sera géré séparément car il n'inclut pas de contenu de page
];

// Déterminer la page actuelle. Par défaut, ce sera 'dashboard'.
// Il est TRÈS IMPORTANT de valider le paramètre 'page' pour éviter les inclusions de fichiers arbitraires.
$currentPageSlug = 'dashboard'; // Page par défaut
$allowedPages = array_column($menuItems, 'slug'); // Obtenir tous les slugs valides

if (isset($_GET['page']) && in_array($_GET['page'], $allowedPages)) {
    $currentPageSlug = $_GET['page'];
}

// Construire le chemin vers le fichier de contenu
// Assurez-vous que vos fichiers de contenu sont dans un dossier 'partials' à côté de layout_admin.php
// et nommés comme 'dashboard_content.php', 'gestion_etudiants_content.php', etc.
$contentFile = '../ressources'.DIRECTORY_SEPARATOR .'views'.DIRECTORY_SEPARATOR . $currentPageSlug . '_content.php';

// Trouver le label de la page actuelle pour le titre
$currentPageLabel = 'Tableau de Bord'; // Label par défaut
foreach ($menuItems as $item) {
    if ($item['slug'] === $currentPageSlug) {
        $currentPageLabel = $item['label'];
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soutenance Manager | <?php echo htmlspecialchars($currentPageLabel); ?></title>
    <!-- Assurez-vous que ce chemin est correct. Si layout_admin.php est à la racine,
         et votre CSS est dans public/css/, alors ce devrait être "public/css/output.css" -->
    <link rel="stylesheet" href="./css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 border-r border-gray-200 bg-white  ">
                <div class="flex items-center justify-center h-16 px-4 bg-green-100 shadow-sm">
                    <div class="flex items-center">
                        <!-- Lien vers le tableau de bord par défaut -->
                        <a href="?page=dashboard" class="text-green-500 font-bold text-xl">Soutenance Manager</a>
                    </div>
                </div>
                <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto ">
                    <div class="space-y-2 pb-3">
                        <?php foreach ($menuItems as $item): ?>
                        <?php
                                $isActive = ($currentPageSlug === $item['slug']);
                                $linkBaseClasses = "flex items-center px-2 py-3 text-sm font-medium rounded-md group";
                                $activeClasses = "text-white bg-green-500"; // Classes si actif
                                $inactiveClasses = "text-gray-700 hover:text-gray-900 hover:bg-gray-100"; // Classes si inactif
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

                        <!-- Lien de déconnexion (géré séparément) -->
                        <a href="logout.php" class="flex items-center px-2 py-3 text-sm font-medium rounded-md text-gray-700
                            hover:text-gray-900 hover:bg-gray-100 group">
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
                        <!-- Ajout d'un ID et marge -->
                        <i class="fas fa-bars"></i>
                    </button>
                    <!-- Le titre de la page est maintenant dynamique -->
                    <h1 class="text-lg font-medium text-green-500"><?php echo htmlspecialchars($currentPageLabel); ?>
                    </h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="flex items-center space-x-2 focus:outline-none">
                            <span class="text-m font-medium text-green-500">Bienvenue, Administrateur</span>
                            <!-- Peut-être une icône de profil ici -->
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <div class="flex-1 p-4 md:p-6 overflow-y-auto">
                <!-- Ajout de padding et overflow -->
                <?php
                if (file_exists($contentFile)) {
                    include $contentFile;
                } else {
                    echo "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative' role='alert'>";
                    echo "<strong class='font-bold'>Erreur de contenu !</strong>";
                    echo "<span class='block sm:inline'> Le fichier de contenu pour la page '" . htmlspecialchars($currentPageSlug) . "' n'a pas été trouvé.</span>";
                    echo "<p class='text-sm'>Chemin vérifié : " . htmlspecialchars($contentFile) . "</p>";
                    echo "</div>";
                    // Vous pourriez inclure un fichier partials/404_content.php ici
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