<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdenRequest;
use App\Models\OrdenTecnica;
use App\Models\Cliente;
use App\Models\Planta;
use App\Models\Tecnico;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrdenTecnicaController extends Controller
{
    public function __construct()
    {
        // Solo usuarios autenticados pueden acceder a cualquiera de estos métodos
        $this->middleware('auth');
    }

    /**
     * Mostrar listado de órdenes técnicas.
     * - Si el usuario es “técnico”, solo ve sus propias órdenes.
     * - Si no, ve todas.
     */
    public function index(): View
    {
        $user = Auth::user();

        // Cargamos relaciones: planta → cliente, técnico asignado y supervisor
        $query = OrdenTecnica::with(['planta.cliente', 'tecnico', 'supervisor'])
            ->orderByDesc('created_at');

        // Si el usuario tiene rol “tecnico”, filtramos solo sus órdenes
        if ($user->rol === 'tecnico') {
            $tecnicoId = $user->tecnico->id_tecnico ?? 0;
            $query->where('id_tecnico', $tecnicoId);
        }

        // Paginamos (10 por página)
        $ordenes = $query->paginate(10);

        return view('ordenes.index', compact('ordenes'));
    }

    /**
     * Mostrar formulario para crear una nueva orden.
     * Carga listas de clientes, plantas y técnicos.
     */
    public function create(): View
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $plantas  = Planta::with('cliente')->orderBy('nombre')->get();
        $tecnicos = Tecnico::orderBy('nombre')->get();

        return view('ordenes.create', compact('clientes', 'plantas', 'tecnicos'));
    }

    /**
     * Almacenar la nueva orden en la base de datos.
     * Por defecto, le ponemos estado "Pendiente" y supervisor_id = null.
     */
    public function store(OrdenRequest $request): RedirectResponse
    {
        OrdenTecnica::create($request->validated() + [
            'estado'        => 'Pendiente',
            'supervisor_id' => null,
        ]);

        return redirect()
            ->route('ordenes.index')
            ->with('success', 'Orden creada correctamente');
    }
 public function historial(Request $request)
    {
        // Preparamos la consulta base con relaciones
        $query = OrdenTecnica::with(['planta.cliente', 'tecnico', 'supervisor'])
                             ->orderByDesc('created_at');

        // Si viene cliente_id en query string, filtramos
        if ($request->filled('cliente_id')) {
            $clienteId = $request->input('cliente_id');
            $query->whereHas('planta', function($q) use ($clienteId) {
                $q->where('id_cliente', $clienteId);
            });
        }

        // Si viene tecnico_id en query string, filtramos
        if ($request->filled('tecnico_id')) {
            $query->where('id_tecnico', $request->input('tecnico_id'));
        }

        $ordenes = $query->paginate(10);

        // Para los select de filtros
        $clientes = Cliente::orderBy('nombre')->get();
        $tecnicos = Tecnico::orderBy('nombre')->get();

        return view('ordenes.historial', compact('ordenes', 'clientes', 'tecnicos'));
    }

    /**
     * Historial de órdenes de un cliente específico.
     */
    public function historialPorCliente(Cliente $cliente)
    {
        $ordenes = OrdenTecnica::with(['planta.cliente', 'tecnico', 'supervisor'])
            ->whereHas('planta', function($q) use ($cliente) {
                $q->where('id_cliente', $cliente->id_cliente);
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('ordenes.historial_por_cliente', compact('ordenes', 'cliente'));
    }

    /**
     * Historial de órdenes de un técnico específico.
     */
    public function historialPorTecnico(Tecnico $tecnico)
    {
        $ordenes = OrdenTecnica::with(['planta.cliente', 'tecnico', 'supervisor'])
            ->where('id_tecnico', $tecnico->id_tecnico)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('ordenes.historial_por_tecnico', compact('ordenes', 'tecnico'));
    }
    public function show($id): View
    {
        // 1) Buscar la orden en BD por su ID (o lanzar 404 si no existe)
        $orden = OrdenTecnica::with(['planta.cliente', 'tecnico', 'supervisor'])
                             ->findOrFail($id);

        // 2) Retornar la vista 'ordenes.show' pasándole la orden como variable
        return view('ordenes.show', compact('orden'));
    }
    /**
     * Mostrar formulario de validación (solo si Policy 'validar' lo permite).
     */
    public function validarForm(OrdenTecnica $orden): View
    {
      
        $this->authorize('validar', $orden);

        return view('ordenes.validar', compact('orden'));
    }
 public function dashboard(): View
    {
        // Consulta 1: total de órdenes
        $totalOrdenes = OrdenTecnica::count();

        // Consulta 2: conteo agrupado por 'estado'
        // Ajusta los valores de estado a los que realmente uses (Pendiente, En Proceso, Validada, Rechazada, etc.)
        $conteoPorEstado = OrdenTecnica::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->pluck('total', 'estado'); 
            // ->pluck('total','estado') devuelve un array tipo ['Pendiente' => 5, 'Validada' => 12, ...]

        // Para que estén en orden fijo, definimos los estados que usas en tu sistema.
        // Si no están, los ponemos en cero:
        $estados = [
            'Pendiente'    => $conteoPorEstado->get('Pendiente', 0),
            'En Proceso'   => $conteoPorEstado->get('En Proceso', 0),
            'Validada'     => $conteoPorEstado->get('Validada', 0),
            'Rechazada'    => $conteoPorEstado->get('Rechazada', 0),
        ];

        return view('ordenes.dashboard', compact('totalOrdenes','estados'));
    }
    /**
     * Procesar la validación POST (solo si Policy 'validar' lo permite).
     */
    public function validar(Request $request, OrdenTecnica $orden): RedirectResponse
    {
        $this->authorize('validar', $orden);

        $data = $request->validate([
            'estado' => 'required|in:Pendiente,En Proceso,Validada,Rechazada',
        ]);


        $estadoAnterior = $orden->estado;

        
        $orden->estado        = $data['estado'];
        $orden->supervisor_id = Auth::user()->tecnico->id_tecnico; 
        $orden->save();

        $orden->validaciones()->create([
            'id_orden'        => $orden->id_orden,
            'id_tecnico'      => $orden->tecnico->id_tecnico ?? null,
            'id_supervisor'   => Auth::user()->tecnico->id_tecnico,
            'estado_anterior' => $estadoAnterior,
            'estado_nuevo'    => $data['estado'],
            'fecha_validacion'=> now(),
        ]);

        return redirect()
            ->route('ordenes.index')
            ->with('success', "Orden #{$orden->id_orden} actualizada a “{$data['estado']}”.");
    }
}