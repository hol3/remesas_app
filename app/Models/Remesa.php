<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Remesa extends Model
{
    use HasFactory;

    public function municipio() : BelongsTo
    {
        return $this->belongsTo(Municipio::class);
    }

    public function mensajero() : BelongsTo
    {
        return $this->belongsTo(Mensajero::class);
    }

    public function moneda() : BelongsTo
    {
        return $this->belongsTo(Moneda::class);
    }    
}
