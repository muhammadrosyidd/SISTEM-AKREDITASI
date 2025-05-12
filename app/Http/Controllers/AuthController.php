<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;


class AuthController extends Controller
{
    // public function login(Request $request)
    // {
    //     $credentials = $request->only('username', 'password');

    //     if (Auth::attempt($credentials)) {
    //         // Authentication passed...
    //         return redirect()->intended('dashboard');
    //     }

    //     return back()->withErrors([
    //         'username' => 'The provided credentials do not match our records.',
    //     ]);
    // }

    public function __construct()
    {
        $this->middleware('guest')->only('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        $username = $request->username;
        $password = $request->password;

        $key = 'login:'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->withErrors(['username' => 'Too many login attempts. Try again later.']);
        }

        Log::info('Login attempt', ['username' => $username]);

        if (Auth::attempt(['username' => $username, 'password' => $password])) {
            $request->session()->regenerate();
            Log::info('User logged in', ['id_user' => Auth::user()->id_user, 'username' => $username]);
            return redirect()->intended('dashboard');
        }

        RateLimiter::hit($key);
        Log::warning('Failed login attempt', ['username' => $username]);

        return back()->withErrors([
            'username' => 'Invalid credentials.',
        ])->withInput();
    }
}