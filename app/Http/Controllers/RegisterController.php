<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Tecnico;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegisterController extends Controller
{
    // Mostrar la vista de registro
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    // Procesar datos del formulario de registro
    public function register(RegisterRequest $request): RedirectResponse
    {
        // 1) Crear un nuevo usuario en la tabla 'users'
        $user = User::create([
            'name'     => $request->input('name'),
            'email'    => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'rol'      => $request->input('role'), 
        ]);

        // 2) Si el rol escogido es “tecnico”, creamos un registro en tabla ‘tecnicos’
        if ($request->input('role') === 'tecnico') {
            Tecnico::create([
                'user_id'      => $user->id,
                'nombre'       => $request->input('nombre_tecnico'),
                'cedula'       => $request->input('cedula'),
                'especialidad' => $request->input('especialidad'),
            ]);
        }


        event(new Registered($user));


        auth()->login($user);


        return redirect()->route('dashboard');
    }
}
