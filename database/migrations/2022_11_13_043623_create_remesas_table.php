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
        Schema::create('remesas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable(true);
            $table->string('nombre_cliente');
            $table->string('telefono');
            $table->string('direccion');
            $table->foreignId('municipio_id');
            $table->decimal('cantidad', 8, 2)->default(0);
            $table->foreignId('moneda_id');
            $table->decimal('comision', 8, 2)->default(0);
            $table->boolean('estado')->default(false);
            $table->foreignId('mensajero_id')->nullable(true);
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
        Schema::dropIfExists('remesas');
    }
};
