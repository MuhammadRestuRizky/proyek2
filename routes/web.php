<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PemilikProfileController;

require __DIR__.'/auth.php';
// =====================
// REGISTER
// =====================
// pencari kost
Route::get('/register', function () {
    return view('auth.register_user');
})->name('register');

Route::post('/register', [AuthController::class, 'registerUser']);

// pemilik kost
Route::get('/register-pemilik', function () {
    return view('auth.register_pemilik');
});

Route::post('/register-pemilik', [AuthController::class, 'registerPemilik']);


// =====================
// LOGIN (UI TERPISAH, BACKEND SAMA)
// =====================
// login pencari
Route::get('/login', function () {
    return view('auth.login_user');
})->name('login');

// login pemilik (UI saja beda)
Route::get('/login-pemilik', function () {
    return view('auth.login_pemilik');
})->name('login.pemilik');

Route::get('/login-admin', function () {
    return view('auth.login_admin');
})->name('login.admin');


// 🔥 LOGIN UNIVERSAL (INI YANG DIPAKAI)
Route::post('/login', [AuthController::class, 'login']);


// 🔥 LOGOUT
Route::post('/logout', [AuthController::class, 'logout'])
->middleware('auth')
->name('logout');

/*
|------------------------------------------------------------------
| router costumer
|------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:costumer'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // detail kost
    Route::get('/kost/{id}', [KostController::class, 'show'])->name('kost.detail');
    Route::get('/booking/{id}', [KostController::class, 'booking'])->name('booking.create');
    Route::post('/booking', [KostController::class, 'storeBooking'])->name('booking.store');
    Route::get('/booking/detail/{id}', [KostController::class, 'showBooking'])->name('booking.show');
});
/*
|------------------------------------------------------------------
| PROFILE PEMILIK
|------------------------------------------------------------------
*/
Route::prefix('pemilik')
    ->middleware(['auth', 'role:pemilik'])
    ->group(function () {

        Route::get('/profile', [PemilikProfileController::class, 'edit'])->name('pemilik.profile.edit');
        Route::patch('/profile', [PemilikProfileController::class, 'update'])->name('pemilik.profile.update');

});
/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
// homepage
Route::get('/', [KostController::class, 'index'])->name('home');

// pencarian (harus login)
Route::get('/kost', [KostController::class, 'index'])
    ->middleware('auth')->name('dashboard')
    ->name('kost.index');

// detail kost
// Route::get('/kost/{id}', [KostController::class, 'show'])->name('kost.detail');


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
// redirect otomatis
Route::get('/dashboard', function () {

    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login');
    }

    if ($user->role == 'admin') {
        return redirect('/admin/dashboard');
    }

    if ($user->role == 'pemilik') {
        return redirect()->route('dashboard.pemilik');
    }

    if ($user->role == 'costumer') {
        return redirect('/');
    }
    // fallback
    return abort(403);

})->middleware('auth');

Route::delete('/pemilik/foto/{id}', [KostController::class, 'destroyFoto'])
->name('pemilik.foto.destroy');

// ==============================
// DASHBOARD PEMILIK
// ==============================
Route::prefix('pemilik')
    ->name('pemilik.')
    ->middleware(['auth', 'role:pemilik'])
    ->group(function () {

    Route::get('/dashboard', [KostController::class, 'dashboardPemilik'])
        ->name('dashboard');

    Route::resource('kost', KostController::class);

});

// halaman dashboard admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth')->name('admin.dashboard');