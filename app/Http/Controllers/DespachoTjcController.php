<?php

namespace App\Http\Controllers;

use App\PedidoAlmacenDetalle;
use App\Periodo;
use Illuminate\Http\Request;

class DespachoTjcController extends Controller
{
    public function index(){
        $periodo=date("Ym");
        $query = Periodo::on('tjc')->where('codigo', '=', $periodo)->get();
        //consulta
        $despachos = PedidoAlmacenDetalle::on('tjc')
            ->join('pedidoalmacen', 'pedidoalmacen_detalle.parent_id', '=','tjc.pedidoalmacen.id')
            ->join('tjc.almacen', 'pedidoalmacen.almacen_id', '=','tjc.almacen.id')
            ->join('comun.tercero', 'pedidoalmacen.tercero_id', '=','comun.tercero.id')
            ->join('tjc.undtransporte', 'pedidoalmacen_detalle.centrocosto_id', '=','tjc.undtransporte.centrocosto_id')
            ->join('tjc.indpetroleo', 'pedidoalmacen.id', '=','tjc.indpetroleo.parent_id')
            ->where([
                ['pedidoalmacen_detalle.producto_id',781],
                ['tjc.pedidoalmacen.estado', '<>', 'ANULADO'],
                ['tjc.pedidoalmacen.periodo_id', '=', $query->first()->id]
            ])->select('tjc.pedidoalmacen.fecha','tjc.indpetroleo.hora', 'tjc.pedidoalmacen.numero', 'pedidoalmacen_detalle.item', 'tjc.undtransporte.placa', 'pedidoalmacen_detalle.cantidad', 'tjc.almacen.descripcion', 'comun.tercero.codigo', 'comun.tercero.descripcion', 'tjc.indpetroleo.odometro', 'tjc.indpetroleo.hubometro', 'tjc.indpetroleo.scngalonaje', 'tjc.indpetroleo.scnkm', 'tjc.pedidoalmacen.glosa', 'tjc.pedidoalmacen.estado')
            ->orderBy('tjc.pedidoalmacen.fecha', 'desc')
            ->orderBy('tjc.pedidoalmacen.numero', 'desc')
            ->orderBy('tjc.pedidoalmacen_detalle.item')
            ->get();
            return response()->json(['data' => $despachos]);
    }


}
