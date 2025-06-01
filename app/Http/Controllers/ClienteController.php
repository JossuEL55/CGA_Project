<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // → Cuando configures roles, reemplaza por ['auth','role:admin']
    }

    /**
     * Mostrar listado de clientes.
     */
   public function index(): View
{
    $clientes = Cliente::orderBy('nombre')->paginate(10); // Cambiado get() por paginate()
    return view('clientes.index', compact('clientes'));
}


    /**
     * Mostrar formulario para crear un nuevo cliente.
     */
    public function create(): View
    {
        return view('clientes.create');
    }

    /**
     * Almacenar un cliente nuevo en la base de datos.
     */
    public function store(ClienteRequest $request): RedirectResponse
    {
        // Aquí ClienteRequest validará los campos según su rules()
        Cliente::create($request->validated());

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente creado correctamente');
    }

    public function edit(Cliente $cliente): View
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(ClienteRequest $request, Cliente $cliente): RedirectResponse
    {
        $cliente->update($request->validated());
        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente');
    }

    public function destroy(Cliente $cliente): RedirectResponse
    {
        $cliente->delete();
        return back()->with('success', 'Cliente eliminado');
    }
}
