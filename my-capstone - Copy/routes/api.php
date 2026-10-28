<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\AppointmentController;

// API Routes (public for now, authentication will be added back later)
Route::apiResource('appointments', AppointmentController::class);

Route::middleware('auth:sanctum')->group(function () {
    // Route::apiResource('appointments', AppointmentController::class);
});

