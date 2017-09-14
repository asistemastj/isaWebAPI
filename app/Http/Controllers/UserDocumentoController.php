<?php

namespace App\Http\Controllers;

use App\Documento;
use App\User;
use Illuminate\Http\Request;

class UserDocumentoController extends Controller
{
    public function store(Request $request, User $usuario)
    {
        // ['nombre', 'descripcion', 'estado', 'tipo', 'archivo', 'area_id']
        #validación
        $this->validate($request, [
            'nombre' => 'required|max:100',
            'descripcion' => 'required|max:255',
            'tipo' => 'required|string',
            'archivo' => 'required|file'
        ]);
        #si pasavalidacio
        $data = $request->all();
        #el estado default al crear documento
        $data['estado'] = Documento::DOC_DISPONIBLE;
        #guardamos la imagen en nuestra carpeta
        $data['archivo'] = $request->archivo->store('documento');
        #guardamos el area a que pertenece el usuario
        $data['area_id'] = $usuario->area_id;
        #creamos documento
        $documento = Documento::create($data);
        return response()->json(['documento' => $documento, 'code' => 201]);
    }

    public function update(Request $request, User $usuario)
    {
        //
    }

    public function destroy(User $usuario, Documento $documento)
    {
        #tienen que coincidir
        if($usuario->area_id == $documento->area_id){
            $documento->delete();
            return response()->json(['documento' => $documento]);
        }
    }
}
