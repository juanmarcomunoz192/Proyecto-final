<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Hotel;
use App\Models\Reserva;
use Illuminate\Http\Request;

class AdminHabitacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $habitaciones = Habitacion::with('Hotel')->paginate(10);

        return view("admin_habitaciones", ['habitaciones' => $habitaciones]);
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
    public function borrar(string $id)
    {
        $habitacion = Habitacion::find($id);

        if (!$habitacion) {
            return redirect('admin/habitaciones')->with('error', 'Reserva no encontrada');
        }

        $habitacion->delete();

        // 'success' es la llave que buscaremos luego en la vista
        return redirect('admin/habitaciones')->with('success', 'La habitación  ha sido eliminada correctamente.');
    }
    public function actualizar(Request $request, string $id)
    {
        $habitacion = Habitacion::find($id);

        if (!$habitacion) {
            return redirect('admin/habitaciones')->with('error', 'Habitación no encontrada');
        }

        // 1. Validamos los campos REALES de la habitación
        $request->validate([
            'hotel_id' => 'required|integer',
            'numero'   => 'required|string|max:10',
            'tipo'     => 'required|string',
            'precio'   => 'required|numeric|min:0',
        ]);

        // 2. Manejo del checkbox (si no se marca, no llega en el request)
        $datos = $request->all();
        $datos['esta_disponible'] = $request->has('esta_disponible') ? 1 : 0;

        // 3. Actualizamos
        $habitacion->update($datos);

        // 4. Redirigimos (Usamos 'updated' para que coincida con el JS que hicimos)
        return redirect('admin/habitaciones')->with('updated', 'La habitación ha sido actualizada correctamente.');
    }
    public function editar($id)
    {
        // 1. Buscamos la habitación en la base de datos usando el ID
        $habitacion = Habitacion::findOrFail($id);

        // 2. Retornamos la vista (el archivo donde está tu formulario)
        // Nota: Si tu archivo está en 'resources/views/admin/habitaciones_edit.blade.php'
        // debes poner 'admin.habitaciones_edit'
        return view('admin_habitaciones_create', compact('habitacion'));
    }
    // 1. Mostrar la vista
    public function crear()
    {
        return view('admin_habitaciones_create'); // Asegúrate de que el nombre coincida con tu archivo
    }

    // 2. Guardar en la base de datos
    public function guardar(Request $request)
    {
        // Validación
        $request->validate([
            'hotel_id'      => 'required|integer',
            'numero'        => 'required|string|max:10|unique:habitaciones,numero',
            'tipo'          => 'required|string',
            'precio'        => 'required|numeric|min:0',
        ]);

        // Crear la instancia
        $habitacion = new Habitacion();
        $habitacion->hotel_id = $request->hotel_id;
        $habitacion->numero   = $request->numero;
        $habitacion->tipo     = $request->tipo;
        $habitacion->precio   = $request->precio;
        $habitacion->esta_disponible = $request->has('esta_disponible') ? 1 : 0;

        $habitacion->save();
        return redirect()->route('habitaciones')->with('success', 'La nueva habitación se ha creado correctamente.');
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
