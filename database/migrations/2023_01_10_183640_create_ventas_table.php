<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Compra;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();

            $table->enum('estado', [Compra::PENDIENTE, Compra::PAGADO, Compra::ORDENADO, Compra::ENVIADO, Compra::ENTREGADO, Compra::ANULADO])->default(Compra::PENDIENTE);
            $table->float('total');
            $table->float('impuesto');
            $table->enum('tipo_envio', [1, 2]);
            $table->json('envio')->nullable();
            $table->float('costo_envio');
            $table->string('puntos_canjeados')->nullable();
            $table->string('cupon_descuento')->nullable();
            $table->string('cupon_precio')->nullable();

            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('ventas');
    }
};
