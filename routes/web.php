<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\GruposController;
use App\Http\Controllers\PersonasController;
use App\Http\Controllers\MediosController;
use App\Http\Controllers\EtiquetasController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\TiposController;
use App\Http\Controllers\TiposLinksController;
use App\Http\Controllers\LinksController;
use App\Http\Controllers\ConocimientosController;

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
    Route::post('personas/{persona}/create-apodo', [PersonasController::class, 'createApodo'])
        ->name('personas.createApodo');
    Route::delete('personas/remove-apodo/{apodo}', [PersonasController::class, 'removeApodo'])
        ->name('personas.removeApodo');
    Route::post('personas/{persona}/create-link', [PersonasController::class, 'createLink'])
        ->name('personas.createLink');
    Route::delete('personas/{persona}/remove-link/{idLink}', [PersonasController::class, 'removeLink'])
        ->name('personas.removeLink');
    Route::post('personas/{persona}/attach-link', [PersonasController::class, 'attachLink'])
        ->name('personas.attachLink');

    Route::resource('medios', MediosController::class);
    Route::post('medios/{medio}/create-link', [MediosController::class, 'createLink'])
        ->name('medios.createLink');
    Route::delete('medios/{medio}/remove-link/{idLink}', [MediosController::class, 'removeLink'])
        ->name('medios.removeLink');
    Route::post('medios/{medio}/attach-link', [MediosController::class, 'attachLink'])
        ->name('medios.attachLink');

    Route::resource('etiquetas', EtiquetasController::class);
    Route::resource('categorias', CategoriasController::class);
    Route::resource('tipos', TiposController::class);
    Route::resource('tipos-links', TiposLinksController::class);
    Route::resource('links', LinksController::class);
    Route::resource('conocimientos', ConocimientosController::class);

});

require __DIR__.'/auth.php';
