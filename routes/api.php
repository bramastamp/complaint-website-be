<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\PengaduanController;
use App\Http\Controllers\Api\TanggapanController;
use App\Http\Controllers\Api\KategoriController;
use App\Http\Controllers\Api\GedungController;
use App\Http\Controllers\Api\KelasController;

// ======================
// AUTH
// ======================
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// ======================
// PUBLIC (guest bisa akses)
// ======================
Route::get('/kategori', [KategoriController::class, 'index']);
Route::post('/pengaduan-guest', [PengaduanController::class, 'storeAsGuest']);

// Gedung & Kelas (hanya GET yang terbuka)
Route::get('/gedung', [GedungController::class, "index"]);
Route::get('/gedung/{id}', [GedungController::class, 'show']);
Route::get('/gedung/{id}/kelas', [GedungController::class, 'kelasByGedung']);
Route::get('/kelas', [KelasController::class, "index"]);
Route::get('/kelas/{id}', [KelasController::class, 'show']);

// ======================
// ADMIN ONLY
// ======================
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // CRUD Gedung
    Route::post('/gedung', [GedungController::class, 'store']);
    Route::put('/gedung/{id}', [GedungController::class, 'update']);
    Route::delete('/gedung/{id}', [GedungController::class, 'destroy']);

    // CRUD Kelas
    Route::post('/kelas', [KelasController::class, 'store']);
    Route::put('/kelas/{id}', [KelasController::class, 'update']);
    Route::delete('/kelas/{id}', [KelasController::class, 'destroy']);

    // Pengaduan & Tanggapan
    Route::get('/pengaduan/all', [PengaduanController::class, 'all']);
    Route::get('/tanggapan', [TanggapanController::class, 'index']);
    Route::post('/tanggapan', [TanggapanController::class, 'store']);
});

// ======================
// USER (login diperlukan)
// ======================
Route::middleware(['auth:sanctum', 'role:user,admin'])->group(function () {
    Route::get('/pengaduan', [PengaduanController::class, 'index']);
    Route::get('/pengaduan/me', [PengaduanController::class, 'myPengaduan']);
    Route::post('/pengaduan', [PengaduanController::class, 'store']);
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show']);
    Route::put('/pengaduan/{id}', [PengaduanController::class, 'update']);
    Route::delete('/pengaduan/{id}', [PengaduanController::class, 'destroy']);
    Route::get('/pengaduan/{id}/tanggapan', [TanggapanController::class, 'byPengaduan']);
    Route::get('/pengaduan/{id}', [PengaduanController::class, 'show']);

});
