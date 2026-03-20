@extends('layouts.default')
@section('maincontent')
    <section class="hero"
        style="background-image:linear-gradient(180deg, rgba(0,0,0,0.35), rgba(0,0,0,0.25)), url('https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80');">
        <div class="inner">
            <div>
                <h1>Contacto</h1>
                <p>Estamos aquí para ayudarte. Envíanos tus dudas o consultas.</p>
            </div>
        </div>
    </section>

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
            window.location.href = 'carrito';
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

        document.addEventListener('DOMContentLoaded', function() {
            initCart();
            updateCartUI();
        });
    </script>
@endsection
