<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/cek-token', [AuthController::class, 'cekToken']);

Route::post('/update-level', [AuthController::class, 'updateLevel'])->name('update.level');
