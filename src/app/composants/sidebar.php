<div class="hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64 bg-indigo-700">
        <div class="flex items-center justify-center h-16 px-4">
            <div class="flex items-center">
                <i class="fas fa-graduation-cap text-white text-2xl mr-2"></i>
                <span class="text-white font-semibold text-xl">ScholarSync</span>
            </div>
        </div>
        <div class="flex flex-col flex-grow px-4 py-4 overflow-y-auto">
            <!-- University selector -->
            <div class="mb-6">
                <label class="block text-xs font-medium text-indigo-200 mb-1">Université</label>
                <div class="relative">
                    <select id="university-select" class="block appearance-none w-full bg-indigo-600 border border-indigo-500 text-white text-sm py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-indigo-600 focus:border-indigo-400">
                        <option>Université Paris-Saclay</option>
                        <option>Université de Lyon</option>
                        <option>Université de Lille</option>
                        <option>Université de Bordeaux</option>
                        <option>Université de Strasbourg</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Faculty selector -->
            <div class="mb-6">
                <label class="block text-xs font-medium text-indigo-200 mb-1">Faculté</label>
                <div class="relative">
                    <select id="faculty-select" class="block appearance-none w-full bg-indigo-600 border border-indigo-500 text-white text-sm py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-indigo-600 focus:border-indigo-400">
                        <option>Sciences et Technologies</option>
                        <option>Droit et Science Politique</option>
                        <option>Économie et Gestion</option>
                        <option>Médecine</option>
                        <option>Lettres et Sciences Humaines</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-white">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Navigation menu -->
            <div class="space-y-1">
                <a href="#" class="flex items-center px-2 py-3 text-sm font-medium text-indigo-200 hover:text-white hover:bg-indigo-600 rounded-lg sidebar-item">
                    <i class="fas fa-home sidebar-icon mr-3"></i>
                    Dashboard
                </a>
                <a href="#" class="flex items-center px-2 py-3 text-sm font-medium text-white bg-indigo-800 rounded-lg group">
                    <i class="fas fa-book sidebar-icon mr-3"></i>
                    Unités d'Enseignement
                </a>
                <a href="#" class="flex items-center px-2 py-3 text-sm font-medium text-indigo-200 hover:text-white hover:bg-indigo-600 rounded-lg sidebar-item">
                    <i class="fas fa-calendar-alt sidebar-icon mr-3"></i>
                    Emploi du temps
                </a>
                <a href="#" class="flex items-center px-2 py-3 text-sm font-medium text-indigo-200 hover:text-white hover:bg-indigo-600 rounded-lg sidebar-item">
                    <i class="fas fa-file-alt sidebar-icon mr-3"></i>
                    Notes & Résultats
                </a>
                <a href="#" class="flex items-center px-2 py-3 text-sm font-medium text-indigo-200 hover:text-white hover:bg-indigo-600 rounded-lg sidebar-item">
                    <i class="fas fa-chart-line sidebar-icon mr-3"></i>
                    Progression
                </a>
                <a href="#" class="flex items-center px-2 py-3 text-sm font-medium text-indigo-200 hover:text-white hover:bg-indigo-600 rounded-lg sidebar-item">
                    <i class="fas fa-cog sidebar-icon mr-3"></i>
                    Paramètres
                </a>
            </div>

            <!-- Deadline panel -->
            <div class="mt-auto mb-4">
                <div class="p-4 bg-indigo-800 rounded-lg">
                    <h4 class="text-white text-sm font-medium mb-2">Prochaine échéance</h4>
                    <p class="text-indigo-200 text-xs">Choix des UE optionnelles :</p>
                    <div class="flex items-center mt-2">
                        <span class="text-white font-bold text-lg">7</span>
                        <span class="text-indigo-200 text-sm ml-1">jours</span>
                    </div>
                    <button class="mt-3 w-full bg-white text-indigo-600 text-xs font-semibold py-2 px-3 rounded hover:bg-gray-100 transition duration-150">
                        Compléter mon dossier
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>