<?php

use App\Models\Municipio;
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
        Schema::create('municipios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->foreignId('provincia_id');
            $table->timestamps();
        });
        //fill data with habana municipalities
        $data = array(
            [
                'nombre' => 'Arroyo Naranjo',
                'provincia_id' => 1,
            ],
            [
                'nombre' => 'Boyeros',
                'provincia_id' => 1,
            ], 
            [
                'nombre' => 'Centro Habana',
                'provincia_id' => 1,
            ],
            [
                'nombre' => 'Cerro',
                'provincia_id' => 1,
            ],
            [
                'nombre' => 'Cotorro',
                'provincia_id' => 1,
            ],
            [
                'nombre' => 'Diez de Octubre',
                'provincia_id' => 1,
            ],
            [
                'nombre' => 'Guanabacoa',
                'provincia_id' => 1,
            ],
            [
                'nombre' => 'Habana del Este',
                'provincia_id' => 1,
            ],
            [
                'nombre' => 'Habana Vieja',
                'provincia_id' => 1,
            ],
            [
                'nombre' => 'La Lisa',
                'provincia_id' => 1,
            ],
            [
                'nombre' => 'Marianao',
                'provincia_id' => 1,
            ],
            [
                'nombre' => 'Playa',
                'provincia_id' => 1,
            ],
            [
                'nombre' => 'Plaza',
                'provincia_id' => 1,
            ],
            [
                'nombre' => 'Regla',
                'provincia_id' => 1,
            ],
            [
                'nombre' => 'San Miguel del Padron',
                'provincia_id' => 1,
            ],
        );

        foreach($data as $dataFill) {
            $munipality = new Municipio();
            $munipality->nombre = $dataFill['nombre'];
            $munipality->provincia_id = $dataFill['provincia_id'];
            $munipality->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('municipios');
    }
};
