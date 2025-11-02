<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;

Route::get('/mahasiswa/cetakPDF', [MahasiswaController::class, 'cetakPDF'])->name('mahasiswa.cetakPDF');

Route::get('/mahasiswa/exportExcel', [MahasiswaController::class, 'exportExcel'])->name('mahasiswa.exportExcel');

Route::resource('mahasiswa', MahasiswaController::class);