@extends('layouts.market.masteheaderrmarket')

@section('isimarket')
    <!-- Header Section -->
    <div class="py-1">
        <div class="container mx-auto">

            <!-- Slide Carousel Fullscreen -->
            <div x-data="{ slide: 1, total: 3 }"
                 x-init="setInterval(() => slide = slide === total ? 1 : slide + 1, 5000)"
                 class="relative h-[200px] sm:h-[250px] md:h-[300px] lg:h-[400px] overflow-hidden flex items-center justify-center bg-gray-900 rounded-xl">

                <!-- Slide 1 -->
                <img src="{{ asset('assets/img/iklan/iklan1.png') }}"
                     class="absolute max-w-full max-h-full object-contain transition-opacity duration-1000 z-0"
                     x-show="slide === 1" x-transition.opacity>

                <!-- Slide 2 -->
                <img src="{{ asset('assets/img/iklan/iklan2.png') }}"
                     class="absolute max-w-full max-h-full object-contain transition-opacity duration-1000 z-0"
                     x-show="slide === 2" x-transition.opacity>

                <!-- Slide 3 -->
                <img src="{{ asset('assets/img/iklan/iklan3.png') }}"
                     class="absolute max-w-full max-h-full object-contain transition-opacity duration-1000 z-0"
                     x-show="slide === 3" x-transition.opacity>

                <!-- Indikator -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-3">
                    <span @click="slide = 1" :class="slide === 1 ? 'bg-white scale-125' : 'bg-gray-500'"
                          class="w-3 h-3 rounded-full cursor-pointer transition-all"></span>
                    <span @click="slide = 2" :class="slide === 2 ? 'bg-white scale-125' : 'bg-gray-500'"
                          class="w-3 h-3 rounded-full cursor-pointer transition-all"></span>
                    <span @click="slide = 3" :class="slide === 3 ? 'bg-white scale-125' : 'bg-gray-500'"
                          class="w-3 h-3 rounded-full cursor-pointer transition-all"></span>
                </div>
            </div>

            <!-- Search Bar Section -->
            <div class="flex justify-center mt-6">
                <div class="relative w-full max-w-2xl">
                    <input type="text" id="searchInput"
                           class="w-full p-4 text-lg border border-gray-300 rounded-full shadow focus:ring-2 focus:ring-blue-500 focus:outline-none"
                           placeholder="Cari Jasa...">
                    <button class="absolute inset-y-0 right-4 flex items-center text-blue-500">
                        <i class="fa fa-search text-xl"></i>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Alert -->
    @if (session('success'))
        <div class="bg-green-500 text-white text-center p-4 rounded-md my-4 container mx-auto">
            {{ session('success') }}
        </div>
    @endif

    <!-- Product Section -->
    <div class="py-10 bg-gray-100">
        <div class="container">
            <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Daftar Jasa Produk</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8" id="productList">
                @foreach ($produk as $item)
                    <div class="p-5 border border-gray-200 rounded-xl shadow bg-white hover:shadow-lg transition"
                         data-name="{{ strtolower($item->nama_produk) }}">
                        <h4 class="font-semibold text-xl text-center text-gray-800">{{ $item->nama_produk }}</h4>
                        <div class="produk_img text-center my-4">
                            <img src="{{ asset($item->folder . '/' . $item->nama_foto) }}"
                                 alt="{{ $item->nama_produk }}"
                                 class="w-full h-48 object-cover rounded-md">
                        </div>
                        <p class="text-center text-gray-600">Harga: <span class="font-bold text-gray-900">Rp. {{ number_format($item->harga, 0, ',', '.') }}</span></p>
                        <div class="flex justify-center mt-4">
                            @auth
                                <a href="{{ route('detailproduk', $item->id_produk) }}"
                                   class="bg-gray-800 text-white py-2 px-5 rounded-md hover:bg-gray-700 transition">Lihat Detail</a>
                            @else
                                <a href="{{ route('login') }}"
                                   class="bg-gray-800 text-white py-2 px-5 rounded-md hover:bg-gray-700 transition">Lihat Detail</a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        document.getElementById('searchInput').addEventListener('input', function () {
            let filter = this.value.toLowerCase();
            let items = document.querySelectorAll('#productList .p-5');

            items.forEach(item => {
                let name = item.getAttribute('data-name');
                item.classList.toggle('hidden', !name.includes(filter));
            });
        });
    </script>
@endsection
