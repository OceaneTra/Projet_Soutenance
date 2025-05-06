<div class="container">
    <h2>Gestion des Fonctions</h2>

    <div class="card p-4 mb-4">
        <h3 class="text-xl font-semibold mb-4">Ajouter une Fonction</h3>
        <form method="POST" action="/ajouter-fonction">
            <div class="row">
                <div class="col-md-12">
                    <label for="libelle" class="form-label">Libellé de la fonction</label>
                    <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md" required id="libelle" name="libelle" placeholder="Ex : Responsable logistique">
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="mt-2 w-full inline-flex items-center justify-center px-3 py-2 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-green-500 hover:bg-green-600">Ajouter</button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fonction</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
        <!-- Boucle PHP pour afficher les fonctions -->
        </tbody>
    </table>
        <div/>
</div>
