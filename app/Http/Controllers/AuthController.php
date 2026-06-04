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
    ],[
    'password.min' => 'Password minimal 6 karakter.',
    'password.required' => 'Password wajib diisi.'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_wa' => $request->no_wa,
            'role' => 'costumer',
            'status_akun' => 'aktif',
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('success', 'Register berhasil');
    }

    // =====================
    // REGISTER PEMILIK
    // =====================
    public function registerPemilik(Request $request)
    {$userDitolak = User::where('email', $request->email)
    ->where('status_akun', 'ditolak')
    ->first();

if ($userDitolak) {

    // hapus file lama
    if ($userDitolak->ktp) {
        \Storage::disk('public')->delete($userDitolak->ktp);
    }

    if ($userDitolak->dokumen) {
        \Storage::disk('public')->delete($userDitolak->dokumen);
    }

    // hapus akun lama
    $userDitolak->delete();
}
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'no_wa' => 'required',
            'password' => 'required|min:6',
            'ktp' => 'required|file',
            'dokumen' => 'required|file',
            ],[
    'password.min' => 'Password minimal 6 karakter.',
    'password.required' => 'Password wajib diisi.'
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

        return redirect('/login')->with(
            'success',
            'Akun Pemilik Kost berhasil dibuat dan menunggu persetujuan admin'
        );
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

            // =========================
            // PEMILIK KOST
            // =========================
            if ($user->role === 'pemilik') {

                // akun masih pending
                if ($user->status_akun === 'pending') {

                    Auth::logout();

                    return back()->withErrors([
                        'email' => 'Akun Anda masih menunggu persetujuan admin.'
                    ]);
                }

                // akun ditolak
                if ($user->status_akun === 'ditolak') {

                    Auth::logout();

                    return back()->withErrors([
                        'email' => 'Akun Anda ditolak oleh admin. Silakan daftar ulang dengan memperbaiki data yang diperlukan.'
                    ]);
                }

                // akun aktif
                if ($user->status_akun === 'aktif') {
                    return redirect()->route('pemilik.dashboard');
                }
            }

            // =========================
            // ADMIN
            // =========================
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            }

            // =========================
            // COSTUMER
            // =========================
            if ($user->role === 'costumer') {

                // akun customer dinonaktifkan admin
                if ($user->status_akun === 'nonaktif') {

                    Auth::logout();

                    return back()->withErrors([
                        'email' => 'Akun Anda telah dinonaktifkan oleh admin.'
                    ]);
                }

                // akun aktif
                return redirect('/');
            }
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

        return redirect('/');
    }
}