<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $table = 'detailpesanan';
    protected $primaryKey = 'id_detailpesanan';
    public $timestamps = false;

    protected $fillable = [
        'id_pesanan', 'id_produk', 'brand', 'type', 'qty', 'harga'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

}
