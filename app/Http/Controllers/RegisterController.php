<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    //

    public function show()
    {
        /* if (Auth::check()) {
            return redirect()->route('home.index');
        }*/
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:8',             // Mínimo 8 caracteres
                'confirmed',         // Verifica que exista un campo 'password_confirmation' igual
                Password::min(8)     // Reglas de seguridad adicionales:
                    ->mixedCase()    // Al menos una mayúscula y una minúscula
                    ->letters()      // Al menos una letra
                    ->numbers()      // Al menos un número
                    ->symbols(),     // Al menos un símbolo (!@#$%...)
            ],
        ]);

        // 2. Crear el usuario en la base de datos (tabla 'users')
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => UserRole::Admin->value,
            'password' => Hash::make($request->password), // ¡NUNCA guardes la contraseña en texto plano!
        ]);
       
        // 3. Iniciar sesión automáticamente después de registrarse
        Auth::login($user);

        // 4. Redirigir a la página principal o de habitaciones
        return redirect('/login')->with('success', '¡Registro completado con éxito!');
    }

    // --- LÓGICA DE LOGIN ---
    public function login(Request $request)
    {
        // 1. Validar que nos envíen email y password
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // El campo 'remember' viene del checkbox "Recordarme"
        $remember = $request->filled('remember');

        // 2. Intentar autenticar
        if (Auth::attempt($credentials, $remember)) {
            // 3. Si tiene éxito, regenerar la sesión (Medida de seguridad de Laravel 10)
            $request->session()->regenerate();

            return redirect()->intended('/habitacion')->with('success', '¡Has iniciado sesión!');
        }

        // 4. Si falla, volver al formulario con un error
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email'); // Mantiene el email escrito para que el usuario no lo repita
    }

    // --- LÓGICA DE CERRAR SESIÓN ---
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidar la sesión actual y regenerar el token CSRF por seguridad
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Sesión cerrada correctamente.');
    }
}
