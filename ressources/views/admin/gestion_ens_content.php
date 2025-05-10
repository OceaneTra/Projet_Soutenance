<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Enseignants</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Gestion des Enseignants</h1>

        <!-- Formulaire d'ajout/modification -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-700 mb-4" id="form-title">Ajouter un nouvel enseignant</h2>
            <form id="teacher-form">
                <input type="hidden" id="teacher-id">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="last-name" class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" id="last-name" name="last-name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="first-name" class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <input type="text" id="first-name" name="first-name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <input type="tel" id="phone" name="phone"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Matière
                            enseignée</label>
                        <select id="subject" name="subject"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Sélectionnez une matière</option>
                            <option value="Mathématiques">Mathématiques</option>
                            <option value="Physique">Physique</option>
                            <option value="Chimie">Chimie</option>
                            <option value="Informatique">Informatique</option>
                            <option value="Français">Français</option>
                            <option value="Histoire-Géographie">Histoire-Géographie</option>
                            <option value="Anglais">Anglais</option>
                            <option value="Espagnol">Espagnol</option>
                            <option value="Allemand">Allemand</option>
                            <option value="SVT">SVT</option>
                            <option value="EPS">EPS</option>
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select id="status" name="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="Actif">Actif</option>
                            <option value="En congé">En congé</option>
                            <option value="Retraité">Retraité</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-end space-x-4">
                    <button type="button" id="cancel-btn"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Annuler
                    </button>
                    <button type="submit" id="submit-btn"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>

        <!-- Tableau des enseignants -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-4 sm:mb-0">Liste des enseignants</h2>
                <div class="w-full sm:w-auto flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                    <div class="relative">
                        <input type="text" id="search"
                            class="pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Rechercher...">
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button id="export-btn"
                            class="px-3 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <i class="fas fa-file-export mr-1"></i> Exporter
                        </button>
                        <button id="print-btn"
                            class="px-3 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            <i class="fas fa-print mr-1"></i> Imprimer
                        </button>
                        <button id="delete-selected-btn"
                            class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500"
                            disabled>
                            <i class="fas fa-trash-alt mr-1"></i> Supprimer
                        </button>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="w-10 py-2 px-3 text-left">
                                <input type="checkbox" id="select-all"
                                    class="rounded text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="py-2 px-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                                Nom</th>
                            <th class="py-2 px-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                                Prénom</th>
                            <th class="py-2 px-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                                Email</th>
                            <th class="py-2 px-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                                Téléphone</th>
                            <th class="py-2 px-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                                Matière</th>
                            <th class="py-2 px-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                                Statut</th>
                            <th class="py-2 px-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Les données seront chargées dynamiquement ici -->
                    </tbody>
                </table>
            </div>
            <div class="mt-4 flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    <span id="selected-count">0</span> sur <span id="total-count">0</span> enseignants sélectionnés
                </div>
                <div class="flex space-x-2">
                    <button id="prev-page"
                        class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <div class="text-sm text-gray-500 py-1">
                        Page <span id="current-page">1</span> sur <span id="total-pages">1</span>
                    </div>
                    <button id="next-page"
                        class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation pour la suppression -->
    <div id="delete-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 max-w-md mx-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Confirmer la suppression</h3>
            <p class="text-gray-700 mb-6">Êtes-vous sûr de vouloir supprimer <span id="delete-count">0</span>
                enseignant(s) ? Cette action est irréversible.</p>
            <div class="flex justify-end space-x-4">
                <button id="cancel-delete"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Annuler
                </button>
                <button id="confirm-delete"
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                    Supprimer
                </button>
            </div>
        </div>
    </div>

    <script>
    // Données d'exemple des enseignants
    let teachers = [{
            id: 1,
            lastName: 'Dubois',
            firstName: 'Marie',
            email: 'marie.dubois@email.com',
            phone: '01 23 45 67 89',
            subject: 'Mathématiques',
            status: 'Actif'
        },
        {
            id: 2,
            lastName: 'Martin',
            firstName: 'Pierre',
            email: 'pierre.martin@email.com',
            phone: '01 23 45 67 90',
            subject: 'Physique',
            status: 'Actif'
        },
        {
            id: 3,
            lastName: 'Bernard',
            firstName: 'Sophie',
            email: 'sophie.bernard@email.com',
            phone: '01 23 45 67 91',
            subject: 'Français',
            status: 'En congé'
        },
        {
            id: 4,
            lastName: 'Petit',
            firstName: 'Thomas',
            email: 'thomas.petit@email.com',
            phone: '01 23 45 67 92',
            subject: 'Histoire-Géographie',
            status: 'Actif'
        },
        {
            id: 5,
            lastName: 'Robert',
            firstName: 'Julie',
            email: 'julie.robert@email.com',
            phone: '01 23 45 67 93',
            subject: 'Anglais',
            status: 'Actif'
        },
        {
            id: 6,
            lastName: 'Richard',
            firstName: 'Nicolas',
            email: 'nicolas.richard@email.com',
            phone: '01 23 45 67 94',
            subject: 'SVT',
            status: 'Retraité'
        },
        {
            id: 7,
            lastName: 'Durand',
            firstName: 'Émilie',
            email: 'emilie.durand@email.com',
            phone: '01 23 45 67 95',
            subject: 'Informatique',
            status: 'Actif'
        },
        {
            id: 8,
            lastName: 'Moreau',
            firstName: 'Lucas',
            email: 'lucas.moreau@email.com',
            phone: '01 23 45 67 96',
            subject: 'EPS',
            status: 'Actif'
        },
    ];

    // Variables pour la pagination et la recherche
    let currentPage = 1;
    let itemsPerPage = 5;
    let filteredTeachers = [...teachers];
    let selectedTeachers = new Set();
    let isEditMode = false;
    let currentEditId = null;

    // Sélection des éléments DOM
    const tableBody = document.querySelector('tbody');
    const selectAllCheckbox = document.getElementById('select-all');
    const searchInput = document.getElementById('search');
    const deleteSelectedBtn = document.getElementById('delete-selected-btn');
    const deleteModal = document.getElementById('delete-modal');
    const cancelDeleteBtn = document.getElementById('cancel-delete');
    const confirmDeleteBtn = document.getElementById('confirm-delete');
    const deleteCountSpan = document.getElementById('delete-count');
    const selectedCountSpan = document.getElementById('selected-count');
    const totalCountSpan = document.getElementById('total-count');
    const currentPageSpan = document.getElementById('current-page');
    const totalPagesSpan = document.getElementById('total-pages');
    const prevPageBtn = document.getElementById('prev-page');
    const nextPageBtn = document.getElementById('next-page');
    const teacherForm = document.getElementById('teacher-form');
    const formTitle = document.getElementById('form-title');
    const lastNameInput = document.getElementById('last-name');
    const firstNameInput = document.getElementById('first-name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const subjectSelect = document.getElementById('subject');
    const statusSelect = document.getElementById('status');
    const teacherIdInput = document.getElementById('teacher-id');
    const submitBtn = document.getElementById('submit-btn');
    const cancelBtn = document.getElementById('cancel-btn');
    const exportBtn = document.getElementById('export-btn');
    const printBtn = document.getElementById('print-btn');

    // Fonction pour charger les données dans le tableau
    function loadTeacherData() {
        // Calculer le nombre total de pages
        const totalPages = Math.ceil(filteredTeachers.length / itemsPerPage);
        totalPagesSpan.textContent = totalPages;
        currentPageSpan.textContent = currentPage;
        totalCountSpan.textContent = filteredTeachers.length;

        // Déterminer les éléments à afficher pour la page courante
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = Math.min(startIndex + itemsPerPage, filteredTeachers.length);
        const currentTeachers = filteredTeachers.slice(startIndex, endIndex);

        // Vider le contenu du tableau
        tableBody.innerHTML = '';

        // Ajouter les enseignants à la page courante
        currentTeachers.forEach(teacher => {
            const row = document.createElement('tr');
            row.classList.add('border-b', 'hover:bg-gray-50');

            // Déterminer si l'enseignant est sélectionné
            const isSelected = selectedTeachers.has(teacher.id);
            if (isSelected) {
                row.classList.add('bg-blue-50');
            }

            row.innerHTML = `
                    <td class="py-3 px-3">
                        <input type="checkbox" class="teacher-checkbox rounded text-blue-600 focus:ring-blue-500" data-id="${teacher.id}" ${isSelected ? 'checked' : ''}>
                    </td>
                    <td class="py-3 px-3 text-sm text-gray-900">${teacher.lastName}</td>
                    <td class="py-3 px-3 text-sm text-gray-900">${teacher.firstName}</td>
                    <td class="py-3 px-3 text-sm text-gray-900">${teacher.email}</td>
                    <td class="py-3 px-3 text-sm text-gray-900">${teacher.phone}</td>
                    <td class="py-3 px-3 text-sm text-gray-900">${teacher.subject}</td>
                    <td class="py-3 px-3 text-sm">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${
                            teacher.status === 'Actif' ? 'bg-green-100 text-green-800' : 
                            teacher.status === 'En congé' ? 'bg-yellow-100 text-yellow-800' : 
                            'bg-gray-100 text-gray-800'
                        }">${teacher.status}</span>
                    </td>
                    <td class="py-3 px-3 text-sm flex space-x-2">
                        <button class="edit-btn text-blue-600 hover:text-blue-800" data-id="${teacher.id}">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="delete-btn text-red-600 hover:text-red-800" data-id="${teacher.id}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                `;

            tableBody.appendChild(row);
        });

        // Mettre à jour l'état des boutons de pagination
        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === totalPages;

        // Ajouter les écouteurs d'événements aux cases à cocher
        document.querySelectorAll('.teacher-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', handleCheckboxChange);
        });

        // Ajouter les écouteurs d'événements aux boutons d'édition et de suppression
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', handleEdit);
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', handleSingleDelete);
        });

        // Mettre à jour l'état du bouton de suppression
        updateDeleteButton();
    }

    // Fonction pour filtrer les enseignants en fonction de la recherche
    function filterTeachers() {
        const searchTerm = searchInput.value.toLowerCase();

        if (searchTerm === '') {
            filteredTeachers = [...teachers];
        } else {
            filteredTeachers = teachers.filter(teacher => {
                return (
                    teacher.lastName.toLowerCase().includes(searchTerm) ||
                    teacher.firstName.toLowerCase().includes(searchTerm) ||
                    teacher.email.toLowerCase().includes(searchTerm) ||
                    teacher.phone.toLowerCase().includes(searchTerm) ||
                    teacher.subject.toLowerCase().includes(searchTerm) ||
                    teacher.status.toLowerCase().includes(searchTerm)
                );
            });
        }

        // Réinitialiser la page courante à 1 après une recherche
        currentPage = 1;
        loadTeacherData();
    }

    // Fonction pour gérer le changement d'état des cases à cocher
    function handleCheckboxChange(e) {
        const teacherId = parseInt(e.target.dataset.id);

        if (e.target.checked) {
            selectedTeachers.add(teacherId);
        } else {
            selectedTeachers.delete(teacherId);
        }

        // Mettre à jour l'état du bouton "Tout sélectionner"
        const allCheckboxes = document.querySelectorAll('.teacher-checkbox');
        const allChecked = Array.from(allCheckboxes).every(cb => cb.checked);
        selectAllCheckbox.checked = allChecked && allCheckboxes.length > 0;

        // Mettre à jour l'affichage du nombre d'éléments sélectionnés
        selectedCountSpan.textContent = selectedTeachers.size;

        // Mettre à jour l'état du bouton de suppression
        updateDeleteButton();

        // Mettre à jour la classe de la ligne
        const row = e.target.closest('tr');
        if (e.target.checked) {
            row.classList.add('bg-blue-50');
        } else {
            row.classList.remove('bg-blue-50');
        }
    }

    // Fonction pour mettre à jour l'état du bouton de suppression
    function updateDeleteButton() {
        deleteSelectedBtn.disabled = selectedTeachers.size === 0;
    }

    // Fonction pour gérer l'édition d'un enseignant
    function handleEdit(e) {
        const teacherId = parseInt(e.currentTarget.dataset.id);
        const teacher = teachers.find(t => t.id === teacherId);

        if (teacher) {
            isEditMode = true;
            currentEditId = teacherId;
            formTitle.textContent = `Modifier les informations de ${teacher.firstName} ${teacher.lastName}`;
            lastNameInput.value = teacher.lastName;
            firstNameInput.value = teacher.firstName;
            emailInput.value = teacher.email;
            phoneInput.value = teacher.phone;
            subjectSelect.value = teacher.subject;
            statusSelect.value = teacher.status;
            teacherIdInput.value = teacher.id;
            submitBtn.textContent = 'Mettre à jour';

            // Faire défiler jusqu'au formulaire
            teacherForm.scrollIntoView({
                behavior: 'smooth'
            });
        }
    }

    // Fonction pour gérer la suppression d'un seul enseignant
    function handleSingleDelete(e) {
        const teacherId = parseInt(e.currentTarget.dataset.id);
        selectedTeachers.clear();
        selectedTeachers.add(teacherId);
        deleteCountSpan.textContent = 1;

        // Afficher la modale de confirmation
        deleteModal.classList.remove('hidden');
    }

    // Fonction pour gérer la suppression multiple
    function handleMultipleDelete() {
        deleteCountSpan.textContent = selectedTeachers.size;

        // Afficher la modale de confirmation
        deleteModal.classList.remove('hidden');
    }

    // Fonction pour confirmer la suppression
    function confirmDelete() {
        // Supprimer les enseignants sélectionnés
        teachers = teachers.filter(teacher => !selectedTeachers.has(teacher.id));

        // Réinitialiser la sélection
        selectedTeachers.clear();
        selectedCountSpan.textContent = 0;
        selectAllCheckbox.checked = false;

        // Mettre à jour le filtre et recharger les données
        filterTeachers();

        // Fermer la modale
        deleteModal.classList.add('hidden');

        // Mettre à jour l'état du bouton de suppression
        updateDeleteButton();
    }

    // Fonction pour exporter les données
    function exportData() {
        // Créer un tableau avec les données sélectionnées ou toutes les données
        const dataToExport = selectedTeachers.size > 0 ?
            teachers.filter(teacher => selectedTeachers.has(teacher.id)) :
            teachers;

        // Convertir en CSV
        const headers = ['ID', 'Nom', 'Prénom', 'Email', 'Téléphone', 'Matière', 'Statut'];
        const csvContent = [
            headers.join(','),
            ...dataToExport.map(teacher => [
                teacher.id,
                teacher.lastName,
                teacher.firstName,
                teacher.email,
                teacher.phone,
                teacher.subject,
                teacher.status
            ].join(','))
        ].join('\n');

        // Créer un blob et un lien de téléchargement
        const blob = new Blob([csvContent], {
            type: 'text/csv;charset=utf-8;'
        });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);

        link.setAttribute('href', url);
        link.setAttribute('download', 'enseignants.csv');
        link.style.visibility = 'hidden';

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    // Fonction pour imprimer les données
    function printData() {
        // Créer une fenêtre d'impression
        const printWindow = window.open('', '_blank');
        const dataToExport = selectedTeachers.size > 0 ?
            teachers.filter(teacher => selectedTeachers.has(teacher.id)) :
            teachers;

        // Préparer le contenu HTML à imprimer
        let printContent = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Liste des enseignants</title>
                    <style>
                        body { font-family: Arial, sans-serif; }
                        h1 { color: #333; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
                        th { background-color: #f2f2f2; }
                    </style>
                </head>
                <body>
                    <h1>Liste des enseignants</h1>
                    <table>
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Matière</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

        dataToExport.forEach(teacher => {
            printContent += `
                    <tr>
                        <td>${teacher.lastName}</td>
                        <td>${teacher.firstName}</td>
                        <td>${teacher.email}</td>
                        <td>${teacher.phone}</td>
                        <td>${teacher.subject}</td>
                        <td>${teacher.status}</td>
                    </tr>
                `;
        });

        printContent += `
                        </tbody>
                    </table>
                </body>
                </html>
            `;

        // Écrire le contenu et imprimer
        printWindow.document.open();
        printWindow.document.write(printContent);
        printWindow.document.close();
        printWindow.onload = function() {
            printWindow.print();
        };
    }

    // Fonction pour soumettre le formulaire
    function submitForm(e) {
        e.preventDefault();

        // Récupérer les valeurs du formulaire
        const lastName = lastNameInput.value.trim();
        const firstName = firstNameInput.value.trim();
        const email = emailInput.value.trim();
        const phone = phoneInput.value.trim();
        const subject = subjectSelect.value;
        const status = statusSelect.value;

        // Validation basique
        if (!lastName || !firstName || !email) {
            alert('Veuillez remplir tous les champs obligatoires.');
            return;
        }

        if (isEditMode) {
            // Mise à jour d'un enseignant existant
            const index = teachers.findIndex(t => t.id === currentEditId);
            if (index !== -1) {
                teachers[index] = {
                    id: currentEditId,
                    lastName,
                    firstName,
                    email,
                    phone,
                    subject,
                    status
                };
            }
        } else {
            // Ajout d'un nouvel enseignant
            const newId = teachers.length > 0 ? Math.max(...teachers.map(t => t.id)) + 1 : 1;
            teachers.push({
                id: newId,
                lastName,
                firstName,
                email,
                phone,
                subject,
                status
            });
        }

        // Réinitialiser le formulaire
        resetForm();

        // Recharger les données
        filterTeachers();
    }

    // Fonction pour réinitialiser le formulaire
    function resetForm() {
        teacherForm.reset();
        isEditMode = false;
        currentEditId = null;
        formTitle.textContent = 'Ajouter un nouvel enseignant';
        submitBtn.textContent = 'Enregistrer';
    }

    // Initialisation
    function init() {
        // Charger les données initiales
        loadTeacherData();
        selectedCountSpan.textContent = 0;
        totalCountSpan.textContent = teachers.length;
    }