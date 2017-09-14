<?php

namespace App\Http\Controllers;

use App\Area;
use Illuminate\Http\Request;

class AreaUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Area $area)
    {
        $usuarios = $area->usuarios;
        return response()->json(['usuarios' => $usuarios, 'code' => 201]);
    }
}
