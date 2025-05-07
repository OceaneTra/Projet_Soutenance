<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link rel="stylesheet" href="../../../public/css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<script>
tailwind.config = {
    theme: {
        extend: {
            colors: {
                'pink': {
                    '500': '#EC4899',
                    '600': '#DB2777',
                },
                'purple': {
                    '500': '#8B5CF6',
                    '600': '#7C3AED',
                },
                'cyan': {
                    '500': '#06B6D4',
                    '600': '#0891B2',
                },
                'amber': {
                    '500': '#F59E0B',
                    '600': '#D97706',
                }
            }
        }
    }
}
</script>

<style>
.bg-gradient-pink {
    background: linear-gradient(to right, #EC4899, #DB2777);
}

.bg-gradient-purple {
    background: linear-gradient(to right, #8B5CF6, #7C3AED);
}

.bg-gradient-cyan {
    background: linear-gradient(to right, #06B6D4, #0891B2);
}

.bg-gradient-amber {
    background: linear-gradient(to right, #F59E0B, #D97706);
}

.chart-line-pink {
    fill: rgba(236, 72, 153, 0.2);
    stroke: #EC4899;
}

.chart-line-purple {
    fill: rgba(139, 92, 246, 0.2);
    stroke: #8B5CF6;
}
</style>

<body class="bg-gray-50">
    <div class="max-w-6xl mx-auto p-6">
        <!-- Dashboard Header -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Dashboard</h2>
                <p class="text-sm text-gray-500">Welcome back to your dashboard</p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex space-x-1">
                    <button
                        class="px-4 py-1 text-xs font-medium text-gray-500 border-b-2 border-transparent hover:border-gray-300">DAILY</button>
                    <button
                        class="px-4 py-1 text-xs font-medium text-gray-500 border-b-2 border-transparent hover:border-gray-300">WEEKLY</button>
                    <button
                        class="px-4 py-1 text-xs font-medium text-gray-800 border-b-2 border-pink-500">MONTHLY</button>
                    <button
                        class="px-4 py-1 text-xs font-medium text-gray-500 border-b-2 border-transparent hover:border-gray-300">YEARLY</button>
                </div>
            </div>
        </div>

        <!-- Key Metrics -->
        <div class="grid grid-cols-3 gap-6 mb-6">
            <div class="col-span-2">
                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <div class="flex justify-between mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">$3468.96</h3>
                            <p class="text-sm text-gray-500">Current month earnings</p>
                        </div>
                        <div class="flex items-center">
                            <span class="text-xs font-medium text-green-500 mr-2">+2.45%</span>
                            <span class="text-xs font-medium text-gray-500">vs last month</span>
                        </div>
                    </div>

                    <!-- Chart -->
                    <div class="h-40 w-full relative">
                        <svg viewBox="0 0 800 200" class="w-full h-full">
                            <path
                                d="M0,180 C50,160 100,140 150,120 C200,100 250,80 300,60 C350,40 400,20 450,40 C500,60 550,80 600,100 C650,120 700,140 750,160 C800,180 850,200 900,180"
                                class="chart-line-pink" fill="none" stroke-width="2" />
                            <path
                                d="M0,160 C50,140 100,120 150,100 C200,80 250,60 300,40 C350,20 400,0 450,20 C500,40 550,60 600,80 C650,100 700,120 750,140 C800,160 850,180 900,160"
                                class="chart-line-purple" fill="none" stroke-width="2" />
                        </svg>
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-white p-4 rounded-lg shadow-sm h-full">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Traffic</h3>
                    </div>

                    <!-- Donut Chart -->
                    <div class="flex justify-center">
                        <svg width="120" height="120" viewBox="0 0 120 120">
                            <circle cx="60" cy="60" r="50" fill="transparent" stroke="#8B5CF6" stroke-width="20"
                                stroke-dasharray="314" stroke-dashoffset="0" />
                            <circle cx="60" cy="60" r="50" fill="transparent" stroke="#EC4899" stroke-width="20"
                                stroke-dasharray="314" stroke-dashoffset="110" />
                            <circle cx="60" cy="60" r="50" fill="transparent" stroke="#06B6D4" stroke-width="20"
                                stroke-dasharray="314" stroke-dashoffset="250" />
                        </svg>
                    </div>

                    <div class="flex justify-between mt-4">
                        <div class="text-center">
                            <p class="text-lg font-bold">33<span class="text-sm">%</span></p>
                            <p class="text-xs text-gray-500">New Visitors</p>
                        </div>
                        <div class="text-center">
                            <p class="text-lg font-bold">55<span class="text-sm">%</span></p>
                            <p class="text-xs text-gray-500">Returning</p>
                        </div>
                        <div class="text-center">
                            <p class="text-lg font-bold">12<span class="text-sm">%</span></p>
                            <p class="text-xs text-gray-500">Referrals</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Metrics Cards -->
        <div class="grid grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-pink p-4 rounded-lg shadow-sm text-white">
                <div class="flex justify-between">
                    <div>
                        <h4 class="text-xs font-medium opacity-80">Revenue Status</h4>
                        <p class="text-lg font-bold mt-2">$432</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-2 h-8 w-8 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <svg class="w-full h-12" viewBox="0 0 100 30">
                        <rect x="0" y="15" width="8" height="15" rx="2" fill="white" fill-opacity="0.4" />
                        <rect x="12" y="10" width="8" height="20" rx="2" fill="white" fill-opacity="0.4" />
                        <rect x="24" y="5" width="8" height="25" rx="2" fill="white" fill-opacity="0.4" />
                        <rect x="36" y="15" width="8" height="15" rx="2" fill="white" fill-opacity="0.4" />
                        <rect x="48" y="10" width="8" height="20" rx="2" fill="white" fill-opacity="0.4" />
                        <rect x="60" y="5" width="8" height="25" rx="2" fill="white" fill-opacity="0.8" />
                        <rect x="72" y="15" width="8" height="15" rx="2" fill="white" fill-opacity="0.4" />
                        <rect x="84" y="10" width="8" height="20" rx="2" fill="white" fill-opacity="0.4" />
                    </svg>
                </div>
            </div>

            <div class="bg-gradient-purple p-4 rounded-lg shadow-sm text-white">
                <div class="flex justify-between">
                    <div>
                        <h4 class="text-xs font-medium opacity-80">Page Views</h4>
                        <p class="text-lg font-bold mt-2">$432</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-2 h-8 w-8 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <svg class="w-full h-12" viewBox="0 0 100 30">
                        <rect x="0" y="15" width="8" height="15" rx="2" fill="white" fill-opacity="0.4" />
                        <rect x="12" y="10" width="8" height="20" rx="2" fill="white" fill-opacity="0.4" />
                        <rect x="24" y="5" width="8" height="25" rx="2" fill="white" fill-opacity="0.4" />
                        <rect x="36" y="15" width="8" height="15" rx="2" fill="white" fill-opacity="0.4" />
                        <rect x="48" y="10" width="8" height="20" rx="2" fill="white" fill-opacity="0.4" />
                        <rect x="60" y="5" width="8" height="25" rx="2" fill="white" fill-opacity="0.8" />
                        <rect x="72" y="15" width="8" height="15" rx="2" fill="white" fill-opacity="0.4" />
                        <rect x="84" y="10" width="8" height="20" rx="2" fill="white" fill-opacity="0.4" />
                    </svg>
                </div>
            </div>

            <div class="bg-gradient-cyan p-4 rounded-lg shadow-sm text-white">
                <div class="flex justify-between">
                    <div>
                        <h4 class="text-xs font-medium opacity-80">Bounce Rate</h4>
                        <p class="text-lg font-bold mt-2">$432</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-2 h-8 w-8 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <svg class="w-full h-12" viewBox="0 0 100 30">
                        <path d="M0,15 C10,10 20,20 30,15 C40,10 50,20 60,15 C70,10 80,20 90,15 C100,10" fill="none"
                            stroke="white" stroke-width="2" stroke-opacity="0.8" />
                    </svg>
                </div>
            </div>

            <div class="bg-gradient-amber p-4 rounded-lg shadow-sm text-white">
                <div class="flex justify-between">
                    <div>
                        <h4 class="text-xs font-medium opacity-80">Unique Visits</h4>
                        <p class="text-lg font-bold mt-2">$432</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-2 h-8 w-8 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <svg class="w-full h-12" viewBox="0 0 100 30">
                        <rect x="0" y="15" width="8" height="15" rx="2" fill="white" fill-opacity="0.4" />
                        <rect x="12" y="10" width="8" height="20" rx="2" fill="white" fill-opacity="0.4" />
                        <rect x="24" y="5" width="8" height="25" rx="2" fill="white" fill-opacity="0.4" />
                        <rect x="36" y="15" width="8" height="15" rx="2" fill="white" fill-opacity="0.4" />
                        <rect x="48" y="10" width="8" height="20" rx="2" fill="white" fill-opacity="0.4" />
                        <rect x="60" />
                </div>


</body>

</html>