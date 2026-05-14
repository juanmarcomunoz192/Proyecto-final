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

    .form-control-custom {
        border-radius: 12px;
        border: 1.5px solid #e9ecef;
        padding: 14px 18px;
        width: 100%;
        display: block;
        transition: all 0.3s ease;
    }

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
        cursor: pointer;
    }

    .link-regresar {
        display: inline-flex;
        align-items: center;
        color: #adb5bd;
        text-decoration: none;
        margin-top: 25px;
    }

    label {
        margin-bottom: 10px;
        font-size: 0.9rem;
        text-transform: uppercase;
        color: #495057 !important;
    }
</style>

<div class="wrapper">
    <div class="card card-custom">
        @if (isset($usuario))
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: #003366;">Editar Usuario</h2>
                <span class="badge bg-light text-muted">ID: {{ $usuario->id }}</span>
            </div>
            <form action="{{ route('users.actualizar', $usuario->id) }}" method="POST">
                @csrf @method('PUT')
            @else
                <div class="text-center mb-5">
                    <h2 class="fw-bold" style="color: #003366;">Nuevo Usuario</h2>
                    <p class="text-muted">Crea un nuevo acceso al sistema</p>
                </div>
                <form action="{{ route('users.guardar') }}" method="POST">
                    @csrf
        @endif

        <div class="form-group-custom">
            <label class="fw-bold">Nombre Completo</label>
            <input type="text" name="name" class="form-control-custom" value="{{ $usuario->name ?? '' }}"
                required>
        </div>

        <div class="form-group-custom">
            <label class="fw-bold">Correo Electrónico</label>
            <input type="email" name="email" class="form-control-custom" value="{{ $usuario->email ?? '' }}"
                required>
        </div>

        <div class="form-group-custom">
            <label class="fw-bold">Rol de Usuario</label>
            <select name="role" class="form-control-custom" required>
                <option value="">Selecciona un rol</option>
                @foreach ($roles as $role)
                    <option value="{{ $role }}"
                        {{ isset($usuario) && $usuario->role == $role ? 'selected' : '' }}>
                        {{ ucfirst($role) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group-custom">
            <label class="fw-bold">Contraseña</label>
            <input type="password" name="password" class="form-control-custom"
                placeholder="{{ isset($usuario) ? 'Dejar en blanco para no cambiar' : 'Mínimo 8 caracteres' }}"
                {{ isset($usuario) ? '' : 'required' }}>
        </div>

        <button type="submit" class="btn btn-gradient">
            {{ isset($usuario) ? 'Actualizar Usuario' : 'Crear Usuario' }}
        </button>
        </form>

        <div class="text-center">
            <a href="{{ route('users') }}" class="link-regresar">← Volver al listado</a>
        </div>
    </div>
</div>
