<?php

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Vérification des rapports étudiants</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>

<body class="bg-green-50 min-h-screen">
    <div class="flex min-h-screen">

        <!-- Main content -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- Content -->
            <main class="flex-1 p-8 bg-green-50/60">
                <div class="bg-white rounded-2xl shadow-xl p-6 md:p-10">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-green-700 flex items-center gap-2"><i
                                    class="fa-solid fa-list-check"></i> Liste des rapports étudiants</h2>
                            <p class="text-green-400 text-sm mt-1">Vérifiez, validez ou rejetez les rapports soumis par
                                les étudiants.</p>
                        </div>

                    </div>
                    <div class="overflow-x-auto rounded-xl shadow-sm">
                        <table id="rapportsTable" class="min-w-full bg-white rounded-xl text-green-900">
                            <thead class="sticky top-0 z-10">
                                <tr>
                                    <th
                                        class="px-4 py-4 bg-green-50 text-green-700 font-bold text-left text-base whitespace-nowrap border-b border-green-100">
                                        <i class="fa-solid fa-user-graduate mr-2"></i>Étudiant
                                    </th>
                                    <th
                                        class="px-4 py-4 bg-green-50 text-green-700 font-bold text-left text-base whitespace-nowrap border-b border-green-100">
                                        <i class="fa-solid fa-file-lines mr-2"></i>Rapport
                                    </th>
                                    <th
                                        class="px-4 py-4 bg-green-50 text-green-700 font-bold text-left text-base whitespace-nowrap border-b border-green-100">
                                        <i class="fa-solid fa-lightbulb mr-2"></i>Thème
                                    </th>
                                    <th
                                        class="px-4 py-4 bg-green-50 text-green-700 font-bold text-left text-base whitespace-nowrap border-b border-green-100">
                                        <i class="fa-solid fa-calendar-day mr-2"></i>Date d'envoi
                                    </th>
                                    <th
                                        class="px-4 py-4 bg-green-50 text-green-700 font-bold text-center text-base whitespace-nowrap border-b border-green-100">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-green-50">
                                <?php if (empty($rapports)): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-gray-400 py-12 text-lg">Aucun rapport
                                        trouvé.</td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($rapports as $i => $rapport): ?>
                                <tr
                                    class="hover:bg-green-50 transition <?php echo $i % 2 === 0 ? 'bg-green-50/40' : 'bg-white'; ?>">
                                    <td
                                        class="px-4 py-3 font-medium text-green-800 flex items-center gap-2 whitespace-nowrap">
                                        <i
                                            class="fa-solid fa-user text-green-300"></i><?= htmlspecialchars($rapport->nom_etu . ' ' . $rapport->prenom_etu) ?>
                                    </td>
                                    <td class="px-4 py-3 font-semibold text-green-900 whitespace-nowrap">
                                        <?= htmlspecialchars($rapport->nom_rapport) ?></td>
                                    <td class="px-4 py-3 italic text-green-600 whitespace-nowrap">
                                        <?= htmlspecialchars($rapport->theme_rapport) ?></td>
                                    <td class="px-4 py-3 text-green-500 font-medium whitespace-nowrap">
                                        <?= date('d/m/Y', strtotime($rapport->date_rapport)) ?></td>
                                    <td class="px-4 py-3 text-center whitespace-nowrap">
                                        <div class="flex items-center gap-2 justify-center">
                                            <button
                                                class="bg-green-100 hover:bg-green-200 text-green-700 px-3 py-1 rounded-lg text-sm font-semibold flex items-center gap-1"><i
                                                    class="fa-solid fa-circle-check"></i> Valider</button>
                                            <button
                                                class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1 rounded-lg text-sm font-semibold flex items-center gap-1"><i
                                                    class="fa-solid fa-circle-xmark"></i> Rejeter</button>
                                            <button
                                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1 rounded-lg text-sm font-semibold flex items-center gap-1"><i
                                                    class="fa-solid fa-eye"></i> Détail</button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
    // Recherche dynamique dans le tableau
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function() {
        const term = this.value.toLowerCase();
        const rows = document.querySelectorAll('#rapportsTable tbody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(term) ? '' : 'none';
        });
    });
    </script>

</body>

</html>