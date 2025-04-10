<?php

namespace App\Http\Controllers;
use App\Models\Pesanan;

use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function simpan(Request $request, $id)
{
    $pesanan = Pesanan::findOrFail($id);
    $pesanan->rating = $request->rating;
    $pesanan->save();

    return response()->json(['success' => true]);
}
}
