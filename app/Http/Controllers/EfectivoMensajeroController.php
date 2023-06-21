<?php

namespace App\Http\Controllers;

use App\Models\EfectivoMensajero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EfectivoMensajeroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        echo("hola mundo");
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

        
        return redirect(route('mensajero.show', $request->mensajero_id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EfectivoMensajero  $efectivoMensajero
     * @return \Illuminate\Http\Response
     */
    public function show(EfectivoMensajero $efectivoMensajero)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EfectivoMensajero  $efectivoMensajero
     * @return \Illuminate\Http\Response
     */
    public function edit(EfectivoMensajero $efectivoMensajero)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EfectivoMensajero  $efectivoMensajero
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EfectivoMensajero $efectivoMensajero)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EfectivoMensajero  $efectivoMensajero
     * @return \Illuminate\Http\Response
     */
    public function destroy(EfectivoMensajero $efectivoMensajero)
    {
        //
    }
}
