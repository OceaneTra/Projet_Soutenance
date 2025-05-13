<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soumettre une Réclamation</title>
    <!-- Include Quill rich text editor -->

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
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-green-600 px-6 py-4">
                <h1 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i> Nouvelle Réclamation
                </h1>
            </div>

            <!-- Form Container -->
            <div class="p-6">
                <form id="reclamationForm">
                    <!-- Type de réclamation -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Type de réclamation*</label>
                        <select
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Sélectionnez un type...</option>
                            <option value="academic">Problème académique</option>
                            <option value="administrative">Problème administratif</option>
                            <option value="technical">Problème technique</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>

                    <!-- Objet -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Objet*</label>
                        <input type="text"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                            placeholder="Objet de votre réclamation" required>
                    </div>

                    <!-- Éditeur de texte riche -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description détaillée*</label>
                        <div id="editor" class="bg-white"></div>
                        <input type="hidden" name="content" id="content">
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
                                </div>
                                <input type="file" class="hidden" multiple>
                            </label>
                        </div>
                        <div id="fileList" class="mt-2 space-y-2"></div>
                    </div>

                    <!-- Confidentialité -->
                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <span class="ml-2 text-sm text-gray-600">Je souhaite que cette réclamation reste
                                confidentielle</span>
                        </label>
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-end space-x-3">
                        <button type="button"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                            Annuler
                        </button>
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition flex items-center">
                            <i class="fas fa-paper-plane mr-2"></i> Soumettre la réclamation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation -->
    <div id="confirmationModal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl shadow-lg p-6 max-w-md w-full mx-4">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                    <i class="fas fa-check text-green-600"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-3">Réclamation soumise avec succès</h3>
                <div class="mt-2 text-sm text-gray-500">
                    <p>Votre réclamation a bien été enregistrée sous le numéro <span
                            class="font-bold">#REC-2023-4567</span>.</p>
                    <p class="mt-2">Vous recevrez une réponse dans les 5 jours ouvrés.</p>
                </div>
                <div class="mt-4">
                    <button id="closeModal" type="button"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
                        Fermer
                    </button>
                </div>
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
                    ['link', 'image'],
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
            Array.from(e.target.files).forEach(file => {
                const fileItem = document.createElement('div');
                fileItem.className =
                    'flex items-center justify-between p-2 bg-gray-50 rounded-lg';
                fileItem.innerHTML = `
                        <div class="flex items-center">
                            <i class="fas fa-file-alt text-gray-500 mr-3"></i>
                            <span class="text-sm text-gray-700 truncate max-w-xs">${file.name}</span>
                        </div>
                        <button class="text-red-500 hover:text-red-700">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                fileList.appendChild(fileItem);
            });
        });

        // Gestion de la soumission du formulaire
        const form = document.getElementById('reclamationForm');
        const confirmationModal = document.getElementById('confirmationModal');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            // Récupérer le contenu HTML de l'éditeur
            const content = document.getElementById('content');
            content.value = quill.root.innerHTML;

            // Simuler l'envoi (en production, vous feriez une requête AJAX ici)
            setTimeout(() => {
                confirmationModal.classList.remove('hidden');
            }, 1000);
        });

        // Fermer la modal
        document.getElementById('closeModal').addEventListener('click', function() {
            confirmationModal.classList.add('hidden');
            form.reset();
            quill.root.innerHTML = '';
            fileList.innerHTML = '';
        });
    });
    </script>
</body>

</html>