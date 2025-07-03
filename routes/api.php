<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EskulController;
use App\Http\Controllers\Api\AbsensiController;
use App\Http\Controllers\Api\NilaiController;
use App\Models\Absensi;

Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});
// Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/alluser', [AuthController::class, 'alluser']);
Route::get('/user/{id}', [AuthController::class, 'getUserById']);
Route::put('/user/{id}/update', [AuthController::class, 'updateProfile']);
// Eskul
Route::get('/eskul', [EskulController::class, 'index']);
Route::get('/eskul/{id}/siswa', [EskulController::class, 'siswaEskul']);
Route::post('/eskul', [EskulController::class, 'store']);
Route::post('/eskul/daftar', [EskulController::class, 'daftarEskul']);
Route::post('/eskul/keluar', [EskulController::class, 'keluarEskul']);
Route::put('/eskul/{id}', [EskulController::class, 'update']);
Route::delete('/eskul/{id}/delete', [EskulController::class, 'destroy']);
Route::get('/pembina/{pembina_id}/absensi', [AbsensiController::class, 'getAbsensiByPembina']);
Route::get('/pembina/{pembina_id}/nilai', [NilaiController::class, 'getNilaiByPembina']);
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
