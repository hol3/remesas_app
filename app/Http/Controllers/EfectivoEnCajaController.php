<?php

namespace App\Http\Controllers;

use App\Models\EfectivoEnCaja;
use App\Models\Moneda;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EfectivoEnCajaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = EfectivoEnCaja::latest('id')->paginate(100);
        $dinero = [];

        foreach($result as $item)
        {
            array_push($dinero, [
                'id' => $item->id,
                'cantidad' => $item->cantidad,
                'moneda' => $item->moneda->nombre,
                'moneda_id' => $item->moneda->id,
                'created_at' => $item->created_at,
            ]);
        }

        $monedas = Moneda::all();

        return Inertia::render('Efectivo/index', [
            'pagination' => $result,
            'efectivo' => $dinero,
            'monedas' => $monedas
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
        $dinero = new EfectivoEnCaja();
        $dinero->cantidad = $request->cantidad;
        $dinero->moneda_id = $request->moneda_id;
        $dinero->save();

        return redirect(route('dinero.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EfectivoEnCaja  $efectivoEnCaja
     * @return \Illuminate\Http\Response
     */
    public function show(EfectivoEnCaja $efectivoEnCaja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EfectivoEnCaja  $efectivoEnCaja
     * @return \Illuminate\Http\Response
     */
    public function edit(EfectivoEnCaja $efectivoEnCaja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EfectivoEnCaja  $efectivoEnCaja
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EfectivoEnCaja $efectivoEnCaja)
    {
        //
        $efectivoEnCaja = EfectivoEnCaja::find($request->id);
        $efectivoEnCaja->USD = $request->USD;
        $efectivoEnCaja->CUP = $request->CUP;
        $efectivoEnCaja->EUR = $request->EUR;
        $efectivoEnCaja->save();

        return redirect(route('dinero.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EfectivoEnCaja  $efectivoEnCaja
     * @return \Illuminate\Http\Response
     */
    public function destroy(EfectivoEnCaja $efectivoEnCaja)
    {
        //
    }
}
