<?php

namespace App\Http\Controllers;

#trait de jwt-auth
use JWTAuth;
#excepcion jwt-auth
use JWTAuthException;
use Illuminate\Http\Request;
#modelo
use App\User;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return response()->json(['usuarios' => $users]);
    }

    #metodo para registrar
    public function register(Request $request){
    	#validación
        $this->validate($request, [
            'nombre' => 'required|min: 4',
            'username' => 'required',
            'descripcion' => '',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'area_id' => 'required|integer'
        ]);
        #guardamos el request en una variable
        $data = $request->all();
        #guardamos contraseña encriptada
        $data['password'] = bcrypt($request->password);
        $data['estado'] = User::USUARIO_ACTIVO;
        $data['admin'] = User::USUARIO_NO_ADMINISTRADOR;
        if(!$request->avatar){
            $data['avatar'] = null;
        }
        #creamos 1 nuevo usuario
        $user = new User($data);
        #guardamos usuario en db
        $user->save();
        #retornamos JSON
        return response()->json([
        	'status' => 200,
        	'mensaje' => 'Usuario fue creado',
        	'datos' => $user
        ]);
    }

    #metodo para iniciar sesión
    public function login(Request $request){
    	$credenciales = $request->only('username', 'password');
    	$token = null;
    	try{
    		#verifica credenciales y crea token para el usuario
    		if (!$token = JWTAuth::attempt($credenciales)) {
    			return response()->json(['error' => 'credenciales invalidas'], 422);
      	}
    	}catch(JWTAuthException $e){
    		#error al crear token
    		return response()->json(['error' => 'no pudo crearse token'], 500);
    	}
    	#todo bien, retorna el token
    	return response()->json(compact('token'));
    }

    #obtener usuario apartir del token
    public function getAuthUser(Request $request){
    	#obtenemos usuario del token
    	$user = JWTAuth::toUser($request->token);
    	return response()->json(['usuario' => $user]);
    }
}