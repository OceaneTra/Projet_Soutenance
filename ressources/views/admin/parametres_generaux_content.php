<?php
// Tableau de données pour vos cartes avec des titres et descriptions personnalisés.
// Chaque élément du tableau représente une carte.
$cardData = [
    [
        'title' => 'Années Académiques',
        'description' => 'Gérer les années académiques, les dates de début et de fin.',
        'link' => '?page=parametres_generaux&action=annees_academiques', // Adaptez le lien
        'icon' => 'fa-calendar-alt' // Optionnel: vous pouvez ajouter une icône
    ],
    [
        'title' => 'Gestion des Grades',
        'description' => 'Définir et administrer les différents grades académiques.',
        'link' => '?page=parametres_generaux&action=grades',
        'icon' => 'fa-graduation-cap'
    ],
    [
        'title' => 'Fonctions Utilisateurs',
        'description' => 'Configurer les rôles et fonctions des utilisateurs du système.',
        'link' => '?page=parametres_generaux&action=fonctions',
        'icon' => 'fa-user-tie'
    ],
    [
        'title' => 'Spécialités des enseignants',
        'description' => 'Administrer les spécialités et filières proposées.',
        'link' => '?page=parametres_generaux&action=specialites',
        'icon' => 'fa-microscope'
    ],
    [
        'title' => 'Niveaux d\'Étude',
        'description' => 'Gérer les différents niveaux d\'étude (Licence, Master, etc.).',
        'link' => '?page=parametres_generaux&action=niveaux_etude',
        'icon' => 'fa-layer-group'
    ],
    [
        'title' => 'Unités d\'Enseignement (UE)',
        'description' => 'Définir les unités d\'enseignement et leurs crédits.',
        'link' => '?page=parametres_generaux&action=ue',
        'icon' => 'fa-book-open'
    ],
    [
        'title' => 'Éléments Constitutifs (ECUE)',
        'description' => 'Gérer les éléments constitutifs des unités d\'enseignement.',
        'link' => '?page=parametres_generaux&action=ecue',
        'icon' => 'fa-puzzle-piece'
    ],
    [
        'title' => 'Statuts du Jury',
        'description' => 'Configurer les différents statuts possibles pour les membres du jury.',
        'link' => '?page=parametres_generaux&action=statuts_jury',
        'icon' => 'fa-gavel'
    ],

    [
        'title' => 'Niveaux d\'Approbation',
        'description' => 'Définir les circuits et niveaux d\'approbation pour les documents.',
        'link' => '?page=parametres_generaux&action=niveaux_approbation',
        'icon' => 'fa-check-double'
    ],
     [
        'title' => 'Semestres',
        'description' => 'Définir les différents semestres et UE associées.',
        'link' => '?page=parametres_generaux&action=semestres',
        'icon' => 'fa-graduation-cap'
    ],
     [
        'title' => 'Niveaux d\'Accès',
        'description' => 'Définir les différents niveaux d\'accès pour les utilisateurs',
        'link' => '?page=parametres_generaux&action=niveaux_acces',
        'icon' => 'fa-check-double',
    ],
     [
        'title' => 'Traitements',
        'description' => 'Définir les traitements à affecter aux différents utilisateurs.',
        'link' => '?page=parametres_generaux&action=traitements',
        'icon' => 'fa-solid fa-server'
    ], [
        'title' => 'Entreprises',
        'description' => 'Gérer les entreprises partenaires et leurs informations.',
        'link' => '?page=parametres_generaux&action=entreprises',
        'icon' => 'fa-solid fa-briefcase'
    ],
     [
        'title' => 'Actions',
        'description' => 'Définir les actions possibles pour les utilisateurs dans le système.',
        'link' => '?page=parametres_generaux&action=actions',
        'icon' => 'fa-solid fa-location-crosshairs'
    ],
     [
        'title' => 'Fonctions',
        'description' => 'Définir les fonctions exercées par les enseignants dans le système.',
        'link' => '?page=parametres_generaux&action=niveaux_approbation',
        'icon' => 'fa-solid fa-briefcase'
    ],
    

];
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold text-gray-800 mb-8 text-center">Paramètres Généraux de l'Application</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php foreach ($cardData as $card): ?>
        <div
            class="bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col transition-all duration-300 ease-in-out hover:shadow-lg hover:transform hover:-translate-y-1">
            <div class="p-6 flex-grow">
                <a href="<?php echo htmlspecialchars($card['link']); ?>" class="group">
                    <?php if (!empty($card['icon'])): ?>
                    <div
                        class="flex items-center justify-center w-12 h-12  rounded-full mb-4 mx-auto transition-colors">
                        <i class="fas <?php echo htmlspecialchars($card['icon']); ?> text-2xl text-green-500"></i>
                    </div>
                    <?php endif; ?>
                    <h5
                        class="mb-2 text-xl font-semibold tracking-tight text-center text-gray-900 dark:text-white group-hover:text-green-600 transition-colors">
                        <?php echo htmlspecialchars($card['title']); ?>
                    </h5>
                </a>
                <p class="mb-3 font-normal text-gray-600 dark:text-gray-400 text-sm text-center">
                    <?php echo htmlspecialchars($card['description']); ?>
                </p>
            </div>
            <div class="p-4 pt-0 text-center border-t border-gray-100 dark:border-gray-700 mt-auto">
                <!-- mt-auto pour pousser vers le bas -->
                <a href="<?php echo htmlspecialchars($card['link']); ?>"
                    class="inline-flex  items-center justify-center px-4 py-2 text-sm font-medium text-center text-white bg-green-300 rounded-md hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 transition-colors w-full sm:w-auto">
                    Accéder
                    <i class=" px-2 fa fa-chevron-right"></i>

                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>