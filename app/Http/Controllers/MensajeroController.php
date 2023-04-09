<?php

namespace App\Http\Controllers;

use App\Models\Mensajero;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MensajeroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = array();

        $mensajeros = Mensajero::all();

        foreach ($mensajeros as $item)
        {
            array_push($data, [
                'id' => $item->id,
                'nombre' => $item->nombre,
                'telefono' => $item->telefono,
                'comision' => $item->comision,
                'totalEntregas' => $item->remesas->count(),
                'totalPendientes' => $item->remesas->where('estado', 0)->count(),
                'entregasPendientes' => $item->remesas->where('estado', 0)
            ]);
        }

        // dump($mensajeros[1]->remesas);

        return Inertia::render('Mensajeros/Index', [
            'mensajeros' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $mensajero = new Mensajero();
        $mensajero->nombre = $request->nombre;
        $mensajero->telefono = $request->telefono;
        $mensajero->comision = $request->comision;
        $mensajero->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mensajero  $mensajero
     * @return \Illuminate\Http\Response
     */
    public function show(Mensajero $mensajero)
    {
        //
        $item = $mensajero->remesas;
        $pagination = $mensajero->remesas()->latest('id')->paginate(20);
        $pendientes = $mensajero->remesas()->where('estado', 0)->count();
        $entregadasHoy = $mensajero->remesas()->where('estado', 1)->whereDate('updated_at', Carbon::today())->count();
        $entregasHoy = $mensajero->remesas()->where('estado', 1)->whereDate('updated_at', Carbon::today())->get();
 
        $remesas = array();

        $cobro = 0;

        if($mensajero->comision > 0){
            $cobro = $entregadasHoy * $mensajero->comision;
        }else{
            foreach($entregasHoy as $entrega){
                $cobro += $entrega->comision;
            }
        }

        foreach ($pagination as $item) {
            array_push($remesas, [
                'id' => $item->id,
                'codigo' => $item->codigo,
                'nombre_cliente' => $item->nombre_cliente,
                'telefono' => $item->telefono,
                'direccion' => $item->direccion,
                'provincia' => $item->municipio->provincia->nombre,
                'municipio' => $item->municipio->nombre,
                'cantidad' => $item->cantidad,
                'moneda' => $item->moneda->nombre,                
                'comision' => $this->comision($mensajero->comision, $item->comision),
                'mensajero' => $item->mensajero->nombre,
                'estado' => $item->estado,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at
            ]);
        }

        // dump($entregasHoy);
        return Inertia::render('Mensajeros/Show', [
            'mensajero' => $mensajero,
            'remesas' => $remesas,
            'pendientes' => $pendientes,
            'pagination' => $pagination,
            'cobroHoy' => $cobro,
        ]);
    }

    private function CalcularComision($comision, $entregas)
    {
        $result = 0;
        if($comision > 0){
            $result = count($entregas) * $comision;
        }else{
            foreach($entregas as $entrega){
                $result += $entrega->comision;
            }
        }
        return $result;
    }

    private function comision($x, $y)
    {
        if($x > 0){
            return $x;
        }else{
            return $y;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mensajero  $mensajero
     * @return \Illuminate\Http\Response
     */
    public function edit(Mensajero $mensajero)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mensajero  $mensajero
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mensajero $mensajero)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mensajero  $mensajero
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mensajero $mensajero)
    {
        //
    }
}
