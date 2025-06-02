<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

use App\Models\User;
use App\Models\Tecnico;
use App\Models\Cliente;
use App\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Mostrar formulario de registro.
     */
    public function create(): View
    {
        $roles = Role::all(); // Cargar roles desde la base de datos
        return view('auth.register', compact('roles'));
    }

    /**
     * Registrar nuevo usuario según su rol.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
                'unique:tecnicos,email',
                'unique:clientes,email'
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,tecnico,supervisor'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        // Guardar en tabla correspondiente
        switch ($request->role) {
            case 'admin':
                $user = User::create($data);
                break;
            case 'tecnico':
                $user = Tecnico::create($data);
                break;
            case 'supervisor':
                $user = Cliente::create($data);
                break;
            default:
                abort(400, 'Rol no válido');
        }

        // Asignar rol usando Spatie
        $user->assignRole($request->role);

        // Solo loguear si es admin (modelo User)
        if ($request->role === 'admin') {
            event(new Registered($user));
            Auth::login($user);
        }

        return redirect()->route('dashboard');
    }
}
