<?php

namespace App\Http\Controllers;

use App\Archivo;
use Illuminate\Http\Request;

class ArchivoController extends Controller
{
    public function index()
    {
        #listar archivos
        $archivos = Archivo::all();
        return response()->json(['data' => $archivos]);
    }
}
