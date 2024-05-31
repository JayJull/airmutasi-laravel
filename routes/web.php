<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\Rotasi\HomeController as RotasiHomeController;
use App\Http\Controllers\Rotasi\DenahController as RotasiDenahController;
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

Route::group(['prefix' => 'rotasi'], function () {
    Route::get('/', [RotasiHomeController::class, 'index'])->name('rotasi');
    Route::group(['prefix' => 'denah', 'middleware' => [
        'auth:web'
    ]], function () {
        Route::get('/', [RotasiDenahController::class, 'index'])->name('rotasi.denah');
        Route::get("/{id}", [RotasiDenahController::class, 'cabang']);
    });
    Route::group(['prefix' => 'selektif', 'middleware' => [
        'auth:web',
        'is.admin'
    ]], function () {
        Route::get('/', [RotasiSelektifAdminController::class, 'index'])->name('rotasi.selektif');
        Route::post("/{id}", [RotasiSelektifAdminController::class, 'selektif']);
    });
    Route::group(['prefix' => 'personal', 'middleware' => [
        'auth:web'
    ]], function () {
        Route::get('/', [RotasiPersonalController::class, 'index']);
        Route::post('/', [RotasiPersonalController::class, 'register']);
    });
});
