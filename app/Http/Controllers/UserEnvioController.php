<?php

namespace App\Http\Controllers;

use App\User;
use App\Envio;
use Illuminate\Http\Request;

class UserEnvioController extends Controller
{
    public function index(User $usuario)
    {
        #listar envios de un usuario
        $envios = $usuario->envios;
        return response()->json(['envios' => $envios]);
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
            'contenido' => 'required',
            'observacion' => 'nullable',
            'fechaEnvio' => 'date',
            'fechaLlegada' => 'nullable|date',
            'destinatario_id'=>'required|integer'
        ]);
        #si pasa validación
        $data = $request->all();
        $data['estado'] = Envio::ENVIO_NO_FINALIZADO;
        $data['fechaEnvio'] = date("Y-m-d");
        $data['user_id'] = $usuario->id;
        #creamos envio
        $envio = Envio::create($data);
        return response()->json(['envio' => $envio, 'code' => 201]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario, Envio $envio)
    {
        #si el envio pertenece al usuario
        if($usuario->id == $envio->user_id){
            #validación
            $this->validate($request, [
                'contenido' => 'string',
                'observacion' => 'string|min:6',
                'destinatario_id'=>'required|integer'
            ]);
            #solo entran
            $envio->fill($request->intersect([
              'contenido',
              'destinatario_id'
            ]));
            #si hay observacion
            if($request->has('observacion')){
              $envio->observacion = $request->observacion;
            }
            #ver si se modifico algo delenvio
            if(!$envio->isClean()){
              $envio->save();
            }
            #mostramos el nuevo envio
            return response()->json(['envio' => $envio, 'code' => 201]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $usuario, Envio $envio)
    {
        if($usuario->id == $envio->user_id){
            $envio->delete();
            return response()->json(['envio' => $envio]);    
        }
    }
}
