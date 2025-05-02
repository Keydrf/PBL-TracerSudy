<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    LevelController,
    AlumniController,
    UserController,
    ProfesiController,
    KategoriProfesiController,
    AuthController,
    DashboardController,
    AlumniDataController,
    LandingController,
    LaporanController
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

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::view('/surveialumni', 'surveialumni.survei');
Route::view('/surveiperusahaan', 'surveiperusahaan.survei');
Route::get('/sebaran-profesi', [ProfesiController::class, 'sebaranProfesiView'])->name('sebaran.profesi');

Route::pattern('id', '[0-9]+');

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
    Route::post('/check-username', 'checkUsername')->name('check.username');
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'postlogin');
    Route::post('/logout', 'logout')->name('logout')->middleware('auth');
});

Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/admin', 'layouts_admin.isi');
    Route::get('/forbiddenError', function () {
        return view('auth.forbiddenError');
    });
    // Add the route for DashboardController
    // Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/api/alumni-data', [AlumniDataController::class, 'getAlumniData']);
    // Level Management Routes (Super Admin Only)
    Route::middleware(['authorize:superadmin'])->controller(LevelController::class)->group(function () {
        Route::prefix('level')->group(function () {
            Route::get('/', 'index');
            Route::post('/list', 'list');
            Route::get('/create', 'create');
            Route::post('/', 'store');
            Route::get('/{id}/edit', 'edit');
            Route::put('/{id}', 'update');
            Route::get('/{id}/delete_ajax', 'confirm_ajax');
            Route::delete('/{id}/delete_ajax', 'delete_ajax');
            Route::delete('/{id}', 'destroy');
        });
    });

    // User Management Routes (Super Admin Only)
    Route::middleware(['authorize:superadmin'])->controller(UserController::class)->group(function () {
        Route::prefix('user')->group(function () {
            Route::get('/', 'index');
            Route::post('/list', 'list');
            Route::get('/create', 'create');
            Route::post('/', 'store');
            Route::get('/{id}/edit', 'edit');
            Route::put('/{id}', 'update');
            Route::get('/{id}/delete_ajax', 'confirm_ajax');
            Route::delete('/{id}/delete_ajax', 'delete_ajax');
            Route::delete('/{id}', 'destroy');
        });
    });

    // Alumni and Profesi Management Routes (Super Admin and Admin)
    Route::middleware(['authorize:superadmin,admin'])->group(function () {

        Route::controller(LaporanController::class)->group(function () {
            Route::prefix('laporan')->group(function () {
                Route::get('/', 'index');
                Route::get('/tracer-study', 'tracerStudy');
                Route::get('/survei-kepuasan', 'surveiKepuasan');
                Route::get('/belum-tracer', 'belumTracer');
                Route::get('/belum-survei', 'belumSurvei');
            });
        });

        Route::controller(AlumniController::class)->group(function () {
            Route::prefix('alumni')->group(function () {
                Route::get('/', 'index');
                Route::post('/list', 'list');
                Route::get('/create', 'create');
                Route::post('/', 'store');
                Route::get('/{id}/edit', 'edit');
                Route::put('/{id}', 'update');
                Route::get('/{id}/delete_ajax', 'confirm_ajax');
                Route::delete('/{id}/delete_ajax', 'delete_ajax');
                Route::post('/import_ajax', 'import_ajax');
                Route::get('/import', 'import'); //ditambahkan
            });
        });

        Route::controller(KategoriProfesiController::class)->group(function () {
            Route::prefix('kategori')->group(function () {
                Route::get('/', 'index');
                Route::post('/list', 'list');
                Route::get('/create', 'create');
                Route::post('/', 'store');
                Route::get('/{id}', 'show');
                Route::get('/{id}/edit', 'edit');
                Route::put('/{id}', 'update');
                Route::get('/{id}/delete_ajax', 'confirm_ajax');
                Route::delete('/{id}/delete_ajax', 'delete_ajax');
            });
        });

        Route::controller(ProfesiController::class)->group(function () {
            Route::prefix('profesi')->group(function () {
                Route::get('/', 'index');
                Route::post('/list', 'list');
                Route::get('/create', 'create');
                Route::post('/', 'store');
                Route::get('/{id}', 'show');
                Route::get('/{id}/edit', 'edit');
                Route::put('/{id}', 'update');
                Route::get('/{id}/delete_ajax', 'confirm_ajax');
                Route::delete('/{id}/delete_ajax', 'delete_ajax');
            });
        });
    });
});
