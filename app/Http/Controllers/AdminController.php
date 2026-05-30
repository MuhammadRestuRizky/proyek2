<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kost;

class AdminController extends Controller
{
    // ======================
    // DASHBOARD ADMIN
    // ======================
    public function dashboard()
    {
        // akun pemilik yang pending
        $pendingUsers = User::where('role', 'pemilik')
            ->where('status_akun', 'pending')
            ->get();

        // akun pemilik yang aktif
        $activeUsers = User::where('role', 'pemilik')
            ->where('status_akun', 'aktif')
            ->get();

        return view('admin.dashboard', compact(
            'pendingUsers',
            'activeUsers'
        ));
    }

    // ======================
    // HALAMAN VERIFIKASI USER
    // ======================
    public function verifikasiUser()
    {
        return view('admin.verifikasi');
    }

    // ======================
    // APPROVE USER
    // ======================
    public function approveUser($id)
    {
        $user = User::findOrFail($id);

        $user->status_akun = 'aktif';
        $user->save();

        return redirect()->back()->with('success', 'Akun berhasil diaktifkan');
    }

    // ======================
    // KELOLA KOST
    // ======================
    public function kelolaKost()
    {
        return view('admin.kost');
    }

    // ======================
    // UPDATE STATUS
    // ======================
    public function updateStatus($id)
    {
        $user = User::findOrFail($id);

        if ($user->status_akun == 'aktif') {
            $user->status_akun = 'ditolak';
        } else {
            $user->status_akun = 'aktif';
        }

        $user->save();

        return redirect()->back();
    }

    // ======================
    // AKTIFKAN AKUN
    // ======================
    public function aktifkan($id)
    {
        $user = User::findOrFail($id);

        $user->status_akun = 'aktif';
        $user->save();

        return redirect()->back()->with('success', 'Akun berhasil diaktifkan');
    }

    // ======================
    // TOLAK AKUN
    // ======================
    public function tolak($id)
    {
        $user = User::findOrFail($id);

        $user->status_akun = 'ditolak';
        $user->save();

        return redirect()->back()->with('success', 'Akun berhasil ditolak');
    }
     public function kelolaIklan()
    {
        $iklanPerTanggal = Kost::with('fotos')
            ->where('status_iklan', 'aktif')
            ->latest()
            ->get()
            ->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            });

        return view('admin.kelola-iklan', compact('iklanPerTanggal'));
    }

    public function hapusIklan($id)
    {
        $kost = Kost::findOrFail($id);

        // ubah status iklan
        $kost->status_iklan = 'dihapus';

        $kost->save();

        return redirect()->back()
            ->with('success', 'Iklan berhasil dihapus');
    }

    public function kelolaCustomer()
{
    $customers = User::where('role', 'costumer')
                    ->latest()
                    ->get();

    return view(
        'admin.kelola-customer',
        compact('customers')
    );
}

public function nonaktifCustomer($id)
{
    $user = User::findOrFail($id);

    $user->status_akun = 'nonaktif';
    $user->save();

    return back()->with(
        'success',
        'Customer berhasil dinonaktifkan'
    );
}

public function aktifCustomer($id)
{
    $user = User::findOrFail($id);

    $user->status_akun = 'aktif';
    $user->save();

    return back()->with(
        'success',
        'Customer berhasil diaktifkan'
    );
}

}