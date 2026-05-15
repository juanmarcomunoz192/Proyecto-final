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

        @if (isset($habitacion))
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: #003366;">Actualizar Habitación</h2>
                <span class="badge bg-light text-muted">Editando ID: {{ $habitacion->id }}</span>
            </div>

            <form action="{{ route('habitaciones.actualizar', $habitacion->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group-custom">
                    <label class="fw-bold">ID del Hotel</label>
                    <input type="number" name="hotel_id" class="form-control-custom"
                        value="{{ $habitacion->hotel_id }}" required>
                </div>

                <div class="form-group-custom">
                    <label class="fw-bold">Número de Habitación</label>
                    <input type="text" name="numero" class="form-control-custom" value="{{ $habitacion->numero }}"
                        required>
                </div>

                <div class="form-group-custom">
                    <label class="fw-bold">Tipo</label>
                    <input type="text" name="tipo" class="form-control-custom" value="{{ $habitacion->tipo }}"
                        required>
                </div>

                <div class="form-group-custom">
                    <label class="fw-bold">Precio por Noche (€)</label>
                    <input type="number" step="0.01" name="precio" class="form-control-custom"
                        value="{{ $habitacion->precio }}" required>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" class="form-check-input" name="esta_disponible" value="1"
                        {{ $habitacion->esta_disponible ? 'checked' : '' }}>
                    <label class="form-check-label fw-bold" style="text-transform: none; margin-bottom: 0;">¿Está
                        disponible ahora?</label>
                </div>

                <button type="submit" class="btn btn-gradient">Guardar Cambios</button>
            </form>
        @else
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: #003366;">Nueva Habitación</h2>
                <p class="text-muted">Completa los datos del nuevo registro</p>
            </div>

            <form action="{{ route('habitaciones.guardar') }}" method="POST">
                @csrf

                <div class="form-group-custom">
                    <label class="fw-bold">Hotel</label>
                    <select name="hotel_id" class="form-control-custom" required>
                        <option value="">Selecciona un Hotel</option>
                        @foreach ($hoteles_id as $hotel_id)
                            <option value="{{ $hotel_id }}">Hotel ID: {{ $hotel_id }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group-custom">
                    <label class="fw-bold">Número</label>
                    <input type="text" name="numero" class="form-control-custom" placeholder="Ej: Hab-101" required>
                </div>

                <div class="form-group-custom">
                    <label class="fw-bold">Tipo de Habitación</label>
                    <select name="tipo" class="form-control-custom" required>
                        <option value="">Selecciona un tipo</option>
                        @foreach ($tiposHabitaciones as $tipo)
                            <option value="{{ $tipo }}">{{ ucfirst($tipo) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group-custom">
                    <label class="fw-bold">Precio (€)</label>
                    <input type="number" step="0.01" name="precio" class="form-control-custom" placeholder="0.00"
                        required>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" class="form-check-input" name="esta_disponible" value="1" checked>
                    <label class="form-check-label fw-bold" style="text-transform: none; margin-bottom: 0;">Disponible
                        para reserva</label>
                </div>

                <button type="submit" class="btn btn-gradient">+ Crear Habitación</button>
            </form>
        @endif

        <div class="text-center">
            <a href="{{ route('habitaciones') }}" class="link-regresar">
                ← Volver al listado
            </a>
        </div>
    </div>
</div>
