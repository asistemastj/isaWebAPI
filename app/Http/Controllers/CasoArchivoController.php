<?php

namespace App\Http\Controllers;

use App\Caso;
use App\Archivo;
use Illuminate\Http\Request;

class CasoArchivoController extends Controller
{
    public function index(Caso $caso)
    {
        #listamos los archivos de un caso
        $archivos = $caso->archivos;
        return response()->json(['archivos' => $archivos, 'code' => '200']);
    }

    public function store(Request $request, Caso $caso)
    {
        #validación
        $this->validate($request, [
            'nombre' => 'required|file',
        ]);
        $data = $request->all();
        $data['nombre'] = $request->nombre->store('archivo');;
        $data['caso_id'] = $caso->id;
        #creamos archivo
        $archivo = Archivo::create($data);
        return response()->json(['archivo' => $archivo, 'code' => 200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Caso  $caso
     * @return \Illuminate\Http\Response
     */
    public function show(Caso $caso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Caso  $caso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Caso $caso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Caso  $caso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Caso $caso)
    {
        //
    }
}
