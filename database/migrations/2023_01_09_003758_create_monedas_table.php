<?php

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
        Schema::create('monedas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->timestamps();
        });

        //Fill default data
        $data = array(
            [
                'currency' => 'USD',
            ],
            [
                'currency' => 'CUP',
            ],
            [
                'currency' => 'EUR',
            ]
        );

        foreach ($data as $datafill) {
            $currency = new Moneda();
            $currency->nombre = $datafill['currency'];
            $currency->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monedas');
    }
};
