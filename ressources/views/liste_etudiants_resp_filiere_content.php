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
</head>

<body class="p-4 sm:p-6 md:p-8">
    <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden md:p-8 p-6">
        <h1 class=" text-4xl font-bold text-gray-900 mb-6 text-center s">Liste des Étudiants <span
                class="text-emerald-600">MIAGE</span></h1>

        <!-- Section de recherche et de filtres -->
        <form method="get" class="mb-6 flex flex-wrap gap-4 items-center">
            <?php if (isset($_GET['p'])): ?>
            <input type="hidden" name="p" value="<?= htmlspecialchars($_GET['p']) ?>">
            <?php endif; ?>
            <?php if (isset($_GET['page'])): ?>
            <input type="hidden" name="page" value="<?= htmlspecialchars($_GET['page']) ?>">
            <?php endif; ?>
            <input type="text" name="search" placeholder="Rechercher par nom, prénom ou email..."
                class="flex-1 min-w-[200px] p-3 pl-4 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-gray-700 shadow-sm md:text-base text-sm"
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

            <select name="promotion"
                class="p-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-gray-700 shadow-sm md:text-base text-sm">
                <option value="">Toutes les Années Académiques</option>
                <?php foreach ($listeAnnees as $annee): ?>
                <option value="<?= htmlspecialchars($annee->id_annee_acad) ?>"
                    <?php if(isset($_GET['promotion']) && $_GET['promotion'] == $annee->id_annee_acad) echo 'selected'; ?>>
                    <?= htmlspecialchars(date('Y', strtotime($annee->date_deb)) . '-' . date('Y', strtotime($annee->date_fin))) ?>
                </option>
                <?php endforeach; ?>
            </select>

            <select name="niveau"
                class="p-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-gray-700 shadow-sm md:text-base text-sm">
                <option value="">Tous les Niveaux</option>
                <?php foreach ($listeNiveaux as $niv): ?>
                <option value="<?= htmlspecialchars($niv->id_niv_etude) ?>"
                    <?php if(isset($_GET['niveau']) && $_GET['niveau'] == $niv->id_niv_etude) echo 'selected'; ?>>
                    <?= htmlspecialchars($niv->lib_niv_etude) ?>
                </option>
                <?php endforeach; ?>
            </select>

            <button type="submit"
                class="p-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">Filtrer</button>
        </form>

        <!-- Conteneur pour la liste des étudiants (tableau) -->
        <div id="studentListContainer" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">
                            Nom
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Prénom
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Promotion
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Niveau
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date de Naissance
                        </th>

                    </tr>
                </thead>
                <tbody id="studentTableBody" class="bg-white divide-y divide-gray-200">
                    <?php
if (empty($etudiantsPage)) {
    echo '<tr><td colspan="6" class="text-center text-gray-500 py-8">Aucun étudiant trouvé pour votre recherche.</td></tr>';
} else {
    foreach ($etudiantsPage as $etudiant) {
        echo '<tr class="table-row-hover">';
        echo '<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 rounded-bl-lg">'.htmlspecialchars($etudiant->nom_etu ?? '').'</td>';
        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">'.htmlspecialchars($etudiant->prenom_etu ?? '').'</td>';
        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-emerald-600 hover:text-emerald-800">'.htmlspecialchars($etudiant->email_etu ?? '').'</td>';
        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">'.(isset($etudiant->date_deb, $etudiant->date_fin) ? htmlspecialchars(date('Y', strtotime($etudiant->date_deb)) . '-' . date('Y', strtotime($etudiant->date_fin))) : '').'</td>';
        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">'.htmlspecialchars($etudiant->lib_niv_etude ?? '').'</td>';
        echo '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">'.htmlspecialchars($etudiant->date_naiss_etu ?? '').'</td>';
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
                <!-- Précédent -->
                <li>
                    <a href="?<?php
                        $params = $_GET;
                        $params['p'] = max(1, $p - 1);
                        if (isset($_GET['page'])) $params['page'] = $_GET['page'];
                        echo http_build_query($params);
                    ?>"
                        class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 <?php if($p == 1) echo 'pointer-events-none opacity-50'; ?>">
                        Précédent
                    </a>
                </li>
                <!-- Numéros de page -->
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li>
                    <a href="?<?php
                        $params = $_GET;
                        $params['p'] = $i;
                        if (isset($_GET['page'])) $params['page'] = $_GET['page'];
                        echo http_build_query($params);
                    ?>"
                        class="px-3 py-2 leading-tight border border-gray-300 <?php echo $i == $p ? 'bg-emerald-600 text-white' : 'bg-white text-gray-500 hover:bg-gray-100 hover:text-gray-700'; ?>">
                        <?= $i ?>
                    </a>
                </li>
                <?php endfor; ?>
                <!-- Suivant -->
                <li>
                    <a href="?<?php
                        $params = $_GET;
                        $params['p'] = min($totalPages, $p + 1);
                        if (isset($_GET['page'])) $params['page'] = $_GET['page'];
                        echo http_build_query($params);
                    ?>"
                        class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 <?php if($p == $totalPages) echo 'pointer-events-none opacity-50'; ?>">
                        Suivant
                    </a>
                </li>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</body>

</html>