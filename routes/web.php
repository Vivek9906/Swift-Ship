<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\ContactLeadController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\CustomerAuthController;
use Illuminate\Support\Facades\Route;

// -- Public pages
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public tracking
Route::get('/track', [TrackingController::class, 'lookup'])->name('tracking.lookup');
Route::post('/track', [TrackingController::class, 'redirectToShipment'])->name('tracking.lookup.submit');
Route::get('/track/{trackingNumber}', [TrackingController::class, 'publicShow'])->name('tracking.public.show');

// Contact Sales (public AJAX)
Route::post('/contact-leads', [ContactLeadController::class, 'store'])->name('contact.store');

// AJAX fare calculation
Route::post('/api/fare', [BookingController::class, 'calculateFare'])->name('booking.fare');

// -- CUSTOMER AUTHENTICATION
Route::middleware('guest')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'login'])->name('login.post');
    Route::get('/register', [CustomerAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'register'])->name('register.post');
});
Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout')->middleware('auth');

// -- CUSTOMER PORTAL (prefix: /customer, names: customer.*)
Route::middleware(['auth', 'customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/shipments', [CustomerDashboardController::class, 'shipments'])->name('shipments');
        Route::get('/shipments/{id}', [CustomerDashboardController::class, 'shipmentDetail'])->name('shipment.detail');
        Route::post('/shipments/{id}/cancel', [CustomerDashboardController::class, 'cancelShipment'])->name('shipment.cancel');
        Route::get('/profile', [CustomerDashboardController::class, 'profile'])->name('profile');
        Route::put('/profile', [CustomerDashboardController::class, 'updateProfile'])->name('profile.update');
    });

// Customer booking & payment (no prefix, scoped to customer auth)
Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/shipments/pay', [BookingController::class, 'pay'])->name('customer.shipments.pay');
    Route::get('/shipments/new', [BookingController::class, 'create'])->name('customer.shipments.new');
    Route::post('/shipments', [BookingController::class, 'store'])->name('customer.shipments.store');
    Route::get('/shipments/{id}/confirmation', [BookingController::class, 'confirmation'])->name('customer.shipments.confirmation');
    Route::post('/shipments/stripe-checkout', [BookingController::class, 'stripeCheckout'])->name('customer.shipments.stripe-checkout');
    Route::get('/shipments/stripe-success', [BookingController::class, 'stripeSuccess'])->name('customer.shipments.stripe-success');
    Route::post('/shipments/pay-simulate', [BookingController::class, 'simulatePaymentSuccess'])->name('customer.shipments.pay-simulate');
    Route::get('/shipments/{id}/resume-payment', [BookingController::class, 'resumePayment'])->name('customer.shipments.resume-payment');
    Route::delete('/shipments/{id}/delete', [CustomerDashboardController::class, 'deleteShipment'])->name('customer.shipments.delete');
});

// Stripe Webhook
Route::post('stripe/webhook', [\App\Http\Controllers\StripeController::class, 'webhook'])->name('stripe.webhook');

// -- ADMIN / STAFF PORTAL (prefix: /admin)
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        Route::post('/shipments/bulk', [ShipmentController::class, 'bulk'])->name('shipments.bulk');
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

        Route::get('/leads', [ContactLeadController::class, 'index'])->name('admin.leads.index');
        Route::patch('/leads/{lead}/status', [ContactLeadController::class, 'updateStatus'])->name('admin.leads.status');
    });

// -- ADMIN AUTH (separate login at /admin/login)
require __DIR__ . '/auth.php';
