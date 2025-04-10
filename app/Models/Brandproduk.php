<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brandproduk extends Model
{
    use HasFactory;

    protected $table = 'brandproduk';
    protected $primaryKey = 'id_brandproduk';
    public $timestamps = false;

    protected $fillable = [
        'brand',
        'type'
    ];

    public function types()
    {
        return $this->hasMany(brandproduk::class, 'brandproduk_id', 'id_brandproduk');
    }
}
