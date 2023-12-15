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

Route::group(['middleware' => 'vendor'], function () {
    Route::get('/myprods', [App\Http\Controllers\ProductController::class, 'myProducts'])->name('myprods');
    Route::get('/subir_producto', [App\Http\Controllers\ProductController::class, 'create'])->name('subir_producto');
    Route::post('/products', [App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
    Route::post('/products/addStock', [App\Http\Controllers\ProductController::class, 'addStock'])->name('products.addStock');
    Route::get('/pedidos', [App\Http\Controllers\PedidoController::class, 'index'])->name('pedidos');
    Route::post('/enviar_pedido/{pedido}', [App\Http\Controllers\PedidoController::class, 'enviar'])->name('enviar_pedido');
    Route::delete('products/{productStockId}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('products/{product}/edit', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
});

Route::group(['middleware' => 'comprador'], function () {
    Route::get('/carrito', [App\Http\Controllers\CarritoController::class, 'index'])->name('carrito');
    Route::post('/carrito/add/{productStock}', [App\Http\Controllers\CarritoController::class, 'addToCart'])->name('carrito.addToCart');
    Route::delete('/carrito/remove/{productStock}', [App\Http\Controllers\CarritoController::class, 'remove'])->name('carrito.remove');
    Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'showCheckoutForm'])->name('checkout');
    Route::post('/process_checkout', [App\Http\Controllers\CheckoutController::class, 'process'])->name('process_checkout');

});

Route::group(['middleware' => 'controlador'], function () {
    Route::get('/controlador', [App\Http\Controllers\ControladorController::class, 'index'])->name('controlador');
    Route::get('/avisar/{vendedorId}', [App\Http\Controllers\PedidoController::class, 'avisar'])->name('avisar');
    Route::put('/guardar-envio/{orderId}', [App\Http\Controllers\ControladorController::class, 'guardarEnvio'])->name('guardar-envio');
    Route::get('/pedidos/{pedido}', [App\Http\Controllers\ControladorController::class, 'show'])->name('pedidos.show');
});

Route::group(['middleware' => 'repartidor'], function () {
    Route::get('/repartidor', [App\Http\Controllers\RepartidorController::class, 'index'])->name('repartidor');
    Route::get('/pedidos/{pedido}/incidencia', [App\Http\Controllers\PedidoController::class, 'mostrarIncidencia'])->name('pedidos.incidencia');
    Route::put('/pedidos/{pedido}/update-status', [App\Http\Controllers\PedidoController::class, 'updateStatus'])->name('pedidos.updateStatus');
});

Route::get('/products/show/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/getMunicipiosByProvince/{provinceId}', [App\Http\Controllers\CheckoutController::class, 'getMunicipiosByProvince']);
Route::get('/perfil', [App\Http\Controllers\PerfilController::class, 'index'])->name('perfil');
Route::post('/perfil/actualizar', [App\Http\Controllers\PerfilController::class, 'actualizar'])->name('actualizar-perfil');
Route::get('/', [App\Http\Controllers\ProductController::class, 'index'])->name('index');


