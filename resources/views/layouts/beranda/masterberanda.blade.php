<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>::KCR::Admin</title>

    <!-- Custom fonts for this template-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom styles for this template-->
    <link rel="stylesheet" type="text/css" href={{ asset('assets/css/sb-admin-2.min.css') }} rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

    <!-- Sidebar -->
    <div class="flex flex-col h-screen w-64 fixed left-0 top-0 bg-gradient-to-b from-gray-900 to-gray-800 text-gray-200 shadow-lg z-10 overflow-y-auto transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out" id="sidebar">
        <!-- Sidebar - Brand -->
        <div class="flex items-center justify-center p-4 border-b border-gray-700">
            <a href="{{ route('beranda') }}" class="flex items-center justify-center">
                <img src="{{ asset('assets/img/logobrand.png') }}" alt="logobrand" class="w-48">
            </a>
        </div>

        <!-- Navigation Items -->
        <nav class="flex-1 overflow-y-auto">
            <div class="space-y-1 px-2 py-4">
                <!-- Dashboard -->
                <a href="{{ route('beranda') }}" class="flex items-center px-4 py-2 text-base font-medium rounded-md hover:bg-white hover:text-blue-800">
                    <i class="fa fa-home mr-3 text-lg"></i>
                    <span>Beranda</span>
                </a>

                <div class="border-t border-blue-700 my-2"></div>

                <!-- Market Section -->
                <div class="px-4 pt-2 pb-1 text-xs font-medium uppercase tracking-wider text-gray-400">
                    Market
                </div>

                <!-- Data Pelanggan -->
                <a href="{{ route('tampilpelanggan') }}" class="flex items-center px-4 py-2 text-base font-medium rounded-md hover:bg-white hover:text-blue-800">
                    <i class="fa fa-users mr-3 text-lg"></i>
                    <span>Data Pelanggan</span>
                </a>

                <!-- Produk Dropdown -->
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-2 text-base font-medium rounded-md hover:bg-white hover:text-blue-800">
                        <div class="flex items-center">
                            <i class="fas fa-book mr-3 text-lg"></i>
                            <span>Produk</span>
                        </div>
                        <svg :class="{'transform rotate-180': open}" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4 space-y-1 bg-gray-700 rounded-md">
                        <a href="{{ route('tampilproduk') }}" class="block px-4 py-2 text-sm font-medium rounded-md hover:bg-gray-600 hover:text-white">Data Produk</a>
                        <a href="{{ route('admin.tambahproduk') }}" class="block px-4 py-2 text-sm font-medium rounded-md hover:bg-white hover:text-blue-800">Tambah Produk Jasa</a>
                        <a href="{{ route('admin.tambahjenis') }}" class="block px-4 py-2 text-sm font-medium rounded-md hover:bg-white hover:text-blue-800">Tambah Brand Dan Type</a>
                    </div>
                </div>

                <!-- Pesanan Dropdown -->
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-2 text-base font-medium rounded-md hover:bg-white hover:text-blue-800">
                        <div class="flex items-center">
                            <i class="fas fa-list-alt mr-3 text-lg"></i>
                            <span>Pesanan</span>
                        </div>
                        <svg :class="{'transform rotate-180': open}" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4 space-y-1 bg-gray-700 rounded-md">
                        <a href="{{ route('semuapesanan') }}" class="block px-4 py-2 text-sm font-medium rounded-md hover:bg-gray-600 hover:text-white">Semua Pesanan</a>
                        <a href="{{ route('tampilpesanan') }}" class="block px-4 py-2 text-sm font-medium rounded-md hover:bg-gray-600 hover:text-white">Konfirmasi Pembayaran</a>
                        <a href="{{ route('pesananditolak') }}" class="block px-4 py-2 text-sm font-medium rounded-md hover:bg-gray-600 hover:text-white">Pembayaran Ditolak</a>
                    </div>
                </div>

                <!-- Take Job Dropdown -->
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-2 text-base font-medium rounded-md hover:bg-white hover:text-blue-800">
                        <div class="flex items-center">
                            <i class="fas fa-paper-plane mr-3 text-lg"></i>
                            <span>Take Job</span>
                        </div>
                        <svg :class="{'transform rotate-180': open}" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" class="pl-4 space-y-1 bg-gray-700 rounded-md">
                        <a href="{{ route('admin.takejob') }}" class="block px-4 py-2 text-sm font-medium rounded-md hover:bg-gray-600 hover:text-white">Job</a>
                        <a href="{{ route('admin.jobdone') }}" class="block px-4 py-2 text-sm font-medium rounded-md hover:bg-gray-600 hover:text-white">Selesai</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content with scrollable area -->
            <div class="flex flex-col md:ml-64 min-h-screen">
                <!-- Topbar -->
                <nav class="flex items-center bg-white shadow px-4 py-2 h-16 fixed top-0 right-0 left-0 md:left-64 z-10">
                    <!-- Mobile menu button -->
                    <button id="mobileMenuButton" class="md:hidden text-gray-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <!-- User Profile (pushed to right) -->
                    <div class="ml-auto flex items-center space-x-4" x-data="{ open: false }">
                        <!-- User Dropdown -->
                        <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                            <span class="hidden lg:inline text-gray-600 font-medium">
                                {{ strtoupper(Auth::user()->name) }}
                            </span>
                            <img class="w-8 h-8 rounded-full" 
                                 src="{{ asset(Auth::user()->folder .'/'.Auth::user()->foto) }}" 
                                 alt="User profile">
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-4 mt-10 w-48 bg-white rounded-md shadow-lg z-10">
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" 
                                        @click="$event.target.closest('[x-data]').__x.$data.loading = true"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    LOGOUT
                                </button>
                            </form>
                        </div>
                    </div>
                </nav>
                <!-- End of Topbar -->
                <!-- Scrollable content area with footer space -->
                <div class="flex-1 overflow-y-auto mt-16 p-6 bg-gray-50 pb-20">
                    @yield('content')
                </div>

                <!-- Fixed footer -->
                <footer class="fixed bottom-0 left-0 right-0 md:left-64 bg-white border-t border-gray-200 py-4 z-10">
                    <div class="container mx-auto px-4">
                        <div class="text-center text-gray-600">
                            <span>Copyright &copy; <?= date('Y') ?> Khoiril Costum Rom - Official</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Loading Animation -->
        <div x-data="{ loading: false }" 
             x-show="loading"
             x-init="loading = false"
             class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="animate-spin rounded-full h-16 w-16 border-t-2 border-b-2 border-blue-500"></div>
        </div>

        <script>
            function showLoading() {
                document.querySelector('[x-data]').__x.$data.loading = true;
            }

            // Mobile menu toggle
            document.getElementById('mobileMenuButton').addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.toggle('translate-x-0');
                sidebar.classList.toggle('-translate-x-full');
            });

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const sidebar = document.getElementById('sidebar');
                const mobileBtn = document.getElementById('mobileMenuButton');
                if (!sidebar.contains(event.target) && !mobileBtn.contains(event.target) && window.innerWidth < 768) {
                    sidebar.classList.remove('translate-x-0');
                    sidebar.classList.add('-translate-x-full');
                }
            });
        </script>





        <!-- Bootstrap core JavaScript-->
        <script src="assets/vendor/jquery/jquery.min.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="assets/js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="assets/vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="assets/js/demo/chart-area-demo.js"></script>
        <script src="assets/js/demo/chart-pie-demo.js"></script>

        @yield('scripts')
</body>

</html>
