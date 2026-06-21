<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EscuelaController;

Route::get('/', [EscuelaController::class, 'index']);
Route::get('/escuelas/search', [EscuelaController::class, 'search'])->name('escuelas.search');
Route::get('/crear-carpetas-escuelas', [EscuelaController::class, 'CrearCarpetasEscuelas'])->name('escuelas.creaRR');
Route::post('/agregar-carpetas-escuelas', [EscuelaController::class, 'ValidarCarpetasEscuelas'])->name('escuelas.agg');




