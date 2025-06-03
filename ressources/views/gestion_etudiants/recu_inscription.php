<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
}

.receipt-box {
    border: 1px solid #000;
    padding: 20px;
    width: 600px;
    margin: 20px auto;
}

.header {
    display: flex;
    /* Use flexbox for header layout */
    align-items: center;
    justify-content: space-between;
    /* Space out the items */
    margin-bottom: 20px;
    border-bottom: 2px solid #000;
    /* Add a bottom border like in the image */
    padding-bottom: 10px;
}

.header img {
    height: 60px;
    /* Adjust logo size */
    width: auto;
}

.header .university-info {
    flex-grow: 1;
    /* Allow this section to take up available space */
    text-align: center;
    margin: 0 20px;
    /* Add some space between logos and text */
}

.header h2,
.header h3 {
    margin: 0;
    font-size: 1.2em;
}

.header p {
    margin: 2px 0;
    font-size: 0.9em;
}

.receipt-number {
    font-size: 1.5em;
    font-weight: bold;
    color: #e74c3c;
    /* Red color like in the image */
}

.info-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.info-table td {
    padding: 5px 0;
    border-bottom: 1px dashed #ccc;
}

.info-table td:first-child {
    font-weight: bold;
    width: 180px;
    /* Adjust width for labels */
}

.amount-text {
    font-style: italic;
    margin-top: 5px;
    /* Adjust margin */
    display: block;
    /* Make it a block element */
    text-align: left;
    /* Align left */
}

.footer-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 30px;
}

.footer-table td {
    padding: 5px 0;
}

.footer-table td:first-child {
    width: 50%;
    /* Distribute space */
}

.footer-table td:last-child {
    text-align: right;
}

.signature {
    margin-top: 50px;
    /* Increase margin */
    text-align: center;
}

.signature p {
    margin: 0;
    border-top: 1px solid #000;
    display: inline-block;
    padding: 5px 20px;
    /* Add padding around signature line */
}

.note {
    text-align: center;
    font-size: 0.8em;
    margin-top: 30px;
    /* Increase margin */
}
</style>
<div class="receipt-box">
    <div class="header">
        <div>
            <img src="/images/logo.png" alt="Logo Université">
        </div>
        <div class="university-info">
            <!-- Vous pouvez ajouter ici le nom complet de l'université -->
            <h2>UNIVERSITE FELIX HOUPHOUET-BOIGNY</h2>
            <p>FILIERES PROFESSIONNALISEES, UFR MI</p>
            <p>22 B.P. 582 Abidjan 22</p>
            <p>Tél. (Fax): 27 22 41 05 74 / 27 22 48 01 80</p>
            <p>Cel: 07 07 89 94 26 / 07 07 69 15 04</p>
        </div>
        <div>
            <img src="/images/logo_mathInfo_fond_blanc.png" alt="Logo MathInfo">
        </div>
    </div>

    <h3 style="text-align: center; margin-bottom: 20px;">REÇU <span class="receipt-number">Nº
            <?php echo htmlspecialchars($inscription['numero_recu'] ?? 'N/A'); ?></span></h3>

    <table class="info-table">
        <tr>
            <td>Reçu de M/Mme :</td>
            <td><?php echo htmlspecialchars(($etudiant['nom_etu'] ?? '') . ' ' . ($etudiant['prenom_etu'] ?? '')); ?>
            </td>
        </tr>
        <tr>
            <td>La somme de :</td>
            <td><?php echo htmlspecialchars(number_format($inscription['montant_premier_versement'] ?? 0, 0, ',', ' ')); ?>
                FCFA</td>
        </tr>
        <tr>
            <td colspan="2" class="amount-text">(en toutes lettres : [Montant en toutes lettres - TODO: Implement
                function to convert number to French words])</td>
        </tr>
        <tr>
            <td>En règlement de :</td>
            <td>Scolarité Année Académique
                <?php echo htmlspecialchars(date('Y', strtotime($anneeAcademique['date_deb'] ?? 'now')) . ' - ' . date('Y', strtotime($anneeAcademique['date_fin'] ?? 'now'))); ?>
                - <?php echo htmlspecialchars($niveau['lib_niv_etude'] ?? 'N/A'); ?></td>
        </tr>
        <tr>
            <td>Année d\'Études :</td>
            <td><?php echo htmlspecialchars($niveau['lib_niv_etude'] ?? 'N/A'); ?></td>
        </tr>
    </table>

    <table class="footer-table">
        <tr>
            <td>Espèces: <?php echo (($inscription['methode_paiement'] ?? '') === 'Espèce' ? 'X' : ' '); ?> Chèque n°:
                <?php echo htmlspecialchars($inscription['numero_cheque'] ?? ''); ?></td>
            <td>Date:
                <?php echo htmlspecialchars(date('d/m/Y', strtotime($inscription['date_inscription'] ?? 'now'))); ?>
            </td>
        </tr>
        <tr>
            <td>Reste à payer :</td>
            <td><?php echo htmlspecialchars(number_format($inscription['reste_payer'] ?? 0, 0, ',', ' ')); ?> FCFA</td>
        </tr>
        <tr>
            <td>Montant prochain versement :</td>
            <td>[Montant prochain versement - TODO: Calculate based on tranches]</td>
        </tr>
        <tr>
            <td>Date prochain versement :</td>
            <td>[Date prochain versement - TODO: Calculate based on tranches]</td>
        </tr>
    </table>

    <div class="signature">
        <p>Signature et cachet</p>
    </div>

    <p class="note">N.B.: Aucun remboursement n'est possible après versement</p>

</div>