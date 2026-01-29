<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan Form Login
    public function showLogin()
    {
        return view("auth.login");
    }

    // Tampilkan Form Register
    public function showRegister()
    {
        return view("auth.register");
    }

    // Proses Register (Simpan ke DB)
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required|min:6|confirmed",
            "username" => "nullable|unique:users",
        ]);

        DB::table("users")->insert([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password), // Password di-hash agar aman
            "username" => $request->username,
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        return redirect()
            ->route("login")
            ->with("success", "Pendaftaran berhasil! Silahkan login.");
    }

    // Proses Login
    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        $credentials = $request->only("email", "password");

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended("/dashboard");
        }

        return back()->with("error", "Email atau Password salah!");
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/");
    }
}
