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
        'title' => 'Spécialités d\'Études',
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
        'title' => 'Groupes d\'Utilisateurs',
        'description' => 'Créer et gérer des groupes d\'utilisateurs avec des permissions spécifiques.',
        'link' => '?page=parametres_generaux&action=groupes_utilisateurs',
        'icon' => 'fa-users-cog'
    ],
    [
        'title' => 'Niveaux d\'Approbation',
        'description' => 'Définir les circuits et niveaux d\'approbation pour les documents.',
        'link' => '?page=parametres_generaux&action=niveaux_approbation',
        'icon' => 'fa-check-double'
    ],
    [
        'title' => 'Modèles de Documents',
        'description' => 'Gérer les modèles de documents utilisés dans le système.',
        'link' => '?page=parametres_generaux&action=modeles_documents',
        'icon' => 'fa-file-alt'
    ],
    [
        'title' => 'Configuration Email',
        'description' => 'Paramétrer les serveurs SMTP et les notifications par email.',
        'link' => '?page=parametres_generaux&action=config_email',
        'icon' => 'fa-envelope'
    ],
    [
        'title' => 'Thèmes et Apparence',
        'description' => 'Personnaliser l\'apparence visuelle de l\'application.',
        'link' => '?page=parametres_generaux&action=themes',
        'icon' => 'fa-palette'
    ],
    [
        'title' => 'Intégrations Externes',
        'description' => 'Configurer les connexions avec d\'autres services ou API.',
        'link' => '?page=parametres_generaux&action=integrations',
        'icon' => 'fa-plug'
    ],
    [
        'title' => 'Sauvegarde des Données',
        'description' => 'Planifier et exécuter les sauvegardes de la base de données.',
        'link' => '?page=parametres_generaux&action=sauvegarde',
        'icon' => 'fa-database'
    ],
    [
        'title' => 'Piste d\'Audit',
        'description' => 'Consulter les journaux d\'activités et les modifications du système.',
        'link' => '?page=parametres_generaux&action=audit_log',
        'icon' => 'fa-clipboard-list'
    ],
    [
        'title' => 'Informations Système',
        'description' => 'Voir les informations sur la version et l\'état du serveur.',
        'link' => '?page=parametres_generaux&action=system_info',
        'icon' => 'fa-info-circle'
    ]
    // Ajoutez autant de cartes que nécessaire pour atteindre 17 ou plus.
];
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold text-gray-800 mb-8 text-center">Paramètres Généraux de l'Application</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php foreach ($cardData as $card): ?>
        <div
            class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 flex flex-col transition-all duration-300 ease-in-out hover:shadow-lg hover:transform hover:-translate-y-1">
            <div class="p-6 flex-grow">
                <a href="<?php echo htmlspecialchars($card['link']); ?>" class="group">
                    <?php if (!empty($card['icon'])): ?>
                    <div
                        class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-full mb-4 mx-auto group-hover:bg-green-200 transition-colors">
                        <i class="fas <?php echo htmlspecialchars($card['icon']); ?> text-2xl text-green-600"></i>
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
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-center text-white bg-green-500 rounded-md hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 transition-colors w-full sm:w-auto">
                    Accéder
                    <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9" />
                    </svg>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>