<div class="boton-container">
    <button {{ $attributes->merge(['class' => 'btn-base', 'id' => 'btn-' . uniqid()]) }} onclick="manejarClick(this)">
        {{ $slot }}
    </button>
</div>

<style>
    .btn-base {
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .btn-loading {
        background-color: #eee;
        color: #888;
        cursor: not-allowed;
    }
</style>
<div id="auth-modal" class="modal" style="display: none">
    <div class="modal-content">
        <span class="close" onclick="closeLoginModal()">&times;</span>

        <div id="login-view">
            <h2>Iniciar Sesión</h2>
            <form id="login-form" action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="login-email">Email:</label>
                    <input type="email" name="email" id="login-email" value="{{ old('email') }}" >
                    @error('email')
                        <small style="color:red">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="login-password">Contraseña:</label>
                    <input type="password" name="password" id="login-password" >
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="remember"> Recordarme
                    </label>
                </div>
                <button type="submit" class="btn-primary">Entrar</button>
            </form>
            <p><a href="#" onclick="showRegisterView()">¿No tienes cuenta? Regístrate</a></p>
        </div>

        <div id="register-view" style="display: none;">
            <h2>Registrarse</h2>
            <form id="register-form" action="{{ route('registro.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="register-name">Nombre:</label>
                    <input type="text" name="name" id="register-name" value="{{ old('name') }}" >
                    <small id="error-name" style="color:red; display:none; margin-top:5px;">
                    </small>
                </div>

                <div class="form-group">
                    <label for="register-email">Email:</label>
                    <input type="email" name="email" id="register-email" value="{{ old('email') }}" >
                    <small id="error-email" style="color:red; display:none; margin-top:5px;">
                    </small>
                </div>

                <div class="form-group">
                    <label for="register-password">Contraseña:</label>
                    <input type="password" name="password" id="register-password" >
                    <small id="error-password" style="color:red; display:none; margin-top:5px;">
                    </small>
                </div>

                <div class="form-group">
                    <label for="register-password-confirm">Confirmar Contraseña:</label>
                    <input type="password" name="password_confirmation" id="register-password-confirm" >
                    <small id="error-password_confirmation" style="color:red; display:none; margin-top:5px;"></small>
                </div>
                <button type="submit" class="btn-primary">Crear Cuenta</button>
            </form>
            <p><a href="#" onclick="showLoginView()">¿Ya tienes cuenta? Inicia sesión</a></p>
        </div>
    </div>
</div>
<script>
    // --- FUNCIONES DE INTERFAZ (UI) ---
    function showLoginModal() {
        const modal = document.getElementById('auth-modal');
        if (modal) modal.style.display = 'flex';
    }

    function closeLoginModal() {
        const modal = document.getElementById('auth-modal');
        if (modal) modal.style.display = 'none';
    }

    function showRegisterView() {
        document.getElementById('login-view').style.display = 'none';
        document.getElementById('register-view').style.display = 'block';
    }

    function showLoginView() {
        document.getElementById('register-view').style.display = 'none';
        document.getElementById('login-view').style.display = 'block';
    }

    // Manejo de cierre al hacer click fuera
    window.onclick = function(event) {
        const modal = document.getElementById('auth-modal');
        if (event.target == modal) closeLoginModal();
    }

    document.addEventListener("DOMContentLoaded", function() {
        const button = document.getElementById("auth-btn");

        if (button) {
            // CORRECCIÓN: Pasamos la referencia de la función, NO la ejecutamos con ()
            button.addEventListener("click", showLoginModal);
        }



        document.getElementById('register-form').addEventListener('submit', function(e) {
            let hasErrors = false;

            // Elementos de entrada
            const name = document.getElementById('register-name');
            const email = document.getElementById('register-email');
            const password = document.getElementById('register-password');
            const passwordConfirm = document.getElementById('register-password-confirm');

            // Función para mostrar/ocultar errores
            function setError(id, message) {
                const errorElement = document.getElementById('error-' + id);
                if (message) {
                    errorElement.innerText = message;
                    errorElement.style.display = 'block';
                    hasErrors = true;
                } else {
                    errorElement.style.display = 'none';
                    errorElement.innerText = '';
                }
            }

            // --- LIMPIAR ERRORES ANTERIORES ---
            setError('name', '');
            setError('email', '');
            setError('password', '');
            setError('password_confirmation', '');

            // 1. Validar Nombre
            if (name.value.length > 255) {
                setError('name', "El nombre es demasiado largo (máx 255).");
            }
            if (name.value.length <= 0) {
                setError('name', "El nombre debe estar rellenado");
            }

            // 2. Validar Email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value)) {
                setError('email', "El formato del email no es válido.");
            }

            // 3. Validar Contraseña (Complejidad)
            let passwordError = "";
            if (password.value.length < 8) {
                passwordError = "Mínimo 8 caracteres. ";
            }
            if (!/[A-Z]/.test(password.value) || !/[a-z]/.test(password.value)) {
                passwordError += "Debe incluir mayúsculas y minúsculas. ";
            }
            if (!/[0-9]/.test(password.value)) {
                passwordError += "Debe incluir un número. ";
            }
            if (!/[!@#$%^&*(),.?":{}|<>]/.test(password.value)) {
                passwordError += "Debe incluir un símbolo.";
            }

            if (passwordError) setError('password', passwordError);

            // 4. Validar Confirmación
            if (password.value !== passwordConfirm.value) {
                setError('password_confirmation', "Las contraseñas no coinciden.");
            }
            if (passwordConfirm.value.length <= 0) {
                setError('password_confirmation', "Se debe rellenar el campo contraseña de confirmación");
            }

            // Si hay errores, detener el envío
            if (hasErrors) {
                e.preventDefault();
            }
        });


        // Si Laravel envió errores de sesión, mostrar los campos small correspondientes
        document.querySelectorAll('small[id^="error-"]').forEach(el => {
            if (el.innerText.trim() !== "") {
                el.style.display = 'block';
            }
        });

    });
</script>
