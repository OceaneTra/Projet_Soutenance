<?php
// Traitement du formulaire directement dans la vue - solution simple pour déboguer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($message) && !isset($error)) {
    $dateDebut = $_POST['date_deb'] ?? '';
    $dateFin = $_POST['date_fin'] ?? '';

    // Validation des données
    if (empty($dateDebut) || empty($dateFin)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        try {
            // Utiliser l'instance de AnneeAcademique à partir du contrôleur
            global $pdo;
            $anneeAcademiqueModel = new AnneeAcademique($pdo);
            $result = $anneeAcademiqueModel->addAnneeAcademique($dateDebut, $dateFin);

            if ($result) {
                $message = "Année académique ajoutée avec succès.";
                // Actualiser la liste des années
                $annees = $anneeAcademiqueModel->getAllAnneeAcademiques();
            } else {
                $error = "Erreur lors de l'ajout de l'année académique.";
            }
        } catch (Exception $e) {
            $error = "Exception: " . $e->getMessage();
        }
    }
}

?>
<div class="min-h-screen flex flex-col">
    <main class="flex-grow container mx-auto px-4 py-8">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold">Gestion des Années Académiques</h2>
            <a href="?route=admin/dashboard" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded">Retour</a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p><?= $message ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p><?= $error ?></p>
            </div>
        <?php endif; ?>

        <!-- Formulaire d'ajout -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-xl font-semibold mb-4">Ajouter une année académique</h3>
            <form method="POST" action="?route=admin/parametres/annee-academique">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="date_deb" class="block text-sm font-medium text-gray-700 mb-1">Date début</label>
                        <input type="date" id="date_deb" name="date_deb" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-1">Date fin</label>
                        <input type="date" id="date_fin" name="date_fin" class="w-full px-3 py-2 border border-gray-300 rounded-md" required>
                    </div>
                </div>
                <button type="submit" class="mt-2 w-full inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-green-500 hover:bg-green-600">
                    Ajouter
                </button>
            </form>
        </div>

        <!-- Tableau des années académiques -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Année académique</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <?php
                $req = $this->pdo->query("SELECT * FROM annee_academique ORDER BY date_deb DESC");
                $req->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($req)) {
                    foreach ($req as $annee): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?= htmlspecialchars($annee['id_annee_acad']) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('Y', strtotime($annee['date_deb'])) . '-' . date('Y', strtotime($annee['date_fin'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="?route=admin/parametres/annees-academiques/modifier/<?= $annee['id_annee_acad'] ?>" class="text-indigo-600 hover:text-indigo-900 mr-2">Modifier</a>
                                <a href="?route=admin/parametres/annees-academiques/supprimer/<?= $annee['id_annee_acad'] ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette année académique ?')">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach;
                } else { ?>
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-sm text-gray-500 text-center">Aucune année académique trouvée</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </main>
</div>