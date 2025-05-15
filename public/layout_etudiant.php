<?php
include '../app/config/database.php';
session_start();


// Définir les éléments du menu principal
$menuItems = [
    ['slug' => 'candidature_soutenance', 'label' => 'Candidater à la soutenance', 'icon' => 'fa-graduation-cap'],
    ['slug' => 'gestion_rapport', 'label' => 'Gestion des rapports', 'icon' => 'fa-file'],
    ['slug' => 'gestion_reclamations', 'label' => 'Réclamations', 'icon' => 'fa-exclamation'],
    ['slug' => 'notes_resultats', 'label' => 'Notes & résultats', 'icon' => 'fa-note-sticky'],
    ['slug' => 'messagerie', 'label' => 'Messagerie', 'icon' => 'fa-envelope'],
    ['slug' => 'profil', 'label' => 'Profil', 'icon' => 'fa-user'],
    
];
$cardData = [
    [
        'title' => 'Soumettre une Réclamation',
        'description' => 'Déposez une nouvelle réclamation en remplissant le formulaire dédié.',
        'link' => '?page=gestion_reclamations&action=soumettre_reclamation', // Adaptez le lien
        'icon' => 'fa-solid fa-circle-exclamation ', // Optionnel: vous pouvez ajouter une icône
        'title_link' => 'Soumettre',
        'bg_color' =>'bg-blue-300 ',
        'text_color' => 'text-blue-500'
    ],
    [
        'title' => 'Suivre mes Réclamations',
        'description' => 'Consultez l\'état actuel de vos réclamations en cours.',
        'link' => '?page=gestion_reclamations&action=suivi_reclamation',
        'icon' => 'fa-solid fa-eye ',
        'title_link' => 'Suivre',
        'bg_color' =>'bg-yellow-500 ',
        'text_color' =>'text-yellow-600'
    ],
    [
        'title' => 'Historique des Réclamations',
        'description' => 'Accédez à l\'historique complet de vos réclamations passées.',
        'link' => '?page=gestion_reclamations&action=historique_reclamation',
        'icon' => 'fa-solid fa-clock-rotate-left ',
        'title_link' => 'Consulter',
        'bg_color' =>'bg-purple-300 ',
        'text_color' =>'text-purple-600'
    ]
];

// Déterminer la page actuelle du menu principal.
$currentMenuSlug = 'candidature_soutenance'; // Page par défaut
$allowedMenuPages = array_column($menuItems, 'slug');
if (isset($_GET['page']) && in_array($_GET['page'], $allowedMenuPages)) {
    $currentMenuSlug = $_GET['page'];
}

// Initialiser les variables
$currentAction = null;
$contentFile = '';
$currentPageLabel = '';


$partialsBasePath = '..' . DIRECTORY_SEPARATOR . 'ressources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'etudiant' . DIRECTORY_SEPARATOR;

// Logique spécifique pour la section "Gestion des réclamations"

if ($currentMenuSlug === 'gestion_reclamations') {
    include __DIR__ . '/../ressources/routes/gestionReclamationsRouteur.php'; // Ajustez le chemin si nécessaire

    $allowedActions = ['soumettre_reclamation', 'suivi_reclamation', 'historique_reclamation'];

    if (isset($_GET['action']) && in_array($_GET['action'], $allowedActions)) {
        $currentAction = $_GET['action'];
        $contentFile = $partialsBasePath . 'partials/gestion_reclamations/' . $currentAction . '.php';
        $currentPageLabel = ucfirst(str_replace('_', ' ', $currentAction));
    } else {
        // Si aucune action valide n'est spécifiée, affichez la page par défaut
        $contentFile = $partialsBasePath . 'gestion_reclamations_content.php';
        $currentPageLabel = 'Gestion des réclamations';
    }
} else if ($currentMenuSlug === 'gestion_rapport') {
    // Ajustez le chemin si nécessaire

    $allowedActions = ['creer_rapport', 'suivi_rapport', 'compte_rendu_rapport'];

    if (isset($_GET['action']) && in_array($_GET['action'], $allowedActions)) {
        $currentAction = $_GET['action'];
        $contentFile = $partialsBasePath . 'partials/gestion_rapports/' . $currentAction . '.php';
        $currentPageLabel = ucfirst(str_replace('_', ' ', $currentAction));
    } else {
        // Si aucune action valide n'est spécifiée, affichez la page par défaut
        $contentFile = $partialsBasePath . 'gestion_rapport_content.php';
        $currentPageLabel = 'Gestion des rapports';
    }
}


else {
    // Logique pour les autres pages
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
    <link rel="stylesheet" href="css/output.css">
    <link rel="shortcut icon" href="./images/dessin.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/l10n/fr.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 border-r border-gray-200 bg-white">
                <div class="flex items-center justify-center h-16 px-4 bg-green-100 shadow-sm">
                    <div class="flex overflow-hidden items-center">

                        <a href="?page=candidater_soutenance" class="text-green-500 font-bold text-xl">Soutenance
                            Manager</a>
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
                        <a href=""
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
                            <span class="text-m font-medium text-green-500">Bienvenue, Étudiant</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main content area -->
            <div class="flex-1 p-4 md:p-6 overflow-y-auto">
                <?php
            // Bouton Retour si on est dans une action spécifique des paramètres généraux
            if ($currentMenuSlug === 'gestion_reclamations' && $currentAction):
                ?>
                <div class="mb-6">
                    <a href="?page=gestion_reclamations"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-500 transition-colors">
                        <i class="fas fa-arrow-left mr-2 "></i>
                        Retour
                    </a>
                </div>
                <?php endif; ?>
                <?php
                if ($currentMenuSlug === 'gestion_rapport' && $currentAction):
                ?>
                <div class="mb-6">
                    <a href="?page=gestion_rapport"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-500 transition-colors">
                        <i class="fas fa-arrow-left mr-2 "></i>
                        Retour
                    </a>
                </div>
                <?php endif ;?>


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
                sidebar.classList.toggle('absolute');
                sidebar.classList.toggle('z-20'); // Pour s'assurer qu'elle est au-dessus
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
    <script src="./js/suivi_reclamation.js"></script>
    <script src="./js/historique_reclamation.js"></script>
</body>

</html>