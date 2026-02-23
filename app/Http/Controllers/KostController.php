<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost;

class KostController extends Controller
{
    public function index(Request $request)
    {
        $query = Kost::where('status', 'Tersedia');

        // Search lokasi / nama
        if ($request->q) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->q . '%')
                  ->orWhere('alamat', 'like', '%' . $request->q . '%');
            });
        }

        // Filter gender
        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        // Filter AC / Non AC
        if ($request->ac !== null && $request->ac !== '') {
            $query->where('ac', $request->ac);
        }

        // Filter harga
        if ($request->harga) {
            if ($request->harga === '2000000+') {
                $query->where('harga', '>=', 2000000);
            } else {
                [$min, $max] = explode('-', $request->harga);
                $query->whereBetween('harga', [$min, $max]);
            }
        }

        $kosts = $query->latest()->paginate(9);

        // Dipakai oleh welcome & kost.index
        return view(
            request()->is('/') ? 'welcome' : 'kost.index',
            compact('kosts')
        );
    }

    public function show($id)
    {
        $kost = Kost::where('status','Tersedia')->findOrFail($id);
        return view('kost.show', compact('kost'));
    }
}
