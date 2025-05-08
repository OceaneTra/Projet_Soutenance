<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des étudiants</title>
</head>

<body>

    <?php
// Placeholder data for students
$etudiants = [
    ['id' => 1, 'num_etudiant' => 'E2023001', 'nom' => 'Dupont', 'prenom' => 'Jean', 'filiere' => 'Informatique', 'email' => 'jean.dupont@etu.example.com'],
    ['id' => 2, 'num_etudiant' => 'E2023002', 'nom' => 'Martin', 'prenom' => 'Alice', 'filiere' => 'Gestion', 'email' => 'alice.martin@etu.example.com'],
];
$filieres = ['Informatique', 'Gestion', 'Lettres', 'Sciences'];
?>

    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-semibold text-gray-800">Gestion des Étudiants</h1>
            <div>
                <button onclick="openEtudiantModal(null)"
                    class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-150 ease-in-out">
                    <i class="fas fa-plus mr-2"></i>Ajouter un Étudiant
                </button>
            </div>
        </div>

        <!-- Action Bar for Table (Search, Print, Export) - Similar to gestion_utilisateurs -->
        <div class="mb-6 flex flex-col sm:flex-row justify-between items-center">
            <div class="relative mb-4 sm:mb-0 w-full sm:w-1/3">
                <input type="text" placeholder="Rechercher un étudiant..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                <span class="absolute top-0 right-0 mt-2 mr-3"><i class="fas fa-search text-gray-400"></i></span>
            </div>
            <div>
                <button
                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow hover:shadow-md mr-2"><i
                        class="fas fa-print mr-2"></i>Imprimer</button>
                <button
                    class="bg-gray-700 hover:bg-gray-800 text-white font-semibold py-2 px-4 rounded-lg shadow hover:shadow-md"><i
                        class="fas fa-file-export mr-2"></i>Exporter</button>
            </div>
        </div>

        <!-- Students Table -->
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                N° Étudiant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Prénom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Filière</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email</th>
                            <th
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($etudiants as $etudiant): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo htmlspecialchars($etudiant['num_etudiant']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <?php echo htmlspecialchars($etudiant['nom']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <?php echo htmlspecialchars($etudiant['prenom']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <?php echo htmlspecialchars($etudiant['filiere']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <?php echo htmlspecialchars($etudiant['email']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <button onclick='openEtudiantModal(<?php echo json_encode($etudiant); ?>)'
                                    class="text-indigo-600 hover:text-indigo-900 mr-3" title="Modifier"><i
                                        class="fas fa-pencil-alt"></i></button>
                                <button onclick="return confirm('Supprimer cet étudiant ?');"
                                    class="text-red-600 hover:text-red-900" title="Supprimer"><i
                                        class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination (Placeholder) -->
            <div class="px-6 py-4 border-t border-gray-200">
                <p class="text-sm text-gray-700">Pagination ici...</p>
            </div>
        </div>
    </div>

    <!-- Add/Edit Etudiant Modal -->
    <div id="etudiantModal"
        class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden z-50">
        <div class="relative mx-auto p-8 border w-full max-w-2xl shadow-2xl rounded-xl bg-white">
            <div class="flex justify-between items-center mb-6">
                <h3 id="etudiantModalTitle" class="text-2xl font-semibold text-gray-700">Ajouter un Étudiant</h3>
                <button onclick="closeEtudiantModal()" class="text-gray-400 hover:text-gray-600"><i
                        class="fas fa-times fa-lg"></i></button>
            </div>
            <form id="etudiantForm">
                <input type="hidden" id="etudiantId" name="etudiantId">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="num_etudiant" class="block text-sm font-medium text-gray-700 mb-1">N°
                            Étudiant</label>
                        <input type="text" name="num_etudiant" id="num_etudiant" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" name="nom" id="nom" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <input type="text" name="prenom" id="prenom" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="date_naissance" class="block text-sm font-medium text-gray-700 mb-1">Date de
                            Naissance</label>
                        <input type="date" name="date_naissance" id="date_naissance"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 bg-white">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="adresse" class="block text-sm font-medium text-gray-700 mb-1">Adresse</label>
                    <textarea name="adresse" id="adresse" rows="2"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500"></textarea>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                    <div>
                        <label for="email_etu" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email_etu" id="email_etu" required
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="telephone_etu"
                            class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <input type="tel" name="telephone_etu" id="telephone_etu"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                    </div>
                </div>
                <div class="mb-6">
                    <label for="filiere" class="block text-sm font-medium text-gray-700 mb-1">Filière</label>
                    <select name="filiere" id="filiere" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 bg-white">
                        <?php foreach($filieres as $filiere): ?>
                        <option value="<?php echo htmlspecialchars($filiere); ?>">
                            <?php echo htmlspecialchars($filiere); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeEtudiantModal()"
                        class="px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50">Annuler</button>
                    <button type="submit"
                        class="px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600"><i
                            class="fas fa-save mr-2"></i><span
                            id="etudiantModalSubmitButton">Enregistrer</span></button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // JavaScript for Etudiant Modal (similar to User Modal)
    const etudiantModal = document.getElementById('etudiantModal');
    const etudiantForm = document.getElementById('etudiantForm');
    const etudiantModalTitle = document.getElementById('etudiantModalTitle');
    const etudiantModalSubmitButton = document.getElementById('etudiantModalSubmitButton');

    function openEtudiantModal(etudiantData = null) {
        etudiantForm.reset();
        if (etudiantData) {
            etudiantModalTitle.textContent = 'Modifier l\'Étudiant';
            etudiantModalSubmitButton.textContent = 'Mettre à jour';
            // Populate form fields:
            document.getElementById('etudiantId').value = etudiantData.id;
            document.getElementById('num_etudiant').value = etudiantData.num_etudiant;
            document.getElementById('nom').value = etudiantData.nom;
            document.getElementById('prenom').value = etudiantData.prenom;
            // ... (populate other fields like date_naissance, adresse, email_etu, telephone_etu, filiere)
            document.getElementById('email_etu').value = etudiantData.email;
            document.getElementById('filiere').value = etudiantData.filiere;

        } else {
            etudiantModalTitle.textContent = 'Ajouter un Étudiant';
            etudiantModalSubmitButton.textContent = 'Enregistrer';
            document.getElementById('etudiantId').value = '';
        }
        etudiantModal.classList.remove('hidden');
    }

    function closeEtudiantModal() {
        etudiantModal.classList.add('hidden');
    }

    etudiantForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(etudiantForm);
        const data = Object.fromEntries(formData.entries());
        console.log('Submitting etudiant data:', data);
        alert((data.etudiantId ? 'Modification' : 'Ajout') + ' de l\'étudiant ' + data.nom + ' simulé.');
        closeEtudiantModal();
    });
    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && !etudiantModal.classList.contains('hidden')) {
            closeEtudiantModal();
        }
    });
    </script>

</body>

</html>