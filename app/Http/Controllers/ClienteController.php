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
        // Por ahora solo autenticación; cuando configures roles, reemplaza por ['auth','role:admin']
        $this->middleware('auth');
    }

    /**
     * Mostrar el listado de clientes.
     *
     * @return View
     */
    public function index(): View
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Mostrar el formulario para crear un cliente nuevo.
     *
     * @return View
     */
    public function create(): View
    {
        return view('clientes.create');
    }

    /**
     * Almacenar un cliente recién creado en la base.
     *
     * @param  ClienteRequest  $request
     * @return RedirectResponse
     */
    public function store(ClienteRequest $request): RedirectResponse
    {
        Cliente::create($request->validated());

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente creado correctamente');
    }

    /**
     * Mostrar los detalles de un cliente en particular.
     *
     * @param  Cliente  $cliente
     * @return View
     */
    public function show(Cliente $cliente): View
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Mostrar el formulario para editar un cliente existente.
     *
     * @param  Cliente  $cliente
     * @return View
     */
    public function edit(Cliente $cliente): View
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualizar el cliente en la base de datos.
     *
     * @param  ClienteRequest  $request
     * @param  Cliente         $cliente
     * @return RedirectResponse
     */
    public function update(ClienteRequest $request, Cliente $cliente): RedirectResponse
    {
        $cliente->update($request->validated());

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente');
    }

    /**
     * Eliminar un cliente de la base de datos.
     *
     * @param  Cliente  $cliente
     * @return RedirectResponse
     */
    public function destroy(Cliente $cliente): RedirectResponse
    {
        $cliente->delete();

        return back()->with('success', 'Cliente eliminado');
    }
}
