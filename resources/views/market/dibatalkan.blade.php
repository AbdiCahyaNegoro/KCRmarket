@extends('layouts.market.masteheaderrmarket')

@section('title', 'Pesanan Dibatalkan')

@section('isimarket')
<h2 class="text-2xl font-semibold mb-6 text-red-600">Pesanan Dibatalkan</h2>

<div class="container mx-auto p-6 flex flex-col md:flex-row gap-4">
    <!-- Sidebar -->
    <div class="md:w-1/4 bg-gray-100 p-4 rounded-lg shadow-md">
        <ul class="space-y-2">
            <li><a href="{{ route('pesanan.belumbayar') }}" class="block py-2 px-4 rounded hover:bg-gray-200">Belum Bayar</a></li>
            <li><a href="{{ route('pesanan.proses') }}" class="block py-2 px-4 rounded hover:bg-gray-200">Proses</a></li>
            <li><a href="{{ route('pesanan.selesai') }}" class="block py-2 px-4 rounded hover:bg-gray-200">Selesai</a></li>
            <li><a href="{{ route('pesanan.dibatalkan') }}" class="block py-2 px-4 rounded bg-red-500 text-white">Dibatalkan</a></li>
        </ul>
    </div>

    <!-- Konten -->
    <div class="md:w-3/4 space-y-6">
        @forelse($pesanan as $item)
            <div class="bg-red-100 border border-red-300 rounded-lg p-4 mb-6">
                <div class="text-sm text-red-700 mb-2 font-medium">ID Pesanan: {{ $item->id_pesanan }} - Status: {{ $item->status }}</div>

                <div class="space-y-2">
                    @foreach ($item->detailPesanan as $detail)
                        <div class="flex justify-between border-b pb-2">
                            <span>{{ $detail->produk->nama_produk }} (x{{ $detail->jumlah }})</span>
                            <span class="font-semibold text-red-800">
                                Rp {{ number_format($detail->produk->harga * $detail->jumlah, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                <p class="font-bold">Tidak ada pesanan</p>
                <p>Tidak ada pesanan yang dibatalkan saat ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
