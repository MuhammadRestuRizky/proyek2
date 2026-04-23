<?php

use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    // ❌ LOGIN & REGISTER DIHAPUS (PAKAI CUSTOM DI web.php)

    // =====================
    // LUPA PASSWORD
    // =====================
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});


Route::middleware('auth')->group(function () {

    // =====================
    // VERIFIKASI EMAIL
    // =====================
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // =====================
    // KONFIRM PASSWORD
    // =====================
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // =====================
    // UPDATE PASSWORD
    // =====================
    Route::put('password', [PasswordController::class, 'update'])
        ->name('password.update');

    // =====================
    // LOGOUT (MASIH DIPAKAI)
    // =====================
    Route::post('logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // =====================
    // PROFILE
    // =====================
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});