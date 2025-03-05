<?php

namespace App\Http\Controllers;

use App\Models\Contabilidad;
use App\Models\EfectivoEnCaja;
use App\Models\Moneda;
use App\Models\Remesa;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use SebastianBergmann\CodeCoverage\Report\Xml\Totals;

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
        $totalEntregadas = Remesa::where('estado', 'completado')->count();
        //Total pendientes
        $totalPendientes = Remesa::whereNot('estado', 'completado')->count();
        //Remesas sin entregar
        $remesas = Remesa::whereNot('estado', 'completado')->latest('id')->get();
        // $remesasSinEntregar = Remesa::where('estado', '=', 0);

        $remesasSixMonth = Remesa::where("created_at", ">", Carbon::now()->subWeek()->format("Y-m-d H:i:s"))->get();

        // $data = array();

        // foreach ($remesas as $item) {
        //     array_push($data, [
        //         'id' => $item->id,
        //         'codigo' => $item->codigo,
        //         'nombre_cliente' => $item->nombre_cliente,
        //         'telefono' => $item->telefono,
        //         'localidad' => $item->localidad,
        //         'direccion' => $item->direccion,
        //         'cantidad' => $item->cantidad,
        //         'moneda' => $item->moneda->nombre,
        //         'comision' => $item->comision,
        //         'moneda_comision' => $item->comision,
        //         'mensajero' => $item->mensajero->nombre,
        //         'estado' => $item->estado,
        //         'created_at' => $item->created_at,
        //         'updated_at' => $item->updated_at
        //     ]);
        // }

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
                'cantidad' => Contabilidad::where('moneda_id', $item->id)->sum('cantidad'),
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
            'remesas' => $remesas,
            // 'pagination' => $remesas,
            'dineroPendiente' => $efectivoPendiente,
        ]);
    }

    private function calcularEfectivo($moneda)
    {
        if($moneda->nombre === "CUP")
        {
            $total = Contabilidad::where('moneda_id', $moneda->id)->sum('cantidad') - Remesa::where('moneda_id', $moneda->id)->sum('cantidad') - Remesa::sum('comision');
        }
        else
        {
            $total = Contabilidad::where('moneda_id', $moneda->id)->sum('cantidad') - Remesa::where('moneda_id', $moneda->id)->sum('cantidad');
        }
        return $total;
    }

    private function efectivoPendiente($moneda)
    {
        $total = Remesa::where('moneda_id', $moneda->id)->whereNot('estado', 'completado')->sum('cantidad');
        $total1 = Remesa::where('comision_moneda_id', $moneda->id)->whereNot('estado', 'completado')->sum('comision');
        // $result = Contabilidad::where('moneda_id', $moneda->id)->where('concepto', 'salida')->sum('cantidad');
        return $total + $total1;
    }
}
