<?php

namespace App\Http\Controllers;

use App\Caso;
use Illuminate\Http\Request;

class CasoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $casos = Caso::all();
        return response()->json(['casos' => $casos]);
    }

}
