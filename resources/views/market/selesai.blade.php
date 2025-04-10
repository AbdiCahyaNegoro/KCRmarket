@extends('layouts.market.masteheaderrmarket')

@section('title', 'Selesai')

@section('isimarket')
<h2 class="text-2xl font-semibold mb-6">Pesanan Selesai</h2>

<div class="container mx-auto p-6 flex flex-col md:flex-row gap-4">
    <!-- Sidebar -->
    <div class="md:w-1/4 bg-gray-100 p-4 rounded-lg shadow-md">
        <ul class="space-y-2">
            <li><a href="{{ route('pesanan.belumbayar') }}" class="block py-2 px-4 rounded hover:bg-gray-200">Belum Bayar</a></li>
            <li><a href="{{ route('pesanan.proses') }}" class="block py-2 px-4 rounded hover:bg-gray-200">Proses</a></li>
            <li><a href="{{ route('pesanan.selesai') }}" class="block py-2 px-4 rounded bg-green-500 text-white">Selesai</a></li>
            <li><a href="{{ route('pesanan.dibatalkan') }}" class="block py-2 px-4 rounded hover:bg-gray-200">Dibatalkan</a></li>
        </ul>
    </div>

     <!-- Konten -->
     <div class="md:w-3/4">
        @if ($selesai->count() > 0)
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
                            <th class="px-4 py-2 border">Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($selesai as $item)
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
                                <td>
                                    <div class="px-4 py-2 border">
                                        <div x-data="{
                                            rating: {{ $item->pesanan->rating ?? 0 }},
                                            hover: 0,
                                            saveRating(r) {
                                                this.rating = r;
                                                fetch('{{ route('rating.pesanan.simpan', $item->pesanan->id_pesanan) }}', {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                    },
                                                    body: JSON.stringify({ rating: r })
                                                }).then(() => {
                                                    // Langsung refresh setelah rating berhasil dikirim
                                                    location.reload();
                                                });
                                            }
                                        }" class="flex justify-center items-center space-x-1 text-yellow-500 text-xl cursor-pointer">
                                            <template x-for="i in 5" :key="i">
                                                <span @click="saveRating(i)" @mouseover="hover = i" @mouseleave="hover = 0">
                                                    <template x-if="i <= (hover || rating)">
                                                        <span>★</span>
                                                    </template>
                                                    <template x-if="i > (hover || rating)">
                                                        <span class="text-gray-400">☆</span>
                                                    </template>
                                                </span>
                                            </template>
                                        </div>
                                    </div>
                                </td>                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mt-4" role="alert">
                <p class="font-bold">Tidak ada pesanan selesai</p>
                <p>Belum ada pesanan yang selesai saat ini.</p>
            </div>
        @endif
    </div>
</div>
@endsection
