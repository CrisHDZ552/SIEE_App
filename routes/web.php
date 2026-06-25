<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EscuelaController;

Route::get('/', [EscuelaController::class, 'index']);
Route::get('/escuelas/search', [EscuelaController::class, 'search'])->name('escuelas.search');
Route::get('/crear/carpetas', [EscuelaController::class, 'CrearCarpetasEscuelas'])->name('escuelas.creaRR');
Route::post('/agregar/carpetas', [EscuelaController::class, 'ValidarCarpetasEscuelas'])->name('escuelas.agg');
Route::get('/escuelas/{escuela}', [EscuelaController::class, 'show'])->name('escuelas.show');
Route::get('/crear/archivos', [EscuelaController::class, 'CrearArchivosEscuelas'])->name('archivos.creaRR');
Route::post('/agregar/archivos', [EscuelaController::class, 'ValidarArchivosEscuelas'])->name('archivos.agg');
