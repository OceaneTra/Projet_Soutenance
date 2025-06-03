<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sauvegarde et restauration</title>
</head>

<body>

    <div class="container mx-auto px-4 py-8">

        <!-- Create Backup Section -->
        <div class="bg-white shadow-sm rounded-lg p-6 md:p-8 mb-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Créer une Nouvelle Sauvegarde</h2>
            <p class="text-gray-600 mb-6">
                Créez une sauvegarde manuelle de la base de données. Il est recommandé de le faire avant toute
                modification majeure du système.
            </p>
            <form id="createBackupForm">
                <div class="mb-4">
                    <label for="backup_name" class="block text-sm font-medium text-gray-700 mb-3">Nom de la sauvegarde
                        (optionnel)</label>
                    <input type="text" name="backup_name" id="backup_name" placeholder="Ex: avant_mise_a_jour_v2"
                        class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                </div>
                <button type="submit"
                    class="px-6 py-2 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    <i class="fas fa-database mr-2"></i>Lancer la Sauvegarde Manuelle
                </button>
            </form>
        </div>

        <!-- Existing Backups Section -->
        <div class="bg-white shadow-sm rounded-lg overflow-hidden mb-6">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-semibold text-gray-700">Sauvegardes Existantes</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nom du Fichier</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Taille</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date de Création</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type</th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($backups)): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">Aucune sauvegarde disponible.
                            </td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($backups as $backup): ?>
                        <tr>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 hover:text-blue-800 font-medium">
                                <i
                                    class="fas fa-file-archive mr-2"></i><?php echo htmlspecialchars($backup['filename']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <?php echo htmlspecialchars($backup['size']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <?php echo htmlspecialchars($backup['created_at']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $backup['type'] === 'Automatique' ? 'bg-purple-100 text-purple-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                    <?php echo htmlspecialchars($backup['type']); ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <button onclick="restoreBackup('<?php echo htmlspecialchars($backup['filename']); ?>')"
                                    class="text-green-600 hover:text-green-900 mr-3" title="Restaurer">
                                    <i class="fas fa-undo-alt"></i> Restaurer
                                </button>
                                <a href="#" download="<?php echo htmlspecialchars($backup['filename']); ?>"
                                    class="text-blue-600 hover:text-blue-900 mr-3" title="Télécharger">
                                    <i class="fas fa-download"></i>
                                </a>
                                <button onclick="deleteBackup('<?php echo htmlspecialchars($backup['filename']); ?>')"
                                    class="text-red-600 hover:text-red-900" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Restore from Upload Section (Optional) -->
        <div class="bg-white shadow-sm rounded-lg p-6 md:p-8 mt-8">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Restaurer à partir d'un Fichier</h2>
            <p class="text-gray-600 mb-6">
                Si vous avez un fichier de sauvegarde local, vous pouvez le téléverser ici pour restaurer la base de
                données.
                <strong class="text-red-600">Attention: Cette action écrasera les données actuelles.</strong>
            </p>
            <form id="uploadRestoreForm" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="backup_file_upload" class="block text-sm font-medium text-gray-700 mb-3">Fichier de
                        sauvegarde (.sql, .sql.gz)</label>
                    <input type="file" name="backup_file_upload" id="backup_file_upload" required class="w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-lg file:border-0
                    file:text-sm file:font-semibold
                    file:bg-green-50 file:text-green-700
                    hover:file:bg-green-100
                " />
                </div>
                <button type="submit"
                    class="px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    <i class="fas fa-upload mr-2"></i>Téléverser et Restaurer
                </button>
            </form>
        </div>
    </div>

    <script>
    document.getElementById('createBackupForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const backupName = document.getElementById('backup_name').value;
        alert('Lancement de la sauvegarde manuelle simulée' + (backupName ? ' avec le nom: ' + backupName :
            '') + '.');
        // Add AJAX call to backend to trigger backup
    });

    function restoreBackup(filename) {
        if (confirm(
                `Êtes-vous sûr de vouloir restaurer la base de données à partir de la sauvegarde "${filename}" ?\nCETTE ACTION EST IRRÉVERSIBLE ET ÉCRASERA LES DONNÉES ACTUELLES.`
            )) {
            alert(`Restauration à partir de "${filename}" simulée.`);
            // Add AJAX call to backend to trigger restore
        }
    }

    function deleteBackup(filename) {
        if (confirm(`Êtes-vous sûr de vouloir supprimer la sauvegarde "${filename}" ?`)) {
            alert(`Suppression de la sauvegarde "${filename}" simulée.`);
            // Add AJAX call to backend to delete backup file and DB record
        }
    }

    document.getElementById('uploadRestoreForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const fileInput = document.getElementById('backup_file_upload');
        if (fileInput.files.length === 0) {
            alert("Veuillez sélectionner un fichier de sauvegarde.");
            return;
        }
        if (confirm(
                `Êtes-vous sûr de vouloir restaurer la base de données à partir du fichier téléversé ?\nCETTE ACTION EST IRRÉVERSIBLE ET ÉCRASERA LES DONNÉES ACTUELLES.`
            )) {
            const fileName = fileInput.files[0].name;
            alert(`Restauration à partir du fichier téléversé "${fileName}" simulée.`);
            // Add AJAX call to backend to handle upload and restore
        }
    });
    </script>

</body>

</html>