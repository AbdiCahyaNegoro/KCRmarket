<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuhuAirIot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SuhuAirController extends Controller
{
    public function suhuair()
    {
        $data = DB::table('suhuairiot')->get();

        return view ('admin.SuhuAir',compact('data'));
    } 


    function simpandata() {
        DB::table('suhuair')->insert(['nilaisuhu'=>request()->nilaisuhu,]);
    }

}

