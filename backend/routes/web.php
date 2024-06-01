<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VerificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/verification/success', [VerificationController::class, 'success'])->name('verification.success');
Route::get('/verification/already-verified', [VerificationController::class, 'alreadyVerified'])->name('verification.already_verified');
Route::get('/verification/user-not-found', [VerificationController::class, 'userNotFound'])->name('verification.user_not_found');
Route::get('/verification/invalid-link', [VerificationController::class, 'invalidLink'])->name('verification.invalid_link');
