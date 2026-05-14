<style>
    .wrapper {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        background-color: #f8f9fa;
    }

    .card-custom {
        border: none;
        background-color: #ffffff;
        border-radius: 24px;
        width: 100%;
        max-width: 500px;
        padding: 50px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
    }

    .form-group-custom {
        margin-bottom: 25px;
    }

    /* Estilo general para todos los inputs y selects */
    .form-control-custom {
        border-radius: 12px;
        border: 1.5px solid #e9ecef;
        padding: 14px 18px;
        width: 100%;
        display: block;
        transition: all 0.3s ease;
        background-color: #fff;
    }

    .form-control-custom:focus {
        border-color: #0052cc;
        box-shadow: 0 0 0 4px rgba(0, 82, 204, 0.1);
        outline: none;
    }

    /* Estilo exclusivo para los select (agrega la flecha) */
    select.form-control-custom {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 16px 12px;
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
    }

    label {
        margin-bottom: 10px;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #495057 !important;
    }
</style>

<div class="wrapper">
    <div class="card card-custom">

        {{-- PARTE 1: SI EXISTE $hotel, MOSTRAR EDITAR --}}
        @if (isset($hotel))
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: #003366;">Actualizar Hotel</h2>
                <span class="badge bg-light text-muted">Editando ID: {{ $hotel->id }}</span>
            </div>

            <form action="{{ route('hoteles.actualizar', $hotel->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group-custom">
                    <label class="fw-bold">Nombre del Hotel</label>
                    <input type="text" name="nombre" class="form-control-custom" value="{{ $hotel->nombre }}" required>
                </div>

                <div class="form-group-custom">
                    <label class="fw-bold">Dirección</label>
                    <input type="text" name="direccion" class="form-control-custom" value="{{ $hotel->direccion }}" required>
                </div>

                <div class="form-group-custom">
                    <label class="fw-bold">Ciudad</label>
                    <input type="text" name="ciudad" class="form-control-custom" value="{{ $hotel->ciudad }}" required>
                </div>

                <div class="form-group-custom">
                    <label class="fw-bold">Latitud</label>
                    <input type="number" step="any" name="latitud" class="form-control-custom" value="{{ $hotel->latitud }}">
                </div>

                <div class="form-group-custom">
                    <label class="fw-bold">Longitud</label>
                    <input type="number" step="any" name="longitud" class="form-control-custom" value="{{ $hotel->longitud }}">
                </div>

                <button type="submit" class="btn btn-gradient">Guardar Cambios</button>
            </form>

        {{-- PARTE 2: SI NO EXISTE $hotel, MOSTRAR CREAR --}}
        @else
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: #003366;">Nuevo Hotel</h2>
                <p class="text-muted">Completa los datos del nuevo establecimiento</p>
            </div>

            <form action="{{ route('hoteles.guardar') }}" method="POST">
                @csrf

                <div class="form-group-custom">
                    <label class="fw-bold">Nombre del Hotel</label>
                    <input type="text" name="nombre" class="form-control-custom" placeholder="Ej: Hotel Aurora Centro" required>
                </div>

                <div class="form-group-custom">
                    <label class="fw-bold">Dirección</label>
                    <input type="text" name="direccion" class="form-control-custom" placeholder="Ej: Calle Principal 123" required>
                </div>

                <div class="form-group-custom">
                    <label class="fw-bold">Ciudad</label>
                    <input type="text" name="ciudad" class="form-control-custom" placeholder="Ej: Madrid" required>
                </div>

                <div class="form-group-custom">
                    <label class="fw-bold">Latitud (Opcional)</label>
                    <input type="number" step="any" name="latitud" class="form-control-custom" placeholder="Ej: 40.416775">
                </div>

                <div class="form-group-custom">
                    <label class="fw-bold">Longitud (Opcional)</label>
                    <input type="number" step="any" name="longitud" class="form-control-custom" placeholder="Ej: -3.703790">
                </div>

                <button type="submit" class="btn btn-gradient">+ Crear Hotel</button>
            </form>
        @endif

        <div class="text-center">
            <a href="{{ route('hoteles') }}" class="link-regresar">
                ← Volver al listado
            </a>
        </div>
    </div>
</div>