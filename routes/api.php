<?php

use App\Http\Controllers\FileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Rotasi\DenahController as RotasiDenahController;
use App\Http\Controllers\Rotasi\PengajuanController as RotasiPengajuanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'rotasi'], function () {
    Route::get('/cabang-induk', [RotasiDenahController::class, 'listCabangInduk']);
    Route::get('/cabang-summary/{id}', [RotasiDenahController::class, 'cabangSummary']);
    Route::get('/cabang-search', [RotasiDenahController::class, 'cabangSearch']);
});

Route::group(['prefix' => 'pengajuan'], function () {
    Route::get('/{id}', [RotasiPengajuanController::class, 'pengajuanById']);
});

Route::post('/upload-doc', [FileController::class, 'uploadDoc']);
