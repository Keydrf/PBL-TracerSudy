<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\UserController;

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

Route::group(['prefix' => 'alumni'], function () {
    Route::get('/', [AlumniController :: class, 'index']);
    Route::post('/list', [AlumniController :: class, 'list']);
    Route::get('/create', [AlumniController :: class, 'create' ]);
    Route::post('/', [AlumniController :: class, 'store']);
    // Route::get('/{id}', [AlumniController :: class, 'show']);
    Route::get('/{id}/edit', [AlumniController :: class, 'edit' ]);
    Route::put('/{id}', [AlumniController :: class, 'update']);
    Route::get('/{id}/delete_ajax', [AlumniController::class, 'confirm_ajax']); //untuk menampilkan form confirm delete Alumni ajax
    Route::delete('/{id}/delete_ajax', [AlumniController::class, 'delete_ajax']);
    
    Route::post('/import_ajax', [AlumniController::class, 'import_ajax']);
    // Route::get('/import', [AlumniController::class, 'import']);
    // Route::post('/import-', [AlumniController::class, 'import']);
});

Route::group(['prefix' => 'kategori-profesi'], function () {
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
    Route::get('/', [ProfesiController::class, 'index']);           // Menampilkan semua profesi
    Route::get('/create', [ProfesiController::class, 'create']);    // Form untuk membuat profesi baru
    Route::post('/', [ProfesiController::class, 'store']);          // Menyimpan profesi baru
    Route::get('/{id}/edit', [ProfesiController::class, 'edit']);   // Form untuk mengedit profesi
    Route::put('/{id}', [ProfesiController::class, 'update']);      // Mengupdate profesi
    Route::get('/{id}', [ProfesiController::class, 'show']);        // Menampilkan detail profesi
    Route::delete('/{id}', [ProfesiController::class, 'destroy']);  // Menghapus profesi
    Route::delete('/profesi/{id}/delete_ajax', [ProfesiController::class, 'delete_ajax']);

});

Route::get('/', function () {
    return view('landingpage');
});

Route::get('/alumni/import', [AlumniController::class, 'import']);
