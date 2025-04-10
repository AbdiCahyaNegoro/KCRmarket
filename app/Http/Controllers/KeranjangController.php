<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class KeranjangController extends Controller
{
    public function __construct()
    {
        // Middleware untuk memastikan pengguna sudah login
        $this->middleware('auth');
    }

    // Tambah item dari halaman detail produk
    public function TambahKeranjangDariDetail(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'brand' => 'required|string',
            'type' => 'required|string',
        ]);

        try {
            $userId = Auth::id();
            $productId = $request->input('id_produk');
            $jumlah =1;
            $brand = $request->input('brand');
            $type = $request->input('type');

            $existing = DB::table('keranjang')
                ->where('id_user', $userId)
                ->where('id_produk', $productId)
                ->where('brand', $brand)
                ->where('type', $type)
                ->first();

            if ($existing) {
                DB::table('keranjang')
                    ->where('id_keranjang', $existing->id_keranjang)
                    ->update(['quantity' => $existing->quantity + $jumlah]);
            } else {
                DB::table('keranjang')->insert([
                    'id_user' => $userId,
                    'id_produk' => $productId,
                    'quantity' => 1 ,
                    'brand' => $brand,
                    'type' => $type,
                ]);
            }

            return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
        } catch (\Exception $e) {
            Log::error('Gagal tambah ke keranjang: '.$e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan produk ke keranjang.');
        }
    }

    
    // Tampilkan isi keranjang
    public function tampilKeranjang()
    {
        $keranjangItems = Keranjang::with('produk')->where('id_user', auth()->id())->get();
        return view('market.keranjang', compact('keranjangItems'));
    }

    public function hapusItemKeranjang($id_keranjang)
{
    try {
        $item = Keranjang::where('id_user', auth()->id())
                         ->where('id_keranjang', $id_keranjang)
                         ->firstOrFail();

        $item->delete();

        return redirect()->route('keranjang')->with('success', 'Item berhasil dihapus dari keranjang.');
    } catch (\Exception $e) {
        return redirect()->route('keranjang')->with('error', 'Gagal menghapus item: ' . $e->getMessage());
    }
    }


    // Pindahkan item dari keranjang ke pesanan
    public function pindahKePesanan(Request $request)
{
    $keranjang = Keranjang::where('id_user', Auth::id())->get();

    if ($keranjang->isEmpty()) {
        return redirect()->back()->with('error', 'Keranjang kosong.');
    }

    $total = 0;

    foreach ($keranjang as $item) {
        $total += $item->produk->harga * $item->quantity;
    }

    $pesanan = Pesanan::create([
        'id_user' => Auth::id(),
        'tanggalpesanan' => now(),
        'totalpesanan' => $total,
        'status' => 'Belum Bayar',
        // Ambil brand dan type dari item pertama
        'brand' => $keranjang->first()->brand,
        'type' => $keranjang->first()->type,
    ]);

    foreach ($keranjang as $item) {
        $pesanan->detailpesanan()->create([
            'id_produk' => $item->id_produk,
            'brand' => $item->brand,
            'type' => $item->type,
            'qty' => $item->quantity,
            'harga' => $item->produk->harga,
        ]);
    }

    Keranjang::where('id_user', Auth::id())->delete();

    return redirect()->route('pesanan.belumbayar')->with('success', 'Checkout berhasil.');
}

}
