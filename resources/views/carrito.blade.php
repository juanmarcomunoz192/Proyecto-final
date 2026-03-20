@extends('layouts.default')
@section('maincontent')
    <section class="hero">
        <div class="inner">
            <div>
                <h1>Tu Carrito de Reserva</h1>
                <p>Revisa las habitaciones que has añadido antes de confirmar tu estancia.</p>
            </div>
        </div>
    </section>

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
        window.onclick = function(event) {
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
                cartList.innerHTML =
                    '<p style="text-align:center; padding:20px;">Vuelve a la página de <a href="/habitaciones">Habitaciones</a> para empezar tu reserva.</p>';
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
@endsection
