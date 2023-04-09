<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mensajero extends Model
{
    use HasFactory;

    public function remesas() : HasMany
    {
        return $this->hasMany(Remesa::class);
    }

    protected $fillable = [
        'nombre',
        'telefono',
        'comision'
    ];
}
