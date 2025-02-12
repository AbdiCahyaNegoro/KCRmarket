<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PakanIkanIot;

class PakanIkanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pakan = new PakanIkanIot();
        $pakan->waktu_pakan = 60;
        $pakan->save();
    }
}
