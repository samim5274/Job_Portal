<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Job\JobController;
use App\Http\Controllers\Job\JobApplicationController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ======================
// Public Routes
// ======================
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


// ======================
// Job Routes
// ======================
// Public
Route::get('/jobs', [JobController::class, 'index']);                      
Route::get('/jobs/{id}', [JobController::class, 'show']);                   
Route::get('/categories', [JobController::class, 'showCategory']);     
Route::get('/latest-jobs-8', [JobController::class, 'show8Jobs']);     

Route::post('/job-applications', [JobApplicationController::class, 'store']);

// Admin only (admin middleware)
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/jobs', [JobController::class, 'store']);         
    Route::delete('/jobs/{id}', [JobController::class, 'destroy']); 
});