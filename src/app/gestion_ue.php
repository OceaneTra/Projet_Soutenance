<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des UE | ScholarSync</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/src/assets/css/styles.css">
    >
</head>

<body class="min-h-screen bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <?php include __DIR__ . '/composants/sidebar.php'; ?>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <?php include __DIR__ . '/composants/header.php'; ?>

            <!-- Main content area -->
            <div class="flex-1 overflow-auto p-4 md:p-6">
                <?php include __DIR__ . '/composants/student_info.php'; ?>

                <!-- Current semester -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Semestre en cours - Automne 2023</h2>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Validé
                            </span>
                            <span class="text-sm font-medium text-gray-500">24/30 ECTS</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php
                        require_once __DIR__ . '/composants/ue_card.php';

                        // UE Card 1
                        echo renderUeCard([
                            'code' => 'INF501',
                            'title' => 'Algorithmique avancée',
                            'professor' => 'Prof. Martin Dupont',
                            'ects' => '6',
                            'isOptional' => false,
                            'status' => 'validated',
                            'score' => '14.5'
                        ]);

                        // UE Card 2
                        echo renderUeCard([
                            'code' => 'INF502',
                            'title' => 'Bases de données',
                            'professor' => 'Prof. Sophie Martin',
                            'ects' => '6',
                            'isOptional' => false,
                            'status' => 'validated',
                            'score' => '12.0'
                        ]);

                        // UE Card 3
                        echo renderUeCard([
                            'code' => 'INF503',
                            'title' => 'Sécurité informatique',
                            'professor' => 'Prof. Jean Leroy',
                            'ects' => '6',
                            'isOptional' => false,
                            'status' => 'validated',
                            'score' => '15.5'
                        ]);

                        // UE Card 4
                        echo renderUeCard([
                            'code' => 'OPT701',
                            'title' => 'Intelligence Artificielle',
                            'professor' => 'Prof. Alice Durand',
                            'ects' => '6',
                            'isOptional' => true,
                            'status' => 'validated',
                            'score' => '16.0'
                        ]);

                        // UE Card 5
                        echo renderUeCard([
                            'code' => 'OPT702',
                            'title' => 'Blockchain',
                            'professor' => 'Prof. Pierre Lambert',
                            'ects' => '6',
                            'isOptional' => true,
                            'status' => 'validated',
                            'score' => '13.5'
                        ]);
                        ?>
                    </div>
                </div>

                <!-- Next semester -->
                <div class="mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Prochain semestre - Printemps 2024</h2>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                À compléter
                            </span>
                            <span class="text-sm font-medium text-gray-500">12/30 ECTS</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php
                        // UE Card 6
                        echo renderUeCard([
                            'code' => 'INF601',
                            'title' => 'Architecture logicielle',
                            'professor' => 'Prof. Martin Dupont',
                            'ects' => '6',
                            'isOptional' => false,
                            'status' => 'in_progress'
                        ]);

                        // UE Card 7
                        echo renderUeCard([
                            'code' => 'INF602',
                            'title' => 'Cloud Computing',
                            'professor' => 'Prof. Sophie Martin',
                            'ects' => '6',
                            'isOptional' => false,
                            'status' => 'in_progress'
                        ]);

                        // UE to choose
                        echo renderUeCard([
                            'ects' => '6',
                            'status' => 'to_choose'
                        ]);
                        ?>
                    </div>
                </div>

                <?php include __DIR__ . '/composants/settings_panel.php'; ?>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/composants/ue_modal.php'; ?>

    <script src="../assets/js/scripts.js"></script>
</body>

</html>