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
            <h2 id="cart-title">Cargando...</h2>

            <div id="cart-items-list">
            </div>

            <div id="cart-summary-total" class="cart-summary" style="display:none;">
                <span>Total Estimado (x noche)</span>
                <span id="total-price">0.00€</span>
            </div>

            <div class="cart-actions">
                <button class="btn-ghost" onclick="clearCart()">Vaciar Carrito</button>
                <button class="btn-primary" id="btn-pay" onclick="finishReservation()">Confirmar y Pagar</button>
            </div>
        </div>
    </section>

    <div id="toast-container" aria-live="polite"></div>

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
        function getCart() {
            return JSON.parse(localStorage.getItem('hotelAuroraCart')) || [];
        }

        function renderCart() {
            const cart = getCart();
            const cartList = document.getElementById('cart-items-list');
            const totalDisplay = document.getElementById('total-price');
            const summaryDiv = document.getElementById('cart-summary-total');
            const title = document.getElementById('cart-title');
            const btnPay = document.getElementById('btn-pay');

            cartList.innerHTML = '';

            if (cart.length === 0) {
                title.textContent = 'El carrito está vacío 😔';
                cartList.innerHTML =
                    '<p style="text-align:center; padding:20px;">Vuelve a la página de habitaciones para empezar.</p>';
                summaryDiv.style.display = 'none';
                if (btnPay) btnPay.disabled = true;
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
            <div class="item-details" style="border-bottom: 1px solid #eee; padding: 10px 0;">
                <div class="item-name"><strong>${index + 1}. ${item.nombre}</strong> (${item.tipo})</div>
                <div class="item-dates" style="font-size: 0.9em; color: #555;">
                    <span><strong>Entrada:</strong> ${item.entrada}</span> | 
                    <span><strong>Salida:</strong> ${item.salida}</span>
                </div>
            </div>
            <div class="item-price" style="font-weight: bold;">${itemTotal.toFixed(2)}€</div>
        `;
                cartList.appendChild(itemDiv);
            });

            totalDisplay.textContent = `${total.toFixed(2)}€`;
            summaryDiv.style.display = 'flex';
            if (btnPay) btnPay.disabled = false;
        }

        function clearCart() {
            if (confirm('¿Deseas vaciar el carrito?')) {
                // Borramos del navegador
                localStorage.removeItem(STORAGE_KEY);
                // Borramos del servidor llamando a la ruta que creamos
                window.location.href = "/carrito/vaciar";
            }
        }


        function finishReservation() {
            const cart = getCart();
            if (cart.length === 0) return;
            const total = cart.reduce((sum, item) => sum + (item.precio * item.cantidad), 0);
            document.getElementById('modal-total').textContent = `${total.toFixed(2)}€`;
            document.getElementById('confirmation-modal').style.display = 'flex';
        }

        function closeConfirmationModal() {
            document.getElementById('confirmation-modal').style.display = 'none';
        }


        async function confirmReservation() {
            const cart = getCart();
            if (cart.length === 0) return;

            // Bloqueamos el botón para evitar doble clic
            const btnConfirm = document.querySelector('.btn-confirm');
            btnConfirm.disabled = true;
            btnConfirm.textContent = 'Procesando...';

            try {
                const response = await fetch("{{ route('carrito.confirmar') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Vital para Laravel
                        'Accept': 'application/json'
                    },
                    // Enviamos el contenido del localStorage al servidor
                    body: JSON.stringify({
                        carrito: cart
                    })
                });

                const result = await response.json();

                if (response.ok) {
                    // 1. Limpiamos LocalStorage
                    localStorage.removeItem(STORAGE_KEY);

                    // 2. Éxito con SweetAlert
                    Swal.fire({
                        title: '¡Reserva Confirmada!',
                        text: 'Tu estancia en Hotel Aurora ha sido registrada.',
                        icon: 'success',
                        confirmButtonColor: '#3085d6'
                    }).then(() => {
                        // Redirigimos a la página de sus reservas
                        window.location.href = "{{ route('reserva') }}";
                    });
                } else {
                    throw new Error(result.message || 'Error en el servidor');
                }

            } catch (error) {
                Swal.fire('Error', error.message, 'error');
                btnConfirm.disabled = false;
                btnConfirm.textContent = 'Confirmar y Pagar';
            } finally {
                closeConfirmationModal();
            }
        }

        function showToast(message) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `toast toast-success show`;
            toast.textContent = message;
            container.appendChild(toast);
            setTimeout(() => toast.remove(), 3000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderCart();
            @if (session('success'))
                showToast("{{ session('success') }}");
            @endif
        });
    </script>
@endsection
