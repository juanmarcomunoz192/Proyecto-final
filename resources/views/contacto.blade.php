@extends('layouts.default')
@section('maincontent')

    <div id="toast-container" aria-live="polite"></div>

    {{-- HERO --}}
    <section class="hero"
        style="background-image:linear-gradient(180deg, rgba(0,0,0,0.35), rgba(0,0,0,0.25)), url('https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80');">
        <div class="inner">
            <div>
                <h1>Contacto</h1>
                <p>Estamos aquí para ayudarte. Envíanos tus dudas o consultas.</p>
            </div>
        </div>
    </section>

    {{-- SECCIÓN PRINCIPAL --}}
    <div class="contact-page-wrapper">

        {{-- COLUMNA IZQUIERDA: Información --}}
        <aside class="contact-info-col">

            <div class="contact-info-header">
                <h2>Información de contacto</h2>
                <p>Visítanos, llámanos o escríbenos. Respondemos en menos de 24 horas.</p>
            </div>

            <div class="contact-cards">
                <div class="contact-card">
                    <div class="contact-card-icon">📍</div>
                    <div>
                        <strong>Dirección</strong>
                        <span>Calle Sol, 25 — Zaragoza, España</span>
                    </div>
                </div>
                <div class="contact-card">
                    <div class="contact-card-icon">📞</div>
                    <div>
                        <strong>Teléfono</strong>
                        <span>+34 645 789 320</span>
                    </div>
                </div>
                <div class="contact-card">
                    <div class="contact-card-icon">📧</div>
                    <div>
                        <strong>Email</strong>
                        <span>info@hotel-aurora.com</span>
                    </div>
                </div>
                <div class="contact-card">
                    <div class="contact-card-icon">🕐</div>
                    <div>
                        <strong>Horario de atención</strong>
                        <span>Lun–Dom · 8:00 – 22:00</span>
                    </div>
                </div>
            </div>

            <div class="contact-social">
                <span>Síguenos</span>
                <div class="contact-social-icons">
                    <a href="#" title="Facebook" class="social-btn">📘</a>
                    <a href="#" title="Instagram" class="social-btn">📷</a>
                    <a href="#" title="Twitter" class="social-btn">🐦</a>
                </div>
            </div>

        </aside>

        {{-- COLUMNA DERECHA: Formulario --}}
        <div class="contact-form-col">
            <div class="contact-form-card">
                <h3>Envíanos un mensaje</h3>
                <p class="contact-form-subtitle">Rellena el formulario y te contactaremos a la mayor brevedad posible.</p>

                <form id="contactForm" onsubmit="handleContactForm(event)" novalidate>

                    <div class="contact-fields-row">
                        <div class="contact-field">
                            <label for="contactName">
                                <i class="fa-solid fa-user"></i> Nombre completo
                            </label>
                            <input id="contactName" type="text" placeholder="Tu nombre completo" required autocomplete="name">
                        </div>
                        <div class="contact-field">
                            <label for="contactEmail">
                                <i class="fa-solid fa-envelope"></i> Email
                            </label>
                            <input id="contactEmail" type="email" placeholder="tuemail@ejemplo.com" required autocomplete="email">
                        </div>
                    </div>

                    <div class="contact-field">
                        <label for="contactPhone">
                            <i class="fa-solid fa-phone"></i> Teléfono
                        </label>
                        <input id="contactPhone" type="tel" placeholder="+34 600 000 000" autocomplete="tel">
                    </div>

                    <div class="contact-field">
                        <label for="contactSubject">
                            <i class="fa-solid fa-tag"></i> Asunto
                        </label>
                        <select id="contactSubject">
                            <option value="">Selecciona un asunto...</option>
                            <option value="reserva">Consulta sobre reserva</option>
                            <option value="servicios">Información de servicios</option>
                            <option value="grupos">Reservas para grupos</option>
                            <option value="incidencia">Incidencia o reclamación</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <div class="contact-field">
                        <label for="contactMessage">
                            <i class="fa-solid fa-message"></i> Mensaje
                        </label>
                        <textarea id="contactMessage" rows="5" placeholder="Escribe aquí tu mensaje..." required></textarea>
                    </div>

                    <div class="contact-privacy">
                        <input type="checkbox" id="privacyCheck" required>
                        <label for="privacyCheck">He leído y acepto la <a href="#">política de privacidad</a></label>
                    </div>

                    <button type="submit" class="contact-submit-btn" id="contactSubmitBtn">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Enviar mensaje</span>
                        <div class="btn-shimmer"></div>
                    </button>

                </form>
            </div>
        </div>

    </div>

    <script>
        /* ---- Cart helpers ---- */
        const STORAGE_KEY = 'hotelAuroraCart';
        function initCart() { if (!localStorage.getItem(STORAGE_KEY)) localStorage.setItem(STORAGE_KEY, JSON.stringify([])); }
        function getCart() { initCart(); return JSON.parse(localStorage.getItem(STORAGE_KEY)); }
        function updateCartUI() {
            const cart = getCart();
            const el = document.getElementById('cart-count');
            if (!el) return;
            if (cart.length > 0) { el.textContent = cart.length; el.style.display = 'flex'; }
            else { el.style.display = 'none'; }
        }

        /* ---- Toast ---- */
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.textContent = message;
            container.innerHTML = '';
            container.appendChild(toast);
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => { toast.classList.remove('show'); setTimeout(() => toast.remove(), 500); }, 3500);
        }

        /* ---- Contact form ---- */
        function handleContactForm(event) {
            event.preventDefault();

            const privacyCheck = document.getElementById('privacyCheck');
            if (!privacyCheck.checked) {
                showToast('Por favor, acepta la política de privacidad.', 'error');
                return;
            }

            const btn = document.getElementById('contactSubmitBtn');
            btn.classList.add('loading');
            btn.disabled = true;

            setTimeout(() => {
                const contacts = JSON.parse(localStorage.getItem('hotelAuroraContacts')) || [];
                contacts.push({
                    id: Date.now(),
                    name:    document.getElementById('contactName').value,
                    email:   document.getElementById('contactEmail').value,
                    phone:   document.getElementById('contactPhone').value,
                    subject: document.getElementById('contactSubject').value,
                    message: document.getElementById('contactMessage').value,
                    fecha:   new Date().toISOString().split('T')[0]
                });
                localStorage.setItem('hotelAuroraContacts', JSON.stringify(contacts));

                event.target.reset();
                btn.classList.remove('loading');
                btn.disabled = false;
                showToast('✅ Mensaje enviado. Nos pondremos en contacto pronto.', 'success');
            }, 900);
        }

        /* ---- Animación de entrada ---- */
        document.addEventListener('DOMContentLoaded', function () {
            initCart();
            updateCartUI();

            const cards = document.querySelectorAll('.contact-card');
            cards.forEach((card, i) => {
                card.style.opacity = '0';
                card.style.transform = 'translateX(-20px)';
                setTimeout(() => {
                    card.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateX(0)';
                }, 150 * i);
            });
        });
    </script>

@endsection
