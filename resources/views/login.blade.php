@extends('layouts.default')
@section('maincontent')
    @if (session('success'))
        <div class="alert alert-success" style="margin: 20px;">{{ session('success') }}</div>
    @endif

    <section class="hero" role="banner" aria-labelledby="hero-title">
        <div class="inner">
            <div>
                <h1 id="hero-title">Escápate. Relájate. Repite.</h1>
                <p>Habitaciones modernas, desayuno incluido y una ubicación inmejorable en Zaragoza.</p>
            </div>

            <div id="search-dates" class="search-card">
                <form id="searchForm" action="/habitacion" method="GET">
                    <div class="search-grid">
                        <div class="field">
                            <label for="checkin">Entrada</label>
                            <input id="checkin" name="checkin" type="date" required />
                        </div>
                        <div class="field">
                            <label for="checkout">Salida</label>
                            <input id="checkout" name="checkout" type="date" required />
                        </div>
                        <div class="field">
                            <button type="submit" class="btn-primary" style="margin-top: 25px;">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
