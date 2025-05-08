<?php
// Placeholder data for RH employees
$employes = [
    ['id' => 1, 'matricule' => 'RH001', 'nom' => 'Durand', 'prenom' => 'Sophie', 'poste' => 'Responsable RH', 'departement' => 'Direction', 'email' => 'sophie.durand@example.com'],
    ['id' => 2, 'matricule' => 'RH002', 'nom' => 'Petit', 'prenom' => 'Luc', 'poste' => 'Comptable', 'departement' => 'Finance', 'email' => 'luc.petit@example.com'],
];
$postes = ['Responsable RH', 'Comptable', 'Assistant Administratif', 'Développeur'];
$departements = ['Direction', 'Finance', 'IT', 'Marketing'];
?>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-semibold text-gray-800">Gestion des Ressources Humaines</h1>
        <div>
            <button onclick="openRhModal(null)"
                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md">
                <i class="fas fa-plus mr-2"></i>Ajouter un Employé
            </button>
        </div>
    </div>

    <!-- Action Bar & Table (Similar to gestion_utilisateurs_content.php) -->
    <!-- ... Adapt Search, Print, Export buttons ... -->
    <!-- ... Adapt Table Columns: Matricule, Nom, Prénom, Poste, Département, Email, Actions ... -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center">
        <div class="relative mb-4 sm:mb-0 w-full sm:w-1/3">
            <input type="text" placeholder="Rechercher un employé..."
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

    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Matricule</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Prénom</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poste
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Département</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($employes as $employe): ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo htmlspecialchars($employe['matricule']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($employe['nom']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($employe['prenom']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($employe['poste']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($employe['departement']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <?php echo htmlspecialchars($employe['email']); ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <button onclick='openRhModal(<?php echo json_encode($employe); ?>)'
                                class="text-indigo-600 hover:text-indigo-900 mr-3" title="Modifier"><i
                                    class="fas fa-pencil-alt"></i></button>
                            <button onclick="return confirm('Supprimer cet employé ?');"
                                class="text-red-600 hover:text-red-900" title="Supprimer"><i
                                    class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            <p class="text-sm text-gray-700">Pagination ici...</p>
        </div>
    </div>
</div>

<!-- Add/Edit RH Modal -->
<div id="rhModal"
    class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center hidden z-50">
    <div class="relative mx-auto p-8 border w-full max-w-2xl shadow-2xl rounded-xl bg-white">
        <div class="flex justify-between items-center mb-6">
            <h3 id="rhModalTitle" class="text-2xl font-semibold text-gray-700">Ajouter un Employé</h3>
            <button onclick="closeRhModal()" class="text-gray-400 hover:text-gray-600"><i
                    class="fas fa-times fa-lg"></i></button>
        </div>
        <form id="rhForm">
            <input type="hidden" id="employeId" name="employeId">
            <!-- Form fields: Matricule, Nom, Prénom, Poste, Département, Email, Téléphone, Date d'embauche -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label for="matricule" class="block text-sm font-medium text-gray-700 mb-1">Matricule</label>
                    <input type="text" name="matricule" id="matricule" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label for="nom_rh" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input type="text" name="nom_rh" id="nom_rh" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label for="prenom_rh" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                    <input type="text" name="prenom_rh" id="prenom_rh" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label for="poste" class="block text-sm font-medium text-gray-700 mb-1">Poste</label>
                    <select name="poste" id="poste" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 bg-white">
                        <?php foreach($postes as $posteItem): ?>
                        <option value="<?php echo htmlspecialchars($posteItem); ?>">
                            <?php echo htmlspecialchars($posteItem); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label for="departement" class="block text-sm font-medium text-gray-700 mb-1">Département</label>
                    <select name="departement" id="departement" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 bg-white">
                        <?php foreach($departements as $deptItem): ?>
                        <option value="<?php echo htmlspecialchars($deptItem); ?>">
                            <?php echo htmlspecialchars($deptItem); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="email_rh" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email_rh" id="email_rh" required
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="telephone_rh" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                    <input type="tel" name="telephone_rh" id="telephone_rh"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                </div>
                <div>
                    <label for="date_embauche" class="block text-sm font-medium text-gray-700 mb-1">Date
                        d'embauche</label>
                    <input type="date" name="date_embauche" id="date_embauche"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 bg-white">
                </div>
            </div>
            <div class="flex justify-end space-x-4">
                <button type="button" onclick="closeRhModal()"
                    class="px-6 py-2.5 border border-gray-300 text-sm font-medium rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50">Annuler</button>
                <button type="submit"
                    class="px-6 py-2.5 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-green-500 hover:bg-green-600"><i
                        class="fas fa-save mr-2"></i><span id="rhModalSubmitButton">Enregistrer</span></button>
            </div>
        </form>
    </div>
</div>
<script>
// JavaScript for RH Modal (similar to User/Etudiant Modal)
const rhModal = document.getElementById('rhModal');
const rhForm = document.getElementById('rhForm');
const rhModalTitle = document.getElementById('rhModalTitle');
const rhModalSubmitButton = document.getElementById('rhModalSubmitButton');

function openRhModal(employeData = null) {
    rhForm.reset();
    if (employeData) {
        rhModalTitle.textContent = 'Modifier l\'Employé';
        rhModalSubmitButton.textContent = 'Mettre à jour';
        document.getElementById('employeId').value = employeData.id;
        document.getElementById('matricule').value = employeData.matricule;
        document.getElementById('nom_rh').value = employeData.nom;
        document.getElementById('prenom_rh').value = employeData.prenom;
        document.getElementById('poste').value = employeData.poste;
        document.getElementById('departement').value = employeData.departement;
        document.getElementById('email_rh').value = employeData.email;
        // ... populate other fields
    } else {
        rhModalTitle.textContent = 'Ajouter un Employé';
        rhModalSubmitButton.textContent = 'Enregistrer';
        document.getElementById('employeId').value = '';
    }
    rhModal.classList.remove('hidden');
}

function closeRhModal() {
    rhModal.classList.add('hidden');
}

rhForm.addEventListener('submit', function(event) {
    event.preventDefault();
    // Submit logic
    const formData = new FormData(rhForm);
    const data = Object.fromEntries(formData.entries());
    console.log('Submitting RH data:', data);
    alert((data.employeId ? 'Modification' : 'Ajout') + ' de l\'employé ' + data.nom_rh + ' simulé.');
    closeRhModal();
});
window.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && !rhModal.classList.contains('hidden')) {
        closeRhModal();
    }
});
</script>