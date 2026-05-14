@extends('layouts.default')
@section('maincontent')

    <div id="toast-container" aria-live="polite"></div>

    <section class="hero"
        style="background-image:linear-gradient(180deg, rgba(0,0,0,0.45), rgba(0,0,0,0.3)), url('https://images.unsplash.com/photo-1631049307264-da0ec9d70304?q=80&w=1600&auto=format&fit=crop');">
        <div class="inner">
            <div>
                <h1>Tu Carrito de Reserva</h1>
                <p>Revisa las habitaciones que has añadido antes de confirmar tu estancia.</p>
            </div>
        </div>
    </section>

    <div class="cart-page-wrapper">

        {{-- Columna izquierda: resumen azul --}}
        <aside class="cart-summary-col">
            <div class="cart-summary-header">
                <span class="cart-summary-icon">🛏️</span>
                <h3>Resumen de Reserva</h3>
                <p>Habitaciones seleccionadas para tu próxima estancia en Hotel Aurora.</p>
            </div>

            <div id="cart-summary-total" class="cart-price-box" style="display:none;">
                <span class="cart-price-label">Total estimado / noche</span>
                <span id="total-price" class="cart-price-value">0.00€</span>
            </div>

            <div class="cart-aside-actions">
                <button class="cart-btn-clear" onclick="clearCart()">
                    <i class="fa-solid fa-trash"></i> Vaciar carrito
                </button>
                <button class="cart-btn-confirm" onclick="finishReservation()">
                    <i class="fa-solid fa-credit-card"></i> Confirmar y pagar
                    <div class="btn-shimmer"></div>
                </button>
            </div>

            <div class="cart-aside-info">
                <div class="cart-info-item">
                    <span>🔒</span><span>Pago 100% seguro</span>
                </div>
                <div class="cart-info-item">
                    <span>✅</span><span>Cancelación gratuita 24h</span>
                </div>
                <div class="cart-info-item">
                    <span>🏨</span><span>Check-in flexible</span>
                </div>
            </div>
        </aside>

        {{-- Columna derecha: items --}}
        <div class="cart-items-col">
            <div class="cart-items-card">
                <h2 id="cart-title" class="cart-items-title"></h2>
                <div id="cart-items-list"></div>
                <div class="cart-empty-link" id="cart-empty-link" style="display:none;">
                    <a href="/habitaciones">← Ver habitaciones disponibles</a>
                </div>
            </div>
        </div>

    </div>

    {{-- Modal de confirmación --}}
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

        function initCart()  { if (!localStorage.getItem(STORAGE_KEY)) localStorage.setItem(STORAGE_KEY, JSON.stringify([])); }
        function getCart()   { initCart(); return JSON.parse(localStorage.getItem(STORAGE_KEY)); }
        function saveCart(c) { localStorage.setItem(STORAGE_KEY, JSON.stringify(c)); }

        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.textContent = message;
            container.innerHTML = '';
            container.appendChild(toast);
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 500); }, 3000);
        }

        function updateCartUI() {
            const cart = getCart();
            const el = document.getElementById('cart-count');
            if (!el) return;
            if (cart.length > 0) { el.textContent = cart.length; el.style.display = 'flex'; }
            else { el.style.display = 'none'; }
        }

        function clearCart() {
            if (confirm('¿Estás seguro de que deseas vaciar el carrito?')) {
                localStorage.removeItem(STORAGE_KEY);
                initCart();
                renderCart();
                showToast('Carrito vaciado con éxito.', 'warning');
            }
        }

        function finishReservation() {
            const cart = getCart();
            if (cart.length === 0) { showToast('El carrito está vacío. Añade habitaciones primero.', 'error'); return; }
            const total = cart.reduce((sum, item) => sum + item.precio * item.cantidad, 0);
            document.getElementById('modal-total').textContent = `${total.toFixed(2)}€`;
            document.getElementById('confirmation-modal').style.display = 'flex';
        }

        function closeConfirmationModal() { document.getElementById('confirmation-modal').style.display = 'none'; }

        function confirmReservation() {
            closeConfirmationModal();
            showToast('¡Reserva simulada finalizada! Recibirás un email de confirmación.', 'success');
            localStorage.removeItem(STORAGE_KEY);
            initCart();
            setTimeout(() => { window.location.href = '/habitaciones'; }, 1200);
        }

        window.onclick = function(e) {
            const modal = document.getElementById('confirmation-modal');
            if (e.target == modal) closeConfirmationModal();
        };

        function renderCart() {
            const cart = getCart();
            const cartList    = document.getElementById('cart-items-list');
            const totalDisplay = document.getElementById('total-price');
            const summaryDiv  = document.getElementById('cart-summary-total');
            const title       = document.getElementById('cart-title');
            const emptyLink   = document.getElementById('cart-empty-link');
            const confirmBtn  = document.querySelector('.cart-btn-confirm');

            cartList.innerHTML = '';

            if (cart.length === 0) {
                title.textContent = 'Tu carrito está vacío 😔';
                cartList.innerHTML = '<p style="color:var(--muted); padding: 20px 0 8px; font-size:0.95rem;">No has añadido ninguna habitación todavía.</p>';
                summaryDiv.style.display  = 'none';
                emptyLink.style.display   = 'block';
                if (confirmBtn) confirmBtn.disabled = true;
                return;
            }

            title.textContent = `Tienes ${cart.length} reserva${cart.length > 1 ? 's' : ''} pendiente${cart.length > 1 ? 's' : ''}`;
            emptyLink.style.display = 'none';
            let total = 0;

            cart.forEach((item, index) => {
                const itemTotal = item.precio * item.cantidad;
                total += itemTotal;

                const itemDiv = document.createElement('div');
                itemDiv.className = 'cart-item-row';
                itemDiv.innerHTML = `
                    <div class="cart-item-icon">🛏️</div>
                    <div class="cart-item-details">
                        <div class="cart-item-name">Habitación ${item.numero ?? (index + 1)}</div>
                        <small class="cart-item-meta">Fecha reserva: ${item.fecha_reserva}</small>
                    </div>
                    <div class="cart-item-price">${itemTotal.toFixed(2)}€</div>
                `;
                cartList.appendChild(itemDiv);
            });

            totalDisplay.textContent = `${total.toFixed(2)}€`;
            summaryDiv.style.display = 'flex';
            if (confirmBtn) confirmBtn.disabled = false;
        }

        document.addEventListener('DOMContentLoaded', () => {
            initCart();
            updateCartUI();
            renderCart();
        });
    </script>
@endsection
