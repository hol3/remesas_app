<?php

namespace App\Enums;

enum RemesaEstados : string
{
    case Pendiente = 'pendiente';
    case Enviado = 'enviado';
    case Completado = 'completado';
}
