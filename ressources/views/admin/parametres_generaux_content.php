<div class="container mx-auto px-4 py-6">

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php foreach ($cardData as $card): ?>
        <div
            class="bg-white border border-gray-200 rounded-md shadow-sm flex flex-col justify-start items-start transition-all duration-300 ease-in-out hover:shadow-md hover:transform hover:-translate-y-1">
            <div class="p-4 flex-grow justify-start items-start">
                <a href="<?php echo htmlspecialchars($card['link']); ?>" class="group">
                    <?php if (!empty($card['icon'])): ?>
                    <div style="width:15%"
                        class="bg-green-100 flex items-center justify-center px-1 py-2 rounded-md mb-3 transition-colors">
                        <img src="<?php echo htmlspecialchars($card['icon']); ?>" alt="icone" class="text-xl">
                    </div>
                    <?php endif; ?>
                    <h5
                        class="mb-1 text-sm font-semibold tracking-tight text-gray-900 dark:text-white group-hover:text-green-600 transition-colors">
                        <?php echo htmlspecialchars($card['title']); ?>
                    </h5>
                </a>
                <p class="font-normal text-gray-600 dark:text-gray-400 text-xs text-left">
                    <?php echo htmlspecialchars($card['description']); ?>
                </p>
            </div>
            <div class="flex justify-start p-2">
                <a href="<?php echo htmlspecialchars($card['link']); ?>"
                    class="inline-flex items-center px-3 py-1 text-xs font-medium text-center text-white bg-green-300 rounded-md hover:bg-green-600 focus:ring-2 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 transition-colors">
                    Accéder
                    <i class="px-1 fa fa-chevron-right"></i>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>