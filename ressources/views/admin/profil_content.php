<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between">
                <div class="flex space-x-8">
                    <button class="py-4 px-2 border-b-2 border-blue-500 text-blue-500 font-medium">User Profile</button>
                    <button class="py-4 px-2 border-b-0 text-gray-500 font-medium">User Management</button>
                    <button class="py-4 px-2 border-b-0 text-gray-500 font-medium">Audit Trail</button>
                </div>
            </div>
        </div>
    </div>

    <!-- User Profile Interface -->
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg my-8 overflow-hidden">
        <div class="flex bg-white">
            <!-- Sidebar -->
            <div class="w-48 bg-blue-500 text-white p-4">
                <div class="pb-4">
                    <button class="flex items-center text-sm text-white mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back
                    </button>
                </div>
                <div class="text-center mb-6">
                    <div class="inline-block rounded-full overflow-hidden h-20 w-20 bg-gray-200 border-2 border-white">
                        <img src="/api/placeholder/80/80" alt="Profile picture" class="h-full w-full object-cover" />
                    </div>
                    <div class="flex justify-center items-center">
                        <span class="text-sm font-medium mt-2">Nathaniel Poole</span>
                        <span
                            class="ml-1 text-xs bg-blue-600 text-white rounded-full h-4 w-4 flex items-center justify-center">✓</span>
                    </div>
                    <div class="text-xs text-blue-100 mt-1">Recruiter</div>
                </div>
                <nav class="mt-8">
                    <a href="#" class="flex items-center py-2 text-sm mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Overview
                    </a>
                    <a href="#" class="flex items-center py-2 text-sm mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        Watchlist
                        <span class="ml-auto bg-red-500 text-xs rounded px-1">2</span>
                    </a>
                    <a href="#" class="flex items-center py-2 text-sm mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        Messages
                        <span class="ml-auto bg-red-500 text-xs rounded px-1">1</span>
                    </a>
                    <a href="#" class="flex items-center py-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Scheduling
                    </a>
                </nav>
                <div class="mt-8">
                    <div class="text-xs font-medium text-blue-100 mb-2">Opportunities</div>
                    <div class="flex justify-between text-xs mb-1">
                        <span>Opportunities applied</span>
                        <span class="bg-yellow-500 text-white px-1 rounded">19</span>
                    </div>
                    <div class="flex justify-between text-xs mb-1">
                        <span>Opportunities won</span>
                        <span class="bg-green-500 text-white px-1 rounded">26</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span>Current opportunities</span>
                        <span class="bg-blue-600 text-white px-1 rounded">4</span>
                    </div>
                </div>
                <div class="mt-8 text-center">
                    <button class="text-xs text-blue-100 mb-3">View Public Profile</button>
                    <div class="text-xs text-blue-200 flex items-center justify-center">
                        <span class="truncate">https://app.site/profile</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 ml-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 p-6">
                <div class="flex gap-4 mb-5">
                    <button class="px-3 py-1 text-sm border-b-2 border-blue-500 text-blue-500">Account Settings</button>
                    <button class="px-3 py-1 text-sm text-gray-500">Company Settings</button>
                    <button class="px-3 py-1 text-sm text-gray-500">Documents</button>
                    <button class="px-3 py-1 text-sm text-gray-500">Billing</button>
                    <button class="px-3 py-1 text-sm text-gray-500">Notifications</button>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <!-- First column -->
                    <div>
                        <div class="mb-4">
                            <label class="block text-sm text-gray-700 mb-1">First Name</label>
                            <input type="text" value="Nathaniel"
                                class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm text-gray-700 mb-1">Phone Number</label>
                            <input type="text" value="+1800-000"
                                class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm text-gray-700 mb-1">City</label>
                            <input type="text" value="Bridgeport"
                                class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm text-gray-700 mb-1">Postcode</label>
                            <input type="text" value="53005"
                                class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <!-- Second column -->
                    <div>
                        <div class="mb-4">
                            <label class="block text-sm text-gray-700 mb-1">Last Name</label>
                            <input type="text" value="Poole"
                                class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm text-gray-700 mb-1">Email address</label>
                            <input type="email" value="nathaniel.poole@worksmail.com"
                                class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm text-gray-700 mb-1">State/County</label>
                            <div class="relative">
                                <input type="text" value="WA"
                                    class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <div class="absolute inset-y-0 right-0 flex items-center px-2">
                                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm text-gray-700 mb-1">Country</label>
                            <div class="relative">
                                <input type="text" value="United States"
                                    class="w-full px-3 py-2 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <div class="absolute inset-y-0 right-0 flex items-center px-2">
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

                <div class="mt-6">
                    <button
                        class="bg-blue-500 text-white px-6 py-2 rounded text-sm font-medium hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Update</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>