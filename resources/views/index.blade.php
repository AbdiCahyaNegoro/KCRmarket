@extends('layouts.market.masteheaderrmarket')

@section('isimarket')
    <div class="header_section bg-gray-100 py-1">
        <div class="container mx-auto">

            <!-- Slide Carousel Fullscreen -->
            <div x-data="{ slide: 1, total: 3 }" x-init="setInterval(() => slide = slide === total ? 1 : slide + 1, 5000)"
                class="relative  h-[200px] sm:h-[250px] md:h-[300px] lg:h-[400px] overflow-hidden flex items-center justify-center bg-gray-800">

                <!-- Slide 1 -->
                <img src="{{ asset('assets/img/iklan/iklan1.png') }}"
                    class="absolute max-w-full max-h-full object-contain transition-opacity duration-10000 z-0"
                    x-show="slide === 1" x-transition.opacity>

                <!-- Slide 2 -->
                <img src="{{ asset('assets/img/iklan/iklan2.png') }}"
                    class="absolute max-w-full max-h-full object-contain transition-opacity duration-10000 z-0"
                    x-show="slide === 2" x-transition.opacity>

                <!-- Slide 3 -->
                <img src="{{ asset('assets/img/iklan/iklan3.png') }}"
                    class="absolute max-w-full max-h-full object-contain transition-opacity duration-10000 z-0"
                    x-show="slide === 3" x-transition.opacity>

                <!-- Indikator -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-3">
                    <span @click="slide = 1" :class="slide === 1 ? 'bg-white scale-125' : 'bg-gray-400'"
                        class="w-4 h-4 rounded-full cursor-pointer transition-all"></span>
                    <span @click="slide = 2" :class="slide === 2 ? 'bg-white scale-125' : 'bg-gray-400'"
                        class="w-4 h-4 rounded-full cursor-pointer transition-all"></span>
                    <span @click="slide = 3" :class="slide === 3 ? 'bg-white scale-125' : 'bg-gray-400'"
                        class="w-4 h-4 rounded-full cursor-pointer transition-all"></span>
                </div>
            </div>


            <!-- Search Bar Section -->
            <div class="flex justify-center mt-6">
                <div class="relative w-full max-w-2xl">
                    <input type="text" id="searchInput"
                        class="w-full p-4 text-lg border border-gray-800 rounded-full shadow-md focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        placeholder="Cari Jasa...">
                    <button class="absolute inset-y-0 right-4 flex items-center text-blue-500">
                        <i class="fa fa-search text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-500 text-white text-center p-4 rounded-md my-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="fashion_section py-6">
        <div class="container">
            <h1 class="text-2xl font-bold text-center mb-6">Daftar Jasa Produk</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="productList">
                @foreach ($produk as $item)
                    <div class="box_main p-4 border rounded-lg shadow-md bg-white"
                        data-name="{{ strtolower($item->nama_produk) }}">
                        <h4 class="font-semibold text-lg text-center">{{ $item->nama_produk }}</h4>
                        <div class="produk_img text-center my-3">
                            <img src="{{ asset($item->folder . '/' . $item->nama_foto) }}" alt="{{ $item->nama_produk }}"
                                class="w-full h-48 object-cover rounded-md">
                        </div>
                        <p class="text-center text-gray-700">Harga: <span class="font-bold">Rp.
                                {{ number_format($item->harga, 0, ',', '.') }}</span></p>
                        <div class="flex justify-center mt-4 space-x-3">
                            @auth
                                <a href="{{ route('detailproduk', $item->id_produk) }}"
                                    class="bg-gray-700 text-white py-2 px-4 rounded-md">Lihat Detail</a>
                            @else
                                <a href="{{ route('login') }}" class="bg-gray-700 text-white py-2 px-4 rounded-md">Lihat
                                    Detail</a>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let items = document.querySelectorAll('#productList .box_main');

            items.forEach(item => {
                let name = item.getAttribute('data-name');
                item.classList.toggle('hidden', !name.includes(filter));
            });
        });
    </script>
@endsection
