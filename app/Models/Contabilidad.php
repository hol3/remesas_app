<?php

namespace App\Models;

use App\Enums\EntradaSalida;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contabilidad extends Model
{
    //
    use HasFactory;

    protected $cast = [
        'concepto' => EntradaSalida::class,
    ];

    public function moneda(): BelongsTo
    {
        return $this->belongsTo(Moneda::class);
    }
}
