<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Administracion\Persona;
use App\Models\Administracion\PersonaDni;
use App\Models\Administracion\Cliente;
class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        Log::info($request);
        DB::beginTransaction();
        try{
            $rules=[
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required',
                    'dni'=> ['required','unique:persona_dni,dni']
            ];
            $message=[
                'name.required'=>"El nombre es requerido",
                'email.required'=>"El email es requerido",
                'email.email'=>"El email no cumple con el formato",
                'email.unique'=>"El email ya esta en uso",
                'password.required'=>"El password es requerido",
                'dni.required'=>"El dni es requerido",
                'dni.unique'=>"El dni debe ser unico"
            ];
            $validator = Validator::make($request->all(), $rules,$message);
            if ($validator->fails()) {
                return response()->json([
                    'success'=>false,
                    "message"=>$validator->errors()->first()
                ]);
            }
            $user=User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $persona=Persona::create([
                'tipo_documento'=>"DNI",
                'distrito_id'=>1
            ]);
            $personaDni=PersonaDni::create([
                'nombres'=>$request->name,
                'apellidos'=>$request->apellidos,
                'dni'=>$request->dni,
                'persona_id'=>$persona->id
            ]);
            $cliente=Cliente::create([
                'user_id'=>$user->id,
                'persona_id'=>$persona->id,
                'tipo'=>'app'
            ]);
            DB::commit();
            return response()->json([
                'success'=>true,
                'message' => 'Usuario creado con Exito',
            ]);
        }
        catch(\Exception $e)
        {
            Log::info($e);
            DB::rollback();
            return response()->json([
                'success'=>false,
                'message' => 'Ocurrio un Error',
            ]);
        }
    }

    /**
     * Inicio de sesión y creación de token
     */
    public function login(Request $request)
    {
        Log::info($request);
        try{

            $rules=[
                'email' => 'required',
                'password' => 'required',
            ];
            $message=[
                'email.required'=>"El email es requerido",
                'password.required'=>"El password es requerido"
            ];

            $validator = Validator::make($request->all(), $rules,$message);
            if($validator->fails())
            {
                return response()->json([
                    'success'=>true,
                    "message"=>$validator->errors()->first()
                ]);
            }
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials))
                return response()->json([
                    'success' => false,
                    'message' => 'Logueo incorrecto'
                ]);
            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->save();
            return response()->json([
                'success' => true,
                "message"=>$user,
                'token' => $tokenResult->accessToken,
                'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
            ]);
        }
        catch(\Exception $e)
        {
            Log::info($e);
            return response()->json([
                'success' =>false,
                "message"=>"Ocurrio un Error",
            ]);
        }
    }
    /**
     * Cierre de sesión (anular el token)
     */
    public function logout(Request $request)
    {
        try
        {
            $request->user()->token()->revoke();
            return response()->json([
                'success' => true,
                'message' => 'Cierre de Session correctamente'
            ]);
        }
        catch(Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Obtener el objeto User como json
     */
    public function user(Request $request)
    {

        try{
            $user=User::findOrFail($request->user_id);
            $cliente=$user->cliente;
            $datos=array(
                "nombres"=>$cliente->persona->personaDni? $cliente->persona->personaDni->nombres:$cliente->persona->personaRuc->nombre_comercial,
                "correo"=>$user->email,
                "telefono"=>$cliente->persona->telefono,
                "direccion"=>$cliente->persona->direccion
            );
            return response()->json([
                "success"=>true,
                "message"=>$datos
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                "success"=>false,
                "message"=>"Ocurrio un Error"
            ]);
        }
    }
    public function updateUser(Request $request)
    {

        try{
            $user=User::findOrFail($request->user_id);
            $cliente=$user->cliente;
            $persona=$cliente->persona;
            $persona->direccion=$request->direccion;
            $persona->telefono=$request->telefono;
            $persona->save();
            $personaDni=$persona->personaDni;
            $personaDni->nombres=$request->nombres;
            $personaDni->save();
            return response()->json([
                "success"=>true,
                "message"=>"Registro con Exito"
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                "success"=>false,
                "message"=>"Ocurrio un Error"
            ]);
        }
    }
}
