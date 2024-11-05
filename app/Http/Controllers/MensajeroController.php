<?php

namespace App\Http\Controllers;

use App\Models\EfectivoMensajero;
use App\Models\Mensajero;
use App\Models\Moneda;
use App\Models\Remesa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
                'tiene_efectivo' => $item->tiene_efectivo,
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
        $mensajero->tiene_efectivo = $request->tiene_efectivo;
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
        // $item = $mensajero->remesas;
        // $pagination = $mensajero->remesas()->where('estado',0)->orderBy('estado')->orderBy('created_at', 'desc')->paginate(20);
        $pendientes = $mensajero->remesas()->where('estado', 0)->count();
        // $remesasPendientes = $mensajero->remesas()->where('estado', 0)->get();
        // $entregadasHoy = $mensajero->remesas()->where('estado', 1)->whereDate('updated_at', Carbon::today())->count();
        // $entregasHoy = $mensajero->remesas()->where('estado', 1)->whereDate('updated_at', Carbon::today())->get();

        $cobro = 0;
        $cobroPendiente = 0;

        // dd($remesasPendientes);

        if($mensajero->comision > 0){
            $cobro = $mensajero->remesas()->where('estado', 1)->whereDate('updated_at', Carbon::today())->count() * $mensajero->comision;
            $cobroPendiente = $pendientes * $mensajero->comision;            
        }else{
            $cobroPendiente = $mensajero->remesas()->where('estado', 0)->sum('comision');
            $cobro = $mensajero->remesas()->where('estado', 1)->whereDate('updated_at', Carbon::today())->sum('comision');
        }

        $efectivo = [];
        $ultimaAsignacion = [];

        foreach (Moneda::all() as $item)
        {
            //calcular el efectivo en caja solo si el mensajero tiene efectivo asignado
            if($mensajero->tiene_efectivo === 1)
            {
                array_push($efectivo, [
                    // $item->nombre => Remesa::where('moneda_id', $item->id)->where('mensajero_id' ,$mensajero->id)->sum('cantidad')
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'cantidadPorEntregar' => $this->EfectivoXEntregar($item, $mensajero),
                    'cantidadEnCaja' => $this->EfectivoEnCaja($item, $mensajero)
                ]);

                array_push($ultimaAsignacion, [
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'asignacion' => $this->ultimaAsignacion($mensajero->id, $item->id),
                ]);
            }
            else
            {
                array_push($efectivo, [
                    // $item->nombre => Remesa::where('moneda_id', $item->id)->where('mensajero_id' ,$mensajero->id)->sum('cantidad')
                    'id' => $item->id,
                    'nombre' => $item->nombre,
                    'cantidadPorEntregar' => $this->EfectivoXEntregar($item, $mensajero),
                    'cantidadEnCaja' => 'No tiene'
                ]);
            }          
        }
        
        // dd($pagination);

        return Inertia::render('Mensajeros/Show', [
            'mensajero' => $mensajero,
            // 'remesas' => $remesasPendientes,
            'pendientes' => $pendientes,
            'cobroPendiente' => $cobroPendiente,
            'ultimaAsignacion' => $ultimaAsignacion,
            // 'pagination' => $pagination,
            'cobroHoy' => $cobro,            
            'efectivo' => $efectivo,
            'monedas' => Moneda::all()
        ]);
    }

    public function getRemesas(Mensajero $mensajero)
    {
        $items = $mensajero->remesas()->orderBy('estado')->orderBy('created_at', 'desc')->paginate(20);

        $remesas = array();

        foreach ($items as $item) {
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

        return response()->json($remesas);
    }
    
    private function ultimaAsignacion($mensajero_id, $moneda_id)
    {
        $query = EfectivoMensajero::where('mensajero_id', $mensajero_id)->where('moneda_id', $moneda_id)->latest('created_at')->first();
        if($query != null)
        {
            return $query;
        }
        else
        {
            return 0;
        }
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

    public function addEfectivo(Request $request)
    {
        //
        Validator::make($request->all(), [
            'cantidad' => ['required'],
            'moneda_id' => ['required'],
            'mensajero_id' => ['required'],
        ])->validate();

        $efectivo = new EfectivoMensajero();
        $efectivo->cantidad = $request->cantidad;
        $efectivo->moneda_id = $request->moneda_id;
        $efectivo->mensajero_id = $request->mensajero_id;
        $efectivo->save();
        
        // dump($efectivo);
        
        return back();
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
        return Inertia::render('Mensajeros/Edit', [
            'mensajero' => $mensajero,
        ]);

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
        $mensajero->nombre = $request->nombre;
        $mensajero->telefono = $request->telefono;
        $mensajero->comision = $request->comision;
        $mensajero->tiene_efectivo = $request->tiene_efectivo;

        $mensajero->save();
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

    private function EfectivoEnCaja($moneda, $mensajero)
    {
        if($moneda->nombre === "CUP")
        {
            $total = EfectivoMensajero::where('moneda_id', $moneda->id)->where('mensajero_id', $mensajero->id)->sum('cantidad') - Remesa::where('moneda_id', $moneda->id)->where('mensajero_id', $mensajero->id)->sum('cantidad') - $mensajero->comision * Remesa::where('mensajero_id', $mensajero->id)->count();
        }
        else
        {
            $total = EfectivoMensajero::where('moneda_id', $moneda->id)->where('mensajero_id', $mensajero->id)->sum('cantidad') - Remesa::where('moneda_id', $moneda->id)->where('mensajero_id', $mensajero->id)->sum('cantidad');
        }
        return $total;
    }

    private function EfectivoXEntregar($moneda, $mensajero)
    {
        if($mensajero->comision > 0){
            if($moneda->nombre === "CUP")
            {
                $total = Remesa::where('moneda_id', $moneda->id)->where('mensajero_id', $mensajero->id)->where('estado', 0)->sum('cantidad') + $mensajero->comision * Remesa::where('mensajero_id', $mensajero->id)->where('estado', 0)->count();
            }
            else
            {
                $total = Remesa::where('moneda_id', $moneda->id)->where('mensajero_id', $mensajero->id)->where('estado', 0)->sum('cantidad');
            }
        }else{
            if($moneda->nombre === "CUP")
            {
                $total = Remesa::where('moneda_id', $moneda->id)->where('mensajero_id', $mensajero->id)->where('estado', 0)->sum('cantidad') + Remesa::where('mensajero_id', $mensajero->id)->where('estado', 0)->sum('comision');
            }
            else
            {
                $total = Remesa::where('moneda_id', $moneda->id)->where('mensajero_id', $mensajero->id)->where('estado', 0)->sum('cantidad');
            }
        }
        return $total;
    }
}
