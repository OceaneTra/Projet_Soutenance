<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrement Étudiant | Gestion Scolarité</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    .gradient-bg {
        background: linear-gradient(135deg, #f0f9ff 0%, #e6f7ff 100%);
    }

    .fade-in {
        animation: fadeIn 0.3s ease-in;
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

    .status-badge {
        padding: 0.25rem 0.5rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    <div class="flex h-screen overflow-hidden">

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">


            <!-- Main content area -->
            <div class="flex-1 p-4 md:p-6 overflow-y-auto ">
                <!-- Header with search -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">inscription étudiant</h1>
                        <p class="text-gray-600">Ajouter un nouvel étudiant au système</p>
                    </div>
                    <div class="w-full md:w-96">
                        <div class="search-container relative">
                            <div class="relative">
                                <input type="text" id="studentSearch"
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Rechercher un étudiant existant...">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                            <div id="searchResults" class="search-results hidden"></div>
                        </div>
                    </div>
                </div>

                <!-- Registration form -->
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800">Formulaire d'enregistrement</h2>
                        <p class="text-sm text-gray-600">Remplissez toutes les informations requises</p>
                    </div>
                    <div class="px-6 py-4">
                        <form id="registrationForm">
                            <!-- Personal Information -->
                            <div class="mb-8">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-id-card mr-2 text-blue-500"></i>
                                    Informations personnelles
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">Nom
                                            <span class="text-red-500">*</span></label>
                                        <input type="text" id="lastName" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="firstName"
                                            class="block text-sm font-medium text-gray-700 mb-1">Prénom <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" id="firstName" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="birthDate" class="block text-sm font-medium text-gray-700 mb-1">Date
                                            de naissance <span class="text-red-500">*</span></label>
                                        <input type="date" id="birthDate" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">Genre
                                            <span class="text-red-500">*</span></label>
                                        <select id="gender" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Sélectionner...</option>
                                            <option value="male">Masculin</option>
                                            <option value="female">Féminin</option>
                                            <option value="other">Autre</option>
                                            <option value="prefer_not">Préfère ne pas répondre</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="nationality"
                                            class="block text-sm font-medium text-gray-700 mb-1">Nationalité</label>
                                        <input type="text" id="nationality"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="birthPlace"
                                            class="block text-sm font-medium text-gray-700 mb-1">Lieu de
                                            naissance</label>
                                        <input type="text" id="birthPlace"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Academic Information -->
                            <div class="mb-8">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-graduation-cap mr-2 text-blue-500"></i>
                                    Informations académiques
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="program"
                                            class="block text-sm font-medium text-gray-700 mb-1">Formation <span
                                                class="text-red-500">*</span></label>
                                        <select id="program" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Sélectionner une formation...</option>
                                            <option value="master_info">Master Informatique</option>
                                            <option value="master_management">Master Management</option>
                                            <option value="master_marketing">Master Marketing</option>
                                            <option value="master_finance">Master Finance</option>
                                            <option value="licence_info">Licence Informatique</option>
                                            <option value="licence_eco">Licence Économie</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="promotion"
                                            class="block text-sm font-medium text-gray-700 mb-1">Promotion <span
                                                class="text-red-500">*</span></label>
                                        <select id="promotion" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Sélectionner une promotion...</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email
                                            universitaire <span class="text-red-500">*</span></label>
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <input type="text" id="emailPrefix"
                                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm"
                                                disabled>
                                            <span
                                                class="inline-flex items-center px-3 border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">@univ-example.fr</span>
                                            <input type="hidden" id="email" name="email">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="studentId"
                                            class="block text-sm font-medium text-gray-700 mb-1">Numéro étudiant</label>
                                        <input type="text" id="studentId"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Généré automatiquement" disabled>
                                    </div>
                                    <div>
                                        <label for="registrationDate"
                                            class="block text-sm font-medium text-gray-700 mb-1">Date d'inscription
                                            <span class="text-red-500">*</span></label>
                                        <input type="date" id="registrationDate" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut
                                            <span class="text-red-500">*</span></label>
                                        <select id="status" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            <option value="active" selected>Actif</option>
                                            <option value="exchange">Échange</option>
                                            <option value="distance">Formation à distance</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="mb-8">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-address-book mr-2 text-blue-500"></i>
                                    Informations de contact
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="address"
                                            class="block text-sm font-medium text-gray-700 mb-1">Adresse <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" id="address" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Ville
                                            <span class="text-red-500">*</span></label>
                                        <input type="text" id="city" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="postalCode"
                                            class="block text-sm font-medium text-gray-700 mb-1">Code postal <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" id="postalCode" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">Pays
                                            <span class="text-red-500">*</span></label>
                                        <input type="text" id="country" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="phone"
                                            class="block text-sm font-medium text-gray-700 mb-1">Téléphone <span
                                                class="text-red-500">*</span></label>
                                        <input type="tel" id="phone" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="personalEmail"
                                            class="block text-sm font-medium text-gray-700 mb-1">Email personnel</label>
                                        <input type="email" id="personalEmail"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Emergency Contact -->
                            <div class="mb-8">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-2 text-blue-500"></i>
                                    Contact d'urgence
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="emergencyContact"
                                            class="block text-sm font-medium text-gray-700 mb-1">Nom complet <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" id="emergencyContact" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="emergencyRelation"
                                            class="block text-sm font-medium text-gray-700 mb-1">Relation <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" id="emergencyRelation" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                            placeholder="Parent, conjoint, etc.">
                                    </div>
                                    <div>
                                        <label for="emergencyPhone"
                                            class="block text-sm font-medium text-gray-700 mb-1">Téléphone <span
                                                class="text-red-500">*</span></label>
                                        <input type="tel" id="emergencyPhone" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="emergencyEmail"
                                            class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email" id="emergencyEmail"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Documents -->
                            <div class="mb-8">
                                <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                                    <i class="fas fa-file-alt mr-2 text-blue-500"></i>
                                    Documents requis
                                </h3>
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <input id="docId" name="documents" type="checkbox"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="docId" class="ml-2 block text-sm text-gray-700">
                                            Pièce d'identité (CNI/Passeport)
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="docPhoto" name="documents" type="checkbox"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="docPhoto" class="ml-2 block text-sm text-gray-700">
                                            Photo d'identité
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="docDiploma" name="documents" type="checkbox"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="docDiploma" class="ml-2 block text-sm text-gray-700">
                                            Diplôme ou attestation de réussite
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="docResume" name="documents" type="checkbox"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="docResume" class="ml-2 block text-sm text-gray-700">
                                            Curriculum Vitae
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="docMotivation" name="documents" type="checkbox"
                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="docMotivation" class="ml-2 block text-sm text-gray-700">
                                            Lettre de motivation
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Form actions -->
                            <div class="pt-5 border-t border-gray-200">
                                <div class="flex justify-end space-x-3">
                                    <button type="reset"
                                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                                        <i class="fas fa-times mr-2"></i>Annuler
                                    </button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition flex items-center justify-center">
                                        <i class="fas fa-user-plus mr-2"></i>Enregistrer l'étudiant
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Generate student email based on first and last name
    document.getElementById('firstName').addEventListener('input', updateEmail);
    document.getElementById('lastName').addEventListener('input', updateEmail);

    function updateEmail() {
        const firstName = document.getElementById('firstName').value.toLowerCase();
        const lastName = document.getElementById('lastName').value.toLowerCase();

        if (firstName && lastName) {
            const emailPrefix = `${firstName.charAt(0)}.${lastName}`.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            document.getElementById('emailPrefix').value = emailPrefix;
            document.getElementById('email').value = `${emailPrefix}@univ-example.fr`;

            // Generate student ID (example format)
            const currentYear = new Date().getFullYear().toString().slice(-2);
            const randomNum = Math.floor(1000 + Math.random() * 9000);
            document.getElementById('studentId').value = `ST${currentYear}${randomNum}`;
        }
    }

    // Set registration date to today by default
    document.getElementById('registrationDate').valueAsDate = new Date();

    // Student search functionality
    const studentSearch = document.getElementById('studentSearch');
    const searchResults = document.getElementById('searchResults');

    studentSearch.addEventListener('input', function() {
        if (this.value.length > 2) {
            // Simulate API call with timeout
            setTimeout(() => {
                const mockResults = [{
                        id: 1,
                        name: "Sophie Martin",
                        program: "Master Informatique",
                        promo: "2023",
                        email: "s.martin@univ-example.fr"
                    },
                    {
                        id: 2,
                        name: "Pierre Dupont",
                        program: "Licence Économie",
                        promo: "2024",
                        email: "p.dupont@univ-example.fr"
                    },
                    {
                        id: 3,
                        name: "Jean Bernard",
                        program: "Master Finance",
                        promo: "2023",
                        email: "j.bernard@univ-example.fr"
                    },
                    {
                        id: 4,
                        name: "Marie Leroy",
                        program: "Master Marketing",
                        promo: "2025",
                        email: "m.leroy@univ-example.fr"
                    }
                ].filter(student =>
                    student.name.toLowerCase().includes(this.value.toLowerCase()) ||
                    student.email.toLowerCase().includes(this.value.toLowerCase())
                );

                displaySearchResults(mockResults);
            }, 300);
        } else {
            searchResults.classList.add('hidden');
        }
    });

    function displaySearchResults(results) {
        searchResults.innerHTML = '';

        if (results.length > 0) {
            results.forEach(student => {
                const item = document.createElement('div');
                item.className = 'search-item';
                item.innerHTML = `
                        <div class="font-medium">${student.name}</div>
                        <div class="text-sm text-gray-500">${student.program} - Promo ${student.promo}</div>
                        <div class="text-xs text-gray-400">${student.email}</div>
                    `;
                item.addEventListener('click', () => {
                    // Fill form with selected student data (simulated)
                    alert(`Chargement des données de ${student.name}...`);
                    studentSearch.value = student.name;
                    searchResults.classList.add('hidden');
                });
                searchResults.appendChild(item);
            });
            searchResults.classList.remove('hidden');
        } else {
            const noResults = document.createElement('div');
            noResults.className = 'search-item text-gray-500';
            noResults.textContent = 'Aucun étudiant trouvé';
            searchResults.appendChild(noResults);
            searchResults.classList.remove('hidden');
        }
    }

    // Hide search results when clicking outside
    document.addEventListener('click', function(e) {
        if (!studentSearch.contains(e.target) && !searchResults.contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });

    // Form submission
    document.getElementById('registrationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Étudiant enregistré avec succès!');
        // Here you would typically send the form data to your backend
    });
    </script>
</body>

</html>