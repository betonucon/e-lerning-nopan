<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\MKController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\Auth\LogoutController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['prefix' => 'pdf','middleware'    => 'auth'],function(){
    Route::get('/',[ExampleController::class, 'index']);
});

Route::group(['middleware' => 'auth'], function() {
    /**
    * Logout Route
    */
    Route::get('/logout-perform', [LogoutController::class, 'perform'])->name('logout.perform');
 

    Route::group(['prefix' => 'master/siswa'],function(){
        Route::get('/', [SiswaController::class, 'index']);
        Route::post('/', [SiswaController::class, 'store']);
        Route::get('/modal', [SiswaController::class, 'modal']);
        Route::get('/proses_user', [SiswaController::class, 'proses_user']);
        Route::get('/delete_data', [SiswaController::class, 'delete_data']);
        Route::get('/get_data', [SiswaController::class, 'get_data']);
    });
    Route::group(['prefix' => 'master/guru'],function(){
        Route::get('/', [GuruController::class, 'index']);
        Route::post('/', [GuruController::class, 'store']);
        Route::get('/modal', [GuruController::class, 'modal']);
        Route::get('/delete_data', [GuruController::class, 'delete_data']);
        Route::get('/proses_user', [GuruController::class, 'proses_user']);
        Route::get('/get_data', [GuruController::class, 'get_data']);
    });
    Route::group(['prefix' => 'master/mk'],function(){
        Route::get('/', [MKController::class, 'index']);
        Route::post('/', [MKController::class, 'store']);
        Route::get('/modal', [MKController::class, 'modal']);
        Route::get('/delete_data', [MKController::class, 'delete_data']);
        Route::get('/get_data', [MKController::class, 'get_data']);
    });
    Route::group(['prefix' => 'soal'],function(){
        Route::get('/', [SoalController::class, 'index']);
        Route::post('/', [SoalController::class, 'store']);
        Route::get('/modal', [SoalController::class, 'modal']);
        Route::get('/delete_data', [SoalController::class, 'delete_data']);
        Route::get('/get_data', [SoalController::class, 'get_data']);
    });
    Route::group(['prefix' => 'materi'],function(){
        Route::get('/', [MateriController::class, 'index']);
        Route::post('/', [MateriController::class, 'store']);
        Route::post('/store_materi', [MateriController::class, 'store_materi']);
        Route::post('/forum', [MateriController::class, 'store_forum']);
        Route::get('/modal', [MateriController::class, 'modal']);
        Route::get('/modal_ujian', [MateriController::class, 'modal_ujian']);
        Route::get('/forum', [MateriController::class, 'forum']);
        Route::get('/view_forum', [MateriController::class, 'view_forum']);
        Route::get('/tutup_materi', [MateriController::class, 'tutup_materi']);
        Route::get('/get_data_tugas', [MateriController::class, 'get_data_tugas']);
        Route::get('/pilih_tugas', [MateriController::class, 'pilih_tugas']);
        Route::get('/pilih_ujian', [MateriController::class, 'pilih_ujian']);
        Route::get('/buka_materi', [MateriController::class, 'buka_materi']);
        Route::get('/tampil_forum', [MateriController::class, 'tampil_forum']);
        Route::get('/view', [MateriController::class, 'view_data']);
        Route::get('/lihat', [MateriController::class, 'lihat_data']);
        Route::get('/delete_data', [MateriController::class, 'delete_data']);
        Route::get('/delete_data_tugas', [MateriController::class, 'delete_data_tugas']);
        Route::get('/get_data', [MateriController::class, 'get_data']);
        Route::get('/get_data_materi', [MateriController::class, 'get_data_materi']);
    });
    Route::group(['prefix' => 'ujian'],function(){
        Route::get('/', [UjianController::class, 'index']);
        Route::post('/', [UjianController::class, 'store']);
        Route::post('/forum', [UjianController::class, 'store_forum']);
        Route::get('/modal', [UjianController::class, 'modal']);
        Route::get('/forum', [UjianController::class, 'forum']);
        Route::get('/tutup_materi', [UjianController::class, 'tutup_materi']);
        Route::get('/buka_materi', [UjianController::class, 'buka_materi']);
        Route::get('/tampil_forum', [UjianController::class, 'tampil_forum']);
        Route::get('/view', [UjianController::class, 'view_data']);
        Route::get('/lihat', [UjianController::class, 'lihat_data']);
        Route::get('/delete_data', [UjianController::class, 'delete_data']);
        Route::get('/get_data', [UjianController::class, 'get_data']);
        Route::get('/get_data_siswa', [UjianController::class, 'get_data_siswa']);
    });
    Route::group(['prefix' => 'tugas'],function(){
        Route::get('/', [TugasController::class, 'index']);
        Route::post('/', [TugasController::class, 'store']);
        Route::post('/forum', [TugasController::class, 'store_forum']);
        Route::get('/modal', [TugasController::class, 'modal']);
        Route::get('/forum', [TugasController::class, 'forum']);
        Route::get('/get_data_nomor', [TugasController::class, 'get_data_nomor']);
        Route::get('/tutup_materi', [TugasController::class, 'tutup_materi']);
        Route::get('/buka_materi', [TugasController::class, 'buka_materi']);
        Route::get('/tampil_forum', [TugasController::class, 'tampil_forum']);
        Route::get('/view', [TugasController::class, 'view_data']);
        Route::get('/lihat', [TugasController::class, 'lihat_data']);
        Route::get('/delete_data', [TugasController::class, 'delete_data']);
        Route::get('/get_data', [TugasController::class, 'get_data']);
        Route::get('/get_data_siswa', [TugasController::class, 'get_data_siswa']);
    });
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
