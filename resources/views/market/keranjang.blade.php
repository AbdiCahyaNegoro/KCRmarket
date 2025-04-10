@extends('layouts.market.masteheaderrmarket')

@section('title', 'Keranjang Belanja')

@section('isimarket')
<div class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">Keranjang Belanja Kamu</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if($keranjangItems->isEmpty())
        <p class="text-gray-600">Keranjang kamu masih kosong.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left">Produk</th>
                        <th class="px-6 py-3 text-left">Brand</th>
                        <th class="px-6 py-3 text-left">Type</th>
                        <th class="px-6 py-3 text-left">Jumlah</th>
                        <th class="px-6 py-3 text-left">Harga</th>
                        <th class="px-6 py-3 text-left">Total</th>
                        <th class="px-6 py-3 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($keranjangItems as $item)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $item->produk->nama_produk }}</td>
                            <td class="px-6 py-4">{{ $item->brand }}</td>
                            <td class="px-6 py-4">{{ $item->type }}</td>
                            <td class="px-6 py-4">{{ $item->quantity }}</td>
                            <td class="px-6 py-4">Rp{{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">Rp{{ number_format($item->produk->harga * $item->quantity, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                <form action="{{ route('keranjang.hapus', $item->id_keranjang) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <form action="{{ route('keranjang.checkout') }}" method="POST" class="mt-6 text-right">
            @csrf
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded text-sm font-medium">
                Lanjutkan Pesanan
            </button>
        </form>
    @endif
</div>
@endsection
