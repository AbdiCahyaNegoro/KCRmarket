@extends('layouts.market.masteheaderrmarket')

@section('title', 'Pesanan Belum Bayar')

@section('isimarket')
    <h2 class="text-2xl font-semibold mb-6">Pesanan Belum Dibayar</h2>

    <div class="container mx-auto p-6 flex flex-col md:flex-row gap-4">
        <!-- Sidebar -->
        <div class="md:w-1/4 bg-gray-100 p-4 rounded-lg shadow-md">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('pesanan.belumbayar') }}" class="block py-2 px-4 rounded bg-blue-500 text-white">Belum
                        Bayar</a>
                </li>
                <li>
                    <a href="{{ route('pesanan.proses') }}" class="block py-2 px-4 rounded hover:bg-gray-200">Proses</a>
                </li>
                <li>
                    <a href="{{ route('pesanan.selesai') }}" class="block py-2 px-4 rounded hover:bg-gray-200">Selesai</a>
                </li>
                <li>
                    <a href="{{ route('pesanan.dibatalkan') }}"
                        class="block py-2 px-4 rounded hover:bg-gray-200">Dibatalkan</a>
                </li>
            </ul>
        </div>

        <!-- Konten Pesanan -->
        <div class="md:w-3/4 space-y-6">
            @forelse($pesanan as $item)
                <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <p class="text-gray-500 text-sm">ID Pesanan:</p>
                            <p class="text-lg font-bold text-gray-800">{{ $item->id_pesanan }}</p>
                        </div>
                        <div
                            class="text-sm text-white px-3 py-1 rounded {{ $item->status == 'Belum Bayar' ? 'bg-red-500' : 'bg-yellow-500' }}">
                            {{ $item->status }}
                        </div>
                    </div>

                    <!-- Table Produk -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-600">
                            <thead class="bg-gray-100 text-xs uppercase text-gray-700">
                                <tr>
                                    <th scope="col" class="px-4 py-2">Produk</th>
                                    <th scope="col" class="px-4 py-2">Qty</th>
                                    <th scope="col" class="px-4 py-2">Brand</th>
                                    <th scope="col" class="px-4 py-2">Type</th>
                                    <th scope="col" class="px-4 py-2 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailPesanan->where('id_pesanan', $item->id_pesanan) as $detail)
                                    <tr class="border-b">
                                        <td class="px-4 py-2">{{ $detail->nama_produk }}</td>
                                        <td class="px-4 py-2">{{ $detail->qty }}</td>
                                        <td class="px-4 py-2">{{ $detail->brand }}</td>
                                        <td class="px-4 py-2">{{ $detail->type }}</td>
                                        <td class="px-4 py-2 text-right">
                                            Rp {{ number_format($detail->harga * $detail->qty, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Total Pesanan -->
                    <div class="text-right mt-4 text-lg font-semibold text-gray-800">
                        Total: Rp {{ number_format($item->totalpesanan, 0, ',', '.') }}
                    </div>

                    <!-- Informasi Pembayaran dengan Tombol Copy -->
                    <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h3 class="text-base font-semibold text-blue-800 mb-2">Informasi Pembayaran</h3>
                        <div class="space-y-1 text-sm text-gray-700">
                            <p><span class="font-medium">Nama:</span> Abdi Cahya Negoro</p>
                            <p><span class="font-medium">Bank:</span> Dana</p>
                            <div class="flex items-center gap-2">
                                <p class="font-medium">No. Rekening:</p>
                                <p id="norek" class="text-gray-800">08980950919</p>
                                <button type="button"
                                    onclick="navigator.clipboard.writeText(document.getElementById('norek').innerText)"
                                    class="text-xs px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                    Copy
                                </button>
                            </div>
                        </div>
                    </div>


                    <!-- Form Upload Bukti Pembayaran -->
                    <form action="{{ route('pesanan.bayar', $item->id_pesanan) }}" method="POST"
                        enctype="multipart/form-data" class="mt-4">
                        @csrf
                        <label class="block text-sm mb-1 font-medium text-gray-700">Upload Bukti Pembayaran:</label>
                        <input type="file" name="buktibayar"
                            {{ $item->status == 'Menunggu Konfirmasi' ? 'disabled' : '' }} required
                            class="w-full border border-gray-300 px-3 py-2 rounded mb-2 focus:ring focus:ring-blue-200">
                        <button type="submit"
                            class="px-4 py-2 rounded transition 
            {{ $item->status == 'Menunggu Konfirmasi' ? 'bg-gray-400 cursor-not-allowed text-white' : 'bg-green-600 hover:bg-green-700 text-white' }}"
                            {{ $item->status == 'Menunggu Konfirmasi' ? 'disabled' : '' }}>
                            Upload
                        </button>
                    </form>

                    <!-- Form Batalkan Pesanan -->
                    <form action="{{ route('pesanan.batal', $item->id_pesanan) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 rounded transition 
            {{ $item->status == 'Menunggu Konfirmasi' ? 'bg-gray-400 cursor-not-allowed text-white' : 'bg-red-600 hover:bg-red-700 text-white' }}"
                            {{ $item->status == 'Menunggu Konfirmasi' ? 'disabled' : '' }}>
                            Batalkan Pesanan
                        </button>
                    </form>

                </div>
            @empty
                <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded" role="alert">
                    <p class="font-bold">Tidak ada pesanan</p>
                    <p>Kamu belum memiliki pesanan yang belum dibayar.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
