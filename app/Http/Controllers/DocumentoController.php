<?php

namespace App\Http\Controllers;

use App\Documento;
use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    public function index()
    {
        #listar documentos
        $documentos = Documento::all();
        return response()->json(['documentos' => $documentos]);
    }
}
