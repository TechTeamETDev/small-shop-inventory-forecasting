<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Small Shop Inventory System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-md w-full text-center">
        <!-- Simple icon -->
        <div class="mb-4">
            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </div>
        </div>
        
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Small Shop Inventory</h1>
        <p class="text-gray-500 text-sm mb-6">Manage products, sales, and stock — simply.</p>
        
        <div class="space-y-3">
            <a href="/login" class="block w-full py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                Login
            </a>
            <a href="/register" class="block w-full py-2.5 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                Register
            </a>
        </div>
        
        <p class="text-xs text-gray-400 mt-6">Easy setup</p>
    </div>

</body>
</html>