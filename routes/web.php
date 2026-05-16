<?php

use App\Http\Controllers\CarrierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;        // ADD THIS
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

// ── ADD THIS: Public homepage ────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ── ADD THIS: Public standalone track form ───────────────────────────────────
Route::get('/track-form', [TrackingController::class, 'publicTrackForm'])->name('track.form');

// EXISTING CODE UNCHANGED
Route::get('/track', [TrackingController::class, 'lookup'])->name('tracking.lookup');
Route::post('/track', [TrackingController::class, 'redirectToShipment'])->name('tracking.lookup.submit');
Route::get('/track/{trackingNumber}', [TrackingController::class, 'publicShow'])->name('tracking.public.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/shipments/bulk', [ShipmentController::class, 'bulk'])
        ->middleware('role:admin,manager')
        ->name('shipments.bulk');
    Route::resource('shipments', ShipmentController::class);

    Route::resource('customers', CustomerController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('carriers', CarrierController::class)->only(['index', 'show']);

    Route::get('/tracking/live-map', [TrackingController::class, 'liveMap'])->name('tracking.live-map');
    Route::get('/tracking/active-shipments', [TrackingController::class, 'activeShipments'])->name('tracking.active');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/{id}/snooze', [NotificationController::class, 'snooze'])->name('notifications.snooze');

    Route::view('/settings', 'settings.index')->name('settings');
});

require __DIR__.'/auth.php';
