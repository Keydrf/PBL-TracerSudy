<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumniController;

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

Route::group(['prefix' => 'alumni'], function () {
    Route::get('/', [AlumniController :: class, 'index']);
    Route::post('/list', [AlumniController :: class, 'list']);
    Route::get('/create', [AlumniController :: class, 'create' ]);
    Route::post('/', [AlumniController :: class, 'store']);
    Route::get('/create_ajax', [AlumniController :: class, 'create_ajax' ]);
    Route::post('/ajax', [AlumniController :: class, 'store_ajax']);
    Route::get('/{id}', [AlumniController :: class, 'show']);
    Route::get('/{id}/edit', [AlumniController :: class, 'edit' ]);
    Route::put('/{id}', [AlumniController :: class, 'update']);
    Route::get('/{id}/edit_ajax', [AlumniController::class, 'edit_ajax']); //menampilkan halaman form edit Alumni ajax
    Route::put('/{id}/update_ajax', [AlumniController::class, 'update_ajax']); //menyimpan perubahan data Alumni ajax
    Route::get('/{id}/delete_ajax', [AlumniController::class, 'confirm_ajax']); //untuk menampilkan form confirm delete Alumni ajax
    Route::delete('/{id}/delete_ajax', [AlumniController::class, 'delete_ajax']); //menghapus data Alumni ajax
    Route::delete('/{id}', [AlumniController :: class, 'destroy' ]);
});

Route::get('/', function () {
    return view('layouts_lp.template');
});
