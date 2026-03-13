<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto – Hotel Aurora</title>
    <link rel="stylesheet" href="{{ asset('css/proyecto.css') }}">
</head>

<body>

    <nav class="nav">
        <div class="nav-container">
            <a class="logo" href="/login">
                <span class="brand">Hotel Aurora</span>
            </a>

            <div class="nav-links">
                <a href="/login">Inicio</a>
                <a href="/habitaciones">Habitaciones</a>
                <a href="/servicios">Servicios</a>
                <a href="/contacto">Contacto</a>
                <button class="btn-primary" onclick="viewCart()">Ver Carrito</button>
            </div>
        </div>
    </nav>

    <header class="hero"
        style="background-image:linear-gradient(180deg, rgba(0,0,0,0.35), rgba(0,0,0,0.25)), url('https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80');">
        <div class="inner">
            <div>
                <h1>Contacto</h1>
                <p>Estamos aquí para ayudarte. Envíanos tus dudas o consultas.</p>
            </div>
        </div>
    </header>

    <section class="section">
        <h2>Escríbenos</h2>

        <div class="search-card" style="max-width:600px; margin:auto">

            <form onsubmit="handleContactForm(event)">
                <div class="field">
                    <label>Nombre completo</label>
                    <input id="contactName" type="text" placeholder="Tu nombre" required>
                </div>

                <div class="field">
                    <label>Email</label>
                    <input id="contactEmail" type="email" placeholder="tuemail@ejemplo.com" required>
                </div>

                <div class="field">
                    <label>Teléfono</label>
                    <input id="contactPhone" type="tel" placeholder="+34 600 000 000" required>
                </div>

                <div class="field">
                    <label>Mensaje</label>
                    <textarea id="contactMessage" style="height:120px; padding:10px; border-radius:8px; border:1px solid #ccc;"
                        placeholder="Escribe aquí tu mensaje..." required></textarea>
                </div>

                <div class="search-actions">
                    <button type="submit" class="btn-primary">Enviar mensaje</button>
                </div>
            </form>

        </div>
    </section>

    <footer class="footer" role="contentinfo">
        <div class="footer-grid">
            <div class="footer-links">
                <h3>Hotel Aurora</h3>
                <p class="muted2">Tu lugar de descanso y confort. Reserva fácilmente y disfruta de la mejor experiencia.
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

    <div id="toast-container" aria-live="polite"></div>

    <script>
        const STORAGE_KEY = 'hotelAuroraCart';

        function initCart() {
            if (!localStorage.getItem(STORAGE_KEY)) {
                localStorage.setItem(STORAGE_KEY, JSON.stringify([]));
            }
        }

        function getCart() {
            initCart();
            return JSON.parse(localStorage.getItem(STORAGE_KEY));
        }

        function saveCart(cart) {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(cart));
        }

        // Función para actualizar el contador del carrito (consistencia entre páginas)
        function updateCartUI() {
            const cart = getCart();
            const cartCountElement = document.getElementById('cart-count');
            if (!cartCountElement) return;

            if (cart.length > 0) {
                cartCountElement.textContent = cart.length;
                cartCountElement.style.display = 'flex';
            } else {
                cartCountElement.style.display = 'none';
            }
        }

        // NUEVA FUNCIÓN TOAST
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.textContent = message;

            container.innerHTML = '';
            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('show');
            }, 100);

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 500);
            }, 3000);
        }

        // Función para añadir (necesaria para la consistencia del script)
        function addToCart(id, nombre, precio) {
            let cart = getCart();
            const newItem = {
                id: id,
                nombre: nombre,
                precio: parseFloat(precio),
                cantidad: 1,
                fecha_reserva: new Date().toISOString().split('T')[0]
            };

            cart.push(newItem);
            saveCart(cart);
            showToast(`¡Habitación "${nombre}" añadida! Reservas pendientes: ${cart.length}.`);
        }

        // Función principal: redirige al carrito.
        function viewCart() {
            window.location.href = 'carrito.html';
        }

        // Funciones no usadas en esta página (necesarias para evitar errores si el script de login.html se copia)
        function buscar(e) {
            e.preventDefault();
            showToast('Busca habitaciones desde la página de inicio.', 'warning');
        }

        function handleRoomReservation(id, nombre, precio) {
            addToCart(id, nombre, precio);
        }

        (function setMinDates() {
            // No se usa
        })();

        // Función para manejar el envío del formulario de contacto
        function handleContactForm(event) {
            event.preventDefault();
            const name = document.getElementById('contactName').value;
            const email = document.getElementById('contactEmail').value;
            const phone = document.getElementById('contactPhone').value;
            const message = document.getElementById('contactMessage').value;

            // Guardar en localStorage
            const contacts = JSON.parse(localStorage.getItem('hotelAuroraContacts')) || [];
            contacts.push({
                id: Date.now(),
                name: name,
                email: email,
                phone: phone,
                message: message,
                fecha: new Date().toISOString().split('T')[0]
            });
            localStorage.setItem('hotelAuroraContacts', JSON.stringify(contacts));

            // Resetear formulario y mostrar toast
            event.target.reset();
            showToast('Mensaje enviado exitosamente. Nos pondremos en contacto pronto.', 'success');
        }

        document.addEventListener('DOMContentLoaded', function () { initCart(); updateCartUI(); });
    </script>
</body>

</html>