<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BannedController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('index');
})->name('index');

Auth::routes();

Route::middleware('auth','is_user')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
    Route::get('/topup', [DashboardController::class, 'topup'])->name('saldo.topup');
    Route::post('/topup', [DashboardController::class, 'topupStore'])->name('saldo.topup');
    Route::get('/transfer', [DashboardController::class, 'transfer'])->name('saldo.transfer');
    Route::post('/transfer', [DashboardController::class, 'transferStore'])->name('saldo.transfer');
    Route::get('/riwayat', [DashboardController::class, 'riwayat'])->name('saldo.riwayat');
    Route::get('/pengeluaran', [DashboardController::class, 'pengeluaran'])->name('saldo.pengeluaran');
    Route::get('/pulsa', [DashboardController::class, 'pulsa'])->name('shop.pulsa');
    Route::post('/pulsa', [DashboardController::class, 'pulsaStore'])->name('shop.pulsa');
    Route::get('/listrik', [DashboardController::class, 'listrik'])->name('shop.listrik');
    Route::post('/listrik', [DashboardController::class, 'listrikStore'])->name('shop.listrik');
    Route::get('/catatan', [DashboardController::class, 'catatan'])->name('catatan.list');
    Route::get('/tambah-catatan', [DashboardController::class, 'tambahCtt'])->name('catatan.add');
    Route::post('/tambah-catatan', [DashboardController::class, 'insertCtt'])->name('catatan.add');
    Route::get('/catatan/{note}', [DashboardController::class, 'editCtt'])->name('catatan.edit');
    Route::post('/catatan/{note}', [DashboardController::class, 'updateCtt'])->name('catatan.edit');
    Route::post('/catatan/finish/{note}', [DashboardController::class, 'finishedCtt'])->name('catatan.fnish');
    Route::get('/catatan/del/{note}', [DashboardController::class, 'delCtt'])->name('catatan.del');
    Route::get('/myvoucher', [DashboardController::class, 'myvoucher'])->name('myvoucher');
    Route::get('/voucher', [DashboardController::class, 'voucher'])->name('shop.voucher.list');
    Route::get('/voucher/buy/{voucher}', [DashboardController::class, 'buyVoucher'])->name('shop.voucher.buy');
    Route::get('/tabungan', [DashboardController::class, 'tabungan'])->name('tabungan.index');
    Route::post('/tabungan', [DashboardController::class, 'transNabung'])->name('tabungan.index');
});

Route::middleware('auth','is_admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/voucher', [AdminController::class, 'voucher'])->name('voucher.list');
    Route::get('/tambah-voucher', [AdminController::class, 'tambahVchr'])->name('voucher.add');
    Route::post('/tambah-voucher', [AdminController::class, 'insertVchr'])->name('voucher.add');
    Route::get('/voucher/{voucher}', [AdminController::class, 'editVchr'])->name('voucher.edit');
    Route::post('/voucher/{voucher}', [AdminController::class, 'updateVchr'])->name('voucher.edit');
    Route::post('/voucher/finish/{voucher}', [AdminController::class, 'finishedVchr'])->name('voucher.fnish');
    Route::get('/voucher/del/{voucher}', [AdminController::class, 'delVchr'])->name('voucher.del');
    Route::get('/users', [AdminController::class, 'users'])->name('users.list');
    Route::get('/users/pswd/{user}', [AdminController::class, 'resetPswdUser'])->name('users.reset');
    Route::get('/users/status/{user}', [AdminController::class, 'statusChngUser'])->name('users.stat');

});

Route::get('/myaccount', [ProfileController::class, 'user'])->name('myaccount');
Route::put('/myaccount', [ProfileController::class, 'update'])->name('myaccount.update');
Route::get('/banned', [BannedController::class, 'index'])->name('banned');
