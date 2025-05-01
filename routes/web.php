<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfesiController;
use App\Http\Controllers\KategoriProfesiController;

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

use App\Http\Controllers\AuthController;

Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/check-username', [AuthController::class, 'checkUsername'])->name('check.username');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['auth'])
->group(function () { // artinya semua route di dalam group ini harus login dulu

    // masukkan semua route yang perlu autentikasi di sini
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
    
    Route::get('/admin', function () {
        return view('layouts_admin.isi');
    });
    
    Route::get('/surveialumni', function () {
        return view('surveialumni.survei');
    });
    
    Route::get('/surveiperusahaan', function () {
        return view('surveiperusahaan.survei');
    });
    
    Route::get('/sebaranprofesi', function () {
        return view('sebaranprofesi.index');
    });

    Route::middleware(['authorize:superadmin'])->group(function() {
        Route::group(['prefix' => 'level'], function () {
            Route::get('/', [LevelController :: class, 'index']);
            Route::post('/list', [LevelController :: class, 'list']);
            Route::get('/create', [LevelController :: class, 'create' ]);
            Route::post('/', [LevelController :: class, 'store']);
            Route::get('/{id}/edit', [LevelController :: class, 'edit' ]);
            Route::put('/{id}', [LevelController :: class, 'update']);
            Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); //menghapus data Level ajax
            Route::delete('/{id}', [LevelController :: class, 'destroy' ]);
        });
    
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController :: class, 'index']);
            Route::post('/list', [UserController :: class, 'list']);
            Route::get('/create', [UserController :: class, 'create' ]);
            Route::post('/', [UserController :: class, 'store']);
            Route::get('/{id}/edit', [UserController :: class, 'edit' ]);
            Route::put('/{id}', [UserController :: class, 'update']);
            Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); //menghapus data User ajax
            Route::delete('/{id}', [UserController :: class, 'destroy' ]);
        });
    });

    Route::middleware(['authorize:superadmin,admin'])->group(function() {
        Route::group(['prefix' => 'alumni'], function () {
            Route::get('/', [AlumniController :: class, 'index']);
            Route::post('/list', [AlumniController :: class, 'list']);
            Route::get('/create', [AlumniController :: class, 'create' ]);
            Route::post('/', [AlumniController :: class, 'store']);
            Route::get('/{id}/edit', [AlumniController :: class, 'edit' ]);
            Route::put('/{id}', [AlumniController :: class, 'update']);
            Route::get('/{id}/delete_ajax', [AlumniController::class, 'confirm_ajax']); //untuk menampilkan form confirm delete Alumni ajax
            Route::delete('/{id}/delete_ajax', [AlumniController::class, 'delete_ajax']);
            Route::post('/import_ajax', [AlumniController::class, 'import_ajax']);
        });

        Route::group(['prefix' => 'kategori'], function () {
            Route::get('/', [KategoriProfesiController :: class, 'index']);
            Route::post('/list', [KategoriProfesiController :: class, 'list']);
            Route::get('/create', [KategoriProfesiController :: class, 'create' ]);
            Route::post('/', [KategoriProfesiController :: class, 'store']);
            Route::get('/{id}', [KategoriProfesiController :: class, 'show']);
            Route::get('/{id}/edit', [KategoriProfesiController :: class, 'edit' ]);
            Route::put('/{id}', [KategoriProfesiController :: class, 'update']);
            Route::get('/{id}/delete_ajax', [KategoriProfesiController::class, 'confirm_ajax']); //untuk menampilkan form confirm delete KategoriProfesi ajax
            Route::delete('/{id}/delete_ajax', [KategoriProfesiController::class, 'delete_ajax']);
        });
    
        Route::group(['prefix' => 'profesi'], function () {
            Route::get('/', [ProfesiController :: class, 'index']);
            Route::post('/list', [ProfesiController :: class, 'list']);
            Route::get('/create', [ProfesiController :: class, 'create' ]);
            Route::post('/', [ProfesiController :: class, 'store']);
            Route::get('/{id}', [ProfesiController :: class, 'show']);
            Route::get('/{id}/edit', [ProfesiController :: class, 'edit' ]);
            Route::put('/{id}', [ProfesiController :: class, 'update']);
            Route::get('/{id}/delete_ajax', [ProfesiController::class, 'confirm_ajax']); //untuk menampilkan form confirm delete Profesi ajax
            Route::delete('/{id}/delete_ajax', [ProfesiController::class, 'delete_ajax']);
        });
    });
    
    Route::get('/', function () {
        return view('landingpage');
    });
    
    Route::get('/alumni/import', [AlumniController::class, 'import']);

});
