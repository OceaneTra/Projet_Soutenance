<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réclamation soumise avec succès</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- En-tête de succès -->
            <div class="bg-green-600 px-6 py-4 text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                    <i class="fas fa-check text-green-600 text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-white">
                    Réclamation soumise avec succès !
                </h1>
            </div>

            <!-- Contenu -->
            <div class="p-8 text-center">
                <!-- Numéro de référence -->
                <div class="mb-6">
                    <p class="text-gray-600 mb-2">Votre réclamation a bien été enregistrée sous le numéro :</p>
                    <div class="bg-gray-100 rounded-lg p-4 inline-block">
                        <span class="text-2xl font-bold text-green-600 font-mono">
                            <?php echo htmlspecialchars($numeroReclamation); ?>
                        </span>
                    </div>
                </div>

                <!-- Informations importantes -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6 text-left">
                    <h3 class="font-semibold text-blue-800 mb-3 flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informations importantes
                    </h3>
                    <ul class="text-sm text-blue-700 space-y-2">
                        <li>• Votre réclamation sera traitée dans les <strong>5 jours ouvrés</strong></li>
                        <li>• Vous recevrez une notification à chaque étape du traitement</li>
                        <li>• Conservez ce numéro de référence pour le suivi</li>
                        <li>• Vous pouvez suivre l'évolution de votre réclamation en temps réel</li>
                    </ul>
                </div>

                <!-- Prochaines étapes -->
                <div class="mb-8">
                    <h3 class="font-semibold text-gray-800 mb-4">Que se passe-t-il maintenant ?</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div
                                class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <span class="text-yellow-600 font-bold">1</span>
                            </div>
                            <h4 class="font-medium text-gray-800 mb-1">Réception</h4>
                            <p class="text-gray-600">Votre réclamation est en attente de traitement</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <span class="text-blue-600 font-bold">2</span>
                            </div>
                            <h4 class="font-medium text-gray-800 mb-1">Traitement</h4>
                            <p class="text-gray-600">Analyse et traitement de votre demande</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div
                                class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-2">
                                <span class="text-green-600 font-bold">3</span>
                            </div>
                            <h4 class="font-medium text-gray-800 mb-1">Résolution</h4>
                            <p class="text-gray-600">Réponse et clôture de votre réclamation</p>
                        </div>
                    </div>
                </div>

                <!-- Actions disponibles -->
                <div class="space-y-3">
                    <a href="?page=gestion_reclamations&action=suivi_reclamation"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>
                        Suivre ma réclamation
                    </a>

                    <div class="flex space-x-3">
                        <a href="?page=gestion_reclamations&action=soumettre_reclamation"
                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors text-center">
                            <i class="fas fa-plus mr-2"></i>
                            Nouvelle réclamation
                        </a>

                        <a href="?page=gestion_reclamations"
                            class="flex-1 bg-green-100 hover:bg-green-200 text-green-700 px-4 py-2 rounded-lg font-medium transition-colors text-center">
                            <i class="fas fa-home mr-2"></i>
                            Retour au dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact d'urgence -->
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
            <h4 class="font-medium text-yellow-800 mb-2">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Problème urgent ?
            </h4>
            <p class="text-sm text-yellow-700">
                Si votre réclamation nécessite une attention immédiate,
                contactez directement le secrétariat au
                <strong>+225 XX XX XX XX</strong>
            </p>
        </div>
    </div>

    <!-- Auto-redirection après 10 secondes (optionnel) -->
    <script>
    // Optionnel : redirection automatique après 10 secondes
    let countdown = 10;
    const redirectInfo = document.createElement('div');
    redirectInfo.className = 'fixed bottom-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-lg text-sm';
    redirectInfo.style.display = 'none';
    document.body.appendChild(redirectInfo);

    // Décommenter pour activer la redirection automatique
    /*
    const timer = setInterval(() => {
        countdown--;
        redirectInfo.textContent = `Redirection dans ${countdown}s...`;
        redirectInfo.style.display = 'block';

        if (countdown <= 0) {
            clearInterval(timer);
            window.location.href = '?page=gestion_reclamations';
        }
    }, 1000);
    */
    </script>
</body>

</html>