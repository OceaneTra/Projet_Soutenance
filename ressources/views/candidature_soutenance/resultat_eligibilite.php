<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat de vérification d'éligibilité | Soutenance Manager</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <!-- En-tête -->
                <div class="p-6 bg-gradient-to-r from-green-50 to-blue-50 border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Résultat de la vérification d'éligibilité</h2>
                    <p class="text-gray-600">Voici le résultat de votre demande de vérification d'éligibilité.</p>
                </div>

                <!-- Contenu -->
                <div class="p-6">
                    <!-- Informations de l'étudiant -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-user text-green-500 mr-2"></i>
                            Informations de l'étudiant
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                                <p class="mt-1 text-gray-900"><?= esc($data['nom_complet']) ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Numéro d'étudiant</label>
                                <p class="mt-1 text-gray-900"><?= esc($data['numero_etudiant']) ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Formation</label>
                                <p class="mt-1 text-gray-900"><?= esc($data['formation']) ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Promotion</label>
                                <p class="mt-1 text-gray-900"><?= esc($data['promotion']) ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Résultat de l'éligibilité -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-clipboard-check text-green-500 mr-2"></i>
                            Résultat de l'éligibilité
                        </h3>

                        <!-- Barre de progression -->
                        <div class="mb-6">
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Progression de vérification</span>
                                <span class="text-sm font-medium text-green-600"><?= round($eligibilite['pourcentage']) ?>%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="progress-bar bg-green-500 h-2.5 rounded-full" style="width: <?= $eligibilite['pourcentage'] ?>%"></div>
                            </div>
                        </div>

                        <!-- Conditions -->
                        <div class="space-y-4">
                            <?php foreach ($eligibilite['conditions'] as $condition => $remplie): ?>
                            <div class="p-4 border rounded-lg flex items-start <?= $remplie ? 'bg-green-50' : 'bg-red-50' ?>">
                                <div class="mr-3 mt-1">
                                    <?php if ($remplie): ?>
                                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                                    <?php else: ?>
                                    <i class="fas fa-times-circle text-red-500 text-xl"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-grow">
                                    <h4 class="font-medium text-gray-800">
                                        <?php
                                        switch ($condition) {
                                            case 'rapport_stage':
                                                echo 'Rapport de stage déposé';
                                                break;
                                            case 'fiche_evaluation':
                                                echo 'Fiche d\'évaluation complétée';
                                                break;
                                            case 'soutenance_blanche':
                                                echo 'Soutenance blanche réalisée';
                                                break;
                                            case 'memoire':
                                                echo 'Dépôt du mémoire';
                                                break;
                                        }
                                        ?>
                                    </h4>
                                    <div class="mt-2 text-sm <?= $remplie ? 'text-green-600' : 'text-red-600' ?> font-medium">
                                        <?php if ($remplie): ?>
                                        <i class="fas fa-check mr-1"></i> Condition remplie
                                        <?php else: ?>
                                        <i class="fas fa-times mr-1"></i> Condition non remplie
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Commentaires -->
                    <?php if (!empty($data['commentaires'])): ?>
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-comment-alt text-green-500 mr-2"></i>
                            Commentaires additionnels
                        </h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-gray-700"><?= nl2br(esc($data['commentaires'])) ?></p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Statut final -->
                    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium text-gray-800">Statut final :</span>
                                    <?php if ($eligibilite['remplies'] === $eligibilite['total']): ?>
                                    Vous êtes éligible à la soutenance. Votre demande a été transmise à l'administration pour validation finale.
                                    <?php else: ?>
                                    Vous n'êtes pas encore éligible à la soutenance. <?= $eligibilite['total'] - $eligibilite['remplies'] ?> condition(s) manquante(s).
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="mt-8 flex justify-end space-x-3">
                        <a href="<?= base_url('eligibilite') ?>"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-arrow-left mr-2"></i> Retour
                        </a>
                        <button onclick="window.print()"
                            class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-print mr-2"></i> Imprimer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation de la barre de progression
        const progressBar = document.querySelector('.progress-bar');
        progressBar.style.width = '0';
        setTimeout(() => {
            progressBar.style.width = progressBar.parentElement.getAttribute('data-progress') + '%';
        }, 100);
    });
    </script>
</body>

</html> 