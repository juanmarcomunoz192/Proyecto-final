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
        <h2 class="fw-bold text-center mb-5" style="color: #003366;">
            {{ isset($reserva) ? 'Editar Reserva' : 'Nueva Reserva' }}
        </h2>

        <form action="{{ isset($reserva) ? route('reservas.actualizar', $reserva->id) : route('reservas.guardar') }}"
            method="POST">
            @csrf
            @if (isset($reserva))
                @method('PUT')
            @endif

            <!-- Selección de Hotel -->
            <div class="form-group-custom">
                <label class="fw-bold">Hotel</label>
                <select name="hotel_id" class="form-control-custom" required>
                    <option value="">Seleccione Hotel</option>
                    @foreach ($hoteles_id as $id)
                        <option value="{{ $id }}"
                            {{ isset($reserva) && $reserva->hotel_id == $id ? 'selected' : '' }}>
                            Hotel ID: {{ $id }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row">
                <!-- Selección de Habitación -->
                <div class="col-md-6 form-group-custom">
                    <label class="fw-bold">Habitación</label>
                    <select name="habitacion_id" class="form-control-custom" required>
                        @foreach ($habitaciones_id as $id)
                            <option value="{{ $id }}"
                                {{ isset($reserva) && $reserva->habitacion_id == $id ? 'selected' : '' }}>
                                Hab. ID: {{ $id }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Selección de Usuario -->
                <div class="col-md-6 form-group-custom">
                    <label class="fw-bold">Usuario</label>
                    <select name="usuario_id" class="form-control-custom" required>
                        @foreach ($usuarios_id as $id)
                            <option value="{{ $id }}"
                                {{ isset($reserva) && $reserva->usuario_id == $id ? 'selected' : '' }}>
                                User ID: {{ $id }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group-custom">
                    <label class="fw-bold">Fecha Entrada</label>
                    <input type="date" name="fecha_entrada" class="form-control-custom"
                        value="{{ $reserva->fecha_entrada ?? '' }}" required>
                </div>
                <div class="col-md-6 form-group-custom">
                    <label class="fw-bold">Fecha Salida</label>
                    <input type="date" name="fecha_salida" class="form-control-custom"
                        value="{{ $reserva->fecha_salida ?? '' }}" required>
                </div>
            </div>

            <div class="form-group-custom">
                <label class="fw-bold">Precio Total (€)</label>
                <input type="number" step="0.01" name="precio_total" class="form-control-custom"
                    value="{{ $reserva->precio_total ?? '' }}" required>
            </div>

            <button type="submit" class="btn btn-gradient w-100">
                {{ isset($reserva) ? 'Actualizar Reserva' : 'Crear Reserva' }}
            </button>
        </form>
        <div class="text-center">
            <a href="{{ route('admin.reservas') }}" class="link-regresar">← Volver al listado</a>
        </div>
    </div>
</div>
