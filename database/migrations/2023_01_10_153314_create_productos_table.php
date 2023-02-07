<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Producto;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();

            $table->string('nombre')->unique();
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->float('precio_venta');
            $table->float('precio_real');
            $table->integer('stock_total')->nullable();
            $table->text('descripcion');
            $table->text('informacion');
            $table->integer('puntos_ganar')->default(0);
            $table->string('link_video')->nullable();
            $table->boolean('incluye_igv')->default(false);
            $table->boolean('tiene_detalle')->default(false);
            $table->text('detalle')->nullable();
            $table->enum('estado', [Producto::DESACTIVADO, Producto::ACTIVADO])->default(Producto::DESACTIVADO);

            $table->unsignedBigInteger('subcategoria_id');
            $table->unsignedBigInteger('marca_id');
            $table->unsignedBigInteger('proveedor_id');

            $table->foreign('subcategoria_id')->references('id')->on('subcategorias');
            $table->foreign('marca_id')->references('id')->on('marcas');
            $table->foreign('proveedor_id')->references('id')->on('proveedors');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
