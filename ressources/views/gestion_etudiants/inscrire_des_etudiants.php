<?php
// Utilisation des variables globales au lieu d'appeler directement la base de données
$etudiantsNonInscrits = isset($GLOBALS['etudiantsNonInscrits']) ? $GLOBALS['etudiantsNonInscrits'] : [];
$niveaux = isset($GLOBALS['niveaux']) ? $GLOBALS['niveaux'] : [];
$etudiantsInscrits = isset($GLOBALS['etudiantsInscrits']) ? $GLOBALS['etudiantsInscrits'] : [];
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription des étudiants</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: '#2c3e50',
                    secondary: '#34495e',
                    accent: '#3498db',
                    success: '#27ae60',
                    danger: '#e74c3c',
                    warning: '#f1c40f',
                }
            }
        }
    }
    </script>
    <style>
    /* Style pour les sections */
    .section-container {
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        background-color: #f8fafc;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease-in-out;
    }

    .section-container:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    /* Style pour les champs en lecture seule */
    .form-control[readonly] {
        background-color: #f1f5f9;
        border-color: #cbd5e1 !important;
    }

    /* Style pour les selects */
    select.form-control {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2310b981' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
    }

    /* Animation pour les icônes */
    .icon-animate {
        transition: all 0.3s ease-in-out;
    }

    .section-container:hover .icon-animate {
        transform: scale(1.1);
        color: #10b981;
    }

    /* Style pour les labels */
    .form-label {
        color: #d9d9d9;
        transition: all 0.3s ease-in-out;
    }

    .section-container:hover .form-label {
        color: #d9d9d9;
    }
    </style>
</head>

<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <?php if (isset($_SESSION['success'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo $_SESSION['success']; ?></span>
            <?php unset($_SESSION['success']); ?>
        </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
            <?php unset($_SESSION['error']); ?>
        </div>
        <?php endif; ?>

        <!-- Formulaire d'inscription -->
        <div class="bg-white rounded-lg shadow-sm mb-8 print:hidden">
            <div class="border-b border-gray-200 px-6 py-4">
                <h5 class="text-lg font-semibold text-green-600 flex items-center">
                    <i class="fas fa-user-plus mr-2"></i>Nouvelle inscription
                </h5>
            </div>
            <div class="p-6">
                <form id="inscriptionForm" method="POST" action="?page=gestion_etudiants&action=inscrire_des_etudiants">
                    <!-- Section Informations étudiant -->
                    <div
                        class="mb-8 border border-gray-200 rounded-lg bg-gray-50 p-6 transition-all duration-300 ease-in-out hover:shadow-md">
                        <h6 class="text-sm font-semibold text-green-600 mb-4 flex items-center">
                            <i
                                class="fas fa-user-graduate mr-2 transition-all duration-300 ease-in-out hover:scale-110 hover:text-green-500"></i>Informations
                            étudiant
                        </h6>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="col-span-2">
                                <label for="etudiant" class="block text-sm font-medium text-gray-600 mb-1">Sélectionner
                                    un étudiant</label>
                                <select
                                    class="w-full h-10 border border-gray-300 rounded-md transition-all duration-300 ease-in-out outline-none focus:border-green-500 focus:shadow-sm hover:-translate-y-0.5"
                                    id="etudiant" name="etudiant" required>
                                    <option value="">Choisir un étudiant...</option>
                                    <?php foreach ($etudiantsNonInscrits as $etudiant): ?>
                                    <option value="<?php echo $etudiant['num_etu']; ?>">
                                        <?php echo $etudiant['num_etu'] . ' - ' . $etudiant['nom_etu'] . ' ' . $etudiant['prenom_etu']; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label for="niveau" class="block text-sm font-medium text-gray-600 mb-1">Niveau
                                    d'études</label>
                                <select
                                    class="w-full h-10 border border-gray-300 rounded-md transition-all duration-300 ease-in-out outline-none focus:border-green-500 focus:shadow-sm hover:-translate-y-0.5"
                                    id="niveau" name="niveau" required>
                                    <option value="">Choisir un niveau...</option>
                                    <?php foreach ($niveaux as $niveau): ?>
                                    <option value="<?php echo $niveau['id_niveau']; ?>"
                                        data-montant="<?php echo $niveau['montant_scolarite']; ?>">
                                        <?php echo $niveau['nom_niveau']; ?> -
                                        <?php echo number_format($niveau['montant_scolarite'], 2); ?> FCFA
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section Détails étudiant -->
                    <div
                        class="mb-8 border border-gray-200 rounded-lg bg-gray-50 p-6 transition-all duration-300 ease-in-out hover:shadow-md">
                        <h6 class="text-sm font-semibold text-green-600 mb-4 flex items-center">
                            <i
                                class="fas fa-id-card mr-2 transition-all duration-300 ease-in-out hover:scale-110 hover:text-green-500"></i>Détails
                            étudiant
                        </h6>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Numéro étudiant</label>
                                <input type="text"
                                    class="w-full h-10 border border-gray-300 rounded-md bg-gray-100 transition-all duration-300 ease-in-out outline-none"
                                    id="num_etu" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Nom</label>
                                <input type="text"
                                    class="w-full h-10 border border-gray-300 rounded-md bg-gray-100 transition-all duration-300 ease-in-out outline-none"
                                    id="nom" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Prénom</label>
                                <input type="text"
                                    class="w-full h-10 border border-gray-300 rounded-md bg-gray-100 transition-all duration-300 ease-in-out outline-none"
                                    id="prenom" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Section Paiement -->
                    <div class="mb-8">
                        <h6 class="text-sm font-semibold text-green-600 mb-4 flex items-center">
                            <i
                                class="fas fa-money-bill-wave mr-2 transition-all duration-300 ease-in-out hover:scale-110 hover:text-green-500"></i>Détails
                            du paiement
                        </h6>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div
                                class="border border-gray-200 rounded-lg bg-gray-50 p-6 transition-all duration-300 ease-in-out hover:shadow-md">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Montant total de la
                                        scolarité</label>
                                    <input type="text"
                                        class="w-full h-10 border border-gray-300 rounded-md bg-gray-100 transition-all duration-300 ease-in-out outline-none"
                                        id="montant_total" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Premier versement
                                        (minimum 30%)</label>
                                    <input type="number"
                                        class="w-full h-10 border border-gray-300 rounded-md transition-all duration-300 ease-in-out outline-none focus:border-green-500 focus:shadow-sm hover:-translate-y-0.5"
                                        id="premier_versement" name="premier_versement" required>
                                </div>
                            </div>
                            <div
                                class="border border-gray-200 rounded-lg bg-gray-50 p-6 transition-all duration-300 ease-in-out hover:shadow-md">
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Reste à payer</label>
                                    <input type="text"
                                        class="w-full h-10 border border-gray-300 rounded-md bg-gray-100 transition-all duration-300 ease-in-out outline-none"
                                        id="reste_payer" readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Nombre de
                                        tranches</label>
                                    <select
                                        class="w-full h-10 border border-gray-300 rounded-md transition-all duration-300 ease-in-out outline-none focus:border-green-500 focus:shadow-sm hover:-translate-y-0.5"
                                        id="nombre_tranches" name="nombre_tranches">
                                        <option value="1">1 tranche</option>
                                        <option value="2">2 tranches</option>
                                        <option value="3">3 tranches</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-6 py-2.5 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-500/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            <i class="fas fa-save mr-2"></i>Enregistrer l'inscription
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Liste des étudiants inscrits -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="border-b border-gray-200 px-6 py-4">
                <div class="flex justify-between items-center">
                    <h5 class="text-lg font-semibold text-green-600 flex items-center">
                        <i class="fas fa-users mr-2"></i>Étudiants inscrits
                    </h5>
                </div>
            </div>
            <div class="p-6">
                <!-- Barre d'outils -->
                <div class="mb-6 flex flex-col sm:flex-row gap-4 items-center justify-between">
                    <!-- Barre de recherche -->
                    <div class="relative w-full sm:w-96">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" id="searchInput"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-accent focus:border-accent sm:text-sm"
                            placeholder="Rechercher un étudiant...">
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex flex-wrap gap-2">
                        <button onclick="exportToExcel()"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200">
                            <i class="fas fa-file-excel mr-2"></i>Excel
                        </button>
                        <button onclick="exportToPDF()"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-all duration-200">
                            <i class="fas fa-file-pdf mr-2"></i>PDF
                        </button>
                        <button onclick="window.print()"
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <i class="fas fa-print mr-2"></i>Imprimer
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-green-500 to-green-600">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Numéro</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Niveau</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Date d'inscription</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Statut</th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($etudiantsInscrits as $inscrit): ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo $inscrit['num_etu']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo $inscrit['nom'] . ' ' . $inscrit['prenom']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo $inscrit['nom_niveau']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo date('d/m/Y', strtotime($inscrit['date_inscription'])); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo $inscrit['statut_inscription'] === 'Validée' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'; ?>">
                                        <?php echo $inscrit['statut_inscription']; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <button onclick="modifierInscription(<?php echo $inscrit['id_inscription']; ?>)"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                                            <i class="fas fa-edit mr-1"></i>Modifier
                                        </button>
                                        <button
                                            onclick="confirmerSuppression(<?php echo $inscrit['id_inscription']; ?>, '<?php echo $inscrit['nom'] . ' ' . $inscrit['prenom']; ?>')"
                                            class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                                            <i class="fas fa-trash-alt mr-1"></i>Supprimer
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div id="modalSuppression" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Confirmer la suppression</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Êtes-vous sûr de vouloir supprimer l'inscription de <span id="nomEtudiant"
                            class="font-medium"></span> ?
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirmerBtn"
                        class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Confirmer
                    </button>
                    <button onclick="fermerModal()"
                        class="ml-3 px-4 py-2 bg-gray-100 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const etudiantSelect = document.getElementById('etudiant');
        const niveauSelect = document.getElementById('niveau');
        const premierVersementInput = document.getElementById('premier_versement');
        const nombreTranchesSelect = document.getElementById('nombre_tranches');

        // Gestion de la sélection d'un étudiant
        etudiantSelect.addEventListener('change', function() {
            const numEtu = this.value;
            if (numEtu) {
                fetch(`index.php?page=inscrire_des_etudiants&action=get_etudiant&num_etu=${numEtu}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('num_etu').value = data.num_etu;
                        document.getElementById('nom').value = data.nom;
                        document.getElementById('prenom').value = data.prenom;
                    });
            }
        });

        // Gestion du montant de la scolarité
        niveauSelect.addEventListener('change', function() {
            const montant = this.options[this.selectedIndex].dataset.montant;
            document.getElementById('montant_total').value = new Intl.NumberFormat('fr-FR').format(
                montant) + ' FCFA';
            updateRestePayer();
        });

        // Gestion du premier versement
        premierVersementInput.addEventListener('input', function() {
            const montantTotal = parseFloat(niveauSelect.options[niveauSelect.selectedIndex].dataset
                .montant);
            const montantMinimum = montantTotal * 0.3;

            if (parseFloat(this.value) < montantMinimum) {
                alert(
                    `Le premier versement doit être au minimum de ${new Intl.NumberFormat('fr-FR').format(montantMinimum)} FCFA (30% du montant total)`
                );
                this.value = montantMinimum;
            }

            updateRestePayer();
        });

        // Mise à jour du reste à payer
        function updateRestePayer() {
            const montantTotal = parseFloat(niveauSelect.options[niveauSelect.selectedIndex].dataset.montant);
            const premierVersement = parseFloat(premierVersementInput.value) || 0;
            const reste = montantTotal - premierVersement;

            document.getElementById('reste_payer').value = new Intl.NumberFormat('fr-FR').format(reste) +
                ' FCFA';
        }

        // Validation du formulaire
        document.getElementById('inscriptionForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const montantTotal = parseFloat(niveauSelect.options[niveauSelect.selectedIndex].dataset
                .montant);
            const premierVersement = parseFloat(premierVersementInput.value);

            if (premierVersement < montantTotal * 0.3) {
                alert('Le premier versement doit être au minimum de 30% du montant total');
                return;
            }

            this.submit();
        });

        // Fonction de recherche
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('tbody tr');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Variables pour la suppression
        let inscriptionASupprimer = null;

        // Fonction pour modifier une inscription
        window.modifierInscription = function(idInscription) {
            window.location.href =
                `index.php?page=inscrire_des_etudiants&action=modifier&id=${idInscription}`;
        };

        // Fonction pour confirmer la suppression
        window.confirmerSuppression = function(idInscription, nomEtudiant) {
            inscriptionASupprimer = idInscription;
            document.getElementById('nomEtudiant').textContent = nomEtudiant;
            document.getElementById('modalSuppression').classList.remove('hidden');
        };

        // Fonction pour fermer le modal
        window.fermerModal = function() {
            document.getElementById('modalSuppression').classList.add('hidden');
            inscriptionASupprimer = null;
        };

        // Gestionnaire de confirmation de suppression
        document.getElementById('confirmerBtn').addEventListener('click', function() {
            if (inscriptionASupprimer) {
                window.location.href =
                    `index.php?page=inscrire_des_etudiants&action=supprimer&id=${inscriptionASupprimer}`;
            }
        });

        // Fermer le modal si on clique en dehors
        document.getElementById('modalSuppression').addEventListener('click', function(e) {
            if (e.target === this) {
                fermerModal();
            }
        });
    });

    // Fonctions d'exportation
    function exportToExcel() {
        // Implémentation de l'export Excel
        alert('Fonctionnalité d\'export Excel à implémenter');
    }

    function exportToPDF() {
        // Implémentation de l'export PDF
        alert('Fonctionnalité d\'export PDF à implémenter');
    }
    </script>
</body>

</html>