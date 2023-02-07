<?php

use App\Http\Controllers\Administrador\Ckeditor5Controller;
use App\Http\Controllers\Administrador\CompraController;
use App\Http\Controllers\Administrador\ProductoController;
use App\Http\Livewire\Administrador\Categoria\CategoriaLivewire;
use App\Http\Livewire\Administrador\Cliente\ClienteCrearLivewire;
use App\Http\Livewire\Administrador\Cliente\ClienteEditarLivewire;
use App\Http\Livewire\Administrador\Cliente\ClienteTodoLivewire;
use App\Http\Livewire\Administrador\Color\ColorLivewire;
use App\Http\Livewire\Administrador\Compra\CompraCrearLivewire;
use App\Http\Livewire\Administrador\Compra\CompraEditarLivewire;
use App\Http\Livewire\Administrador\Compra\CompraTodoLivewire;
use App\Http\Livewire\Administrador\Empresa\EmpresaLivewire;
use App\Http\Livewire\Administrador\Estadistica\EstadisticaLivewire;
use App\Http\Livewire\Administrador\Impresora\ImpresoraLivewire;
use App\Http\Livewire\Administrador\Marca\MarcaLivewire;
use App\Http\Livewire\Administrador\Perfil\PerfilLivewire;
use App\Http\Livewire\Administrador\Producto\ProductoCrearLivewire;
use App\Http\Livewire\Administrador\Producto\ProductoEditarLivewire;
use App\Http\Livewire\Administrador\Producto\ProductoTodoLivewire;
use App\Http\Livewire\Administrador\Proveedor\ProveedorLivewire;
use App\Http\Livewire\Administrador\Reporte\CompraDiaLivewire;
use App\Http\Livewire\Administrador\Reporte\CompraFechaLivewire;
use App\Http\Livewire\Administrador\Slider\SliderLivewire;
use App\Http\Livewire\Administrador\Subcategoria\SubcategoriaLivewire;
use App\Http\Livewire\Administrador\Tag\TagLivewire;
use Illuminate\Support\Facades\Route;

Route::get('prueba-administrador', function () {
    return "Amdministrador";
});

Route::get('perfil', PerfilLivewire::class)->name('perfil');

Route::get('categorias', CategoriaLivewire::class)->name('categoria.index');

Route::get('subcategoria/{categoria}', SubcategoriaLivewire::class)->name('subcategoria.index');

Route::get('colores', ColorLivewire::class)->name('color.index');

Route::get('marcas', MarcaLivewire::class)->name('marca.index');

Route::get('tags', TagLivewire::class)->name('tag.index');

Route::get('proveedores', ProveedorLivewire::class)->name('proveedor.index');

Route::get('productos', ProductoTodoLivewire::class)->name('producto.index');
Route::get('producto/crear', ProductoCrearLivewire::class)->name('producto.crear');
Route::get('producto/{producto}/editar', ProductoEditarLivewire::class)->name('producto.editar');
Route::post('ckeditor-upload', [Ckeditor5Controller::class, 'upload'])->name('ckeditor.upload');
Route::post('producto/{producto}/dropzone', [ProductoController::class, 'dropzone'])->name('producto.dropzone');

Route::get('clientes', ClienteTodoLivewire::class)->name('cliente.index');
Route::get('cliente/crear', ClienteCrearLivewire::class)->name('cliente.crear');
Route::get('cliente/{cliente}/editar', ClienteEditarLivewire::class)->name('cliente.editar');

Route::get('compras', CompraTodoLivewire::class)->name('compra.index');
Route::get('compra/crear', CompraCrearLivewire::class)->name('compra.crear');
Route::get('compra/{compra}/editar', CompraEditarLivewire::class)->name('compra.editar');
Route::get('compra/{compra}/pdf',  [CompraController::class, 'pdfCompra'])->name('compra.pdf');
Route::get('compra/{compra}/imprimir',  [CompraController::class, 'imprimirCompra'])->name('compra.imprimir');

Route::get('empresa', EmpresaLivewire::class)->name('empresa.index');
Route::get('impresoras', ImpresoraLivewire::class)->name('impresora.index');

Route::get('reportes/dia', CompraDiaLivewire::class)->name('reporte.dia');
Route::get('reportes/fechas', CompraFechaLivewire::class)->name('reporte.fecha');

Route::get('estadistica', EstadisticaLivewire::class)->name('estadistica.index');

Route::get('slider', SliderLivewire::class)->name('slider.index');
