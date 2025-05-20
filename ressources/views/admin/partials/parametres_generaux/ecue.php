<?php
require_once __DIR__ . '/../../../../app/models/Ecue.php';
require_once __DIR__ . '/../../../../app/models/Ue.php';
require_once __DIR__ . '/../../../../app/config/database.php';

$db = Database::getConnection();
$ecue = new Ecue($db);
$ue = new Ue($db);

// Récupérer les données
$ecues = $ecue->getAllEcues();
$ues = $ue->getAllUes();

// Gérer les actions POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $id_ue = $_POST['id_ue'];
                $lib_ecue = $_POST['lib_ecue'];
                $credit = $_POST['credit'];
                
                if ($ecue->ajouterEcue($id_ue, $lib_ecue, $credit)) {
                    $messageSuccess = "ECUE ajouté avec succès.";
                } else {
                    $messageError = "Erreur lors de l'ajout de l'ECUE.";
                }
                break;
                
            case 'update':
                $id_ecue = $_POST['id_ecue'];
                $id_ue = $_POST['id_ue'];
                $lib_ecue = $_POST['lib_ecue'];
                $credit = $_POST['credit'];
                
                if ($ecue->updateEcue($id_ecue, $id_ue, $lib_ecue, $credit)) {
                    $messageSuccess = "ECUE modifié avec succès.";
                } else {
                    $messageError = "Erreur lors de la modification de l'ECUE.";
                }
                break;
                
            case 'delete':
                $id_ecue = $_POST['id_ecue'];
                if ($ecue->deleteEcue($id_ecue)) {
                    $messageSuccess = "ECUE supprimé avec succès.";
                } else {
                    $messageError = "Erreur lors de la suppression de l'ECUE.";
                }
                break;
        }
    }
}

// Récupérer l'ECUE à modifier si présent
$ecue_a_modifier = null;
if (isset($_GET['id_ecue'])) {
    $ecue_a_modifier = $ecue->getEcueById($_GET['id_ecue']);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des ECUE</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-600">
                <i class="fas fa-book mr-2 text-green-600"></i>
                Gestion des ECUE
            </h2>
        </div>

        <?php if (isset($messageSuccess)): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo $messageSuccess; ?></span>
        </div>
        <?php endif; ?>

        <?php if (isset($messageError)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo $messageError; ?></span>
        </div>
        <?php endif; ?>

        <!-- Formulaire d'ajout/modification -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-600 mb-4">
                <i
                    class="fas <?= $ecue_a_modifier ? 'fa-edit text-green-500' : 'fa-plus-circle text-green-500' ?> mr-2"></i>
                <?= $ecue_a_modifier ? 'Modifier l\'ECUE' : 'Ajouter un nouvel ECUE' ?>
            </h3>

            <form method="POST" action="" id="ecueForm" class="space-y-4">
                <input type="hidden" name="action" value="<?= $ecue_a_modifier ? 'update' : 'add' ?>">
                <?php if ($ecue_a_modifier): ?>
                <input type="hidden" name="id_ecue" value="<?= htmlspecialchars($ecue_a_modifier->id_ecue) ?>">
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="id_ue" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-graduation-cap text-green-500 mr-2"></i>Unité d'Enseignement
                        </label>
                        <select name="id_ue" id="id_ue" required
                            class="form-select w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white transition-all duration-200">
                            <option value="">Sélectionnez une UE</option>
                            <?php foreach ($ues as $ue): ?>
                            <option value="<?= htmlspecialchars($ue->id_ue) ?>"
                                <?= ($ecue_a_modifier && $ecue_a_modifier->id_ue == $ue->id_ue) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($ue->lib_ue) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="lib_ecue" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-book text-green-500 mr-2"></i>Libellé de l'ECUE
                        </label>
                        <input type="text" name="lib_ecue" id="lib_ecue" required
                            value="<?= $ecue_a_modifier ? htmlspecialchars($ecue_a_modifier->lib_ecue) : '' ?>"
                            class="form-input w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                    </div>

                    <div class="space-y-2">
                        <label for="credit" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-star text-green-500 mr-2"></i>Crédits
                        </label>
                        <input type="number" name="credit" id="credit" required min="1" max="30"
                            value="<?= $ecue_a_modifier ? htmlspecialchars($ecue_a_modifier->credit) : '' ?>"
                            class="form-input w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-6">
                    <?php if ($ecue_a_modifier): ?>
                    <a href="?page=parametres_generaux&action=ecue"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </a>
                    <?php endif; ?>
                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas <?= $ecue_a_modifier ? 'fa-save' : 'fa-plus' ?> mr-2"></i>
                        <?= $ecue_a_modifier ? 'Modifier' : 'Ajouter' ?>
                    </button>
                </div>
            </form>
        </div>

        <!-- Liste des ECUE -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-600 mb-4">
                    <i class="fas fa-list-ul text-green-500 mr-2"></i>
                    Liste des ECUE
                </h3>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    UE
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Libellé
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Crédits
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (!empty($ecues)): ?>
                            <?php foreach ($ecues as $ecue): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?= htmlspecialchars($ecue->lib_ue) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?= htmlspecialchars($ecue->lib_ecue) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?= htmlspecialchars($ecue->credit) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <a href="?page=parametres_generaux&action=ecue&id_ecue=<?= htmlspecialchars($ecue->id_ecue) ?>"
                                        class="text-green-600 hover:text-green-900 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button onclick="deleteEcue(<?= htmlspecialchars($ecue->id_ecue) ?>)"
                                        class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                    Aucun ECUE enregistré
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-sm w-full mx-4">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-trash-alt text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Confirmation de suppression</h3>
                <p class="text-sm text-gray-500 mb-6">
                    Êtes-vous sûr de vouloir supprimer cet ECUE ? Cette action est irréversible.
                </p>
                <div class="flex justify-center gap-4">
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200">
                        <i class="fas fa-times mr-2"></i>Annuler
                    </button>
                    <button type="button" id="confirmDelete"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200">
                        <i class="fas fa-trash-alt mr-2"></i>Supprimer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Variables pour le modal de suppression
    const deleteModal = document.getElementById('deleteModal');
    let ecueToDelete = null;

    // Fonction pour ouvrir le modal de suppression
    function deleteEcue(id) {
        ecueToDelete = id;
        deleteModal.classList.remove('hidden');
    }

    // Fonction pour fermer le modal de suppression
    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        ecueToDelete = null;
    }

    // Gérer la confirmation de suppression
    document.getElementById('confirmDelete').addEventListener('click', function() {
        if (ecueToDelete) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.innerHTML = `
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id_ecue" value="${ecueToDelete}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    });

    // Fermer le modal si on clique en dehors
    deleteModal.addEventListener('click', function(e) {
        if (e.target === deleteModal) {
            closeDeleteModal();
        }
    });
    </script>
</body>

</html>