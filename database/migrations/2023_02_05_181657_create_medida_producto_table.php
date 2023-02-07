<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medida_producto', function (Blueprint $table) {
            $table->id();

            $table->integer('stock');

            $table->unsignedBigInteger('medida_id');
            $table->unsignedBigInteger('producto_id');

            $table->foreign('medida_id')->references('id')->on('medidas')->onDelete('cascade');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

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
        Schema::dropIfExists('medida_producto');
    }
};
