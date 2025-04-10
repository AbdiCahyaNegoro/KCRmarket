@extends('layouts.market.masteheaderrmarket')
@section('title', 'Detail Produk')

@section('isimarket')
<div class="fashion_section py-10">
    <div class="container mx-auto px-4">

        {{-- Notifikasi --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-yellow-100 text-yellow-800 px-4 py-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="text-3xl font-bold mb-6 text-center">Detail Produk</h1>
        <div class="grid md:grid-cols-2 gap-6">

            <!-- Kiri: Info Produk -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h4 class="text-xl font-semibold mb-4">{{ $produk->nama_produk }}</h4>
                <img src="{{ asset($produk->folder . '/' . $produk->nama_foto) }}"
                    class="w-full h-64 object-cover rounded-md" alt="{{ $produk->nama_produk }}">
                <p class="mt-4 text-gray-700">Deskripsi: <span class="italic">{{ $produk->deskripsiproduk }}</span></p>
            </div>

            <!-- Kanan: Formulir -->
            <div>
                <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                    <h4 class="text-xl font-semibold mb-4">Harga</h4>
                    <p class="text-lg font-medium">Harga: <span class="text-green-600">Rp.
                            {{ number_format($produk->harga, 0, ',', '.') }}</span></p>
                </div>

                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h4 class="text-xl font-semibold mb-4">Pesan Produk</h4>

                    {{-- Form Input Umum --}}
                    <form id="formInput" class="space-y-4">
                        <input type="hidden" name="id_produk" id="id_produk" value="{{ $produk->id_produk }}">

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="brand">Brand:</label>
                                <select name="brand" id="brand" required class="w-full border rounded px-2 py-1">
                                    <option value="">Pilih Brand</option>
                                    @foreach ($brandproduk->unique('brand') as $brand)
                                        <option value="{{ $brand->brand }}">{{ $brand->brand }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="type">Type:</label>
                                <select name="type" id="type" required class="w-full border rounded px-2 py-1">
                                    <option value="">Pilih Type</option>
                                </select>
                            </div>
                        </div>
                    </form>

                    {{-- Tombol Tambah ke Keranjang --}}
                    <form action="{{ route('keranjang.tambah') }}" method="POST" onsubmit="return submitSharedInputs(this)">
                        @csrf
                        <input type="hidden" name="id_produk">
                        <input type="hidden" name="brand">
                        <input type="hidden" name="type">

                        <button type="submit" class="w-full mt-2 bg-blue-600 text-white py-2 px-4 rounded-md">
                            Masuk Keranjang
                        </button>
                    </form>

                    {{-- Tombol Pesan Langsung --}}
                    <form action="{{ route('pesan.langsung') }}" method="POST" class="mt-2" onsubmit="return submitSharedInputs(this)">
                        @csrf
                        <input type="hidden" name="id_produk">
                        <input type="hidden" name="qty" value="1">
                        <input type="hidden" name="brand">
                        <input type="hidden" name="type">

                        <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-md">
                            Pesan Langsung
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const brandSelect = document.getElementById("brand");
        const typeSelect = document.getElementById("type");
        const brandData = @json($brandproduk);

        brandSelect.addEventListener("change", function () {
            const selectedBrand = this.value;
            typeSelect.innerHTML = '<option value="">Pilih Type</option>';

            if (selectedBrand) {
                const filteredTypes = brandData.filter(item => item.brand === selectedBrand);
                filteredTypes.forEach(item => {
                    const option = document.createElement("option");
                    option.value = item.type;
                    option.textContent = item.type;
                    typeSelect.appendChild(option);
                });
            }
        });
    });

    // Fungsi untuk menyisipkan input form ke dalam kedua form yang submit
    function submitSharedInputs(form) {
        const id_produk = document.getElementById("id_produk").value;
        const brand = document.getElementById("brand").value;
        const type = document.getElementById("type").value;

        form.querySelector('input[name="id_produk"]').value = id_produk;
        form.querySelector('input[name="brand"]').value = brand;
        form.querySelector('input[name="type"]').value = type;

        return true; // biar form tetap jalan
    }
</script>
@endsection