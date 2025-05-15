<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Piste D'Audit</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">


</head>

<body class="bg-gray-50 min-h-screen animated-bg font-sans">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header with Logo and Title -->
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center">
            <div class="bg-green-500 text-white p-3 rounded-full mr-4">
                <i class="fas fa-shield-alt text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800"> Piste d'Audit</h1>
        </div>
        <div class="date-picker relative">
            <label class="block text-sm font-medium text-gray-700 mb-1">Date du jour</label>
            <input type="text"
                   class="w-40 px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 focus:border-0 text-sm"
                   readonly value="10/05/2025">
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white shadow-lg rounded-xl overflow-hidden transition-all hover:shadow-xl">
        <!-- Card Header -->
        <div class="bg-gradient-to-r from-green-600 to-green-800 px-6 py-4">
            <h2 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-history mr-2"></i>
                Piste d'Audit - Historique des Connexions
            </h2>
        </div>

        <!-- Filters Section -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                <!-- Period Selection -->
                <div class="flex flex-col sm:flex-row items-start sm:items-end gap-4">
                    <div class="w-full sm:w-auto">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Période de recherche</h3>
                        <div class="flex items-center space-x-2">
                            <div class="date-picker">
                                <label class="block text-xs text-gray-500 mb-1">Date début</label>
                                <input type="text" id="date-debut"
                                       class="w-32 px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 focus:border-0 text-sm"
                                       placeholder="JJ/MM/AAAA">
                            </div>
                            <div class="date-picker">
                                <label class="block text-xs text-gray-500 mb-1">Date fin</label>
                                <input type="text" id="date-fin"
                                       class="w-32 px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 text-sm"
                                       placeholder="JJ/MM/AAAA">
                            </div>
                            <button
                                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm shadow-sm transition-all mt-5 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                <i class="fas fa-filter mr-1"></i> Filtrer
                            </button>
                        </div>
                    </div>

                    <!-- Additional Filters -->
                    <div class="w-full sm:w-auto">
                        <label class="block text-xs text-gray-500 mb-1">Statut</label>
                        <select
                                class="w-full sm:w-40 px-3 py-2 bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                            <option value="">Tous les statuts</option>
                            <option value="success">Succès</option>
                            <option value="failure">Échec</option>
                            <option value="warning">Avertissement</option>
                        </select>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="relative w-full md:w-96">
                    <input type="text" placeholder="Rechercher une connexion..."
                           class="search-input w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400 search-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center px-6 py-3 bg-white border-b border-gray-200">
            <div class="text-sm text-gray-500">
                <span class="font-medium">248</span> enregistrements trouvés
            </div>
            <div class="flex space-x-2">
                <button
                        class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg text-sm shadow-sm transition-all hover-scale focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 flex items-center"
                        data-tooltip="Exporter les données">
                    <i class="fas fa-file-export mr-2"></i> Exporter
                </button>
                <button
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm shadow-sm transition-all hover-scale focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center"
                        data-tooltip="Imprimer les résultats">
                    <i class="fas fa-print mr-2"></i> Imprimer
                </button>
                <button
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg text-sm shadow-sm transition-all hover-scale focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 flex items-center"
                        data-tooltip="Actualiser les données">
                    <i class="fas fa-sync-alt mr-2"></i> Actualiser
                </button>
            </div>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full table-hover">
                <thead class="bg-gray-50 text-gray-700 border-b border-gray-200">
                <tr>
                    <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer">
                            Date
                            <i class="fas fa-sort ml-1 text-gray-400"></i>
                        </div>
                    </th>
                    <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">
                        <div class="flex items-center cursor-pointer">
                            Heure
                            <i class="fas fa-sort ml-1 text-gray-400"></i>
                        </div>
                    </th>
                    <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Statut</th>
                    <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Traitement</th>
                    <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Login
                        Utilisateur
                    </th>
                    <th class="py-3 px-4 text-left text-xs font-medium uppercase tracking-wider">Nom Utilisateur
                    </th>
                    <th class="py-3 px-4 text-center text-xs font-medium uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                <!-- Sample data rows -->
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-sm">10/05/2025</td>
                    <td class="py-3 px-4 text-sm">08:45:12</td>
                    <td class="py-3 px-4">
                                <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Succès</span>
                    </td>
                    <td class="py-3 px-4 text-sm">Connexion</td>
                    <td class="py-3 px-4 text-sm">jmartin</td>
                    <td class="py-3 px-4 text-sm">Jean Martin</td>
                    <td class="py-3 px-4 text-center">
                        <button class="text-blue-600 hover:text-blue-800 mx-1 custom-tooltip"
                                data-tooltip="Voir les détails">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-sm">10/05/2025</td>
                    <td class="py-3 px-4 text-sm">09:12:34</td>
                    <td class="py-3 px-4">
                                <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Échec</span>
                    </td>
                    <td class="py-3 px-4 text-sm">Tentative de connexion</td>
                    <td class="py-3 px-4 text-sm">pdupont</td>
                    <td class="py-3 px-4 text-sm">Pierre Dupont</td>
                    <td class="py-3 px-4 text-center">
                        <button class="text-blue-600 hover:text-blue-800 mx-1 custom-tooltip"
                                data-tooltip="Voir les détails">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-sm">10/05/2025</td>
                    <td class="py-3 px-4 text-sm">09:30:45</td>
                    <td class="py-3 px-4">
                                <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Succès</span>
                    </td>
                    <td class="py-3 px-4 text-sm">Connexion</td>
                    <td class="py-3 px-4 text-sm">pdupont</td>
                    <td class="py-3 px-4 text-sm">Pierre Dupont</td>
                    <td class="py-3 px-4 text-center">
                        <button class="text-blue-600 hover:text-blue-800 mx-1 custom-tooltip"
                                data-tooltip="Voir les détails">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-sm">10/05/2025</td>
                    <td class="py-3 px-4 text-sm">10:15:00</td>
                    <td class="py-3 px-4">
                                <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Avertissement</span>
                    </td>
                    <td class="py-3 px-4 text-sm">Modification de droits</td>
                    <td class="py-3 px-4 text-sm">sbernard</td>
                    <td class="py-3 px-4 text-sm">Sophie Bernard</td>
                    <td class="py-3 px-4 text-center">
                        <button class="text-blue-600 hover:text-blue-800 mx-1 custom-tooltip"
                                data-tooltip="Voir les détails">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-sm">10/05/2025</td>
                    <td class="py-3 px-4 text-sm">11:20:18</td>
                    <td class="py-3 px-4">
                                <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Succès</span>
                    </td>
                    <td class="py-3 px-4 text-sm">Déconnexion</td>
                    <td class="py-3 px-4 text-sm">jmartin</td>
                    <td class="py-3 px-4 text-sm">Jean Martin</td>
                    <td class="py-3 px-4 text-center">
                        <button class="text-blue-600 hover:text-blue-800 mx-1 custom-tooltip"
                                data-tooltip="Voir les détails">
                            <i class="fas fa-eye"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                Affichage de <span class="font-medium">1</span> à <span class="font-medium">5</span> sur <span
                        class="font-medium">248</span> enregistrements
            </div>
            <div class="flex items-center space-x-1">
                <button class="pagination-item" disabled>
                    <i class="fas fa-chevron-left mr-2"></i>
                </button>
                <button class="pagination-item active">1</button>
                <button class="pagination-item">2</button>
                <button class="pagination-item">3</button>
                <span class="pagination-item ">...</span>
                <button class="pagination-item">50</button>
                <button class="pagination-item">
                    <i class="fas fa-chevron-right ml-2"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="mt-8 text-center text-sm text-gray-500">
        <p>© 2025 Système de Piste d'Audit. Tous droits réservés.</p>
    </div>
</div>

<script>
    // Initialize date pickers
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#date-debut", {
            locale: "fr",
            dateFormat: "d/m/Y",
            maxDate: "today"
        });

        flatpickr("#date-fin", {
            locale: "fr",
            dateFormat: "d/m/Y",
            maxDate: "today"
        });
    });
</script>
</body>

</html>