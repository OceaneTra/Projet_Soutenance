<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion des dossiers de candidature vérifiés</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>

<body class="bg-green-50 min-h-screen">
    <div class="flex min-h-screen">

        <!-- Main content -->
        <div class="flex-1 flex flex-col min-h-screen">

            <header class="w-full flex justify-center mt-8 mb-6">
                <div
                    class="max-w-5xl w-full mx-auto bg-green-200 rounded-2xl px-8 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4 border border-green-500">
                    <div class="flex items-center gap-4">
                        <span class="text-green-800 text-xl md:text-2xl font-bold tracking-tight"><i
                                class="fa-solid fa-file-circle-check mr-2 text-green-600"></i>Dossiers de candidature
                            vérifiés</span>
                        <span
                            class=" bg-green-500 w-2/3 text-white text-xs font-semibold px-6 py-1 rounded-full shadow">
                            Total : <span id="totalRapports">0</span>
                        </span>
                    </div>
                    <div class="flex items-center gap-2 mt-2 md:mt-0">
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Rechercher..."
                                class="pl-10 pr-3 py-2 rounded-lg border border-green-300 bg-green-50 focus:ring-2 focus:ring-green-400 focus:border-green-400 text-green-900 placeholder-green-400 shadow-sm outline-none text-sm w-44" />
                            <i
                                class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-green-400 pointer-events-none"></i>
                        </div>
                        <select id="statutFilter"
                            class="ml-2 px-3 py-2 rounded-lg border border-green-300 bg-green-50 text-green-700 text-sm focus:ring-2 focus:ring-green-400 focus:border-green-400">
                            <option value="all">Tous les statuts</option>
                            <option value="approuve">Approuvé</option>
                            <option value="rejete">Rejeté</option>
                        </select>
                        <button
                            class="ml-2 px-4 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-white font-semibold flex items-center gap-2 shadow transition-colors"><i
                                class="fa-solid fa-print"></i> Imprimer</button>
                        <button
                            class="ml-2 px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold flex items-center gap-2 shadow transition-colors"><i
                                class="fa-solid fa-file-export"></i> Exporter</button>
                    </div>
                </div>
            </header>
            <!-- Content -->
            <main class="flex-1 flex flex-col items-center">
                <div
                    class="w-full max-w-5xl mx-auto bg-white rounded-2xl shadow-xl p-6 md:p-10 border border-green-100">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-green-700 flex items-center gap-2"><i
                                    class="fa-solid fa-list-check text-green-600"></i> Historique des vérifications</h2>
                            <p class="text-green-500 text-sm mt-1">Consultez, imprimez ou exportez l'historique des
                                rapports vérifiés.</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 rounded-xl overflow-hidden">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">
                                        Étudiant</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Rapport</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Thème</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date d'envoi</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Vérifié par</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Statut</th>
                                    <th
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tr-lg">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!-- Exemple statique adapté -->
                                <tr class="hover:bg-green-50 transition">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 rounded-bl-lg flex items-center gap-2">
                                        <i class="fa-solid fa-user text-green-400"></i> Jean Dupont
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 flex items-center gap-2">
                                        Rapport de stage
                                        <span
                                            class="ml-2 px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-bold flex items-center gap-1"><i
                                                class="fa-solid fa-check-circle"></i> Vérifié</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Développement web</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">12/06/2024</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Dr. Martin</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fa-solid fa-circle-check text-green-500"></i> Approuvé
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm rounded-br-lg">
                                        <div class="flex items-center gap-1 justify-center">
                                            <button onclick="openResumeModal()" title="Voir résumé"
                                                class="bg-green-100 hover:bg-green-200 text-green-700 px-2 py-1 rounded-lg text-sm flex items-center gap-1 shadow transition-colors"><i
                                                    class="fa-solid fa-eye"></i></button>
                                            <button title="Imprimer"
                                                class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded-lg text-sm flex items-center gap-1 shadow transition-colors"><i
                                                    class="fa-solid fa-print"></i></button>
                                            <button title="Exporter"
                                                class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded-lg text-sm flex items-center gap-1 shadow transition-colors"><i
                                                    class="fa-solid fa-file-export"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover:bg-red-50 transition">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 flex items-center gap-2">
                                        <i class="fa-solid fa-user text-green-400"></i> Alice Martin
                                    </td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 flex items-center gap-2">
                                        Rapport final
                                        <span
                                            class="ml-2 px-2 py-0.5 rounded-full bg-red-100 text-red-700 text-xs font-bold flex items-center gap-1"><i
                                                class="fa-solid fa-xmark-circle"></i> Vérifié</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Analyse de données
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">10/06/2024</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Mme Dupuis</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-700">
                                            <i class="fa-solid fa-circle-xmark text-red-400"></i> Rejeté
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        <div class="flex items-center gap-1 justify-center">
                                            <button onclick="openResumeModal()" title="Voir résumé"
                                                class="bg-green-100 hover:bg-green-200 text-green-700 px-2 py-1 rounded-lg text-sm flex items-center gap-1 shadow transition-colors"><i
                                                    class="fa-solid fa-eye"></i></button>
                                            <button title="Imprimer"
                                                class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded-lg text-sm flex items-center gap-1 shadow transition-colors"><i
                                                    class="fa-solid fa-print"></i></button>
                                            <button title="Exporter"
                                                class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded-lg text-sm flex items-center gap-1 shadow transition-colors"><i
                                                    class="fa-solid fa-file-export"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <!-- ... -->
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination statique -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mt-4 gap-2">
                        <div class="text-gray-600 text-sm">Page 1 sur 1 — Affichage de <span
                                class="font-semibold">1</span> à <span class="font-semibold">2</span> sur <span
                                class="font-semibold">2</span> rapports</div>
                        <div class="flex justify-center mt-2 md:mt-0">
                            <nav class="inline-flex -space-x-px">
                                <a href="#"
                                    class="px-3 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-300 cursor-not-allowed rounded-l-md">&laquo;</a>
                                <a href="#"
                                    class="px-3 py-2 border border-gray-300 bg-white text-sm font-medium bg-green-100 text-green-700 font-bold">1</a>
                                <a href="#"
                                    class="px-3 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-300 cursor-not-allowed rounded-r-md">&raquo;</a>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- Modale résumé de candidature -->
                <div id="resumeModal" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50 hidden">
                    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-2xl relative border border-green-100">
                        <button onclick="closeResumeModal()"
                            class="absolute top-4 right-4 text-green-400 hover:text-green-700 text-xl transition-colors"><i
                                class="fa-solid fa-xmark"></i></button>
                        <h3 class="text-xl font-bold text-green-700 mb-4 flex items-center gap-2"><i
                                class="fa-solid fa-user-graduate text-green-600"></i> Résumé de candidature</h3>
                        <div class="text-green-900 text-base">
                            <!-- Contenu dynamique du résumé à insérer ici -->
                            <p class="mb-2"><span class="font-semibold">Nom :</span> Jean Dupont</p>
                            <p class="mb-2"><span class="font-semibold">Rapport :</span> Rapport de stage</p>
                            <p class="mb-2"><span class="font-semibold">Thème :</span> Développement web</p>
                            <p class="mb-2"><span class="font-semibold">Statut :</span> <span
                                    class="inline-block px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">Approuvé</span>
                            </p>
                            <p class="mb-2"><span class="font-semibold">Résumé :</span> Lorem ipsum dolor sit amet,
                                consectetur adipiscing elit. Suspendisse euismod, urna eu tincidunt consectetur, nisi
                                nisl aliquam nunc, eget aliquam massa.</p>
                        </div>
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
        let count = 0;
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const visible = text.includes(term);
            row.style.display = visible ? '' : 'none';
            if (visible) count++;
        });
        document.getElementById('totalRapports').textContent = count;
    });
    // Filtre par statut
    const statutFilter = document.getElementById('statutFilter');
    statutFilter.addEventListener('change', function() {
        const statut = this.value;
        const rows = document.querySelectorAll('#rapportsTable tbody tr');
        let count = 0;
        rows.forEach(row => {
            const cell = row.querySelector('td:nth-child(5) span');
            if (!cell) return;
            const status = cell.textContent.trim().toLowerCase();
            const visible = (statut === 'all') || (statut === 'approuve' && status === 'approuvé') || (
                statut === 'rejete' && status === 'rejeté');
            row.style.display = visible ? '' : 'none';
            if (visible) count++;
        });
        document.getElementById('totalRapports').textContent = count;
    });
    // Modale résumé
    function openResumeModal() {
        document.getElementById('resumeModal').classList.remove('hidden');
    }

    function closeResumeModal() {
        document.getElementById('resumeModal').classList.add('hidden');
    }
    // Initialiser le compteur
    window.onload = function() {
        document.getElementById('totalRapports').textContent = document.querySelectorAll('#rapportsTable tbody tr')
            .length;
    };
    </script>
</body>

</html>