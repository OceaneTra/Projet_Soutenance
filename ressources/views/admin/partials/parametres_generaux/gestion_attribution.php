<?php
require_once __DIR__ . '/../../../../app/models/GroupeUtilisateur.php';
require_once __DIR__ . '/../../../../app/models/Traitement.php';
require_once __DIR__ . '/../../../../app/models/Attribution.php';
require_once __DIR__ . '/../../../../app/config/database.php';

$db = Database::getConnection();
$groupeUtilisateur = new GroupeUtilisateur($db);
$traitement = new Traitement($db);
$attribution = new Attribution($db);

// Récupérer les données
$groupes = $groupeUtilisateur->getAllGroupeUtilisateur();
$traitements = $traitement->getAllTraitements();

// Gérer les actions POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'update_attributions') {
        $id_GU = $_POST['id_GU'];
        $traitements_ids = isset($_POST['traitements']) ? $_POST['traitements'] : [];
        
        // Supprimer toutes les attributions existantes pour ce groupe
        $attribution->deleteAttribution($id_GU);
        
        // Ajouter les nouvelles attributions
        foreach ($traitements_ids as $id_traitement) {
            $attribution->ajouterAttribution($id_GU, $id_traitement);
        }
        
        $messageSuccess = "Les attributions ont été mises à jour avec succès.";
    }
}

// Récupérer les attributions pour chaque groupe
$attributions = [];
foreach ($groupes as $groupe) {
    $attributions[$groupe->id_GU] = $traitement->getTraitementByGU($groupe->id_GU);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Attributions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-600">
                <i class="fas fa-tasks mr-2 text-green-600"></i>
                Gestion des Attributions
            </h2>
        </div>

        <?php if (isset($messageSuccess)): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo $messageSuccess; ?></span>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Liste des groupes -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-600 mb-4">
                    <i class="fas fa-users mr-2 text-green-500"></i>
                    Groupes d'utilisateurs
                </h3>
                <div class="space-y-2">
                    <?php foreach ($groupes as $groupe): ?>
                    <button
                        onclick="selectGroupe(<?php echo $groupe->id_GU; ?>, '<?php echo htmlspecialchars($groupe->lib_GU); ?>')"
                        class="w-full text-left px-4 py-2 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50 transition-all duration-200 groupe-btn"
                        data-groupe-id="<?php echo $groupe->id_GU; ?>">
                        <div class="flex items-center justify-between">
                            <span
                                class="font-medium text-gray-700"><?php echo htmlspecialchars($groupe->lib_GU); ?></span>
                            <span class="text-sm text-gray-500">
                                <?php echo count($attributions[$groupe->id_GU]); ?> traitements
                            </span>
                        </div>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Liste des traitements -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-600 mb-4">
                    <i class="fas fa-cogs mr-2 text-green-500"></i>
                    Traitements disponibles
                </h3>
                <form id="attributionForm" method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="update_attributions">
                    <input type="hidden" name="id_GU" id="selectedGroupeId">

                    <div id="selectedGroupeName" class="text-lg font-medium text-gray-700 mb-4"></div>

                    <div class="space-y-2">
                        <?php foreach ($traitements as $traitement): ?>
                        <div class="flex items-center">
                            <input type="checkbox" name="traitements[]"
                                value="<?php echo $traitement->id_traitement; ?>"
                                class="traitement-checkbox h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-green-500"
                                data-groupe-id="<?php echo $traitement->id_traitement; ?>">
                            <label class="ml-2 text-sm text-gray-700">
                                <?php echo htmlspecialchars($traitement->lib_traitement); ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        <button type="button" onclick="resetForm()"
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-undo mr-2"></i>Réinitialiser
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-save mr-2"></i>Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    // Variables globales
    let currentGroupeId = null;
    const groupeButtons = document.querySelectorAll('.groupe-btn');
    const traitementCheckboxes = document.querySelectorAll('.traitement-checkbox');
    const selectedGroupeId = document.getElementById('selectedGroupeId');
    const selectedGroupeName = document.getElementById('selectedGroupeName');
    const attributionForm = document.getElementById('attributionForm');

    // Fonction pour sélectionner un groupe
    function selectGroupe(id, name) {
        currentGroupeId = id;
        selectedGroupeId.value = id;
        selectedGroupeName.textContent = name;

        // Mettre à jour l'apparence des boutons
        groupeButtons.forEach(btn => {
            if (btn.dataset.groupeId == id) {
                btn.classList.add('bg-green-50', 'border', 'border-green-200');
            } else {
                btn.classList.remove('bg-green-50', 'border', 'border-green-200');
            }
        });

        // Mettre à jour les cases à cocher
        traitementCheckboxes.forEach(checkbox => {
            const isChecked = <?php echo json_encode($attributions); ?>[id]?.some(t => t.id_traitement ==
                checkbox.value);
            checkbox.checked = isChecked;
        });
    }

    // Fonction pour réinitialiser le formulaire
    function resetForm() {
        if (currentGroupeId) {
            selectGroupe(currentGroupeId, selectedGroupeName.textContent);
        }
    }

    // Gérer la soumission du formulaire
    attributionForm.addEventListener('submit', function(e) {
        if (!currentGroupeId) {
            e.preventDefault();
            alert('Veuillez sélectionner un groupe d\'utilisateurs.');
        }
    });
    </script>
</body>

</html>