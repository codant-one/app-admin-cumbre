<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Landing\LandingController;

use App\Http\Controllers\Auth\Admin\{
    AuthController, 
    PasswordResetController
};

use App\Http\Controllers\Admin\{
    DashboardController,
    UserController,
    RolController,
    PlaceController,
    NewController,
    CategoryTypeController,
    CategoryController,
    PositionController,
    SponsorController,
    ConfigController,
    SpeakerController,
    ScheduleController,
    TalkController,
    ClientController
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

    Route::name('auth.')->group(function () {
        Route::get('/admin', [AuthController::class, 'login'])->name('admin.login');
        Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::get('/admin/forgot-password', [PasswordResetController::class, 'forgot_password'])->name('admin.forgot.password');
        Route::post('/admin/reset-confirm', [PasswordResetController::class, 'email_confirmation'])->name('admin.confirm');
        Route::get('/admin/reset-password', [PasswordResetController::class, 'reset_password'])->name('admin.reset.password');
        Route::post('/admin/change', [PasswordResetController::class, 'change'])->name("admin.change");
        Route::post('/admin/login', [AuthController::class, 'authenticate'])->name('admin.authenticate');
        Route::get('/admin/find/{token}', [PasswordResetController::class, 'find'])->name("admin.find");
    });

    Route::name('auth.admin.')->middleware(['auth'])->group(function () {
        Route::get('/admin/2fa', [AuthController::class, 'double_factor_auth'])->name('2fa');
        Route::get('/admin/2fa/generar', [AuthController::class, 'generate_double_factor_auth'])->name('2fa.generate');
        Route::post('/admin/2fa/validate', [AuthController::class, 'validate_double_factor_auth'])->name('2fa.validate');
    });

    Route::middleware(['auth'])->prefix('admin')->group(function () {

        /* RESOURCES */
        Route::resources([
            'users' => UserController::class,
            'roles' => RolController::class,
            'places' => PlaceController::class,
            'news' => NewController::class,
            'category-types' => CategoryTypeController::class,
            'categories' => CategoryController::class,
            'positions' => PositionController::class,
            'sponsors' => SponsorController::class,
            'speakers' => SpeakerController::class,
            'schedules' => ScheduleController::class,     
            'talks' => TalkController::class,
            'clients' => ClientController::class         
        ]);

        /* DASHBOARD */
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
            
        /* AUTH */
        Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

        /* CONFIG */
        Route::get('/map', [ConfigController::class, 'map'])->name('map');
        Route::post('/map', [ConfigController::class, 'mapUpdate'])->name('mapUpdate');
        Route::get('/translations', [ConfigController::class, 'translations'])->name('translations');
        Route::post('/translations', [ConfigController::class, 'translationsUpdate'])->name('translationsUpdate');

        /* CLIENTS */
        Route::get('/clients/upload', [ClientController::class, 'upload'])->name('upload');
        Route::post('/clients/uploadPost', [ClientController::class, 'uploadPost'])->name('uploadPost');

        /* DELETE MULTIPLE ELEMENTS */
        Route::post('/users/delete', [UserController::class, 'deleteUsers'])->name('users.delete');
        Route::post('/roles/delete', [RolController::class, 'deleteRoles'])->name('roles.delete');
        Route::post('/places/delete', [PlaceController::class, 'deletePlaces'])->name('places.delete');
        Route::post('/news/delete', [NewController::class, 'deleteNews'])->name('news.delete');
        Route::post('/category-types/delete', [CategoryTypeController::class, 'deleteCategoryTypes'])->name('category-types.delete');
        Route::post('/categories/delete', [CategoryController::class, 'deleteCategories'])->name('categories.delete');
        Route::post('/positions/delete', [PositionController::class, 'deletePositions'])->name('positions.delete');
        Route::post('/sponsors/delete', [SponsorController::class, 'deleteSponsors'])->name('sponsors.delete');
        Route::post('/speakers/delete', [SpeakerController::class, 'deleteSpeakers'])->name('speakers.delete');
        Route::post('/schedules/delete', [ScheduleController::class, 'deleteSchedules'])->name('schedules.delete');
        Route::post('/talks/delete', [TalkController::class, 'deleteTalks'])->name('talks.delete');
        Route::post('/clients/delete', [ClientController::class, 'deleteClients'])->name('clients.delete');
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

