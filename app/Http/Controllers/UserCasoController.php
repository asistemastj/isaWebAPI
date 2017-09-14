<?php

namespace App\Http\Controllers;

use App\Caso;
use App\User;
use App\Archivo;
use Illuminate\Http\Request;

class UserCasoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $usuario)
    {   
        #casos de 1 determinado usuario
        $casos = $usuario->casos;
        return response()->json(['casos' => $casos]);
    }

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $usuario)
    {
        #validación
        $this->validate($request, [
            'titulo' => 'required|max:100',
            'contenido' => 'required|max:255',
            'conclusion' => 'nullable|string',
            'fecha' => 'date',
            'archivo' => 'required'
        ]);
        #si pasavalidacio
        $data = $request->all();
        $data['fecha'] = date("Y-m-d");
        $data['user_id'] = $usuario->id;
        #guardamos la imagen en nustra carpeta
        $data['archivo'] = $request->archivo;
        #$data['archivo'] = $request->archivo->store('');
        #creamos caso
        $caso = Caso::create($data);
        #tomamos el archivo y lo guardamos en db
        $archivo = new Archivo();
        $archivo->nombre = $request->archivo;
        #$archivo->nombre = $request->archivo->store('');
        $archivo->caso_id = $caso->id;
        #guardamos archivo
        $archivo->save();
        return response()->json(['caso' => $caso, 'code' => 201]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $usuario, Caso $caso)
    {
        #el usuario solo puede borrar su propio caso
        if($usuario->id == $caso->user_id){
            $caso->delete();
            return response()->json(['data' => $caso]);
        }
    }
}
