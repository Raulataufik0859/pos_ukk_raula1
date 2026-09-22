<?php

namespace Database\Factories;

use App\Models\Jenis;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdukFactory extends Factory
{
    public function definition(): array
    {
        $hargaBeli = $this->faker->numberBetween(10_000, 500_000);
        $persenLaba = $this->faker->numberBetween(10, 50);

        return [
            'user_id'       => User::where('role_id', 1)->inRandomOrder()->value('id') ?? 1,
            'foto'          => null, // biar kosong dulu, atau bisa diisi path dummy
            'nama'          => $this->faker->words(2, true),
            'jenis_id'      => Jenis::inRandomOrder()->value('id'),
            'harga_beli'    => $hargaBeli,
            'persen_laba'   => $persenLaba,
            'harga_jual'    => Produk::hitungHargaJual($hargaBeli, $persenLaba),
            'persen_diskon' => 0,
            'stok'          => $this->faker->numberBetween(5, 300),
        ];
    }
}
