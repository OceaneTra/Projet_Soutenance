<div class="flex items-center justify-between h-16 px-4 bg-white border-b border-gray-200">
    <div class="flex items-center">
        <button class="md:hidden text-gray-500 focus:outline-none mr-2">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="text-lg font-semibold text-gray-800">Gestion des Unités d'Enseignement</h1>
    </div>

    <div class="flex items-center space-x-4">
        <!-- Semester selector -->
        <div class="relative">
            <select id="semester-select" class="block appearance-none bg-white border border-gray-300 text-gray-700 py-1 px-3 pr-8 rounded text-sm leading-tight focus:outline-none focus:bg-white focus:border-indigo-500">
                <option>Automne 2023</option>
                <option>Printemps 2024</option>
                <option>Automne 2024</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                <i class="fas fa-chevron-down text-xs"></i>
            </div>
        </div>

        <!-- Notifications -->
        <div class="relative">
            <button class="text-gray-500 focus:outline-none">
                <i class="fas fa-bell"></i>
            </button>
            <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
        </div>

        <!-- User profile -->
        <div class="flex items-center">
            <div class="relative">
                <img class="h-8 w-8 rounded-full object-cover" src="https://randomuser.me/api/portraits/men/32.jpg" alt="User profile">
                <span class="absolute bottom-0 right-0 h-2 w-2 rounded-full bg-green-500 border border-white"></span>
            </div>
            <span class="ml-2 text-sm font-medium text-gray-700 hidden md:inline">Thomas Dubois</span>
        </div>
    </div>
</div>