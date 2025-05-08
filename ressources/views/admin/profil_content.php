<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil utilisateur</title>

</head>

<body class="bg-gray-100 min-h-screen">


    <!-- User Profile Interface -->
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg my-8 overflow-hidden">
        <div class="flex bg-white">
            <!-- Main Content -->
            <div class="flex-1 p-6">

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