<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EskulController;
use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\NilaiController;

Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});
// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Eskul
Route::get('/eskul', [EskulController::class, 'index']);
Route::get('/eskul/{id}/siswa', [EskulController::class, 'siswaEskul']);
Route::post('/eskul', [EskulController::class, 'store']);
Route::post('/eskul/daftar', [EskulController::class, 'daftarEskul']);
Route::put('/eskul/{id}', [EskulController::class, 'update']);
Route::delete('/eskul/{id}/delete', [EskulController::class, 'destroy']);
// Absensi
Route::post('/absen', [AbsensiController::class, 'store']);
Route::get('/absen/{siswa_id}', [AbsensiController::class, 'show']);
Route::put('/absen/{id}', [AbsensiController::class, 'update']);
Route::delete('/nilai/{id}/delete', [NilaiController::class, 'destroy']);
// Nilai
Route::post('/nilai', [NilaiController::class, 'store']);
Route::get('/nilai/{siswa_id}', [NilaiController::class, 'index']);
Route::put('/nilai/{id}', [NilaiController::class, 'update']);
Route::delete('/nilai/{id}', [NilaiController::class, 'destroy']);
