<?php

namespace Database\Seeders;

use App\Models\Jenis;
use App\Models\User;
use Illuminate\Database\Seeder;

class JenisSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::whereHas('role', fn ($q) => $q->where('name', 'admin'))->first();

        // Jenis = tipe/kategori produk (bukan nama varian/merek)
        $daftarJenis = [
            'Sepatu',
            'Jaket',
            'Celana',
        ];

        foreach ($daftarJenis as $nama) {
            Jenis::firstOrCreate(
                ['nama' => $nama],
                ['user_id' => $admin?->id]
            );
        }
    }
}
