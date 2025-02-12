<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PelangganController extends Controller
{

    public function __construct()
    {
        // Menambahkan middleware ke dalam controller untuk mengotentikasi pengguna
        $this->middleware('auth');
    }

    
    public function pelanggan(){
        $users = User::all(); // Mengambil semua data pengguna
        return view('admin.Pelanggan', compact('users'));
    }
}
