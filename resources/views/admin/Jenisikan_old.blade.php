@extends('layouts.beranda.masterberanda')
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Brand Produk</h1>
        </div>

        <!-- Grid untuk Menampilkan Data dan Form -->
        <div class="row">
            <!-- Kolom untuk Menampilkan Data -->
            <div class="col-lg-6 mb-4">
                <!-- Daftar Jenis Ikan -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Daftar Brand Produk</h6>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTableJenisIkan" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Brand Produk</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brandproduk as $index => $brand)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $brand->brand }}</td>
                                            <td>
                                                <form
                                                    action="{{ route('admin.hapusjenis', ['id' => $brand->id_brandproduk]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="fa fa-trash" type="submit"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus brand produk ini?')"></button>
                                                </form>
                                            </td>
                                           
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom untuk Menambah Data -->
            <div class="col-lg-6 mb-4">
                <!-- Form Tambah Jenis Ikan -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tambah brand Produk</h6>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('admin.simpanjenis') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="jenis">Brand Produk</label>
                                <input type="text" class="form-control" id="jenis" name="jenis"
                                    placeholder="Masukkan brand produk">
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
