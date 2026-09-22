@extends('layouts.app')

@section('title', 'Tentang Kami')
@section('header', 'Tentang Kami')

@section('content')
<div class="p-6">

    {{-- Hero --}}
    <div class="relative overflow-hidden rounded-2xl bg-black mb-6">
        <div class="absolute inset-0 bg-gradient-to-br from-red-950 via-black to-black opacity-90"></div>
        <div class="relative px-8 py-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-white dark:bg-black p-3 border border-gray-200 dark:border-gray-700
                                    transition group-hover:ring-2 group-hover:ring-indigo-400" shadow-xl mb-4">
                 <img src="{{ asset('images/puma-logo-black.png') }}" alt="Logo Puma Speedcat"
                                class="w-full h-full object-contain block dark:hidden">
                            <img src="{{ asset('images/puma-logo-white.png') }}" alt="Logo Puma Speedcat"
                                class="w-full h-full object-contain hidden dark:block">
            </div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight">PUMA SPEEDCAT</h1>
            <p class="text-sm text-red-200/80 mt-2">Distributor Resmi Outfit Puma Speedcat</p>
        </div>
    </div>

    {{-- Deskripsi --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 md:p-8 mb-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Tentang Kami</h2>
        <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
            Puma Speedcat Store adalah toko yang fokus menjual produk outfit bertema
            <strong>Puma Speedcat</strong> — mulai dari sepatu, jaket, hingga celana yang terinspirasi
            dari warisan balap (motorsport) khas Puma. Kami berkomitmen menghadirkan produk yang
            orisinal, berkualitas, dan sesuai gaya penggemar budaya racing maupun streetwear.
        </p>
        <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed mt-3">
            Sistem kasir digital ini dibangun untuk mempermudah pencatatan transaksi penjualan,
            pengelolaan stok, dan pemantauan performa toko secara real-time.
        </p>
    </div>

    {{-- Keunggulan --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 text-center">
            <div class="w-11 h-11 mx-auto rounded-xl bg-red-50 dark:bg-red-900/30 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">100% Original</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Produk resmi & bergaransi</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 text-center">
            <div class="w-11 h-11 mx-auto rounded-xl bg-red-50 dark:bg-red-900/30 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Transaksi Cepat</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Cash, QRIS & Transfer Bank</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 text-center">
            <div class="w-11 h-11 mx-auto rounded-xl bg-red-50 dark:bg-red-900/30 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Stok Real-time</h3>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pantauan stok otomatis</p>
        </div>
    </div>

    {{-- Kontak --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 md:p-8">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Kontak & Lokasi</h2>
        <div class="space-y-3 text-sm">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span class="text-gray-600 dark:text-gray-300">Tasikmalaya, Jawa Barat, Indonesia</span>
            </div>
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span class="text-gray-600 dark:text-gray-300">0812-3456-7890</span>
            </div>
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-gray-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span class="text-gray-600 dark:text-gray-300">hello@pumaspeedcat.store</span>
            </div>
        </div>

        
    </div>

</div>
@endsection
