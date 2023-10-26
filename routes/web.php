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

Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('index');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
