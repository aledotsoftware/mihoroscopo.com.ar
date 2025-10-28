<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function showLogin()
    {
        return view('admin.login');
    }

    // Manejar el login del administrador
    public function login(Request $request)
    {
        // Obtener la clave maestra del archivo .env
        $adminPassword = env('ADMIN_PASSWORD');

        // Verificar si la clave ingresada es correcta
        if ($request->input('password') === $adminPassword) {
            // Guardar en la sesión que el usuario es administrador
            $request->session()->put('is_admin', true);
            return redirect()->route('admin.dashboard');
        }

        // Si la clave es incorrecta, redirigir con un mensaje de error
        return redirect()->route('admin.login')->with('error', 'Clave incorrecta.');
    }

    // Mostrar el panel de administración si está autenticado
    public function dashboard(Request $request)
    {
        if (!$request->session()->has('is_admin')) {
            return redirect()->route('admin.login');
        }

        return view('admin.dashboard');
    }

    // Manejar el logout del administrador
    public function logout(Request $request)
    {
        $request->session()->forget('is_admin');
        return redirect()->route('admin.login');
    }
}
