<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    
    private const MAX_ATTEMPTS = 5;

    private const LOCK_SECONDS = 60;

    public function index()
    {
        return view('login');
    }

    public function auth(LoginRequest $request)
    {
        $throttleKey = $this->throttleKey($request);

       
        if (RateLimiter::tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)) {
            $detik = RateLimiter::availableIn($throttleKey);

            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => "Terlalu banyak percobaan gagal (maks " . self::MAX_ATTEMPTS . "x). "
                        . "Akun dikunci sementara, coba lagi dalam {$detik} detik.",
                ]);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            return redirect()->route('dashboard')
                ->with('success', 'Selamat Datang, ' . Auth::user()->name);
        }

        RateLimiter::hit($throttleKey, self::LOCK_SECONDS);
        $sisaPercobaan = self::MAX_ATTEMPTS - RateLimiter::attempts($throttleKey);

        $pesan = $sisaPercobaan > 0
            ? "Email atau password tidak valid. Sisa percobaan: {$sisaPercobaan}x."
            : "Email atau password tidak valid. Akun dikunci sementara selama " . self::LOCK_SECONDS . " detik.";

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => $pesan,
            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah keluar aplikasi!');
    }

    /**
     * Kunci pembatas percobaan login: kombinasi email + alamat IP,
     * supaya orang lain tidak ikut terkunci gara-gara satu email dicoba dari device lain.
     */
    private function throttleKey(Request $request): string
    {
        return Str::lower((string) $request->input('email')) . '|' . $request->ip();
    }
}
