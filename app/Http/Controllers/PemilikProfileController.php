<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PemilikProfileController extends Controller
{
    public function edit()
    {
        return view('pemilik.profile.edit');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'no_wa' => 'required',
            'photo' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('photo')) {

            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $path = $request->file('photo')->store('profiles', 'public');
            $user->photo = $path;
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_wa' => $request->no_wa,
        ]);

        return back()->with('success', 'Profil pemilik berhasil diperbarui!');
    }
}