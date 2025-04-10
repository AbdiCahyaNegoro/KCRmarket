@extends('layouts.beranda.masterberanda')

@section('title', 'Take Job')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Take Job</h1>

        @if (session('success'))
            <div class="mb-4 p-4 rounded bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="bg-blue-100 px-4 py-3 border-b flex justify-between items-center">
                <h2 class="text-blue-800 font-semibold">Daftar Job Yang Tersedia</h2>
                <a href="#"
                    class="bg-red-900 hover:bg-pink-600 text-white px-4 py-2 rounded text-sm">
                    Job Saya
                </a>
            </div>

            <div class="p-4 overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-2">No</th>
                            <th class="px-4 py-2">Tanggal Pesanan</th>
                            <th class="px-4 py-2">ID Pesanan</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prosesList as $key => $proses)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $key + 1 }}</td>
                                <td class="px-4 py-2">{{ optional($proses->pesanan)->tanggalpesanan ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $proses->id_pesanan }}</td>
                                <td class="px-4 py-2">{{ $proses->status }}</td>
                                <td class="px-4 py-2 space-x-2">
                                    <!-- Detail Pesanan -->
                                    <button type="button"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded"
                                        data-toggle="modal" data-target="#detailPesanan{{ $proses->id_proses }}">
                                        Detail
                                    </button>

                                    <!-- Tombol Ambil -->
                                    <a href="{{ route('admin.takejobform', $proses->id_proses) }}"
                                        class="px-3 py-1 rounded 
                                       {{ $proses->status === 'Sedang Dikerjakan' ? 'bg-gray-300 cursor-not-allowed text-gray-600' : 'bg-green-500 hover:bg-green-600 text-white' }}
                                       {{ $proses->status === 'Sedang Dikerjakan' ? 'pointer-events-none' : '' }}">
                                        Ambil
                                    </a>

                                    <!-- Tombol Selesai -->
                                    @if ($proses->status === 'Sedang Dikerjakan')
                                        <form action="{{ route('admin.selesaikanJob', $proses->id_proses) }}"
                                            method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                                Selesai
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Detail --}}
    @foreach ($prosesList as $proses)
        <div class="modal fade" id="detailPesanan{{ $proses->id_proses }}" tabindex="-1" role="dialog"
            aria-labelledby="modalLabel{{ $proses->id_proses }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel{{ $proses->id_proses }}">Detail Pesanan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailPesanan->where('id_pesanan', $proses->id_pesanan) as $detail)
                                    <tr>
                                        <td>{{ $detail->nama_produk }}</td>
                                        <td>{{ $detail->qty }}</td>
                                        <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
