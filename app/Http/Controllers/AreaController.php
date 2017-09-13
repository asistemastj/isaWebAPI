<?php

namespace App\Http\Controllers;

use App\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        #lista de areas
        $areas = Area::all();
        return response()->json(['areas' => $areas]);
    }

}
