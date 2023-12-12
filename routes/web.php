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

Route::get('/perfil', [App\Http\Controllers\PerfilController::class, 'index'])->name('perfil');

Route::post('/perfil/actualizar', [App\Http\Controllers\PerfilController::class, 'actualizar'])->name('actualizar-perfil');

Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('index');
Route::group(['middleware' => 'vendor'], function () {
    Route::get('/myprods', [App\Http\Controllers\ProductController::class, 'myProducts'])->name('myprods');
    Route::get('/subir_producto', [App\Http\Controllers\ProductController::class, 'create'])->name('subir_producto');
    Route::post('/products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
    Route::get('/pedidos', [App\Http\Controllers\PedidoController::class, 'index'])->name('pedidos');
    Route::post('/enviar_pedido/{pedido}', [App\Http\Controllers\PedidoController::class, 'enviar'])->name('enviar_pedido');

});

Route::group(['middleware' => 'comprador'], function () {
    Route::get('/carrito', [App\Http\Controllers\CarritoController::class, 'index'])->name('carrito');
    Route::post('/carrito/add/{product}', [App\Http\Controllers\CarritoController::class, 'add'])->name('carrito.add');
    Route::delete('/carrito/remove/{product}', [App\Http\Controllers\CarritoController::class, 'remove'])->name('carrito.remove');
});

Route::group(['middleware' => 'controlador'], function () {
    Route::get('/controlador', [App\Http\Controllers\ControladorController::class, 'index'])->name('controlador');
});

Route::get('/products/show/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::delete('products/{product}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');
Route::get('products/{product}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
Route::put('products/{product}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'showCheckoutForm'])->name('checkout');

Route::post('/process_checkout', [App\Http\Controllers\CheckoutController::class, 'process'])->name('process_checkout');

Route::get('/getMunicipiosByProvince/{provinceId}', [App\Http\Controllers\CheckoutController::class, 'getMunicipiosByProvince']);
Route::get('/pedidos/{pedido}', [App\Http\Controllers\ControladorController::class, 'show'])->name('pedidos.show');

Route::get('/avisar/{vendedorId}', [App\Http\Controllers\PedidoController::class, 'avisar'])->name('avisar');
Route::get('/repartidor', [App\Http\Controllers\RepartidorController::class, 'index'])->name('repartidor');

Route::get('/pedidos/{pedido}/incidencia', [App\Http\Controllers\PedidoController::class, 'mostrarIncidencia'])->name('pedidos.incidencia');
Route::post('/pedidos/{pedido}/incidencias', [App\Http\Controllers\PedidoController::class, 'almacenarIncidencia'])->name('pedidos.incidencias.store');


