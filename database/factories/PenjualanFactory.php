<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Penjualan;
use App\Models\User;
use App\Models\Produk;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penjualan>
 */
class PenjualanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Penjualan::class;

    public function definition(): array
    {
        // Bobot: lebih banyak COMPLETED supaya data dummy terlihat seperti toko yang aktif
        $status = $this->faker->randomElement(['OPEN', 'COMPLETED', 'COMPLETED', 'COMPLETED', 'PENDING']);

        if ($status === 'OPEN') {
            // OPEN = belum checkout, metode belum benar-benar dipilih kasir (nilai default saja)
            $metode = 'CASH';
        } elseif ($status === 'PENDING') {
            // PENDING hanya berlaku untuk transfer yang menunggu verifikasi admin
            $metode = 'TRANSFER';
        } else {
            $metode = $this->faker->randomElement(['CASH', 'TRANSFER', 'QRIS']);
        }

        return [
            'user_id' => User::inRandomOrder()->value('id'),
            'total_pembayaran' => 0, // akan diupdate di seeder
            'metode_pembayaran' => $metode,
            'status' => $status,
        ];
    }
}
