<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold text-gray-800 mb-8 text-center">Paramètres Généraux de l'Application</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php foreach ($cardData as $card): ?>
        <div
            class="bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col justify-start items-start transition-all duration-300 ease-in-out hover:shadow-lg hover:transform hover:-translate-y-1">
            <div class="p-6 flex-grow justify-start items-start">
                <a href="<?php echo htmlspecialchars($card['link']); ?>" class="group">
                    <?php if (!empty($card['icon'])): ?>
                    <div style="width:20%"
                        class="bg-green-100 flex items-center justify-center px-2 py-4 rounded-md mb-4 transition-colors">
                        <img src="<?php echo htmlspecialchars($card['icon']); ?>" alt="icone" class="text-2xl">
                    </div>
                    <?php endif; ?>
                    <h5
                        class="mb-2 text-xl font-semibold tracking-tight text-gray-900 dark:text-white group-hover:text-green-600 transition-colors">
                        <?php echo htmlspecialchars($card['title']); ?>
                    </h5>
                </a>
                <p class="font-normal text-gray-600 dark:text-gray-400 text-sm text-left">
                    <?php echo htmlspecialchars($card['description']); ?>
                </p>

            </div>
            <div class="flex justify-start p-4 ">
                <a href="<?php echo htmlspecialchars($card['link']); ?>"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-green-300 rounded-md hover:bg-green-600 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 transition-colors sm:w-auto">
                    Accéder
                    <i class="px-2 fa fa-chevron-right"></i>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>