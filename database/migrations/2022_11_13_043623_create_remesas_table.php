<?php

use App\Models\Mensajero;
use App\Models\Moneda;
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
            $table->decimal('cantidad', 10, 2)->default(0);
            $table->foreignIdFor(Moneda::class);
            $table->decimal('comision', 10, 2)->default(0);
            $table->foreignId('comision_moneda_id');
            $table->string('localidad');
            $table->text('direccion');
            $table->text('referencia')->nullable(true);
            $table->string('estado')->default('pendiente');
            $table->foreignIdFor(Mensajero::class);
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
