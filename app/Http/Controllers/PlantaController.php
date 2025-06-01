<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlantaRequest;
use App\Models\Planta;
use App\Models\Cliente;
use Illuminate\Http\Request;

class PlantaController extends Controller
{
    public function __construct()
    {
        // Sólo admin puede gestionar Plantas
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        // traemos las plantas junto con su cliente (eager loading)
        $plantas = Planta::with('cliente')->orderBy('nombre')->get();
        return view('plantas.index', compact('plantas'));
    }

    public function create()
    {
        // necesitamos lista de clientes para asignar a la planta
        $clientes = Cliente::orderBy('nombre')->get();
        return view('plantas.create', compact('clientes'));
    }

    public function store(PlantaRequest $request)
    {
        Planta::create($request->validated());
        return redirect()->route('plantas.index')
                         ->with('success', 'Planta creada correctamente');
    }

    public function show(Planta $planta)
    {
        return view('plantas.show', compact('planta'));
    }

    public function edit(Planta $planta)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('plantas.edit', compact('planta','clientes'));
    }

    public function update(PlantaRequest $request, Planta $planta)
    {
        $planta->update($request->validated());
        return redirect()->route('plantas.index')
                         ->with('success', 'Planta actualizada correctamente');
    }

    public function destroy(Planta $planta)
    {
        $planta->delete();
        return back()->with('success', 'Planta eliminada');
    }
}
