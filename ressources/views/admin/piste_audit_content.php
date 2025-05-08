<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piste D'AUDIT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-8">
                    <button class="py-4 px-2 border-b-0 text-gray-500 font-medium">User Profile</button>
                    <button class="py-4 px-2 border-b-0 text-gray-500 font-medium">Gestion des utilisateurs</button>
                    <button class="py-4 px-2 border-b-2 border-blue-500 text-blue-500 font-medium">Piste
                        D'AUDIT</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Audit Trail Interface -->
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg my-8 p-8">
        <h1 class="text-xl font-bold border-b pb-3 mb-6">Piste D'AUDIT</h1>

        <div class="mb-6">
            <h2 class="text-md font-medium mb-2">Période</h2>
            <div class="flex items-center space-x-4">
                <div>
                    <label class="block text-sm mb-1">debut</label>
                    <input type="text"
                        class="w-32 px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm mb-1">Fin</label>
                    <input type="text"
                        class="w-32 px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="ml-8">
                    <label class="block text-sm mb-1">Date du jour</label>
                    <input type="text"
                        class="w-32 px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
        </div>

        <h2 class="text-lg font-medium border-t border-b py-2 mb-4">Liste des connexions</h2>

        <div class="flex justify-between mb-4">
            <button
                class="bg-gray-200 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Exporter</button>

            <div class="flex items-center">
                <input type="text"
                    class="w-48 px-3 py-1 border border-gray-300 rounded-l text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <button
                    class="bg-gray-200 text-gray-700 px-3 py-1 rounded-r text-sm border border-gray-300 border-l-0 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>

            <button
                class="bg-gray-200 text-gray-700 px-3 py-1 rounded text-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Imprimer</button>
        </div>

        <table class="w-full border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="py-2 px-4 text-left text-sm">Date</th>
                    <th class="py-2 px-4 text-left text-sm">Heure</th>
                    <th class="py-2 px-4 text-left text-sm">Statut</th>
                    <th class="py-2 px-4 text-left text-sm">Traitement</th>
                    <th class="py-2 px-4 text-left text-sm">Login Utilisateur</th>
                    <th class="py-2 px-4 text-left text-sm">Nom Utilisateur</th>
                </tr>
            </thead>
            <tbody>
                <!-- Empty rows would go here -->
                <tr class="border-b">
                    <td class="py-2 px-4 text-sm" colspan="6">No data available</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>