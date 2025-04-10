@extends('layouts.market.masteheaderrmarket')

@section('title', 'Pesanan Diproses')

@section('isimarket')
    <h2 class="text-2xl font-semibold mb-6">Pesanan Diproses</h2>

    <div class="container mx-auto p-6 flex flex-col md:flex-row gap-4">
        <!-- Sidebar -->
        <div class="md:w-1/4 bg-gray-100 p-4 rounded-lg shadow-md">
            <ul class="space-y-2">
                <li><a href="{{ route('pesanan.belumbayar') }}" class="block py-2 px-4 rounded hover:bg-gray-200">Belum
                        Bayar</a></li>
                <li><a href="{{ route('pesanan.proses') }}" class="block py-2 px-4 rounded bg-blue-500 text-white">Proses</a>
                </li>
                <li><a href="{{ route('pesanan.selesai') }}" class="block py-2 px-4 rounded hover:bg-gray-200">Selesai</a>
                </li>
                <li><a href="{{ route('pesanan.dibatalkan') }}"
                        class="block py-2 px-4 rounded hover:bg-gray-200">Dibatalkan</a></li>
            </ul>
        </div>

        <!-- Konten -->
        <div class="md:w-3/4">
            @if ($proses->count() > 0)
                <div class="bg-white p-4 rounded shadow overflow-x-auto">
                    <table class="min-w-full table-auto border border-gray-300">
                        <thead class="bg-gray-200">
                            <tr class="text-left">
                                <th class="px-4 py-2 border">ID Pesanan</th>
                                <th class="px-4 py-2 border">Tanggal Pesanan</th>
                                <th class="px-4 py-2 border">Produk</th>
                                <th class="px-4 py-2 border">Tanggal Proses</th>
                                <th class="px-4 py-2 border">Total Harga</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border">Nama PIC</th>
                                <th class="px-4 py-2 border">Hubungi Kami</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($proses as $item)
                                <tr class="text-center">
                                    <td class="px-4 py-2 border">{{ $item->pesanan->id_pesanan ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $item->pesanan->tanggalpesanan ?? '-' }}</td>
                                    <td class="px-4 py-2 border">
                                        {{ $item->pesanan->detailPesanan->first()->produk->nama_produk ?? '-' }}
                                    </td>
                                    <td class="px-4 py-2 border">{{ $item->tanggal_proses }}</td>
                                    <td class="px-4 py-2 border">Rp
                                        {{ number_format($item->pesanan->totalpesanan ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 border">{{ $item->status }}</td>
                                    <td class="px-4 py-2 border">{{ $item->user->name ?? 'Belum ditangani' }}</td>
                                    <td>
                                        <div class="px-4 py-2 border">
                                            @php
                                                $pesan = "Halo Admin, saya ingin bertanya tentang pesanan saya dengan ID: {$item->id_pesanan}.";
                                                $whatsappLink = 'https://wa.me/628159909012?text=' . urlencode($pesan);
                                            @endphp
                                            <a href="{{ $whatsappLink }}" target="_blank"
                                                class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                                Hubungi Kami
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mt-4" role="alert">
                    <p class="font-bold">Tidak ada pesanan</p>
                    <p>Tidak ada pesanan yang sedang diproses saat ini.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
