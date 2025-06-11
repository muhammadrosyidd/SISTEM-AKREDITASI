<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     * Jika pengguna sudah login, langsung arahkan ke dashboard yang sesuai.
     */
    public function login()
    {
        if (Auth::check()) {
            // Dapatkan user yang sedang login
            $user = Auth::user();

            // Cek peran dan arahkan ke rute yang benar
            // PASTIKAN Anda menyesuaikan cara pengecekan role di bawah ini
            // Contoh ini mengasumsikan ada relasi 'role' di model User Anda
            if ($user->role->role_kode === 'KJR') {
                return redirect()->route('dashboard.kajur');
            }

            if ($user->role && $user->role->role_kode === 'DKT') {
                return redirect()->route('dashboard.direktur');
            }

            // Fallback jika punya role lain atau untuk halaman default
            return redirect('/dashboard');
        }

        // PERBAIKAN: Gunakan nama file view, bukan URL.
        // Ganti 'auth.login' dengan nama file view login Anda (misal: 'login_page').
        return view('auth.login');
    }

    /**
     * Memproses permintaan login dari form.
     */
    public function postlogin(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string|max:100',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        Log::info('Login attempt', ['username' => $credentials['username']]);

        // Mencoba untuk melakukan otentikasi
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Dapatkan user yang berhasil login
            $user = Auth::user();
            Log::info('Login successful', ['username' => $user->username, 'id_user' => $user->id_user, 'role' => $user->role->nama_role ?? 'N/A']);

            // --- INI BAGIAN UTAMA PERBAIKAN ---
            // Arahkan pengguna berdasarkan perannya (role)
            // Sesuaikan kondisi ini dengan struktur database Anda.
            // Contoh: $user->role->nama_role, $user->id_role, dll.
            if ($user->role && $user->role->role_kode === 'KJR') {
                return redirect()->route('dashboard.kajur');
            }

            if ($user->role && $user->role->role_kode === 'DKT') {
                return redirect()->route('dashboard.direktur');
            }

            // Redirect default jika user tidak punya role yang cocok
            return redirect()->intended('/dashboard');
        }

        Log::warning('Login failed', ['username' => $credentials['username']]);

        // PERBAIKAN: Redirect kembali ke halaman login dengan pesan error.
        // Lebih baik menggunakan nama rute jika ada.
        return back()->withErrors([
            'username' => 'Username atau password salah.'
        ])->withInput($request->only('username')); // Hanya kembalikan username
    }

    /**
     * Memproses logout pengguna.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // PERBAIKAN: Redirect ke halaman utama atau halaman login
        return redirect('/');
    }
}
