@extends('layouts.app')

@section('title', 'Profil Saya')
@section('header', 'Profil Saya')

@section('content')

<style>
    #avatar-lightbox-img {
        max-height: 70vh;
        width: auto;
        max-width: 100%;
        margin: 0 auto;
        border-radius: 1rem;
        object-fit: contain;
    }
</style>

@php
    $hasAvatar = $user->avatar && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->avatar);
    $avatarUrl = $hasAvatar ? asset('storage/'.$user->avatar) : null;
    $initial = strtoupper(substr($user->name ?? 'U', 0, 1));
    $roleName = ucfirst($user->role->name ?? '-');
    $isAdmin = strtolower($user->role->name ?? '') === 'admin';

    // Statistik berguna untuk UKK
    $totalTransaksi = \App\Models\Penjualan::when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))
        ->where('status', 'COMPLETED')
        ->count();
    $totalOmzet = \App\Models\Penjualan::when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))
        ->where('status', 'COMPLETED')
        ->sum('total_pembayaran');
    $transaksiHariIni = \App\Models\Penjualan::when(!$isAdmin, fn($q) => $q->where('user_id', $user->id))
        ->where('status', 'COMPLETED')
        ->whereDate('created_at', today())
        ->count();
@endphp

<div class="w-full px-4 sm:px-6 lg:px-8 py-6">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Profil Saya</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola foto dan informasi akun Anda</p>
    </div>

    @if (session('success'))
        <div class="mb-5 p-4 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-xl text-sm border border-emerald-200 dark:border-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-5 p-4 bg-red-50 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-xl text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- KIRI: Kartu profil (gaya WhatsApp) --}}
            <div class="lg:col-span-1 space-y-5">
                <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm">
                    <div class="bg-gradient-to-br from-indigo-500 via-violet-500 to-purple-600 h-28 relative"></div>

                    <div class="px-6 pb-6 -mt-14 text-center">
                        <div class="relative inline-flex">
                            {{-- Avatar bulat (gaya WhatsApp): ukuran tetap 112x112px, overlap ke banner --}}
                            <div id="avatar-box"
                                 onclick="if(document.getElementById('avatar-preview') && !document.getElementById('avatar-preview').classList.contains('hidden')){openAvatarLightbox()}"
                                 class="w-28 h-28 shrink-0 rounded-full overflow-hidden ring-4 ring-white dark:ring-gray-900 shadow-xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center cursor-pointer">
                                <img src="{{ $avatarUrl }}" alt="Foto profil"
                                     class="w-full h-full object-cover {{ $hasAvatar ? '' : 'hidden' }}" id="avatar-preview"
                                     onerror="this.classList.add('hidden'); document.getElementById('avatar-fallback').classList.remove('hidden'); document.getElementById('btn-remove-avatar')?.classList.add('hidden');">
                                <span id="avatar-fallback"
                                      class="text-white text-4xl font-bold select-none {{ $hasAvatar ? 'hidden' : '' }}">{{ $initial }}</span>
                            </div>

                            {{-- Tombol kamera --}}
                            <label for="avatar-input"
                                   class="absolute bottom-1 right-1 w-9 h-9 rounded-full bg-indigo-600 hover:bg-indigo-500 text-white flex items-center justify-center cursor-pointer shadow-lg border-2 border-white dark:border-gray-900 transition"
                                   title="Ganti foto profil">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </label>
                            <input type="file" name="avatar" id="avatar-input" accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden">
                        </div>

                        <h2 class="mt-4 text-lg font-bold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                        <span class="inline-flex mt-2 px-3 py-0.5 rounded-full text-xs font-semibold
                            {{ $isAdmin ? 'bg-violet-100 text-violet-700 dark:bg-violet-900/40 dark:text-violet-300' : 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' }}">
                            {{ $roleName }}
                        </span>
                        <p class="text-xs text-gray-400 mt-3">Klik ikon kamera untuk ganti foto</p>
                    </div>

                    <div class="border-t border-gray-100 dark:border-gray-800 px-6 py-4 space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Bergabung</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $user->created_at?->translatedFormat('d M Y') ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Terakhir update</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $user->updated_at?->translatedFormat('d M Y H:i') ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Statistik akun (berguna UKK) --}}
                <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 p-5 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">{{ $isAdmin ? 'Ringkasan Aktivitas Toko (Semua Kasir)' : 'Ringkasan Aktivitas Saya' }}</h3>
                    <div class="grid grid-cols-1 gap-3">
                        <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800/60">
                            <span class="text-sm text-gray-500">Transaksi hari ini</span>
                            <span class="text-sm font-bold text-indigo-600 dark:text-indigo-400">{{ $transaksiHariIni }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800/60">
                            <span class="text-sm text-gray-500">Total transaksi</span>
                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ number_format($totalTransaksi) }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 dark:bg-gray-800/60">
                            <span class="text-sm text-gray-500">{{ $isAdmin ? 'Total omzet (semua)' : 'Omzet saya' }}</span>
                            <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">Rp {{ number_format($totalOmzet, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KANAN: Form edit --}}
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-900 rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Edit Informasi</h3>
                        <p class="text-xs text-gray-500 mt-0.5">Perbarui data pribadi Anda di bawah ini</p>
                    </div>

                    <div class="p-6 space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                                Role
                            </label>
                            <input type="text" value="{{ $roleName }}" disabled
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 text-gray-500 dark:text-gray-400 text-sm cursor-not-allowed">
                            <p class="text-xs text-gray-400 mt-1">{{ $isAdmin ? 'Role admin tidak dapat diubah melalui sistem' : 'Role hanya bisa diubah oleh admin' }}</p>
                        </div>

                        <div class="pt-2 border-t border-gray-100 dark:border-gray-800">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Ganti Password <span class="text-gray-400 font-normal">(opsional)</span></p>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1.5">Password Baru</label>
                                    <input type="password" name="password" autocomplete="new-password"
                                           placeholder="Kosongkan jika tidak ingin mengganti"
                                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 dark:text-gray-400 mb-1.5">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" autocomplete="new-password"
                                           placeholder="Ulangi password baru"
                                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none text-sm">
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-3 pt-2">
                            <button type="submit"
                                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold rounded-xl shadow-sm transition">
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('dashboard') }}"
                               class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-xl transition">
                                Batal
                            </a>
                            @if($hasAvatar)
                            <button type="button" id="btn-remove-avatar"
                                    class="px-5 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition ml-auto">
                                Hapus Foto
                            </button>
                            @else
                            <button type="button" id="btn-remove-avatar"
                                    class="hidden px-5 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition ml-auto">
                                Hapus Foto
                            </button>
                            @endif
                            <input type="hidden" name="remove_avatar" id="remove_avatar" value="0">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('avatar-input');
    const preview = document.getElementById('avatar-preview');
    const fallback = document.getElementById('avatar-fallback');
    const removeBtn = document.getElementById('btn-remove-avatar');
    const removeField = document.getElementById('remove_avatar');

    input?.addEventListener('change', function () {
        const file = this.files?.[0];
        if (!file) return;
        if (!file.type.startsWith('image/')) {
            alert('Pilih file gambar (jpg, png, webp).');
            this.value = '';
            return;
        }
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran maksimal 2MB.');
            this.value = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = function (e) {
            if (preview) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            }
            if (fallback) fallback.classList.add('hidden');
            if (removeBtn) removeBtn.classList.remove('hidden'); // sekarang ada foto (preview baru) -> tombol hapus boleh muncul
        };
        reader.readAsDataURL(file);
        if (removeField) removeField.value = '0';
    });

    removeBtn?.addEventListener('click', function () {
        if (!confirm('Hapus foto profil?')) return;
        if (removeField) removeField.value = '1';
        if (preview) {
            preview.src = '';
            preview.classList.add('hidden');
        }
        if (fallback) fallback.classList.remove('hidden');
        if (input) input.value = '';
        removeBtn.classList.add('hidden'); // tidak ada foto lagi -> tombol hapus disembunyikan
    });
});
</script>

<div id="avatar-lightbox" class="hidden fixed inset-0 z-[9999] items-center justify-center bg-black/80 p-4" onclick="closeAvatarLightbox()">
  <div class="relative max-w-sm w-full" onclick="event.stopPropagation()">
    <button type="button" onclick="closeAvatarLightbox()" class="absolute -top-3 -right-3 w-9 h-9 rounded-full bg-white text-gray-800 font-bold shadow">×</button>
    <img id="avatar-lightbox-img" src="" class="w-full rounded-2xl object-cover shadow-2xl" alt="Foto profil">
  </div>
</div>
<script>
function openAvatarLightbox(){
  const prev = document.getElementById('avatar-preview');
  const lb = document.getElementById('avatar-lightbox');
  const img = document.getElementById('avatar-lightbox-img');
  if(!prev || prev.classList.contains('hidden') || !prev.src) return;
  img.src = prev.src;
  lb.classList.remove('hidden'); lb.classList.add('flex');
  document.body.style.overflow='hidden';
}
function closeAvatarLightbox(){
  const lb = document.getElementById('avatar-lightbox');
  lb.classList.add('hidden'); lb.classList.remove('flex');
  document.body.style.overflow='';
}
document.getElementById('avatar-preview')?.addEventListener('click', function(e){ e.stopPropagation(); openAvatarLightbox(); });
</script>

@endsection
