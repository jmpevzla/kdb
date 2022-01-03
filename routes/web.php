<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\GruposController;
use App\Http\Controllers\PersonasController;
use App\Http\Controllers\MediosController;
use App\Http\Controllers\EtiquetasController;
use App\Http\Controllers\CategoriasController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('grupos', GruposController::class);
    Route::resource('personas', PersonasController::class);
    Route::resource('medios', MediosController::class);
    Route::resource('etiquetas', EtiquetasController::class);
    Route::resource('categorias', CategoriasController::class);

});

require __DIR__.'/auth.php';
