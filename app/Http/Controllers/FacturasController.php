<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Reserva;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class FacturasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $facturas = Factura::all();
        $info = ['status' => 'Ok', 'data' => $facturas];
        return response()->json($info, 200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validación de los campos según tu DB
        $request->validate([
            'reserva_id'   => 'required|exists:reserva,id', // Debe existir en la tabla reserva
            'fecha'        => 'required|date',
            'precio_total' => 'required|numeric|min:0',    // Decimal(8,2)
        ]);

        // 2. Creación del registro
        $factura = Factura::create([
            'reserva_id'   => $request->reserva_id,
            'fecha'        => $request->fecha,
            'precio_total' => $request->precio_total,
        ]);

        // 3. Respuesta JSON
        return response()->json([
            'status'  => 'Ok',
            'message' => 'Factura generada con éxito',
            'data'    => $factura
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $factura = Factura::find($id);
        if (!$factura) {
            // 3. Respuesta JSON
            return response()->json([
                'status'  => 'No Ok',
                'message' => 'Factura no encontrada',
                'data'    => $factura
            ], 404);
        } else {
            // 3. Respuesta JSON
            return response()->json([
                'status'  => 'Ok',
                'data'    => $factura
            ], 200);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $factura = Factura::find($id);
        if (!$factura) {
            // 3. Respuesta JSON
            return response()->json([
                'status'  => 'No Ok',
                'message' => 'Factura no encontrada para actualizar',
            ], 404);
        } else {
            $request->validate([
                'reserva_id'   => 'required|exists:reserva,id', // Debe existir en la tabla reserva
                'fecha'        => 'required|date',
                'precio_total' => 'required|numeric|min:0',    // Decimal(8,2)
            ]);
            $factura->update($request->all());
            // 3. Respuesta JSON
            return response()->json([
                'status'  => 'Ok',
                'message' => 'Factura actualizada con éxito',
                'data'    => $factura
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $factura = Factura::find($id);
        if (!$factura) {
            // 3. Respuesta JSON
            return response()->json([
                'status'  => 'No Ok',
                'message' => 'Factura no encontrado para eliminar',
            ], 404);
        } else {

            $factura->delete();
            // 3. Respuesta JSON
            return response()->json([
                'status'  => 'Ok',
                'message' => 'Factura eliminada',
            ], 200);
        }
    }
    public function descargarPdf(string $id)
    {
        // Buscamos la RESERVA (porque es el ID que mandas desde la vista)
        // Usamos 'with' para traer los datos del hotel, habitacion y usuario para que no de error
        $reserva = Reserva::with(['hotel', 'habitacion', 'usuario'])->findOrFail($id);

        // Pasamos la variable $reserva a la vista
        $pdf = FacadePdf::loadView('pdf.factura', compact('reserva'));

        // Generamos y descargamos el PDF
        return $pdf->download('Reserva_' . $reserva->id . '_Hotel.pdf');
    }
}
