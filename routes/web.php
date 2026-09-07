<?php

use App\Http\Controllers\FolderController;
use App\Http\Controllers\MerkController;
use App\Http\Controllers\PenarimaController;
use App\Http\Controllers\suratJalanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/backup-database', function () {
    $databasePath = config('database.connections.sqlite.database');

    if (! file_exists($databasePath)) {
        abort(404, 'Database tidak ditemukan.');
    }

    return response()->download(
        $databasePath,
        'surat-jalan-backup-'.now()->format('Y-m-d_H-i-s').'.sqlite'
    );
})->name('database.backup');

Route::post('/reset-database', function () {
    Artisan::call('migrate:fresh', [
        '--seed' => true,
        '--force' => true,
    ]);

    return redirect()
        ->route('database')
        ->with('success', 'Database berhasil direset ke kondisi awal.');
})->name('database.reset');

Route::post('/restore-database', function (Request $request) {
    $request->validate([
        'database' => ['required', 'file'],
    ]);

    $databasePath = config('database.connections.sqlite.database');

    if (! $databasePath) {
        return back()->with('error', 'Lokasi database tidak ditemukan.');
    }

    $uploadedFile = $request->file('database');

    copy(
        $uploadedFile->getRealPath(),
        $databasePath
    );

    return back()->with('success', 'Database berhasil direstore.');
})->name('database.restore');

Route::get('/database', function () {
    return view('settings.database');
})->name('database');

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
