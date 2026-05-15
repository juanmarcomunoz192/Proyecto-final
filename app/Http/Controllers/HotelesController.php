<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;


class HotelesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hoteles = Hotel::all();
        $info = ['status' => 'Ok', 'data' => $hoteles];
        return response()->json($info, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'latitud'=>'required|decimal',
            'longitud'=>'required|decimal'
        ]);
        $hotel = Hotel::create([
            'nombre' => $request->nombre,
            'direccion' => $request->direccion,
            'ciudad' => $request->ciudad,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud
        ]);
        $info = ['status' => 'Ok', 'menssage' => 'Hotel creado con exito.....', 'data' => $hotel];
        return response()->json($info, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $hotel = Hotel::find($id);
        if (!$hotel) {
            $info = ['status' => 'No Ok', 'data' => 'Hotel no encontrado'];
            return response()->json($info, 404);
        } else {
            $info = ['status' => 'Ok', 'data' => $hotel];
            return response()->json($info, 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $hotel = Hotel::find($id);
        if (!$hotel) {
            $info = ['status' => 'No Ok', 'data' => 'Hotel no encontrado para editar'];
            return response()->json($info, 404);
        } else {
            $info = ['status' => 'Ok', 'data' => $hotel];
            return response()->json($info, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $hotel = Hotel::find($id);
        if (!$hotel) {
            $info = ['status' => 'No Ok', 'data' => 'Hotel no encontrado para actualizar'];
            return response()->json($info, 404);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
        ]);
        $hotel->update($request->all());
        $info = ['status' => 'Ok', 'data' => $hotel];
        return response()->json($info, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hotel = Hotel::find($id);
        if (!$hotel) {
            $info = ['status' => 'No Ok', 'data' => 'Hotel no encontrado para eliminar'];
            return response()->json($info, 404);
        } else {
            $hotel->delete();
            $info = ['status' => 'Ok', 'data' => 'Hotel eliminado correctamente'];
            return response()->json($info, 200);
        }
    }
}
