<?php
require_once __DIR__ . '/../../app/config/database.php';
require_once __DIR__ . '/../../app/models/AnneeAcademique.php';
require_once __DIR__ . '/../../app/models/NiveauEtude.php';
require_once __DIR__ . '/../../app/models/Etudiant.php';

$pdo = Database::getConnection();
$anneeAcademiqueModel = new AnneeAcademique($pdo);
$listeAnnees = $anneeAcademiqueModel->getAllAnneeAcademiques();
$niveauEtudeModel = new NiveauEtude($pdo);
$listeNiveaux = $niveauEtudeModel->getAllNiveauxEtudes();
$etudiantModel = new Etudiant($pdo);
$etudiants = $etudiantModel->getAllListeEtudiants();

// Récupération des filtres
$search = isset($_GET['search']) ? strtolower(trim($_GET['search'])) : '';
$promotion = isset($_GET['promotion']) ? $_GET['promotion'] : '';
$niveau = isset($_GET['niveau']) ? $_GET['niveau'] : '';

// Filtrage des étudiants
$filteredEtudiants = array_filter($etudiants, function($etudiant) use ($search, $promotion, $niveau) {
    // Recherche texte (nom, prénom, email)
    $matchesSearch = $search === '' ||
        (isset($etudiant->nom_etu) && strpos(strtolower($etudiant->nom_etu), $search) !== false) ||
        (isset($etudiant->prenom_etu) && strpos(strtolower($etudiant->prenom_etu), $search) !== false) ||
        (isset($etudiant->email_etu) && strpos(strtolower($etudiant->email_etu), $search) !== false);
    // Filtre promotion (année académique)
    $matchesPromotion = $promotion === '' || (isset($etudiant->id_annee_acad) && $etudiant->id_annee_acad == $promotion);
    // Filtre niveau
    $matchesNiveau = $niveau === '' || (isset($etudiant->id_niv_etude) && $etudiant->id_niv_etude == $niveau);
    // On applique tous les filtres activés (recherche ET (promotion si choisi) ET (niveau si choisi))
    return $matchesSearch && $matchesPromotion && $matchesNiveau;
});

// Pagination
$etudiantsParPage = 10;
$p = isset($_GET['p']) && is_numeric($_GET['p']) && $_GET['p'] > 0 ? (int)$_GET['p'] : 1;
$totalEtudiants = count($filteredEtudiants);
$totalPages = max(1, ceil($totalEtudiants / $etudiantsParPage));
$p = min($p, $totalPages); // éviter page trop grande
$offset = ($p - 1) * $etudiantsParPage;
$etudiantsPage = array_slice($filteredEtudiants, $offset, $etudiantsParPage);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants MIAGE</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>

<body class="bg-green-50 min-h-screen">
    <div class="flex flex-col min-h-screen">
        <!-- Header premium -->
        <header class="w-full flex justify-center mt-8 mb-6">
            <div class="max-w-5xl w-full mx-auto bg-green-200 rounded-2xl shadow-lg px-8 py-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4 border border-green-300">
                <div class="flex items-center gap-4">
                    <span class="text-green-800 text-xl md:text-2xl font-bold tracking-tight"><i class="fa-solid fa-users mr-2 text-green-600"></i>Liste des Étudiants <span class="text-green-700">MIAGE</span></span>
                    <span class="ml-4 bg-green-500 text-white text-xs font-semibold px-3 py-1 rounded-full shadow">Total : <span id="totalEtudiants"><?php echo $totalEtudiants; ?></span></span>
                </div>
                <form method="get" class="flex flex-wrap gap-2 items-center mt-2 md:mt-0">
                    <?php if (isset($_GET['p'])): ?>
                    <input type="hidden" name="p" value="<?= htmlspecialchars($_GET['p']) ?>">
                    <?php endif; ?>
                    <?php if (isset($_GET['page'])): ?>
                    <input type="hidden" name="page" value="<?= htmlspecialchars($_GET['page']) ?>">
                    <?php endif; ?>
                    <div class="relative">
                        <input type="text" name="search" placeholder="Rechercher par nom, prénom ou email..." class="pl-10 pr-3 py-2 rounded-lg border border-green-300 bg-green-50 focus:ring-2 focus:ring-green-400 focus:border-green-400 text-green-900 placeholder-green-400 shadow-sm outline-none text-sm w-44" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-green-400 pointer-events-none"></i>
                    </div>
                    <select name="promotion" class="px-3 py-2 rounded-lg border border-green-300 bg-green-50 text-green-700 text-sm focus:ring-2 focus:ring-green-400 focus:border-green-400">
                        <option value="">Toutes les Années Académiques</option>
                        <?php foreach ($listeAnnees as $annee): ?>
                        <option value="<?= htmlspecialchars($annee->id_annee_acad) ?>" <?php if(isset($_GET['promotion']) && $_GET['promotion'] == $annee->id_annee_acad) echo 'selected'; ?>><?= htmlspecialchars(date('Y', strtotime($annee->date_deb)) . '-' . date('Y', strtotime($annee->date_fin))) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="niveau" class="px-3 py-2 rounded-lg border border-green-300 bg-green-50 text-green-700 text-sm focus:ring-2 focus:ring-green-400 focus:border-green-400">
                        <option value="">Tous les Niveaux</option>
                        <?php foreach ($listeNiveaux as $niv): ?>
                        <option value="<?= htmlspecialchars($niv->id_niv_etude) ?>" <?php if(isset($_GET['niveau']) && $_GET['niveau'] == $niv->id_niv_etude) echo 'selected'; ?>><?= htmlspecialchars($niv->lib_niv_etude) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="px-4 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-white font-semibold flex items-center gap-2 shadow transition-colors"><i class="fa-solid fa-filter"></i> Filtrer</button>
                </form>
            </div>
        </header>
        <!-- Table premium -->
        <main class="flex-1 flex flex-col items-center">
            <div class="w-full max-w-5xl mx-auto bg-white rounded-2xl shadow-xl p-6 md:p-10 border border-green-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-green-700 flex items-center gap-2"><i class="fa-solid fa-list-check text-green-600"></i> Liste des étudiants</h2>
                        <p class="text-green-500 text-sm mt-1">Consultez, filtrez et recherchez les étudiants de la filière.</p>
                    </div>
                </div>
                <div class="overflow-x-auto rounded-xl shadow-sm border border-green-100">
                    <table class="min-w-full bg-white rounded-xl text-green-900">
                        <thead class="sticky top-0 z-10">
                            <tr>
                                <th class="px-4 py-4 bg-green-50 text-green-700 font-bold text-left text-base whitespace-nowrap border-b border-green-200"><i class="fa-solid fa-user-graduate mr-2 text-green-600"></i>Nom</th>
                                <th class="px-4 py-4 bg-green-50 text-green-700 font-bold text-left text-base whitespace-nowrap border-b border-green-200"><i class="fa-solid fa-user mr-2 text-green-600"></i>Prénom</th>
                                <th class="px-4 py-4 bg-green-50 text-green-700 font-bold text-left text-base whitespace-nowrap border-b border-green-200"><i class="fa-solid fa-envelope mr-2 text-green-600"></i>Email</th>
                                <th class="px-4 py-4 bg-green-50 text-green-700 font-bold text-left text-base whitespace-nowrap border-b border-green-200"><i class="fa-solid fa-calendar mr-2 text-green-600"></i>Promotion</th>
                                <th class="px-4 py-4 bg-green-50 text-green-700 font-bold text-left text-base whitespace-nowrap border-b border-green-200"><i class="fa-solid fa-layer-group mr-2 text-green-600"></i>Niveau</th>
                                <th class="px-4 py-4 bg-green-50 text-green-700 font-bold text-left text-base whitespace-nowrap border-b border-green-200"><i class="fa-solid fa-cake-candles mr-2 text-green-600"></i>Date de Naissance</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-green-50">
                            <?php
if (empty($etudiantsPage)) {
    echo '<tr><td colspan="6" class="text-center text-green-400 py-8">Aucun étudiant trouvé pour votre recherche.</td></tr>';
} else {
    foreach ($etudiantsPage as $etudiant) {
        echo '<tr class="hover:bg-green-50 transition bg-white">';
        echo '<td class="px-4 py-3 font-medium text-green-800 flex items-center gap-2 whitespace-nowrap">'.htmlspecialchars($etudiant->nom_etu ?? '').'</td>';
        echo '<td class="px-4 py-3 text-green-900 whitespace-nowrap">'.htmlspecialchars($etudiant->prenom_etu ?? '').'</td>';
        echo '<td class="px-4 py-3 text-green-600 whitespace-nowrap">'.htmlspecialchars($etudiant->email_etu ?? '').'</td>';
        echo '<td class="px-4 py-3 text-green-700 whitespace-nowrap">'.(isset($etudiant->date_deb, $etudiant->date_fin) ? htmlspecialchars(date('Y', strtotime($etudiant->date_deb)) . '-' . date('Y', strtotime($etudiant->date_fin))) : '').'</td>';
        echo '<td class="px-4 py-3 text-green-700 whitespace-nowrap">'.htmlspecialchars($etudiant->lib_niv_etude ?? '').'</td>';
        echo '<td class="px-4 py-3 text-green-700 whitespace-nowrap">'.htmlspecialchars($etudiant->date_naiss_etu ?? '').'</td>';
        echo '</tr>';
    }
}
?>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                <nav class="flex justify-center mt-6">
                    <ul class="inline-flex items-center -space-x-px">
                        <li>
                            <a href="?<?php
                                $params = $_GET;
                                $params['p'] = max(1, $p - 1);
                                if (isset($_GET['page'])) $params['page'] = $_GET['page'];
                                echo http_build_query($params);
                            ?>"
                                class="px-3 py-2 ml-0 leading-tight text-green-600 bg-white border border-green-300 rounded-l-lg hover:bg-green-50 hover:text-green-700 <?php if($p == 1) echo 'pointer-events-none opacity-50'; ?>">
                                Précédent
                            </a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li>
                            <a href="?<?php
                                $params = $_GET;
                                $params['p'] = $i;
                                if (isset($_GET['page'])) $params['page'] = $_GET['page'];
                                echo http_build_query($params);
                            ?>"
                                class="px-3 py-2 leading-tight border border-green-300 <?php echo $i == $p ? 'bg-green-600 text-white' : 'bg-white text-green-600 hover:bg-green-50 hover:text-green-700'; ?>">
                                <?= $i ?>
                            </a>
                        </li>
                        <?php endfor; ?>
                        <li>
                            <a href="?<?php
                                $params = $_GET;
                                $params['p'] = min($totalPages, $p + 1);
                                if (isset($_GET['page'])) $params['page'] = $_GET['page'];
                                echo http_build_query($params);
                            ?>"
                                class="px-3 py-2 leading-tight text-green-600 bg-white border border-green-300 rounded-r-lg hover:bg-green-50 hover:text-green-700 <?php if($p == $totalPages) echo 'pointer-events-none opacity-50'; ?>">
                                Suivant
                            </a>
                        </li>
                    </ul>
                </nav>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>

</html>