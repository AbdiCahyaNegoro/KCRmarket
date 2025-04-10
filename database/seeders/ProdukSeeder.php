<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produk1 = new produk;
        $produk1->nama_produk = "Custom Rom";
        $produk1->harga = 150000;
        $produk1->deskripsiproduk = "Melayani Costum Room";
        $produk1->id_brandproduk = 1;
        $produk1->nama_foto = "ROOT.png";
        $produk1->folder = 'assets/img/produk';
        $produk1->save();
    }
}
