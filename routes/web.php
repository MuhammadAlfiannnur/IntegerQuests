<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvaluasiController;
use App\Http\Controllers\HalamanGuruController;
use App\Http\Controllers\AuthController;

// Halaman Utama 
Route::get('/', function () {
    return view('beranda');
})->name('beranda');

// CHANGED: Updated login route to use AuthController
Route::post('/login', [AuthController::class, 'login'])->name('login');

// NEW: Added logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Evaluasi
Route::prefix('evaluasi')->group(function () {
    Route::get('/', [EvaluasiController::class, 'tampilkanEvaluasi'])->name('evaluasi');
    Route::post('/submit', [EvaluasiController::class, 'simpanJawaban'])->name('submit.evaluasi');
});

// Route Halaman Guru - renamed for consistency
Route::prefix('guru')->group(function () {
    Route::get('/', [HalamanGuruController::class, 'index'])->name('guru.index');
    Route::post('/token', [HalamanGuruController::class, 'storeToken'])->name('token.store');
    Route::delete('/siswa/{id}', [HalamanGuruController::class, 'destroySiswa'])->name('siswa.destroy');
    Route::delete('/nilai/{id}', [HalamanGuruController::class, 'destroyNilai'])->name('guru.nilai.destroy');
});


// NEW: Route for getting evaluasi data via AJAX
Route::get('/evaluasi/data', [EvaluasiController::class, 'getDataEvaluasi'])->name('evaluasi.data');
Route::post('/cek-nama-siswa', [EvaluasiController::class, 'cekNamaSiswa'])->name('cek.nama.siswa');

// REMOVED: All commented old routes to clean up the file

Route::get('/guru/export/pdf', [HalamanGuruController::class, 'exportPDF'])->name('guru.export.pdf');

// ▼▼▼ TAMBAHKAN RUTE BARU INI ▼▼▼
Route::get('/guru/export/excel', [HalamanGuruController::class, 'exportExcel'])->name('guru.export.excel');

Route::post('/cek-token', [AuthController::class, 'cekToken'])->name('cek.token');


Route::get('/test-rute-sukses', function () {
    return 'Rute ini berhasil diakses!';
});