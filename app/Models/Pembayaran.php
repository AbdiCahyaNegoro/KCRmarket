<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_pesanan', 'id_user', 'status', 'tanggal_pembayaran',
        'buktibayar', 'folder'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
