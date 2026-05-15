<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura de Reserva #{{ $reserva->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 14px;
        }

        .cabecera {
            width: 100%;
            border-bottom: 2px solid #0052cc;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }

        .titulo-factura {
            color: #0052cc;
            font-size: 28px;
            margin: 0;
        }

        .datos-grid {
            width: 100%;
            margin-bottom: 30px;
        }

        .datos-grid td {
            vertical-align: top;
            width: 50%;
        }

        .caja-datos {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #e9ecef;
        }

        .caja-datos h3 {
            margin-top: 0;
            font-size: 16px;
            color: #495057;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .tabla-detalles {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .tabla-detalles th {
            background-color: #0052cc;
            color: white;
            padding: 10px;
            text-align: left;
        }

        .tabla-detalles td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .totales {
            width: 100%;
            border-collapse: collapse;
        }

        .totales td {
            text-align: right;
            padding: 8px;
        }

        .total-final {
            font-size: 18px;
            font-weight: bold;
            color: #0052cc;
            border-top: 2px solid #0052cc;
        }

        .footer {
            position: fixed;
            bottom: -20px;
            width: 100%;
            text-align: center;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>

<body>

    <table class="cabecera">
        <tr>
            <td>
                <h1 class="titulo-factura">FACTURA DE ESTANCIA</h1>
                <p><strong>Hotel:</strong> {{ $reserva->hotel->nombre }}</p>
            </td>
            <td style="text-align: right;">
                <p>
                    <strong>Nº Reserva:</strong> #{{ $reserva->id }}<br>
                    <strong>Fecha Emisión:</strong> {{ date('d/m/Y') }}
                </p>
            </td>
        </tr>
    </table>

    <table class="datos-grid">
        <tr>
            <td style="padding-right: 10px;">
                <div class="caja-datos">
                    <h3>Datos del Cliente</h3>
                    <p>
                        <strong>Nombre:</strong> {{ $reserva->usuario->name }}<br>
                        <strong>Email:</strong> {{ $reserva->usuario->email ?? 'No registrado' }}
                    </p>
                </div>
            </td>
            <td style="padding-left: 10px;">
                <div class="caja-datos">
                    <h3>Detalles de la Reserva</h3>
                    <p>
                        <strong>Check-in:</strong>
                        {{ \Carbon\Carbon::parse($reserva->fecha_entrada)->format('d/m/Y') }}<br>
                        <strong>Check-out:</strong>
                        {{ \Carbon\Carbon::parse($reserva->fecha_salida)->format('d/m/Y') }}<br>
                        <strong>Habitación:</strong> {{ $reserva->habitacion->numero }}
                    </p>
                </div>
            </td>
        </tr>
    </table>

    <table class="tabla-detalles">
        <thead>
            <tr>
                <th>Descripción del Servicio</th>
                <th style="text-align: center;">Habitación</th>
                <th style="text-align: right;">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Estancia en {{ $reserva->hotel->nombre }} (Desde el
                    {{ \Carbon\Carbon::parse($reserva->fecha_entrada)->format('d/m/Y') }} al
                    {{ \Carbon\Carbon::parse($reserva->fecha_salida)->format('d/m/Y') }})</td>
                <td style="text-align: center;">{{ $reserva->habitacion->numero }}</td>
                <td style="text-align: right;">{{ $reserva->precio_total }} €</td>
            </tr>
        </tbody>
    </table>

    <table class="totales">
        <tr>
            <td style="width: 70%;">Base Imponible:</td>
            <td>{{ number_format($reserva->precio_total / 1.1, 2) }} €</td>
        </tr>
        <tr>
            <td>IVA (10%):</td>
            <td>{{ number_format($reserva->precio_total - $reserva->precio_total / 1.1, 2) }} €</td>
        </tr>
        <tr class="total-final">
            <td>TOTAL A PAGAR:</td>
            <td>{{ $reserva->precio_total }} €</td>
        </tr>
    </table>

    <div class="footer">
        Este documento sirve como comprobante de su reserva en {{ $reserva->hotel->nombre }}.<br>
        Gracias por confiar en nosotros.
    </div>

</body>

</html>
