<?php
$entreprise_a_modifier = $GLOBALS['entreprise_a_modifier'] ?? null;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Entreprises</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
    /* Animations et transitions */
    .animate__animated {
        animation-duration: 0.3s;
    }

    .transition-all {
        transition-property: all;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }

    /* Personnalisation des inputs */
    .form-input:focus {
        border-color: #22c55e;
        box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.2);
        background-color: #f0fdf4;
    }

    /* Style pour le hover des lignes du tableau */
    .table-row:hover {
        background-color: #f0fdf4;
    }

    /* Style pour les checkboxes */
    input[type="checkbox"]:checked {
        background-color: #22c55e;
        border-color: #22c55e;
    }

    /* Style pour la pagination active */
    .pagination-active {
        background-color: #22c55e;
        border-color: #22c55e;
    }

    /* Boutons avec dégradés */
    .btn-gradient-primary {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    }

    .btn-gradient-secondary {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    }

    .btn-gradient-warning {
        background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%);
    }

    .btn-gradient-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    /* Effet de hover sur les boutons */
    .btn-hover {
        transition: all 0.3s ease;
    }

    .btn-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    @media print {
        body * {
            visibility: hidden;
        }

        .container table,
        .container table * {
            visibility: visible;
        }

        .container table {
            position: absolute;
            left: 0;
            top: 0;
        }

        button,
        .actions,
        input[type="checkbox"] {
            display: none !important;
        }
    }

    /* Styles pour les notifications */
    .notification {
        position: fixed;
        top: 1rem;
        right: 1rem;
        padding: 1rem;
        border-radius: 0.5rem;
        color: white;
        max-width: 24rem;
        z-index: 50;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        animation: slideIn 0.5s ease-out;
    }

    .notification.success {
        background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    }

    .notification.error {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }

        to {
            opacity: 0;
        }
    }
    </style>
</head>

<body class="bg-gray-50">
    <!-- Système de notification -->
    <?php if (!empty($GLOBALS['messageSuccess'])): ?>
    <div id="successNotification" class="notification success animate__animated animate__fadeIn">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <p><?= htmlspecialchars($GLOBALS['messageSuccess']) ?></p>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($GLOBALS['messageErreur'])): ?>
    <div id="errorNotification" class="notification error animate__animated animate__fadeIn">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <p><?= htmlspecialchars($GLOBALS['messageErreur']) ?></p>
        </div>
    </div>
    <?php endif; ?>

    <div class="min-h-screen">
        <main class="container mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-600">
                    <i class="fas fa-building mr-2 text-green-600"></i>
                    Gestion des Entreprises
                </h2>
            </div>

            <!-- Formulaire -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-600 mb-4 flex items-center">
                    <i
                        class="fas <?= isset($_GET['id_entreprise']) ? 'fa-edit text-green-500' : 'fa-plus-circle text-green-500' ?> mr-2"></i>
                    <?= isset($_GET['id_entreprise']) ? 'Modifier l\'entreprise' : 'Ajouter une nouvelle entreprise' ?>
                </h3>

                <form method="POST" action="?page=parametres_generaux&action=entreprises" id="entrepriseForm">
                    <?php if($entreprise_a_modifier): ?>
                    <input type="hidden" name="id_entreprise"
                        value="<?= htmlspecialchars($entreprise_a_modifier->id_entreprise) ?>">
                    <?php endif; ?>

                    <div class="mb-4">
                        <label for="lib_entreprise" class="block text-sm font-medium text-gray-700 mb-2">Nom de
                            l'entreprise</label>
                        <input type="text" name="lib_entreprise" id="lib_entreprise" required
                            value="<?= $entreprise_a_modifier ? htmlspecialchars($entreprise_a_modifier->lib_entreprise) : '' ?>"
                            class="form-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-4 focus:outline-green-300 focus:ring-green-300 focus:border-green-300 focus:ring-opacity-50 transition-all duration-200">
                    </div>

                    <div class="flex justify-between mt-6">
                        <?php if (isset($_GET['id_entreprise'])): ?>
                        <button type="submit" name="btn_annuler"
                            class="btn-hover px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <i class="fas fa-times mr-2"></i>Annuler
                        </button>
                        <button type="submit" name="submit_edit_entreprise"
                            class="btn-hover px-4 py-2 btn-gradient-primary text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <i class="fas fa-save mr-2"></i>Modifier
                        </button>
                        <?php else: ?>
                        <div></div>
                        <button type="submit" name="submit_add_entreprise"
                            class="btn-hover px-4 py-2 btn-gradient-primary text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <i class="fas fa-plus mr-2"></i>Ajouter une entreprise
                        </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Liste des entreprises -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-600 mb-4">Liste des entreprises</h3>
                    <form method="POST" action="?page=parametres_generaux&action=entreprises" id="deleteForm">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="w-16 px-6 py-3 text-center">
                                            <input type="checkbox" id="selectAllCheckbox"
                                                class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nom
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php if (!empty($listeEntreprises)): ?>
                                    <?php foreach ($listeEntreprises as $entreprise): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <input type="checkbox" name="selected_ids[]"
                                                value="<?= htmlspecialchars($entreprise->id_entreprise) ?>"
                                                class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <?= htmlspecialchars($entreprise->id_entreprise) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <?= htmlspecialchars($entreprise->lib_entreprise) ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                            <a href="?page=parametres_generaux&action=entreprises&id_entreprise=<?= htmlspecialchars($entreprise->id_entreprise) ?>"
                                                class="text-green-600 hover:text-green-900">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                            Aucune entreprise enregistrée
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" name="btn_supprimer_entreprise" id="deleteButton"
                                class="btn-hover px-4 py-2 btn-gradient-danger text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-trash-alt mr-2"></i>Supprimer la sélection
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <?php
    unset($GLOBALS['messageErreur'], $GLOBALS['messageSucces']);
    ?>

</body>

</html>