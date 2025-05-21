<?php
// Connexion à la base de données et récupération des données
 $listeGroupes = $GLOBALS['listeGroupe'];
 $listeTraitements = $GLOBALS['listeTraitements'];
$attributions = $GLOBALS['attributions'] ?? [];

// Fonction pour récupérer les attributions existantes pour un groupe
function getAttributionsForGroupe($groupeId) {
    global $DB;
    $query = "SELECT id_traitement FROM rattacher WHERE id_GU = :id_GU";
    $stmt = $DB->prepare($query);
    $stmt->execute(['id_GU' => $groupeId]);
    
    $attributions = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $attributions[] = $row['id_traitement'];
    }
    
    return $attributions;
}

// Si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_GU = $_POST['id_GU'] ?? null;
    $selectedTraitements = $_POST['traitements'] ?? [];
    
    if ($id_GU) {
        // Supprimer toutes les attributions existantes pour ce groupe
        $deleteQuery = "DELETE FROM rattacher WHERE id_GU = :id_GU";
        $deleteStmt = $DB->prepare($deleteQuery);
        $deleteStmt->execute(['id_GU' => $id_GU]);
        
        // Insérer les nouvelles attributions
        if (!empty($selectedTraitements)) {
            $insertQuery = "INSERT INTO rattacher (id_GU, id_traitement) VALUES (:id_GU, :id_traitement)";
            $insertStmt = $DB->prepare($insertQuery);
            
            foreach ($selectedTraitements as $id_traitement) {
                $insertStmt->execute([
                    'id_GU' => $id_GU,
                    'id_traitement' => $id_traitement
                ]);
            }
        }
        
        $messageSuccess = "Les attributions ont été mises à jour avec succès.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Attributions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    .fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .slide-in {
        animation: slideIn 0.3s ease-in-out;
    }

    @keyframes slideIn {
        from {
            transform: translateY(10px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <header class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        <i class="fas fa-tasks mr-3 text-emerald-600"></i>
                        Gestion des Attributions
                    </h1>
                    <p class="text-gray-600 mt-2">Attribuez des traitements aux groupes d'utilisateurs</p>
                </div>
                <div class="hidden md:block">
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Rechercher un groupe ou traitement..."
                            class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-80">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
            </div>
        </header>

        <?php if (isset($messageSuccess)): ?>
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-lg shadow mb-6"
            role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-emerald-500 mr-3 text-lg"></i>
                <span><?php echo $messageSuccess; ?></span>
            </div>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Liste des groupes -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 p-4">
                    <h3 class="text-lg font-semibold text-white">
                        <i class="fas fa-users mr-2"></i>
                        Groupes d'utilisateurs
                    </h3>
                    <p class="text-emerald-100 text-sm mt-1">Sélectionnez un groupe pour gérer ses traitements</p>
                </div>

                <div class="p-4">
                    <div class="relative mb-4 md:hidden">
                        <input type="text" id="mobileSearchGroupe" placeholder="Rechercher un groupe..."
                            class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 w-full">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>

                    <div class="space-y-2 max-h-96 overflow-y-auto" id="groupesList">
                        <?php foreach ($listeGroupes as $groupe): ?>
                        <button
                            onclick="selectGroupe(<?php echo $groupe->id_GU; ?>, '<?php echo htmlspecialchars($groupe->lib_GU); ?>')"
                            class="w-full text-left px-4 py-3 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-opacity-50 transition-all duration-200 groupe-btn group"
                            data-groupe-id="<?php echo $groupe->id_GU; ?>"
                            data-groupe-name="<?php echo htmlspecialchars($groupe->lib_GU); ?>">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3 group-hover:bg-emerald-200 transition-colors">
                                        <i class="fas fa-user-group"></i>
                                    </div>
                                    <span
                                        class="font-medium text-gray-700"><?php echo htmlspecialchars($groupe->lib_GU); ?></span>
                                </div>
                                <div class="flex items-center">
                                    <i
                                        class="fas fa-chevron-right ml-2 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                                </div>
                            </div>
                        </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Détails du groupe et attributions -->
            <div class="lg:col-span-2">
                <div id="attributionContainer"
                    class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 h-full">
                    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 p-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-white">
                                <i class="fas fa-cogs mr-2"></i>
                                Gestion des traitements
                            </h3>
                            <span id="attributionCounter"
                                class="bg-white text-emerald-700 text-sm px-3 py-1 rounded-full font-medium">
                                0 traitements attribués
                            </span>
                        </div>
                        <p class="text-emerald-100 text-sm mt-1">Attribuez des traitements au groupe sélectionné</p>
                    </div>

                    <div id="noSelectionMessage" class="p-16 text-center">
                        <div class="mb-6 text-gray-300">
                            <i class="fas fa-hand-pointer text-6xl"></i>
                        </div>
                        <h3 class="text-xl font-medium text-gray-600 mb-2">Aucun groupe sélectionné</h3>
                        <p class="text-gray-500">Veuillez sélectionner un groupe d'utilisateurs dans la liste</p>
                    </div>

                    <div id="attributionContent" class="hidden p-6">
                        <div class="mb-6">
                            <div class="flex items-center mb-4">
                                <div
                                    class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center mr-3">
                                    <i class="fas fa-user-group"></i>
                                </div>
                                <div>
                                    <h4 id="selectedGroupeName" class="text-xl font-semibold text-gray-800"></h4>
                                    <p class="text-gray-500 text-sm">Sélectionnez les traitements à attribuer</p>
                                </div>
                            </div>

                            <div class="mb-4 relative">
                                <input type="text" id="searchTraitements" placeholder="Filtrer les traitements..."
                                    class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 w-full">
                                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                            </div>
                        </div>

                        <form id="attributionForm" method="POST" class="space-y-2">
                            <input type="hidden" name="id_GU" id="selectedGroupeId">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="traitementsContainer">
                                <?php foreach ($listeTraitements as $traitement): ?>
                                <div class="traitement-item border border-gray-200 rounded-lg p-4 hover:shadow-sm transition-shadow"
                                    data-traitement-id="<?php echo $traitement->id_traitement; ?>"
                                    data-traitement-name="<?php echo htmlspecialchars($traitement->label_traitement); ?>">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="relative">
                                                <input type="checkbox"
                                                    id="traitement_<?php echo $traitement->id_traitement; ?>"
                                                    name="traitements[]"
                                                    value="<?php echo $traitement->id_traitement; ?>"
                                                    class="traitement-checkbox h-5 w-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500"
                                                    onchange="updateAttributionCounter()">
                                            </div>
                                            <label for="traitement_<?php echo $traitement->id_traitement; ?>"
                                                class="ml-3 text-gray-700 font-medium cursor-pointer">
                                                <?php echo htmlspecialchars($traitement->label_traitement); ?>
                                            </label>
                                        </div>
                                        <div>
                                            <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-600">
                                                ID: <?php echo $traitement->id_traitement; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="flex justify-end space-x-4 mt-6">
                                <button type="button" onclick="resetForm()"
                                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                    <i class="fas fa-undo mr-2"></i>Réinitialiser
                                </button>
                                <button type="submit" id="saveButton"
                                    class="px-4 py-2 bg-emerald-600 text-white rounded-md text-sm font-medium hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                    <i class="fas fa-save mr-2"></i>Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Variables globales
    let currentGroupeId = null;
    let currentGroupeName = null;
    const groupeButtons = document.querySelectorAll('.groupe-btn');
    const traitementItems = document.querySelectorAll('.traitement-item');
    const traitementCheckboxes = document.querySelectorAll('.traitement-checkbox');
    const selectedGroupeId = document.getElementById('selectedGroupeId');
    const selectedGroupeName = document.getElementById('selectedGroupeName');
    const attributionForm = document.getElementById('attributionForm');
    const saveButton = document.getElementById('saveButton');
    const noSelectionMessage = document.getElementById('noSelectionMessage');
    const attributionContent = document.getElementById('attributionContent');
    const attributionCounter = document.getElementById('attributionCounter');
    const searchInput = document.getElementById('searchInput');
    const mobileSearchGroupe = document.getElementById('mobileSearchGroupe');
    const searchTraitements = document.getElementById('searchTraitements');

    // Structure pour stocker les attributions existantes
    const existingAttributions = <?php 
        $attributionsMap = [];
        foreach ($listeGroupes as $groupe) {
            $attributionsMap[$groupe->id_GU] = getAttributionsForGroupe($groupe->id_GU);
        }
        echo json_encode($attributionsMap);
    ?>;

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        // Configuration des filtres de recherche
        setupSearch();

        // Désactiver le bouton d'enregistrement si aucun groupe n'est sélectionné
        saveButton.disabled = true;
        saveButton.classList.add('opacity-50', 'cursor-not-allowed');
    });

    // Configuration des champs de recherche
    function setupSearch() {
        // Recherche globale
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();

            // Filtrer les groupes
            document.querySelectorAll('.groupe-btn').forEach(btn => {
                const groupeName = btn.dataset.groupeName.toLowerCase();
                if (groupeName.includes(searchTerm)) {
                    btn.style.display = 'block';
                } else {
                    btn.style.display = 'none';
                }
            });

            // Filtrer les traitements si un groupe est sélectionné
            if (currentGroupeId) {
                filterTraitements(searchTerm);
            }
        });

        // Recherche mobile pour les groupes
        mobileSearchGroupe.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();

            document.querySelectorAll('.groupe-btn').forEach(btn => {
                const groupeName = btn.dataset.groupeName.toLowerCase();
                if (groupeName.includes(searchTerm)) {
                    btn.style.display = 'block';
                } else {
                    btn.style.display = 'none';
                }
            });
        });

        // Recherche des traitements
        searchTraitements.addEventListener('input', function(e) {
            filterTraitements(e.target.value.toLowerCase());
        });
    }

    // Filtrer les traitements en fonction d'un terme de recherche
    function filterTraitements(searchTerm) {
        document.querySelectorAll('.traitement-item').forEach(item => {
            const traitementName = item.dataset.traitementName.toLowerCase();
            if (traitementName.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Fonction pour sélectionner un groupe
    function selectGroupe(id, name) {
        currentGroupeId = id;
        currentGroupeName = name;
        selectedGroupeId.value = id;
        selectedGroupeName.textContent = name;

        // Activer le bouton d'enregistrement
        saveButton.disabled = false;
        saveButton.classList.remove('opacity-50', 'cursor-not-allowed');

        // Afficher le contenu des attributions
        noSelectionMessage.classList.add('hidden');
        attributionContent.classList.remove('hidden');
        attributionContent.classList.add('fade-in');

        // Mettre à jour l'apparence des boutons
        groupeButtons.forEach(btn => {
            if (btn.dataset.groupeId == id) {
                btn.classList.add('bg-emerald-50', 'border-l-4', 'border-emerald-500');
            } else {
                btn.classList.remove('bg-emerald-50', 'border-l-4', 'border-emerald-500');
            }
        });

        // Récupérer les attributions pour ce groupe
        const groupeAttributions = existingAttributions[id] || [];

        // Mettre à jour les cases à cocher
        let attributionCount = 0;

        traitementCheckboxes.forEach(checkbox => {
            const isChecked = groupeAttributions.includes(checkbox.value);
            checkbox.checked = isChecked;
            if (isChecked) attributionCount++;
        });

        // Mettre à jour le compteur
        updateAttributionCounter();
    }

    // Mettre à jour le compteur d'attributions
    function updateAttributionCounter() {
        const count = document.querySelectorAll('.traitement-checkbox:checked').length;
        attributionCounter.textContent =
            `${count} traitement${count !== 1 ? 's' : ''} attribué${count !== 1 ? 's' : ''}`;
    }

    // Fonction pour réinitialiser le formulaire
    function resetForm() {
        if (currentGroupeId) {
            // Récupérer les attributions originales
            const groupeAttributions = existingAttributions[currentGroupeId] || [];

            // Réinitialiser les cases à cocher
            traitementCheckboxes.forEach(checkbox => {
                checkbox.checked = groupeAttributions.includes(checkbox.value);
            });

            // Mettre à jour le compteur
            updateAttributionCounter();
        }
    }

    // Gérer la soumission du formulaire
    attributionForm.addEventListener('submit', function(e) {
        if (!currentGroupeId) {
            e.preventDefault();
            alert('Veuillez sélectionner un groupe d\'utilisateurs.');
        } else {
            // Ajouter un effet de chargement au bouton lors de la soumission
            saveButton.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i>Enregistrement...';
            saveButton.disabled = true;
        }
    });
    </script>
</body>

</html>