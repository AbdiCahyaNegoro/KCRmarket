<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proses extends Model
{
    use HasFactory;

    protected $table = 'proses';
    protected $primaryKey = 'id_proses';
    public $timestamps = false;

    protected $fillable = [
        'id_pesanan', 'tanggal_proses', 'status',
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
