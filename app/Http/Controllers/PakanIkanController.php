<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PakanIkanIot;

class PakanIkanController extends Controller
{
    public function lihatpakanikan()
    {
        $waktuPakan = DB::table('pakanikaniot')->value('waktu_pakan');
        $last_feed_time = PakanIkanIot::latest()->value('waktu_pakan'); // Contoh mengambil waktu terakhir dari model PakanIkan
    
        return view('admin.PakanIkan', compact('waktuPakan', 'last_feed_time'));
    }

    public function getWaktuPakan()
    {
        $waktuPakan = PakanIkanIot::value('waktu_pakan');
        return response()->json(['waktuPakan' => $waktuPakan]);
    }

    public function updateWaktuPakan(Request $request)
    {
        $request->validate([
            'waktu_pakan' => 'required|integer',
        ]);

        PakanIkanIot::updateOrCreate(
            ['id' => 1], // Sesuaikan dengan kondisi tabel Anda
            [
                'waktu_pakan' => $request->waktu_pakan,
                'updated_at' => now() // Menyimpan waktu saat ini
            ]
        );

        return redirect()->back()->with('success', 'Waktu pakan updated successfully.');
    }
}
