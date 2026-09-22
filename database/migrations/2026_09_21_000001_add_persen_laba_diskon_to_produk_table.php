<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom persentase laba & persentase diskon pada tabel produk.
     *
     * - persen_laba   : persen keuntungan dari harga beli, dipakai untuk
     *                   menghitung harga_jual secara otomatis.
     * - persen_diskon : persen potongan harga yang boleh diatur admin,
     *                   nilainya dibatasi tidak boleh melebihi persen_laba
     *                   (lihat App\Models\Produk::batasDiskon()).
     */
    public function up(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->unsignedInteger('persen_laba')->default(0)->after('harga_beli');
            $table->unsignedInteger('persen_diskon')->default(0)->after('harga_jual');
        });
    }

    public function down(): void
    {
        Schema::table('produk', function (Blueprint $table) {
            $table->dropColumn(['persen_laba', 'persen_diskon']);
        });
    }
};
