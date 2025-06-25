<?php
if (isset($_GET['page']) && $_GET['page'] === 'verification_candidatures_soutenance') {

    require_once __DIR__ . '/../../app/controllers/VerificationRapportsController.php';
    $controller = new VerificationRapportsController();
    
    // Gérer les actions PHP (formulaires)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['valider']) && isset($_POST['id_rapport'])) {
            $_POST['commentaire'] = $_POST['commentaire'] ?? '';
            $_POST['id_rapport'] = (int)$_POST['id_rapport'];
            $result = $controller->validerRapport();
            $_SESSION['message'] = $result['message'] ?? '';
            header('Location: ?page=verification_candidatures_soutenance');
            exit;
        }
        if (isset($_POST['rejeter']) && isset($_POST['id_rapport'])) {
            $_POST['commentaire'] = $_POST['commentaire'] ?? '';
            $_POST['id_rapport'] = (int)$_POST['id_rapport'];
            $result = $controller->rejeterRapport();
            $_SESSION['message'] = $result['message'] ?? '';
            header('Location: ?page=verification_candidatures_soutenance');
            exit;
        }
    }
    
    // Gérer les actions AJAX
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'detail':
                $id = $_GET['id'] ?? 0;
                if ($id) {
                    $rapport = $controller->getRapportDetail($id);
                    if ($rapport) {
                        echo '<div class="space-y-4">';
                        echo '<div class="grid grid-cols-2 gap-4">';
                        echo '<div><strong>Étudiant:</strong> ' . htmlspecialchars($rapport->nom_etu . ' ' . $rapport->prenom_etu) . '</div>';
                        echo '<div><strong>Email:</strong> ' . htmlspecialchars($rapport->email_etu) . '</div>';
                        echo '<div><strong>Nom du rapport:</strong> ' . htmlspecialchars($rapport->nom_rapport) . '</div>';
                        echo '<div><strong>Thème:</strong> ' . htmlspecialchars($rapport->theme_rapport) . '</div>';
                        echo '<div><strong>Date d\'envoi:</strong> ' . date('d/m/Y H:i', strtotime($rapport->date_rapport)) . '</div>';
                        echo '<div><strong>Statut:</strong> ' . htmlspecialchars($rapport->statut_rapport) . '</div>';
                        echo '</div>';
                        // Afficher le contenu du rapport s\'il existe
                        $chemin = $rapport->chemin_fichier;
                        if (empty($chemin)) {
                            $chemin = 'rapport_' . $rapport->id_rapport . '.html';
                        }
                        $fichierContenu = __DIR__ . "/../uploads/rapports/" . $chemin;
                        if (file_exists($fichierContenu)) {
                            echo '<div class="mt-6">';
                            echo '<h4 class="font-bold text-lg mb-3">Contenu du rapport:</h4>';
                            echo '<div class="border border-gray-200 rounded-lg p-4 max-h-96 overflow-y-auto">';
                            echo file_get_contents($fichierContenu);
                            echo '</div>';
                            echo '</div>';
                        } else {
                            echo '<div class="mt-6 text-gray-500">Aucun contenu disponible pour ce rapport.</div>';
                        }
                        echo '</div>';
                    } else {
                        echo '<div class="text-red-500">Rapport non trouvé.</div>';
                    }
                } else {
                    echo '<div class="text-red-500">ID du rapport manquant.</div>';
                }
                exit;
        }
    }
    
    // Action par défaut : afficher la liste
    $controller->index();
} 