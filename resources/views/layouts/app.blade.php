<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div id="app" class="min-h-screen flex flex-col">
        <nav class="bg-gray-900 shadow-sm py-2">
            <div class="max-w-screen-lg mx-auto px-4 flex justify-between items-center">
                <a href="{{ url('/') }}" class="flex items-center">
                    <img src="{{ url('assets/img/logobrand.png') }}"  width="70" alt="Brand Logo">
                </a>
                <button class="lg:hidden text-gray-700 focus:outline-none" id="menu-toggle">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </nav>
       

        <main class="flex-grow container mx-auto py-6 px-4">
            @yield('content')
        </main>
    </div>

    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            document.getElementById('navbar').classList.toggle('hidden');
        });
    </script>
</body>
</html>