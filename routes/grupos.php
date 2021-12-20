<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Grupos\CreateGrupoController;

Route::get('/grupos/crear', [CreateGrupoController::class, 'create'])
    ->middleware(['auth', 'verified'])->name('grupos.crear');

Route::post('/grupos/crear', [CreateGrupoController::class, 'store'])
    ->middleware(['auth', 'verified']);
