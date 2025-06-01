<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdenRequest;
use App\Models\OrdenTecnica;
use App\Models\Cliente;
use App\Models\Planta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrdenTecnicaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // index y show para admin y supervisor
        $this->middleware('role:admin|supervisor')->only(['index', 'show', 'validar']);

        // crear/almacenar orden → solo admin
        $this->middleware('role:admin')->only(['create', 'store']);

        // editar/actualizar observaciones → solo técnico
        $this->middleware('role:tecnico')->only(['edit', 'update']);

        // validar → solo supervisor
        $this->middleware('role:supervisor')->only(['validar']);
    }

    /**
     * Mostrar listado de órdenes según el rol del usuario.
     *
     * @return View
     */
    public function index(): View
    {
        $user = auth()->user();

        if ($user->hasRole('tecnico')) {
            // Un técnico solo ve sus propias órdenes
            $ordenes = OrdenTecnica::where('tecnico_id', $user->id)
                ->orderByDesc('created_at')
                ->get();
        } elseif ($user->hasRole('supervisor')) {
            // Supervisor ve todas las órdenes
            $ordenes = OrdenTecnica::orderByDesc('created_at')->get();
        } else {
            // Admin ve todas las órdenes
            $ordenes = OrdenTecnica::orderByDesc('created_at')->get();
        }

        return view('ordenes.index', compact('ordenes'));
    }

    /**
     * Mostrar formulario para crear una nueva orden (solo admin).
     *
     * @return View
     */
    public function create(): View
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $tecnicos = User::role('tecnico')->get();

        return view('ordenes.create', compact('clientes', 'tecnicos'));
    }

    /**
     * Almacenar la nueva orden en la base (solo admin).
     *
     * @param  OrdenRequest  $request
     * @return RedirectResponse
     */
    public function store(OrdenRequest $request): RedirectResponse
    {
        OrdenTecnica::create($request->validated() + [
            'estado'        => 'pendiente',
            'supervisor_id' => null,
        ]);

        return redirect()
            ->route('ordenes.index')
            ->with('success', 'Orden creada correctamente');
    }

    /**
     * Mostrar detalles de una orden (admin y supervisor).
     *
     * @param  OrdenTecnica  $ordenTecnica
     * @return View
     */
    public function show(OrdenTecnica $ordenTecnica): View
    {
        return view('ordenes.show', compact('ordenTecnica'));
    }

    /**
     * Mostrar formulario para que el técnico edite sus observaciones.
     *
     * @param  OrdenTecnica  $ordenTecnica
     * @return View
     */
    public function edit(OrdenTecnica $ordenTecnica): View
    {
        $user = auth()->user();
        if ($ordenTecnica->tecnico_id !== $user->id) {
            abort(403);
        }

        return view('ordenes.edit', compact('ordenTecnica'));
    }

    /**
     * Actualizar únicamente las observaciones de la orden (rol técnico).
     *
     * @param  OrdenRequest   $request
     * @param  OrdenTecnica   $ordenTecnica
     * @return RedirectResponse
     */
    public function update(OrdenRequest $request, OrdenTecnica $ordenTecnica): RedirectResponse
    {
        $ordenTecnica->update([
            'observaciones' => $request->observaciones,
        ]);

        return redirect()
            ->route('ordenes.index')
            ->with('success', 'Observaciones guardadas');
    }

    /**
     * Validar o rechazar la orden (rol supervisor).
     *
     * @param  Request        $request
     * @param  OrdenTecnica   $ordenTecnica
     * @return RedirectResponse
     */
    public function validar(Request $request, OrdenTecnica $ordenTecnica): RedirectResponse
    {
        $request->validate([
            'estado' => 'required|in:aprobada,rechazada',
        ]);

        $ordenTecnica->estado        = $request->estado;
        $ordenTecnica->supervisor_id = auth()->id();
        $ordenTecnica->save();

        return redirect()
            ->route('ordenes.index')
            ->with('success', 'Orden actualizada correctamente');
    }

    // Nota: omitimos destroy y métodos de “destroy” si no son necesarios.
}
