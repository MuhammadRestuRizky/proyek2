<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CheckUserExists
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = User::find(Auth::id());

            // ❌ kalau user sudah dihapus dari database
            if (!$user) {
                Auth::logout(); // paksa logout
                return redirect('/login')
                    ->with('error', 'Akun tidak ditemukan, silakan login ulang');
            }
        }

        return $next($request);
    }
}