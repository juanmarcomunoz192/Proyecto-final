<style>
    .wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        /* Más padding superior e inferior */
        background-color: #f8f9fa;
    }

    .card-custom {
        border: none;
        background-color: #ffffff;
        border-radius: 24px;
        /* Un poco más redondeado */
        width: 100%;
        max-width: 500px;
        padding: 50px;
        /* Más espacio interno */
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
    }

    /* ESPACIADO: Cambiamos mb-3 por un margen mayor */
    .form-group-custom {
        margin-bottom: 25px;
        /* Espacio generoso entre campos */
    }

    .form-control-custom {
        border-radius: 12px;
        border: 1.5px solid #e9ecef;
        /* Borde más sutil */
        padding: 14px 18px;
        width: 100%;
        display: block;
        transition: all 0.3s ease;
        background-color: #fff;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
    }

    .form-control-custom:focus {
        border-color: #0052cc;
        box-shadow: 0 0 0 4px rgba(0, 82, 204, 0.1);
        outline: none;
    }

    .btn-gradient {
        background: linear-gradient(to right, #002e5d 0%, #0052cc 100%);
        border-radius: 12px;
        font-weight: 600;
        padding: 16px;
        width: 100%;
        color: white;
        border: none;
        margin-top: 10px;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 46, 93, 0.2);
    }

    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 46, 93, 0.3);
        opacity: 0.95;
    }

    /* MEJORA DEL REGRESAR */
    .link-regresar {
        display: inline-flex;
        align-items: center;
        color: #adb5bd;
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-top: 25px;
    }

    .link-regresar:hover {
        color: #002e5d;
    }

    .link-regresar i {
        margin-right: 8px;
        /* Espacio para un icono si lo usas */
    }

    label {
        margin-bottom: 10px;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        /* Etiquetas más profesionales */
        color: #495057 !important;
    }
</style>
<div class="wrapper">
    <div class="card card-custom">
        @if (isset($factura))
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: #003366;">Actualizar Factura</h2>
                <span class="badge bg-light text-muted">ID Factura: {{ $factura->id }}</span>
            </div>
            <form action="{{ route('facturas.actualizar', $factura->id) }}" method="POST">
                @csrf @method('PUT')
            @else
                <div class="text-center mb-5">
                    <h2 class="fw-bold" style="color: #003366;">Nueva Factura</h2>
                    <p class="text-muted">Asignar facturación a una reserva existente</p>
                </div>
                <form action="{{ route('facturas.guardar') }}" method="POST">
                    @csrf
        @endif

        <!-- Selector de Reserva -->
        <div class="form-group-custom">
            <label class="fw-bold">ID de Reserva</label>
            <select name="reserva_id" class="form-control-custom" required>
                <option value="">Selecciona una Reserva</option>
                @foreach ($reserva_ids as $id)
                    <option value="{{ $id }}"
                        {{ isset($factura) && $factura->reserva_id == $id ? 'selected' : '' }}>
                        Reserva #{{ $id }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Campo Fecha -->
        <div class="form-group-custom">
            <label class="fw-bold">Fecha de Emisión</label>
            <input type="date" name="fecha" class="form-control-custom"
                value="{{ $factura->fecha ?? date('Y-m-d') }}" required>
        </div>

        <!-- Precio Total -->
        <div class="form-group-custom">
            <label class="fw-bold">Precio Total (€)</label>
            <input type="number" step="0.01" name="precio_total" class="form-control-custom" placeholder="0.00"
                value="{{ $factura->precio_total ?? '' }}" required>
        </div>

        <button type="submit" class="btn btn-gradient">
            {{ isset($factura) ? 'Actualizar Factura' : '+ Generar Factura' }}
        </button>
        </form>

        <div class="text-center">
            <a href="{{ route('facturas') }}" class="link-regresar">← Volver al listado</a>
        </div>
    </div>
</div>
