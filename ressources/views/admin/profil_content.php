<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil utilisateur</title>


</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen font-sans text-gray-800" x-data="{
    formChanged: false,
    showNotification: false,
    showConfirmation: false,
    saveChanges() {
        this.showNotification = true;
        this.formChanged = false;
        setTimeout(() => this.showNotification = false, 3000);
    }
}">
    <div class="container max-w-5xl mx-auto px-4 py-10">
        <!-- Header -->
        <header class="mb-8 text-center md:text-left fade-in">
            <h1 class="text-3xl font-bold text-indigo-800">Profil Utilisateur</h1>
            <p class="text-gray-600 mt-2">Gérez vos informations personnelles</p>
        </header>

        <!-- Main Content -->
        <div class="profile-card bg-white rounded-xl shadow-lg overflow-hidden fade-in" style="animation-delay: 0.1s;">
            <div class="md:flex">
                <!-- Sidebar -->
                <div class="w-full md:w-1/4 bg-indigo-700 text-white p-6">
                    <div class="flex flex-col items-center md:items-start space-y-6">
                        <div class="relative group">
                            <div
                                class="h-24 w-24 rounded-full bg-indigo-300 flex items-center justify-center overflow-hidden border-4 border-indigo-400">
                                <img src="/api/placeholder/200/200" alt="Photo de profil"
                                    class="min-h-full min-w-full object-cover">
                                <div
                                    class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                                    <i class="fas fa-camera text-white text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <div class="text-center md:text-left">
                            <h2 class="text-xl font-bold">Nathaniel Poole</h2>
                            <p class="text-indigo-200 text-sm">Membre depuis 2023</p>
                        </div>

                        <nav class="w-full space-y-2 mt-4">
                            <a href="#"
                                class="flex items-center space-x-3 p-3 rounded-lg bg-indigo-800 hover:bg-indigo-900 transition">
                                <i class="fas fa-user-circle w-5 text-center"></i>
                                <span>Profil</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-3 p-3 rounded-lg hover:bg-indigo-800 transition">
                                <i class="fas fa-shield-alt w-5 text-center"></i>
                                <span>Sécurité</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-3 p-3 rounded-lg hover:bg-indigo-800 transition">
                                <i class="fas fa-bell w-5 text-center"></i>
                                <span>Notifications</span>
                            </a>
                            <a href="#"
                                class="flex items-center space-x-3 p-3 rounded-lg hover:bg-indigo-800 transition">
                                <i class="fas fa-cog w-5 text-center"></i>
                                <span>Préférences</span>
                            </a>
                        </nav>
                    </div>
                </div>

                <!-- Form Content -->
                <div class="w-full md:w-3/4 p-6 md:p-8" @change="formChanged = true">
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-indigo-800 pb-2 border-b border-gray-200">Informations
                            personnelles</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- First column -->
                        <div>
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-1"
                                    for="firstname">Prénom</label>
                                <div class="relative">
                                    <span
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </span>
                                    <input id="firstname" type="text" value="Nathaniel"
                                        class="form-input w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none">
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-1"
                                    for="phone">Téléphone</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </span>
                                    <input id="phone" type="text" value="+1800-000"
                                        class="form-input w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none">
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="city">Ville</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fas fa-city text-gray-400"></i>
                                    </span>
                                    <input id="city" type="text" value="Bridgeport"
                                        class="form-input w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none">
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="postcode">Code
                                    postal</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </span>
                                    <input id="postcode" type="text" value="53005"
                                        class="form-input w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none">
                                </div>
                            </div>
                        </div>

                        <!-- Second column -->
                        <div>
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="lastname">Nom</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </span>
                                    <input id="lastname" type="text" value="Poole"
                                        class="form-input w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none">
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </span>
                                    <input id="email" type="email" value="nathaniel.poole@worksmail.com"
                                        class="form-input w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none">
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-1"
                                    for="state">État/Région</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fas fa-map text-gray-400"></i>
                                    </span>
                                    <select id="state"
                                        class="form-input w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none appearance-none">
                                        <option value="WA" selected>Washington (WA)</option>
                                        <option value="NY">New York (NY)</option>
                                        <option value="CA">Californie (CA)</option>
                                        <option value="TX">Texas (TX)</option>
                                        <option value="FL">Floride (FL)</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="country">Pays</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fas fa-globe text-gray-400"></i>
                                    </span>
                                    <select id="country"
                                        class="form-input w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none appearance-none">
                                        <option value="US" selected>États-Unis</option>
                                        <option value="CA">Canada</option>
                                        <option value="FR">France</option>
                                        <option value="GB">Royaume-Uni</option>
                                        <option value="DE">Allemagne</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-gray-200 flex items-center justify-between">
                        <div>
                            <span x-show="formChanged" class="text-sm text-yellow-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                Modifications non enregistrées
                            </span>
                        </div>
                        <div class="flex space-x-3">
                            <button
                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition"
                                @click="formChanged = false">
                                Annuler
                            </button>
                            <button
                                class="btn-primary px-5 py-2 bg-indigo-600 rounded-lg text-white text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition flex items-center"
                                :class="{'opacity-50 cursor-not-allowed': !formChanged}" :disabled="!formChanged"
                                @click="saveChanges()">
                                <i class="fas fa-save mr-2"></i>
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional information card -->
        <div class="mt-6 bg-white rounded-xl shadow-lg p-6 fade-in" style="animation-delay: 0.2s;">
            <h3 class="text-xl font-semibold text-indigo-800 mb-4">Préférences de communication</h3>
            <div class="space-y-3">
                <div class="flex items-center">
                    <input id="email-notifications" type="checkbox" checked
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="email-notifications" class="ml-3 text-sm text-gray-700">
                        Recevoir des notifications par email
                    </label>
                </div>
                <div class="flex items-center">
                    <input id="marketing-emails" type="checkbox"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="marketing-emails" class="ml-3 text-sm text-gray-700">
                        Recevoir des emails marketing
                    </label>
                </div>
                <div class="flex items-center">
                    <input id="newsletter" type="checkbox" checked
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="newsletter" class="ml-3 text-sm text-gray-700">
                        S'abonner à notre newsletter
                    </label>
                </div>
            </div>
        </div>
    </div>

    <!-- Success notification -->
    <div x-show="showNotification" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-2"
        class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        Profil mis à jour avec succès
    </div>

    <!-- Confirmation modal -->
    <div x-show="showConfirmation" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md mx-4" @click.away="showConfirmation = false">
            <h3 class="text-lg font-bold text-gray-900 mb-2">Confirmer les modifications?</h3>
            <p class="text-gray-600 mb-4">Êtes-vous sûr de vouloir enregistrer ces modifications?</p>
            <div class="flex justify-end space-x-3">
                <button
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 text-sm font-medium hover:bg-gray-50"
                    @click="showConfirmation = false">
                    Annuler
                </button>
                <button class="px-4 py-2 bg-indigo-600 rounded-lg text-white text-sm font-medium hover:bg-indigo-700"
                    @click="saveChanges(); showConfirmation = false">
                    Confirmer
                </button>
            </div>
        </div>
    </div>
</body>

</html>