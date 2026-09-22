@extends('layouts.app')

@section('content')
<div class="p-6">
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Produk</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Ubah data produk</p>
        </div>
        <a href="{{ route('produk.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm font-medium rounded-xl transition">
            ← Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <form action="{{ route('produk.update', $produk) }}" method="POST" enctype="multipart/form-data" class="p-6 md:p-8">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Produk --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama', $produk->nama) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           required>
                    @error('nama')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Jenis Produk <span class="text-red-500">*</span>
                    </label>
                    <select name="jenis_id"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            required>
                        <option value="">-- Pilih Jenis --</option>
                        @foreach($jenisList as $jenis)
                            <option value="{{ $jenis->id }}"
                                {{ old('jenis_id', $produk->jenis_id) == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_id')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stok --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stok" value="{{ old('stok', $produk->stok) }}" min="0"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           required>
                    @error('stok')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga Beli --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Harga Beli <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 text-sm pointer-events-none">Rp</span>
                        <input type="text" inputmode="numeric" id="harga_beli_display"
                               value="{{ number_format((int) old('harga_beli', $produk->harga_beli), 0, ',', '.') }}"
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                               autocomplete="off">
                        <input type="hidden" name="harga_beli" id="harga_beli" value="{{ old('harga_beli', $produk->harga_beli) }}">
                    </div>
                    @error('harga_beli')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Persen Laba --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Persen Laba (%) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="persen_laba" id="persen_laba" min="0" max="1000"
                           value="{{ old('persen_laba', $produk->persen_laba) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                           required>
                    @error('persen_laba')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga Jual (otomatis, tidak diinput manual) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Harga Jual <span class="text-xs text-gray-400 font-normal">(otomatis)</span>
                    </label>
                    <div id="harga_jual_display"
                         class="w-full px-4 py-2.5 rounded-xl border border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900/60 text-gray-800 dark:text-gray-200 font-semibold">
                        Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                    </div>
                    <p class="mt-1.5 text-xs text-gray-400">Dihitung otomatis dari harga beli + persen laba.</p>
                </div>

                {{-- Persen Diskon --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Persen Diskon (%) <span class="text-xs text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <input type="number" name="persen_diskon" id="persen_diskon" min="0" max="100"
                           value="{{ old('persen_diskon', $produk->persen_diskon) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    <p id="batas_diskon_info" class="mt-1.5 text-xs text-gray-400">
                        @php $batas = $produk->batas_diskon; @endphp
                        Diskon boleh diisi 0%, atau antara {{ $batas['min'] }}% - {{ $batas['max'] }}% (dari laba {{ $produk->persen_laba }}%).
                    </p>
                    @error('persen_diskon')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga Setelah Diskon (otomatis) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Harga Setelah Diskon <span class="text-xs text-gray-400 font-normal">(otomatis)</span>
                    </label>
                    <div id="harga_final_display"
                         class="w-full px-4 py-2.5 rounded-xl border border-dashed border-emerald-300 dark:border-emerald-700 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-300 font-semibold">
                        Rp {{ number_format($produk->harga_setelah_diskon, 0, ',', '.') }}
                    </div>
                    <p class="mt-1.5 text-xs text-gray-400">Harga inilah yang dipakai kasir saat transaksi.</p>
                </div>

                {{-- Foto --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Foto Produk
                    </label>

                    {{-- Preview: tampilkan foto lama (kalau ada), otomatis berganti kalau pilih foto baru --}}
                    <div id="foto-preview-wrapper" class="mb-3 {{ $produk->foto ? '' : 'hidden' }}">
                        <img id="foto-preview"
                             src="{{ $produk->foto ? asset('storage/' . $produk->foto) : '' }}"
                             alt="{{ $produk->nama }}"
                             class="w-32 h-32 object-cover rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    </div>

                    <input type="file" name="foto" id="foto-input" accept="image/*"
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    @error('foto')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition shadow-sm">
                    Update Produk
                </button>
                <a href="{{ route('produk.index') }}"
                   class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 text-sm font-medium rounded-xl transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/rupiah-input.js') }}"></script>
<script src="{{ asset('js/photo-preview.js') }}"></script>
<script src="{{ asset('js/produk-harga.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        formatRupiahInput('harga_beli_display', 'harga_beli');
        setupPhotoPreview('foto-input', 'foto-preview', 'foto-preview-wrapper');
        setupHitungHargaProduk();
    });
</script>
@endsection
