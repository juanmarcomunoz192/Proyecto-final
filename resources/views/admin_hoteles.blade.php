@extends('layouts.admin_default')
@section('maincontent')
    <!-- <form action="{{ route('hoteles') }}" method="POST" class="p-3">
                                                <div class="row">
                                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                        <label for="id" class="form-label">ID</label>
                                                        <input type="text" class="form-control" id="id" name="id" readonly>
                                                    </div>

                                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                        <label for="hotel_id" class="form-label">ID del Hotel</label>
                                                        <input type="number" class="form-control" id="hotel_id" name="hotel_id" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                        <label for="numero" class="form-label">Número de Habitación</label>
                                                        <input type="text" class="form-control" id="numero" name="numero" required>
                                                    </div>

                                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                        <label for="tipo" class="form-label">Tipo de Habitación</label>
                                                        <input type="text" class="form-control" id="tipo" name="tipo"
                                                            placeholder="Ej: Doble, Sencilla, Suite" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                                        <label for="precio" class="form-label">Precio</label>
                                                        <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                                                    </div>
                                                </div>
                                                <div class="row p-5">
                                                    <button type="submit" class="btn btn-primary m-4">Guardar</button>
                                                </div>
                                            </form>
                                        -->
    <div class="mb-3">

        <a href="{{ route('hoteles.crear') }}" class="btn btn-success">
            + Añadir Hotel
        </a>
    </div>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Dirección</th>
                <th scope="col">Ciudad</th>
                <th scope="col">Latitud</th>
                <th scope="col">Longitud</th>
                <th scope="col">Creado</th>
                <th scope="col">Actualizado</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($hoteles as $hotel)
                <tr>
                    <th scope="row">{{ $hotel->id }}</th>
                    <td>{{ $hotel->nombre }}</td>
                    <td>{{ $hotel->direccion }}</td>
                    <td>{{ $hotel->ciudad }}</td>
                    <td>{{ $hotel->latitud }} </td>
                    <td>{{ $hotel->longitud }} </td>


                    <td>{{ $hotel->created_at }}</td>
                    <td>{{ $hotel->updated_at }}</td>

                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('hoteles.editar', $hotel->id) }}" class="btn btn-warning btn-sm">
                                Editar
                            </a>

                            <form action="{{ route('hoteles.borrar', $hotel->id) }}" method="POST"
                                class="form-eliminar">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if (isset($hoteles) && $hoteles instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-center mt-4">
            {{ $hoteles->links() }}
        </div>
    @endif
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- 1. Alerta de ÉXITO (se dispara al volver del controlador) ---
            @if (session('success'))
                Swal.fire({
                    title: '¡Logrado!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonColor: '#3085d6'
                });
            @endif

            // --- 2. Alerta de ERROR ---
            @if (session('error'))
                Swal.fire({
                    title: 'Error',
                    text: "{{ session('error') }}",
                    icon: 'error'
                });
            @endif

            // --- 3. Confirmación de ELIMINAR ---
            const forms = document.querySelectorAll('.form-eliminar');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "Esta acción no se puede deshacer",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
