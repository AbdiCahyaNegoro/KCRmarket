@extends('layouts.beranda.masterberanda')

@section('content')
    <div class="container-fluid">
        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Pakan Ikan</h6>
                </div>
                <!-- Card Body -->

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Pakan Ikan</div>

                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <h4>Informasi Pakan Ikan</h4>
                                <p>Waktu Pakan: {{ $waktuPakan }} detik</p>
                                <p>Waktu Pemberian Pakan Terakhir:
                                    {{ $last_feed_time ?? 'Belum ada data pemberian pakan.' }}</p>

                                <hr>

                                <h4>Update Waktu Pakan</h4>
                                <form method="POST" action="{{ route('update.waktu.pakan') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="waktu_pakan">Waktu Pakan (detik)</label>
                                        <input type="number" class="form-control" id="waktu_pakan" name="waktu_pakan"
                                            value="{{('waktu_pakan') }}" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
