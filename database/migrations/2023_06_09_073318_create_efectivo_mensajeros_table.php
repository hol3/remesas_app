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
        Schema::create('efectivo_mensajeros', function (Blueprint $table) {
            $table->id();
            $table->decimal('cantidad', 8, 2);
            $table->foreignId('moneda_id');
            $table->foreignId('mensajero_id');
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
        Schema::dropIfExists('efectivo_mensajeros');
    }
};
