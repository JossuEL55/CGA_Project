<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdenRequest;
use App\Models\OrdenTecnica;
use App\Models\Cliente;
use App\Models\Planta;
use App\Models\Tecnico;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class OrdenTecnicaController extends Controller
{
    public function __construct()
    {
        // Solo autenticados pueden llegar a CUALQUIER método:
        $this->middleware('auth');
    }

    /**
     * Mostrar listado de órdenes.
     * CUALQUIER usuario autenticado las puede ver (Admin, Supervisor, Técnicos, etc.).
     */
    public function index(): View
    {
        $user = Auth::user();
        $query = OrdenTecnica::with(['planta.cliente','tecnico','supervisor'])
                    ->orderByDesc('created_at');

        // Si el user es técnico, solo mostramos sus órdenes
        if ($user->rol==='tecnico') {
            // NOTA: aquí suponemos que en la tabla "ordenes_tecnicas" hay
            // un campo id_tecnico que apunta a id_tecnico en tu tabla tecnicos,
            // y que a su vez $user->tecnico->id_tecnico está bien configurado.
            $tecnicoId = $user->tecnico->id_tecnico ?? 0;
            $query->where('id_tecnico', $tecnicoId);
        }

        $ordenes = $query->paginate(10);

        return view('ordenes.index', compact('ordenes'));
    }

    /**
     * Mostrar detalles de una orden.
     * CUALQUIER usuario autenticado puede verla si está en su propia lista (index).
     * No hacemos validación de policy aquí; quien ya no la vea, sencillamente
     * no encontrará ese enlace en la vista index si no le toca.
     */
    public function show(OrdenTecnica $orden): View
    {
        // Aún si quisieras, NO cobramos $this->authorize('view',$orden);
        // porque te interesa solo la validación (no bloqueamos show).
        $orden->load(['planta.cliente','tecnico','supervisor','validaciones']);
        return view('ordenes.show', compact('orden'));
    }

    /**
     * Mostrar formulario de creación de orden.
     * CUALQUIERA autenticado puede entrar a create si quieres.
     * (Si en tu lógica quieres restringir quién puede crearlas,
     *  aquí iría $this->authorize('create',Orden::class), pero omitimos.)
     */
    public function create(): View
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $plantas  = Planta::with('cliente')->orderBy('nombre')->get();
        $tecnicos = Tecnico::orderBy('nombre')->get();
        return view('ordenes.create', compact('clientes','plantas','tecnicos'));
    }

    /**
     * Almacenar la orden nueva.
     * CUALQUIERA autenticado puede hacerlo (o podrías limitar a admin/supervisor
     * si deseas, agregando $this->authorize('create',OrdenTecnica::class) aquí).
     */
    public function store(OrdenRequest $request): RedirectResponse
    {
        OrdenTecnica::create($request->validated() + [
            'estado'        => 'Pendiente',
            'supervisor_id' => null,
            // 'id_tecnico' vendrá del form si el usuario la asigna
        ]);

        return redirect()
            ->route('ordenes.index')
            ->with('success','Orden creada correctamente');
    }

    /**
     * Mostrar formulario para editar (solo observaciones del técnico).
     * CUALQUIERA autenticado puede editar si ya es el técnico asignado:
     * pero como tu pregunta va SOLO a "validar", no lo bloqueamos aquí.
     */
    public function edit(OrdenTecnica $orden): View
    {
        // Si quisieras bloquear edición a solo quien toque:
        // $this->authorize('update',$orden);
        return view('ordenes.edit', compact('orden'));
    }

    public function update(OrdenRequest $request, OrdenTecnica $orden): RedirectResponse
    {
        // $this->authorize('update',$orden);  // opcional
        $orden->update([
            'observaciones' => $request->validated()['observaciones'],
        ]);

        return redirect()
            ->route('ordenes.index')
            ->with('success','Observaciones actualizadas');
    }

    /**
     * Mostrar formulario para asignar técnico.
     * CUALQUIERA autenticado puede entrar (o bloqueas con authorize('update')).
     */
    public function asignarTecnicoForm(OrdenTecnica $orden): View
    {
        $tecnicos = Tecnico::orderBy('nombre')->get();
        return view('ordenes.asignar', compact('orden','tecnicos'));
    }

    public function asignarTecnico(Request $request, OrdenTecnica $orden): RedirectResponse
    {
        $request->validate([
            'id_tecnico' => 'required|exists:tecnicos,id_tecnico'
        ]);

        $orden->update(['id_tecnico' => $request->id_tecnico]);

        return redirect()
            ->route('ordenes.index')
            ->with('success','Técnico asignado correctamente');
    }

    /**
     * Mostrar formulario de validación (solo supervisor).
     */
    public function validarForm(OrdenTecnica $orden): View
    {
        // *** Aquí invocamos la policy validar() ***
        $this->authorize('validar', $orden);

        return view('ordenes.validar', compact('orden'));
    }

    /**
     * Procesar la validación POST (solo supervisor).
     */
    public function validar(Request $request, OrdenTecnica $orden): RedirectResponse
    {
        $this->authorize('validar', $orden);

        $data = $request->validate([
            'estado'        => 'required|in:Pendiente,En Proceso,Validada,Rechazada',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        $estadoAnterior       = $orden->estado;
        $orden->estado        = $data['estado'];
        // Suponemos que $user->rol==='supervisor' y tiene relación con tecnico
        $orden->supervisor_id = Auth::user()->tecnico->id_tecnico; 
        $orden->save();

        // Crear registro en validaciones
        $orden->validaciones()->create([
            'id_orden'        => $orden->id_orden,
            'id_tecnico'      => $orden->tecnico->id_tecnico ?? null,
            'id_supervisor'   => Auth::user()->tecnico->id_tecnico,
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo'    => $data['estado'],
            'fecha_validacion'=> now(),
        ]);

        // Notificar si quieres
        if($orden->tecnico && $orden->tecnico->user){
            $orden->tecnico->user
                  ->notify(new \App\Notifications\OrdenEstadoActualizado($orden));
        }

        return redirect()
            ->route('ordenes.index')
            ->with('success',"Orden #{$orden->id_orden} actualizada a “{$data['estado']}”.");
    }

    /**
     * Eliminar orden (si lo necesitas).
     */
    public function destroy(OrdenTecnica $orden): RedirectResponse
    {
        // Podrías bloquear con authorize('delete',$orden)
        $orden->delete();
        return back()->with('success','Orden eliminada');
    }
}
