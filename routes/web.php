<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonelController;
// use App\Http\Controllers\Rotasi\HomeController as RotasiHomeController;
use App\Http\Controllers\Rotasi\CabangController as RotasiCabangController;
use App\Http\Controllers\Rotasi\SelektifAdminController as RotasiSelektifAdminController;
use App\Http\Controllers\Rotasi\PengajuanController as RotasiPersonalController;

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
    return view('welcome');
})->name('landing');

Route::middleware("guest")->get("/login", [AuthController::class, 'loginView'])->name('login');
Route::middleware("guest")->post("/login", [AuthController::class, 'login']);
Route::middleware("auth:web")->get("/logout", [AuthController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'akun', 'middleware' => [
    'auth:web'
]], function () {
    Route::get("/", [AccountController::class, 'index'])->name('akun');
    Route::group(['prefix' => 'add', 'middleware' => [
        'is.admin'
    ]], function () {
        Route::get('/', [AccountController::class, 'inputView']);
        Route::post('/', [AccountController::class, 'input']);
    });
    Route::get('/edit', [AccountController::class, 'updateView']);
    Route::post('/edit', [AccountController::class, 'update']);
});

Route::group(['prefix' => 'personel', 'middleware' => [
    'auth:web'
]], function () {
    Route::get('/cabang/{id}', [PersonelController::class, 'index'])->name('personel.index');
    Route::group(['prefix' => 'add', 'middleware' => [
        'is.admin'
    ]], function () {
        Route::get('/', [PersonelController::class, 'inputView']);
        Route::post('/', [PersonelController::class, 'input']);
    });
});

Route::group(['prefix' => 'rotasi', 'middleware' => [
    'auth:web'
]], function () {
    // Route::get('/', [RotasiHomeController::class, 'index'])->name('rotasi');
    Route::group(['prefix' => 'denah'], function () {
        Route::group(['prefix' => 'input', 'middleware' => [
            'is.admin'
        ]], function () {
            Route::get('/', [RotasiCabangController::class, 'inputView']);
            Route::post('/', [RotasiCabangController::class, 'input']);

            Route::get('/{id}', [RotasiCabangController::class, 'updateView']);
            Route::post('/{id}', [RotasiCabangController::class, 'update']);

            Route::get('/{id}/delete', [RotasiCabangController::class, 'delete']);
        });

        Route::get('/', [RotasiCabangController::class, 'index'])->name('rotasi.denah');
        Route::get("/{id}", [RotasiCabangController::class, 'cabang']);
    });
    Route::group(['prefix' => 'personal'], function () {
        Route::get('/', [RotasiPersonalController::class, 'inputView']);
        Route::post('/', [RotasiPersonalController::class, 'input']);
        Route::middleware("is.admin")->get('/{id}', [RotasiPersonalController::class, 'updateView']);
        Route::middleware("is.admin")->post('/{id}', [RotasiPersonalController::class, 'update']);
    });
    Route::group(['prefix' => 'selektif', 'middleware' => [
        'is.admin'
    ]], function () {
        Route::get('/', [RotasiSelektifAdminController::class, 'index'])->name('rotasi.selektif');
        Route::post("/{id}", [RotasiSelektifAdminController::class, 'selektif']);
    });
});
