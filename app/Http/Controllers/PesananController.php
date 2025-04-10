<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Pembayaran;
use App\Models\Proses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function pesanlangsung(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'brand' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'qty' => 'required|integer|min:1',
        ]);
    
        $produk = Produk::find($request->id_produk);
        $total = $produk->harga * $request->qty;
    
        $pesanan = Pesanan::create([
            'id_user' => Auth::id(),
            'tanggalpesanan' => now(),
            'totalpesanan' => $total,
            'status' => 'Belum Bayar',
            'brand' => $request->brand,
            'type' => $request->type,
        ]);
    
        $pesanan->detailpesanan()->create([
            'id_produk' => $produk->id_produk,
            'brand' => $request->brand,
            'type' => $request->type,
            'qty' => $request->qty,
            'harga' => $produk->harga,
        ]);
    
        return redirect()->route('pesanan.belumbayar')->with('success', 'Pesanan berhasil dibuat.');
    }


    public function belumBayar()
    {
    $userId = Auth::id();

    $pesanan = Pesanan::with('pembayaran')
        ->where('id_user', $userId)
        ->whereIn('status', ['Belum Bayar', 'Menunggu Konfirmasi'])
        ->orderByDesc('tanggalpesanan')
        ->get();

    $detailPesanan = DB::table('detailpesanan')
        ->leftJoin('produk', 'detailpesanan.id_produk', '=', 'produk.id_produk')
        ->select('detailpesanan.*', 'produk.nama_produk', 'produk.harga', 'produk.folder', 'produk.nama_foto')
        ->whereIn('detailpesanan.id_pesanan', $pesanan->pluck('id_pesanan'))
        ->get();

    return view('market.belumbayar', compact('pesanan', 'detailPesanan'));
    }

    public function proses()
    {
    $proses = Proses::with(['pesanan.produk', 'user'])
        ->whereRelation('pesanan', 'id_user', Auth::id())
        ->whereIn('status', ['Menunggu Penanganan', 'Sedang Dikerjakan'])
        ->orderByDesc('tanggal_proses')
        ->get();

    return view('market.proses', compact('proses'));
    }
          

    public function selesai()
    {
        $selesai = Proses::with(['pesanan.produk'])
        ->whereRelation('pesanan', 'id_user', Auth::id())
        ->whereIn('status', ['selesai'])
        ->orderByDesc('tanggal_proses')
        ->get();

        $selesai = Proses::with(['pesanan.detailPesanan.produk'])->get();

    return view('market.selesai', compact('selesai'));
    }

public function dibatalkan()
{
    $userId = Auth::id();

    $pesanan = Pesanan::with('pembayaran')
        ->where('id_user', $userId)
        ->where('status', 'Dibatalkan')
        ->get();

    return view('market.dibatalkan', compact('pesanan'));
}

public function bayar(Request $request, $id)
{
    $pesanan = Pesanan::findOrFail($id);

    $request->validate([
        'buktibayar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $file = $request->file('buktibayar');
    $fileName = time().'_'.$file->getClientOriginalName();
    $path = 'assets/img/pembayaran/';
    $file->move(public_path($path), $fileName);

    Pembayaran::create([
        'id_pesanan' => $id,
        'id_user' => Auth::id(),
        'status' => 'Menunggu Konfirmasi',
        'tanggal_pembayaran' => now(),
        'buktibayar' => $fileName,
        'folder' => $path,
    ]);

    $pesanan->update(['status' => 'Menunggu Konfirmasi']);

    return redirect()->route('pesanan.belumbayar')->with('success', 'Pembayaran berhasil dikirim!');
}

public function batal($id)
{
    Pesanan::where('id_pesanan', $id)->update(['status' => 'Dibatalkan']);
    return redirect()->route('pesanan.belumbayar')->with('success', 'Pesanan dibatalkan.');
}


public function semuapesanan()
{
    $pembayaranMenungguKonfirmasi = Pembayaran::with(['user', 'pesanan.detailpesanan.produk'])
    ->get();

    $detailPesanan = DB::table('detailpesanan')
        ->leftJoin('produk', 'detailpesanan.id_produk', '=', 'produk.id_produk')
        ->select('detailpesanan.*', 'produk.nama_produk', 'produk.harga')
        ->get();

    return view('admin.Pesanan', compact('pembayaranMenungguKonfirmasi', 'detailPesanan'));
}

    public function adminTampilPesanan()
    {
        $pembayaranMenungguKonfirmasi = Pembayaran::with(['user', 'pesanan.detailpesanan.produk'])
        ->where('status', 'Menunggu Konfirmasi')
        ->get();

        $detailPesanan = DB::table('detailpesanan')
            ->leftJoin('produk', 'detailpesanan.id_produk', '=', 'produk.id_produk')
            ->select('detailpesanan.*', 'produk.nama_produk', 'produk.harga')
            ->get();

        return view('admin.PesananKonfirmasi', compact('pembayaranMenungguKonfirmasi', 'detailPesanan'));
    }

    public function adminTampilPesananDitolak()
    {
        $pembayaranMenungguKonfirmasi = Pembayaran::with('user', 'pesanan')
            ->where('status', 'Pembayaran Ditolak')
            ->get();

        return view('admin.PesananDitolak', compact('pembayaranMenungguKonfirmasi'));
    }

    public function adminKonfirmasiPembayaran($id)
    {
    $pembayaran = Pembayaran::findOrFail($id);

    $pembayaran->update([
        'status' => 'Pembayaran Sukses'
    ]);

    $pesanan = Pesanan::findOrFail($pembayaran->id_pesanan);

    $pesanan->update([
        'status' => 'Proses Pengerjaan'
    ]);

    Proses::create([
        'id_pesanan' => $pembayaran->id_pesanan,
        'tanggal_proses' => now(),
        'status' => 'Menunggu Penanganan',
        'id_user' => null
    ]);

    return redirect()->back()->with('success', 'Pembayaran diterima.');
    }

    public function adminRejectPembayaran($id)
    {
    Pembayaran::where('id_pembayaran', $id)->update([
        'status' => 'Pembayaran Ditolak'
    ]);

    return redirect()->back()->with('success', 'Pembayaran ditolak.');
    }
}
