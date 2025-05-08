<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piste D'audit</title>

</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Audit Trail Interface -->
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg my-8 p-8">
        <div class="flex justify-between items-center mb-6 border-b pb-3">
            <h1 class=" text-xl font-bold text-green-500">Piste d'audit</h1>
            <div class="ml-8 mb-3">
                <label class="block text-sm mb-3">Date du jour</label>
                <input type="text" class="w-32 px-3 py-2 border border-gray-300 text-sm focus:outline-none rounded-md">
            </div>
        </div>


        <div class="mb-6">
            <h2 class="text-md font-medium mb-2">Période</h2>
            <div class="flex items-center space-x-4">
                <div>
                    <label class="block text-sm mb-3">debut</label>
                    <input type="text"
                        class="w-32 px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm mb-3">Fin</label>
                    <input type="text"
                        class="w-32 px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

            </div>
        </div>

        <h2 class="text-lg font-medium border-t border-b py-2 mb-4 text-green-500">Liste des connexions</h2>

        <div class="flex justify-between mb-4">
            <button
                class="bg-orange-500 text-white px-6 py-2 rounded-md text-sm  focus:outline-none focus:ring-2  focus:ring-offset-2">Exporter</button>

            <div class="flex items-center w-1/3">
                <input type="text"
                    class="w-full px-6 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2">
                <button
                    class="rounded-md bg-green-500 text-white px-3 py-1 rounded-r text-sm border  border-l-0  focus:outline-none focus:ring-2  focus:ring-offset-2">
                    <i class="fa fa-search py-3 "></i>
                </button>
            </div>

            <button
                class="bg-green-500 text-white px-6 py-2 rounded-md text-sm  focus:outline-none focus:ring-2  focus:ring-offset-2">Imprimer</button>
        </div>

        <table class=" w-full  border border-gray-300 rounded-md mt-3 ">
            <thead class="bg-gray-50 text-gray-700">
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
                <tr class="border-b">
                    <td class="py-2 px-4 text-sm" colspan="6"></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>