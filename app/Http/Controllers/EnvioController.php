<?php

namespace App\Http\Controllers;

use App\Envio;
use Illuminate\Http\Request;

class EnvioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #listar envios
        $envios = Envio::all();
        return response()->json(['envios' => $envios]);
    }
}
