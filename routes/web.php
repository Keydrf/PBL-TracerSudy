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
    LaporanController,
    AlumniSurveyController,
    SurveiPerusahaanController,
    // PerusahaanController
};
use Illuminate\Support\Facades\Mail;
use App\Mail\KirimEmail;

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
// Route::get('/populate', [PerusahaanController::class, 'populate'])->name('pop');
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::controller(AlumniSurveyController::class)->group(function () {
    // Halaman utama survei alumni
    Route::get('/surveialumni', 'create')->name('alumni.survey.create');
    
    // Menyimpan data survei alumni
    Route::post('/surveialumni', 'store')->name('alumni.survey.store');
    
    // API untuk pencarian alumni - Pastikan route ini benar
    Route::get('/api/alumni/search', 'search')->name('api.alumni.search');
});





// Survey Routes
Route::get('/surveiperusahaan', [SurveiPerusahaanController::class, 'create'])->name('survei.perusahaan.create');
Route::post('/surveiperusahaan', [SurveiPerusahaanController::class, 'store'])->name('survei.perusahaan.store');
// Route::resource('perusahaan', PerusahaanController::class);

// API Route for Alumni Search
Route::get('/api/alumni/search-for-survey', [SurveiPerusahaanController::class, 'searchAlumni'])->name('api.alumni.search-for-survey');
Route::get('/sebaran-profesi', [ProfesiController::class, 'sebaranProfesiView'])->name('sebaran.profesi');
Route::get('/perusahaan/{id}', [App\Http\Controllers\SurveiPerusahaanController::class, 'getPerusahaanData']);

Route::get('locale/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('locale');

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::view('/dashboard', 'dashboard')->name('dashboard');
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

        // Route::controller(PerusahaanController::class)->group(function () {
        //     Route::prefix('perusahaan')->group(function () {
        //         Route::get('/', 'index')->name('perusahaan.index');
        //         Route::post('/list', 'list');
        //         // Route::get('/populate', 'populate');
        //     });
        // });

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


Route::get('/kirim-email', function () {
    Mail::to('arindrakeysha@gmail.com')->send(new \App\Mail\KirimEmail("Tes email dari localhost!"));
    return "Email sudah dikirim!";
});
