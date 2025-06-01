<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants Encadrés</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">


    <style>
    /* Custom styles if needed (keep minimal, prefer Tailwind utilities) */
    .table-row-hover:hover {
        background-color: #f7fafc;
        /* hover:bg-gray-50 */
    }
    </style>

</head>

<body class="font-sans bg-gray-100 text-gray-800 min-h-screen p-6">

    <div class="container mx-auto px-4 max-w-screen-xl">

        <!-- Header with Title and User -->
        <!-- Note: Full header from image is part of the layout, replicating main content area -->

        <div class="bg-white rounded-lg shadow-lg p-6">

            <!-- Section Header and Controls -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 border-b border-gray-200 pb-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 md:mb-0">Étudiants Encadrés</h2>
                <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                    <div class="relative w-full sm:w-64">
                        <input type="text" placeholder="Rechercher..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500 text-sm">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    <!-- Filter Button -->
                    <button
                        class="bg-purple-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-purple-700 transition-colors duration-200 w-full sm:w-auto">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                    <!-- Example: Add New Button -->
                    <!-- <button class="bg-green-500 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-green-600 transition-colors duration-200 w-full sm:w-auto">
                         <i class="fas fa-user-plus mr-2"></i> Ajouter Nouvel Étudiant
                     </button> -->
                </div>
            </div>

            <!-- Students Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Photo</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nom Étudiant</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Numéro Étudiant</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Niveau</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        // Placeholder for dynamic student data
                        $students = [
                            ['photo' => 'https://randomuser.me/api/portraits/men/1.jpg', 'nom' => 'Dupont', 'prenom' => 'Jean', 'num_etu' => '12345', 'niveau' => 'L3', 'status' => 'Actif'],
                            ['photo' => 'https://randomuser.me/api/portraits/women/1.jpg', 'nom' => 'Durand', 'prenom' => 'Lucie', 'num_etu' => '67890', 'niveau' => 'M1', 'status' => 'Actif'],
                            ['photo' => 'https://randomuser.me/api/portraits/men/2.jpg', 'nom' => 'Petit', 'prenom' => 'Thomas', 'num_etu' => '11223', 'niveau' => 'M2', 'status' => 'Inactif'],
                            ['photo' => 'https://randomuser.me/api/portraits/women/2.jpg', 'nom' => 'Bernard', 'prenom' => 'Sophie', 'num_etu' => '44556', 'niveau' => 'L3', 'status' => 'Actif'],
                            ['photo' => 'https://randomuser.me/api/portraits/men/3.jpg', 'nom' => 'Martin', 'prenom' => 'Pierre', 'num_etu' => '77889', 'niveau' => 'M2', 'status' => 'Actif'],
                            // Add more student data here
                        ];

                        // Loop through students (replace with fetching from database and applying filters/pagination)
                        foreach ($students as $student) {
                        ?>
                        <tr class="table-row-hover">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full"
                                            src="<?php echo htmlspecialchars($student['photo']); ?>" alt="">
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?php echo htmlspecialchars($student['prenom'] . ' ' . $student['nom']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?php echo htmlspecialchars($student['num_etu']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <?php echo htmlspecialchars($student['niveau']); ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($student['status'] == 'Actif'): ?>
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Actif
                                </span>
                                <?php else: ?>
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Inactif
                                </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <!-- Actions like View, Edit, Delete, Login -->
                                <a href="#" class="text-purple-600 hover:text-purple-900 mr-3" title="Voir Profil">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <!-- Add other actions if needed -->
                                <!-- <a href="#" class="text-blue-600 hover:text-blue-900 mr-3" title="Modifier"><i class="fas fa-edit"></i></a>
                                <a href="#" class="text-red-600 hover:text-red-900" title="Supprimer"><i class="fas fa-trash"></i></a> -->
                            </td>
                        </tr>
                        <?php
                        } // end foreach
                        // If no students found
                        if (empty($students)) {
                        ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Aucun étudiant trouvé.
                            </td>
                        </tr>
                        <?php
                         }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination (Simplified for Placeholder) -->
            <div class="mt-6 flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    <!-- Showing X to Y of Z results (dynamic) -->
                    Affichage de 1 à <?php echo count($students); ?> sur <?php echo count($students); ?> résultats
                </div>
                <div class="flex items-center">
                    <button
                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50"
                        disabled>
                        Précédent
                    </button>
                    <a href="#"
                        class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Suivant
                    </a>
                </div>
            </div>

        </div>

    </div>

</body>

</html>