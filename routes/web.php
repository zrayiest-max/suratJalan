<?php

use App\Http\Controllers\FolderController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\PenarimaController;
use App\Http\Controllers\suratJalanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/merk', [MerkController::class, 'index'])->name('merk.index');
Route::post('/merk', [MerkController::class, 'store'])->name('merk.store');
Route::get('/merk/create', [MerkController::class, 'create'])->name('merk.create');
Route::get('/merk/{merk}/edit', [MerkController::class, 'edit'])->name('merk.edit');
Route::put('/merk/{merk}', [MerkController::class, 'update'])->name('merk.update');
Route::delete('/merk/{merk}', [MerkController::class, 'destroy'])->name('merk.destroy');

Route::resource('penerima', PenarimaController::class);
Route::post('/surat-jalan/masukkan-folder',
    [suratJalanController::class, 'masukkanFolder']
)->name('surat-jalan.masukkan-folder');
Route::post('/folder/{folder}/details', [FolderController::class, 'storeDetails'])
    ->name('folder.details.store');
Route::get('/folder/{folder}/print', [FolderController::class, 'print'])
    ->name('folder.print');
Route::get('/surat-jalan/tracking', [suratJalanController::class, 'tracking'])->name('surat-jalan.tracking');
Route::resource('surat-jalan', suratJalanController::class);
Route::resource('folder', FolderController::class);
