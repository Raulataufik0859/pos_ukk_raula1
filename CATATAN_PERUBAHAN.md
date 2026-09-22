# Catatan Perubahan — Aplikasi Kasir (Persiapan UKK)

Ringkasan perubahan yang dilakukan, supaya mudah dijelaskan ke asesor.

## 1. Setelah ekstrak file ini

```bash
composer install
copy .env.example .env      # (Windows) atau: cp .env.example .env  (Linux/Mac)
php artisan key:generate
php artisan migrate         # WAJIB: ada migration baru (persen_laba & persen_diskon)
php artisan db:seed         # opsional, isi data contoh
npm install && npm run build
```

> Jika sebelumnya sudah pernah migrate, cukup jalankan `php artisan migrate`
> untuk menambahkan 2 kolom baru ke tabel `produk` tanpa menghapus data lain.

## 2. Fitur Diskon Produk

- Field baru di produk: **Persen Laba** dan **Persen Diskon**.
- **Harga Jual dihitung otomatis** di server (bukan diinput manual):
  `harga_jual = harga_beli + (harga_beli x persen_laba / 100)`.
- **Aturan diskon**: hanya boleh 0% (tanpa diskon), atau berada di antara
  **1/3 sampai 2/3 dari persen laba**.
  Contoh: laba 30% → diskon hanya boleh diisi **10% s.d. 20%**.
  Validasi ini dijalankan di dua tempat:
  - **Server** (`app/Http/Requests/Produk/StoreRequest.php` &
    `UpdateRequest.php`, method `withValidator()`) — ini yang menentukan,
    tidak bisa dilewati walau form diubah lewat devtools.
  - **Client (JS)** di `public/js/produk-harga.js` — hanya membantu
    tampilan real-time, bukan validasi utama.
- Logika hitungnya ada di satu tempat saja: `app/Models/Produk.php`
  (`hitungHargaJual()` dan `batasDiskon()`), supaya gampang dijelaskan.
- Saat kasir menambahkan produk ke keranjang (`ItemPenjualanController`),
  harga yang dicatat adalah **harga setelah diskon**
  (`$produk->harga_setelah_diskon`), bukan harga jual normal.

## 3. Batas Percobaan Login (5x)

- Ada di `app/Http/Controllers/AuthController.php`, menggunakan fitur
  bawaan Laravel `RateLimiter` (tidak perlu tabel/migration tambahan).
- Kunci pembatas = kombinasi **email + alamat IP**, jadi email lain dari
  perangkat lain tidak ikut terkunci.
- Setelah **5x salah**, akun dikunci sementara **60 detik**; pesan
  peringatan otomatis muncul di halaman login (jumlah sisa percobaan,
  lalu pesan "dikunci sementara ... detik").
- Percobaan direset otomatis begitu login berhasil.

## 4. Harga Jual Otomatis dari Laba

- Contoh sesuai permintaan: harga beli Rp1.000.000, persen laba 30% →
  harga jual otomatis tampil **Rp1.300.000** (dihitung live lewat JS saat
  mengetik, dan dihitung ulang di server saat disimpan).
- Field "Harga Jual" di form sekarang **read-only** (bukan input bebas)
  supaya tidak bisa diisi sembarangan — konsisten dengan harga beli & laba.

## 5. Penyederhanaan Tampilan & Kode

- Form Tambah/Edit Produk memakai pola & style yang sama seperti versi
  sebelumnya (Tailwind, komponen `page-header`, dsb.) supaya asesor yang
  minta ubah tampilan tidak bingung dengan struktur baru.
- Perhitungan harga & diskon dipisah jadi 1 file JS kecil
  (`public/js/produk-harga.js`) dan 1 method di Model — bukan logic yang
  bertebaran di banyak file, jadi lebih gampang ditunjukkan & diubah saat
  presentasi.
- Semua controller/model yang diubah diberi komentar berbahasa Indonesia
  supaya gampang dijelaskan langsung ke asesor.

## 6. File yang berubah/ditambah

- `database/migrations/2026_09_21_000001_add_persen_laba_diskon_to_produk_table.php` (baru)
- `app/Models/Produk.php`
- `app/Http/Requests/Produk/StoreRequest.php`
- `app/Http/Requests/Produk/UpdateRequest.php`
- `app/Http/Controllers/ProdukController.php`
- `app/Http/Controllers/ItemPenjualanController.php`
- `app/Http/Controllers/AuthController.php`
- `resources/views/produk/create.blade.php`
- `resources/views/produk/edit.blade.php`
- `resources/views/produk/index.blade.php`
- `resources/views/penjualan/form.blade.php`
- `public/js/produk-harga.js` (baru)
- `database/seeders/ProdukSeeder.php`
- `database/factories/ProdukFactory.php`
- `database/factories/ItemPenjualanFactory.php`

## 7. Yang perlu di-cek ulang setelah upload ke server ujikom

- Pastikan `php artisan migrate` dijalankan (kalau tidak, kolom
  `persen_laba` & `persen_diskon` belum ada → form produk akan error).
- Pastikan cache driver aktif (default `database`, tabel `cache` sudah
  ada dari migration bawaan) supaya batas percobaan login berfungsi.
