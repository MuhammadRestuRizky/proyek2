<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Kost;
use App\Models\KostFoto;
use App\Models\Fasilitas;
use Illuminate\Support\Facades\Storage;

class KostController extends Controller
{

public function login(Request $request)
{
    Auth::logout(); // 🔥 ini penting

    if (Auth::attempt($request->only('email', 'password'))) {

        $user = Auth::user();

        if ($user->role == 'pemilik') {
            return redirect('pemilik.dashboard');
        }

        if ($user->role == 'customer') {
            return redirect('/');
        }
    }

    return back()->with('error', 'Login gagal');
}


    public function index(Request $request)
    {
        $query = Kost::with('fasilitas')->where('status', 'Tersedia');

        // 🔍 SEARCH
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_kost', 'like', '%' . $request->q . '%')
                  ->orWhere('alamat', 'like', '%' . $request->q . '%');
            });
        }

        // 👤 FILTER GENDER
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // 🚿 FILTER KAMAR MANDI
        if ($request->filled('kamar_mandi')) {
            $query->where('kamar_mandi', $request->kamar_mandi);
        }

        // 💰 FILTER HARGA
        if ($request->filled('min_harga') && $request->filled('max_harga')) {
            $query->whereBetween('harga', [
                $request->min_harga,
                $request->max_harga
            ]);
        }

        // 📦 PAGINATION (FIX: jangan overwrite lagi)
        $kosts = $query->latest()->paginate(9)->withQueryString();

        // ⚡ AJAX
        if ($request->ajax()) {
            return view('kost.partials.list', compact('kosts'))->render();
        }

        return view('welcome', compact('kosts'));
    }

    public function show($id)
    {
        $kost = Kost::with(['fasilitas', 'fotos'])
            ->where('status', 'Tersedia')
            ->findOrFail($id);

        return view('kost.show', compact('kost'));
    }

    // ✅ TAMBAHKAN DI SINI
    public function booking($id)
    {
        $kost = Kost::with(['fotos','fasilitas','pemilik'])->findOrFail($id);
        return view('booking', compact('kost'));
    }

    // ✅ DASHBOARD PEMILIK
    public function dashboardPemilik()
    {
        if (auth()->user()->role !== 'pemilik') {
            abort(403);
        }

        $kosts = Kost::with('fotos')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('pemilik.dashboard', compact('kosts'));
    }

    // FORM CREATE
    public function create()
    {
        $fasilitas = Fasilitas::all(); // 🔥 ambil dari DB
        return view('pemilik.create', compact('fasilitas'));
    }

    

    // SIMPAN DATA
    public function store(Request $request)
    {

        $request->validate([
            'nama_kost' => 'required',
            'alamat' => 'required',
            'harga' => 'required|numeric',
            'gender' => 'required',
            'deskripsi' => 'required',
            'foto.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if (!$request->hasFile('foto')) {
        return back()->with('error', 'Foto wajib diupload');
    }

        // 🔥 SIMPAN DATA KOST DULU (WAJIB DI ATAS)
        $kost = Kost::create([
            'user_id' => auth()->id(),
            'nama_kost' => $request->nama_kost ?? $request->nama,
            'alamat' => $request->alamat,
            'harga' => $request->harga,
            'gender' => $request->gender,
            'kamar_mandi' => $request->kamar_mandi,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi,
            'maps' => $request->maps // 🔥 tambah maps
        ]);

        // 🔥 MULTI FOTO (FIX TOTAL)
    if ($request->hasFile('foto')) {

        $primaryIndex = $request->primary_index ?? 0;

        foreach ($request->file('foto') as $i => $file) {

            $path = $file->store('kost', 'public');

            $kost->fotos()->create([
                'foto' => $path,
                'is_primary' => ($i == $primaryIndex) ? 1 : 0
            ]);
        }
}

        // 🔥 FASILITAS
        if ($request->fasilitas) {
            $kost->fasilitas()->sync($request->fasilitas);
        }

        return redirect()->route('pemilik.dashboard')
        ->with('success', 'Iklan berhasil dibuat!');
    }
        public function edit($id)
    {
        $kost = Kost::with(['fotos', 'fasilitas'])
        ->where('user_id', auth()->id()) // 🔥 SECURITY
        ->findOrFail($id);
        $fasilitas = Fasilitas::all();

        return view('pemilik.kost.edit', compact('kost', 'fasilitas'));
    }

    public function update(Request $request, $id)
    {
        $kost = Kost::where('user_id', auth()->id())
        ->findOrFail($id);

        // VALIDASI
        $request->validate([
            'nama_kost' => 'required|max:255',
            'alamat' => 'required',
            'harga' => 'required|numeric',
            'gender' => 'required',
            'status' => 'required|in:Tersedia,Habis',
            'kamar_mandi' => 'required|in:Dalam,Luar',
            'foto.*' => 'image|mimes:jpg,jpeg,png|max:2048' // 🔥 TAMBAH INI
    ]);

        // UPDATE DATA
        $kost->update([
            'nama_kost' => $request->nama_kost,
            'alamat' => $request->alamat,
            'harga' => $request->harga,
            'gender' => $request->gender,
            'kamar_mandi' => $request->kamar_mandi,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'maps' => $request->maps
        ]);

        // 🔥 TAMBAH FOTO BARU (INI YANG KURANG)
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('kost', 'public');

                $kost->fotos()->create([
                    'foto' => $path,
                    'is_primary' => 0
                ]);
            }
        }

        return redirect()
            ->route('pemilik.dashboard')
            ->with('success', 'Kost berhasil diupdate!');
    }

    // ✅ HAPUS IKLAN
        public function destroy($id)
        {
            $kost = Kost::where('user_id', auth()->id())
                ->with('fotos')
                ->findOrFail($id);

            // 🔥 HAPUS FOTO DARI STORAGE
            foreach ($kost->fotos as $foto) {
                Storage::disk('public')->delete($foto->foto);
            }
            $kost->delete();
            return back()->with('success', 'Iklan berhasil dihapus');
        }

        // ✅ HAPUS FOTO DALAM EDIT IKLAN
        public function destroyFoto($id)
        {
            $foto = KostFoto::with('kost')->findOrFail($id);

             // 🔐 pastikan milik user
            if ($foto->kost->user_id != auth()->id()) {
                return response()->json(['success' => false], 403);
            }

            // hapus file dari storage (disk public)
            if (Storage::disk('public')->exists($foto->foto)) {
                Storage::disk('public')->delete($foto->foto);
            }

            // hapus dari database
            $foto->delete();

            return response()->json([
            'success' => true
        ]);
        }

}