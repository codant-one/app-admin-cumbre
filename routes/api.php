<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Testing\TestingController;

use App\Http\Controllers\Auth\Api\ {
    AuthController,
    PasswordResetController
};

use App\Http\Controllers\{
    MiscellaneousController,
    UserController
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

Route::middleware('throttle:200,1')->group(function () {
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

            Route::post('/profile/user', [UserController::class, 'profile'])->name('profile');
            Route::post('/profile/user/updatePassword', [UserController::class, 'updatePassword'])->name('updatePassword');
        });
    });

    //private Endpoints
    Route::middleware('jwt')->group(function () {
        // Questions
        Route::get('questions/talk/{id}', [MiscellaneousController::class , 'allQuestions'])->name('allQuestions');
        Route::post('questions', [MiscellaneousController::class , 'question'])->name('question');
        Route::get('questions/{id}', [MiscellaneousController::class , 'question_details'])->name('question_details');

        // Reviews
        Route::get('reviews/talk/{id}', [MiscellaneousController::class , 'allReviews'])->name('allReviews');
        Route::post('reviews', [MiscellaneousController::class , 'review'])->name('review');
        Route::get('reviews/{id}', [MiscellaneousController::class , 'review_details'])->name('review_details');

        // Favorites
        Route::get('favorites', [MiscellaneousController::class , 'allFavorites'])->name('allFavorites');
        Route::post('favorites', [MiscellaneousController::class , 'favorite'])->name('favorite');

        // Translations
        Route::get('translations', [MiscellaneousController::class , 'translations'])->name('translations');

        // Maps
        Route::get('maps', [MiscellaneousController::class , 'maps'])->name('maps');

        // Notifications
        Route::get('notifications', [MiscellaneousController::class , 'notifications'])->name('notifications');
        Route::post('notifications', [MiscellaneousController::class , 'notification'])->name('notification');

        // Maps
        Route::get('lang', [MiscellaneousController::class , 'lang'])->name('lang');
    });

    //Testing Endpoints
    Route::get('notifications_', [TestingController::class , 'notifications'])->name('notifications');
    Route::get('forgot_password', [TestingController::class , 'forgot_password'])->name('forgot_password');
    Route::get('reset_password', [TestingController::class , 'reset_password'])->name('reset_password');

    //public Endpoints
    Route::get('home', [MiscellaneousController::class , 'home'])->name('home');
    Route::get('sponsors', [MiscellaneousController::class , 'sponsors'])->name('sponsors');
    Route::get('places', [MiscellaneousController::class , 'places'])->name('places');
    Route::get('places/{id}', [MiscellaneousController::class , 'place_details'])->name('place_details');
    Route::get('news', [MiscellaneousController::class , 'news'])->name('news');
    Route::get('news/{id}', [MiscellaneousController::class , 'new_details'])->name('new_details');
    Route::get('schedules', [MiscellaneousController::class , 'schedules'])->name('schedules');
    Route::get('schedules/{id}', [MiscellaneousController::class , 'schedule_details'])->name('schedule_details');
    Route::get('talk/{id}', [MiscellaneousController::class , 'talk_details'])->name('talk_details');
    Route::get('speakers', [MiscellaneousController::class , 'speakers'])->name('schedules');
    Route::get('speakers/{id}', [MiscellaneousController::class , 'speaker_details'])->name('speaker_details');
    Route::post('tokens', [MiscellaneousController::class , 'tokens'])->name('tokens');

});