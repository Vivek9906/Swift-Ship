<?php

use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->get('/tracking/active-shipments', [TrackingController::class, 'activeShipments']);
