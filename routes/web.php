<?php

use App\Models\Admin\Pool;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpjController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\KotaController;
use App\Http\Controllers\Admin\PoolController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RuteController;
use App\Http\Controllers\Admin\ArmadaController;
use App\Http\Controllers\Hrd\BiodataControllerr;
use App\Http\Controllers\Hrd\KaryawanController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Hrd\KondekturController;
use App\Http\Controllers\Hrd\PengemudiController;
use App\Http\Controllers\Admin\ProvinsiController;
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

Route::prefix('provinsi')->group(function () {
    Route::get('/', [ProvinsiController::class, 'index'])->name('provinsi');
    Route::get('/create', [ProvinsiController::class, 'create'])->name('provinsi/create');
    Route::post('/store', [ProvinsiController::class, 'store'])->name('provinsi/store');
    Route::get('/edit/{id}', [ProvinsiController::class, 'edit'])->name('provinsi/edit');
    Route::put('/provinsi/{provinsi}', [ProvinsiController::class, 'update'])->name('provinsi.update');
});

/* Element */
Route::prefix('kota')->group(function () {
    Route::get('/', [KotaController::class, 'index'])->name('kota');
    Route::get('/create', [KotaController::class, 'create'])->name('kota/create');
    Route::post('/store', [KotaController::class, 'store'])->name('kota/store');
    Route::get('/edit/{id}', [KotaController::class, 'edit'])->name('kota/edit');
    Route::put('/kota/{kota}', [KotaController::class, 'update'])->name('kota.update');
});

Route::prefix('pool')->group(function () {
    Route::get('/', [PoolController::class, 'index'])->name('pool');
    Route::get('/create', [PoolController::class, 'create'])->name('pool/create');
    Route::post('/store', [PoolController::class, 'store'])->name('pool/store');
    Route::get('/edit/{id}', [PoolController::class, 'edit'])->name('pool/edit');
    Route::put('/pool/{pool}', [PoolController::class, 'update'])->name('pool.update');
});

Route::prefix('rute')->group(function () {
    Route::get('/', [RuteController::class, 'index'])->name('rute');
    Route::get('/create', [RuteController::class, 'create'])->name('rute/create');
    Route::post('/store', [RuteController::class, 'store'])->name('rute/store');
    Route::get('/edit/{id}', [RuteController::class, 'edit'])->name('rute/edit');
    Route::put('/rute/{rute}', [RuteController::class, 'update'])->name('rute.update');
});

Route::prefix('jabatan')->group(function () {
    Route::get('/', [JabatanController::class, 'index'])->name('jabatan');
    Route::get('/create', [JabatanController::class, 'create'])->name('jabatan/create');
    Route::post('/store', [JabatanController::class, 'store'])->name('jabatan/store');
    Route::get('/edit/{id}', [JabatanController::class, 'edit'])->name('jabatan/edit');
    Route::put('/jabatan/{jabatan}', [JabatanController::class, 'update'])->name('jabatan.update');
});

Route::prefix('armada')->group(function () {
    Route::get('/', [ArmadaController::class, 'index'])->name('armada');
    Route::get('/create', [ArmadaController::class, 'create'])->name('armada/create');
    Route::post('/store', [ArmadaController::class, 'store'])->name('armada/store');
    Route::get('/edit/{id}', [ArmadaController::class, 'edit'])->name('armada/edit');
    Route::put('/armada/{armada}', [ArmadaController::class, 'update'])->name('armada.update');
});

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users');
    Route::get('/create', [UserController::class, 'create'])->name('users/create');
    Route::post('/store', [UserController::class, 'store'])->name('users/store');
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('users/edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

});

/* HRD */
Route::prefix('biodata')->group(function () {
    Route::get('/', [BiodataControllerr::class, 'index'])->name('biodata');
    Route::get('/create', [BiodataControllerr::class, 'create'])->name('biodata/create');
    Route::post('/store', [BiodataControllerr::class, 'store'])->name('biodata/store');
    Route::get('/edit/{id}', [BiodataControllerr::class, 'edit'])->name('biodata/edit');
    Route::put('/biodata/{biodata}', [BiodataControllerr::class, 'update'])->name('biodata.update');
    Route::get('/biodata/{nik}', [BiodataControllerr::class, 'show'])->name('biodata/show');

});

Route::prefix('karyawan')->group(function () {
    Route::get('/', [KaryawanController::class, 'index'])->name('karyawan');
    Route::get('/create', [KaryawanController::class, 'create'])->name('karyawan/create');
    Route::post('/store', [KaryawanController::class, 'store'])->name('karyawan/store');
    Route::get('/edit/{id}', [KaryawanController::class, 'edit'])->name('karyawan/edit');
    Route::put('karyawan/{karyawan}', [KaryawanController::class, 'update'])->name('karyawan/update');

});

Route::prefix('pengemudi')->group(function () {
    Route::get('/', [PengemudiController::class, 'index'])->name('pengemudi');
    Route::get('/create', [PengemudiController::class, 'create'])->name('pengemudi/create');
    Route::post('/store', [PengemudiController::class, 'store'])->name('pengemudi/store');
    Route::get('/edit/{id}', [PengemudiController::class, 'edit'])->name('pengemudi/edit');
    Route::put('/pengemudi/{pengemudi}', [PengemudiController::class, 'update'])->name('pengemudi/update');
    Route::get('/get-pool-name/{id}', [PengemudiController::class, 'getPoolName']);
});

Route::prefix('kondektur')->group(function () {
    Route::get('/', [KondekturController::class, 'index'])->name('kondektur');
    Route::get('/create', [KondekturController::class, 'create'])->name('kondektur/create');
    Route::post('/store', [KondekturController::class, 'store'])->name('kondektur/store');
    Route::get('/edit/{id}', [KondekturController::class, 'edit'])->name('kondektur/edit');
    Route::put('/kondektur/{kondektur}', [KondekturController::class, 'update'])->name('kondektur/update');
});

Route::prefix('booking')->group(function () {
    Route::get('/', [BookingController::class, 'index'])->name('booking');
    Route::get('/report', [BookingController::class, 'report'])->name('booking/report');
    Route::get('/laporan', [BookingController::class, 'laporan'])->name('booking/laporan');
    Route::get('/create', [BookingController::class, 'create'])->name('booking/create');
    Route::post('/store', [BookingController::class, 'store'])->name('booking/store');
    Route::get('/pengemudi/{id}', [BookingController::class, 'pengemudi'])->name('booking/pengemudi');
    Route::post('/update-data', [BookingController::class, 'update_pengemudi'])->name('booking/update');
    Route::get('/detail/{id}', [BookingController::class, 'detail'])->name('booking/detail');
    Route::post('/store-detail', [BookingController::class, 'store_detail'])->name('booking/store_detail');
    Route::get('/jadwal', [BookingController::class, 'jadwal'])->name('jadwal');
    Route::post('/getTujuan', [BookingController::class, 'getTujuan'])->name('getTujuan');
    Route::post('/getTotalHargaStd', [BookingController::class, 'getTotalHargaStd'])->name('getTotalHargaStd');
    Route::get('/edit/{id}', [BookingController::class, 'edit'])->name('booking/edit');
    Route::post('/update-reservation', [BookingController::class, 'updateBusReservation'])->name('booking/update');
    Route::post('/update-date', [BookingController::class, 'updateDateReservation'])->name('booking/update/date');
    Route::get('/excel', [BookingController::class, 'excel'])->name('booking/excel');

});

Route::prefix('report')->group(function () {
    Route::get('/booking', [BookingController::class, 'laporan'])->name('report/booking');
    Route::get('/detail', [BookingController::class, 'report'])->name('report/detail');
    Route::get('/spj', [SpjController::class, 'report'])->name('report/spj');
    Route::get('/payment', [PaymentController::class, 'report'])->name('report/payment');
    Route::get('/payment/detail/{id}', [PaymentController::class, 'detail_report'])->name('report/payment/detail');
    Route::get('/spj/detail/{id}', [SpjController::class, 'detail_report'])->name('report/spj/detail');
    Route::get('/booking/detail/{id}', [BookingController::class, 'detail_report'])->name('report/booking/detail');
});

Route::prefix('payment')->group(function () {

    Route::get('/', [PaymentController::class, 'index'])->name('payment');
    Route::get('/create/{id}', [PaymentController::class, 'create'])->name('payment/create');
    Route::post('/store', [PaymentController::class, 'store'])->name('payment/store');
    Route::get('/excel', [PaymentController::class, 'excel'])->name('payment/excel');

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
    Route::get('/excel', [SpjController::class, 'excel'])->name('spj/excel');

});
