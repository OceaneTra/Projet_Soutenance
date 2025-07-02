<?php

require_once __DIR__ . '/../models/Valider.php';
require_once __DIR__ . '/../models/CompteRendu.php';
require_once __DIR__ . '/../../vendor/autoload.php';
use Dompdf\Dompdf;

class RedactionCompteRenduController {
    public function index() {
        $GLOBALS['rapports_valides'] = Valider::getRapportsValides();
        // Ne pas inclure la vue ici, le layout s'en charge
    }

    public function enregistrer() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $num_etu = $_POST['num_etu'] ?? null;
            $nom_CR = $_POST['nom_CR'] ?? '';
            $contenu_CR = $_POST['contenu_CR'] ?? '';
            $rapports = isset($_POST['rapports']) ? $_POST['rapports'] : [];
            $date_CR = date('Y-m-d H:i:s');

            if (empty($num_etu)) {
                $_SESSION['error'] = "Aucun étudiant sélectionné.";
                header('Location: layout.php?page=redaction_compte_rendu');
                exit;
            }

            // TEST MINIMAL POUR LES IMAGES
            $basePath = realpath(__DIR__ . '/../../public/');
            $html = '<img src="images/FHB.png">';
            $dompdf = new Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setBasePath($basePath);
            $dompdf->render();
            $output = $dompdf->output();

            // Sauvegarde du PDF
            $pdf_dir = __DIR__ . '/../../ressources/uploads/comptes_rendus/';
            if (!is_dir($pdf_dir)) mkdir($pdf_dir, 0777, true);
            $pdf_name = 'CR_' . date('Ymd_His') . '.pdf';
            $pdf_path = $pdf_dir . $pdf_name;
            file_put_contents($pdf_path, $output);
            $chemin_pdf = 'ressources/uploads/comptes_rendus/' . $pdf_name;

            // Enregistrement en BD
            $id_CR = CompteRendu::creer($num_etu, $nom_CR, $contenu_CR, $chemin_pdf, $date_CR, $rapports);
            if ($id_CR) {
                $_SESSION['success'] = 'Compte rendu enregistré avec succès !';
            } else {
                $_SESSION['error'] = 'Erreur lors de l\'enregistrement du compte rendu.';
            }
            header('Location: layout.php?page=redaction_compte_rendu');
            exit;
        }
    }
} 