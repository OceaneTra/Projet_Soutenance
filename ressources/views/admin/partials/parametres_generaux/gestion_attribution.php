<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Attributions de Traitements</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">
    <div class="min-h-screen" x-data="gestionAttributions()">
        <!-- Header -->
        <header class="bg-gradient-to-r from-emerald-600 to-teal-500 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center py-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-layer-group text-white text-2xl"></i>
                        </div>
                        <h1 class="ml-3 text-white text-xl font-bold">Gestion des Attributions</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative" @click.away="profilMenu = false" x-data="{ profilMenu: false }">
                            <button @click="profilMenu = !profilMenu"
                                class="flex items-center space-x-3 text-white focus:outline-none">
                                <span class="text-sm font-medium hidden md:block">Admin</span>
                                <div class="h-8 w-8 rounded-full bg-white/30 flex items-center justify-center">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            </button>

                            <div x-show="profilMenu" x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mon
                                    Profil</a>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Paramètres</a>
                                <div class="border-t border-gray-100"></div>
                                <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Déconnexion</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Tabs -->
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <template x-for="groupe in groupes" :key="groupe.id">
                            <button @click="groupeSelectionne = groupe"
                                class="py-4 px-6 text-center border-b-2 font-medium text-sm" :class="groupeSelectionne.id === groupe.id ? 
                              'border-emerald-500 text-emerald-600' : 
                              'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'">
                                <span x-text="groupe.nom"></span>
                            </button>
                        </template>
                    </nav>
                </div>

                <!-- Content -->
                <div class="px-6 py-5">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-900">
                            Traitements pour : <span class="text-emerald-600" x-text="groupeSelectionne.nom"></span>
                        </h2>
                        <div class="flex space-x-3">
                            <button @click="cocherTout()"
                                class="flex items-center px-4 py-2 border border-emerald-500 text-emerald-500 rounded-md hover:bg-emerald-50 focus:outline-none">
                                <i class="fas fa-check-double mr-2"></i> Tout sélectionner
                            </button>
                            <button @click="decocherTout()"
                                class="flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none">
                                <i class="fas fa-times mr-2"></i> Tout désélectionner
                            </button>
                        </div>
                    </div>

                    <!-- Search Bar -->
                    <div class="mb-6">
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" x-model="recherche" placeholder="Rechercher un traitement..."
                                class="focus:ring-emerald-500 focus:border-emerald-500 block w-full pl-10 pr-12 sm:text-sm border-gray-300 rounded-md py-3">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <span x-show="recherche.length > 0" @click="recherche = ''"
                                    class="text-gray-400 cursor-pointer hover:text-gray-600">
                                    <i class="fas fa-times-circle"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="flex flex-wrap gap-2 mb-6">
                        <button @click="filtreActif = filtreActif === 'tous' ? null : 'tous'"
                            class="px-3 py-1 rounded-full text-sm"
                            :class="filtreActif === 'tous' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-800'">
                            Tous
                        </button>
                        <button @click="filtreActif = filtreActif === 'selectionnes' ? null : 'selectionnes'"
                            class="px-3 py-1 rounded-full text-sm"
                            :class="filtreActif === 'selectionnes' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-800'">
                            Sélectionnés
                        </button>
                        <button @click="filtreActif = filtreActif === 'non_selectionnes' ? null : 'non_selectionnes'"
                            class="px-3 py-1 rounded-full text-sm"
                            :class="filtreActif === 'non_selectionnes' ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-800'">
                            Non sélectionnés
                        </button>
                    </div>

                    <!-- Treatments List -->
                    <div class="space-y-1 max-h-96 overflow-y-auto pr-2">
                        <template x-for="(traitement, index) in traitementsFiltres" :key="traitement.id">
                            <div class="rounded-md hover:bg-gray-50 transition-colors"
                                :class="index % 2 === 0 ? 'bg-white' : 'bg-gray-50'">
                                <div class="flex items-center py-3 px-4">
                                    <div class="mr-4">
                                        <input type="checkbox" :id="'traitement-' + traitement.id"
                                            :checked="estSelectionne(traitement.id)"
                                            @change="toggleTraitement(traitement.id)"
                                            class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 rounded">
                                    </div>
                                    <label :for="'traitement-' + traitement.id"
                                        class="flex-1 flex items-center justify-between cursor-pointer">
                                        <div>
                                            <p class="font-medium text-gray-900" x-text="traitement.nom"></p>
                                            <p class="text-sm text-gray-500" x-text="traitement.description"></p>
                                        </div>
                                        <div class="ml-4">
                                            <span x-show="estSelectionne(traitement.id)"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                                Attribué
                                            </span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </template>

                        <!-- Empty State -->
                        <div x-show="traitementsFiltres.length === 0" class="text-center py-12">
                            <div class="mx-auto h-12 w-12 text-gray-400">
                                <i class="fas fa-search text-3xl"></i>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun traitement trouvé</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Essayez de modifier vos critères de recherche ou votre filtre.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-600">
                            <span x-text="nombreTraitementsSelectionnes"></span> traitement(s) sélectionné(s) sur
                            <span x-text="traitements.length"></span>
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <button @click="annuler()"
                            class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                            Annuler
                        </button>
                        <button @click="sauvegarder()"
                            class="px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none">
                            Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    function gestionAttributions() {
        return {
            // Données
            groupes: [{
                    id: 1,
                    nom: "Administrateurs"
                },
                {
                    id: 2,
                    nom: "Gestionnaires"
                },
                {
                    id: 3,
                    nom: "Utilisateurs"
                },
                {
                    id: 4,
                    nom: "Consultants"
                }
            ],
            traitements: [{
                    id: 1,
                    nom: "Créer un utilisateur",
                    description: "Permet de créer de nouveaux utilisateurs dans le système",
                    categorie: "Utilisateurs"
                },
                {
                    id: 2,
                    nom: "Modifier un utilisateur",
                    description: "Permet de modifier les informations des utilisateurs",
                    categorie: "Utilisateurs"
                },
                {
                    id: 3,
                    nom: "Supprimer un utilisateur",
                    description: "Permet de supprimer des utilisateurs du système",
                    categorie: "Utilisateurs"
                },
                {
                    id: 4,
                    nom: "Consulter les rapports",
                    description: "Permet de consulter les rapports générés par le système",
                    categorie: "Rapports"
                },
                {
                    id: 5,
                    nom: "Générer des rapports",
                    description: "Permet de générer de nouveaux rapports",
                    categorie: "Rapports"
                },
                {
                    id: 6,
                    nom: "Exporter des données",
                    description: "Permet d'exporter des données du système",
                    categorie: "Données"
                },
                {
                    id: 7,
                    nom: "Importer des données",
                    description: "Permet d'importer des données dans le système",
                    categorie: "Données"
                },
                {
                    id: 8,
                    nom: "Configurer le système",
                    description: "Permet de modifier les paramètres du système",
                    categorie: "Configuration"
                },
                {
                    id: 9,
                    nom: "Gérer les sauvegardes",
                    description: "Permet de gérer les sauvegardes du système",
                    categorie: "Configuration"
                },
                {
                    id: 10,
                    nom: "Consulter l'historique",
                    description: "Permet de consulter l'historique des actions",
                    categorie: "Audit"
                }
            ],
            attributions: {
                1: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], // Administrateurs ont tout
                2: [2, 4, 5, 6, 7], // Gestionnaires
                3: [4], // Utilisateurs simples
                4: [4, 5] // Consultants
            },
            attributionsInitiales: {},
            groupeSelectionne: null,
            recherche: '',
            filtreActif: null,

            // Initialisation
            init() {
                this.groupeSelectionne = this.groupes[0];
                // Copie profonde des attributions initiales pour pouvoir annuler les modifications
                this.attributionsInitiales = JSON.parse(JSON.stringify(this.attributions));
            },

            // Computed properties
            get traitementsFiltres() {
                return this.traitements.filter(traitement => {
                    // Filtre par recherche
                    const matchRecherche = traitement.nom.toLowerCase().includes(this.recherche
                        .toLowerCase()) ||
                        traitement.description.toLowerCase().includes(this.recherche.toLowerCase());

                    // Filtre par état de sélection
                    const estSelectionne = this.estSelectionne(traitement.id);

                    if (!matchRecherche) return false;

                    if (this.filtreActif === 'selectionnes' && !estSelectionne) return false;
                    if (this.filtreActif === 'non_selectionnes' && estSelectionne) return false;

                    return true;
                });
            },

            get nombreTraitementsSelectionnes() {
                return this.attributions[this.groupeSelectionne.id]?.length || 0;
            },

            // Méthodes
            estSelectionne(traitementId) {
                return this.attributions[this.groupeSelectionne.id]?.includes(traitementId) || false;
            },

            toggleTraitement(traitementId) {
                // Initialiser le tableau d'attributions pour ce groupe s'il n'existe pas encore
                if (!this.attributions[this.groupeSelectionne.id]) {
                    this.attributions[this.groupeSelectionne.id] = [];
                }

                const index = this.attributions[this.groupeSelectionne.id].indexOf(traitementId);

                if (index === -1) {
                    // Ajouter le traitement
                    this.attributions[this.groupeSelectionne.id].push(traitementId);
                } else {
                    // Retirer le traitement
                    this.attributions[this.groupeSelectionne.id].splice(index, 1);
                }
            },

            cocherTout() {
                // Sélectionner tous les traitements visibles (selon les filtres actuels)
                this.attributions[this.groupeSelectionne.id] = Array.from(
                    new Set([
                        ...(this.attributions[this.groupeSelectionne.id] || []),
                        ...this.traitementsFiltres.map(t => t.id)
                    ])
                );
            },

            decocherTout() {
                // Désélectionner tous les traitements visibles (selon les filtres actuels)
                if (!this.attributions[this.groupeSelectionne.id]) return;

                const idsADesactiver = new Set(this.traitementsFiltres.map(t => t.id));
                this.attributions[this.groupeSelectionne.id] = this.attributions[this.groupeSelectionne.id]
                    .filter(id => !idsADesactiver.has(id));
            },

            annuler() {
                // Restaurer les attributions initiales pour le groupe actuel
                this.attributions = JSON.parse(JSON.stringify(this.attributionsInitiales));
                // Ajouter une notification
                this.notifier('Les modifications ont été annulées.');
            },

            sauvegarder() {
                // Simuler une sauvegarde (normalement appel AJAX)
                // Dans un vrai contexte, vous feriez une requête au serveur ici
                console.log('Attributions sauvegardées :', this.attributions);

                // Mettre à jour les attributions initiales pour refléter l'état actuel
                this.attributionsInitiales = JSON.parse(JSON.stringify(this.attributions));

                // Ajouter une notification
                this.notifier('Les attributions ont été enregistrées avec succès.');
            },

            notifier(message) {
                // Simple notification pour l'exemple
                alert(message);
                // Dans une application réelle, vous utiliseriez un système de notifications plus élégant
            }
        }
    }
    </script>
</body>

</html>