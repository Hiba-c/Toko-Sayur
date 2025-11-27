<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| Redirect root ke login
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('backend.login');
});

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/
Route::get('backend/login', [LoginController::class, 'loginBackend'])
    ->name('backend.login');

Route::post('backend/login', [LoginController::class, 'authenticateBackend'])
    ->name('backend.login.post');

Route::post('backend/logout', [LoginController::class, 'logoutBackend'])
    ->name('backend.logout');

/*
|--------------------------------------------------------------------------
| BACKEND (AUTH REQUIRED)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('backend')->name('backend.')->group(function () {

    // Dashboard
    Route::get('/beranda', [BerandaController::class, 'berandaBackend'])
        ->name('beranda');

    /*
    |--------------------------------------------------------------------------
    | USER / MEMBER
    |--------------------------------------------------------------------------
    */
    Route::get('/member', [UserController::class, 'indexMember'])
        ->name('member.index');

    Route::resource('/user', UserController::class)
        ->names('user');

    /*
    |--------------------------------------------------------------------------
    | KATEGORI & PRODUK
    |--------------------------------------------------------------------------
    */
    Route::resource('/kategori', KategoriController::class)
        ->names('kategori');

    Route::resource('/produk', ProdukController::class)
        ->names('produk');

    /*
    |--------------------------------------------------------------------------
    | TRANSAKSI & POS
    |--------------------------------------------------------------------------
    */
    Route::resource('/transaksi', TransactionController::class)
        ->names('transaksi');

    // Print Struk
    Route::get('/transaksi/{id}/print', [TransactionController::class, 'print'])
        ->name('transaksi.print');

    // Mode POS
    Route::get('/pos', [TransactionController::class, 'pos'])
        ->name('pos');

    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    |--------------------------------------------------------------------------
    */
    Route::get('/laporan', [ReportController::class, 'index'])
        ->name('laporan.index');

    Route::get('/laporan/export/csv', [ReportController::class, 'exportCsv'])
        ->name('laporan.export.csv');

    Route::get('/laporan/export/pdf', [ReportController::class, 'exportPdf'])
        ->name('laporan.export.pdf');

    Route::get('/laporan/export/xlsx', [ReportController::class, 'exportXlsx'])
    ->name('laporan.export.xlsx');
});
