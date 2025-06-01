<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Scolarité | Scolarité</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hover-scale {
        transition: transform 0.3s ease;
    }

    .hover-scale:hover {
        transform: scale(1.03);
    }

    .sidebar-item.active {
        background-color: #e6f7ff;
        border-left: 4px solid #3b82f6;
        color: #3b82f6;
    }

    .sidebar-item.active i {
        color: #3b82f6;
    }

    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">



        <!-- Main content area -->
        <div class="flex-1 p-4 md:p-6 overflow-y-auto ">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Gestion des paiements</h1>
                        <p class="text-gray-600">Suivi des paiements de scolarité</p>
                    </div>
                    <div class="w-full md:w-96">
                        <div class="relative">
                            <input type="text" id="paymentSearch"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Rechercher un étudiant...">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment status cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white p-4 rounded-lg shadow-sm hover-scale">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Paiements complets</p>
                                <p class="text-2xl font-bold text-gray-800">1,024</p>
                                <p class="text-xs text-gray-500">78% des étudiants</p>
                            </div>
                            <div class="p-3 rounded-full bg-green-100 text-green-500">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-sm hover-scale">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Paiements partiels</p>
                                <p class="text-2xl font-bold text-gray-800">156</p>
                                <p class="text-xs text-gray-500">12% des étudiants</p>
                            </div>
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                                <i class="fas fa-exclamation-circle text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-sm hover-scale">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">En attente</p>
                                <p class="text-2xl font-bold text-gray-800">65</p>
                                <p class="text-xs text-gray-500">5% des étudiants</p>
                            </div>
                            <div class="p-3 rounded-full bg-red-100 text-red-500">
                                <i class="fas fa-times-circle text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment list -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">Liste des paiements</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <!-- Table header -->
                        <div class="grid grid-cols-12 gap-4 px-6 py-3 bg-gray-50 text-sm font-medium text-gray-500">
                            <div class="col-span-3">Étudiant</div>
                            <div class="col-span-2">Formation</div>
                            <div class="col-span-2">Montant total</div>
                            <div class="col-span-2">Payé</div>
                            <div class="col-span-2">Statut</div>
                            <div class="col-span-1">Actions</div>
                        </div>

                        <!-- Sample payment row -->
                        <div class="grid grid-cols-12 gap-4 px-6 py-4 items-center">
                            <div class="col-span-3 flex items-center">
                                <img class="h-10 w-10 rounded-full mr-3"
                                    src="https://randomuser.me/api/portraits/women/44.jpg" alt="">
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Sophie Martin</p>
                                    <p class="text-xs text-gray-500">s.martin@email.com</p>
                                </div>
                            </div>
                            <div class="col-span-2 text-sm text-gray-800">Master Informatique</div>
                            <div class="col-span-2 text-sm text-gray-800">1,200€</div>
                            <div class="col-span-2 text-sm text-gray-800">1,200€</div>
                            <div class="col-span-2">
                                <span class="status-badge bg-green-100 text-green-800">Complet</span>
                            </div>
                            <div class="col-span-1 flex justify-end">
                                <button class="p-1 text-blue-500 hover:text-blue-700 focus:outline-none">
                                    <i class="fas fa-print"></i>
                                </button>
                            </div>
                        </div>

                        <!-- More rows would go here -->
                    </div>
                </div>

                <!-- Payment form -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">Enregistrer un paiement</h2>
                    </div>
                    <div class="px-6 py-4">
                        <form id="paymentForm">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="studentSelect"
                                        class="block text-sm font-medium text-gray-700 mb-1">Étudiant <span
                                            class="text-red-500">*</span></label>
                                    <select id="studentSelect" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Sélectionner un étudiant...</option>
                                        <option value="1">Sophie Martin</option>
                                        <option value="2">Jean Dupont</option>
                                        <option value="3">Marie Lambert</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="paymentAmount"
                                        class="block text-sm font-medium text-gray-700 mb-1">Montant <span
                                            class="text-red-500">*</span></label>
                                    <div class="relative mt-1">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500">€</span>
                                        </div>
                                        <input type="number" id="paymentAmount" required
                                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="0.00">
                                    </div>
                                </div>
                                <div>
                                    <label for="paymentDate" class="block text-sm font-medium text-gray-700 mb-1">Date
                                        <span class="text-red-500">*</span></label>
                                    <input type="date" id="paymentDate" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label for="paymentMethod"
                                        class="block text-sm font-medium text-gray-700 mb-1">Méthode <span
                                            class="text-red-500">*</span></label>
                                    <select id="paymentMethod" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Sélectionner...</option>
                                        <option value="cash">Espèces</option>
                                        <option value="check">Chèque</option>
                                        <option value="transfer">Virement</option>
                                        <option value="card">Carte bancaire</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                    Enregistrer le paiement
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>