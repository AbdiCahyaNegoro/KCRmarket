@extends('layouts.beranda.masterberanda')

@section('title', 'Kirim Pengiriman')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Take Job</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Silahkan Kerjakan Job Ini</h6>
                <button type="button" class="btn btn-success mt-3" onclick="printSection('print-section')">Cetak</button>
            </div>
            <div class="card-body">

                <!-- Notifikasi Tailwind -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">Berhasil!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">Gagal!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">Ada kesalahan!</strong>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Informasi Pemesan -->
                <div class="mb-4" id="print-section">
                    <img src="{{ asset('assets/img/logobrand.png') }}" alt="logobrand" style="max-width: 100px;">
                    <h5 class="font-weight-bold">Informasi Pemesan | Id Pesanan : {{ $proses->id_pesanan }}</h5>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td style="width: 30%;"><strong>Nama Pemesan:</strong></td>
                                <td>{{ $pemesan->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $pemesan->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Alamat:</strong></td>
                                <td>{{ $pemesan->alamat }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Kelamin:</strong></td>
                                <td>{{ $pemesan->jeniskelamin }}</td>
                            </tr>
                            <tr>
                                <td><strong>No Hp:</strong></td>
                                <td>{{ $pemesan->no_hp }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h5 class="font-weight-bold">Detail Pesanan</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Jumlah</th>
                                <th>Brand</th>
                                <th>Type</th>
                                <th>Harga</th>
                                <th>Total Pesanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detailPesanan as $detail)
                                <tr>
                                    <td>{{ $detail->nama_produk }}</td>
                                    <td>{{ $detail->qty }}</td>
                                    <td>{{ $detail->brand }}</td>
                                    <td>{{ $detail->type }}</td>
                                    <td>{{ $detail->harga }}</td>
                                    <td>{{ $detail->qty * $detail->harga }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <hr>

                <!-- Form Pengambilan Job -->
                <form action="{{ route('admin.kirimpesanan', $proses->id_proses) }}" method="POST" enctype="multipart/form-data" id="kirim-form">
                    @csrf
                
                    <input type="hidden" name="id_user" value="{{ $pemesan->id }}">
                
                    <div class="form-group">
                        <label for="tanggal_proses">Tanggal Pengambilan Job</label>
                        <input type="date" class="form-control" id="tanggal_proses" name="tanggal_proses"
                            value="{{ old('tanggal_proses') }}" required>
                    </div>
                
                    <button type="submit" class="btn btn-primary mt-3" id="kirim-button" disabled>Ambil Job</button>
                </form>
                
            </div>
        </div>
    </div>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #print-section,
            #print-section * {
                visibility: visible;
            }

            #print-section {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }
        }
    </style>

    <script>
        function printSection(sectionId) {
            var printContents = document.getElementById(sectionId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;

            // Aktifkan tombol kirim setelah mencetak
            document.getElementById('kirim-button').disabled = false;
        }

        document.getElementById('kirim-button').addEventListener('click', function(event) {
            if (this.disabled) {
                event.preventDefault();
                alert('Silakan cetak informasi terlebih dahulu sebelum mengambil job.');
            }
        });
    </script>
@endsection
