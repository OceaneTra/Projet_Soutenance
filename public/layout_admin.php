<?php
session_start();


// Définir les éléments du menu principal
$menuItems = [
    ['slug' => 'dashboard', 'label' => 'Tableau de bord', 'icon' => 'fa-home'],
    ['slug' => 'gestion_etudiants', 'label' => 'Gestion des étudiants', 'icon' => 'fa-book'],
    ['slug' => 'gestion_rh', 'label' => 'Gestion des ressources humaines', 'icon' => 'fa-users'],
    ['slug' => 'gestion_utilisateurs', 'label' => 'Gestion des utilisateurs', 'icon' => 'fa-user'],
    ['slug' => 'piste_audit', 'label' => 'Gestion de la piste d\'audit', 'icon' => 'fa-history'],
    ['slug' => 'sauvegarde_restauration', 'label' => 'Sauvegarde et restauration des données', 'icon' => 'fa-save'],
    ['slug' => 'parametres_generaux', 'label' => 'Paramètres généraux', 'icon' => 'fa-gears'],
    ['slug' => 'profil', 'label' => 'Profil', 'icon' => 'fa-user'],
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


$partialsBasePath = '..' . DIRECTORY_SEPARATOR . 'ressources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR;
// Logique spécifique pour la section "Paramètres Généraux"
if ($currentMenuSlug === 'parametres_generaux') {
    include __DIR__ . '/../ressources/routes/parametreGenerauxRouteur.php'; // ajuste le chemin selon ta structure
    if (isset($_GET['action'])) {
        $allowedActions = [
            'annees_academiques', 'grades', 'fonctions', 'fonction_utilisateur', 'specialites', 'niveaux_etude',
            'ue', 'ecue', 'statut_jury', 'niveaux_approbation', 'semestres',
            'niveaux_acces', 'traitements', 'entreprises', 'actions', 'fonctions_enseignants','messages',
        ];
        if (in_array($_GET['action'], $allowedActions)) {
            $currentAction = $_GET['action'];
            $contentFile = $partialsBasePath . 'partials/parametres_generaux' . DIRECTORY_SEPARATOR . $currentAction . '.php';
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

// Tableau de données pour vos cartes avec des titres et descriptions personnalisés.
// Chaque élément du tableau représente une carte.
$cardData = [
    [
        'title' => 'Années Académiques',
        'description' => 'Gérer les années académiques, les dates de début et de fin.',
        'link' => '?page=parametres_generaux&action=annees_academiques', // Adaptez le lien
        'icon' => './images/date-du-calendrier.png' // Optionnel: vous pouvez ajouter une icône
    ],
    [
        'title' => 'Gestion des Grades',
        'description' => 'Définir et administrer les différents grades académiques.',
        'link' => '?page=parametres_generaux&action=grades',
        'icon' => './images/diplome.png'
    ],
    [
        'title' => 'Fonctions Utilisateurs',
        'description' => 'Configurer les rôles et fonctions des utilisateurs du système.',
        'link' => '?page=parametres_generaux&action=fonction_utilisateur&tab=groupes',
        'icon' => './images/equipe.png'
    ],
    [
        'title' => 'Spécialités des enseignants',
        'description' => 'Administrer les spécialités et filières proposées.',
        'link' => '?page=parametres_generaux&action=specialites',
        'icon' => './images/marche-de-niche.png'
    ],
    [
        'title' => 'Niveaux d\'Étude',
        'description' => 'Gérer les différents niveaux d\'étude (Licence, Master, etc.).',
        'link' => '?page=parametres_generaux&action=niveaux_etude',
        'icon' => './images/livre.png'
    ],
    [
        'title' => 'Unités d\'Enseignement (UE)',
        'description' => 'Définir les unités d\'enseignement et leurs crédits.',
        'link' => '?page=parametres_generaux&action=ue',
        'icon' => './images/livre-ouvert.png'
    ],
    [
        'title' => 'Éléments Constitutifs (ECUE)',
        'description' => 'Gérer les éléments constitutifs des unités d\'enseignement.',
        'link' => '?page=parametres_generaux&action=ecue',
        'icon' => './images/piece-de-puzzle.png'
    ],
    [
        'title' => 'Statuts du Jury',
        'description' => 'Configurer les différents statuts possibles pour les membres du jury.',
        'link' => '?page=parametres_generaux&action=statut_jury',
        'icon' => './images/droit.png'
    ],

    [
        'title' => 'Niveaux d\'Approbation',
        'description' => 'Définir les circuits et niveaux d\'approbation pour les documents.',
        'link' => '?page=parametres_generaux&action=niveaux_approbation',
        'icon' => './images/check.png'
    ],
     [
        'title' => 'Semestres',
        'description' => 'Définir les différents semestres et UE associées.',
        'link' => '?page=parametres_generaux&action=semestres',
        'icon' => './images/diplome.png'
    ],
     [
        'title' => 'Niveaux d\'Accès',
        'description' => 'Définir les différents niveaux d\'accès pour les utilisateurs',
        'link' => '?page=parametres_generaux&action=niveaux_acces',
        'icon' => './images/check.png',
    ],
     [
        'title' => 'Traitements',
        'description' => 'Définir les traitements à affecter aux différents utilisateurs.',
        'link' => '?page=parametres_generaux&action=traitements',
        'icon' => './images/bd.png'
    ], [
        'title' => 'Entreprises',
        'description' => 'Gérer les entreprises partenaires et leurs informations.',
        'link' => '?page=parametres_generaux&action=entreprises',
        'icon' => './images/valise.png'
    ],
     [
        'title' => 'Actions',
        'description' => 'Définir les actions possibles pour les utilisateurs dans le système.',
        'link' => '?page=parametres_generaux&action=actions',
        'icon' => './images/cible.png'
     ],
     [
        'title' => 'Fonctions',
        'description' => 'Définir les fonctions exercées par les enseignants dans le système.',
        'link' => '?page=parametres_generaux&action=fonctions',
        'icon' => './images/valise.png'
    ],
    [
        'title' => 'Messagerie',
        'description' => 'Définition des messages d\'erreur à afficher dans le système.',
        'link' => '?page=parametres_generaux&action=messages',
        'icon' => './images/enveloppe.png'
    ],
];




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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/l10n/fr.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden md:flex md:flex-shrink-0">
            <div class="flex flex-col w-64 border-r border-gray-200 bg-white">
                <div class="flex items-center justify-center h-16 px-4 bg-green-100 shadow-sm">
                    <div class="flex overflow-hidden items-center">

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
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-green-500 transition-colors">
                        <i class="fas fa-arrow-left mr-2 "></i>
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