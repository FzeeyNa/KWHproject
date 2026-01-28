<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan Form Login
    public function showLogin() {
        return view('auth.login');
    }

    // Tampilkan Form Register
    public function showRegister() {
        return view('auth.register');
    }

    // Proses Register (Simpan ke DB)
    public function register(Request $request) {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'fullName' => 'required'
        ]);

        DB::table('users')->insert([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password di-hash agar aman
            'fullName' => $request->fullName,
            'createdAt' => now(),
            'updatedAt' => now()
        ]);

        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silahkan login.');
    }

    // Proses Login
    public function login(Request $request) {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->with('error', 'Username atau Password salah!');
    }

    // Proses Logout
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}