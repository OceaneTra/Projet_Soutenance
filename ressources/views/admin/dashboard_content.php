<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-6 bg-white rounded-3xl shadow-sm max-w-6xl">
        <!-- Header with date range -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-3">
                <div class="bg-indigo-600 w-12 h-12 rounded-xl flex items-center justify-center">
                    <i class="fas fa-cloud text-white text-xl"></i>
                </div>
                <h1 class="text-xl font-bold">Dashboard</h1>
            </div>
            <div class="flex space-x-2 text-sm text-gray-500">
                <span>10-06-2020</span>
                <span>—</span>
                <span>10-10-2020</span>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <!-- Users Projects Card -->
            <div class="gradient-purple rounded-xl p-4 text-white">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-2xl font-bold">178+</h3>
                        <p class="text-sm opacity-80">Users Projects</p>
                    </div>
                    <div class="bg-white bg-opacity-20 w-10 h-10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-heart text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Stock Products Card -->
            <div class="gradient-blue rounded-xl p-4 text-white">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-2xl font-bold">20+</h3>
                        <p class="text-sm opacity-80">Stock Products</p>
                    </div>
                    <div class="bg-white bg-opacity-20 w-10 h-10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-cube text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Sales Products Card -->
            <div class="gradient-red rounded-xl p-4 text-white">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-2xl font-bold">190+</h3>
                        <p class="text-sm opacity-80">Sales Products</p>
                    </div>
                    <div class="bg-white bg-opacity-20 w-10 h-10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-lock text-white"></i>
                    </div>
                </div>
            </div>

            <!-- Job Applications Card -->
            <div class="gradient-orange rounded-xl p-4 text-white">
                <div class="flex justify-between">
                    <div>
                        <h3 class="text-2xl font-bold">12+</h3>
                        <p class="text-sm opacity-80">Job Applications</p>
                    </div>
                    <div class="bg-white bg-opacity-20 w-10 h-10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-envelope text-white"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column - Dashboard Stats -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="font-bold">Dashboard</h2>
                        <p class="text-xs text-gray-500">Overview of Recent Month</p>
                    </div>
                    <div class="flex space-x-1 text-xs">
                        <button class="px-3 py-1 rounded">DAILY</button>
                        <button class="px-3 py-1 rounded">WEEKLY</button>
                        <button class="px-3 py-1 rounded bg-blue-100 text-blue-600">MONTHLY</button>
                        <button class="px-3 py-1 rounded">YEARLY</button>
                    </div>
                </div>

                <!-- Revenue Stats -->
                <div class="mb-6">
                    <h3 class="text-2xl font-bold">$6468.96</h3>
                    <p class="text-xs text-gray-500">Current Month Earnings</p>
                </div>

                <!-- Sales Stats -->
                <div class="mb-6">
                    <h3 class="text-xl font-bold">82</h3>
                    <p class="text-xs text-gray-500">Current Month Sales</p>
                </div>

                <!-- Summary Button -->
                <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm mb-6">Last Month Summary</button>

                <!-- Chart -->
                <div class="chart-container">
                    <canvas id="earningsChart"></canvas>
                </div>

                <!-- Bottom Stats Cards -->
                <div class="grid grid-cols-4 gap-2 mt-4">
                    <!-- Wallet Balance -->
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-pink-500 flex items-center justify-center mr-2">
                            <i class="fas fa-wallet text-white text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Wallet Balance</p>
                            <p class="text-sm font-semibold">$3,567.50</p>
                        </div>
                    </div>

                    <!-- Referral Earning -->
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center mr-2">
                            <i class="fas fa-users text-white text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Referral Earning</p>
                            <p class="text-sm font-semibold">$1,599.93</p>
                        </div>
                    </div>

                    <!-- Estimate Sales -->
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center mr-2">
                            <i class="fas fa-chart-line text-white text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Estimate Sales</p>
                            <p class="text-sm font-semibold">$2,955.00</p>
                        </div>
                    </div>

                    <!-- Earning -->
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-blue-400 flex items-center justify-center mr-2">
                            <i class="fas fa-dollar-sign text-white text-xs"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Earning</p>
                            <p class="text-sm font-semibold">$93,987.54</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Analytics & Recent Activities -->
            <div class="flex flex-col space-y-6">
                <!-- Analytics -->
                <div class="bg-white rounded-xl shadow p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="font-bold">Analytics</h2>
                        <button class="text-gray-400">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                    </div>

                    <div class="flex items-center justify-between">
                        <!-- Donut Chart -->
                        <div class="w-40 h-40 mx-auto">
                            <canvas id="analyticsChart"></canvas>
                        </div>

                        <!-- Percentage -->
                        <div class="text-center">
                            <h3 class="text-2xl font-bold">80%</h3>
                            <p class="text-sm text-gray-500">Transactions</p>
                        </div>
                    </div>

                    <!-- Legend -->
                    <div class="flex justify-center space-x-4 mt-4">
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-indigo-600 mr-2"></div>
                            <span class="text-xs">Sale</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-yellow-400 mr-2"></div>
                            <span class="text-xs">Distribute</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 rounded-full bg-red-400 mr-2"></div>
                            <span class="text-xs">Return</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="bg-white rounded-xl shadow p-6">
                    <h2 class="font-bold mb-4">Recent Activities</h2>

                    <!-- Activity Item -->
                    <div class="flex mb-4">
                        <div class="text-xs text-gray-500 w-16">40 Min Ago</div>
                        <div class="w-8 h-8 rounded-full bg-pink-500 flex items-center justify-center mx-4">
                            <i class="fas fa-tasks text-white text-xs"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold">Task Updated</h4>
                            <p class="text-xs text-gray-500">Nicolas Updated a Task</p>
                        </div>
                    </div>

                    <!-- Activity Item -->
                    <div class="flex mb-4">
                        <div class="text-xs text-gray-500 w-16">1 day ago</div>
                        <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center mx-4">
                            <i class="fas fa-handshake text-white text-xs"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold">Deal Added</h4>
                            <p class="text-xs text-gray-500">Pamela Updated a Task</p>
                        </div>
                    </div>

                    <!-- Activity Item -->
                    <div class="flex">
                        <div class="text-xs text-gray-500 w-16">40 Min Ago</div>
                        <div class="w-8 h-8 rounded-full bg-blue-400 flex items-center justify-center mx-4">
                            <i class="fas fa-newspaper text-white text-xs"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold">Published Article</h4>
                            <p class="text-xs text-gray-500">Daniel Updated an Article</p>
                        </div>
                    </div>
                </div>

                <!-- Order Status -->
                <div class="bg-white rounded-xl shadow p-6">
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <h2 class="font-bold">Order Status</h2>
                            <p class="text-xs text-gray-500">Overview of latest month</p>
                        </div>
                        <div class="flex space-x-1">
                            <button class="w-6 h-6 bg-red-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs"></i>
                            </button>
                            <button class="w-6 h-6 bg-gray-200 rounded-md flex items-center justify-center">
                                <i class="fas fa-list text-gray-500 text-xs"></i>
                            </button>
                            <button class="w-6 h-6 bg-gray-200 rounded-md flex items-center justify-center">
                                <i class="fas fa-sort text-gray-500 text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Search -->
                    <div class="flex justify-end mb-4">
                        <div class="relative">
                            <input type="text" placeholder="Search" class="bg-gray-100 rounded-md px-4 py-1 text-sm">
                            <button class="absolute right-2 top-1/2 transform -translate-y-1/2">
                                <i class="fas fa-search text-gray-400 text-xs"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Table -->
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-gray-500 uppercase text-xs">
                                <th class="py-2 text-left">Invoice</th>
                                <th class="py-2 text-left">Customers</th>
                                <th class="py-2 text-left">From</th>
                                <th class="py-2 text-left">Price</th>
                                <th class="py-2 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="py-2">12396</td>
                                <td class="py-2">Christy Jean</td>
                                <td class="py-2">Russia</td>
                                <td class="py-2">$2652</td>
                                <td class="py-2">
                                    <button class="bg-pink-500 text-white text-xs rounded-md px-3 py-1">Process</button>
                                </td>
                            </tr>
                            <tr>
                                <td class="py-2">12398</td>
                                <td class="py-2">Christy Jean</td>
                                <td class="py-2">Russia</td>
                                <td class="py-2">$2652</td>
                                <td class="py-2">
                                    <button class="bg-indigo-600 text-white text-xs rounded-md px-3 py-1">Open</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="flex justify-center mt-4">
                        <div class="flex space-x-1">
                            <button class="w-6 h-6 bg-gray-200 rounded-md flex items-center justify-center text-xs">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button
                                class="w-6 h-6 bg-red-500 text-white rounded-md flex items-center justify-center text-xs">1</button>
                            <button
                                class="w-6 h-6 bg-gray-200 rounded-md flex items-center justify-center text-xs">2</button>
                            <button
                                class="w-6 h-6 bg-gray-200 rounded-md flex items-center justify-center text-xs">3</button>
                            <button
                                class="w-6 h-6 bg-gray-200 rounded-md flex items-center justify-center text-xs">4</button>
                            <button
                                class="w-6 h-6 bg-gray-200 rounded-md flex items-center justify-center text-xs">5</button>
                            <button class="w-6 h-6 bg-gray-200 rounded-md flex items-center justify-center text-xs">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Area Chart for Earnings
    const earningsCtx = document.getElementById('earningsChart').getContext('2d');
    const earningsChart = new Chart(earningsCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Feb', 'Mar', 'Apr', 'May'],
            datasets: [{
                    label: 'Earnings',
                    data: [15, 20, 25, 30, 25, 35, 15],
                    borderColor: '#F472B6',
                    backgroundColor: 'rgba(244, 114, 182, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2
                },
                {
                    label: 'Sales',
                    data: [10, 15, 20, 15, 25, 20, 10],
                    borderColor: '#818CF8',
                    backgroundColor: 'rgba(129, 140, 248, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    min: 0,
                    max: 35,
                    ticks: {
                        stepSize: 5
                    }
                }
            },
            elements: {
                point: {
                    radius: 0
                }
            }
        }
    });

    // Donut Chart for Analytics
    const analyticsCtx = document.getElementById('analyticsChart').getContext('2d');
    const analyticsChart = new Chart(analyticsCtx, {
        type: 'doughnut',
        data: {
            labels: ['Sale', 'Distribute', 'Return'],
            datasets: [{
                data: [55, 25, 20],
                backgroundColor: [
                    '#4F46E5',
                    '#FBBF24',
                    '#F87171'
                ],
                borderWidth: 0,
                cutout: '75%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
    </script>
</body>

</html>