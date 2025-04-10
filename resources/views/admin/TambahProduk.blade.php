@extends('layouts.beranda.masterberanda')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Produk</h1>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.simpanproduk') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Nama Produk -->
            <div class="space-y-2">
                <label for="nama_produk" class="block text-sm font-medium text-gray-700">Nama Produk:</label>
                <input type="text" id="nama_produk" name="nama_produk" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Harga Satuan -->
            <div class="space-y-2">
                <label for="harga" class="block text-sm font-medium text-gray-700">Harga:</label>
                <input type="number" id="harga" name="harga" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <!-- Brand Produk -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Brand Produk:</label>
                <div class="flex items-center mb-2">
                    <input type="checkbox" id="selectAllBrands" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="selectAllBrands" class="ml-2 text-sm text-gray-700">Pilih Semua</label>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2" id="brandsContainer">
                    @foreach ($brandproduk as $brand)
                        <div class="flex items-center">
                            <input type="checkbox" name="id_brandproduk[]" value="{{ (int)$brand->id_brandproduk }}" 
                                class="brand-checkbox h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label class="ml-2 text-sm text-gray-700">{{ $brand->brand }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Deskripsi Produk -->
            <div class="space-y-2">
                <label for="deskripsiproduk" class="block text-sm font-medium text-gray-700">Deskripsi Produk:</label>
                <textarea id="deskripsiproduk" name="deskripsiproduk" rows="4" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <!-- Foto Produk -->
            <div class="space-y-2">
                <label for="nama_foto" class="block text-sm font-medium text-gray-700">Foto Produk:</label>
                <input type="file" id="nama_foto" name="nama_foto" required
                    class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-50 file:text-indigo-700
                        hover:file:bg-indigo-100">
            </div>

            <!-- Tombol Submit -->
            <div class="pt-4">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Tambah Produk
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAllBrands');
        const brandCheckboxes = document.querySelectorAll('.brand-checkbox');
        
        // Select all brands
        selectAll.addEventListener('change', function() {
            brandCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        });
        
        // Uncheck "select all" if any brand is unchecked
        brandCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (!this.checked) {
                    selectAll.checked = false;
                } else {
                    // Check if all brands are selected
                    const allChecked = Array.from(brandCheckboxes).every(cb => cb.checked);
                    selectAll.checked = allChecked;
                }
            });
        });
    });
</script>
@endsection
