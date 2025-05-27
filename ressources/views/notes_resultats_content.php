<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portail Étudiant - Mes Résultats</title>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="mb-10 text-center animate-fade-in">
            <h1 class="text-4xl font-bold text-green-800 mb-2">Mon Portail Académique</h1>
            <p class="text-xl text-green-600">Consultez vos résultats et bulletins de notes</p>
            <div class="flex justify-center mt-4">
                <div class="bg-white rounded-full shadow-md px-6 py-2 inline-flex items-center">
                    <i class="fas fa-user-graduate text-indigo-500 mr-2"></i>
                    <span class="font-medium">Étudiant: Jean Dupont | Numéro étudiant: 123456</span>
                </div>
            </div>
        </header>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="card-gradient-1 rounded-xl shadow-lg p-6 flex items-center animate-fade-in">
                <div class="bg-blue-100 p-3 rounded-full mr-4">
                    <i class="fas fa-book text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-white text-sm">Moyenne Générale</p>
                    <h3 class="text-2xl font-bold text-white">15.8/20</h3>
                </div>
            </div>

            <div class="card-gradient-2 rounded-xl shadow-lg p-6 flex items-center animate-fade-in">
                <div class="bg-green-100 p-3 rounded-full mr-4">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-white text-sm">Unités Validées</p>
                    <h3 class="text-2xl font-bold text-white">8/10</h3>
                </div>
            </div>

            <div class="card-gradient-3 rounded-xl shadow-lg p-6 flex items-center animate-fade-in">
                <div class="bg-amber-100 p-3 rounded-full mr-4">
                    <i class="fas fa-chart-line text-amber-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-white text-sm">Classement</p>
                    <h3 class="text-2xl font-bold text-white">25ème/150</h3>
                </div>
            </div>

            <div class="bg-purple-500 rounded-xl shadow-lg p-6 flex items-center animate-fade-in">
                <div class="bg-purple-100 p-3 rounded-full mr-4">
                    <i class="fas fa-clock text-purple-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-white text-sm">Prochaine Session</p>
                    <h3 class="text-2xl font-bold text-white">Jan 2024</h3>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-fade-in">
            <!-- Toolbar -->
            <div class="bg-indigo-700 px-6 py-4 flex flex-wrap justify-between items-center">
                <h2 class="text-xl font-bold text-white">
                    <i class="fas fa-table mr-2"></i> Bulletin de Notes
                </h2>
                <div class="flex space-x-2 mt-2 sm:mt-0">
                    <button id="printBtn"
                        class="bg-white text-indigo-700 px-4 py-2 rounded-lg hover:bg-indigo-50 transition flex items-center">
                        <i class="fas fa-print mr-2"></i> Imprimer
                    </button>
                    <button id="pdfBtn"
                        class="bg-white text-indigo-700 px-4 py-2 rounded-lg hover:bg-indigo-50 transition flex items-center">
                        <i class="fas fa-file-pdf mr-2"></i> PDF
                    </button>
                    <button id="exportBtn"
                        class="bg-white text-indigo-700 px-4 py-2 rounded-lg hover:bg-indigo-50 transition flex items-center">
                        <i class="fas fa-file-excel mr-2"></i> Excel
                    </button>
                    <div class="relative">
                        <select id="semesterFilter"
                            class="appearance-none bg-white text-indigo-700 pl-4 pr-8 py-2 rounded-lg hover:bg-indigo-50 transition cursor-pointer">
                            <option value="all">Tous les semestres</option>
                            <option value="1">Semestre 1</option>
                            <option value="2">Semestre 2</option>
                            <option value="3">Semestre 3</option>
                            <option value="4">Semestre 4</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3 text-indigo-700 pointer-events-none"></i>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200" id="gradesTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Module</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Professeur</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Crédits</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Note</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Appréciation</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Semestre</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Algorithmique Avancée</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">Prof. Martin</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">6</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="grade-A px-3 py-1 rounded-full text-sm font-semibold">17.5</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">Excellent travail</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">1</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Base de Données</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">Prof. Dubois</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">5</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="grade-B px-3 py-1 rounded-full text-sm font-semibold">14.0</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">Bon résultat</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">1</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Développement Web</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">Prof. Lambert</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">4</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="grade-A px-3 py-1 rounded-full text-sm font-semibold">18.2</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">Exceptionnel</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">2</td>
                        </tr>
                        <tr class="bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Réseaux</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">Prof. Nguyen</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">5</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="grade-C px-3 py-1 rounded-full text-sm font-semibold">11.5</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">Peut mieux faire</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">2</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">IA</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">Prof. Zhang</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">6</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="grade-A px-3 py-1 rounded-full text-sm font-semibold">16.8</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">Très bonne compréhension</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">3</td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>


    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation des éléments
        gsap.from(".animate-fade-in", {
            opacity: 0,
            y: 20,
            duration: 0.6,
            stagger: 0.1,
            ease: "power2.out"
        });

        // Filtrage par semestre
        const semesterFilter = document.getElementById('semesterFilter');
        semesterFilter.addEventListener('change', function() {
            const selectedSemester = this.value;
            const rows = document.querySelectorAll('#gradesTable tbody tr');

            rows.forEach(row => {
                const semesterCell = row.querySelector('td:nth-child(6)');
                if (selectedSemester === 'all' || semesterCell.textContent ===
                    selectedSemester) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Bouton Imprimer
        document.getElementById('printBtn').addEventListener('click', function() {
            window.print();
        });

        // Bouton PDF (utilisant jsPDF et html2canvas)
        document.getElementById('pdfBtn').addEventListener('click', function() {
            const {
                jsPDF
            } = window.jspdf;
            const element = document.querySelector('.bg-white.rounded-2xl');

            html2canvas(element).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('p', 'mm', 'a4');
                const imgProps = pdf.getImageProperties(imgData);
                const pdfWidth = pdf.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                pdf.save('bulletin-notes.pdf');
            });
        });

        // Bouton Export Excel (simulé)
        document.getElementById('exportBtn').addEventListener('click', function() {
            alert('Exportation vers Excel en cours... (fonctionnalité simulée)');
            // En réalité, vous utiliseriez une librairie comme SheetJS
        });

        // Effet hover sur les lignes du tableau
        const tableRows = document.querySelectorAll('#gradesTable tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', () => {
                row.classList.add('bg-indigo-50');
            });
            row.addEventListener('mouseleave', () => {
                row.classList.remove('bg-indigo-50');
            });
        });
    });
    </script>
</body>

</html>