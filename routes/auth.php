<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/admin/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('admin.logout');
