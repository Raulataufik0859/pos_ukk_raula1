<?php

namespace App\Http\Requests\Produk;

use App\Models\Produk;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'foto'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'nama'          => 'required|string|max:255',
            'jenis_id'      => 'required|exists:jenis,id',
            'harga_beli'    => 'required|integer|min:0',
            'persen_laba'   => 'required|integer|min:0|max:1000',
            'persen_diskon' => 'nullable|integer|min:0|max:100',
            'stok'          => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'foto.image' => 'File yang diupload harus gambar.',
            'foto.mimes' => 'Ekstensi gambar harus JPG, JPEG, PNG, atau WEBP.',
            'foto.max' => 'Maksimal ukuran gambar 2MB.',
            'nama.required' => 'Nama produk wajib diisi.',
            'nama.max' => 'Nama produk maksimal 255 karakter.',
            'jenis_id.required' => 'Jenis produk wajib dipilih.',
            'harga_beli.required' => 'Harga beli wajib diisi.',
            'harga_beli.integer' => 'Harga beli harus berupa angka.',
            'harga_beli.min' => 'Harga beli tidak boleh negatif.',
            'persen_laba.required' => 'Persen laba wajib diisi.',
            'persen_laba.integer' => 'Persen laba harus berupa angka.',
            'persen_laba.min' => 'Persen laba tidak boleh negatif.',
            'persen_diskon.integer' => 'Persen diskon harus berupa angka.',
            'persen_diskon.min' => 'Persen diskon tidak boleh negatif.',
            'persen_diskon.max' => 'Persen diskon maksimal 100.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'stok.min' => 'Stok tidak boleh negatif.',
        ];
    }

    /**
     * Aturan tambahan: persen diskon tidak boleh melebihi persen laba.
     * Batasnya: minimal 1/3 dari laba, maksimal 2/3 dari laba.
     * Contoh: laba 30% -> diskon hanya boleh 10% s.d. 20%.
     */
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $persenLaba = (int) $this->input('persen_laba');
            $persenDiskon = (int) $this->input('persen_diskon', 0);

            if ($persenDiskon <= 0) {
                return; // tidak pakai diskon, tidak perlu dicek
            }

            $batas = Produk::batasDiskon($persenLaba);

            if ($persenDiskon < $batas['min'] || $persenDiskon > $batas['max']) {
                $validator->errors()->add(
                    'persen_diskon',
                    "Diskon untuk laba {$persenLaba}% harus di antara {$batas['min']}% - {$batas['max']}%."
                );
            }
        });
    }
}
