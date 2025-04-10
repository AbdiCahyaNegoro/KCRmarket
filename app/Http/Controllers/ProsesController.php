<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proses;
use App\Models\User;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProsesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function takejob()
    {
        $prosesList = Proses::whereIn('status', ['Menunggu Penanganan', 'Sedang Dikerjakan'])->get();

        $detailPesanan = DetailPesanan::select('detailpesanan.*', 'produk.nama_produk', 'produk.harga')
            ->leftJoin('produk', 'detailpesanan.id_produk', '=', 'produk.id_produk')
            ->whereIn('detailpesanan.id_pesanan', $prosesList->pluck('id_pesanan')->toArray())
            ->distinct()
            ->get();

        $pembayaran = Pembayaran::all();
        $pelanggan = User::all();

        return view('admin.job', compact('prosesList', 'detailPesanan', 'pembayaran', 'pelanggan'));
    }

    public function takejobform($id_proses)
    {
        $proses = Proses::findOrFail($id_proses);
        $pesanan = Pesanan::findOrFail($proses->id_pesanan);
        $pemesan = User::findOrFail($pesanan->id_user);

        $detailPesanan = DetailPesanan::select('detailpesanan.*', 'produk.nama_produk', 'produk.harga')
            ->leftJoin('produk', 'detailpesanan.id_produk', '=', 'produk.id_produk')
            ->where('detailpesanan.id_pesanan', $proses->id_pesanan)
            ->get();

        return view('admin.formtakejob', compact('proses', 'pemesan', 'detailPesanan'));
    }

    public function storejob(Request $request, $id_proses)
    {
        $request->validate([
            'tanggal_proses' => 'required|date',
            'id_user' => 'required',
        ]);


        $proses = Proses::findOrFail($id_proses);
        $proses->tanggal_proses = $request->tanggal_proses;
        $proses->status = 'Sedang Dikerjakan';
        $proses->id_user = Auth::id();
        $proses->save();

        return redirect()->back()->with('success', 'Job Sudah Diambil.');
    }

    public function selesaikanJob($id_proses)
    {
        // Update tabel proses
        $proses = Proses::findOrFail($id_proses);
        $proses->status = 'Selesai';
        $proses->save();
    
        // Tabel Pesanan
        $proses->pesanan->status = 'Selesai';
        $proses->pesanan->save();
    
        return redirect()->back()->with('success', 'Job berhasil diselesaikan.');
    }
    

    public function jobdone()
    {
        $selesai = Pesanan::with(['detailPesanan.produk', 'user'])
            ->where('status', 'Selesai')
            ->orderByDesc('tanggalpesanan')
            ->get();

        return view('admin.Job-selesai', compact('selesai'));
    }

    

}
