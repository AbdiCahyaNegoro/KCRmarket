<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SELAMAT DATANG::SELAMAT BERBELANJA')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href={{ asset('assets/vendor/fontawesome-free/css/all.min.css') }} rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="//unpkg.com/alpinejs" defer></script>


</head>

<body class="bg-gray-100 font-sans">
    <header class="bg-gray-800 py-3 shadow-lg">
        <div class="container mx-auto flex justify-between items-center px-4 md:px-6">
            <a href="{{ route('index') }}" class="flex items-center space-x-2">
                <img src="{{ asset('assets/img/logobrand.png') }}" width="70" class="rounded-md shadow-md">
            </a>
            <nav class="flex items-center space-x-6 text-white font-medium">
                @guest
                    <a href="{{ route('login') }}" class="hover:text-gray-300 transition">LOGIN</a>
                    <a href="{{ route('register') }}" class="hover:text-gray-300 transition">REGISTER</a>
                @endguest
                @auth
                    @if (Auth::user()->leveluser == 1)
                        <a href="{{ route('beranda') }}" class="hover:text-gray-300 transition">DASHBOARD ADMIN</a>
                    @endif
                    @if (Auth::user()->leveluser == 2)
                        <a href="{{ route('keranjang') }}"
                            class="relative hover:text-gray-300 transition flex items-center">
                            <i class="fas fa-shopping-cart mr-2 text-xl"></i> KERANJANG
                            @if (isset($jumlahItemKeranjang) && $jumlahItemKeranjang > 0)
                                <span
                                    class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                                    {{ $jumlahItemKeranjang }}
                                </span>
                            @endif
                        </a>
                        <a href="{{ route('pesanan.belumbayar') }}"
                            class="relative hover:text-gray-300 transition flex items-center">
                            <i class="fas fa-receipt mr-2 text-xl"></i> PESANAN
                            @if (isset($jumlahPesananBelumBayar) && $jumlahPesananBelumBayar > 0)
                                <span
                                    class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                                    {{ $jumlahPesananBelumBayar }}
                                </span>
                            @endif
                        </a>
                    @endif
                    <div class="relative">
                        <button
                            class="text-white font-bold flex items-center space-x-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            id="dropdownButton">
                            <span>{{ strtoupper(Auth::user()->name) }}</span>
                            <i class="fas fa-caret-down"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="dropdownMenu"
                            class="absolute right-0 mt-3 w-48 bg-white text-black rounded-lg shadow-lg hidden">
                            <a href="{{ route('Profile') }}" class="block px-4 py-2 hover:bg-gray-200">PROFILE</a>
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-200">LOGOUT</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </nav>
        </div>
    </header>

    <main class="container mx-auto py-8 px-6">
        @yield('isimarket')
    </main>

    <footer class="bg-gray-800 text-white py-6 mt-8">
        <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold">Alamat Kami :</h2>
                <p>Jl. Nuansa Baru,<br>Suka Mulya, Kec. Sematang Borang, Kota Palembang Sumatera Selatan 30961</p>
                <p class="mt-2">Telepon: 081223123321</p>
                <p>Email: @gmail.com</p>
            </div>
            <div>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.5369106242106!2d104.81479537393191!3d-2.9483831396995543!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3b77c7b99e04ef%3A0xf1b6c2b3135c1e29!2sJASA%20CUSTOM%20ROM%20%26%20ROOT%20-%20%40khoiril_cr!5e0!3m2!1sid!2sid!4v1743423017673!5m2!1sid!2sid"
                    width="100%" height="250" frameborder="0" class="rounded-lg"></iframe>
            </div>
        </div>
    </footer>

    <div class="bg-gray-900 text-white text-center py-4">
        <p>&copy; <?= date('Y') ?> Khoiril Costum Rom - Official</p>
    </div>

    <script>
        // Get references to the button and the dropdown menu
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        // Toggle visibility of the dropdown menu when the button is clicked
        dropdownButton.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevents the click event from propagating to the document
            dropdownMenu.classList.toggle('hidden'); // Toggles visibility of the dropdown
        });

        // Close the dropdown if the user clicks anywhere outside of it
        document.addEventListener('click', function(event) {
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
