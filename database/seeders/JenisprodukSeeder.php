<?php

namespace Database\Seeders;

use App\Models\Brandproduk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisprodukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brandproduk = new brandproduk();
        $brandproduk->brand = "Xiaomi";
        $brandproduk->type = "13T";
        $brandproduk->save();

        $brandproduk = new brandproduk();
        $brandproduk->brand = "Infinix";
        $brandproduk->type = "1S";
        $brandproduk->save();

    }
}
