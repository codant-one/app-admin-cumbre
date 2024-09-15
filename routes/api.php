<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Testing\TestingController;

use App\Http\Controllers\Auth\{
    AuthController,
    PasswordResetController
};

use App\Http\Controllers\{
    MiscellaneousController
};

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

Route::group([
    'prefix' => 'auth',
    'middleware' => 'cors'
], function () {
    Route::post('login', [AuthController::class , 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);
    Route::post('forgot-password', [PasswordResetController::class, 'forgot_password'])->name('forgot.password');
    Route::get('password/find', [PasswordResetController::class, 'find'])->name("find");
    Route::post('change', [PasswordResetController::class, 'change'])->name("change");

    Route::middleware('jwt')->group(function () {
        Route::post('logout', [AuthController::class , 'logout'])->name('logout');
    });
});

//Testing Endpoints
Route::get('notifications', [TestingController::class , 'notifications'])->name('notifications');
Route::get('forgot_password', [TestingController::class , 'forgot_password'])->name('forgot_password');
Route::get('reset_password', [TestingController::class , 'reset_password'])->name('reset_password');

//public Endpoints
Route::get('home', [MiscellaneousController::class , 'home'])->name('home');
Route::get('sponsors', [MiscellaneousController::class , 'sponsors'])->name('sponsors');
Route::get('places', [MiscellaneousController::class , 'places'])->name('places');
Route::get('places/{id}', [MiscellaneousController::class , 'place_details'])->name('place_details');
Route::get('news', [MiscellaneousController::class , 'news'])->name('news');
Route::get('news/{id}', [MiscellaneousController::class , 'new_details'])->name('new_details');