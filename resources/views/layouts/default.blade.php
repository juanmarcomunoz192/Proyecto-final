<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hotel Aurora</title>
    <link rel="stylesheet" href="{{ asset('asset/css/proyecto.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/fontAwesome.css') }}">
</head>

<body>
    <header>
        <nav class="nav" aria-label="Main navigation">
            <div class="nav-container">
                <a class="logo" href="/login">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" aria-hidden>
                        <rect width="24" height="24" rx="6" fill="white" opacity="0.06"></rect>
                        <path d="M4 12h16" stroke="white" stroke-opacity="0.25" stroke-width="1.2"></path>
                    </svg>
                    <span class="brand">Hotel Aurora</span>
                </a>

                <div class="nav-links" role="navigation" aria-label="Enlaces principales">
                    <a href="/login">Inicio</a>
                    <a href="/habitaciones">Habitaciones</a>
                    <a href="/servicios">Servicios</a>
                    <a href="/contacto">Contacto</a>

                    <a href="{{ route('carrito') }}" class="btn btn-primary cart-button cart-pill">
                        <span class="cart-icon-wrap">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span id="cart-count" class="cart-count">0</span>
                        </span>
                        <span class="cart-label">Cesta</span>
                    </a>
                    <div class="user-menu">
                        @auth
                            <button class="btn btn-secondary dropdown-toggle" onclick="toggleDropdown()">
                                <i class="fa-solid fa-user" style="margin-right: 8px;"></i>
                                {{ Auth::user()->name }}
                            </button>

                            <div id="user-dropdown" class="user-dropdown" style="display: none;">
                                <div id="user-info" class="user-info">
                                    <strong>{{ Auth::user()->email }}</strong>
                                    <small>{{ ucfirst(Auth::user()->role) }}</small>
                                </div>
                                <hr>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="logout-btn">
                                        <i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        @endauth

                        @guest
                            <button id="auth-btn" class="btn btn-secondary" onclick="showLoginModal()">
                                Iniciar Sesión
                            </button>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
        @yield('maincontent')
    </main>
    <footer class="footer" role="contentinfo">
        <div class="footer-grid">
            <div class="footer-links">
                <h3>Hotel Aurora</h3>
                <p class="muted2">Tu lugar de descanso y confort. Reserva fácilmente y disfruta de la mejor
                    experiencia.
                </p>
            </div>

            <div class="footer-links">
                <h4>Enlaces rápidos</h4>
                <p><a href="/login">Inicio</a> · <a href="/habitaciones">Habitaciones</a> · <a
                        href="/login#search-dates">Reservas</a></p>
            </div>

            <div class="footer-links">
                <h4>Contacto</h4>
                <p class="muted2">📍 Calle Sol, 25 – Zaragoza<br>📞 +34 645 789 320<br>📧 info@hotel-aurora.com</p>
            </div>

            <div class="footer-links">
                <h4>Síguenos</h4>
                <div class="social-icons">
                    <a href="#" title="Facebook">📘</a>
                    <a href="#" title="Instagram">📷</a>
                    <a href="#" title="Twitter">🐦</a>
                </div>
            </div>
        </div>

        <div style="max-width:1200px;margin:18px auto 0 auto;text-align:center;color:rgba(255,255,255,0.85)">
            &copy; 2025 Hotel Aurora. Todos los derechos reservados.
        </div>
    </footer>


    <x-auth-modal />


</body>
<script src="{{ asset('asset/js/bootstrap.js') }}"></script>
<script src="{{ asset('asset/js/sweetalert.js') }}"></script>
<script src="{{ asset('asset/js/fontAwesome.js') }}"></script>
<script>
    function toggleDropdown() {
    const dropdown = document.getElementById('user-dropdown');
    dropdown.style.display = (dropdown.style.display === 'none' || dropdown.style.display === '') 
        ? 'block' 
        : 'none';
}

// Cerrar si hacen click fuera
window.addEventListener('click', function(e) {
    if (!document.querySelector('.user-menu').contains(e.target)) {
        document.getElementById('user-dropdown').style.display = 'none';
    }
});
</script>
</html>
