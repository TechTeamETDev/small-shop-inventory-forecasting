<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InventoryMaster</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://googleapis.com" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white text-slate-900 antialiased min-h-screen flex flex-col">

    <!-- Simple Centered Header -->
    <nav class="w-full py-12 flex justify-center">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
            </div>
            <span class="text-xl font-bold tracking-tight">Inventory<span class="text-blue-600">Master</span></span>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col items-center justify-center px-6 -mt-20">
        <div class="max-w-3xl w-full text-center">
            <h1 class="text-5xl md:text-6xl font-bold text-slate-900 tracking-tight mb-6">
                Inventory management <br>
                <span class="text-slate-400 font-medium">for the modern shop.</span>
            </h1>
            
            <p class="text-lg text-slate-500 mb-12 max-w-lg mx-auto">
                A minimalist approach to tracking stock and growing your business with total clarity.
            </p>

            <!-- Centered Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" 
                       class="w-full sm:w-auto bg-slate-900 text-white px-12 py-4 rounded-xl font-semibold hover:bg-slate-800 transition">
                        Login
                    </a>
                @endif

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" 
                       class="w-full sm:w-auto px-12 py-4 rounded-xl font-semibold text-slate-600 border border-slate-200 hover:bg-slate-50 transition">
                        Register
                    </a>
                @endif
            </div>
        </div>
    </main>

   

</body>
</html>
