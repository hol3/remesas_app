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
        Schema::create('efectivo_mensajeros', function (Blueprint $table) {
            $table->id();
            $table->decimal('cantidad', 10, 2);
            $table->foreignIdFor(Moneda::class);
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
        Schema::dropIfExists('efectivo_mensajeros');
    }
};
