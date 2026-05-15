<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;

class AdminReservasController extends Controller
{
    public function index()
    {
        $reservas = Reserva::paginate(10);
        return view("admin_reservas", ['reservas' => $reservas]);
    }
    public function borrar(string $id)
    {
        $reservas = Reserva::find($id);

        if (!$reservas) {
            return redirect('admin/reservas')->with('error', 'Reserva no encontrada');
        }

        $reservas->delete();

        // 'success' es la llave que buscaremos luego en la vista
        return redirect('admin/reservas')->with('success', 'La reserva  ha sido eliminada correctamente.');
    }
    public function crear()
    {
        return view('admin_reservas_create');
    }

    public function guardar(Request $request)
    {
        // 1. Validación estricta con las llaves ajenas (FK)
        $request->validate([
            'hotel_id'      => 'required|exists:hoteles,id',
            'habitacion_id' => 'required|exists:habitaciones,id',
            'usuario_id'   => 'required|exists:users,id',
            'fecha_entrada' => 'required|date|after_or_equal:today',
            'fecha_salida'  => 'required|date|after:fecha_entrada',
            'precio_total'  => 'required|numeric|min:0',
        ]);

        // 2. Guardado
        $reserva = new Reserva();
        $reserva->hotel_id      = $request->hotel_id;
        $reserva->habitacion_id = $request->habitacion_id;
        $reserva->usuario_id    = $request->usuario_id;
        $reserva->fecha_entrada = $request->fecha_entrada;
        $reserva->fecha_salida  = $request->fecha_salida;
        $reserva->precio_total  = $request->precio_total;
        $reserva->save();

        return redirect()->route('admin.reservas')->with('success', 'Reserva creada con éxito.');
    }

    public function editar(string $id)
    {
        $reserva = Reserva::findOrFail($id);
        return view('admin_reservas_create', compact('reserva'));
    }

    public function actualizar(Request $request, string $id)
    {
        $reserva = Reserva::findOrFail($id);
        
        $request->validate([
            'hotel_id'      => 'required|exists:hoteles,id',
            'habitacion_id' => 'required|exists:habitaciones,id',
            'usuario_id'    => 'required|exists:users,id',
            'fecha_entrada' => 'required|date',
            'fecha_salida'  => 'required|date|after:fecha_entrada',
            'precio_total'  => 'required|numeric|min:0',
        ]);

        $reserva->update($request->all());

        return redirect()->route('admin.reservas')->with('updated', 'La reserva ha sido modificada.');
    }
}
