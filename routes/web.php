<?php

use App\Http\Controllers\Administrador\ProductoController as AdministradorProductoController;
use App\Http\Controllers\Web\InicioController;
use App\Http\Controllers\Web\ProductoController as WebProductoController;
use App\Http\Livewire\Web\Tienda\TiendaPagina;
use Illuminate\Support\Facades\Route;
use Gloudemans\Shoppingcart\Facades\Cart;

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
Route::get('/', InicioController::class)->name('inicio');

Route::get('prueba-web', function () {
    return "Web";
});


Route::get('producto/{producto}', [WebProductoController::class, 'mostrar'])->name('producto.index');

Route::get('producto/{producto}/qr', [AdministradorProductoController::class, 'redirigirQr'])->name('producto.redirigir.qr');

Route::get('tienda', TiendaPagina::class)->name('tienda');

Route::get('carrito-eliminar', function () {
    Cart::instance('shopping')->destroy();
});

Route::get('favorito-eliminar', function () {
    Cart::instance('wishlist')->destroy();
});

Route::get('carrito-mostrar', function () {
    if (Cart::instance('shopping')->count()) {
        return Cart::instance('shopping')->content();
    } else {
        return "NO hay productos en el carrito";
    }
});

Route::get('favorito-mostrar', function () {
    if (Cart::instance('wishlist')->count()) {
        return Cart::instance('wishlist')->content();
    } else {
        return "NO hay productos en el favorito";
    }
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
