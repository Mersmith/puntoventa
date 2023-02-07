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
        Schema::create('compras', function (Blueprint $table) {
            $table->id();

            $table->enum('estado', [Compra::PENDIENTE, Compra::PAGADO, Compra::ORDENADO, Compra::ENVIADO, Compra::ENTREGADO, Compra::ANULADO])->default(Compra::PENDIENTE);
            $table->float('total');
            $table->float('impuesto');
            
            $table->unsignedBigInteger('proveedor_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('proveedor_id')->references('id')->on('proveedors');
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
        Schema::dropIfExists('compras');
    }
};
