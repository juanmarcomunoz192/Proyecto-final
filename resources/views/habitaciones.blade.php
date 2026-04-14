@extends('layouts.default')
@section('maincontent')
    <div id="toast-container" aria-live="polite"></div>

    <section class="hero">
        <div class="inner">
            <div>
                <h1>Nuestras Habitaciones</h1>
                <p>12 espacios diseñados para tu descanso y confort, con estilo moderno y servicios premium.</p>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="rooms-section-wrapper">
            <!-- SIDEBAR DE FILTROS (estilo Trivago) -->
            <aside class="filters-sidebar">

                <div class="filters-header">
                    <h3>Filtros</h3>

                </div>

                <form action="/habitacion" method="post">
                    @csrf

                    <!-- Tipo de habitación -->
                    <div class="filter-group">
                        <label for="tipo">Tipo de habitación</label>
                        <select id="tipo" name="tipo">
                            <option value="">Todos los tipos</option>

                            @foreach ($tiposHabitaciones as $tipo)
                                <option value="{{ $tipo }}" {{ request('tipo') == $tipo ? 'selected' : '' }}>
                                    {{ ucfirst($tipo) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Rango de precio con slider -->
                    <div class="filter-group">
                        <label>Rango de precio</label>
                        <div class="price-range-display">
                            <span id="minPriceDisplay">0€</span> - <span id="maxPriceDisplay">10000€</span>
                        </div>
                        <input id="priceSlider" name="priceSlider" type="range" min="0" max="10000"
                            value="200">

                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <button onclick="limpiarFiltros()" title="Limpiar todos los filtros"
                                class="  btn btn-sm btn-primary cart-button cart-pill">
                                <i class="fa-solid fa-filter-circle-xmark pe-1"></i>Reseteo
                            </button>
                        </div>
                        <div class="col-12 col-md-6">
                            <button type="submit" class="btn btn-sm btn-primary cart-button cart-pill text-center">
                                <i class="fa-solid fa-filter pe-1"></i> Filtar
                            </button>
                        </div>
                    </div>
                </form>
            </aside>

            <!-- CONTENEDOR PRINCIPAL DE HABITACIONES -->
            <section class="rooms-main-container">

                <!-- Grilla de habitaciones -->
                <div class="row">
                    @forelse ($habitaciones ?? [] as $habitacion)
                        <div class="col-md-4 mb-4">
                            <div class="card" style="width: 100%;">

                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title"> {{ $habitacion->numero }}</h5>
                                        <span class="badge bg-info text-dark">{{ ucfirst($habitacion->tipo) }}</span>
                                    </div>
                                    <p class="card-text">
                                        Disfruta de nuestra estancia de tipo <strong>{{ $habitacion->tipo }}</strong>.
                                        Actualmente se encuentra
                                    </p>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h4 me-3">{{ number_format($habitacion->precio, 2) }}€</span>

                                        <a href="/carrito" class="mb-4 btn btn-sm btn-primary cart-button cart-pill"
                                            id="reserva">
                                            <i class="fa-solid fa-calendar-check"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="results-info">
                                <span id="resultCount">No se encontraron habitaciones que coincidan con tus filtros.</span>
                            </div>

                        </div>
                    @endforelse
                    @if (isset($habitaciones) && $habitaciones instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="d-flex justify-content-center mt-4">
                            {{ $habitaciones->appends(['tipo' => request('tipo'), 'priceSlider' => request('priceSlider')])->links() }}
                        </div>
                    @endif
                </div>

        </div>
    </section>
    </div>
    </section>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const priceSlider = document.getElementById('priceSlider');
            if (priceSlider) {
                priceSlider.addEventListener('input', actualizarPrecioMax);
                actualizarPrecioMax();
            }

            function actualizarPrecioMax() {
                const slider = document.getElementById('priceSlider');
                const value = slider.value;
                document.getElementById('maxPriceDisplay').textContent = value + '€';
            }


        });

        function limpiarFiltros() {
            // 1. Limpiar los valores en el DOM (basado en tus IDs reales)
            const tipo = document.getElementById('tipo');
            const price = document.getElementById('priceSlider');

            if (tipo) tipo.value = '';
            if (price) {
                price.value = 200; // Valor por defecto
                document.getElementById('maxPriceDisplay').textContent = '200€';
            }

            // 2. Redirigir a la ruta base para "limpiar" la URL y la vista
            // Esto asegura que al recargar no queden rastros de filtros anteriores
            window.location.href = window.location.pathname;
        }
    </script>
@endsection
