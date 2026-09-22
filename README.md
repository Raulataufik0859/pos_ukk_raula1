# PUMA SPEEDCAT POS — Sistem Kasir Digital (UKK RPL)

Aplikasi Point of Sale (POS) berbasis web untuk mengelola penjualan produk
Puma Speedcat, menggunakan Laravel. Dibuat oleh Raula Taufik Andriana untuk
Uji Kompetensi Keahlian (UKK) Rekayasa Perangkat Lunak.

## Yang dibutuhkan sebelum mulai

- PHP 8.2 atau lebih baru
- Composer
- MySQL (bisa lewat Laragon / XAMPP)
- Node.js + npm (untuk build tampilan Tailwind CSS)

## Cara menjalankan project (dari nol / di komputer baru)

1. **Salin file environment**

   ```
   copy .env.example .env
   ```

   (di Linux/Mac pakai `cp .env.example .env`)

2. **Install dependency PHP**

   ```
   composer install
   ```

3. **Install dependency tampilan (Tailwind CSS) & build sekali**

   ```
   npm install
   npm run build
   ```

   Cukup jalankan `npm run build` **sekali** setiap kali kamu mengubah
   file CSS/tampilan. Setelah itu tidak perlu menjalankan npm lagi — cukup
   `php artisan serve` seperti biasa. (Kalau mau lihat perubahan CSS
   langsung realtime sambil coding, boleh pakai `npm run dev` di terminal
   terpisah, tapi ini opsional.)

4. **Generate application key**

   ```
   php artisan key:generate
   ```

5. **Buat database kosong**

   Buka phpMyAdmin / HeidiSQL, buat database baru bernama `pos_ukk_raula`
   (atau sesuaikan nama di file `.env` pada baris `DB_DATABASE`).

6. **Jalankan migrasi + isi data wajib (role, akun login, jenis produk)**

   ```
   php artisan migrate --seed
   ```

   Perintah ini membuat semua tabel + mengisi data **wajib** saja: role
   (admin/kasir), akun Admin & Kasir contoh, dan 3 jenis produk Speedcat.
   **Produk dan Penjualan sengaja dikosongkan** — silakan input sendiri
   satu-satu lewat form Tambah Produk / Buat Transaksi (bagus untuk latihan
   sebelum ujikom).

   Kalau suatu saat ingin data contoh untuk latihan (20 produk + 20 transaksi
   dummy), jalankan terpisah:

   ```
   php artisan db:seed --class=ProdukSeeder
   php artisan db:seed --class=PenjualanSeeder
   ```

7. **Buat symlink storage** (supaya foto produk & foto profil bisa tampil)

   ```
   php artisan storage:link
   ```

8. **Jalankan server**

   ```
   php artisan serve
   ```

   Buka browser ke `http://127.0.0.1:8000`

## Akun contoh (hasil seeder)

| Role  | Email          | Password |
|-------|----------------|----------|
| Admin | admin@pos.com  | password |
| Kasir | kasir@pos.com  | password |

## Kalau muncul error "Please provide a valid cache path"

Ini artinya folder `storage/framework/views` tidak ada / belum ada hak
akses tulis. Jalankan:

```
php artisan optimize:clear
```

Pastikan juga folder `storage/` dan `bootstrap/cache/` bisa ditulis oleh
web server (chmod 775 di Linux/Mac; biasanya tidak masalah di Windows).

## Struktur menu & role

| Role  | Bisa akses |
|-------|-----------|
| Admin | Semua menu: Dashboard, Jenis, Produk, Penjualan, Pengguna |
| Kasir | Dashboard (terbatas), Produk (lihat saja), Penjualan |

## Struktur folder penting

```
app/Http/Controllers/   -> logic tiap halaman (satu controller per menu)
app/Models/              -> representasi tabel database (Eloquent)
database/migrations/     -> struktur tabel database
database/seeders/        -> data awal/contoh
resources/views/         -> tampilan (Blade), satu folder per menu
routes/web.php           -> daftar semua alamat URL aplikasi
```

## Kalau disuruh membuat menu/halaman baru saat ujikom

Pola yang dipakai di project ini konsisten untuk semua menu (Jenis, Produk,
Pengguna). Untuk menu baru, tinggal ikuti pola yang sama:

1. Buat migration baru: `php artisan make:migration create_nama_tabel_table`
2. Buat model: `php artisan make:model NamaModel`
3. Buat controller: `php artisan make:controller NamaController`
   (isi method `index`, `create`, `store`, `edit`, `update`, `destroy` —
   contoh paling sederhana ada di `app/Http/Controllers/JenisController.php`)
4. Tambahkan route di `routes/web.php` (contoh polanya sudah ada,
   tinggal contek baris-baris `Route::get('/jenis', ...)` dst.)
5. Buat folder view baru di `resources/views/nama-menu/` (contek dari folder
   `resources/views/jenis/` yang paling sederhana)
6. Tambahkan link menu baru di `resources/views/layouts/sidebar.blade.php`
