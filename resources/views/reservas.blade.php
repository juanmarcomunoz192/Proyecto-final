@extends('layouts.default')
@section('maincontent')
    {{-- <form action="{{ route('reserva') }}" method="POST" class="p-3"> --}}

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Hotel</th>
                <th scope="col">Habitación</th>
                <th scope="col">Usuario</th>
                <th scope="col">Fecha_Entrada</th>
                <th scope="col">Fecha_Salida</th>
                <th scope="col">Precio_Total</th>
                <th scope="col">Creado</th>
                <th scope="col">Actualizado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservas as $reserva)
                <tr>
                    <th scope="row">{{ $reserva->id }}</th>
                    <td>{{ $reserva->hotel->nombre }}</td>
                    <td>{{ $reserva->habitacion->numero }}</td>
                    <td>{{ $reserva->usuario->name }}</td>
                    <td>{{ $reserva->fecha_entrada }}</td>
                    <td>{{ $reserva->fecha_salida }}</td>
                    <td>{{ $reserva->precio_total . '€' }}</td>



                    <td>{{ $reserva->created_at }}</td>
                    <td>{{ $reserva->updated_at }}</td>

                    <td>
                        <div class="d-flex gap-2">
                            <form action="{{ route('reserva.borrar', $reserva->id) }}" method="POST" class="form-eliminar">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Eliminar
                                </button>
                            </form>
                            <a href="{{ route('factura.descargar', $reserva->id) }}" class="btn btn-warning btn-sm">
                                Descargar PDF
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if (isset($reservas) && $reservas instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <div class="d-flex justify-content-center mt-4">
            {{ $reservas->links() }}
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
            // --- Alerta de ÉXITO al ACTUALIZAR ---
            @if (session('updated'))
                Swal.fire({
                    title: '¡Buen trabajo!',
                    text: "{{ session('updated') }}",
                    icon: 'success',
                    background: '#ffffff',
                    confirmButtonColor: '#0052cc', // El azul de tu botón
                    customClass: {
                        title: 'fw-bold',
                        popup: 'border-radius-15'
                    },
                    showConfirmButton: true,
                    timer: 3000 // Se cierra sola tras 3 segundos si no tocan nada
                });
            @endif
        });
    </script>
@endpush
