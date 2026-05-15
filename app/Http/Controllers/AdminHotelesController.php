<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Hotel;
use App\Models\Reserva;
use Illuminate\Http\Request;

class AdminHotelesController extends Controller
{
    public function index()
    {
        $hoteles = Hotel::paginate(10);
        return view("admin_hoteles", ['hoteles' => $hoteles]);
    }
    public function borrar(string $id)
    {
        $hoteles = Hotel::find($id);

        if (!$hoteles) {
            return redirect('admin/hoteles')->with('error', 'Hotel no encontrada');
        }

        $hoteles->delete();

        // 'success' es la llave que buscaremos luego en la vista
        return redirect('admin/hoteles')->with('success', 'La hotel  ha sido eliminada correctamente.');
    }
    public function actualizar(Request $request, string $id)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return redirect('admin/hoteles')->with('error', 'Hotel no encontrada');
        }

        // 1. Validamos los campos REALES de la habitación
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'direccion' => 'required|string|max:255', // Quitamos el unique hacia habitaciones
            'ciudad'    => 'required|string|max:255',
            // Latitud y longitud permiten números y nulos (según tu DB que dice "Sí" en Nulo)
            'latitud'   => 'nullable|numeric',
            'longitud'  => 'nullable|numeric',
        ]);

        // 2. Manejo del checkbox (si no se marca, no llega en el request)
        $datos = $request->all();
        // 3. Actualizamos
        $hotel->update($datos);

        // 4. Redirigimos (Usamos 'updated' para que coincida con el JS que hicimos)
        return redirect('admin/hoteles')->with('updated', 'El hotel ha sido actualizado correctamente.');
    }
    public function editar($id)
    {
        // 1. Buscamos la habitación en la base de datos usando el ID
        $hotel = Hotel::findOrFail($id);

        // 2. Retornamos la vista (el archivo donde está tu formulario)
        // Nota: Si tu archivo está en 'resources/views/admin/habitaciones_edit.blade.php'
        // debes poner 'admin.habitaciones_edit'
        return view('admin_hoteles_create', compact('hotel'));
    }
    // 1. Mostrar la vista
    public function crear()
    {
        return view('admin_hoteles_create'); // Asegúrate de que el nombre coincida con tu archivo
    }

    public function guardar(Request $request)
    {
        // 1. Validación basada en la estructura de tu tabla 'hoteles'
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'direccion' => 'required|string|max:255', // Quitamos el unique hacia habitaciones
            'ciudad'    => 'required|string|max:255',
            // Latitud y longitud permiten números y nulos (según tu DB que dice "Sí" en Nulo)
            'latitud'   => 'nullable|numeric',
            'longitud'  => 'nullable|numeric',
        ]);

        // 2. Crear la instancia del Hotel y asignar los campos correctos
        $hotel = new Hotel();
        $hotel->nombre    = $request->nombre;
        $hotel->direccion = $request->direccion;
        $hotel->ciudad    = $request->ciudad;

        // Si envían latitud o longitud, se guardan; si no, se quedan en null
        $hotel->latitud   = $request->latitud;
        $hotel->longitud  = $request->longitud;

        // 3. Guardar en la base de datos
        $hotel->save();

        // 4. Redirección con mensaje de éxito
        return redirect()->route('hoteles')->with('success', "El nuevo hotel '{$hotel->nombre}' se ha creado correctamente.");
    }
}
