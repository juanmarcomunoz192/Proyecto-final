@extends('layouts.default')
@section('maincontent')
    <section class="hero"
        style="background-image:linear-gradient(180deg, rgba(0,0,0,0.35), rgba(0,0,0,0.25)), url('https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?q=80');">
        <div class="inner">
            <div>
                <h1>Servicios del Hotel</h1>
                <p>Experiencias y comodidades pensadas para hacer tu estancia inolvidable.</p>
            </div>
        </div>
    </section>

    <section class="section">
        <h2>Todo lo que necesitas para una estancia perfecta</h2>

        <div class="rooms-grid">

            <div class="room-card">
                <div class="room-media"
                    style="background-image:url('https://images.unsplash.com/photo-1504610926078-a1611febcad3?q=80');">
                </div>
                <div class="room-body">
                    <div class="room-title"><span>Spa & Wellness</span></div>
                    <p class="muted">Masajes, sauna, jacuzzi y terapias relajantes.</p>
                </div>
            </div>

            <div class="room-card">
                <div class="room-media"
                    style="background-image:url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80');">
                </div>
                <div class="room-body">
                    <div class="room-title"><span>Restaurante Gourmet</span></div>
                    <p class="muted">Cocina mediterránea moderna con ingredientes frescos.</p>
                </div>
            </div>

            <div class="room-card">
                <div class="room-media"
                    style="background-image:url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80');">
                </div>
                <div class="room-body">
                    <div class="room-title"><span>Gimnasio 24h</span></div>
                    <p class="muted">Espacio moderno con máquinas de última generación.</p>
                </div>
            </div>

            <div class="room-card">
                <div class="room-media"
                    style="background-image:url('https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80');">
                </div>
                <div class="room-body">
                    <div class="room-title"><span>Piscina Exterior</span></div>
                    <p class="muted">Piscina climatizada con solárium y zona chill.</p>
                </div>
            </div>

            <div class="room-card">
                <div class="room-media"
                    style="background-image:url('https://images.unsplash.com/photo-1445019980597-93fa8acb246c?q=80');">
                </div>
                <div class="room-body">
                    <div class="room-title"><span>Wifi Alta Velocidad</span></div>
                    <p class="muted">Internet rápido en todo el hotel sin coste.</p>
                </div>
            </div>

            <div class="room-card">
                <div class="room-media"
                    style="background-image:url('https://images.unsplash.com/photo-1525186402429-b4ff38bedbec?q=80');">
                </div>
                <div class="room-body">
                    <div class="room-title"><span>Parking Privado</span></div>
                    <p class="muted">Aparcamiento vigilado 24/7 dentro del hotel.</p>
                </div>
            </div>

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

        document.addEventListener('DOMContentLoaded', function() {
            initCart();
            updateCartUI();
        });
    </script>
@endsection
