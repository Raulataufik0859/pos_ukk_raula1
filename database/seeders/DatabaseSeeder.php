<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Data WAJIB supaya aplikasi bisa dipakai (role, akun login, jenis produk).
     * Jalankan dengan: php artisan migrate --seed
     *
     * Produk & Penjualan SENGAJA tidak ikut di sini — supaya setelah migrate --seed,
     * halaman Produk & Penjualan masih kosong dan diisi manual satu-satu sendiri.
     *
     * Kalau suatu saat butuh data contoh (20 produk + 20 transaksi) untuk latihan,
     * jalankan terpisah:
     *   php artisan db:seed --class=ProdukSeeder
     *   php artisan db:seed --class=PenjualanSeeder
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            JenisSeeder::class,
        ]);
    }
}
