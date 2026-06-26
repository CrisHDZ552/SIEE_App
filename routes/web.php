<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EscuelaController;
use App\Http\Controllers\ArchivosController;

Route::get('/', [EscuelaController::class, 'index']);
Route::get('/escuelas/search', [EscuelaController::class, 'search'])->name('escuelas.search');
Route::get('/crear/carpetas', [EscuelaController::class, 'CrearCarpetasEscuelas'])->name('escuelas.creaRR');
Route::post('/agregar/carpetas', [EscuelaController::class, 'ValidarCarpetasEscuelas'])->name('escuelas.agg');
Route::get('/escuelas/{escuela}', [EscuelaController::class, 'show'])->name('escuelas.show');
Route::get('/crear/carpetasarchivos/{escuela}', [ArchivosController::class, 'CrearCarpetasA'])->name('archivos.creaRR');
Route::post('/agregar/carpetasarchivos/{escuela}', [ArchivosController::class, 'ValidarCarpetasA'])->name('archivos.agg');
