<?php if (!empty($GLOBALS['selectedStudent'])): ?>
<div id="releve-notes">
    <div class="bg-white rounded-lg shadow p-8 border border-gray-300 mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <img src="public/images/ufhb_logo.png" alt="Logo UFHB" style="height:60px;">
            </div>
            <div class="text-center">
                <h2 class="text-xl font-bold">REPUBLIQUE DE COTE D'IVOIRE</h2>
                <div class="text-sm">MINISTERE CHARGE DE L'ENSEIGNEMENT SUPERIEUR<br>DE LA RECHERCHE SCIENTIFIQUE</div>
                <div class="text-lg font-semibold mt-2">RELEVE DE NOTES</div>
                <div class="text-sm">Année universitaire : 2023-2024</div>
            </div>
            <div>
                <img src="public/images/miage_logo.png" alt="Logo MIAGE" style="height:60px;">
            </div>
        </div>
        <div class="mb-4">
            <strong>Nom :</strong> <?= htmlspecialchars($GLOBALS['selectedStudent']->nom_etu) ?><br>
            <strong>Prénoms :</strong> <?= htmlspecialchars($GLOBALS['selectedStudent']->prenom_etu) ?><br>
            <strong>Date de naissance :</strong>
            <?= htmlspecialchars($GLOBALS['selectedStudent']->date_naiss_etu)?>
            <strong>Parcours :</strong> MIAGE<br>
            <strong>Niveau :</strong> <?= htmlspecialchars($GLOBALS['niveau']->lib_niv_etude) ?><br>
            <strong>Numéro étudiant :</strong> <?= htmlspecialchars($GLOBALS['selectedStudent']->num_etu) ?><br>
        </div>
        <hr class="my-4">
        <!-- Tableau des notes -->
        <table class="w-full text-sm mb-6" border="1" cellspacing="0" cellpadding="4">
            <thead class="bg-gray-100">
                <tr>
                    <th>Code</th>
                    <th>UE/ECUE</th>
                    <th>Coef</th>
                    <th>Moyenne</th>
                    <th>Crédits</th>
                </tr>
            </thead>
            <tbody>
                <?php
            $sumMaj = $sumMin = $credMaj = $credMin = 0;
            foreach ($GLOBALS['studentGrades'] as $grade) {
                $isMaj = $grade->credit > 3;
                if ($isMaj) {
                    $sumMaj += $grade->moyenne * $grade->credit;
                    $credMaj += $grade->credit;
                } else {
                    $sumMin += $grade->moyenne * $grade->credit;
                    $credMin += $grade->credit;
                }
                $code = isset($grade->code_ecue) && $grade->code_ecue ? $grade->code_ecue : (isset($grade->code_ue) && $grade->code_ue ? $grade->code_ue : '-');
                echo '<tr>';
                echo '<td>' . htmlspecialchars($code ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($grade->lib_ue ?? $grade->lib_ecue ?? '-') . '</td>';
                echo '<td class="text-center">' . htmlspecialchars($grade->credit ?? '-') . '</td>';
                echo '<td class="text-center">' . htmlspecialchars(isset($grade->moyenne) ? number_format($grade->moyenne,2) : '-') . '</td>';
                echo '<td class="text-center">' . htmlspecialchars($grade->credit ?? '-') . '</td>';
                echo '</tr>';
            }
            $moyMaj = $credMaj ? round($sumMaj / $credMaj, 2) : '-';
            $moyMin = $credMin ? round($sumMin / $credMin, 2) : '-';
            ?>
            </tbody>
        </table>
        <div class="mb-2">
            <strong>Moyenne UE majeures :</strong> <?= $moyMaj ?>
            &nbsp;|&nbsp;
            <strong>Moyenne UE mineures :</strong> <?= $moyMin ?>
        </div>
        <div class="mb-2">
            <strong>Moyenne générale :</strong> <?php
                $totalNotes = 0; $totalCredits = 0;
                foreach ($GLOBALS['studentGrades'] as $grade) {
                    $totalNotes += $grade->moyenne * $grade->credit;
                    $totalCredits += $grade->credit;
                }
                echo $totalCredits > 0 ? number_format($totalNotes / $totalCredits, 2) : '0.00';
            ?>
        </div>
        <div class="mb-2">
            <strong>Crédits validés :</strong> <?php
                $creditsValides = 0;
                foreach ($GLOBALS['studentGrades'] as $grade) {
                    if ($grade->moyenne >= 10) {
                        $creditsValides += $grade->credit;
                    }
                }
                echo $creditsValides;
            ?>
        </div>
        <div class="mt-6 flex justify-between">
            <div>
                <div class="text-xs">Fait à Abidjan, le <?= date('d/m/Y') ?></div>
                <div class="text-xs mt-2">Signature du responsable</div>
            </div>
            <div class="text-xs text-right">
                <div>Cachet de l'établissement</div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<style>
@media print {
    body * {
        visibility: hidden;
    }

    #releve-notes,
    #releve-notes * {
        visibility: visible;
    }

    #releve-notes {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        background: white;
    }

    .no-print {
        display: none !important;
    }
}
</style>