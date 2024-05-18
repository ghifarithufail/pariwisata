<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SpjController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::prefix('booking')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('booking');
    Route::get('/create', [BookingController::class, 'create'])->name('booking/create');
    Route::post('/store', [BookingController::class, 'store'])->name('booking/store');
    Route::get('/pengemudi/{id}', [BookingController::class, 'pengemudi'])->name('booking/pengemudi');
    Route::post('/update-data', [BookingController::class, 'update'])->name('booking/update');
    Route::get('/jadwal', [BookingController::class, 'jadwal'])->name('jadwal');
    Route::post('/getTujuan', [BookingController::class, 'getTujuan'])->name('getTujuan');
    Route::post('/getTotalHargaStd', [BookingController::class, 'getTotalHargaStd'])->name('getTotalHargaStd');
    Route::get('/edit/{id}', [BookingController::class, 'edit'])->name('booking/edit');
    Route::post('/update-reservation', [BookingController::class, 'updateBusReservation'])->name('booking/update');
    Route::post('/update-date', [BookingController::class, 'updateDateReservation'])->name('booking/update/date');



});

Route::prefix('payment')->group(function () {

    Route::get('/', [PaymentController::class, 'index'])->name('payment');
    Route::get('/create/{id}', [PaymentController::class, 'create'])->name('payment/create');
    Route::post('/store', [PaymentController::class, 'store'])->name('payment/store');
});

Route::prefix('spj')->group(function () {

    Route::get('/', [SpjController::class, 'index'])->name('spj');
    Route::get('/detail/{id}', [SpjController::class, 'detail'])->name('spj/detail');
    Route::get('/data/{id}', [SpjController::class, 'data'])->name('spj/data');
    Route::post('/keluar/{id}', [SpjController::class, 'keluar'])->name('spj/keluar');
    // Route::post('/masuk/{id}', [SpjController::class, 'masuk'])->name('spj/masuk');
    Route::get('/print/out/{id}', [SpjController::class, 'detail_out'])->name('spj/print_out');
    Route::get('/print_out/{id}', [SpjController::class, 'print'])->name('spj/print');
    Route::get('/print/in/{id}', [SpjController::class, 'detail_in'])->name('spj/print_in');
    Route::post('/print/out/store', [SpjController::class, 'store_print_out'])->name('spj/print_out/store');
    Route::post('/print/in/store', [SpjController::class, 'store_print_in'])->name('spj/print_in/store');
    Route::post('/biaya_lain/store', [SpjController::class, 'biaya_lain'])->name('spj/biaya_lain');
});
