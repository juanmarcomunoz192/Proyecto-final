<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Cargamos la reserva con su habitación, el hotel de esa habitación y el usuario
        $reservas = Reserva::where('usuario_id', auth()->id())
            ->with(['habitacion', 'hotel', 'usuario'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reservas', compact('reservas'));
    }

    public function confirmar()
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->back()->with('error', 'El carrito está vacío');
        }

        try {
            // Usamos una transacción para que, si falla una reserva, no se guarde ninguna
            DB::transaction(function () use ($carrito) {
                foreach ($carrito as $item) {
                    // Buscamos la habitación para obtener el hotel_id si no está en el carrito
                    $habitacion = Habitacion::find($item['id']);

                    Reserva::create([
                        'hotel_id'      => $habitacion->hotel_id, // Columna Hotel_ID
                        'habitacion_id' => $item['id'],            // Columna Habitacion_ID
                        'usuario_id'    => auth()->id(),           // Columna Usuario_ID
                        'fecha_entrada' => $item['entrada'],       // Columna Fecha_Entrada
                        'fecha_salida'  => $item['salida'],        // Columna Fecha_Salida
                        'precio_total'  => $item['precio'],        // Columna Precio_Total
                        'estado'        => 'Confirmada',           // Estado por defecto
                    ]);
                    $habitacion->update([
                        'esta_disponible' => 0
                    ]);
                }
            });

            // 1. Limpiar la sesión de PHP
            session()->forget('carrito');

            // 2. Redirigir a "Mis Reservas" con éxito
            return response()->json([
                'status' => 'Ok',
                'message' => '¡Reserva realizada con éxito!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Hubo un problema: ' . $e->getMessage()
            ], 500);
        }
    }
    public function borrar(string $id)
    {
        // Buscamos la reserva
        $reserva = Reserva::find($id);

        if (!$reserva) {
            return redirect()->route('reserva')->with('error', 'Reserva no encontrada.');
        }

        // SEGURIDAD CRÍTICA: 
        // Forzamos a que ambos sean enteros para que la comparación sea exacta
        if (intval($reserva->usuario_id) !== intval(auth()->id())) {
            return redirect()->route('reserva')->with('error', 'No tienes permiso: Esta reserva no te pertenece.');
        }

        // Si pasa el filtro anterior, borramos
        $reserva->delete();
        $habitacion = Habitacion::find($reserva->habitacion_id);
        $habitacion->update([
            'esta_disponible' => 1
        ]);
        return redirect()->route('reserva')->with('success', 'Tu reserva ha sido cancelada correctamente.');
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
    public function agregar(Request $request)
    {
        // 1. Validar que recibimos un ID válido
        $request->validate([
            'habitacion_id' => 'required|exists:habitaciones,id'
        ]);

        // 2. Obtener los datos de la habitación
        $habitacion = Habitacion::findOrFail($request->habitacion_id);

        // 3. Obtener el carrito actual de la sesión o inicializarlo si está vacío
        $carrito = session()->get('carrito', []);

        // 4. Estructurar el item (puedes añadir fechas si las tienes)
        $item = [
            "id" => $habitacion->id,
            "numero" => $habitacion->numero,
            "precio" => $habitacion->precio,
            "tipo" => $habitacion->tipo,
            "cantidad" => 1
        ];

        // 5. Añadir al carrito (usamos el ID como clave para no duplicar la misma habitación)
        $carrito[$habitacion->id] = $item;

        // 6. Guardar en la sesión y volver con un mensaje de éxito
        session()->put('carrito', $carrito);


        return view('/carrito');
    }
}
