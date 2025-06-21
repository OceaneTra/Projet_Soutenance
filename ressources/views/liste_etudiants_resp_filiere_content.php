<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Étudiants MIAGE</title>
</head>

<body class="p-4 sm:p-6 md:p-8">
    <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden md:p-8 p-6">
        <h1 class=" text-4xl font-bold text-gray-900 mb-6 text-center s">Liste des Étudiants <span
                class="text-emerald-600">MIAGE</span></h1>

        <!-- Section de recherche et de filtres -->
        <div class="mb-6 flex flex-wrap gap-4 items-center">
            <input type="text" id="searchInput" placeholder="Rechercher par nom, prénom ou email..."
                class="flex-1 min-w-[200px] p-3 pl-4 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-gray-700 shadow-sm md:text-base text-sm"
                onkeyup="filterStudents()">

            <select id="promotionFilter" onchange="filterStudents()"
                class="p-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-gray-700 shadow-sm md:text-base text-sm">
                <option value="">Toutes les Promotions</option>
                <option value="2025">Promotion 2025</option>
                <option value="2026">Promotion 2026</option>
                <option value="2027">Promotion 2027</option>
            </select>

            <select id="niveauFilter" onchange="filterStudents()"
                class="p-3 border border-gray-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 text-gray-700 shadow-sm md:text-base text-sm">
                <option value="">Tous les Niveaux</option>
                <option value="L3">Licence 3</option>
                <option value="M1">Master 1</option>
                <option value="M2">Master 2</option>
            </select>
        </div>

        <!-- Conteneur pour la liste des étudiants (tableau) -->
        <div id="studentListContainer" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider rounded-tl-lg">
                            Nom
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Prénom
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Promotion
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Niveau
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date de Naissance
                        </th>

                    </tr>
                </thead>
                <tbody id="studentTableBody" class="bg-white divide-y divide-gray-200">
                    <!-- Les lignes des étudiants seront ajoutées ici par JS -->
                </tbody>
            </table>
        </div>

        <!-- Message si aucun étudiant n'est trouvé -->
        <div id="noResults" class="text-center text-gray-500 py-8 hidden">
            Aucun étudiant trouvé pour votre recherche.
        </div>
    </div>

    <script>
    // Données d'exemple pour les étudiants de la filière MIAGE avec promotion et niveau
    // En production, ces données seraient chargées depuis une API ou une base de données.
    const students = [{
            id: 1,
            lastName: 'Dupont',
            firstName: 'Jean',
            email: 'jean.dupont@univ.fr',
            dob: '1999-05-15',
            status: 'Actif',
            promotion: '2025',
            niveau: 'M1'
        },
        {
            id: 2,
            lastName: 'Martin',
            firstName: 'Sophie',
            email: 'sophie.martin@univ.fr',
            dob: '2000-01-20',
            status: 'Actif',
            promotion: '2026',
            niveau: 'L3'
        },
        {
            id: 3,
            lastName: 'Bernard',
            firstName: 'Pierre',
            email: 'pierre.bernard@univ.fr',
            dob: '1998-11-03',
            status: 'Actif',
            promotion: '2025',
            niveau: 'M2'
        },
        {
            id: 4,
            lastName: 'Thomas',
            firstName: 'Marie',
            email: 'marie.thomas@univ.fr',
            dob: '2001-07-22',
            status: 'Inactif',
            promotion: '2027',
            niveau: 'L3'
        },
        {
            id: 5,
            lastName: 'Petit',
            firstName: 'Luc',
            email: 'luc.petit@univ.fr',
            dob: '1999-09-10',
            status: 'Actif',
            promotion: '2026',
            niveau: 'M1'
        },
        {
            id: 6,
            lastName: 'Durand',
            firstName: 'Anna',
            email: 'anna.durand@univ.fr',
            dob: '2000-03-25',
            status: 'Actif',
            promotion: '2025',
            niveau: 'L3'
        },
        {
            id: 7,
            lastName: 'Leroy',
            firstName: 'Paul',
            email: 'paul.leroy@univ.fr',
            dob: '1998-06-08',
            status: 'Actif',
            promotion: '2027',
            niveau: 'M2'
        },
        {
            id: 8,
            lastName: 'Moreau',
            firstName: 'Clara',
            email: 'clara.moreau@univ.fr',
            dob: '2001-02-14',
            status: 'Actif',
            promotion: '2026',
            niveau: 'M2'
        },
        {
            id: 9,
            lastName: 'Simon',
            firstName: 'Louis',
            email: 'louis.simon@univ.fr',
            dob: '1999-12-01',
            status: 'Actif',
            promotion: '2025',
            niveau: 'M1'
        },
        {
            id: 10,
            lastName: 'Roux',
            firstName: 'Emma',
            email: 'emma.roux@univ.fr',
            dob: '2000-10-18',
            status: 'Inactif',
            promotion: '2027',
            niveau: 'M1'
        }
    ];

    const studentTableBody = document.getElementById('studentTableBody');
    const searchInput = document.getElementById('searchInput');
    const promotionFilter = document.getElementById('promotionFilter');
    const niveauFilter = document.getElementById('niveauFilter');
    const noResultsMessage = document.getElementById('noResults');

    /**
     * Affiche la liste des étudiants dans le tableau.
     * @param {Array} studentArray - Le tableau d'étudiants à afficher.
     */
    function displayStudents(studentArray) {
        studentTableBody.innerHTML = ''; // Vide le tableau avant d'ajouter de nouvelles lignes

        if (studentArray.length === 0) {
            noResultsMessage.classList.remove('hidden'); // Affiche le message "aucun résultat"
        } else {
            noResultsMessage.classList.add('hidden'); // Cache le message "aucun résultat"
            studentArray.forEach(student => {
                const row = document.createElement('tr');
                // Ajoute des classes Tailwind pour le style de ligne et l'effet de survol
                row.classList.add('table-row-hover');

                row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 rounded-bl-lg">${student.lastName}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${student.firstName}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-emerald-600 hover:text-emerald-800">${student.email}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${student.promotion}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${student.niveau}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${student.dob}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                ${student.status === 'Actif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                ${student.status}
                            </span>
                        </td>
                    `;
                studentTableBody.appendChild(row);
            });
        }
    }

    /**
     * Filtre les étudiants en fonction de la valeur de recherche et des filtres de promotion/niveau.
     * La recherche est insensible à la casse.
     */
    function filterStudents() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedPromotion = promotionFilter.value;
        const selectedNiveau = niveauFilter.value;

        const filteredStudents = students.filter(student => {
            const matchesSearch = student.lastName.toLowerCase().includes(searchTerm) ||
                student.firstName.toLowerCase().includes(searchTerm) ||
                student.email.toLowerCase().includes(searchTerm);

            const matchesPromotion = selectedPromotion === '' || student.promotion === selectedPromotion;
            const matchesNiveau = selectedNiveau === '' || student.niveau === selectedNiveau;

            // Un étudiant correspond si sa recherche, sa promotion ET son niveau correspondent
            return matchesSearch && matchesPromotion && matchesNiveau;
        });
        displayStudents(filteredStudents); // Affiche les étudiants filtrés
    }

    // Initialisation : affiche tous les étudiants au chargement de la page
    document.addEventListener('DOMContentLoaded', () => {
        displayStudents(students);
    });
    </script>
</body>

</html>