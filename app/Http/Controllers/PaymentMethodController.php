<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'method_name' => 'required',
            'account_number' => 'required',
        ]);

        PaymentMethod::create([
            'user_id' => auth()->id(),
            'method_name' => $request->method_name,
            'account_number' => $request->account_number,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return back()->with('success', 'Metode pembayaran berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $payment = PaymentMethod::findOrFail($id);

        if ($payment->user_id != auth()->id()) {
            abort(403);
        }

        $payment->delete();

        return back()->with('success', 'Metode pembayaran berhasil dihapus');
    }
}