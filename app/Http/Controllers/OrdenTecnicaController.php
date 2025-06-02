<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdenRequest;
use App\Models\OrdenTecnica;
use App\Models\Cliente;
use App\Models\Planta;
use App\Models\Tecnico;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrdenTecnicaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // index y show → admin|supervisor
        $this->middleware('role:admin|supervisor')->only(['index','show','validar']);
        // crear/almacenar → admin
        $this->middleware('role:admin')->only(['create','store']);
        // editar/actualizar observaciones → técnico
        $this->middleware('role:tecnico')->only(['edit','update']);
        // validar → supervisor
        $this->middleware('role:supervisor')->only(['validar']);
    }

    public function index(): View
{
    $user = auth()->user();

    $query = OrdenTecnica::with(['planta','tecnico','supervisor'])->orderByDesc('created_at');
    
    if ($user->hasRole('tecnico')) {
        $tecnicoId = $user->tecnico ? $user->tecnico->id_tecnico : 0;
        $query->where('id_tecnico', $tecnicoId);
    }

    $ordenes = $query->paginate(10);

    return view('ordenes.index', compact('ordenes'));
}

    public function create(): View
    {
        // Ya no pedimos “clientes”, sino sólo “plantas” (que incluyen cliente)
        $plantas  = Planta::with('cliente')->orderBy('nombre')->get();
        $tecnicos = Tecnico::orderBy('nombre')->get();

        return view('ordenes.create', compact('plantas','tecnicos'));
    }

    public function store(OrdenRequest $request): RedirectResponse
    {
        OrdenTecnica::create($request->validated() + [
            'estado'        => 'Pendiente',
            'observaciones' => null,
            'supervisor_id'=> null,
        ]);

        return redirect()
            ->route('ordenes.index')
            ->with('success', 'Orden creada correctamente');
    }

    public function show(OrdenTecnica $ordenTecnica): View{
    $ordenTecnica->load(['planta.cliente', 'tecnico', 'supervisor', 'validaciones.supervisor']);
    return view('ordenes.show', compact('ordenTecnica'));
}

    public function edit(OrdenTecnica $ordenTecnica): View
    {
        $this->authorize('update', $ordenTecnica);
        $user = auth()->user();
        if ($ordenTecnica->id_tecnico !== $user->id) {
            abort(403);
        }
        return view('ordenes.edit', compact('ordenTecnica'));
    }

    public function update(OrdenRequest $request, OrdenTecnica $ordenTecnica): RedirectResponse
    {
        $ordenTecnica->update([
            'observaciones' => $request->validated()['observaciones'],
        ]);

        return redirect()
            ->route('ordenes.index')
            ->with('success', 'Observaciones guardadas');
    }

    use App\Notifications\OrdenEstadoActualizado;

public function validar(Request $request, OrdenTecnica $orden)
{
    $this->authorize('validar', $orden);

    $request->validate([
        'estado' => 'required|in:Validada,Rechazada',
        'comentarios' => 'nullable|string|max:2000',
    ]);

    $supervisor = auth()->user()->tecnico;

    $orden->estado = $request->estado;
    $orden->supervisor_id = $supervisor ? $supervisor->id_tecnico : null;
    $orden->save();

    $orden->validaciones()->create([
        'id_supervisor' => $orden->supervisor_id,
        'estado_validacion' => $request->estado,
        'comentarios' => $request->comentarios,
    ]);

    // Notificar al técnico responsable
    if ($orden->tecnico && $orden->tecnico->user) {
        $orden->tecnico->user->notify(new OrdenEstadoActualizado($orden));
    }

    return redirect()->route('ordenes.index')->with('success', 'Orden validada y técnico notificado.');


}

}
