<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Étudiant</title>
    <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: {
                        50: '#f0fdf4',
                        100: '#dcfce7',
                        200: '#bbf7d0',
                        300: '#86efac',
                        400: '#4ade80',
                        500: '#22c55e',
                        600: '#16a34a',
                        700: '#15803d',
                        800: '#166534',
                        900: '#14532d',
                    },
                    secondary: {
                        50: '#eff6ff',
                        100: '#dbeafe',
                        200: '#bfdbfe',
                        300: '#93c5fd',
                        400: '#60a5fa',
                        500: '#3b82f6',
                        600: '#2563eb',
                        700: '#1d4ed8',
                        800: '#1e40af',
                        900: '#1e3a8a',
                    },
                    accent: {
                        400: '#f59e0b',
                        500: '#f97316',
                        600: '#ea580c',
                    }
                }
            }
        }
    }
    </script>
</head>

<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header avec photo de profil -->
        <header class="flex flex-col md:flex-row items-center gap-6 mb-10 bg-white rounded-2xl shadow-md p-6">
            <div class="relative">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Photo étudiant"
                    class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover">
            </div>
            <div class="text-center md:text-left">
                <h1 class="text-3xl font-bold text-gray-800">Jean Dupont</h1>
                <p class="text-lg text-green-600 mb-2">Master en Informatique</p>
                <div class="flex flex-wrap justify-center md:justify-start gap-2">
                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm flex items-center">
                        <i class="fas fa-id-card mr-1"></i> ID: 123456
                    </span>
                    <span class="bg-amber-100 text-amber-800 px-3 py-1 rounded-full text-sm flex items-center">
                        <i class="fas fa-calendar-alt mr-1"></i> Promotion 2023
                    </span>
                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm flex items-center">
                        <i class="fas fa-university mr-1"></i> Université Paris-Saclay
                    </span>
                </div>
            </div>
        </header>

        <!-- Navigation par onglets -->
        <div class="flex overflow-x-auto mb-8 border-b border-gray-200">
            <button
                class="tab-button px-6 py-3 whitespace-nowrap border-b-4 border-green-500 text-green-800 font-semibold"
                data-tab="personal">
                <i class="fas fa-user mr-2"></i> Informations Personnelles
            </button>
            <button class="tab-button px-6 py-3 text-gray-600 font-medium whitespace-nowrap" data-tab="academic">
                <i class="fas fa-graduation-cap mr-2"></i> Données Académiques
            </button>
            <button class="tab-button px-6 py-3 text-gray-600 font-medium whitespace-nowrap" data-tab="stats">
                <i class="fas fa-chart-bar mr-2"></i> Statistiques
            </button>
        </div>

        <!-- Contenu des onglets -->
        <div>
            <!-- Onglet Informations Personnelles -->
            <div id="personal-tab" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Carte Info de base -->
                    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-info-circle text-green-500 mr-2"></i> Informations de Base
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Date de Naissance</p>
                                <p class="font-medium">15/03/1999 (24 ans)</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Lieu de Naissance</p>
                                <p class="font-medium">Lyon, France</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Nationalité</p>
                                <p class="font-medium">Française</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Genre</p>
                                <p class="font-medium">Masculin</p>
                            </div>
                        </div>
                    </div>

                    <!-- Carte Contact -->
                    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-address-book text-blue-500 mr-2"></i> Coordonnées
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Adresse Email</p>
                                <p class="font-medium flex items-center">
                                    <i class="fas fa-envelope mr-2 text-gray-400"></i> jean.dupont@universite.fr
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Téléphone</p>
                                <p class="font-medium flex items-center">
                                    <i class="fas fa-phone mr-2 text-gray-400"></i> +33 6 12 34 56 78
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Adresse Postale</p>
                                <p class="font-medium flex items-center">
                                    <i class="fas fa-home mr-2 text-gray-400"></i> 15 Rue de l'Université, 75005 Paris
                                </p>
                            </div>
                            <div class="flex space-x-3 pt-2">
                                <button class="text-blue-600 hover:text-blue-800 transition-colors">
                                    <i class="fab fa-linkedin text-xl"></i>
                                </button>
                                <button class="text-blue-400 hover:text-blue-600 transition-colors">
                                    <i class="fab fa-twitter text-xl"></i>
                                </button>
                                <button class="text-gray-800 hover:text-black transition-colors">
                                    <i class="fab fa-github text-xl"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Documents -->
                <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-amber-500">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-folder-open text-amber-500 mr-2"></i> Documents Administratifs
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div
                            class="border border-gray-200 rounded-lg p-4 flex items-center hover:bg-green-50 cursor-pointer transition-colors">
                            <div class="bg-green-100 p-3 rounded-full mr-4">
                                <i class="fas fa-file-pdf text-green-600"></i>
                            </div>
                            <div>
                                <p class="font-medium">Carte d'étudiant 2023-2024</p>
                                <p class="text-sm text-gray-500">PDF • 1.2 MB</p>
                            </div>
                        </div>
                        <div
                            class="border border-gray-200 rounded-lg p-4 flex items-center hover:bg-blue-50 cursor-pointer transition-colors">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <i class="fas fa-file-pdf text-blue-600"></i>
                            </div>
                            <div>
                                <p class="font-medium">Certificat de scolarité</p>
                                <p class="text-sm text-gray-500">PDF • 0.8 MB</p>
                            </div>
                        </div>
                        <div
                            class="border border-gray-200 rounded-lg p-4 flex items-center hover:bg-amber-50 cursor-pointer transition-colors">
                            <div class="bg-amber-100 p-3 rounded-full mr-4">
                                <i class="fas fa-file-signature text-amber-600"></i>
                            </div>
                            <div>
                                <p class="font-medium">Contrat pédagogique</p>
                                <p class="text-sm text-gray-500">PDF • 2.1 MB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Onglet Données Académiques -->
            <div id="academic-tab" class="hidden space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Carte Parcours Académique -->
                    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-road text-green-500 mr-2"></i> Parcours Académique
                        </h2>
                        <div class="space-y-6">
                            <div class="relative pl-8 pb-6 border-l-2 border-green-200">
                                <div class="absolute -left-2 top-0 w-4 h-4 bg-green-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-800">Master en Informatique</h3>
                                <p class="text-sm text-gray-600">Université Paris-Saclay • 2022-2024</p>
                                <p class="text-sm text-gray-500 mt-1">Spécialité Intelligence Artificielle</p>
                            </div>
                            <div class="relative pl-8 pb-6 border-l-2 border-green-200">
                                <div class="absolute -left-2 top-0 w-4 h-4 bg-green-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-800">Licence en Informatique</h3>
                                <p class="text-sm text-gray-600">Université Claude Bernard Lyon 1 • 2019-2022</p>
                                <p class="text-sm text-gray-500 mt-1">Mention Assez Bien</p>
                            </div>
                            <div class="relative pl-8">
                                <div class="absolute -left-2 top-0 w-4 h-4 bg-green-500 rounded-full"></div>
                                <h3 class="font-bold text-gray-800">Baccalauréat Scientifique</h3>
                                <p class="text-sm text-gray-600">Lycée du Parc, Lyon • 2019</p>
                                <p class="text-sm text-gray-500 mt-1">Mention Bien</p>
                            </div>
                        </div>
                    </div>

                    <!-- Carte Inscription Actuelle -->
                    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-calendar-check text-blue-500 mr-2"></i> Inscription Actuelle
                        </h2>
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Année Universitaire</p>
                                <p class="font-medium">2023-2024</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Formation</p>
                                <p class="font-medium">Master 2 Informatique - Parcours IA</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Statut</p>
                                <p class="font-medium flex items-center">
                                    <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                                    Inscription validée
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Date d'inscription</p>
                                <p class="font-medium">05/09/2023</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Régime</p>
                                <p class="font-medium">Formation initiale</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carte Emploi du Temps -->
                <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-amber-500">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-calendar-alt text-amber-500 mr-2"></i> Emploi du Temps
                    </h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-green-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-green-800 uppercase">Jour
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-green-800 uppercase">Matière
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-green-800 uppercase">Horaire
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-green-800 uppercase">Salle
                                    </th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-green-800 uppercase">
                                        Professeur</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr class="hover:bg-green-50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap font-medium">Lundi</td>
                                    <td class="px-4 py-3 whitespace-nowrap">Machine Learning</td>
                                    <td class="px-4 py-3 whitespace-nowrap">9h-12h</td>
                                    <td class="px-4 py-3 whitespace-nowrap">B305</td>
                                    <td class="px-4 py-3 whitespace-nowrap">Prof. Zhang</td>
                                </tr>
                                <tr class="bg-gray-50 hover:bg-green-50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap font-medium">Mardi</td>
                                    <td class="px-4 py-3 whitespace-nowrap">Traitement du Langage</td>
                                    <td class="px-4 py-3 whitespace-nowrap">14h-17h</td>
                                    <td class="px-4 py-3 whitespace-nowrap">A212</td>
                                    <td class="px-4 py-3 whitespace-nowrap">Prof. Martin</td>
                                </tr>
                                <tr class="hover:bg-green-50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap font-medium">Jeudi</td>
                                    <td class="px-4 py-3 whitespace-nowrap">Vision par Ordinateur</td>
                                    <td class="px-4 py-3 whitespace-nowrap">10h-13h</td>
                                    <td class="px-4 py-3 whitespace-nowrap">B305</td>
                                    <td class="px-4 py-3 whitespace-nowrap">Prof. Zhang</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Onglet Statistiques -->
            <div id="stats-tab" class="hidden space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Carte Progression -->
                    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-tasks text-green-500 mr-2"></i> Progression Académique
                        </h2>
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Crédits obtenus</span>
                                    <span class="text-sm font-medium">45/60</span>
                                </div>
                                <div class="h-2 rounded-full bg-gray-200 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-green-400 to-green-600" style="width: 75%">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Unités validées</span>
                                    <span class="text-sm font-medium">7/10</span>
                                </div>
                                <div class="h-2 rounded-full bg-gray-200 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-green-400 to-blue-500" style="width: 70%">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Stage validé</span>
                                    <span class="text-sm font-medium">En cours</span>
                                </div>
                                <div class="h-2 rounded-full bg-gray-200 overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-amber-400 to-amber-600" style="width: 40%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Carte Performances -->
                    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-chart-line text-blue-500 mr-2"></i> Performances
                        </h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-green-50 p-4 rounded-lg text-center border border-green-100">
                                <p class="text-3xl font-bold text-green-600">15.8</p>
                                <p class="text-sm text-gray-600">Moyenne générale</p>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-lg text-center border border-blue-100">
                                <p class="text-3xl font-bold text-blue-600">25</p>
                                <p class="text-sm text-gray-600">Classement promo</p>
                            </div>
                            <div class="bg-amber-50 p-4 rounded-lg text-center border border-amber-100">
                                <p class="text-3xl font-bold text-amber-600">92%</p>
                                <p class="text-sm text-gray-600">Assiduité</p>
                            </div>
                            <div class="bg-green-100 p-4 rounded-lg text-center border border-green-200">
                                <p class="text-3xl font-bold text-green-800">3</p>
                                <p class="text-sm text-gray-600">Mentions TB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Graphiques -->
                <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-amber-500">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-chart-pie text-amber-500 mr-2"></i> Évolution des Résultats
                    </h2>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div
                            class="bg-gradient-to-br from-green-50 to-blue-50 rounded-lg p-4 h-64 flex items-center justify-center border border-green-100">
                            <p class="text-green-600 font-medium">Graphique d'évolution des notes par semestre</p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-blue-50 to-green-50 rounded-lg p-4 h-64 flex items-center justify-center border border-blue-100">
                            <p class="text-blue-600 font-medium">Répartition des notes par matière</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des onglets
        const tabButtons = document.querySelectorAll('.tab-button');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Retirer active de tous les boutons
                tabButtons.forEach(btn => {
                    btn.classList.remove('border-b-4', 'border-green-500',
                        'text-green-800', 'font-semibold');
                });

                // Ajouter active au bouton cliqué
                button.classList.add('border-b-4', 'border-green-500', 'text-green-800',
                    'font-semibold');

                // Masquer tous les contenus
                document.querySelectorAll('[id$="-tab"]').forEach(content => {
                    content.classList.add('hidden');
                });

                // Afficher le contenu correspondant
                const tabId = button.getAttribute('data-tab');
                document.getElementById(`${tabId}-tab`).classList.remove('hidden');
            });
        });
    });
    </script>
</body>

</html>