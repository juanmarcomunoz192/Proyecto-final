<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitaciones – Hotel Aurora</title>
    <link rel="stylesheet" href="{{ asset('css/proyecto.css') }}">
    <style>
        /* TOAST NOTIFICATIONS (TOP-RIGHT) - estilo similar al carrito */
        #toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            max-width: 400px;
            pointer-events: none;
        }

        .toast {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            color: var(--blue-900, #0f172a);
            padding: 14px 18px;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
            margin-bottom: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            border: 1px solid rgba(255, 255, 255, 0.22);
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: auto;
            max-width: 400px;
            word-wrap: break-word;
            position: relative;
            overflow: hidden;
        }

        .toast::before {
            content: '✓';
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 16px;
            color: #10b981;
            font-weight: bold;
        }

        .toast.show {
            opacity: 1;
            transform: translateX(0);
        }

        .toast-success { border-left: 4px solid #10b981; padding-left: 44px; }
        .toast-error { border-left: 4px solid #ef4444; padding-left: 44px; }
        .toast-warning { border-left: 4px solid #f59e0b; padding-left: 44px; color: #92400e; }

        .toast-error::before { content: '⚠'; color: #ef4444; }
        .toast-warning::before { content: 'ℹ'; color: #f59e0b; }

        /* Barra de progreso visual */
        .toast::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--blue-600, #2563eb), var(--gold, #f59e0b));
            animation: progress 3s linear forwards;
        }

        @keyframes progress { from { width: 100%; } to { width: 0%; } }
    </style>
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

    <div id="toast-container" aria-live="polite"></div>

    <header class="hero">
        <div class="inner">
            <div>
                <h1>Nuestras Habitaciones</h1>
                <p>12 espacios diseñados para tu descanso y confort, con estilo moderno y servicios premium.</p>
            </div>
        </div>
    </header>

    <section class="section">
        <div class="rooms-section-wrapper">
            <!-- SIDEBAR DE FILTROS (estilo Trivago) -->
            <aside class="filters-sidebar">
                <div class="filters-header">
                    <h3>Filtros</h3>
                    <button class="btn-ghost" onclick="limpiarFiltros()" title="Limpiar todos los filtros">✕</button>
                </div>

                <form id="filterForm">
                    <!-- Búsqueda de texto -->
                    <div class="filter-group">
                        <label for="search">Buscar por nombre</label>
                        <input id="search" name="search" type="search" placeholder="Ej. Suite, Premium..." 
                               onchange="filtrarHabitaciones()">
                    </div>

                    <!-- Tipo de habitación -->
                    <div class="filter-group">
                        <label for="roomtype">Tipo de habitación</label>
                        <select id="roomtype" name="roomtype" onchange="filtrarHabitaciones()">
                            <option value="">Todos</option>
                            <option value="individual">Individual</option>
                            <option value="doble">Doble</option>
                            <option value="suite">Suite</option>
                        </select>
                    </div>

                    <!-- Capacidad de huéspedes -->
                    <div class="filter-group">
                        <label for="guests">Capacidad de huéspedes</label>
                        <select id="guests" name="guests" onchange="filtrarHabitaciones()">
                            <option value="">Cualquiera</option>
                            <option value="1">1 huésped</option>
                            <option value="2">2 huéspedes</option>
                            <option value="3">3 huéspedes</option>
                            <option value="4">4+ huéspedes</option>
                        </select>
                    </div>

                    <!-- Rango de precio con slider -->
                    <div class="filter-group">
                        <label>Rango de precio</label>
                        <div class="price-range-display">
                            <span id="minPriceDisplay">0€</span> - <span id="maxPriceDisplay">200€</span>
                        </div>
                        <input id="priceSlider" name="priceSlider" type="range" min="0" max="200" value="200" 
                               oninput="actualizarPrecioMax(); filtrarHabitaciones()">
                        <small class="muted">Hasta <span id="priceValue">200</span>€/noche</small>
                    </div>

                    <!-- Ordenamiento -->
                    <div class="filter-group">
                        <label for="sortBy">Ordenar por</label>
                        <select id="sortBy" name="sortBy" onchange="filtrarHabitaciones()">
                            <option value="">Recomendado</option>
                            <option value="price-asc">Precio: menor a mayor</option>
                            <option value="price-desc">Precio: mayor a menor</option>
                            <option value="name">Nombre (A-Z)</option>
                        </select>
                    </div>
                </form>
            </aside>

            <!-- CONTENEDOR PRINCIPAL DE HABITACIONES -->
            <div class="rooms-main-container">
                <!-- Contador de resultados -->
                <div class="results-info">
                    <span id="resultCount">Cargando habitaciones...</span>
                </div>

                <!-- Grilla de habitaciones -->
                <div class="rooms-grid" id="roomsGrid">
                </div>
            </div>
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

        // MODIFICADA: Ahora usa showToast
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

        // Datos de habitaciones (será rellenado dinámicamente)
        const allRooms = [
            { id: 1, tipo: 'individual', capacidad: 1, nombre: 'Individual Clásica', precio: 45, badge: 'Popular', imagen: 'https://images.unsplash.com/photo-1554995207-c18c203602cb?q=80', features: ['🛏 1 cama', '📶 Wi-Fi', '🍳 Desayuno'] },
            { id: 2, tipo: 'doble', capacidad: 2, nombre: 'Doble Estándar', precio: 70, badge: '', imagen: 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?q=80', features: ['🛏 2 camas', '📺 Smart TV', '🛁 Baño privado'] },
            { id: 3, tipo: 'suite', capacidad: 2, nombre: 'Suite Deluxe', precio: 120, badge: '', imagen: 'https://images.unsplash.com/photo-1496412705862-e0088f16f791?q=80', features: ['🛏 King Size', '🍾 Minibar', '🧖 Spa'] },
            { id: 4, tipo: 'doble', capacidad: 2, nombre: 'Doble Superior', precio: 95, badge: '', imagen: 'https://images.unsplash.com/photo-1617093727343-3746ea41f785?q=80', features: ['🛏 Cama Queen', '🌆 Vistas ciudad', '📶 Wi-Fi'] },
            { id: 5, tipo: 'suite', capacidad: 4, nombre: 'Suite Familiar', precio: 150, badge: '', imagen: 'https://images.unsplash.com/photo-1559599746-7a63f62e93a0?q=80', features: ['👨‍👩‍👧 4 personas', '🛋 Sala', '📺 TV 50\"'] },
            { id: 6, tipo: 'individual', capacidad: 1, nombre: 'Habitación Económica', precio: 35, badge: '', imagen: 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80', features: ['🛏 1 cama', '🧼 Baño compartido', '📶 Wi-Fi'] },
            { id: 7, tipo: 'suite', capacidad: 2, nombre: 'Premium Vista Ciudad', precio: 130, badge: '', imagen: 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80', features: ['🌆 Vistas 360°', '🛏 King Size', '🍾 Minibar'] },
            { id: 8, tipo: 'doble', capacidad: 2, nombre: 'Doble Balcón', precio: 85, badge: '', imagen: 'https://images.unsplash.com/photo-1631049552057-403c7c6f7998?q=80', features: ['🌅 Balcón', '🛏 Cama Queen', '📶 Wi-Fi'] },
            { id: 9, tipo: 'doble', capacidad: 2, nombre: 'Loft Moderno', precio: 110, badge: '', imagen: 'https://images.unsplash.com/photo-1622396481090-d8b3dd4198e0?q=80', features: ['🛋 Espacio amplio', '🖥 Escritorio', '🎧 Aislado'] },
            { id: 10, tipo: 'suite', capacidad: 2, nombre: 'Suite Ejecutiva', precio: 140, badge: '', imagen: 'https://images.unsplash.com/photo-1584132967334-10e028bd69f7?q=80', features: ['💼 Escritorio premium', '🛏 King Size', '🍾 Minibar'] },
            { id: 11, tipo: 'individual', capacidad: 1, nombre: 'Habitación Minimalista', precio: 60, badge: '', imagen: 'https://images.unsplash.com/photo-1582719478236-79f6d1cf0d47?q=80', features: ['🛏 1 cama', '🧘 Espacio Zen', '🌿 Decoración natural'] },
            { id: 12, tipo: 'suite', capacidad: 2, nombre: 'Suite Romántica', precio: 160, badge: '', imagen: 'https://images.unsplash.com/photo-1621393423634-836bb0c7c447?q=80', features: ['❤️ Jacuzzi', '🕯 Iluminación ambiente', '🍾 Botella bienvenida'] }
        ];

        // Función auxiliar para actualizar el display del rango de precio
        function actualizarPrecioMax() {
            const slider = document.getElementById('priceSlider');
            const value = slider.value;
            document.getElementById('priceValue').textContent = value;
            document.getElementById('maxPriceDisplay').textContent = value + '€';
        }

        // Función para renderizar las habitaciones filtradas y ordenadas
        function filtrarHabitaciones(event) {
            if (event && event.preventDefault) event.preventDefault();

            const tipoSeleccionado = document.getElementById('roomtype').value;
            const capacidadSeleccionada = document.getElementById('guests').value;
            const searchTerm = document.getElementById('search').value.trim().toLowerCase();
            const maxPrice = parseFloat(document.getElementById('priceSlider').value);
            const sortBy = document.getElementById('sortBy').value;

            // Filtrar habitaciones
            let filtered = allRooms.filter(room => {
                let incluir = true;

                // Filtro por tipo
                if (tipoSeleccionado && room.tipo !== tipoSeleccionado) incluir = false;

                // Filtro por capacidad
                if (capacidadSeleccionada && room.capacidad < parseInt(capacidadSeleccionada)) incluir = false;

                // Filtro por texto
                if (searchTerm) {
                    const combined = (room.nombre + ' ' + room.features.join(' ')).toLowerCase();
                    if (!combined.includes(searchTerm)) incluir = false;
                }

                // Filtro por precio
                if (room.precio > maxPrice) incluir = false;

                return incluir;
            });

            // Ordenamiento
            if (sortBy === 'price-asc') {
                filtered.sort((a, b) => a.precio - b.precio);
            } else if (sortBy === 'price-desc') {
                filtered.sort((a, b) => b.precio - a.precio);
            } else if (sortBy === 'name') {
                filtered.sort((a, b) => a.nombre.localeCompare(b.nombre, 'es'));
            }

            // Renderizar habitaciones
            const container = document.getElementById('roomsGrid');
            container.innerHTML = '';

            filtered.forEach(room => {
                const card = document.createElement('div');
                card.className = 'room-card';
                card.setAttribute('data-tipo', room.tipo);
                card.setAttribute('data-capacidad', room.capacidad);

                card.innerHTML = `
                    <div class="room-media" style="background-image:url('${room.imagen}');"></div>
                    <div class="room-body">
                        <div class="room-title">
                            <span>${room.nombre}</span>
                            ${room.badge ? `<span class="badge">${room.badge}</span>` : ''}
                        </div>
                        <div class="room-features">
                            ${room.features.map(f => `<span>${f}</span>`).join('')}
                        </div>
                    </div>
                    <div class="room-footer">
                        <span class="price">${room.precio}€/noche</span>
                        <button class="btn-ghost" onclick="addToCart(${room.id}, '${room.nombre}', ${room.precio})">Reservar</button>
                    </div>
                `;

                container.appendChild(card);
            });

            // Actualizar contador de resultados
            const resultCount = document.getElementById('resultCount');
            if (filtered.length === 0) {
                resultCount.textContent = '❌ No se encontraron habitaciones';
                showToast('No hay habitaciones disponibles con esos filtros.', 'warning');
            } else {
                const plural = filtered.length === 1 ? 'habitación' : 'habitaciones';
                resultCount.textContent = `✓ ${filtered.length} ${plural} encontrada(s)`;
            }
        }

        // Función para limpiar filtros
        function limpiarFiltros() {
            document.getElementById('search').value = '';
            document.getElementById('roomtype').value = '';
            document.getElementById('guests').value = '';
            document.getElementById('priceSlider').value = 200;
            document.getElementById('sortBy').value = '';
            actualizarPrecioMax();
            filtrarHabitaciones();
            showToast('Filtros limpiados', 'info');
        }

        (function setMinDates() {
            // No se usa
        })();

        document.addEventListener('DOMContentLoaded', function () {
            initCart();
            updateCartUI();

            // Inicializar slider de precio
            const priceSlider = document.getElementById('priceSlider');
            if (priceSlider) {
                priceSlider.addEventListener('input', actualizarPrecioMax);
                actualizarPrecioMax(); // Inicializar display
            }

            // Leer parámetros de URL y preestablecer filtros
            try {
                const params = new URLSearchParams(window.location.search);
                
                // Parámetro: búsqueda de texto
                const buscar = params.get('buscar');
                if (buscar) {
                    const searchInput = document.getElementById('search');
                    if (searchInput) {
                        searchInput.value = decodeURIComponent(buscar);
                        searchInput.focus();
                    }
                }
                
                // Parámetro: capacidad de huéspedes
                const guests = params.get('guests');
                if (guests) {
                    const guestsInput = document.getElementById('guests');
                    if (guestsInput) {
                        guestsInput.value = guests;
                    }
                }
                
                // Parámetro: tipo de habitación
                const roomtype = params.get('roomtype');
                if (roomtype) {
                    const roomtypeInput = document.getElementById('roomtype');
                    if (roomtypeInput) {
                        roomtypeInput.value = roomtype;
                    }
                }
                
                // Parámetro: precio máximo
                const maxPrice = params.get('maxPrice');
                if (maxPrice) {
                    const priceSliderEl = document.getElementById('priceSlider');
                    if (priceSliderEl) {
                        priceSliderEl.value = maxPrice;
                        actualizarPrecioMax();
                    }
                }
            } catch (err) {
                console.error('Error procesando parámetros de búsqueda:', err);
            }

            // Renderizar habitaciones iniciales con filtros aplicados
            filtrarHabitaciones();
        });
    </script>
</body>

</html>