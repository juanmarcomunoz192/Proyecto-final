<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Reserva – Hotel Aurora</title>
    <link rel="stylesheet" href="{{ asset('css/proyecto.css') }}">
    <style>
        /* Layout improvements for proper footer positioning */
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .section {
            flex: 1;
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Estilos específicos para la página de carrito, adaptados a proyecto.css */
        .cart-container {
            max-width: 800px;
            width: 100%;
            margin: 40px auto;
            padding: 20px;
            background: var(--surface);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(2, 6, 23, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid rgba(15, 23, 42, 0.1);
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-details {
            flex-grow: 1;
        }

        .item-name {
            font-weight: 600;
            color: var(--blue-900);
            font-size: 1.1rem;
            margin-bottom: 4px;
        }

        .item-price {
            font-weight: 700;
            color: var(--gold);
            font-size: 1.2em;
        }

        .cart-summary {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid var(--blue-600);
            display: flex;
            justify-content: space-between;
            font-size: 1.4em;
            font-weight: 700;
            color: var(--blue-900);
        }

        .cart-actions {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        /* Fixed cart badge */
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: linear-gradient(45deg, #ff6b35, #ff8c42);
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            border: 2px solid white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            min-width: 24px;
            min-height: 24px;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .item-price {
                margin-top: 0;
            }

            .cart-actions {
                flex-direction: column;
                gap: 15px;
            }

            .cart-container {
                margin: 20px;
                padding: 15px;
            }
        }

        /* ================================
           TOAST NOTIFICATIONS (TOP-RIGHT)
           ================================ */
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
            color: var(--blue-900);
            padding: 20px 24px;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            margin-bottom: 15px;
            font-weight: 500;
            font-size: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: auto;
            max-width: 400px;
            word-wrap: break-word;
            position: relative;
            overflow: hidden;
        }

        .toast::before {
            content: '✓';
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #10b981;
            font-weight: bold;
        }

        .toast.show {
            opacity: 1;
            transform: translateX(0);
        }

        .toast-success {
            border-left: 4px solid #10b981;
            padding-left: 48px;
        }

        .toast-error {
            border-left: 4px solid #ef4444;
            padding-left: 48px;
        }

        .toast-warning {
            border-left: 4px solid #f59e0b;
            padding-left: 48px;
            color: #92400e;
        }

        .toast-error::before {
            content: '⚠';
            color: #ef4444;
        }

        .toast-warning::before {
            content: 'ℹ';
            color: #f59e0b;
        }

        /* Progress bar for toast */
        .toast::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--blue-600), var(--gold));
            animation: progress 3s linear forwards;
        }

        @keyframes progress {
            from { width: 100%; }
            to { width: 0%; }
        }

        /* ================================
           CONFIRMATION MODAL
           ================================ */
        .confirmation-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10000;
            animation: fadeIn 0.4s ease-out;
        }

        .confirmation-modal-content {
            background: var(--surface);
            border-radius: 20px;
            box-shadow: 0 30px 100px rgba(0, 0, 0, 0.4);
            max-width: 500px;
            width: 90%;
            padding: 50px;
            text-align: center;
            animation: slideIn 0.4s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .confirmation-modal h2 {
            color: var(--blue-900);
            font-size: 2.2rem;
            font-weight: 700;
            margin: 0 0 20px 0;
            letter-spacing: -0.02em;
        }

        .confirmation-modal p {
            color: #64748b;
            font-size: 1.1rem;
            line-height: 1.6;
            margin: 0 0 30px 0;
        }

        .confirmation-modal .total-amount {
            font-size: 2rem;
            font-weight: 800;
            color: var(--gold);
            margin: 30px 0;
            background: linear-gradient(135deg, var(--gold), #f0d97a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .confirmation-modal .modal-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 40px;
        }

        .confirmation-modal .btn-confirm {
            background: linear-gradient(135deg, var(--blue-600), var(--blue-900));
            color: white;
            border: none;
            padding: 18px 40px;
            border-radius: 14px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(0, 95, 204, 0.4);
            min-width: 160px;
        }

        .confirmation-modal .btn-confirm:hover {
            background: linear-gradient(135deg, var(--blue-900), #001a4d);
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(0, 95, 204, 0.5);
        }

        .confirmation-modal .btn-cancel {
            background: transparent;
            color: var(--muted);
            border: 2px solid var(--muted);
            padding: 18px 40px;
            border-radius: 14px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 160px;
        }

        .confirmation-modal .btn-cancel:hover {
            background: rgba(107, 114, 128, 0.1);
            border-color: var(--blue-600);
            color: var(--blue-600);
            transform: translateY(-2px);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
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
                <button class="btn-primary" onclick="finishReservation()">Finalizar Reserva</button>
            </div>
        </div>
    </nav>

    <header class="hero">
        <div class="inner">
            <div>
                <h1>Tu Carrito de Reserva</h1>
                <p>Revisa las habitaciones que has añadido antes de confirmar tu estancia.</p>
            </div>
        </div>
    </header>

    <section class="section">
        <div class="cart-container">
            <h2 id="cart-title"></h2>

            <div id="cart-items-list">
            </div>

            <div id="cart-summary-total" class="cart-summary" style="display:none;">
                <span>Total Estimado (x noche)</span>
                <span id="total-price">0.00€</span>
            </div>

            <div class="cart-actions">
                <button class="btn-ghost" onclick="clearCart()">Vaciar Carrito</button>
                <button class="btn-primary" onclick="finishReservation()">Confirmar y Pagar</button>
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

    <div id="toast-container" aria-live="polite"></div>

    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="confirmation-modal" style="display: none;">
        <div class="confirmation-modal-content">
            <h2>Confirmar Reserva</h2>
            <p>Estás a punto de confirmar tu reserva por un total estimado de:</p>
            <div class="total-amount" id="modal-total">0.00€</div>
            <div class="modal-buttons">
                <button class="btn-cancel" onclick="closeConfirmationModal()">Cancelar</button>
                <button class="btn-confirm" onclick="confirmReservation()">Confirmar y Pagar</button>
            </div>
        </div>
    </div>

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

            // Limpiar toasts previos y añadir el nuevo
            container.innerHTML = '';
            container.appendChild(toast);

            // Mostrar el toast
            setTimeout(() => {
                toast.classList.add('show');
            }, 100);

            // Ocultar y remover después de 3 segundos
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 500); // Espera la transición
            }, 3000);
        }

        // Mantiene solo la redirección
        function viewCart() {
            window.location.href = 'carrito.html';
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

        function clearCart() {
            if (confirm('¿Estás seguro de que deseas vaciar el carrito?')) {
                localStorage.removeItem(STORAGE_KEY);
                initCart();
                renderCart(); // Vuelve a dibujar la página vacía
                showToast('Carrito vaciado con éxito.', 'warning');
            }
        }

        // MODIFICADA: Ahora usa modal personalizado
        function finishReservation() {
            let cart = getCart();
            if (cart.length === 0) {
                showToast('El carrito está vacío. Añade habitaciones primero.', 'error');
                return;
            }

            const total = cart.reduce((sum, item) => sum + item.precio * item.cantidad, 0);
            document.getElementById('modal-total').textContent = `${total.toFixed(2)}€`;
            document.getElementById('confirmation-modal').style.display = 'flex';
        }

        // Función para mostrar modal de confirmación
        function closeConfirmationModal() {
            document.getElementById('confirmation-modal').style.display = 'none';
        }

        // Función para confirmar la reserva
        function confirmReservation() {
            closeConfirmationModal();
            // Notificación de éxito
            showToast('¡Reserva simulada finalizada! Recibirás un email de confirmación.', 'success');
            localStorage.removeItem(STORAGE_KEY);
            initCart();
            // Espera un poco para que el toast se vea antes de redirigir
            setTimeout(() => {
                window.location.href = 'login.html';
            }, 1000);
        }

        // Cerrar modal al hacer click fuera
        window.onclick = function (event) {
            const modal = document.getElementById('confirmation-modal');
            if (event.target == modal) {
                closeConfirmationModal();
            }
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

        function renderCart() {
            const cart = getCart();
            const cartList = document.getElementById('cart-items-list');
            const totalDisplay = document.getElementById('total-price');
            const summaryDiv = document.getElementById('cart-summary-total');
            const title = document.getElementById('cart-title');

            cartList.innerHTML = '';

            if (cart.length === 0) {
                title.textContent = 'El carrito está vacío 😔';
                cartList.innerHTML = '<p style="text-align:center; padding:20px;">Vuelve a la página de <a href="/habitaciones">Habitaciones</a> para empezar tu reserva.</p>';
                summaryDiv.style.display = 'none';
                document.querySelector('.cart-actions button.btn-primary').disabled = true;
                return;
            }

            title.textContent = `Tienes ${cart.length} reserva(s) pendiente(s):`;
            let total = 0;

            cart.forEach((item, index) => {
                const itemTotal = item.precio * item.cantidad;
                total += itemTotal;

                const itemDiv = document.createElement('div');
                itemDiv.className = 'cart-item';
                itemDiv.innerHTML = `
                    <div class="item-details">
                        <div class="item-name">${index + 1}. ${item.nombre}</div>
                        <small class="muted">Fecha de reserva: ${item.fecha_reserva}</small>
                    </div>
                    <div class="item-price">${itemTotal.toFixed(2)}€</div>
                `;
                cartList.appendChild(itemDiv);
            });

            totalDisplay.textContent = `${total.toFixed(2)}€`;
            summaryDiv.style.display = 'flex';
            document.querySelector('.cart-actions button.btn-primary').disabled = false;
        }

        document.addEventListener('DOMContentLoaded', () => {
            initCart();
            updateCartUI();
            renderCart();
        });
    </script>
</body>

</html>