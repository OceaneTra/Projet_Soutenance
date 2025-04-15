<div class="fixed z-10 inset-0 overflow-y-auto hidden" id="ueModal">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-book text-blue-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Sélection d'Unité d'Enseignement
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Choisissez une UE optionnelle pour le semestre de Printemps 2024.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Faculty filter -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Filtrer par faculté</label>
                    <select class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option>Toutes les facultés</option>
                        <option>Sciences et Technologies</option>
                        <option>Droit et Science Politique</option>
                        <option>Économie et Gestion</option>
                    </select>
                </div>

                <div class="mt-5">
                    <div class="space-y-4 max-h-96 overflow-y-auto">
                        <!-- UE Option 1 -->
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                            <div>
                                <h4 class="font-medium text-gray-900">OPT801 - IoT et systèmes embarqués</h4>
                                <p class="text-sm text-gray-500 mt-1">Prof. Eric Petit - Mercredi 14h-17h</p>
                                <span class="inline-block mt-1 px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded">Sciences et Technologies</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-blue-600 mr-3">6 ECTS</span>
                                <input type="radio" name="ueOption" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            </div>
                        </div>

                        <!-- UE Option 2 -->
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                            <div>
                                <h4 class="font-medium text-gray-900">OPT802 - Data Science avancée</h4>
                                <p class="text-sm text-gray-500 mt-1">Prof. Laura Bernard - Lundi 9h-12h</p>
                                <span class="inline-block mt-1 px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded">Sciences et Technologies</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-blue-600 mr-3">6 ECTS</span>
                                <input type="radio" name="ueOption" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            </div>
                        </div>

                        <!-- UE Option 3 -->
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                            <div>
                                <h4 class="font-medium text-gray-900">OPT803 - Cybersécurité pratique</h4>
                                <p class="text-sm text-gray-500 mt-1">Prof. Jean Leroy - Jeudi 14h-17h</p>
                                <span class="inline-block mt-1 px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded">Sciences et Technologies</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-blue-600 mr-3">6 ECTS</span>
                                <input type="radio" name="ueOption" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            </div>
                        </div>

                        <!-- UE Option 4 -->
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                            <div>
                                <h4 class="font-medium text-gray-900">OPT804 - Développement mobile</h4>
                                <p class="text-sm text-gray-500 mt-1">Prof. Marc Dufour - Mardi 9h-12h</p>
                                <span class="inline-block mt-1 px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded">Sciences et Technologies</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-blue-600 mr-3">6 ECTS</span>
                                <input type="radio" name="ueOption" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            </div>
                        </div>

                        <!-- UE Option 5 (from another faculty) -->
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer">
                            <div>
                                <h4 class="font-medium text-gray-900">ECO701 - Économie numérique</h4>
                                <p class="text-sm text-gray-500 mt-1">Prof. Claire Martin - Vendredi 10h-13h</p>
                                <span class="inline-block mt-1 px-2 py-0.5 text-xs font-medium bg-purple-100 text-purple-800 rounded">Économie et Gestion</span>
                            </div>
                            <div class="flex items-center">
                                <span class="text-sm font-medium text-blue-600 mr-3">6 ECTS</span>
                                <input type="radio" name="ueOption" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="confirmUeSelection()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                    Confirmer la sélection
                </button>
                <button type="button" onclick="closeUeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>