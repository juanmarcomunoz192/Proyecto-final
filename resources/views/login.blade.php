@extends('layouts.default')
@section('maincontent')
    <section class="hero" role="banner" aria-labelledby="hero-title">
        <div class="inner">
            <div>
                <h1 id="hero-title">Escápate. Relájate. Repite.</h1>
                <p>Habitaciones modernas, desayuno incluido y una ubicación inmejorable en Zaragoza. Reserva con las
                    mejores condiciones.</p>
                <div class="muted" style="margin-top:14px">Mejor precio garantizado • Cancelación gratuita 24h antes •
                    Wi-Fi gratuito</div>
            </div>

            <div id="search-dates" class="search-card" aria-labelledby="buscar">
                <form id="searchForm" onsubmit="buscar(event)">
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
                            <label for="guests">Huéspedes</label>
                            <select id="guests" name="guests">
                                <option value="1">1 huésped</option>
                                <option value="2" selected>2 huéspedes</option>
                                <option value="3">3 huéspedes</option>
                                <option value="4">4 huéspedes</option>
                            </select>
                        </div>
                        <div class="field">
                            <label for="roomtype">Tipo habitación</label>
                            <select id="roomtype" name="roomtype">
                                <option value="">Cualquiera</option>
                                <option value="individual">Individual</option>
                                <option value="doble">Doble</option>
                                <option value="suite">Suite</option>
                            </select>
                        </div>
                        <div class="field">
                            <label for="maxPrice">Precio máximo</label>
                            <select id="maxPrice" name="maxPrice">
                                <option value="200">Hasta 200€</option>
                                <option value="50">Hasta 50€</option>
                                <option value="75">Hasta 75€</option>
                                <option value="100">Hasta 100€</option>
                                <option value="150">Hasta 150€</option>
                            </select>
                        </div>
                        <div class="field">
                            <label for="globalSearch">Buscar por nombre</label>
                            <input id="globalSearch" name="globalSearch" type="search" placeholder="Ej. Suite, Premium...">
                        </div>
                    </div>

                    <div class="search-actions">
                        <div class="price-hint muted">Desde 35€/noche • Cancelación gratis</div>
                        <button type="submit" class="btn-primary">Buscar habitaciones</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="section" aria-labelledby="rooms-title">
        <h2 id="rooms-title">Habitaciones destacadas</h2>

        <div class="rooms-grid" id="roomsGrid">
            <article class="room-card" aria-labelledby="r1title">
                <div class="room-media"
                    style="background-image:url('https://images.unsplash.com/photo-1554995207-c18c203602cb?q=80&w=1200&auto=format&fit=crop')">
                </div>
                <div class="room-body">
                    <div class="room-title">
                        <div id="r1title">Habitación Individual</div>
                        <div class="badge">Más reservada</div>
                    </div>
                    <div class="room-features">
                        <div>🛏 1 cama</div>
                        <div>📶 Wi-Fi</div>
                        <div>🍽 Desayuno</div>
                    </div>
                </div>
                <div class="room-footer">
                    <div class="price">45€/noche</div>
                    <button class="btn-ghost"
                        onclick="handleRoomReservation(1, 'Habitación Individual', 45)">Reservar</button>
                </div>
            </article>

            <article class="room-card" aria-labelledby="r2title">
                <div class="room-media"
                    style="background-image:url('https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?q=80&w=1200&auto=format&fit=crop')">
                </div>
                <div class="room-body">
                    <div class="room-title">
                        <div id="r2title">Habitación Doble</div>
                        <div class="muted">2 adultos</div>
                    </div>
                    <div class="room-features">
                        <div>🛏 2 camas</div>
                        <div>📺 Smart TV</div>
                        <div>🛁 Baño privado</div>
                    </div>
                </div>
                <div class="room-footer">
                    <div class="price">80€/noche</div>
                    <button class="btn-ghost" onclick="handleRoomReservation(2, 'Habitación Doble', 80)">Reservar</button>
                </div>
            </article>

            <article class="room-card" aria-labelledby="r3title">
                <div class="room-media"
                    style="background-image:url('https://images.unsplash.com/photo-1496412705862-e0088f16f791?q=80&w=1200&auto=format&fit=crop')">
                </div>
                <div class="room-body">
                    <div class="room-title">
                        <div id="r3title">Suite Deluxe</div>
                        <div class="muted">2 adultos • 1 niño</div>
                    </div>
                    <div class="room-features">
                        <div>🛏 Cama king</div>
                        <div>🍾 Minibar</div>
                        <div>🧖 Spa privado</div>
                    </div>
                </div>
                <div class="room-footer">
                    <div class="price">120€/noche</div>
                    <button class="btn-ghost" onclick="handleRoomReservation(3, 'Suite Deluxe', 120)">Reservar</button>
                </div>
            </article>
        </div>
    </section>

    <section class="section" aria-labelledby="test-title">
        <h2 id="test-title">Opiniones de huéspedes</h2>
        <div class="testimonials">
            <div class="test-grid">
                <div class="test">
                    <strong>María G.</strong>
                    <p class="muted">"Estancia fantástica, el personal muy atento y la habitación impecable."</p>
                </div>
                <div class="test">
                    <strong>Carlos R.</strong>
                    <p class="muted">"Excelente ubicación y desayuno delicioso. Repetiré seguro."</p>
                </div>
            </div>
        </div>
    </section>




    <!-- Modal de autenticación -->
    <div id="auth-modal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="closeLoginModal()">&times;</span>
            <div id="login-view">
                <h2>Iniciar Sesión</h2>
                <form id="login-form" onsubmit="handleLogin(event)">
                    <div class="form-group">
                        <label for="login-email">Email:</label>
                        <input type="email" id="login-email" required>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Contraseña:</label>
                        <input type="password" id="login-password" required>
                    </div>
                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="remember-me"> Recordarme
                        </label>
                    </div>
                    <button type="submit" class="btn-primary">Iniciar Sesión</button>
                </form>
                <p><a href="#" onclick="showRegisterView()">¿No tienes cuenta? Regístrate</a></p>
                <p><a href="#" onclick="forgotPassword()">¿Olvidaste tu contraseña?</a></p>
            </div>
            <div id="register-view" style="display: none;">
                <h2>Registrarse</h2>
                <form id="register-form" onsubmit="handleRegister(event)">
                    <div class="form-group">
                        <label for="register-name">Nombre:</label>
                        <input type="text" id="register-name" required>
                    </div>
                    <div class="form-group">
                        <label for="register-email">Email:</label>
                        <input type="email" id="register-email" required>
                    </div>
                    <div class="form-group">
                        <label for="register-password">Contraseña:</label>
                        <input type="password" id="register-password" required>
                    </div>
                    <button type="submit" class="btn-primary">Registrarse</button>
                </form>
                <p><a href="#" onclick="showLoginView()">¿Ya tienes cuenta? Inicia sesión</a></p>
            </div>
            <p id="auth-message"></p>
        </div>
    </div>

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

        // NUEVA FUNCIÓN TOAST (TOP-RIGHT)
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.textContent = message;

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
            updateCartUI();
            showToast('Añadido a la cesta');
        }

        // Función para actualizar el contador del carrito
        function updateCartUI() {
            const cart = getCart();
            const cartCountElement = document.getElementById('cart-count');

            if (cart.length > 0) {
                cartCountElement.textContent = cart.length;
                cartCountElement.style.display = 'flex';
            } else {
                cartCountElement.style.display = 'none';
            }
        }

        // Función principal: redirige al carrito.
        function viewCart() {
            window.location.href = 'carrito.html';
        }

        // Función para mostrar modal de confirmación
        function showConfirmationModal() {
            const modal = document.getElementById('confirmation-modal');
            modal.style.display = 'flex';
        }

        // Función para cerrar modal de confirmación
        function closeConfirmationModal() {
            const modal = document.getElementById('confirmation-modal');
            modal.style.display = 'none';
            // Aquí podrías redirigir a la página de reservas
            // window.location.href = 'mis-reservas.html';
        }

        // Cerrar modal al hacer click fuera
        window.onclick = function(event) {
            const confirmationModal = document.getElementById('confirmation-modal');
            if (event.target == confirmationModal) {
                closeConfirmationModal();
            }
        }

        // Lógica específica del buscador
        function buscar(e) {
            e.preventDefault();

            // Obtener todos los valores del formulario de búsqueda
            const globalSearch = (document.getElementById('globalSearch') || {}).value || '';
            const guests = document.getElementById('guests').value || '';
            const roomtype = document.getElementById('roomtype').value || '';
            const maxPrice = document.getElementById('maxPrice').value || '200';

            // Construir URL con parámetros de filtro
            const params = new URLSearchParams();

            if (globalSearch && globalSearch.trim() !== '') {
                params.append('buscar', globalSearch.trim());
            }
            if (guests) {
                params.append('guests', guests);
            }
            if (roomtype) {
                params.append('roomtype', roomtype);
            }
            if (maxPrice) {
                params.append('maxPrice', maxPrice);
            }

            const queryString = params.toString();
            const url = queryString ? `habitaciones.html?${queryString}` : 'habitaciones.html';

            window.location.href = url;
        }

        function handleRoomReservation(id, nombre, precio) {
            addToCart(id, nombre, precio);
        }

        // Mejora UX: fijar min date hoy
        (function setMinDates() {
            const checkin = document.getElementById('checkin');
            const checkout = document.getElementById('checkout');

            if (checkin && checkout) {
                const today = new Date().toISOString().split('T')[0];
                checkin.setAttribute('min', today);
                checkout.setAttribute('min', today);
            }
        })();

        // Funciones de autenticación
        let currentUser = JSON.parse(localStorage.getItem('currentUser')) || null;

        function showLoginModal() {
            document.getElementById('auth-modal').style.display = 'flex';
        }

        function closeLoginModal() {
            document.getElementById('auth-modal').style.display = 'none';
            document.getElementById('auth-message').textContent = '';
            document.getElementById('login-form').reset();
            document.getElementById('register-form').reset();
            showLoginView();
        }

        function handleLogin(event) {
            event.preventDefault();
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;
            const rememberMe = document.getElementById('remember-me').checked;

            // Simular autenticación (en producción, verificar con servidor)
            const users = JSON.parse(localStorage.getItem('users')) || [];
            const user = users.find(u => u.email === email && u.password === password);

            if (user) {
                currentUser = user;
                const userData = {
                    ...user,
                    rememberMe: rememberMe
                };
                if (rememberMe) {
                    // Store for 30 days
                    userData.expires = Date.now() + 30 * 24 * 60 * 60 * 1000;
                }
                localStorage.setItem('currentUser', JSON.stringify(userData));
                closeLoginModal();
                updateAuthUI();
                showToast('Inicio de sesión exitoso', 'success');
            } else {
                document.getElementById('auth-message').textContent = 'Credenciales incorrectas';
                document.getElementById('auth-message').style.color = 'red';
            }
        }

        function handleRegister(event) {
            event.preventDefault();
            const name = document.getElementById('register-name').value;
            const email = document.getElementById('register-email').value;
            const password = document.getElementById('register-password').value;

            // Verificar si el usuario ya existe
            const users = JSON.parse(localStorage.getItem('users')) || [];
            const existingUser = users.find(u => u.email === email);

            if (existingUser) {
                document.getElementById('auth-message').textContent = 'El email ya está registrado';
                document.getElementById('auth-message').style.color = 'red';
                return;
            }

            // Crear nuevo usuario
            const newUser = {
                id: Date.now(),
                name: name,
                email: email,
                password: password
            };

            users.push(newUser);
            localStorage.setItem('users', JSON.stringify(users));

            // Auto-login después del registro
            currentUser = newUser;
            localStorage.setItem('currentUser', JSON.stringify(newUser));
            closeLoginModal();
            updateAuthUI();
            showToast('Registro exitoso', 'success');
        }

        function showRegisterView() {
            document.getElementById('login-view').style.display = 'none';
            document.getElementById('register-view').style.display = 'block';
            document.getElementById('auth-message').textContent = '';
        }

        function showLoginView() {
            document.getElementById('register-view').style.display = 'none';
            document.getElementById('login-view').style.display = 'block';
            document.getElementById('auth-message').textContent = '';
        }

        function logout() {
            currentUser = null;
            localStorage.removeItem('currentUser');
            updateAuthUI();
            showToast('Sesión cerrada', 'success');
        }

        function forgotPassword() {
            const email = prompt('Ingresa tu email para recuperar la contraseña:');
            if (email) {
                const users = JSON.parse(localStorage.getItem('users')) || [];
                const user = users.find(u => u.email === email);
                if (user) {
                    // In a real app, send email. Here, just show a message
                    showToast('Se ha enviado un email con instrucciones para recuperar tu contraseña.', 'success');
                } else {
                    showToast('No se encontró una cuenta con ese email.', 'error');
                }
            }
        }

        function checkRememberMe() {
            const storedUser = JSON.parse(localStorage.getItem('currentUser'));
            if (storedUser && storedUser.rememberMe && storedUser.expires) {
                if (Date.now() < storedUser.expires) {
                    currentUser = storedUser;
                } else {
                    localStorage.removeItem('currentUser');
                }
            }
        }

        function updateAuthUI() {
            const authBtn = document.getElementById('auth-btn');
            const userDropdown = document.getElementById('user-dropdown');
            const userInfo = document.getElementById('user-info');

            if (currentUser) {
                authBtn.textContent = currentUser.name;
                authBtn.onclick = toggleUserMenu;
                userInfo.textContent = `Hola, ${currentUser.name}`;
                userDropdown.style.display = 'none'; // Oculto por defecto
            } else {
                authBtn.textContent = 'Iniciar Sesión';
                authBtn.onclick = showLoginModal;
                userDropdown.style.display = 'none';
            }
        }

        function toggleUserMenu() {
            const userDropdown = document.getElementById('user-dropdown');
            const isVisible = userDropdown.style.display === 'block';
            userDropdown.style.display = isVisible ? 'none' : 'block';
        }

        // Cerrar dropdown al hacer click fuera
        document.addEventListener('click', function(event) {
            const userMenu = document.querySelector('.user-menu');
            const userDropdown = document.getElementById('user-dropdown');
            if (!userMenu.contains(event.target)) {
                userDropdown.style.display = 'none';
            }
        });

        // Cerrar modal al hacer click fuera
        window.onclick = function(event) {
            const modal = document.getElementById('auth-modal');
            if (event.target == modal) {
                closeLoginModal();
            }
        }

        // Inicializar usuarios de ejemplo si no existen
        function initSampleUsers() {
            const users = JSON.parse(localStorage.getItem('users')) || [];
            if (users.length === 0) {
                const sampleUsers = [{
                        id: 1,
                        name: 'Juan Pérez',
                        email: 'juan@example.com',
                        password: '123456'
                    },
                    {
                        id: 2,
                        name: 'María García',
                        email: 'maria@example.com',
                        password: '123456'
                    }
                ];
                localStorage.setItem('users', JSON.stringify(sampleUsers));
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            initCart();
            initSampleUsers();
            checkRememberMe();
            updateAuthUI();
            updateCartUI();
        });
    </script>
@endsection
