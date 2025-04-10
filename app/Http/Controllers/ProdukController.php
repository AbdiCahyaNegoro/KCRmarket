<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Brandproduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function tampildataproduk()
    {
        // Ambil semua data produk dari database
        $produk = produk::all();

        // Kirim data ke view
        return view('index', compact('produk'));
    }


    public function detailproduk($idproduk)
    {
        $produk = Produk::where('id_produk', $idproduk)->first();
        $brandproduk = Brandproduk::all();

        return view('market.detailproduk', compact('produk', 'brandproduk'));
    }

    public function admintampildataproduk()
    {
        // Ambil semua data produk dari database dengan left join ke tabel brandproduk
        $produk = Produk::leftJoin('brandproduk', 'produk.id_brandproduk', '=', 'brandproduk.id_brandproduk')
            ->select('produk.*', 'brandproduk.brand')
            ->get();

        // Ambil semua data brand
        $brandproduk = BrandProduk::all();

        // Kirim data ke view
        return view('admin.Produk', compact('produk', 'brandproduk'));
    }


    public function formtambahproduk()
    {
        $brandproduk = BrandProduk::all();
        return view('admin.TambahProduk', compact('brandproduk'));
    }

    public function admintambahproduk(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'harga' => 'required|numeric',
            'id_brandproduk' => 'required|array|min:1',
            'id_brandproduk.*' => 'integer|exists:brandproduk,id_brandproduk',
            'deskripsiproduk' => 'required|string',
            'nama_foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Mendapatkan file yang diupload
        $file = $request->file('nama_foto');

        // Simpan file foto dengan nama sesuai nama produk
        $fotoName = $request->nama_produk . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('assets/img/produk');

        // Pindahkan file ke direktori tujuan
        $file->move($destinationPath, $fotoName);

        // Create single product with primary brand
        $produk = Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'id_brandproduk' => $request->id_brandproduk[0], // Use first selected brand
            'deskripsiproduk' => $request->deskripsiproduk,
            'nama_foto' => $fotoName,
            'folder' => 'assets/img/produk',
            'brand_tambahan' => count($request->id_brandproduk) > 1 
                ? json_encode(array_slice($request->id_brandproduk, 1))
                : null
        ]);

        // Redirect dan berikan pesan sukses
        return redirect()->route('admin.simpanproduk')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function adminubahProduk(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'brandproduk_id' => 'required|exists:brandproduk,id_brandproduk',
            'deskripsiproduk' => 'required|string',
            'nama_foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Contoh validasi untuk file foto
        ]);

        // Cari produk berdasarkan ID
        $produk = Produk::find($id);

        // Update data produk
        $produk->nama_produk = $request->nama_produk;
        $produk->harga = $request->harga;
        $produk->brandproduk_id = $request->brandproduk_id;
        $produk->deskripsiproduk = $request->deskripsiproduk;

        // Cek apakah ada file foto baru yang diunggah
        if ($request->hasFile('nama_foto')) {
            // Proses file foto baru
            $file = $request->file('nama_foto');
            $fileName = $file->getClientOriginalName();
            $destinationPath = public_path('assets/img/produk');
            $file->move($destinationPath, $fileName);

            // Update nama file foto dalam database
            $produk->nama_foto = $fileName;
        }

        // Simpan perubahan
        $produk->save();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.tambahproduk')->with('success', 'Produk berhasil diubah.');
    }


    public function adminsimpanubahProduk(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'nama_foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi file foto
        ]);

        // Mulai transaksi database
        DB::beginTransaction();

            // Ambil data produk berdasarkan ID
            $produk = DB::table('produk')->where('id_produk', $id)->first();

            // Update data produk
            DB::table('produk')->where('id_produk', $id)->update([
                'nama_produk' => $request->nama_produk,
                'harga' => $request->harga,
                'deskripsiproduk' => $request->deskripsiproduk,
            ]);

            // Cek apakah ada file foto baru yang diunggah
            if ($request->hasFile('nama_foto')) {
                // Proses file foto baru
                $file = $request->file('nama_foto');
                $fileName = $file->getClientOriginalName();
                $destinationPath = public_path('assets/img/produk');
                $file->move($destinationPath, $fileName);

                // Hapus foto lama jika ada
                $oldPhotoPath = $produk->folder . '/' . $produk->nama_foto;
                if (file_exists($oldPhotoPath)) {
                    unlink($oldPhotoPath);
                }

                // Update nama file foto dalam database
                DB::table('produk')->where('id_produk', $id)->update([
                    'nama_foto' => $fileName,
                ]);
            }

            // Commit transaksi jika berhasil
            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()->route('tampilproduk')->with('success', 'Produk berhasil diupdate.');
    }

    public function formjenisproduk(Request $request)
    {
        $brandproduk = brandproduk::all();
        return view('admin.Tambahbrand', compact('brandproduk'));
    }

    public function admintambahjenis(Request $request)
    {
        // Validasi input
        $request->validate([
            'brand' => 'required|string|max:100',
        ]);

        // Simpan data brand ikan baru
        DB::table('brandproduk')->insert([
            'brand' => $request->brand,
            'type' => $request->type,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('admin.simpanjenis')->with('success', 'brand produk berhasil ditambahkan.');
    }

    public function hapusJenisProduk($id)
    {
        // Hapus jenis produk berdasarkan ID
        DB::table('brandproduk')->where('id_brandproduk', $id)->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('admin.tambahjenis')->with('success', 'brand produk berhasil dihapus.');
    }
}
