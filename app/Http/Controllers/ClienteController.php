<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function __construct()
    {
        // Sólo usuarios con rol 'admin' pueden acceder a cualquiera de estos métodos
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        // Obtener todos los clientes ordenados alfabéticamente
        $clientes = Cliente::orderBy('nombre')->get();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(ClienteRequest $request)
    {
        // $request->validated() contiene sólo lo que pasó validación
        Cliente::create($request->validated());
        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente creado correctamente');
    }

    public function show(Cliente $cliente)
    {
        // Opcional: si más adelante necesitas ver detalle individual
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(ClienteRequest $request, Cliente $cliente)
    {
        $cliente->update($request->validated());
        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente actualizado correctamente');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return back()->with('success', 'Cliente eliminado');
    }
}
