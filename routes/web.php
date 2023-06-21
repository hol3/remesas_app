<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EfectivoEnCajaController;
use App\Http\Controllers\EfectivoMensajeroController;
use App\Http\Controllers\MensajeroController;
use App\Http\Controllers\MonedaController;
use App\Http\Controllers\RemesaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::put('/remesas/close', [RemesaController::class, 'closeDelivery'])->middleware(['auth'])->name('remesas.close');

Route::resource('/remesas', RemesaController::class)
    ->only(['index','store', 'edit', 'update','destroy'])
    ->middleware(['auth']);

Route::resource('/mensajeros', MensajeroController::class)
    ->only(['index','store', 'edit', 'update','destroy', 'show'])
    ->middleware(['auth']);

Route::resource('/dinero', EfectivoEnCajaController::class)
    ->only(['index','store','update','destroy'])
    ->middleware(['auth']);

Route::resource('/moneda', MonedaController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth']);

Route::post('/mensajero/efectivo', [MensajeroController::class, 'addEfectivo'])->middleware(['auth'])->name('mensajero.efectivo');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
