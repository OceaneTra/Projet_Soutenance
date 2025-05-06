<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Règlement des Frais | ScholarSync</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .form-card {
            transition: all 0.2s ease;
        }

        .form-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <?php include __DIR__ . '/composants/sidebar.php'; ?>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <?php include __DIR__ . '/composants/header.php'; ?>

            <!-- Main content area -->
            <div class="flex-1 overflow-auto p-4 md:p-6">
                <div class="mb-6 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-800">Règlement des Frais d'Inscription</h1>
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        <i class="fas fa-print mr-2"></i> Imprimer
                    </button>
                </div>

                <!-- Formulaire de règlement -->
                <div class="bg-white rounded-lg shadow overflow-hidden form-card mb-6">
                    <div class="px-6 py-4 bg-indigo-50 border-b border-indigo-100">
                        <h2 class="text-lg font-semibold text-indigo-800">Informations de Paiement</h2>
                    </div>
                    <div class="p-6">
                        <form>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">N° Étudiant</label>
                                    <input type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                                    <input type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Année Académique</label>
                                    <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option>2023-2024</option>
                                        <option>2024-2025</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Montant</label>
                                    <input type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date de Paiement</label>
                                    <input type="date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Mode de Paiement</label>
                                    <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option>Espèces</option>
                                        <option>Chèque</option>
                                        <option>Virement</option>
                                        <option>Carte Bancaire</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Référence</label>
                                    <input type="text" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>

                            <div class="mt-8 border-t border-gray-200 pt-6">
                                <div class="flex justify-between">
                                    <button type="button" class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        <i class="fas fa-times mr-2"></i> Annuler
                                    </button>
                                    <button type="submit" class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                        <i class="fas fa-check mr-2"></i> Enregistrer le Paiement
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Historique des paiements -->
                <div class="bg-white rounded-lg shadow overflow-hidden form-card">
                    <div class="px-6 py-4 bg-indigo-50 border-b border-indigo-100">
                        <h2 class="text-lg font-semibold text-indigo-800">Historique des Paiements</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mode</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">15/04/2025</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">PAY-2025-001</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">500 000 FCFA</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Virement</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Validé
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">10/03/2025</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">PAY-2025-002</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">250 000 FCFA</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Chèque</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            En attente
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <div class="flex justify-between items-center">
                            <div class="text-sm text-gray-500">
                                Total: <span class="font-bold">750 000 FCFA</span>
                            </div>
                            <div>
                                <button class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                                    <i class="fas fa-plus mr-2"></i> Nouveau Paiement
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/scripts.js"></script>
</body>

</html>