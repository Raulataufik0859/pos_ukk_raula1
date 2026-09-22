<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jenis extends Model
{
    use HasFactory;

    protected $table = 'jenis';

    protected $fillable = [
        'nama',
        'user_id',
    ];

    /**
     * Relasi ke Produk.
     * Di tabel produk, foreign key-nya bernama 'jenis_id'.
     */
    public function produks()
    {
        return $this->hasMany(Produk::class, 'jenis_id');
    }

    /**
     * User yang membuat jenis ini ("Dibuat Oleh").
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
