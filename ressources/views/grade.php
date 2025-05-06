<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Grades - ValidMaster</title>
    <link rel="stylesheet" href="/assets/css/styles.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="min-h-screen flex flex-col">
    <header class="bg-blue-600 text-white shadow">
        <div class="container mx-auto px-4 py-4">
            <h1 class="text-2xl font-bold">ValidMaster - Administration</h1>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold">Gestion des Grades</h2>
            <a href="?route=admin/dashboard" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">Retour</a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p><?= $message ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p><?= $error ?></p>
            </div>
        <?php endif; ?>

        <!-- Formulaire d'ajout -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-xl font-semibold mb-4">Ajouter un nouveau grade</h3>
            <form method="POST" action="?route=admin/parametres/grade">
                <div class="mb-4">
                    <label for="lib_grade" class="block text-sm font-medium text-gray-700 mb-1">Grade</label>
                    <input type="text" id="lib_grade" name="lib_grade" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Ajouter
                </button>
            </form>
        </div>

        <!-- Tableau des grades -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($grades as $grade): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?= htmlspecialchars($grade['id_grade']) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= htmlspecialchars($grade['lib_grade']) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button class="text-red-600 hover:text-red-900">Supprimer</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-4">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?= date('Y') ?> ValidMaster - Système de gestion de la commission de validation</p>
        </div>
    </footer>
</div>
</body>
</html>