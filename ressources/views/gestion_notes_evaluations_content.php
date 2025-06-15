<?php

$students = $GLOBALS['listeEtudiants'];
$niveauxEtude = $GLOBALS['niveauxEtude'];
$selectedNiveau = $GLOBALS['selectedNiveau'];
$selectedStudent = $GLOBALS['selectedStudent'];
$studentGrades = $GLOBALS['studentGrades'];

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsable Scolarité | Gestion des Notes</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    .progress-ring__circle {
        transition: stroke-dashoffset 0.35s;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }

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

    .note-input:focus {
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
    }

    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .search-container {
        position: relative;
    }

    .search-results {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 10;
        max-height: 300px;
        overflow-y: auto;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .search-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .search-item:hover {
        background-color: #f3f4f6;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
        animation: fadeIn 0.3s ease-in;
    }
    </style>
    <script>
    function toggleSemestreValidation(semestre) {
        fetch('<?php echo '?page=gestion_notes_evaluations'; ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    semestre: semestre,
                    etudiant_id: '<?php echo $GLOBALS['selectedStudent']->num_etu; ?>'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Erreur lors de la validation du semestre');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la validation du semestre');
            });
    }

    document.getElementById('saisiForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('<?php echo '?page=gestion_notes_evaluations'; ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Erreur lors de l\'enregistrement des notes');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'enregistrement des notes');
            });
    });
    </script>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Main content area -->
        <div class="flex-1 p-4 md:p-6 overflow-y-auto ">
            <!-- Interface de saisie des notes (optimisée) -->
            <div id="notes" class="tab-content active max-w-7xl mx-auto">
                <!-- Header with student search -->
                <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Gestion des Notes</h2>
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                <select id="niveauSelect"
                                    class="block w-64 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Sélectionner un niveau</option>
                                    <?php foreach ($GLOBALS['niveaux'] as $niveau): ?>
                                    <option value="<?php echo htmlspecialchars($niveau->id_niv_etude); ?>"
                                        <?php echo $GLOBALS['selectedNiveau'] == $niveau->id_niv_etude ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($niveau->lib_niv_etude); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="relative">
                                <select id="studentSelect"
                                    class="block w-64 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Sélectionner un étudiant</option>
                                    <?php foreach ($GLOBALS['etudiants'] as $etudiant): ?>
                                    <option value="<?php echo htmlspecialchars($etudiant->num_etu); ?>"
                                        <?php echo isset($GLOBALS['selectedStudent']) && $GLOBALS['selectedStudent']['num_etu'] == $etudiant->num_etu ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($etudiant->nom_etu . ' ' . $etudiant->prenom_etu); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Message initial -->
                    <?php if (empty($GLOBALS['selectedNiveau'])) { ?>
                    <div class="text-center py-12 bg-gray-50 rounded-lg">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 mb-4">
                            <i class="fas fa-graduation-cap text-2xl text-blue-600"></i>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Sélectionnez un niveau d'étude</h4>
                        <p class="text-gray-500">Veuillez sélectionner un niveau d'étude pour afficher les semestres et
                            les unités d'enseignement.</p>
                    </div>
                    <?php } ?>

                    <!-- Résumé des notes -->
                    <?php if (!empty($GLOBALS['selectedStudent'])): ?>
                    <div class="bg-blue-50 rounded-lg p-4 mb-6">
                        <div class="grid grid-cols-4 gap-4">
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <h3 class="text-sm font-medium text-gray-500 mb-1">Moyenne Générale</h3>
                                <p class="text-2xl font-bold text-blue-600">
                                    <?php
                                    $totalNotes = 0;
                                    $totalCredits = 0;
                                    foreach ($GLOBALS['studentGrades'] as $grade) {
                                        $totalNotes += $grade->note * $grade->credit;
                                        $totalCredits += $grade->credit;
                                    }
                                    echo $totalCredits > 0 ? number_format($totalNotes / $totalCredits, 2) : '0.00';
                                    ?>
                                </p>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <h3 class="text-sm font-medium text-gray-500 mb-1">Crédits Validés</h3>
                                <p class="text-2xl font-bold text-green-600">
                                    <?php
                                    $creditsValides = 0;
                                    foreach ($GLOBALS['studentGrades'] as $grade) {
                                        if ($grade->note >= 10) {
                                            $creditsValides += $grade->credit;
                                        }
                                    }
                                    echo $creditsValides;
                                    ?>
                                </p>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <h3 class="text-sm font-medium text-gray-500 mb-1">UE Validées</h3>
                                <p class="text-2xl font-bold text-green-600">
                                    <?php
                                    $uesValidees = 0;
                                    $uesTraitees = [];
                                    foreach ($GLOBALS['studentGrades'] as $grade) {
                                        if (!in_array($grade->ue_id, $uesTraitees)) {
                                            if ($grade->note >= 10) {
                                                $uesValidees++;
                                            }
                                            $uesTraitees[] = $grade->ue_id;
                                        }
                                    }
                                    echo $uesValidees;
                                    ?>
                                </p>
                            </div>
                            <div class="bg-white rounded-lg p-4 shadow-sm">
                                <h3 class="text-sm font-medium text-gray-500 mb-1">UE en Échec</h3>
                                <p class="text-2xl font-bold text-red-600">
                                    <?php
                                    $uesEchec = 0;
                                    $uesTraitees = [];
                                    foreach ($GLOBALS['studentGrades'] as $grade) {
                                        if (!in_array($grade->ue_id, $uesTraitees)) {
                                            if ($grade->note < 10) {
                                                $uesEchec++;
                                            }
                                            $uesTraitees[] = $grade->ue_id;
                                        }
                                    }
                                    echo $uesEchec;
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Informations de l'étudiant -->
                    <?php if (!empty($GLOBALS['selectedStudent'])): ?>
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-user text-2xl text-blue-600"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-gray-900">
                                    <?php echo htmlspecialchars($GLOBALS['selectedStudent']->nom_etu . ' ' . $GLOBALS['selectedStudent']->prenom_etu); ?>
                                </h3>
                                <p class="text-gray-600">Matricule:
                                    <?php echo htmlspecialchars($GLOBALS['selectedStudent']->num_etu); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Résumé des semestres -->
                    <?php if (!empty($GLOBALS['selectedStudent'])): ?>
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Résumé des Semestres</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <?php
                            $semestres = [];
                            foreach ($GLOBALS['studentUes'] as $ue) {
                                if (!isset($semestres[$ue->lib_semestre])) {
                                    $semestres[$ue->lib_semestre] = [
                                        'total_credits' => 0,
                                        'total_notes' => 0,
                                        'ues_validees' => 0,
                                        'ues_total' => 0
                                    ];
                                }
                                $semestres[$ue->lib_semestre]['total_credits'] += $ue->credit;
                                $semestres[$ue->lib_semestre]['ues_total']++;
                                
                                // Calculer la moyenne de l'UE
                                $note_ue = null;
                                foreach ($GLOBALS['studentGrades'] as $grade) {
                                    if ($grade->ue_id == $ue->id_ue) {
                                        $note_ue = $grade->note;
                                        break;
                                    }
                                }
                                
                                if ($note_ue !== null) {
                                    $semestres[$ue->lib_semestre]['total_notes'] += $note_ue * $ue->credit;
                                    if ($note_ue >= 10) {
                                        $semestres[$ue->lib_semestre]['ues_validees']++;
                                    }
                                }
                            }

                            foreach ($semestres as $lib_semestre => $data):
                                $moyenne = $data['total_credits'] > 0 ? $data['total_notes'] / $data['total_credits'] : 0;
                                $is_valide = $moyenne >= 10;
                            ?>
                            <div
                                class="bg-gray-50 rounded-lg p-4 border <?php echo $is_valide ? 'border-green-200' : 'border-red-200'; ?>">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-medium text-gray-900"><?php echo htmlspecialchars($lib_semestre); ?>
                                    </h4>
                                    <span class="text-sm <?php echo $is_valide ? 'text-green-600' : 'text-red-600'; ?>">
                                        <?php echo $is_valide ? 'Validé' : 'Non validé'; ?>
                                    </span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <div>
                                        <span class="text-gray-500">Moyenne:</span>
                                        <span class="font-medium"><?php echo number_format($moyenne, 2); ?></span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">Crédits:</span>
                                        <span class="font-medium"><?php echo $data['total_credits']; ?></span>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">UE validées:</span>
                                        <span
                                            class="font-medium"><?php echo $data['ues_validees']; ?>/<?php echo $data['ues_total']; ?></span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="button"
                                        class="w-full px-3 py-1.5 text-sm rounded-md <?php echo $is_valide ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-red-100 text-red-700 hover:bg-red-200'; ?>"
                                        onclick="toggleSemestreValidation('<?php echo $lib_semestre; ?>')">
                                        <?php echo $is_valide ? 'Dévalider le semestre' : 'Valider le semestre'; ?>
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Semestres et UE -->
                    <div class="space-y-6">
                        <?php if (!empty($GLOBALS['selectedNiveau'])) { ?>
                        <form id="saisiForm" class="space-y-6">
                            <?php 
                                $currentSemestre = null;
                                foreach ($GLOBALS['studentUes'] as $ue) {
                                    if ($currentSemestre !== $ue->lib_semestre) {
                                        if ($currentSemestre !== null) {
                                            echo '</div></div>';
                                        }
                                        $currentSemestre = $ue->lib_semestre;
                                        
                                        // Calculer le total des crédits pour ce semestre
                                        $totalCreditsSemestre = 0;
                                        foreach ($GLOBALS['studentUes'] as $ueSemestre) {
                                            if ($ueSemestre->lib_semestre === $currentSemestre) {
                                                $totalCreditsSemestre += $ueSemestre->credit;
                                            }
                                        }
                                        ?>
                            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                                <div class="px-6 py-4 bg-blue-500">
                                    <div class="flex justify-between items-center">
                                        <h3 class="text-lg font-semibold text-white">
                                            <?php echo htmlspecialchars($ue->lib_semestre); ?></h3>
                                        <span class="text-sm text-blue-100"><?php echo $totalCreditsSemestre; ?>
                                            crédits</span>
                                    </div>
                                </div>
                                <div class="p-6">
                                    <?php
                                    }
                                    ?>
                                    <div class="mb-6 last:mb-0">
                                        <?php
                                        // Récupérer les ECUE de cette UE
                                        $ecues = [];
                                        foreach ($GLOBALS['studentEcues'] as $ecue) {
                                            if ($ecue->id_ue == $ue->id_ue) {
                                                $ecues[] = $ecue;
                                            }
                                        }
                                        
                                        if (!empty($ecues)) {
                                            echo '<div class="bg-gray-50 rounded-lg p-4 mb-4">';
                                            echo '<h5 class="text-sm font-medium text-gray-700 mb-3">Éléments constitutifs (ECUE)</h5>';
                                            echo '<div class="space-y-3">';
                                            foreach ($ecues as $ecue) {
                                                echo '<div class="flex items-center space-x-4">';
                                                echo '<div class="flex-1">';
                                                echo '<label class="block text-sm text-gray-600 mb-1">' . htmlspecialchars($ecue->lib_ecue) . '</label>';
                                                echo '<input type="number" step="0.01" min="0" max="20" name="notes_ecue[' . $ecue->id_ecue . ']" value="';
                                                $note_ecue = null;
                                                foreach ($GLOBALS['studentGrades'] as $grade) {
                                                    if ($grade->ecue_id == $ecue->id_ecue) {
                                                        $note_ecue = $grade->note;
                                                        break;
                                                    }
                                                }
                                                echo $note_ecue !== null ? htmlspecialchars($note_ecue) : '';
                                                echo '" class="note-input w-24 px-2 py-1 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">';
                                                echo '</div>';
                                                echo '<div class="flex-1">';
                                                echo '<input type="text" name="commentaires_ecue[' . $ecue->id_ecue . ']" value="';
                                                $commentaire_ecue = null;
                                                foreach ($GLOBALS['studentGrades'] as $grade) {
                                                    if ($grade->ecue_id == $ecue->id_ecue) {
                                                        $commentaire_ecue = $grade->commentaire;
                                                        break;
                                                    }
                                                }
                                                echo $commentaire_ecue !== null ? htmlspecialchars($commentaire_ecue) : '';
                                                echo '" placeholder="Commentaire" class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                        ?>

                                        <div class="flex items-center space-x-4">
                                            <div class="w-24">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Note
                                                    UE</label>
                                                <input type="number" step="0.01" min="0" max="20"
                                                    name="notes[<?php echo $ue->id_ue; ?>]" value="<?php 
                                                        $note = null;
                                                        foreach ($GLOBALS['studentGrades'] as $grade) {
                                                            if ($grade->ue_id == $ue->id_ue) {
                                                                $note = $grade->note;
                                                                break;
                                                            }
                                                        }
                                                        echo $note !== null ? htmlspecialchars($note) : '';
                                                    ?>"
                                                    class="note-input w-full px-2 py-1 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                            <div class="flex-1">
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Commentaire
                                                    UE</label>
                                                <input type="text" name="commentaires[<?php echo $ue->id_ue; ?>]" value="<?php 
                                                        $commentaire = null;
                                                        foreach ($GLOBALS['studentGrades'] as $grade) {
                                                            if ($grade->ue_id == $ue->id_ue) {
                                                                $commentaire = $grade->commentaire;
                                                                break;
                                                            }
                                                        }
                                                        echo $commentaire !== null ? htmlspecialchars($commentaire) : '';
                                                    ?>"
                                                    class="w-full px-2 py-1 text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                if ($currentSemestre !== null) {
                                    echo '</div></div>';
                                }
                            ?>
                                    <div class="flex justify-end mt-6">
                                        <button type="submit"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                            Enregistrer les notes
                                        </button>
                                    </div>
                        </form>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const niveauSelect = document.getElementById('niveauSelect');
        const studentSelect = document.getElementById('studentSelect');

        niveauSelect.addEventListener('change', function() {
            const niveauId = this.value;
            if (niveauId) {
                window.location.href = `?page=gestion_notes_evaluations&niveau=${niveauId}`;
            }
        });

        studentSelect.addEventListener('change', function() {
            const studentId = this.value;
            const niveauId = niveauSelect.value;
            if (studentId && niveauId) {
                window.location.href =
                    `?page=gestion_notes_evaluations&niveau=${niveauId}&student=${studentId}`;
            }
        });
    });

    function saveAllGrades() {
        const inputs = document.querySelectorAll('.note-input');
        const updates = [];

        inputs.forEach(input => {
            if (input.value !== '') {
                updates.push({
                    student_id: input.dataset.studentId,
                    ue_id: input.dataset.ueId,
                    note: input.value,
                    commentaire: input.nextElementSibling?.value || ''
                });
            }
        });

        if (updates.length > 0) {
            fetch('updateNote', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(updates)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Notes enregistrées avec succès');
                        location.reload();
                    } else {
                        alert('Erreur lors de l\'enregistrement des notes');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erreur lors de l\'enregistrement des notes');
                });
        }
    }
    </script>

</body>

</html>