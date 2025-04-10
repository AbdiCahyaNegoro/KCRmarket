<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $userId = Auth::id();
                $jumlahItemKeranjang = DB::table('keranjang')
                    ->where('id_user', $userId)
                    ->count();

                $jumlahPesananBelumBayar = DB::table('pesanan')
                ->where('id_user', $userId)
                ->where('status', 'Belum Bayar')
                ->count();

                $view->with('jumlahItemKeranjang', $jumlahItemKeranjang)
                    ->with('jumlahPesananBelumBayar', $jumlahPesananBelumBayar);
            }
        });
    }
}
