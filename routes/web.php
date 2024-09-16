<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Landing\LandingController;
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
Route::get('/', [LandingController::class, 'index'])->name('welcome');
Route::get('/policy', [LandingController::class, 'policy'])->name('policy');
Route::get('/terms', [LandingController::class, 'terms'])->name('terms');
Route::get('/delete-account', [LandingController::class, 'delete_account'])->name('delete_account');
Route::post('/delete-data', [LandingController::class, 'delete_data'])->name('delete_data');

