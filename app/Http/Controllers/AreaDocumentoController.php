<?php

namespace App\Http\Controllers;

use App\Area;
use Illuminate\Http\Request;

class AreaDocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Area $area)
    {
        #documentos de una determinada area
        $documentos = $area->documentos;
        return response()->json(['documentos' => $documentos]);
    }
}
