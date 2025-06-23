<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Rapport</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Bouton retour -->
        <div class="mb-6">
            <a href="?page=gestion_rapports&action=compte_rendu_rapport" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour à la liste
            </a>
        </div>

        <?php if (isset($rapport) && $rapport): ?>
            <!-- En-tête du rapport -->
            <div class="bg-white rounded-lg shadow-md mb-6">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                                <?= htmlspecialchars($rapport['nom_rapport']) ?>
                            </h1>
                            <p class="text-lg text-gray-600 mb-4">
                                <?= htmlspecialchars($rapport['theme_rapport']) ?>
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <?= ucfirst(str_replace('_', ' ', $rapport['statut_rapport'] ?? 'en_cours')) ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                        <div>
                            <strong>Date de création :</strong> 
                            <?= date('d/m/Y à H:i', strtotime($rapport['date_rapport'])) ?>
                        </div>
                        <?php if (isset($rapport['nom_etu']) && isset($rapport['prenom_etu'])): ?>
                            <div>
                                <strong>Étudiant :</strong> 
                                <?= htmlspecialchars($rapport['prenom_etu'] . ' ' . $rapport['nom_etu']) ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($rapport['email_etu'])): ?>
                            <div>
                                <strong>Email :</strong> 
                                <?= htmlspecialchars($rapport['email_etu']) ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($rapport['version'])): ?>
                            <div>
                                <strong>Version :</strong> 
                                <?= htmlspecialchars($rapport['version']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Contenu du rapport -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">
                        <i class="fas fa-file-alt mr-2 text-blue-500"></i>
                        Contenu du rapport
                    </h2>
                </div>
                
                <div class="p-6">
                    <?php if (!empty($contenuRapport)): ?>
                        <div class="prose max-w-none">
                            <?= $contenuRapport ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-file-alt text-4xl mb-4"></i>
                            <p class="text-lg">Aucun contenu disponible pour ce rapport</p>
                            <p class="text-sm">Le contenu du rapport n'a pas été trouvé ou n'a pas encore été sauvegardé.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-between items-center">
                <div class="flex space-x-4">
                    <?php if (isset($_SESSION['type_utilisateur']) && $_SESSION['type_utilisateur'] === 'Etudiant'): ?>
                        <a href="?page=gestion_rapports&action=creer_rapport&edit=<?= $rapport['id_rapport'] ?>" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-edit mr-2"></i>
                            Modifier
                        </a>
                    <?php endif; ?>
                    
                    <button onclick="window.print()" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-print mr-2"></i>
                        Imprimer
                    </button>
                </div>
                
                <div class="text-sm text-gray-500">
                    ID: <?= $rapport['id_rapport'] ?>
                </div>
            </div>

        <?php else: ?>
            <!-- Message d'erreur -->
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <i class="fas fa-exclamation-triangle text-4xl text-red-500 mb-4"></i>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Rapport non trouvé</h2>
                <p class="text-gray-600 mb-4">Le rapport demandé n'existe pas ou vous n'avez pas les droits pour y accéder.</p>
                <a href="?page=gestion_rapports&action=compte_rendu_rapport" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Retour à la liste
                </a>
            </div>
        <?php endif; ?>
    </div>

    <style>
        @media print {
            .container { max-width: none; }
            .bg-gray-50 { background: white; }
            .shadow-md { box-shadow: none; }
            .rounded-lg { border-radius: 0; }
            .mb-6, .mt-6 { margin: 0; }
            .p-6 { padding: 0; }
        }
    </style>
</body>

</html> 