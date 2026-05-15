<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Usuario::all();
        $info = ['status' => 'Ok', 'data' => $usuarios];
        return response()->json($info, 200);
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $usuario = $request->validate([
            'nombre'    => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:usuario,email',
            'password'  => 'required|string|min:8',
            'rol'       => 'required|string|max:255',
            'dni'       => 'required|string|max:255|unique:usuario,dni',
            'direccion' => 'required|string|max:255',
        ]);

        $usuario = Usuario::create([
            'nombre'    => $request->nombre,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'rol'       => $request->rol,
            'dni'       => $request->dni,
            'direccion' => $request->direccion,
        ]);

        return response()->json([
            'status' => 'Ok',
            'message' => 'Usuario creado con éxito',
            'data' => $usuario
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json([
                'status' => 'No Ok',
                'message' => 'Usuario  no encontrado',
                'data' => $usuario
            ], 404);
        } else {
            return response()->json([
                'status' => 'Ok',
                'message' => 'Usuario encontrado con éxito',
                'data' => $usuario
            ], 200);
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) {
            return response()->json([
                'status' => 'No Ok',
                'message' => 'Usuario  no encontrado',
                'data' => $usuario
            ], 404);
        } else {
            $request->validate([
                'nombre'    => 'required|string|max:255',
                'email'     => 'required|string|email|max:255|unique:usuario,email',
                'password'  => 'required|string|min:8',
                'rol'       => 'required|string|max:255',
                'dni'       => 'required|string|max:255|unique:usuario,dni',
                'direccion' => 'required|string|max:255',
            ]);
            $usuario->update($request->all());
            $info = ['status' => 'Ok', 'data' => $usuario];
            return response()->json($info, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = Usuario::find($id);
        if (!$usuario) { 
            $info = ['status' => 'No Ok', 'data' => 'Usuario no encontrado para eliminar'];
            return response()->json($info, 404);
        } else {
            $usuario->delete();
            $info = ['status' => 'Ok', 'data' => 'Usuario eliminado correctamente'];
            return response()->json($info, 200);
        }
    }
}
