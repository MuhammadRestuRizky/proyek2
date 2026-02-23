<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function verifikasiUser()
    {
        return view('admin.verifikasi');
    }

    public function approveUser($id)
    {
        //
    }

    public function kelolaKost()
    {
        return view('admin.kost');
    }

    public function updateStatus($id)
    {
        //
    }
}
