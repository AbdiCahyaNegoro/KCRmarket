<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'leveluser', 'alamat',
        'tanggallahir', 'jeniskelamin', 'no_hp', 'foto', 'folder',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_user');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_user');
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'id_user');
    }
}
