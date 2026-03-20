<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HotelAurora</title>
    <link rel="stylesheet" href="{{ asset('asset/css/proyecto.css') }}">
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

                    <button class="btn btn-primary cart-button cart-pill" onclick="viewCart()">
                        <span class="cart-icon-wrap">
                            <!-- SVG cart icon (customizable) -->
                            <svg class="cart-icon" viewBox="0 0 24 24" aria-hidden focusable="false" width="20"
                                height="20">
                                <path fill="currentColor"
                                    d="M7 4h-2l-1 2H1v2h2l3.6 7.59-1.35 2.45C4.89 18.37 5.48 19 6.22 19h12.56v-2H6.42c-.07 0-.13-.03-.17-.08l.03-.07L7.1 16h8.45c.75 0 1.41-.41 1.75-1.03L21.92 6H6.21L5.27 4H7z">
                                </path>
                            </svg>
                            <span id="cart-count" class="cart-count">0</span>
                        </span>
                        <span class="cart-label">Cesta</span>
                    </button>
                    <div class="user-menu">
                        <button id="auth-btn" class="btn btn-secondary" onclick="toggleUserMenu()">Iniciar
                            Sesión</button>
                        <div id="user-dropdown" class="user-dropdown">
                            <div id="user-info" class="user-info"></div>
                            <button onclick="logout()" class="logout-btn">Cerrar Sesión</button>
                        </div>
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
</body>

</html>
