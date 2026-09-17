<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndikatorController;
use App\Http\Controllers\PerbandinganController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/kelompok', [IndikatorController::class, 'index'])
    ->name('kelompok.index');

Route::get('/kelompok/{slug}', [IndikatorController::class, 'group'])
    ->name('kelompok.show');

Route::get('/perbandingan', [PerbandinganController::class, 'index'])
    ->name('perbandingan.index');

Route::get('/api/indikator-search', [IndikatorController::class, 'search'])
    ->name('indikator.search');

Route::get('/indikator/{slug}/download', [IndikatorController::class, 'download'])
    ->name('indikator.download');

Route::get('/indikator/{slug}', [IndikatorController::class, 'show'])
    ->name('indikator.show');

Route::view('/infografis', 'infografis.index')
    ->name('infografis.index');

Route::view('/layanan', 'layanan.index')
    ->name('layanan.index');