<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlantaRequest;
use App\Models\Planta;
use App\Models\Cliente;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PlantaController extends Controller
{
    public function __construct()
    {
        // Sólo usuarios autenticados pueden acceder
        $this->middleware('auth');
        // Si luego quieres restringir solo a admins:
        // $this->middleware(['auth','role:admin']);
    }

    /**
     * Mostrar el listado de plantas (paginado).
     *
     * @return View
     */
    public function index(): View
    {
        // Antes era ->get(), ahora usamos ->paginate(10):
        $plantas = Planta::with('cliente')
                         ->orderBy('nombre')
                         ->paginate(10);

        return view('plantas.index', compact('plantas'));
    }

    /**
     * Mostrar el formulario para crear una nueva planta.
     *
     * @return View
     */
    public function create(): View
    {
        // Necesitamos la lista de clientes para el <select>
        $clientes = Cliente::orderBy('nombre')->get();
        return view('plantas.create', compact('clientes'));
    }

    /**
     * Almacenar una planta recién creada en la base de datos.
     *
     * @param  PlantaRequest  $request
     * @return RedirectResponse
     */
    public function store(PlantaRequest $request): RedirectResponse
    {
        Planta::create($request->validated());

        return redirect()
            ->route('plantas.index')
            ->with('success', 'Planta creada correctamente');
    }

    /**
     * Mostrar el formulario para editar una planta existente.
     *
     * @param  Planta  $planta
     * @return View
     */
    public function edit(Planta $planta): View
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('plantas.edit', compact('planta', 'clientes'));
    }

    /**
     * Actualizar la planta en la base de datos.
     *
     * @param  PlantaRequest  $request
     * @param  Planta         $planta
     * @return RedirectResponse
     */
    public function update(PlantaRequest $request, Planta $planta): RedirectResponse
    {
        $planta->update($request->validated());

        return redirect()
            ->route('plantas.index')
            ->with('success', 'Planta actualizada correctamente');
    }

    /**
     * Eliminar una planta de la base de datos.
     *
     * @param  Planta  $planta
     * @return RedirectResponse
     */
    public function destroy(Planta $planta): RedirectResponse
    {
        $planta->delete();

        return back()->with('success', 'Planta eliminada');
    }
}
