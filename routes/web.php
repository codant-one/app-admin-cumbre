<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Landing\LandingController;

use App\Http\Controllers\Auth\Admin\{
    AuthController, 
    PasswordResetController
};

use App\Http\Controllers\Admin\{
    DashboardController,
    UserController
};

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

Route::middleware([
    'web'
])->group(function () {

    Route::group(['namespace' => 'Auth', 'as'=>'password.'], function () {
        Route::post('reset-confirm', [PasswordResetController::class, 'email_confirmation'])->name('confirm');
        Route::get('password/find/{token}', [PasswordResetController::class, 'find'])->name("find");
        Route::post('change', [PasswordResetController::class, 'change'])->name("change");
        Route::get('forgot-password', [PasswordResetController::class, 'forgot_password'])->name('client.forgot.password');
        Route::get('reset-password', [PasswordResetController::class, 'reset_password'])->name('client.reset.password');
    });

    Route::name('auth.')->group(function () {
        Route::get('/admin', [AuthController::class, 'login'])->name('admin.login');
        Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::get('/admin/forgot-password', [PasswordResetController::class, 'forgot_adminpassword'])->name('admin.forgot.password');
        Route::post('/admin/reset-confirm', [PasswordResetController::class, 'email_adminconfirmation'])->name('admin.confirm');
        Route::get('/admin/reset-password', [PasswordResetController::class, 'reset_adminpassword'])->name('admin.reset.password');
        Route::post('/admin/change', [PasswordResetController::class, 'admin_change'])->name("admin.change");
        Route::post('/admin/login', [AuthController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::name('auth.admin.')->middleware(['auth'])->group(function () {
        Route::get('/admin/2fa', [AuthController::class, 'double_factor_auth'])->name('2fa');
        Route::get('/admin/2fa/generar', [AuthController::class, 'generate_double_factor_auth'])->name('2fa.generate');
        Route::post('/admin/2fa/validate', [AuthController::class, 'validate_double_factor_auth'])->name('2fa.validate');
    });

    Route::middleware(['auth'])->prefix('admin')->group(function () {

        /* RESOURCES */
        Route::resources([
            'users' => UserController::class
        ]);

        /* DASHBOARD */
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
            
        /* AUTH */
        Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

    });

    // Localization
    Route::get('/js/lang.js', function () {
        $lang = 'es'; 

        $files   = glob(resource_path('lang/' . $lang . '/js_common.php'));
        $strings = [];

        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

        header('Content-Type: text/javascript');
        echo('window.lang = ' . json_encode($strings) . ';');
        exit();
    })->name('assets.lang');

    // Public
    Route::get('/', [LandingController::class, 'index'])->name('welcome');
    Route::get('/policy', [LandingController::class, 'policy'])->name('policy');
    Route::get('/terms', [LandingController::class, 'terms'])->name('terms');
    Route::get('/delete-account', [LandingController::class, 'delete_account'])->name('delete_account');
    Route::post('/delete-data', [LandingController::class, 'delete_data'])->name('delete_data');

});

