<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\RoleModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->intended('/dashboard');
        }

        return view('/');
    }

    public function postlogin(Request $request)
    {
        // Validate input
        $request->validate([
            'username' => 'required|string|max:100',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        // Log attempt for debugging
        Log::info('Login attempt', ['username' => $credentials['username']]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Log::info('Login successful', ['username' => Auth::user()->username, 'id_user' => Auth::user()->id_user]);
            return redirect()->intended('/dashboard');
        }

        Log::warning('Login failed', ['username' => $credentials['username']]);
        return redirect('/')->withErrors([
            'username' => 'Username or password is incorrect.'
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('');
    }
}