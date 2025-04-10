@extends('layouts.beranda.masterberanda')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Semua Pesanan</h1>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex justify-end mb-4">
        <input type="text" id="searchInput" placeholder="Cari pesanan..." class="border border-gray-300 rounded-md px-4 py-2 w-full sm:w-1/3 shadow-sm">
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full text-sm text-left text-gray-700" id="pesananTable">
            <thead class="text-xs uppercase bg-gray-100 text-gray-700">
                <tr>
                    <th class="py-3 px-6 cursor-pointer" onclick="sortTable(0, 'number')">
                        <div class="flex items-center">
                            No
                            <span id="sortIcon0" class="ml-1"></span>
                        </div>
                    </th>
                    <th class="py-3 px-6 cursor-pointer" onclick="sortTable(1, 'date')">
                        <div class="flex items-center">
                            Tanggal
                            <span id="sortIcon1" class="ml-1"></span>
                        </div>
                    </th>
                    <th class="py-3 px-6 cursor-pointer" onclick="sortTable(2, 'text')">
                        <div class="flex items-center">
                            Pelanggan
                            <span id="sortIcon2" class="ml-1"></span>
                        </div>
                    </th>
                    <th class="py-3 px-6">Detail</th>
                    <th class="py-3 px-6">Bukti Bayar</th>
                    <th class="py-3 px-6 cursor-pointer" onclick="sortTable(5, 'text')">
                        <div class="flex items-center">
                            Status
                            <span id="sortIcon5" class="ml-1"></span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pembayaranMenungguKonfirmasi as $key => $pembayaran)
                <tr class="border-t hover:bg-gray-50">
                    <td class="py-3 px-6">{{ $key + 1 }}</td>
                    <td class="py-3 px-6">{{ $pembayaran->tanggal_pembayaran }}</td>
                    <td class="py-3 px-6">{{ $pembayaran->user->name ?? '-' }}</td>
                    <td class="py-3 px-6">
                        <button class="text-blue-600 hover:underline" data-toggle="modal" data-target="#modalDetail{{ $pembayaran->id_pesanan }}">Lihat</button>
                    </td>
                    <td class="py-3 px-6">
                        <button class="text-blue-600 hover:underline" data-toggle="modal" data-target="#modalBukti{{ $pembayaran->id_pembayaran }}">Lihat</button>
                    </td>
                    <td class="py-3 px-6 font-medium">{{ $pembayaran->status }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-6 text-gray-500">Tidak ada data pesanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MODAL DETAIL & BUKTI BAYAR --}}
    @foreach ($pembayaranMenungguKonfirmasi as $pembayaran)
        {{-- Modal Detail Pesanan --}}
        <div class="modal fade" id="modalDetail{{ $pembayaran->id_pesanan }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gray-100">
                        <h5 class="modal-title font-bold">Detail Pesanan #{{ $pembayaran->id_pesanan }}</h5>
                        <button type="button" class="close text-xl" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <table class="w-full text-sm text-gray-800">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="py-2 px-4 text-left">Produk</th>
                                    <th class="py-2 px-4 text-left">Harga</th>
                                    <th class="py-2 px-4 text-left">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pembayaran->pesanan->detailpesanan as $detail)
                                    <tr class="border-t">
                                        <td class="py-2 px-4">{{ $detail->produk->nama_produk ?? '-' }}</td>
                                        <td class="py-2 px-4">Rp {{ number_format($detail->produk->harga ?? 0, 0, ',', '.') }}</td>
                                        <td class="py-2 px-4">{{ $detail->qty }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer bg-gray-50">
                        <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Bukti Bayar --}}
        <div class="modal fade" id="modalBukti{{ $pembayaran->id_pembayaran }}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gray-100">
                        <h5 class="modal-title font-bold">Bukti Pembayaran #{{ $pembayaran->id_pembayaran }}</h5>
                        <button type="button" class="close text-xl" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="{{ asset($pembayaran->folder . '/' . $pembayaran->buktibayar) }}" alt="Bukti Bayar" class="max-w-full rounded shadow-md">
                    </div>
                    <div class="modal-footer bg-gray-50">
                        <button class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @if(method_exists($pembayaranMenungguKonfirmasi, 'links'))
        <div class="mt-6">
            {{ $pembayaranMenungguKonfirmasi->links() }}
        </div>
    @endif
</div>

{{-- Search & Sort --}}
<script>
    document.getElementById("searchInput").addEventListener("keyup", function () {
        let filter = this.value.toLowerCase();
        document.querySelectorAll("#pesananTable tbody tr").forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(filter) ? "" : "none";
        });
    });

    let currentSort = {
        column: null,
        direction: 'asc'
    };

    function sortTable(columnIndex, dataType) {
        const table = document.getElementById("pesananTable");
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.rows);
        const sortIcon = document.getElementById(`sortIcon${columnIndex}`);
        
        // Reset all sort icons
        document.querySelectorAll('[id^="sortIcon"]').forEach(icon => {
            icon.innerHTML = '';
        });

        // Set new sort direction
        if (currentSort.column === columnIndex) {
            currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
        } else {
            currentSort.column = columnIndex;
            currentSort.direction = 'asc';
        }

        // Update sort icon
        sortIcon.innerHTML = currentSort.direction === 'asc' ? '↑' : '↓';

        rows.sort((a, b) => {
            const aValue = a.cells[columnIndex].textContent.trim();
            const bValue = b.cells[columnIndex].textContent.trim();

            if (dataType === 'number') {
                return currentSort.direction === 'asc' 
                    ? Number(aValue) - Number(bValue)
                    : Number(bValue) - Number(aValue);
            } else if (dataType === 'date') {
                return currentSort.direction === 'asc'
                    ? new Date(aValue) - new Date(bValue)
                    : new Date(bValue) - new Date(aValue);
            } else {
                return currentSort.direction === 'asc'
                    ? aValue.localeCompare(bValue)
                    : bValue.localeCompare(aValue);
            }
        });

        // Rebuild table
        rows.forEach(row => tbody.appendChild(row));
    }
</script>
@endsection