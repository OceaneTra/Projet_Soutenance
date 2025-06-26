<?php
// Vérifier si l'étudiant a une candidature validée
$candidature_validee = false;
$message_candidature = '';

if (isset($_SESSION['num_etu'])) {
    // Récupérer le statut de candidature de l'étudiant
    $candidatures_etudiant = isset($GLOBALS['candidatures_etudiant']) ? $GLOBALS['candidatures_etudiant'] : [];
    
    foreach ($candidatures_etudiant as $candidature) {
        if ($candidature['statut_candidature'] === 'Validée') {
            $candidature_validee = true;
            break;
        }
    }
    
    if (!$candidature_validee) {
        $message_candidature = "Vous devez avoir une candidature validée pour accéder aux fonctionnalités de gestion des rapports.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des rapports</title>

</head>

<body class="min-h-screen">

    <?php if (isset($_GET['message'])): ?>
    <?php if ($_GET['message'] === 'depot_ok'): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 text-center">
        <strong class="font-bold">Succès !</strong> Le rapport a bien été déposé.
    </div>
    <?php elseif ($_GET['message'] === 'depot_fail'): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 text-center">
        <strong class="font-bold">Erreur !</strong> Impossible de déposer le rapport (déjà déposé ou erreur technique).
    </div>
    <?php endif; ?>
    <?php endif; ?>

    <section class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
        <!-- Carte 1: Créer un rapport -->
        <div class="card rounded-xl overflow-hidden shadow-lg text-white cursor-pointer">
            <div class="p-6 flex flex-col items-center card-gradient-1">
                <div class="icon-container card-gradient-1 bg-opacity-20 p-5 rounded-full mb-6">
                    <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Créer un Rapport</h3>
                <p class="text-white text-opacity-80 mb-6 text-center">Rédigez et soumettez votre rapport de
                    master directement via notre plateforme sécurisée.</p>
                <div class="mt-auto">
                    <?php if ($candidature_validee): ?>
                    <button
                        class="bg-white text-indigo-700 font-semibold py-2 px-6 rounded-lg hover:bg-opacity-90 transition duration-300 pulse">
                        <a href="?page=gestion_rapports&action=creer_rapport">Commencer</a>
                    </button>
                    <?php else: ?>
                    <button onclick="showCandidatureRequiredMessage()"
                        class="bg-gray-300 text-gray-500 font-semibold py-2 px-6 rounded-lg cursor-not-allowed transition duration-300"
                        disabled>
                        Commencer
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="bg-gradient-to-r from-white to-transparent bg-opacity-10 h-1"></div>
            <div class="px-6 py-4 bg-indigo-500 bg-opacity-10">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-white text-opacity-70">Facile à utiliser</span>
                    <span class="text-xs font-medium bg-indigo-800 px-2 py-1 rounded-full">Étape 1</span>
                </div>
            </div>
        </div>

        <!-- Carte 2: Suivre l'avancée -->
        <div class="card rounded-xl overflow-hidden shadow-lg text-white cursor-pointer">
            <div class="p-6 flex flex-col items-center card-gradient-2">
                <div class="icon-container card-gradient-2 bg-opacity-20 p-5 rounded-full mb-6">
                    <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Suivre l'Avancée</h3>
                <p class="text-white text-opacity-80 mb-6 text-center">Surveillez l'état de votre soumission en
                    temps réel à chaque étape du processus de validation.</p>
                <div class="mt-auto">
                    <?php if ($candidature_validee): ?>
                    <button
                        class="bg-white text-green-700 font-semibold py-2 px-6 rounded-lg hover:bg-opacity-90 transition duration-300 floating">
                        <a href="?page=gestion_rapports&action=suivi_rapport">Consulter</a>
                    </button>
                    <?php else: ?>
                    <button onclick="showCandidatureRequiredMessage()"
                        class="bg-gray-300 text-gray-500 font-semibold py-2 px-6 rounded-lg cursor-not-allowed transition duration-300"
                        disabled>
                        Consulter
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="bg-gradient-to-r from-white to-transparent bg-opacity-10 h-1"></div>
            <div class="px-6 py-4 bg-green-500 bg-opacity-10">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-white text-opacity-70">En temps réel</span>
                    <span class="text-xs font-medium bg-green-800 px-2 py-1 rounded-full">Étape 2</span>
                </div>
            </div>
        </div>

        <!-- Carte 3: Consulter les commentaires -->
        <div class="card rounded-xl overflow-hidden shadow-lg text-white cursor-pointer">
            <div class="p-6 flex flex-col items-center card-gradient-3">
                <div class="icon-container card-gradient-3 bg-opacity-20 p-5 rounded-full mb-6">
                    <svg class="h-10 w-10" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">Consulter les commentaires</h3>
                <p class="text-white text-opacity-80 mb-6 text-center">Accédez aux retours détaillés des
                    évaluateurs pour améliorer votre travail académique.</p>
                <div class="mt-auto">
                    <?php if ($candidature_validee): ?>
                    <button
                        class="bg-white text-yellow-700 font-semibold py-2 px-6 rounded-lg hover:bg-opacity-90 transition duration-300 pulse">
                        <a href="?page=gestion_rapports&action=commentaire_rapport"> Voir les retours</a>
                    </button>
                    <?php else: ?>
                    <button onclick="showCandidatureRequiredMessage()"
                        class="bg-gray-300 text-gray-500 font-semibold py-2 px-6 rounded-lg cursor-not-allowed transition duration-300"
                        disabled>
                        Voir les retours
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="bg-gradient-to-r from-white to-transparent bg-opacity-10 h-1"></div>
            <div class="px-6 py-4 bg-yellow-500 bg-opacity-10">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-white text-opacity-70">Retours d'experts</span>
                    <span class="text-xs font-medium bg-yellow-800 px-2 py-1 rounded-full">Étape 3</span>
                </div>
            </div>
        </div>
    </section>

    <section class="mt-16 max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-2xl font-bold text-gray-800">Mes Rapports</h3>
                    <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                        <?= isset($statistiquesRapports) ? ($statistiquesRapports->total_rapports ?? 0) : 0 ?>
                        rapport(s)
                    </span>
                </div>
            </div>

            <div class="p-6">
                <?php if (isset($rapportsRecents) && !empty($rapportsRecents)): ?>
                <div class="space-y-4">
                    <?php foreach ($rapportsRecents as $rapport): ?>
                    <div id="rapport-<?= $rapport->id_rapport ?>"
                        class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="text-lg font-semibold text-gray-800 mb-2">
                                    <?= htmlspecialchars($rapport->nom_rapport) ?>
                                </h4>
                                <p class="text-gray-600 mb-2">
                                    <strong>Thème:</strong> <?= htmlspecialchars($rapport->theme_rapport) ?>
                                </p>
                                <p class="text-sm text-gray-500">
                                    Créé le <?= date('d/m/Y à H:i', strtotime($rapport->date_rapport)) ?>
                                </p>
                            </div>
                            <div class="flex space-x-2 ml-4">
                                <form method="POST" action="?page=gestion_rapports" style="display:inline;"
                                    id="deposerForm-<?= $rapport->id_rapport ?>">
                                    <input type="hidden" name="id_rapport" value="<?= $rapport->id_rapport ?>">
                                    <input type="hidden" name="action" value="deposer_rapport">
                                    <button type="submit"
                                        class="bg-blue-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-sm transition-colors">
                                        <i class="fas fa-upload mr-1"></i> Déposer
                                    </button>
                                </form>
                                <button onclick="modifierRapport(<?= $rapport->id_rapport ?>)"
                                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm transition-colors">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </button>
                                <button
                                    onclick="supprimerRapport(<?= $rapport->id_rapport ?>, '<?= htmlspecialchars($rapport->nom_rapport) ?>')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition-colors">
                                    <i class="fas fa-trash mr-1"></i> Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php if (count($rapportsRecents) >= 5): ?>
                <div class="mt-6 text-center">
                    <a href="?page=gestion_rapports&action=suivi_rapport"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg inline-flex items-center">
                        <i class="fas fa-list mr-2"></i> Voir tous mes rapports
                    </a>
                </div>
                <?php endif; ?>
                <?php else: ?>
                <div class="text-center py-8">
                    <i class="fas fa-file-alt text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 text-lg mb-4">Aucun rapport créé pour le moment</p>
                    <?php if ($candidature_validee): ?>
                    <a href="?page=gestion_rapports&action=creer_rapport"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i> Créer mon premier rapport
                    </a>
                    <?php else: ?>
                    <button onclick="showCandidatureRequiredMessage()"
                        class="bg-gray-400 text-gray-600 px-6 py-2 rounded-lg inline-flex items-center cursor-not-allowed"
                        disabled>
                        <i class="fas fa-plus mr-2"></i> Créer mon premier rapport
                    </button>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <section class="mt-16 max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Processus de validation</h3>
            <div class="flex flex-wrap">
                <div class="w-full md:w-1/2">
                    <ol class="relative border-l border-gray-200 ml-3">
                        <li class="mb-10 ml-6">
                            <span
                                class="absolute flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full -left-4 ring-4 ring-white">
                                <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </span>
                            <h3 class="font-medium text-gray-900">Dépôt du rapport</h3>
                            <p class="text-sm text-gray-500">L'étudiant rédige et soumet son rapport dans
                                l'application</p>
                        </li>
                        <li class="mb-10 ml-6">
                            <span
                                class="absolute flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full -left-4 ring-4 ring-white">
                                <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </span>
                            <h3 class="font-medium text-gray-900">Vérification initiale</h3>
                            <p class="text-sm text-gray-500">vérification de son admissibilité et respect des normes
                                formelles</p>
                        </li>
                        <li class="ml-6">
                            <span
                                class="absolute flex items-center justify-center w-8 h-8 bg-blue-100 rounded-full -left-4 ring-4 ring-white">
                                <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <h3 class="font-medium text-gray-900">Validation par la commission</h3>
                            <p class="text-sm text-gray-500">Examen par le jury et autorisation de soutenance
                            </p>
                        </li>
                    </ol>
                </div>

            </div>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', () => {


        // Animation au survol des boutons
        const buttons = document.querySelectorAll('button');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', () => {
                gsap.to(button, {
                    scale: 1.05,
                    duration: 0.3
                });
            });

            button.addEventListener('mouseleave', () => {
                gsap.to(button, {
                    scale: 1,
                    duration: 0.3
                });
            });
        });

        // Simulation de clic sur les cartes
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('click', function() {
                const title = this.querySelector('h3').textContent;
                const button = this.querySelector('button');

                // Animation de clic
                gsap.to(this, {
                    scale: 0.95,
                    duration: 0.1,
                    onComplete: () => {
                        gsap.to(this, {
                            scale: 1,
                            duration: 0.3
                        });

                        // Simulation de navigation ou d'ouverture de modal
                        alert(
                            `Section "${title}" - Cette fonctionnalité sera bientôt disponible`
                        );
                    }
                });
            });
        });
    });

    function voirRapport(rapportId) {
        window.location.href = `?page=gestion_rapports&action=compte_rendu_rapport&id=${rapportId}`;
    }

    function modifierRapport(rapportId) {
        window.location.href = `?page=gestion_rapports&action=creer_rapport&edit=${rapportId}`;
    }

    function supprimerRapport(rapportId, nomRapport) {
        if (!confirm(
                `Êtes-vous sûr de vouloir supprimer le rapport "${nomRapport}" ?\n\nCette action est irréversible.`)) {
            return;
        }

        // Afficher un indicateur de chargement
        const loadingDiv = document.createElement('div');
        loadingDiv.innerHTML = `
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg">
                <div class="flex items-center">
                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600 mr-3"></div>
                    <span>Suppression en cours...</span>
                </div>
            </div>
        </div>
    `;
        document.body.appendChild(loadingDiv);

        // Envoyer la requête de suppression
        const formData = new FormData();
        formData.append('rapport_id', rapportId);

        fetch('?page=gestion_rapports&action=delete_rapport', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    // Si le statut HTTP n'est pas OK (e.g. 500 Internal Server Error)
                    // On lit la réponse comme du texte et on la lance comme une erreur
                    return response.text().then(text => {
                        throw new Error(text || 'Réponse invalide du serveur')
                    });
                }
                return response.json(); // On tente de parser le JSON si la réponse est OK
            })
            .then(data => {
                document.body.removeChild(loadingDiv);

                if (data.success) {
                    // Supprimer visuellement le rapport de la liste
                    const rapportElement = document.getElementById('rapport-' + rapportId);
                    if (rapportElement) {
                        rapportElement.remove();
                    }

                    // Afficher un message de succès
                    showNotification('success', data.message);
                } else {
                    showNotification('error', data.message || 'Erreur lors de la suppression');
                }
            })
            .catch(error => {
                document.body.removeChild(loadingDiv);
                console.error('Erreur brut:', error);
                showNotification('error', 'Erreur inattendue: ' + error.message);
            });
    }

    function showNotification(type, message) {
        const notification = document.createElement('div');
        notification.className =
            `fixed top-4 right-4 max-w-md bg-white shadow-lg rounded-lg pointer-events-auto overflow-hidden transform transition-all duration-300 z-50`;

        let iconColor = type === 'success' ? 'text-green-500' : 'text-red-500';
        let bgColor = type === 'success' ? 'bg-green-50' : 'bg-red-50';
        let icon = type === 'success' ? 'check' : 'times';

        notification.innerHTML = `
    <div class="${bgColor} p-4 flex">
        <div class="flex-shrink-0">
            <i class="fas fa-${icon} ${iconColor}"></i>
        </div>
        <div class="ml-3 w-0 flex-1">
            <p class="text-sm font-medium text-gray-900">${message}</p>
        </div>
        <div class="ml-4 flex-shrink-0 flex">
            <button onclick="this.parentElement.parentElement.parentElement.remove()"
                    class="inline-flex text-gray-400 hover:text-gray-500 focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
`;

        document.body.appendChild(notification);

        // Supprimer automatiquement après 3 secondes
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 3000);
    }

    function showCandidatureRequiredMessage() {
        showNotification('error', 'Vous devez avoir une candidature validée pour accéder à cette fonctionnalité.');
    }
    </script>
</body>

</html>