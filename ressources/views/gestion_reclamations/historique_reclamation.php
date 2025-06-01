<!-- Contenu de la page d'historique des réclamations -->

<!-- Messages -->
<?php if (isset($_SESSION['message'])): ?>
    <div class="mb-6 p-4 rounded-lg <?php echo $_SESSION['message']['type'] === 'success' ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300'; ?>">
        <i class="fas <?php echo $_SESSION['message']['type'] === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> mr-2"></i>
        <?php echo htmlspecialchars($_SESSION['message']['text']); ?>
    </div>
    <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<!-- Cartes de statut -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-500">En cours</p>
                <h3 class="text-2xl font-bold"><?php echo isset($statistiquesHistorique) ? $statistiquesHistorique['en_cours'] : 0; ?></h3>
            </div>
            <div class="bg-blue-100 rounded-full px-3 py-2 ">
                <i class="fas fa-spinner text-blue-500 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-500">Résolues</p>
                <h3 class="text-2xl font-bold"><?php echo isset($statistiquesHistorique) ? $statistiquesHistorique['resolues'] : 0; ?></h3>
            </div>
            <div class="bg-green-100  rounded-full px-3 py-2 ">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-500">Sans suite</p>
                <h3 class="text-2xl font-bold"><?php echo isset($statistiquesHistorique) ? $statistiquesHistorique['sans_suite'] : 0; ?></h3>
            </div>
            <div class="bg-red-100 rounded-full px-3 py-2 ">
                <i class="fas fa-times-circle text-red-500 text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filtres et recherche -->
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="relative flex-1">
            <form method="GET" class="flex">
                <input type="hidden" name="page" value="gestion_reclamations">
                <input type="hidden" name="action" value="historique_reclamation">

                <input type="text" name="search"
                       value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>"
                       placeholder="Rechercher une réclamation..."
                       class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>

                <button type="submit" class="ml-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <form method="GET" class="flex gap-3">
                <input type="hidden" name="page" value="gestion_reclamations">
                <input type="hidden" name="action" value="historique_reclamation">

                <select name="status" onchange="this.form.submit()"
                        class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="all" <?php echo (!isset($_GET['status']) || $_GET['status'] === 'all') ? 'selected' : ''; ?>>Tous les statuts</option>
                    <option value="en-cours" <?php echo (isset($_GET['status']) && $_GET['status'] === 'en-cours') ? 'selected' : ''; ?>>En cours</option>
                    <option value="resolue" <?php echo (isset($_GET['status']) && $_GET['status'] === 'resolue') ? 'selected' : ''; ?>>Résolue</option>
                    <option value="sans-suite" <?php echo (isset($_GET['status']) && $_GET['status'] === 'sans-suite') ? 'selected' : ''; ?>>Sans suite</option>
                </select>

                <select name="date" onchange="this.form.submit()"
                        class="px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="recent" <?php echo (!isset($_GET['date']) || $_GET['date'] === 'recent') ? 'selected' : ''; ?>>Plus récentes</option>
                    <option value="ancien" <?php echo (isset($_GET['date']) && $_GET['date'] === 'ancien') ? 'selected' : ''; ?>>Plus anciennes</option>
                </select>
            </form>
        </div>
    </div>
</div>

<!-- Tableau des réclamations -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <?php if (empty($reclamations)): ?>
        <div class="text-center py-12">
            <i class="fas fa-archive text-gray-300 text-6xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune réclamation dans l'historique</h3>
            <p class="text-gray-500 mb-4">
                <?php if (isset($_GET['status']) && $_GET['status'] !== 'all'): ?>
                    Aucune réclamation ne correspond aux filtres sélectionnés.
                <?php else: ?>
                    Vous n'avez pas encore d'historique de réclamations.
                <?php endif; ?>
            </p>
            <a href="?page=gestion_reclamations&action=soumettre_reclamation"
               class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Créer une réclamation
            </a>
        </div>
    <?php else: ?>
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
                        Date</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Dernière mise à jour</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Statut</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($reclamations as $rec): ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            REC-<?php echo $rec['id_reclamation']; ?>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="max-w-xs truncate" title="<?php echo htmlspecialchars($rec['titre_reclamation']); ?>">
                                <?php echo htmlspecialchars($rec['titre_reclamation']); ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo date('d/m/Y', strtotime($rec['date_creation'])); ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php
                            $dateMaj = !empty($rec['date_mise_a_jour']) ? $rec['date_mise_a_jour'] : $rec['date_creation'];
                            echo date('d/m/Y', strtotime($dateMaj));
                            ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?php
                                switch($rec['statut_reclamation']) {
                                    case 'En attente':
                                    case 'En cours':
                                        echo 'bg-blue-100 text-blue-800';
                                        break;
                                    case 'Résolue':
                                        echo 'bg-green-100 text-green-800';
                                        break;
                                    case 'Rejetée':
                                        echo 'bg-red-100 text-red-800';
                                        break;
                                    default:
                                        echo 'bg-gray-100 text-gray-800';
                                }
                                ?>">
                                    <i class="fas
                                        <?php
                                    switch($rec['statut_reclamation']) {
                                        case 'En attente': echo 'fa-clock'; break;
                                        case 'En cours': echo 'fa-spinner'; break;
                                        case 'Résolue': echo 'fa-check-circle'; break;
                                        case 'Rejetée': echo 'fa-times-circle'; break;
                                        default: echo 'fa-question-circle';
                                    }
                                    ?> mr-1"></i>
                                    <?php echo htmlspecialchars($rec['statut_reclamation']); ?>
                                </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="?page=gestion_reclamations&action=historique_reclamation&id=<?php echo $rec['id_reclamation']; ?>"
                               class="text-blue-600 hover:text-blue-900 transition-colors">
                                <i class="fas fa-eye mr-1"></i>
                                Voir détail
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if (isset($totalPages) && $totalPages > 1): ?>
            <div class="bg-white px-6 py-3 flex items-center justify-between border-t border-gray-200">
                <div class="flex-1 flex justify-between sm:hidden">
                    <?php if ($page > 1): ?>
                        <a href="?page=gestion_reclamations&action=historique_reclamation&p=<?php echo $page - 1; ?><?php echo isset($_GET['status']) ? '&status=' . urlencode($_GET['status']) : ''; ?>"
                           class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Précédent
                        </a>
                    <?php endif; ?>

                    <?php if ($page < $totalPages): ?>
                        <a href="?page=gestion_reclamations&action=historique_reclamation&p=<?php echo $page + 1; ?><?php echo isset($_GET['status']) ? '&status=' . urlencode($_GET['status']) : ''; ?>"
                           class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Suivant
                        </a>
                    <?php endif; ?>
                </div>

                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Affichage de
                            <span class="font-medium"><?php echo (($page - 1) * 10) + 1; ?></span>
                            à
                            <span class="font-medium"><?php echo min($page * 10, $totalReclamations); ?></span>
                            sur
                            <span class="font-medium"><?php echo $totalReclamations; ?></span>
                            réclamations
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <?php if ($page > 1): ?>
                                <a href="?page=gestion_reclamations&action=historique_reclamation&p=<?php echo $page - 1; ?><?php echo isset($_GET['status']) ? '&status=' . urlencode($_GET['status']) : ''; ?>"
                                   class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Précédent</span>
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            <?php endif; ?>

                            <!-- Numéros de page -->
                            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                                <a href="?page=gestion_reclamations&action=historique_reclamation&p=<?php echo $i; ?><?php echo isset($_GET['status']) ? '&status=' . urlencode($_GET['status']) : ''; ?>"
                                   class="relative inline-flex items-center px-4 py-2 border text-sm font-medium
                                          <?php echo $i === $page ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'; ?>">
                                    <?php echo $i; ?>
                                </a>
                            <?php endfor; ?>

                            <?php if ($page < $totalPages): ?>
                                <a href="?page=gestion_reclamations&action=historique_reclamation&p=<?php echo $page + 1; ?><?php echo isset($_GET['status']) ? '&status=' . urlencode($_GET['status']) : ''; ?>"
                                   class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Suivant</span>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            <?php endif; ?>
                        </nav>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>