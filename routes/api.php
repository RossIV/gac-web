<?php

use App\Http\Controllers\API\AffiliationController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\EventRegistrationController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\PaymentMethodController;
use App\Http\Controllers\API\SignatureController;
use App\Http\Controllers\API\TeamController;
use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::name('api.')->group(function() {
    Route::name('auth.')->prefix('auth')->group(function() {
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('register', [AuthController::class, 'register'])->name('register');
    });

    Route::post('signatures/callback', [SignatureController::class, 'callback']);

    Route::group(['middleware' => ['auth:sanctum']], function() {
        Route::resource('affiliations', AffiliationController::class);
        Route::resource('events', EventController::class);
        Route::resource('eventRegistrations', EventRegistrationController::class);
        Route::resource('payments', PaymentController::class);
        Route::resource('paymentMethods', PaymentMethodController::class);
        Route::resource('signatures', SignatureController::class);
        Route::resource('teams', TeamController::class);
        Route::resource('users', UserController::class);
        Route::get('user', [UserController::class, 'showSelf']);
    });
});
