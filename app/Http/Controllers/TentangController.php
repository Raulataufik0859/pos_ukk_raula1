<?php

namespace App\Http\Controllers;

class TentangController extends Controller
{
    /**
     * Menampilkan halaman informasi perusahaan (Tentang Puma Speedcat).
     * Bisa diakses oleh Admin maupun Kasir — cuma halaman informasi, tidak ada data sensitif.
     */
    public function index()
    {
        return view('tentang');
    }
}
