<?php

namespace App\Http\Controllers;

use App\PedidoAlmacenDetalle;
use App\Periodo;
use Illuminate\Http\Request;

class DespachoTjoselitoController extends Controller
{
    public function index(){
        $periodo=date("Ym");
        $query = Periodo::on('tjoselito')->where('codigo', '=', $periodo)->get();
        //consulta
        $despachos = PedidoAlmacenDetalle::on('tjoselito')
            ->join('pedidoalmacen', 'pedidoalmacen_detalle.parent_id', '=','pedidoalmacen.id')
            ->join('almacen', 'pedidoalmacen.almacen_id', '=','almacen.id')
            ->join('comun.tercero', 'pedidoalmacen.tercero_id', '=','comun.tercero.id')
            ->join('undtransporte', 'pedidoalmacen_detalle.centrocosto_id', '=','undtransporte.centrocosto_id')
            ->join('indpetroleo', 'pedidoalmacen.id', '=','indpetroleo.parent_id')
            ->where([
                ['pedidoalmacen_detalle.producto_id',781],
                ['pedidoalmacen.estado', '<>', 'ANULADO'],
                ['pedidoalmacen.periodo_id', '=', $query->first()->id]
            ])->select('pedidoalmacen.fecha','indpetroleo.hora', 'pedidoalmacen.numero', 'pedidoalmacen_detalle.item', 'undtransporte.placa', 'pedidoalmacen_detalle.cantidad', 'almacen.descripcion', 'comun.tercero.codigo', 'comun.tercero.descripcion', 'indpetroleo.odometro', 'indpetroleo.hubometro', 'indpetroleo.scngalonaje', 'indpetroleo.scnkm', 'pedidoalmacen.glosa', 'pedidoalmacen.estado')
            ->orderBy('pedidoalmacen.fecha', 'desc')
            ->orderBy('pedidoalmacen.numero', 'desc')
            ->orderBy('pedidoalmacen_detalle.item')
            ->get();
            return response()->json(['data' => $despachos]);
    }
}
