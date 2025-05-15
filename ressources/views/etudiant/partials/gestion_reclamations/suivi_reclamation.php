<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des Réclamations Étudiantes</title>

</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- En-tête -->
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-blue-800">Suivi des Réclamations</h1>
            <p class="text-gray-600">Consultez l'état de vos réclamations en cours</p>
        </header>

        <!-- Filtres -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Filtrer les réclamations</h2>
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select id="statusFilter"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="all">Tous les statuts</option>
                        <option value="pending">En attente</option>
                        <option value="in_progress">En traitement</option>
                        <option value="resolved">Résolue</option>
                        <option value="rejected">Rejetée</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select id="typeFilter"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="all">Tous les types</option>
                        <option value="academic">Académique</option>
                        <option value="financial">Financière</option>
                        <option value="administrative">Administrative</option>
                        <option value="technical">Technique</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <select id="dateFilter"
                        class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="all">Toutes les dates</option>
                        <option value="today">Aujourd'hui</option>
                        <option value="week">Cette semaine</option>
                        <option value="month">Ce mois</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button id="applyFilters"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-200">
                        Appliquer
                    </button>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total</p>
                        <h3 class="text-2xl font-bold" id="totalClaims">0</h3>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-file-alt text-blue-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">En attente</p>
                        <h3 class="text-2xl font-bold" id="pendingClaims">0</h3>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <i class="fas fa-clock text-yellow-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">En traitement</p>
                        <h3 class="text-2xl font-bold" id="inProgressClaims">0</h3>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-spinner text-purple-600"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Résolues</p>
                        <h3 class="text-2xl font-bold" id="resolvedClaims">0</h3>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-check-circle text-green-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liste des réclamations -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-700">Vos réclamations</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Sujet</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Type</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody id="claimsTableBody" class="bg-white divide-y divide-gray-200">
                        <!-- Les réclamations seront chargées ici via JavaScript -->
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    Affichage de <span id="startItem">1</span> à <span id="endItem">5</span> sur <span
                        id="totalItems">0</span> réclamations
                </div>
                <div class="flex space-x-2">
                    <button id="prevPage" class="px-3 py-1 border rounded-md text-gray-700 disabled:opacity-50"
                        disabled>
                        Précédent
                    </button>
                    <button id="nextPage" class="px-3 py-1 border rounded-md text-gray-700 disabled:opacity-50"
                        disabled>
                        Suivant
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de détails -->
    <div id="claimModal" class="fixed inset-0    flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto opacity-100">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-700">Détails de la réclamation</h3>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6" id="modalContent">
                <!-- Contenu du modal sera chargé ici -->
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                <button id="closeModalBtn"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-200">
                    Fermer
                </button>
            </div>
        </div>
    </div>


</body>

</html>