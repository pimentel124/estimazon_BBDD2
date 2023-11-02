<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();

Route::get('/', function () {
    return view('Index');
});

Route::get('/greeting', function () {
    return 'Hello World';
});

Route::get('/carrito', [App\Http\Controllers\CarritoController::class, 'index'])->name('carrito');

Route::get('/perfil', [App\Http\Controllers\PerfilController::class, 'index'])->name('perfil');

Route::post('/perfil/actualizar', [App\Http\Controllers\PerfilController::class, 'actualizar'])->name('actualizar-perfil');

Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('index');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
