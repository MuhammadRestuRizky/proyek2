<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // =====================
    // REGISTER USER (CUSTOMER)
    // =====================
    public function registerUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'no_wa' => 'required',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_wa' => $request->no_wa,
            'role' => 'costumer',
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Register berhasil');
    }

    // =====================
    // REGISTER PEMILIK
    // =====================
    public function registerPemilik(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'no_wa' => 'required',
            'password' => 'required|min:6|confirmed',
            'ktp' => 'required|file',
            'dokumen' => 'required|file',
        ]);

        // upload file
        $ktpPath = $request->file('ktp')->store('ktp', 'public');
        $dokumenPath = $request->file('dokumen')->store('dokumen', 'public');

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_wa' => $request->no_wa,
            'password' => Hash::make($request->password),
            'role' => 'pemilik',
            'status_akun' => 'pending',
            'ktp' => $ktpPath,
            'dokumen' => $dokumenPath,
        ]);

        return redirect('/login')->with('success', 'Akun Pemilik Kost Berhasil Dibuat');
    }

    // =====================
    // LOGIN UNIVERSAL (SEMUA ROLE)
    // =====================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            // 🔥 ROLE BASED REDIRECT
            if ($user->role === 'pemilik') {
                return redirect()->route('pemilik.dashboard');
            }

            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            }

            return redirect('/'); // costumer
        }

        return back()->withErrors([
            'email' => 'Email atau password salah',
        ]);
    }

    // =====================
    // LOGOUT
    // =====================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}