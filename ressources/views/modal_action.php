<?php
// Récupération des données (à adapter selon votre structure)
$actions = []; // Dans une implémentation réelle, vous récupéreriez les données depuis votre modèle

// Simulation de données pour l'exemple
$actions = [
    ['id' => 1, 'nom' => 'Création', 'description' => 'Création d\'un élément'],
    ['id' => 2, 'nom' => 'Modification', 'description' => 'Modification d\'un élément'],
    ['id' => 3, 'nom' => 'Suppression', 'description' => 'Suppression d\'un élément']
];
?>

<div class="overflow-x-auto">
    <table class="min-w-full bg-white">
        <thead>
        <tr>
            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nom</th>
            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Description</th>
            <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($actions as $action) : ?>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200"><?= $action['id'] ?></td>
                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200"><?= htmlspecialchars($action['nom']) ?></td>
                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200"><?= htmlspecialchars($action['description']) ?></td>
                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                    <a href="?section=Gparam&action=edit&type=action&id=<?= $action['id'] ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded mr-2">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a href="?section=Gparam&action=delete&type=action&id=<?= $action['id'] ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?');">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="mt-4 flex justify-between">
    <a href="?section=Gparam&action=add&type=action" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-plus mr-2"></i>Ajouter
    </a>
    <a href="/parametres/actions" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Vue complète
    </a>
    <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded closeModal">
        Fermer
    </button>
</div>