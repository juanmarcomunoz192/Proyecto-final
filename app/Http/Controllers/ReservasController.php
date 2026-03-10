<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservas = Reserva::all();
        $info = ['status' => 'Ok', 'data' => $reservas];
        return response()->json($info, 200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación estricta de IDs y Fechas
        $request->validate([
            'hotel_id'      => 'required|exists:hoteles,id',
            'habitacion_id' => 'required|exists:habitaciones,id',
            'usuario_id'    => 'required|exists:usuario,id', // Se refiere a tu tabla 'usuario'
            'fecha_entrada' => 'required|date|after_or_equal:today',
            'fecha_salida'  => 'required|date|after:fecha_entrada',
            'precio_total'  => 'required|numeric|min:0',
        ]);

        // 2. Crear la reserva
        $reserva = Reserva::create([
            'hotel_id'      => $request->hotel_id,
            'habitacion_id' => $request->habitacion_id,
            'usuario_id'    => $request->usuario_id,
            'fecha_entrada' => $request->fecha_entrada,
            'fecha_salida'  => $request->fecha_salida,
            'precio_total'  => $request->precio_total,
        ]);

        // 3. Respuesta
        return response()->json([
            'status'  => 'Ok',
            'message' => 'Reserva creada con éxito',
            'data'    => $reserva
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reserva = Reserva::find($id);
        if (!$reserva) {
            $info = ['status' => 'No Ok', 'message' => 'Reserva no encontrada.....'];
            return response()->json($info, 404);
        } else {
            $info = ['status' => 'Ok', 'data' => $reserva];
            return response()->json($info, 200);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $reserva = Reserva::find($id);
        if (!$reserva) {
            $info = ['status' => 'No Ok', 'message' => 'Reserva no encontrada.....'];
            return response()->json($info, 404);
        } else {
            $request->validate([
                'hotel_id'      => 'required|exists:hoteles,id',
                'habitacion_id' => 'required|exists:habitaciones,id',
                'usuario_id'    => 'required|exists:usuario,id', // Se refiere a tu tabla 'usuario'
                'fecha_entrada' => 'required|date|after_or_equal:today',
                'fecha_salida'  => 'required|date|after:fecha_entrada',
                'precio_total'  => 'required|numeric|min:0',
            ]);
            $reserva->update($request->all());
            $info = ['status' => 'Ok', 'message' => 'Reserva eliminada.....'];
            return response()->json($info, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reserva = Reserva::find($id);
        if (!$reserva) {
            $info = ['status' => 'No Ok', 'message' => 'Reserva no encontrada.....'];
            return response()->json($info, 404);
        } else {
            $reserva->delete();
            $info = ['status' => 'Ok', 'message' => 'Reserva eliminada.....'];
            return response()->json($info, 200);
        }
    }
}
