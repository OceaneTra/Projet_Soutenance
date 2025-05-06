<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management Interface</title>

</head>

<body class="bg-gray-100">
    <div class="max-w-6xl mx-auto p-6">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-4 flex justify-between items-center">
            <div class="flex space-x-4">
                <button class="px-3 py-1 bg-blue-50 text-blue-600 font-medium rounded-md">Products</button>
                <button class="px-3 py-1 text-gray-500 font-medium rounded-md">Categories</button>
                <button class="px-3 py-1 text-gray-500 font-medium rounded-md">Collections</button>
            </div>
            <button class="flex items-center justify-center bg-blue-600 text-white rounded-md px-4 py-2">
                <span class="mr-1">+</span> New product
            </button>
        </div>

        <!-- Filters Bar -->
        <div class="flex justify-between mb-4 items-center">
            <div class="flex items-center space-x-2">
                <div class="flex items-center bg-white rounded-md border border-gray-300 px-3 py-2">
                    <span class="text-gray-600 text-sm">Channel name</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
                <div class="flex items-center bg-white rounded-md border border-gray-300 px-3 py-2">
                    <span class="text-gray-600 text-sm">En</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="flex justify-between mb-4 items-center">
            <div class="flex items-center space-x-2">
                <div class="flex items-center bg-white rounded-md border border-gray-300 px-3 py-2">
                    <span class="text-gray-600 text-sm">Choose action</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
                <div class="flex items-center text-gray-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <div class="relative">
                    <input type="text" placeholder="Find products"
                        class="bg-white rounded-md border border-gray-300 px-3 py-2 text-sm w-48">
                </div>
                <div class="flex items-center bg-white rounded-md border border-gray-300 px-3 py-2">
                    <span class="text-gray-600 text-sm">Filter</span>
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
                <button class="bg-white rounded-md border border-gray-300 p-2">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <table class="w-full table-fixed">
                <thead>
                    <tr class="bg-gray-50 text-left text-gray-500 text-sm">
                        <th class="w-12 p-4">
                            <input type="checkbox" class="rounded text-blue-500">
                        </th>
                        <th class="w-24 p-4 font-medium">Code</th>
                        <th class="w-1/4 p-4 font-medium">Name</th>
                        <th class="w-1/4 p-4 font-medium">Model</th>
                        <th class="w-1/6 p-4 font-medium">Created at</th>
                        <th class="w-1/6 p-4 font-medium">Modified at</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50">
                        <td class="p-4"><input type="checkbox" class="rounded text-blue-500"></td>
                        <td class="p-4 text-gray-500 text-sm">827842</td>
                        <td class="p-4 text-blue-500">This is a product</td>
                        <td class="p-4 text-gray-500">Model name</td>
                        <td class="p-4 text-gray-500 text-sm">4.9.2018</td>
                        <td class="p-4 text-gray-500 text-sm">11.9.2018</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="p-4"><input type="checkbox" class="rounded text-blue-500"></td>
                        <td class="p-4 text-gray-500 text-sm">287364</td>
                        <td class="p-4 text-blue-500">This is product as well</td>
                        <td class="p-4 text-gray-500">Model name</td>
                        <td class="p-4 text-gray-500 text-sm">3.10.2018</td>
                        <td class="p-4 text-gray-500 text-sm">12.10.2018</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="p-4"><input type="checkbox" class="rounded text-blue-500"></td>
                        <td class="p-4 text-gray-500 text-sm">827842</td>
                        <td class="p-4 text-blue-500">Product name</td>
                        <td class="p-4 text-gray-500">Model name</td>
                        <td class="p-4 text-gray-500 text-sm">4.9.2018</td>
                        <td class="p-4 text-gray-500 text-sm">11.9.2018</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="p-4"><input type="checkbox" class="rounded text-blue-500"></td>
                        <td class="p-4 text-gray-500 text-sm">283761</td>
                        <td class="p-4 text-blue-500">Another product name</td>
                        <td class="p-4 text-gray-500">Model name</td>
                        <td class="p-4 text-gray-500 text-sm">3.10.2018</td>
                        <td class="p-4 text-gray-500 text-sm">12.10.2018</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="p-4"><input type="checkbox" class="rounded text-blue-500"></td>
                        <td class="p-4 text-gray-500 text-sm">827842</td>
                        <td class="p-4 text-blue-500">Product name</td>
                        <td class="p-4 text-gray-500">Model name</td>
                        <td class="p-4 text-gray-500 text-sm">4.9.2018</td>
                        <td class="p-4 text-gray-500 text-sm">11.9.2018</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="p-4"><input type="checkbox" class="rounded text-blue-500"></td>
                        <td class="p-4 text-gray-500 text-sm">283761</td>
                        <td class="p-4 text-blue-500">Another product name</td>
                        <td class="p-4 text-gray-500">Model name</td>
                        <td class="p-4 text-gray-500 text-sm">3.10.2018</td>
                        <td class="p-4 text-gray-500 text-sm">12.10.2018</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="p-4"><input type="checkbox" class="rounded text-blue-500"></td>
                        <td class="p-4 text-gray-500 text-sm">827842</td>
                        <td class="p-4 text-blue-500">Product name</td>
                        <td class="p-4 text-gray-500">Model name</td>
                        <td class="p-4 text-gray-500 text-sm">4.9.2018</td>
                        <td class="p-4 text-gray-500 text-sm">11.9.2018</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="p-4"><input type="checkbox" class="rounded text-blue-500"></td>
                        <td class="p-4 text-gray-500 text-sm">283761</td>
                        <td class="p-4 text-blue-500">Another product name</td>
                        <td class="p-4 text-gray-500">Model name</td>
                        <td class="p-4 text-gray-500 text-sm">3.10.2018</td>
                        <td class="p-4 text-gray-500 text-sm">12.10.2018</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="p-4"><input type="checkbox" class="rounded text-blue-500"></td>
                        <td class="p-4 text-gray-500 text-sm">827842</td>
                        <td class="p-4 text-blue-500">Product name</td>
                        <td class="p-4 text-gray-500">Model name</td>
                        <td class="p-4 text-gray-500 text-sm">4.9.2018</td>
                        <td class="p-4 text-gray-500 text-sm">11.9.2018</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="p-4"><input type="checkbox" class="rounded text-blue-500"></td>
                        <td class="p-4 text-gray-500 text-sm">283761</td>
                        <td class="p-4 text-blue-500">Another product name</td>
                        <td class="p-4 text-gray-500">Model name</td>
                        <td class="p-4 text-gray-500 text-sm">3.10.2018</td>
                        <td class="p-4 text-gray-500 text-sm">12.10.2018</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-4 gap-2">
            <button class="p-2 rounded border border-gray-300 bg-white">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button class="px-4 py-2 rounded border bg-blue-500 text-white">1</button>
            <button class="p-2 rounded border border-gray-300 bg-white">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>
</body>

</html>