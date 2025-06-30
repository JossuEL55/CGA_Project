<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdenRequest;
use App\Services\OrdenTecnicaService;
use App\Models\{Cliente, Planta, Tecnico, OrdenTecnica};
use Illuminate\Http\{RedirectResponse, Request};
use Illuminate\View\View;

class OrdenTecnicaController extends Controller
{
    public function __construct(
        protected OrdenTecnicaService $service
    ){
        $this->middleware('auth');
    }

    public function index(): View
    {
        $ordenes = $this->service->listForUser(10);
        return view('ordenes.index', compact('ordenes'));
    }

    public function create(): View
    {
        return view('ordenes.create', [
            'clientes' => Cliente::orderBy('nombre')->get(),
            'plantas'  => Planta::with('cliente')->orderBy('nombre')->get(),
            'tecnicos' => Tecnico::orderBy('nombre')->get(),
        ]);
    }

    public function store(OrdenRequest $request): RedirectResponse
    {
        $this->service->create($request->validated());
        return redirect()->route('ordenes.index')
                         ->with('success','Orden creada correctamente');
    }

    public function show(int $id): View
    {
        $orden = $this->service->get($id);
        return view('ordenes.show', compact('orden'));
    }

    public function edit(int $id): View
    {
        $orden = $this->service->get($id);
        return view('ordenes.edit', [
            'orden'    => $orden,
            'clientes' => Cliente::orderBy('nombre')->get(),
            'plantas'  => Planta::with('cliente')->orderBy('nombre')->get(),
            'tecnicos' => Tecnico::orderBy('nombre')->get(),
        ]);
    }

    public function update(OrdenRequest $request, OrdenTecnica $orden): RedirectResponse
    {
        $this->service->update($orden, $request->validated());
        return redirect()->route('ordenes.index')
                         ->with('success','Orden actualizada correctamente');
    }

    public function validarForm(OrdenTecnica $orden): View
    {
        $this->authorize('validar',$orden);
        return view('ordenes.validar', compact('orden'));
    }

    public function validar(Request $request, OrdenTecnica $orden): RedirectResponse
    {
        $this->authorize('validar',$orden);
        $data = $request->validate([
            'estado' => 'required|in:Pendiente,En Proceso,Validada,Rechazada',
        ]);
        $this->service->validarOrden($orden, $data['estado']);
        return redirect()->route('ordenes.index')
                         ->with('success',"Orden #{$orden->id_orden} actualizada a “{$data['estado']}”.");
    }
}
