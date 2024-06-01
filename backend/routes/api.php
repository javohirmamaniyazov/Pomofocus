<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\ResetPasswordController;
use App\Http\Controllers\Api\SetPasswordController;
use App\Http\Controllers\Api\SocialiteController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\VerificationController;
use App\Http\Controllers\Api\TimerSettingController;
use App\Http\Controllers\Api\ThemeController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Auth;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    // User Section
    Route::get('logout', [AuthController::class, 'logout']);
    Route::apiResource('/users', UserController::class);
    Route::put('profile/update', [UserController::class, 'update']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // notifications
    Route::apiResource('notifications', NotificationController::class);
    
    // Timer section
    Route::apiResource('timer-settings', TimerSettingController::class);
    
    // Changing color section
    Route::apiResource('themes', ThemeController::class);

    // Task section
    Route::resource('tasks', TaskController::class)->except(['create', 'edit']);
    Route::get('tasks/active/{id}', [TaskController::class, 'active']);
    Route::get('tasks/finished/{id}', [TaskController::class, 'finished']);
    Route::get('tasks/filtered/{id}', [TaskController::class, 'isFiltered']);
    Route::put('tasks/{id}/update-order-number', [TaskController::class, 'updateOrderNumber']);
    Route::delete('tasks/{id}', [TaskController::class, 'destroy']);
    Route::put('tasks/{id}', [TaskController::class, 'update']);
});



Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
// Email Verification section
Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');

// Email is Verified section
Route::middleware('auth:sanctum')->get('/user/email-verified', function (Request $request) {
    return $request->user()->hasVerifiedEmail();
});

// Authentication with google
Route::get('/auth/{provider}', [SocialiteController::class,'redirectToProvider']);
Route::get('/auth/{provider}/callback', [SocialiteController::class,'handleProviderCallback']);

// Setting password section
Route::post('password/set', [SetPasswordController::class, 'set'])->name('password.updatePassword');

// Forgot password section
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

