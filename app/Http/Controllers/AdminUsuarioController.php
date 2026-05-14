<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Hotel;
use App\Models\Reserva;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::paginate(10);
        return view("admin_usuarios", ['usuarios' => $usuarios]);
    }
    public function actualizar(Request $request, string $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return redirect('admin/users')->with('error', 'Usuario no encontrado');
        }

        // 1. Validamos los campos REALES de la habitación
        $request->validate([
            'name' => 'required|string|min:0|max:255',
            'role'   => 'required|string|min:0|max:20',
            'email'   => 'required|string|min:0|max:255',
        ]);

        // 2. Manejo del checkbox (si no se marca, no llega en el request)
        $datos = $request->all();

        // 3. Actualizamos
        $usuario->update($datos);

        // 4. Redirigimos (Usamos 'updated' para que coincida con el JS que hicimos)
        return redirect('admin/users')->with('updated', 'El usuario ha sido actualizado correctamente.');
    }
    public function crear()
    {
        // Definimos los roles exactos que se ven en tu base de datos
        $roles = ['admin', 'user'];

        return view('admin_usuarios_create', compact('roles'));
    }

    public function editar(string $id)
    {
        // Buscamos al usuario por su ID
        $usuario = User::findOrFail($id);

        // Definimos los roles nuevamente para que el select no de error
        $roles = ['admin', 'user'];

        // Pasamos ambas variables a la vista
        return view('admin_usuarios_create', compact('usuario', 'roles'));
    }

    public function guardar(Request $request)
    {
        // 1. Validación: Añadimos la contraseña como obligatoria
        $request->validate([
            'name'     => 'required|string|max:255',
            'role'     => 'required|string|max:20',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8', // La contraseña debe estar presente
        ]);

        // 2. Crear la instancia
        $usuario = new User();
        $usuario->name     = $request->name;
        $usuario->role     = $request->role;
        $usuario->email    = $request->email;

        // 3. ENCRIPTACIÓN: Usamos Hash::make para que se guarde como ves en phpMyAdmin
        $usuario->password = \Illuminate\Support\Facades\Hash::make($request->password);

        // 4. Guardar
        $usuario->save();

        return redirect()->route('users')->with('success', 'El nuevo usuario se ha creado correctamente.');
    }
    public function borrar(string $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            return redirect('admin/users')->with('error', 'Usuario no encontrado');
        }

        $usuario->delete();

        // 'success' es la llave que buscaremos luego en la vista
        return redirect('admin/users')->with('success', 'el usuario  ha sido eliminado correctamente.');
    }
}
