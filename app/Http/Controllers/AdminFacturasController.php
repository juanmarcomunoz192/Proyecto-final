<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;

class AdminFacturasController extends Controller
{
    public function index()
    {
        $facturas = Factura::paginate(10);
        return view("admin_facturas", ['facturas' => $facturas]);
    }
    public function borrar(string $id)
    {
        $facturas = Factura::find($id);

        if (!$facturas) {
            return redirect('admin/facturas')->with('error', 'Factura no encontrada');
        }

        $facturas->delete();

        // 'success' es la llave que buscaremos luego en la vista
        return redirect('admin/facturas')->with('success', 'La factura  ha sido eliminada correctamente.');
    }
    public function crear()
    {
        // Necesitamos las reservas para el desplegable del formulario

        return view('admin_facturas_create');
    }

    public function guardar(Request $request)
    {
        // 1. Validación basada en tu tabla factura (reserva_id, fecha, precio_total)
        $request->validate([
            'reserva_id'   => 'required|exists:reserva,id',
            'fecha'        => 'required|date',
            'precio_total' => 'required|numeric|min:0',
        ]);

        // 2. Crear instancia
        $factura = new Factura();
        $factura->reserva_id   = $request->reserva_id;
        $factura->fecha        = $request->fecha;
        $factura->precio_total = $request->precio_total;

        $factura->save();

        return redirect()->route('facturas')->with('success', 'La factura se ha generado correctamente.');
    }

    public function editar(string $id)
    {
        $factura = Factura::findOrFail($id);
        return view('admin_facturas_create', compact('factura'));
    }

    public function actualizar(Request $request, string $id)
    {
        $factura = Factura::findOrFail($id);

        $request->validate([
            'reserva_id'   => 'required|exists:reserva,id',
            'fecha'        => 'required|date',
            'precio_total' => 'required|numeric|min:0',
        ]);

        $factura->update($request->all());

        return redirect()->route('facturas')->with('updated', 'Factura actualizada correctamente.');
    }
}
