<?php

namespace App\Http\Controllers;

use App\Enums\RemesaEstados;
use App\Models\EfectivoEnCaja;
use App\Models\Mensajero;
use App\Models\Moneda;
use App\Models\Remesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class RemesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $monedas = Moneda::all();
        $mensajeros = Mensajero::all();

        $data = [];

        $result = Remesa::orderBy('created_at', 'desc')->paginate(20);

        $remesas = array();

        foreach ($result as $item) {
            array_push($remesas, [
                'id' => $item->id,
                'codigo' => $item->codigo,
                'nombre_cliente' => $item->nombre_cliente,
                'telefono' => $item->telefono,
                'localidad' => $item->localidad,
                'direccion' => $item->direccion,
                'cantidad' => $item->cantidad,
                'moneda' => $item->moneda->nombre,
                'comision' => $item->comision,
                'moneda_comision' => $item->comision,
                'mensajero' => $item->mensajero->nombre,
                'estado' => $item->estado,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at
            ]);
        }

        // dump($remesas);

        return Inertia::render('Remesas/Index', [
            // 'remesas' => $this->get(),
            'pagination' => $result,
            'provincias' => $data,
            'monedas' => $monedas,
            'mensajeros' => $mensajeros,

            // 'remesas' => Inertia::lazy(fn () => $this->get())
        ]);
    }

    public function get()
    {
        $result = Remesa::orderBy('created_at', 'desc')->paginate(20);

        $remesas = array();

        foreach ($result as $item) {
            array_push($remesas, [
                'id' => $item->id,
                'codigo' => $item->codigo,
                'nombre_cliente' => $item->nombre_cliente,
                'telefono' => $item->telefono,
                'localidad' => $item->localidad,
                'direccion' => $item->direccion,
                'cantidad' => $item->cantidad,
                'moneda' => $item->moneda->nombre,
                'comision' => $item->comision,
                'moneda_comision' => $item->comision,
                'mensajero' => $item->mensajero->nombre,
                'estado' => $item->estado,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at
            ]);
        }

        return $remesas;
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

        Validator::make($request->all(),[
            'nombre_cliente' => ['required'],
            'direccion' => ['required'],
            'localidad' => ['required'],
            'comision' => ['required'],
            'moneda_comision' => ['required'],
            'cantidad' => ['required'],
            'moneda_id' => ['required'],
            'mensajero_id'=> ['required'],
        ])->validate();

        $remesa = new Remesa();
        $remesa->codigo = $request->codigo;
        $remesa->nombre_cliente = $request->nombre_cliente;
        $remesa->direccion = $request->direccion;
        $remesa->localidad = $request->localidad;
        $remesa->telefono = $request->telefono;
        $remesa->cantidad = $request->cantidad;
        $remesa->moneda_id = $request->moneda_id;
        $remesa->comision = $request->comision;
        $remesa->comicion_moneda_id = $request->moneda_comision;
        $remesa->mensajero_id = $request->mensajero_id;
        $remesa->referencia = $request->referencia;

        $remesa->save();

        return redirect(route('remesas.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Remesa  $remesa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $remesa = Remesa::find($id);
        dump($remesa);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Remesa  $remesa
     * @return \Illuminate\Http\Response
     */
    public function edit(Remesa $remesa)
    {
        $monedas = Moneda::all();
        $mensajeros = Mensajero::all();

        //
        return Inertia::render('Remesas/Edit', [
            'item' => $remesa,
            'monedas' => $monedas,
            'mensajeros' => $mensajeros,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Remesa  $remesa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Remesa $remesa)
    {
        $remesa->codigo = $request->codigo;
        $remesa->nombre_cliente = $request->nombre_cliente;
        $remesa->direccion = $request->direccion;
        $remesa->localidad = $request->localidad;
        $remesa->telefono = $request->telefono;
        $remesa->cantidad = $request->cantidad;
        $remesa->moneda_id = $request->moneda_id;
        $remesa->comision = $request->comision;
        $remesa->mensajero_id = $request->mensajero_id;

        $remesa->save();

        // return redirect()->route('remesas.index'); //->with('message', 'Book Updated Successfully');
        return redirect()->back();
    }

    public function closeDelivery(Request $request)
    {
        $remesa = Remesa::find($request->id);
        $remesa->estado = RemesaEstados::Completado;
        $remesa->save();

        // return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Remesa  $remesa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $remesa = new Remesa();
        $remesa->destroy($id);
    }
}
