<?php

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpjController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\RoleController;
use Spatie\Permission\Contracts\Role as ContractsRole;

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

Route::get('/', function () {
    return view('main');
});

Route::get('/main', function () {
    return view('main');
})->middleware(['auth', 'verified'])->name('main');

Route::prefix('roles')->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('roles');
    Route::get('/create', [RoleController::class, 'create'])->name('roles/create');
    Route::post('/store', [RoleController::class, 'store'])->name('roles/store');
    Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('roles/edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');

});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users');
    Route::get('/create', [UserController::class, 'create'])->name('users/create');
    Route::post('/store', [UserController::class, 'store'])->name('users/store');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users/edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

});

Route::prefix('booking')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('booking');
    Route::get('/create', [BookingController::class, 'create'])->name('booking/create');
    Route::post('/store', [BookingController::class, 'store'])->name('booking/store');
    Route::get('/edit/{id}', [BookingController::class, 'edit'])->name('booking/edit');
    Route::post('/update-data', [BookingController::class, 'update'])->name('booking/update');
    Route::get('/jadwal', [BookingController::class, 'jadwal'])->name('jadwal');

});

Route::prefix('payment')->group(function () {

    Route::get('/', [PaymentController::class, 'index'])->name('payment');
    Route::get('/create/{id}', [PaymentController::class, 'create'])->name('payment/create');
    Route::post('/store', [PaymentController::class, 'store'])->name('payment/store');
});

Route::prefix('spj')->group(function () {

    Route::get('/', [SpjController::class, 'index'])->name('spj');
    Route::get('/detail/{id}', [SpjController::class, 'detail'])->name('spj/detail');
    Route::post('/keluar/{id}', [SpjController::class, 'keluar'])->name('spj/keluar');
    Route::post('/masuk/{id}', [SpjController::class, 'masuk'])->name('spj/masuk');
    Route::get('/print/out/{id}', [SpjController::class, 'print_out'])->name('spj/print_out');
});
