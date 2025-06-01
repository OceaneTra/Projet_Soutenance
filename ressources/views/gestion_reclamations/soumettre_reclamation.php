<!-- Contenu de la page de soumission de réclamation -->
<!-- Include Quill rich text editor -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.snow.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/quill/1.3.7/quill.min.js"></script>

<style>
    .ql-toolbar.ql-snow {
        border-radius: 0.5rem 0.5rem 0 0;
        border-color: #d1d5db;
    }

    .ql-container.ql-snow {
        border-radius: 0 0 0.5rem 0.5rem;
        border-color: #d1d5db;
        min-height: 200px;
        font-family: inherit;
    }

    .ql-editor {
        min-height: 200px;
    }
</style>

<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Header -->
        <div class="bg-green-600 px-6 py-4">
            <h1 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i> Nouvelle Réclamation
            </h1>
        </div>

        <!-- Messages d'erreur -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="p-4 <?php echo $_SESSION['message']['type'] === 'success' ? 'bg-green-100 text-green-800 border-green-300' : 'bg-red-100 text-red-800 border-red-300'; ?> border">
                <i class="fas <?php echo $_SESSION['message']['type'] === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> mr-2"></i>
                <?php echo htmlspecialchars($_SESSION['message']['text']); ?>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>

        <?php if (!empty($erreurs)): ?>
            <div class="p-4 bg-red-100 text-red-800 border border-red-300">
                <h4 class="font-bold mb-2">Veuillez corriger les erreurs suivantes :</h4>
                <ul class="list-disc list-inside">
                    <?php foreach ($erreurs as $erreur): ?>
                        <li><?php echo htmlspecialchars($erreur); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Form Container -->
        <div class="p-6">
            <form method="POST" enctype="multipart/form-data" id="reclamationForm">
                <!-- Type de réclamation -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de réclamation*</label>
                    <select name="type" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 <?php echo isset($erreurs['type']) ? 'border-red-500' : ''; ?>">
                        <option value="">Sélectionnez un type...</option>
                        <?php foreach ($typesReclamation as $key => $label): ?>
                            <option value="<?php echo htmlspecialchars($key); ?>"
                                <?php echo (isset($_POST['type']) && $_POST['type'] === $key) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($erreurs['type'])): ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo htmlspecialchars($erreurs['type']); ?></p>
                    <?php endif; ?>
                </div>

                <!-- Objet -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Objet*</label>
                    <input type="text" name="objet" required
                           value="<?php echo htmlspecialchars($_POST['objet'] ?? ''); ?>"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 <?php echo isset($erreurs['titre']) ? 'border-red-500' : ''; ?>"
                           placeholder="Objet de votre réclamation" minlength="5">
                    <?php if (isset($erreurs['titre'])): ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo htmlspecialchars($erreurs['titre']); ?></p>
                    <?php endif; ?>
                </div>

                <!-- Éditeur de texte riche -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description détaillée*</label>
                    <div id="editor" class="bg-white <?php echo isset($erreurs['description']) ? 'border-red-500' : ''; ?>">
                        <?php echo htmlspecialchars($_POST['content'] ?? ''); ?>
                    </div>
                    <input type="hidden" name="content" id="content" required>
                    <?php if (isset($erreurs['description'])): ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo htmlspecialchars($erreurs['description']); ?></p>
                    <?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Minimum 20 caractères requis</p>
                </div>

                <!-- Pièces jointes -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pièces jointes</label>
                    <div class="flex items-center justify-center w-full">
                        <label
                                class="flex flex-col w-full h-32 border-2 border-dashed border-gray-300 hover:border-gray-400 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                            <div class="flex flex-col items-center justify-center pt-7">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                <p class="text-sm text-gray-500">Glissez-déposez vos fichiers ici ou cliquez pour
                                    sélectionner</p>
                                <p class="text-xs text-gray-400 mt-1">PDF, DOC, DOCX, JPG, PNG, TXT jusqu'à 5MB</p>
                            </div>
                            <input type="file" name="fichier_joint" class="hidden"
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.txt">
                        </label>
                    </div>
                    <div id="fileList" class="mt-2 space-y-2"></div>
                </div>

                <!-- Confidentialité -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="confidentiel" value="1"
                               class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                        <span class="ml-2 text-sm text-gray-600">Je souhaite que cette réclamation reste
                            confidentielle</span>
                    </label>
                </div>

                <!-- Informations importantes -->
                <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h4 class="font-medium text-blue-800 mb-2">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informations importantes
                    </h4>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Votre réclamation sera traitée dans les meilleurs délais</li>
                        <li>• Vous recevrez une notification à chaque étape du traitement</li>
                        <li>• Les informations fournies sont confidentielles</li>
                        <li>• Un numéro de référence vous sera attribué pour le suivi</li>
                    </ul>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-3">
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition flex items-center">
                        <i class="fas fa-paper-plane mr-2"></i> Soumettre la réclamation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser l'éditeur de texte riche
        const quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{
                        'header': [1, 2, 3, false]
                    }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{
                        'color': []
                    }, {
                        'background': []
                    }],
                    [{
                        'list': 'ordered'
                    }, {
                        'list': 'bullet'
                    }],
                    ['link'],
                    ['clean']
                ]
            },
            placeholder: 'Décrivez votre réclamation de manière détaillée...'
        });

        // Gestion des fichiers
        const fileInput = document.querySelector('input[type="file"]');
        const fileList = document.getElementById('fileList');

        fileInput.addEventListener('change', function(e) {
            fileList.innerHTML = '';
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const fileItem = document.createElement('div');
                fileItem.className = 'flex items-center justify-between p-2 bg-gray-50 rounded-lg';
                fileItem.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-file-alt text-gray-500 mr-3"></i>
                    <span class="text-sm text-gray-700 truncate max-w-xs">${file.name}</span>
                    <span class="text-xs text-gray-500 ml-2">(${(file.size / 1024 / 1024).toFixed(2)} MB)</span>
                </div>
            `;
                fileList.appendChild(fileItem);
            }
        });

        // Gestion de la soumission du formulaire
        const form = document.getElementById('reclamationForm');
        form.addEventListener('submit', function(e) {
            // Récupérer le contenu HTML de l'éditeur
            const content = document.getElementById('content');
            content.value = quill.root.innerHTML;

            // Validation côté client
            if (quill.getText().trim().length < 20) {
                e.preventDefault();
                alert('La description doit contenir au moins 20 caractères.');
                return false;
            }
        });

        // Compteur de caractères
        const updateCharCount = () => {
            const textLength = quill.getText().trim().length;
            let counter = document.getElementById('charCounter');
            if (!counter) {
                counter = document.createElement('p');
                counter.id = 'charCounter';
                counter.className = 'mt-1 text-sm text-right';
                document.querySelector('#editor').parentNode.appendChild(counter);
            }
            counter.textContent = `${textLength} caractères`;
            counter.className = textLength >= 20 ?
                'mt-1 text-sm text-green-600 text-right' :
                'mt-1 text-sm text-gray-500 text-right';
        };

        quill.on('text-change', updateCharCount);
        updateCharCount();
    });
</script>