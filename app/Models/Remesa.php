<?php

namespace App\Models;

use App\Enums\RemesaEstados;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Remesa extends Model
{
    use HasFactory;

    protected $cast = [
        'estado' => RemesaEstados::class
    ];

    public function mensajero() : BelongsTo
    {
        return $this->belongsTo(Mensajero::class);
    }

    public function moneda() : BelongsTo
    {
        return $this->belongsTo(Moneda::class);
    }

    public function monedaComision() : BelongsTo
    {
        return $this->belongsTo(Moneda::class, 'comision_moneda_id');
    }
}
