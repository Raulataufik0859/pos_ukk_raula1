<?php

namespace Database\Seeders;

use App\Models\Jenis;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::where('role_id', 1)->value('id') ?? 1;

        // 20 produk Puma Speedcat, dikelompokkan berdasarkan JENIS (tipe produk asli).
        // 'persen_laba' dipakai untuk menghitung harga_jual otomatis.
        // 'persen_diskon' contoh diskon (0 = tidak ada diskon).
        $data = [
            'Sepatu' => [
                ['nama' => 'Puma Speedcat OG Black/White',      'harga_beli' => 620000, 'persen_laba' => 30, 'persen_diskon' => 10, 'stok' => 25],
                ['nama' => 'Puma Speedcat OG Puma Black',       'harga_beli' => 620000, 'persen_laba' => 30, 'persen_diskon' => 0,  'stok' => 20],
                ['nama' => 'Puma Speedcat OG Vaporous Grey',    'harga_beli' => 630000, 'persen_laba' => 30, 'persen_diskon' => 0,  'stok' => 15],
                ['nama' => 'Puma Speedcat OG Racing Red',       'harga_beli' => 640000, 'persen_laba' => 30, 'persen_diskon' => 0,  'stok' => 12],
                ['nama' => 'Puma Speedcat Lace Black',          'harga_beli' => 580000, 'persen_laba' => 25, 'persen_diskon' => 0,  'stok' => 24],
                ['nama' => 'Puma Speedcat Lace White',          'harga_beli' => 580000, 'persen_laba' => 25, 'persen_diskon' => 0,  'stok' => 20],
                ['nama' => 'Puma Speedcat Lace Brown Sugar',    'harga_beli' => 590000, 'persen_laba' => 25, 'persen_diskon' => 0,  'stok' => 16],
                ['nama' => 'Puma Speedcat Lace Navy',           'harga_beli' => 590000, 'persen_laba' => 25, 'persen_diskon' => 0,  'stok' => 17],
                ['nama' => 'Puma Speedcat Pro Formstripe Black','harga_beli' => 700000, 'persen_laba' => 30, 'persen_diskon' => 15, 'stok' => 9],
                ['nama' => 'Puma Speedcat Pro Formstripe White','harga_beli' => 700000, 'persen_laba' => 30, 'persen_diskon' => 0,  'stok' => 10],
                ['nama' => 'Puma Speedcat Pro Suede Grey',      'harga_beli' => 710000, 'persen_laba' => 25, 'persen_diskon' => 0,  'stok' => 8],
            ],

            'Jaket' => [
                ['nama' => 'Jaket Puma Speedcat Track Black',      'harga_beli' => 480000, 'persen_laba' => 25, 'persen_diskon' => 0, 'stok' => 14],
                ['nama' => 'Jaket Puma Speedcat Track Navy',       'harga_beli' => 480000, 'persen_laba' => 25, 'persen_diskon' => 0, 'stok' => 12],
                ['nama' => 'Jaket Puma Speedcat Windbreaker Red',  'harga_beli' => 520000, 'persen_laba' => 25, 'persen_diskon' => 8, 'stok' => 10],
                ['nama' => 'Jaket Puma Speedcat Bomber Black',     'harga_beli' => 550000, 'persen_laba' => 25, 'persen_diskon' => 0, 'stok' => 8],
                ['nama' => 'Jaket Puma Speedcat Hoodie Grey',      'harga_beli' => 460000, 'persen_laba' => 25, 'persen_diskon' => 0, 'stok' => 15],
            ],

            'Celana' => [
                ['nama' => 'Celana Training Puma Speedcat Black',   'harga_beli' => 320000, 'persen_laba' => 25, 'persen_diskon' => 0, 'stok' => 18],
                ['nama' => 'Celana Training Puma Speedcat Navy',    'harga_beli' => 320000, 'persen_laba' => 25, 'persen_diskon' => 0, 'stok' => 16],
                ['nama' => 'Celana Chino Puma Speedcat Beige',      'harga_beli' => 350000, 'persen_laba' => 25, 'persen_diskon' => 0, 'stok' => 11],
                ['nama' => 'Celana Jogger Puma Speedcat Grey',      'harga_beli' => 300000, 'persen_laba' => 25, 'persen_diskon' => 0, 'stok' => 20],
            ],
        ];

        foreach ($data as $namaJenis => $produks) {
            $jenis = Jenis::where('nama', $namaJenis)->first();

            if (!$jenis) {
                continue;
            }

            foreach ($produks as $item) {
                Produk::create([
                    'user_id'       => $userId,
                    'foto'          => null,
                    'nama'          => $item['nama'],
                    'jenis_id'      => $jenis->id,
                    'harga_beli'    => $item['harga_beli'],
                    'persen_laba'   => $item['persen_laba'],
                    'harga_jual'    => Produk::hitungHargaJual($item['harga_beli'], $item['persen_laba']),
                    'persen_diskon' => $item['persen_diskon'],
                    'stok'          => $item['stok'],
                ]);
            }
        }
    }
}
