<?php

namespace App\Http\Controllers;

use App\Enums\EntradaSalida;
use App\Models\Contabilidad;
use App\Models\Moneda;
use App\Models\Remesa;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContabilidadController extends Controller
{
    //
    public function index()
    {
        $dinero = Contabilidad::latest('id')->paginate(20);

        foreach($dinero as $item)
        {
            $item->moneda;
        }

        return Inertia::render('Contabilidad/index', [
            'efectivo' => $dinero,
            'monedas' => Moneda::all(),
            'estados' => EntradaSalida::cases(),
        ]);
    }

    public function store(Request $request)
    {
        $dinero = new Contabilidad();
        $dinero->cantidad = $request->cantidad;
        $dinero->moneda_id = $request->moneda_id;
        $dinero->concepto = $request->concepto;
        $dinero->nota = $request->nota;
        $dinero->save();

        return redirect()->route('contabilidad.index');
    }

    public function entrada(Request $request)
    {

    }

    public function salida(Remesa $remesa)
    {
        $dinero = new Contabilidad();
        $dinero->cantidad = -$remesa->cantidad;
        $dinero->moneda_id = $remesa->moneda_id;
        $dinero->concepto = EntradaSalida::Salida;
        $dinero->nota = $remesa->codigo;
        $dinero->save();

        $comision = new Contabilidad();
        $comision->cantidad = -$remesa->comision;
        $comision->moneda_id = $remesa->comision_moneda_id;
        $comision->concepto = EntradaSalida::Salida;
        $comision->nota = $remesa->codigo;
        $comision->save();
    }
}
