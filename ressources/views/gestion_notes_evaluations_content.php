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
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Main content area -->
        <div class="flex-1 p-4 md:p-6 overflow-y-auto ">
            <!-- Interface de saisie des notes (optimisée) -->
            <div id="notes" class="tab-content active max-w-7xl mx-auto">
                <!-- Header with student search -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Gestion des notes</h1>
                        <p class="text-gray-600">Saisie et validation des notes par UE</p>
                    </div>
                    <div class="w-full md:w-96">
                        <div class="bg-white rounded-lg shadow-sm p-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Sélection</h3>
                            <form method="GET" action="" class="space-y-4">
                                <!-- Liste déroulante pour le niveau d'étude -->
                                <div>
                                    <label for="niveauEtude" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-graduation-cap mr-2 text-blue-500"></i>Niveau d'étude
                                    </label>
                                    <select id="niveauEtude" name="niveau_id" onchange="this.form.submit()"
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md bg-white shadow-sm hover:border-blue-400 transition-colors duration-200">
                                        <option value="">Sélectionner un niveau...</option>
                                        <?php foreach ($niveauxEtude as $niveau): ?>
                                        <option value="<?php echo $niveau->id_niv_etude; ?>"
                                            <?php echo ($selectedNiveau == $niveau->id_niv_etude) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($niveau->lib_niv_etude); ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Liste déroulante pour les étudiants -->
                                <div>
                                    <label for="studentSelect" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-user-graduate mr-2 text-blue-500"></i>Étudiant
                                    </label>
                                    <select id="studentSelect" name="student_id" onchange="this.form.submit()"
                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md bg-white shadow-sm hover:border-blue-400 transition-colors duration-200"
                                        <?php echo empty($selectedNiveau) ? 'disabled' : ''; ?>>
                                        <option value="">Sélectionner un étudiant...</option>
                                        <?php if (!empty($students)): ?>
                                        <?php foreach ($students as $etudiant): ?>
                                        <option value="<?php echo $etudiant['num_etu']; ?>"
                                            <?php echo (isset($selectedStudent) && $selectedStudent['num_etu'] == $etudiant['num_etu']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($etudiant['nom_etu'] . ' ' . $etudiant['prenom_etu']); ?>
                                        </option>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <?php if (empty($selectedNiveau)): ?>
                                    <p class="mt-1 text-sm text-gray-500">Veuillez d'abord sélectionner un niveau
                                        d'étude</p>
                                    <?php elseif (empty($students)): ?>
                                    <p class="mt-1 text-sm text-gray-500">Aucun étudiant trouvé pour ce niveau</p>
                                    <?php endif; ?>
                                </div>

                                <!-- Conserver les autres paramètres GET s'ils existent -->
                                <?php
                                foreach ($_GET as $key => $value) {
                                    if ($key !== 'niveau_id' && $key !== 'student_id') {
                                        echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
                                    }
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                </div>

                <?php if (isset($selectedStudent) && is_array($selectedStudent)): ?>
                <div id="selectedStudentInfo" class="bg-white rounded-lg shadow-sm p-4 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800" id="selectedStudentName">
                                <?php 
                                $nom = isset($selectedStudent['nom_etu']) ? $selectedStudent['nom_etu'] : '';
                                $prenom = isset($selectedStudent['prenom_etu']) ? $selectedStudent['prenom_etu'] : '';
                                echo htmlspecialchars($prenom . ' ' . $nom); 
                                ?>
                            </h2>
                            <p class="text-sm text-gray-600" id="selectedStudentProgram">
                                <?php echo isset($selectedStudent['promotion_etu']) ? htmlspecialchars($selectedStudent['promotion_etu']) : ''; ?>
                            </p>
                        </div>
                        <!-- Résumé du niveau d'étude -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Résumé du niveau d'étude</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500">Niveau</p>
                                    <p class="text-lg font-semibold text-gray-800">
                                        <?php 
                                $niveau = array_filter($niveauxEtude, function($n) use ($selectedNiveau) {
                                    return $n->id_niv_etude == $selectedNiveau;
                                });
                                $niveau = reset($niveau);
                                echo $niveau ? htmlspecialchars($niveau->lib_niv_etude) : '';
                                ?>
                                    </p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500">Promotion</p>
                                    <p class="text-lg font-semibold text-gray-800">
                                        <?php echo isset($selectedStudent['promotion_etu']) ? htmlspecialchars($selectedStudent['promotion_etu']) : ''; ?>
                                    </p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-500">Statut</p>
                                    <p class="text-lg font-semibold text-blue-600">En cours</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Semestres et UE -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Semestres et Unités d'Enseignement</h3>

                    <form id="saisiForm" class="space-y-6">


                        <div class="mb-6 border border-gray-200 rounded-lg overflow-hidden">
                            <div class="px-6 py-3 bg-gray-100 flex justify-between items-center">
                                <h4 class="text-lg font-semibold text-gray-800">Semestre </h4>
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    <span>Crédits: <span class="font-bold text-gray-800"></span></span>
                                </div>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-2/6">
                                                UE</th>
                                            <th scope="col"
                                                class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                                                Crédits</th>
                                            <th scope="col"
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                                                Moyenne</th>
                                            <th scope="col"
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">
                                                Statut</th>
                                            <th scope="col"
                                                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">
                                                Commentaire</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">

                                        <tr>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                </div>
                                                <div class="text-sm text-gray-500">Responsable: N/A</div>

                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap text-center text-sm text-gray-500">
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                <input type="number" min="0" max="20" step="0.5"
                                                    class="note-input block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                    value="" placeholder="Non saisie" data-student-id="" data-ue-id="">
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap">

                                                <span
                                                    class="px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $statusClass; ?>">

                                                </span>
                                            </td>
                                            <td class="px-4 py-2 whitespace-nowrap">
                                                <input type="text"
                                                    class="note-input block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                                    placeholder="Ajouter un commentaire..." value="" data-student-id=""
                                                    data-ue-id="">
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="flex justify-end mt-6">
                            <button type="button" onclick="saveAllGrades()"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i>Enregistrer les notes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Summary card -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Résumé académique</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <?php
                         $totalCredits = 0;
                         $totalNotes = 0;
                         $totalCoefficients = 0;
                         $creditsObtenus = 0;
                         
                         foreach ($studentGrades as $grade) {
                             $totalCredits += $grade['credits'];
                             if (isset($grade['note']) && $grade['note'] !== null) {
                                 $totalNotes += $grade['note'] * $grade['coefficient'];
                                 $totalCoefficients += $grade['coefficient'];
                                 if ($grade['note'] >= 10) {
                                     $creditsObtenus += $grade['credits'];
                                 }
                             }
                         }
                         
                         $moyenneGenerale = $totalCoefficients > 0 ? $totalNotes / $totalCoefficients : 0;
                         $pourcentageProgression = $totalCredits > 0 ? ($creditsObtenus / $totalCredits) * 100 : 0;
                         ?>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Moyenne Générale</p>
                            <p class="text-xl font-semibold text-blue-600">
                                <?php echo number_format($moyenneGenerale, 2); ?></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Crédits obtenus</p>
                            <p class="text-xl font-semibold text-gray-800">
                                <?php echo $creditsObtenus; ?>/<?php echo $totalCredits; ?></p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Statut global</p>
                            <span
                                class="status-badge <?php echo $moyenneGenerale >= 10 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
                                <?php echo $moyenneGenerale >= 10 ? 'Validé' : 'Non validé'; ?>
                            </span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Progression</p>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                <div class="bg-blue-600 h-2.5 rounded-full"
                                    style="width: <?php echo $pourcentageProgression; ?>%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                <?php echo number_format($pourcentageProgression, 1); ?>% du parcours validé</p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>


        </div>
    </div>
    <script>
    function saveAllGrades() {
        const noteInputs = document.querySelectorAll('.note-input');
        const updates = [];

        noteInputs.forEach(input => {
            if (input.type === 'number') {
                const studentId = input.dataset.studentId;
                const ueId = input.dataset.ueId;
                const note = input.value;
                const commentaire = input.parentElement.nextElementSibling.querySelector('input').value;

                updates.push({
                    action: 'update_grade',
                    student_id: studentId,
                    ue_id: ueId,
                    note: note,
                    commentaire: commentaire
                });
            }
        });

        // Envoi des mises à jour au serveur
        fetch(window.location.href, {
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
                } else {
                    alert('Erreur lors de l\'enregistrement des notes');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'enregistrement des notes');
            });
    }

    function printGrades() {
        window.print();
    }

    // Gestion de la recherche d'étudiant
    document.getElementById('studentSearch').addEventListener('input', function(e) {
        const selectedStudentInfo = document.getElementById('selectedStudentInfo');
        if (e.target.value) {
            selectedStudentInfo.classList.remove('hidden');
            // Mise à jour du nom de l'étudiant sélectionné
            document.getElementById('selectedStudentName').textContent = e.target.value;
        } else {
            selectedStudentInfo.classList.add('hidden');
        }
    });

    // Gestion du changement de niveau d'étude
    document.getElementById('niveauEtude').addEventListener('change', function(e) {
        console.log('Niveau sélectionné:', this.value); // Debug log

        const niveauId = this.value;
        let newUrl = window.location.pathname;

        if (niveauId) {
            newUrl += '?niveau_id=' + encodeURIComponent(niveauId);
        }

        console.log('Nouvelle URL:', newUrl); // Debug log
        window.location.href = newUrl;
    });

    // Gestion du changement d'étudiant
    document.getElementById('studentSelect').addEventListener('change', function(e) {
        console.log('Étudiant sélectionné:', this.value); // Debug log

        const studentId = this.value;
        const niveauId = document.getElementById('niveauEtude').value;
        let newUrl = window.location.pathname;

        if (niveauId) {
            newUrl += '?niveau_id=' + encodeURIComponent(niveauId);
            if (studentId) {
                newUrl += '&student_id=' + encodeURIComponent(studentId);
            }
        }

        console.log('Nouvelle URL:', newUrl); // Debug log
        window.location.href = newUrl;
    });

    // Vérification que les événements sont bien attachés
    console.log('Script chargé');
    console.log('Élément niveauEtude:', document.getElementById('niveauEtude'));
    console.log('Élément studentSelect:', document.getElementById('studentSelect'));
    </script>
</body>

</html>