<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Storage;

class PemilikProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $paymentMethods = $user->paymentMethods;

        return view('pemilik.profile.edit', compact('user', 'paymentMethods'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'no_wa' => 'required',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Upload foto
        if ($request->hasFile('photo')) {

            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $path = $request->file('photo')->store('profiles', 'public');
            $user->photo = $path;
        }

        // Update profil user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->no_wa = $request->no_wa;
        $user->save();

        // Simpan / update metode pembayaran
        if ($request->payment_methods) {

            foreach ($request->payment_methods as $method) {

                if (!empty($method['method_name']) && !empty($method['account_number'])) {

                    PaymentMethod::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'method_name' => $method['method_name']
                        ],
                        [
                            'account_number' => $method['account_number'],
                            'is_active' => isset($method['is_active']) ? 1 : 0
                        ]
                    );
                }
            }
        }

        return back()->with('success', 'Profil pemilik berhasil diperbarui!');
    }
}