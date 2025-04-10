<?php

use App\Http\Middleware\CekLeveladmin;
use App\Http\Middleware\CekLevelPelanggan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProsesController;
use App\Http\Controllers\PengirimanController;


//AKSES UMUM
Route::get('/index', [App\Http\Controllers\Controller::class, 'tampildataproduk'])->name('tampildataproduk');
Route::get('/', [App\Http\Controllers\ProdukController::class, 'tampildataproduk'])->name('tampildataproduk');


//AKSES PENGGUNA
Auth::routes();

Route::middleware(CekLeveladmin::class)->group(function () {
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'Profile'])->name('Profile');
    Route::put('/profile/update', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('profile.update');
    Route::get('/admin', [App\Http\Controllers\Controller::class, 'index'])->name('admin');
    Route::get('/beranda', [App\Http\Controllers\HomeController::class, 'BerandaAdmin'])->name('beranda');
    Route::get('/pelanggan', [App\Http\Controllers\PelangganController::class, 'pelanggan'])->name('tampilpelanggan');

    //PRODUK ALL
    Route::get('/produk', [App\Http\Controllers\ProdukController::class, 'admintampildataproduk'])->name('tampilproduk');
    Route::put('/produk/{id}/ubah', [App\Http\Controllers\ProdukController::class, 'adminsimpanubahProduk'])->name('admin.ubahproduk');
    Route::post('/produk/{id}/ubah', [App\Http\Controllers\ProdukController::class, 'adminsimpanubahProduk'])->name('admin.simpanubahproduk');
    //SUB MENU TAMBAH PRODUK
    Route::get('/produk/tambahproduk', [App\Http\Controllers\ProdukController::class, 'formtambahproduk'])->name('admin.tambahproduk');
    Route::post('/produk/tambahproduk', [App\Http\Controllers\ProdukController::class, 'admintambahproduk'])->name('admin.simpanproduk');
    //SUB MENU TAMBAH JENIS PRODUK
    Route::get('/produk/tambahbrand', [App\Http\Controllers\ProdukController::class, 'formjenisproduk'])->name('admin.tambahjenis');
    Route::post('/produk/tambahbrand', [App\Http\Controllers\ProdukController::class, 'admintambahjenis'])->name('admin.simpanjenis');
    Route::delete('/produk/{id}/hapus', [App\Http\Controllers\ProdukController::class, 'hapusJenisProduk'])->name('admin.hapusjenis');

    //PESANAN ALL
    Route::get('/adminpesanan', [App\Http\Controllers\PesananController::class, 'admintampilpesanan'])->name('tampilpesanan');
    Route::get('/adminsemuapesanan', [App\Http\Controllers\PesananController::class, 'semuapesanan'])->name('semuapesanan');
    Route::get('/adminpesananditolak', [App\Http\Controllers\PesananController::class, 'admintampilpesananditolak'])->name('pesananditolak');
    Route::post('/adminpesanan/{id}/konfirmasi', [App\Http\Controllers\PesananController::class, 'adminKonfirmasiPembayaran'])->name('konfirmasi.pembayaran');
    Route::post('/adminpesanan/{id}/reject', [App\Http\Controllers\PesananController::class, 'adminrejectPembayaran'])->name('reject.pembayaran');

    Route::get('/takejob', [App\Http\Controllers\ProsesController::class, 'takejob'])->name('admin.takejob');
    Route::get('/jobkirim/{id}', [App\Http\Controllers\ProsesController::class, 'takejobform'])->name('admin.takejobform');
    Route::post('/kirim/{id}', [App\Http\Controllers\ProsesController::class, 'storejob'])->name('admin.kirimpesanan');
    Route::patch('/selesaikan-job/{id_proses}', [App\Http\Controllers\ProsesController::class, 'selesaikanJob'])->name('admin.selesaikanJob');
    Route::get('/jobdone', [App\Http\Controllers\ProsesController::class, 'jobdone'])->name('admin.jobdone');

});

Route::middleware(CekLevelPelanggan::class)->group(function () {
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'Profile'])->name('Profile');
    Route::put('/profile/update', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('profile.update');
    Route::get('/index', [App\Http\Controllers\Controller::class, 'index'])->name('index');
    Route::post('/rating/pesanan/{id}', [App\Http\Controllers\RatingController::class, 'simpan'])->name('rating.pesanan.simpan');


    //KERANJANG
    Route::get('/produk/{id_produk}', [App\Http\Controllers\ProdukController::class, 'detailproduk'])->name('detailproduk');
    Route::post('/keranjang/tambah', [KeranjangController::class, 'TambahKeranjangDariDetail'])->name('keranjang.tambah');
    Route::get('/keranjang', [KeranjangController::class, 'tampilKeranjang'])->name('keranjang');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'hapusItemKeranjang'])->name('keranjang.hapus');
    Route::post('/keranjang/checkout', [KeranjangController::class, 'pindahKePesanan'])->name('keranjang.checkout');
    Route::post('/pesan-langsung', [PesananController::class, 'pesanlangsung'])->name('pesan.langsung');

    

    //PESANAN DAN PEMBAYARAN
    Route::get('/pesanan/belum-bayar', [PesananController::class, 'belumBayar'])->name('pesanan.belumbayar');
    Route::get('/pesanan/proses', [PesananController::class, 'proses'])->name('pesanan.proses');
    Route::get('/pesanan/selesai', [PesananController::class, 'selesai'])->name('pesanan.selesai');
    Route::get('/pesanan/dibatalkan', [PesananController::class, 'dibatalkan'])->name('pesanan.dibatalkan');

    Route::post('/pesanan/{id}/bayar', [PesananController::class, 'bayar'])->name('pesanan.bayar');
    Route::post('/pesanan/{id}/batal', [PesananController::class, 'batal'])->name('pesanan.batal');
});
    