<?php

namespace App\Http\Controllers;

use App\Enums\HabitacionesEstado;
use App\Models\Habitacion;
use Illuminate\Http\Request;

class HabitacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('habitaciones');
    }
    public function obtenerTodasHabitaciones()
    {
        $habitaciones = Habitacion::all();
        $info = ['status' => 'Ok', 'data' => $habitaciones];
        return response()->json($info, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validamos según los tipos de datos de tu phpMyAdmin
        $request->validate([
            'hotel_id'       => 'required|exists:hoteles,id', // Debe existir en la tabla hoteles
            'numero'         => 'required|string|max:255',
            'tipo'           => 'required|string|max:255',   // Ej: Simple, Doble, Suite
            'precio'         => 'required|numeric|min:0',    // Decimal(8,2) en tu DB
            'esta_disponible' => 'boolean',                   // tinyint(1) en tu DB
        ]);

        // 2. Creamos la habitación
        // Usamos el operador ternario para 'esta_disponible' por si el form no lo envía y el "has" devuelve true si el campo existe en la petición y false si no está. 
        $habitacion = Habitacion::create([
            'hotel_id'        => $request->hotel_id,
            'numero'          => $request->numero,
            'tipo'            => $request->tipo,
            'precio'          => $request->precio,
            'esta_disponible' => $request->has('esta_disponible') ? $request->esta_disponible : 1,
        ]);

        // 3. Respuesta JSON para el frontend
        return response()->json([
            'status'  => 'Ok',
            'message' => 'Habitación registrada con éxito',
            'data'    => $habitacion
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $habitacion = Habitacion::find($id);
        if (!$habitacion) {
            $info = ['status' => 'No Ok', 'message' => 'Habitacion no encontrado..'];
            return response()->json($info, 404);
        } else {
            $habitacion->update();
            $info = ['status' => 'Ok', 'data' => $habitacion];
            return response()->json($info, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $habitacion = Habitacion::find($id);
        if (!$habitacion) {
            $info = ['status' => 'No Ok', 'data' => 'Habitación no encontrada para actualizar'];
            return response()->json($info, 404);
        } else {
            $request->validate([
                'hotel_id'       => 'required|exists:hoteles,id', // Debe existir en la tabla hoteles
                'numero'         => 'required|string|max:255',
                'tipo'           => 'required|string|max:255',   // Ej: Simple, Doble, Suite
                'precio'         => 'required|numeric|min:0',    // Decimal(8,2) en tu DB
                'esta_disponible' => 'boolean',                   // tinyint(1) en tu DB
            ]);

            $habitacion->update($request->all());
            $info = ['status' => 'Ok', 'data' => $habitacion];
            return response()->json($info, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $habitacion = Habitacion::find($id);
        if (!$habitacion) {
            $info = ['status' => 'No Ok', 'message' => 'Habitacion no encontrado para eliminar..'];
            return response()->json($info, 404);
        } else {
            $habitacion->delete();
            $info = ['status' => 'Ok', 'message' => 'Habitacion eliminado eliminar..'];
            return response()->json($info, 200);
        }
    }
    public function filtrado(Request $request)
    {
        $query = Habitacion::query();


        $query->when($request->filled('tipo'), function ($q) use ($request) {
            $q->where('tipo', $request->tipo);
        });
        $query->when($request->filled('priceSlider'), function ($q) use ($request) {
            $q->where('precio', '<=', $request->priceSlider);
        });
        $query->where('esta_disponible', HabitacionesEstado::Disponible->value);
        $habitaciones = $query->paginate(12);

        return view('habitaciones', compact('habitaciones'));
    }
}
