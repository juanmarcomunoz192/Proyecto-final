<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  // Aquí recibiremos si requerimos 'admin' o 'user'
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Verificamos si hay sesión (aunque el middleware 'auth' suele ir primero)
        if (!Auth::check()) {
            return redirect('/');
        }

        // 2. Verificamos si el rol del usuario coincide con el que exige la ruta
        if (Auth::user()->role !== $role) {
            return redirect('/')->with('error', 'No tienes permisos.');
        }

        // 3. Si todo está bien, dejamos que la petición continúe
        return $next($request);
    }
}