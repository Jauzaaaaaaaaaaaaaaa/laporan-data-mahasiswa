<?php

use App\Http\Controllers\mahasiswaController;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', '/mahasiswa');

Route::get('mahasiswa/rekap', [mahasiswaController::class, 'rekap']);
Route::resource('mahasiswa', mahasiswaController::class)->except('show');
Route::get('mahasiswa/export/excel',[mahasiswaController::class, 'export_excel']);
Route::get('mahasiswa/view/pdf',[mahasiswaController::class, 'view_pdf']);
Route::get('mahasiswa/download/pdf',[mahasiswaController::class, 'download_pdf']);

