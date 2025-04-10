@extends('layouts.beranda.masterberanda')

@section('title', 'Job Selesai')

@section('content')
    <div class="px-6 py-4" x-data="{ search: '', bulan: '' }">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4">Job Done</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter dan Search -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
            <div>
                <label class="text-gray-700 text-sm mr-2">Filter Bulan:</label>
                <select x-model="bulan" class="border border-gray-300 rounded px-3 py-1 text-sm">
                    <option value="">Semua</option>
                    @php
                        $months = $selesai
                            ->pluck('tanggalpesanan')
                            ->map(function ($date) {
                                return \Carbon\Carbon::parse($date)->format('Y-m');
                            })
                            ->unique();
                    @endphp
                    @foreach ($months as $month)
                        <option value="{{ $month }}">{{ \Carbon\Carbon::parse($month)->isoFormat('MMMM Y') }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <input type="text" x-model="search" placeholder="Nama Costumer / ID Pesanan...."
                    class="border border-gray-300 rounded px-3 py-1 text-sm w-64" />
            </div>
        </div>

        <!-- Tabel -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 font-medium text-gray-700">No</th>
                            <th class="px-6 py-3 font-medium text-gray-700">Tanggal Pesanan</th>
                            <th class="px-6 py-3 font-medium text-gray-700">ID Pesanan</th>
                            <th class="px-6 py-3 font-medium text-gray-700">Nama Pemesan</th>
                            <th class="px-6 py-3 font-medium text-gray-700">Status</th>
                            <th class="px-6 py-3 font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($selesai as $key => $jobselesai)
                            @php
                                $tanggalFormatted = \Carbon\Carbon::parse($jobselesai->tanggalpesanan)->format('Y-m');
                                $searchText = strtolower($jobselesai->id_pesanan . ' ' . $jobselesai->user->name);
                            @endphp
                            <tr
                                x-show="('{{ $tanggalFormatted }}'.includes(bulan) || bulan === '') && ('{{ $searchText }}'.includes(search.toLowerCase()))">
                                <td class="px-6 py-4">{{ $key + 1 }}</td>
                                <td class="px-6 py-4">{{ $jobselesai->tanggalpesanan }}</td>
                                <td class="px-6 py-4">{{ $jobselesai->id_pesanan }}</td>
                                <td class="px-6 py-4">{{ $jobselesai->user->name }}</td>
                                <td class="px-6 py-4 text-green-600 font-semibold">{{ $jobselesai->status }}</td>
                                <td class="px-6 py-4">
                                    <button
                                        @click="document.getElementById('modal-{{ $jobselesai->id_pengiriman }}').showModal()"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm">
                                        Lihat Detail
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modals Detail -->
        @foreach ($selesai as $jobse)
            <dialog id="modal-{{ $jobse->id_pengiriman }}" class="rounded-lg w-full max-w-3xl p-4">
                <div class="flex justify-between items-center border-b pb-2 mb-4">
                    <h3 class="text-xl font-semibold">Detail Pesanan - {{ $jobse->id_pesanan }}</h3>
                    <form method="dialog">
                        <button class="text-gray-500 hover:text-red-500 text-xl">&times;</button>
                    </form>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-700 mb-2">Informasi Produk</h4>
                    <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 font-medium text-gray-700">Nama Produk</th>
                                <th class="px-4 py-2 font-medium text-gray-700">Jumlah</th>
                                <th class="px-4 py-2 font-medium text-gray-700">Harga</th>
                                <th class="px-4 py-2 font-medium text-gray-700">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($jobse->detailPesanan as $detail)
                                <tr>
                                    <td class="px-4 py-2">{{ $detail->produk->nama_produk ?? '-' }}</td>
                                    <td class="px-4 py-2">{{ $detail->qty }}</td>
                                    <td class="px-4 py-2">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">Rp
                                        {{ number_format($detail->qty * $detail->harga, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="mt-4 text-right">
                    <form method="dialog">
                        <button class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                            Tutup
                        </button>
                    </form>
                </div>
            </dialog>
        @endforeach
    </div>
@endsection
