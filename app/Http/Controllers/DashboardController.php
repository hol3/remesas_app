<?php

namespace App\Http\Controllers;

use App\Models\EfectivoEnCaja;
use App\Models\Moneda;
use App\Models\Remesa;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function index()
    {

        /**
         * Remesas
         */
        //Total
        $total = Remesa::all()->count();
        //Total entregadas
        $totalEntregadas = Remesa::where('estado', 1)->count();
        //Total pendientes
        $totalPendientes = Remesa::where('estado', 0)->count();
        //Remesas sin entregar
        $remesas = Remesa::where('estado', 0)->latest('id')->paginate(10);
        // $remesasSinEntregar = Remesa::where('estado', '=', 0);

        $remesasSixMonth = Remesa::where("created_at", ">", Carbon::now()->subWeek()->format("Y-m-d H:i:s"))->get();

        $data = array();

        foreach ($remesas as $item) {
            array_push($data, [
                'id' => $item->id,
                'codigo' => $item->codigo,
                'nombre_cliente' => $item->nombre_cliente,
                'telefono' => $item->telefono,
                'direccion' => $item->direccion,
                'municipio' => $item->municipio->nombre,
                'cantidad' => $item->cantidad,
                'moneda' => $item->moneda->nombre,
                'comision' => $item->comision,
                'created_at' => $item->created_at,
            ]);
        }

        /**
         * FIN REMESAS
         */

         /**
          * EFECTIVO EN CAJA
          */

        $efectivoTotal = [];
        $totalEntregado = [];
        $totalEnCaja = [];
        $efectivoPendiente = [];
        
        foreach(Moneda::all() as $item)
        {
            array_push($efectivoTotal, [
                $item->nombre => EfectivoEnCaja::where('moneda_id', $item->id)->sum('cantidad')
            ]);
            array_push($totalEntregado, [
                $item->nombre => Remesa::where('moneda_id', $item->id)->sum('cantidad')
            ]);
            array_push($totalEnCaja, [
                'id' => $item->id,
                'nombre' => $item->nombre,
                'cantidad' => $this->calcularEfectivo($item),
            ]);
            array_push($efectivoPendiente, [
                'id' => $item->id,
                'nombre' => $item->nombre,
                'cantidad' => $this->efectivoPendiente($item),
            ]);
        }

        // dump($totalEnCaja);

        // dump($remesasSixMonth);

        // dd($efectivoPendiente);
        

        //Leyendo entregas desde la ultima recogida de dinero
        //$entregas = Remesa::whereDate();
        
        
        // $dinero = "";
        return Inertia::render('Dashboard', [
            'total' => $total,
            'entregadas' => $totalEntregadas,
            'pendientes' => $totalPendientes,
            'totalencaja' => $totalEnCaja,
            'remesas' => $data,
            'pagination' => $remesas,
            'dineroPendiente' => $efectivoPendiente,
        ]);
    }

    private function calcularEfectivo($moneda)
    {
        if($moneda->nombre === "CUP")
        {
            $total = EfectivoEnCaja::where('moneda_id', $moneda->id)->sum('cantidad') - Remesa::where('moneda_id', $moneda->id)->sum('cantidad') - Remesa::sum('comision');
        }
        else
        {
            $total = EfectivoEnCaja::where('moneda_id', $moneda->id)->sum('cantidad') - Remesa::where('moneda_id', $moneda->id)->sum('cantidad');
        }
        return $total;
    }

    private function efectivoPendiente($moneda)
    {
        $total = Remesa::where('moneda_id', $moneda->id)->where('estado', 0)->sum('cantidad');
        return $total;
    }
}
