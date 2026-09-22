

<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="relative min-h-screen flex items-center justify-center px-4 py-12 overflow-hidden
            bg-gradient-to-br from-black via-neutral-900 to-red-950">

    
    <div class="absolute top-1/4 -left-20 w-96 h-96 bg-red-600/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-1/4 -right-20 w-80 h-80 bg-neutral-600/25 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative w-full max-w-md">

        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-28 h-28 rounded-[28px] overflow-hidden
                        bg-black border border-white/20 shadow-2xl shadow-red-600/30 mb-5 p-5">
                <img src="<?php echo e(asset('images/puma-logo-white.png')); ?>"
                     alt="Logo PUMA SPEEDCAT"
                     class="w-full h-full object-contain">
            </div>
            <h1 class="text-4xl font-extrabold text-white tracking-tight">PUMA SPEEDCAT</h1>
            <p class="text-sm font-medium text-gray-300 mt-2">Sistem Kasir Distributor Resmi</p>
            <p class="text-xs text-gray-400 mt-1">Silakan masuk untuk mengelola penjualan</p>
        </div>

        
        <div class="bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 p-8 sm:p-10 shadow-xl">
            <form id="loginForm" method="POST" action="<?php echo e(route('auth')); ?>" class="space-y-5">
                <?php echo csrf_field(); ?>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-200 mb-2">Alamat Email</label>
                    <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                        class="w-full px-4 py-3.5 rounded-2xl border border-white/20 bg-white/10 text-white
                               placeholder-gray-400 focus:bg-white/15 focus:border-red-500
                               focus:ring-4 focus:ring-red-500/20 outline-none text-sm transition-all"
                        placeholder="nama@email.com">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-xs font-medium text-rose-300"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-200 mb-2">Kata Sandi</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                            class="w-full px-4 py-3.5 pr-12 rounded-2xl border border-white/20 bg-white/10 text-white
                                   placeholder-gray-400 focus:bg-white/15 focus:border-red-500
                                   focus:ring-4 focus:ring-red-500/20 outline-none text-sm transition-all"
                            placeholder="••••••••">
                        <button type="button" id="togglePassword" tabindex="-1"
                            class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-white transition">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eyeOffIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-2 text-xs font-medium text-rose-300"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" type="checkbox" name="remember" value="1"
                            <?php echo e(old('remember') ? 'checked' : ''); ?>

                            class="w-4 h-4 rounded border-white/30 bg-white/10 text-red-600 focus:ring-red-500">
                        <label for="remember" class="ml-2.5 text-sm text-gray-300 select-none cursor-pointer">
                            Ingat saya
                        </label>
                    </div>
                </div>

                <div class="pt-1">
                    <button type="submit" id="btnSubmit"
                        class="w-full py-3.5 px-4 bg-gradient-to-r from-red-600 via-red-600 to-red-700
                               hover:from-red-500 hover:to-red-600 active:scale-[0.98]
                               text-white font-semibold rounded-2xl shadow-lg shadow-red-600/40
                               transition-all duration-200 disabled:opacity-75 disabled:cursor-not-allowed
                               flex items-center justify-center gap-2 border border-white/10">
                        <span id="btnText">Masuk Ke Aplikasi</span>
                        <span id="btnLoading" class="hidden flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Memproses...</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <p class="text-center text-xs text-gray-400 mt-8">
            © <?php echo e(date('Y')); ?> <span class="font-semibold text-gray-300">PUMA SPEEDCAT Store.</span>
        </p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeOffIcon = document.getElementById('eyeOffIcon');

    togglePassword?.addEventListener('click', function() {
        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        eyeIcon.classList.toggle('hidden', isPassword);
        eyeOffIcon.classList.toggle('hidden', !isPassword);
    });

    const loginForm = document.getElementById('loginForm');
    const btnSubmit = document.getElementById('btnSubmit');
    const btnText = document.getElementById('btnText');
    const btnLoading = document.getElementById('btnLoading');

    loginForm?.addEventListener('submit', function() {
        btnSubmit.disabled = true;
        btnText.classList.add('hidden');
        btnLoading.classList.remove('hidden');
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\pos_ukk_raula1\resources\views/login.blade.php ENDPATH**/ ?>