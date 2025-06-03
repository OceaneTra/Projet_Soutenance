<?php
// Initialisation des variables avec des valeurs par défaut
$etudiantsInscrits = isset($GLOBALS['etudiantsInscrits']) ? $GLOBALS['etudiantsInscrits'] : [];

// Calcul des statistiques
$totalEtudiants = count($etudiantsInscrits);
$complete = 0;
$partial = 0;
$pending = 0;

foreach ($etudiantsInscrits as $etudiant) {
    $montant_total = isset($etudiant['montant_scolarite']) ? $etudiant['montant_scolarite'] : 0;
    $reste_a_payer = isset($etudiant['montant_inscription']) ? $etudiant['montant_inscription'] : 0;
    $montant_payer = $montant_total - $reste_a_payer;

    if ($montant_payer >= $montant_total) {
        $complete++;
    } elseif ($montant_payer > 0) {
        $partial++;
    } else {
        $pending++;
    }
}

$pourcentageComplete = $totalEtudiants > 0 ? round(($complete / $totalEtudiants) * 100) : 0;
$pourcentagePartial = $totalEtudiants > 0 ? round(($partial / $totalEtudiants) * 100) : 0;
$pourcentagePending = $totalEtudiants > 0 ? round(($pending / $totalEtudiants) * 100) : 0;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Scolarité | Scolarité</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hover-scale {
        transition: transform 0.3s ease;
    }

    .hover-scale:hover {
        transform: scale(1.03);
    }

    .sidebar-item.active {
        background-color: #e6f7ff;
        border-left: 4px solid #3b82f6;
        color: #3b82f6;
    }

    .sidebar-item.active i {
        color: #3b82f6;
    }

    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <!-- Système de notification -->
    <?php if (isset($GLOBALS['messageSuccess']) && !empty($GLOBALS['messageSuccess'])): ?>
    <div id="successNotification" class="fixed top-4 right-4 z-50 animate__animated animate__fadeIn">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-lg flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium"><?= htmlspecialchars($GLOBALS['messageSuccess']) ?></p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-auto pl-3">
                <i class="fas fa-times text-green-500 hover:text-green-700"></i>
            </button>
        </div>
    </div>
    <?php endif; ?>

    <?php if (isset($GLOBALS['messageErreur']) && !empty($GLOBALS['messageErreur'])): ?>
    <div id="errorNotification" class="fixed top-4 right-4 z-50 animate__animated animate__fadeIn">
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-lg flex items-center">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium"><?= htmlspecialchars($GLOBALS['messageErreur']) ?></p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-auto pl-3">
                <i class="fas fa-times text-red-500 hover:text-red-700"></i>
            </button>
        </div>
    </div>
    <?php endif; ?>
    <div class="flex h-screen overflow-hidden">
        <!-- Main content area -->
        <div class="flex-1 p-4 md:p-6 overflow-y-auto">
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Gestion des paiements</h1>
                        <p class="text-gray-600">Suivi des paiements de scolarité</p>
                    </div>

                </div>

                <!-- Payment status cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white p-4 rounded-lg shadow-sm hover-scale">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Paiements complets</p>
                                <p class="text-2xl font-bold text-gray-800"><?php echo $complete; ?></p>
                                <p class="text-xs text-gray-500"><?php echo $pourcentageComplete; ?>% des étudiants</p>
                            </div>
                            <div class="p-3 rounded-full bg-green-100 text-green-500">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-sm hover-scale">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Paiements partiels</p>
                                <p class="text-2xl font-bold text-gray-800"><?php echo $partial; ?></p>
                                <p class="text-xs text-gray-500"><?php echo $pourcentagePartial; ?>% des étudiants</p>
                            </div>
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                                <i class="fas fa-exclamation-circle text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-lg shadow-sm hover-scale">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">En attente</p>
                                <p class="text-2xl font-bold text-gray-800"><?php echo $pending; ?></p>
                                <p class="text-xs text-gray-500"><?php echo $pourcentagePending; ?>% des étudiants</p>
                            </div>
                            <div class="p-3 rounded-full bg-red-100 text-red-500">
                                <i class="fas fa-times-circle text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment form -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">Enregistrer un versement</h2>
                    </div>
                    <div class="px-6 py-4">
                        <form id="paymentForm" method="POST"
                            action="?page=gestion_scolarite&action=enregistrer_versement">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="studentSelect"
                                        class="block text-sm font-medium text-gray-700 mb-1">Étudiant <span
                                            class="text-red-500">*</span></label>
                                    <select id="studentSelect" name="id_etudiant" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Sélectionner un étudiant...</option>
                                        <?php if (!empty($etudiantsInscrits)): ?>
                                        <?php foreach ($etudiantsInscrits as $etudiant): ?>
                                        <option value="<?php echo $etudiant['id_etudiant']; ?>"
                                            data-montant-total="<?php echo isset($etudiant['montant_scolarite']) ? $etudiant['montant_scolarite'] : 0; ?>"
                                            data-montant-paye="<?php echo isset($etudiant['montant_inscription']) ? $etudiant['montant_inscription'] : 0; ?>"
                                            data-reste-a-payer="<?php echo isset($etudiant['montant_scolarite']) && isset($etudiant['montant_inscription']) ? ($etudiant['montant_scolarite'] - $etudiant['montant_inscription']) : 0; ?>">
                                            <?php echo $etudiant['nom'] . ' ' . $etudiant['prenom']; ?> -
                                            <?php echo $etudiant['nom_niveau']; ?>
                                        </option>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div>
                                    <label for="paymentAmount"
                                        class="block text-sm font-medium text-gray-700 mb-1">Montant <span
                                            class="text-red-500">*</span></label>
                                    <div class="relative mt-1">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500">FCFA</span>
                                        </div>
                                        <input type="number" id="paymentAmount" name="montant" required
                                            class="block w-full pl-16 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="0">
                                    </div>
                                </div>
                                <div>
                                    <label for="paymentDate" class="block text-sm font-medium text-gray-700 mb-1">Date
                                        <span class="text-red-500">*</span></label>
                                    <input type="date" id="paymentDate" name="date_versement" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                        value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div>
                                    <label for="paymentMethod"
                                        class="block text-sm font-medium text-gray-700 mb-1">Méthode <span
                                            class="text-red-500">*</span></label>
                                    <select id="paymentMethod" name="methode_paiement" required
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Sélectionner une méthode de paiement</option>
                                        <option value="Espèce"
                                            <?php echo (isset($GLOBALS['versementAmodifier']) && isset($GLOBALS['versementAmodifier']['methode_paiement']) && $GLOBALS['versementAmodifier']['methode_paiement'] == 'Espèce') ? 'selected' : ''; ?>>
                                            Espèce</option>
                                        <option value="Carte bancaire"
                                            <?php echo (isset($GLOBALS['versementAmodifier']) && isset($GLOBALS['versementAmodifier']['methode_paiement']) && $GLOBALS['versementAmodifier']['methode_paiement'] == 'Carte bancaire') ? 'selected' : ''; ?>>
                                            Carte bancaire</option>
                                        <option value="Virement"
                                            <?php echo (isset($GLOBALS['versementAmodifier']) && isset($GLOBALS['versementAmodifier']['methode_paiement']) && $GLOBALS['versementAmodifier']['methode_paiement'] == 'Virement') ? 'selected' : ''; ?>>
                                            Virement</option>
                                        <option value="Chèque"
                                            <?php echo (isset($GLOBALS['versementAmodifier']) && isset($GLOBALS['versementAmodifier']['methode_paiement']) && $GLOBALS['versementAmodifier']['methode_paiement'] == 'Chèque') ? 'selected' : ''; ?>>
                                            Chèque</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-between">
                                <div></div>
                                <button type="submit" name="enregistrer_versement"
                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                    Enregistrer le versement
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Liste des versements -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-800">Liste des versements</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <!-- Table header -->
                        <div class="grid grid-cols-12 gap-4 px-6 py-3 bg-gray-50 text-sm font-medium text-gray-500">
                            <div class="col-span-3">Étudiant</div>
                            <div class="col-span-2">Montant versé</div>
                            <div class="col-span-2">Date versement</div>
                            <div class="col-span-2">Méthode</div>
                            <div class="col-span-2">Type versement</div>
                            <div class="col-span-1">Actions</div>
                        </div>

                        <!-- Payment rows -->
                        <?php if (!empty($GLOBALS['versements'])): ?>
                        <?php foreach ($GLOBALS['versements'] as $versement): ?>
                        <div class="grid grid-cols-12 gap-4 px-6 py-4 items-center">
                            <div class="col-span-3 flex items-center">
                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                    <i class="fas fa-user text-gray-500"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">
                                        <?php echo htmlspecialchars($versement['nom_etudiant'] . ' ' . $versement['prenom_etudiant']); ?>
                                    </p>
                                    <!-- Vous pouvez ajouter ici d'autres infos étudiant si nécessaires, ex: numéro -->
                                    <!-- <p class="text-xs text-gray-500"><?php // echo htmlspecialchars($versement['num_etu']); ?></p> -->
                                </div>
                            </div>
                            <div class="col-span-2 text-sm text-gray-800">
                                <?php echo htmlspecialchars(number_format($versement['montant'] ?? 0, 0, ',', ' ')); ?>
                                FCFA
                            </div>
                            <div class="col-span-2 text-sm text-gray-800">
                                <?php echo htmlspecialchars(date('d/m/Y', strtotime($versement['date_versement'] ?? 'now'))); ?>
                            </div>
                            <div class="col-span-2 text-sm text-gray-800">
                                <?php echo htmlspecialchars($versement['methode_paiement'] ?? 'N/A'); ?>
                            </div>
                            <div class="col-span-2 text-sm text-gray-800">
                                <?php echo htmlspecialchars($versement['type_versement'] ?? 'N/A'); ?>
                            </div>
                            <div class="col-span-1 flex justify-end space-x-2">
                                <!-- Les boutons d'action devront utiliser l'ID du versement ($versement['id_versement']) -->
                                <!-- TODO: Adapter les appels JavaScript si vos fonctions prennent l'ID du versement -->
                                <button
                                    onclick="modifierVersement(<?php echo htmlspecialchars($versement['id_versement'] ?? 'null'); ?>)"
                                    class="p-1 text-orange-500 hover:text-orange-600 focus:outline-none">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button
                                    onclick="supprimerVersement(<?php echo htmlspecialchars($versement['id_versement'] ?? 'null'); ?>)"
                                    class="p-1 text-red-500 hover:text-red-700 focus:outline-none">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <!-- Le bouton Imprimer Recu devrait probablement prendre l'ID de l'inscription, pas du versement, pour imprimer le reçu complet de l'inscription -->
                                <button
                                    onclick="imprimerRecu(<?php echo htmlspecialchars($versement['id_inscription'] ?? 'null'); ?>)"
                                    class="p-1 text-green-500 hover:text-green-600 focus:outline-none">
                                    <i class="fas fa-print"></i>
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="px-6 py-4 text-center text-gray-500">
                            Aucun versement trouvé.
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const studentSelect = document.getElementById('studentSelect');
        const paymentAmount = document.getElementById('paymentAmount');
        const searchInput = document.getElementById('paymentSearch');

        // Mettre à jour le montant maximum possible
        studentSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const resteAPayer = selectedOption.dataset.resteAPayer;
                paymentAmount.max = resteAPayer;
                paymentAmount.placeholder = `Montant maximum: ${resteAPayer} FCFA`;
            }
        });

        // Recherche d'étudiants
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.grid-cols-12');

            rows.forEach((row, index) => {
                if (index === 0) return; // Skip header
                const studentName = row.querySelector('.text-gray-800').textContent
                    .toLowerCase();
                const studentId = row.querySelector('.text-gray-500').textContent.toLowerCase();

                if (studentName.includes(searchTerm) || studentId.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Validation du formulaire
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            const amount = parseFloat(paymentAmount.value);
            const selectedOption = studentSelect.options[studentSelect.selectedIndex];
            const resteAPayer = parseFloat(selectedOption.dataset.resteAPayer);

            if (amount > resteAPayer) {
                e.preventDefault();
                alert('Le montant ne peut pas dépasser le reste à payer.');
            }
        });
    });

    // Fonction pour voir l'historique des versements
    function voirHistorique(idInscription) {
        window.location.href = `?page=gestion_scolarite&action=historique_versements&id=${idInscription}`;
    }

    // Fonction pour imprimer le reçu
    function imprimerRecu(idInscription) {
        window.open(`?page=gestion_scolarite&action=imprimer_recu&id=${idInscription}`, '_blank');
    }

    // Gérer les notifications
    const successNotification = document.getElementById('successNotification');
    const errorNotification = document.getElementById('errorNotification');

    function removeNotification(notification) {
        if (notification) {
            notification.classList.add('animate__fadeOut');
            setTimeout(() => notification.remove(), 500);
        }
    }

    if (successNotification) {
        setTimeout(() => removeNotification(successNotification), 5000);
    }

    if (errorNotification) {
        setTimeout(() => removeNotification(errorNotification), 5000);
    }
    </script>
</body>

</html>