<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'produk';

    protected $fillable = [
        'user_id',
        'foto',
        'nama',
        'jenis_id',
        'harga_beli',
        'persen_laba',
        'harga_jual',
        'persen_diskon',
        'stok',
    ];

    protected $casts = [
        'harga_beli'    => 'integer',
        'persen_laba'   => 'integer',
        'harga_jual'    => 'integer',
        'persen_diskon' => 'integer',
        'stok'          => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jenis(): BelongsTo
    {
        return $this->belongsTo(Jenis::class, 'jenis_id');
    }

    public function itemPenjualan(): HasMany
    {
        return $this->hasMany(ItemPenjualan::class, 'produk_id');
    }

    /*
    |--------------------------------------------------------------------
    | LOGIKA HARGA JUAL, LABA & DISKON
    |--------------------------------------------------------------------
    | Harga jual dihitung otomatis dari harga beli + persen laba, supaya
    | tidak bisa diinput sembarangan lewat form:
    |     harga_jual = harga_beli + (harga_beli * persen_laba / 100)
    |
    | Diskon (persen_diskon) dibatasi agar toko tidak pernah rugi:
    | minimal = 1/3 dari persen laba, maksimal = 2/3 dari persen laba.
    | Contoh: laba 30%  -> diskon minimal 10%, maksimal 20%.
    */

    /**
     * Hitung harga jual otomatis dari harga beli & persen laba.
     */
    public static function hitungHargaJual(int $hargaBeli, int $persenLaba): int
    {
        return (int) round($hargaBeli + ($hargaBeli * $persenLaba / 100));
    }

    /**
     * Batas persen diskon yang diperbolehkan untuk sebuah persen laba.
     * Return: ['min' => int, 'max' => int]
     */
    public static function batasDiskon(int $persenLaba): array
    {
        return [
            'min' => (int) round($persenLaba / 3),
            'max' => (int) round($persenLaba * 2 / 3),
        ];
    }

    /** Accessor: batas diskon untuk produk ini. */
    public function getBatasDiskonAttribute(): array
    {
        return self::batasDiskon((int) $this->persen_laba);
    }

    /** Accessor: nominal laba (Rp) per unit dari harga beli. */
    public function getLabaRupiahAttribute(): int
    {
        return (int) $this->harga_jual - (int) $this->harga_beli;
    }

    /** Accessor: harga jual final setelah dipotong diskon (dipakai saat transaksi). */
    public function getHargaSetelahDiskonAttribute(): int
    {
        if ($this->persen_diskon <= 0) {
            return (int) $this->harga_jual;
        }

        return (int) round($this->harga_jual - ($this->harga_jual * $this->persen_diskon / 100));
    }
}
