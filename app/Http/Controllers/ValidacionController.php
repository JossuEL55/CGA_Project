<?php

namespace App\Http\Controllers;

use App\Models\Validacion;
use App\Models\OrdenTecnica;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ValidacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:supervisor'); // Solo supervisores pueden validar
    }

    // Mostrar historial de validaciones (opcional, filtrado por orden)
    public function index(Request $request): View
    {
        $validaciones = Validacion::with(['orden', 'supervisor'])
                            ->orderByDesc('created_at')
                            ->paginate(15);

        return view('validaciones.index', compact('validaciones'));
    }

    // Mostrar formulario para crear una validación para una orden específica
    public function create(int $ordenId): View
    {
        $orden = OrdenTecnica::findOrFail($ordenId);
        return view('validaciones.create', compact('orden'));
    }

    // Guardar validación en BD
    public function store(Request $request): RedirectResponse
    {
           $request->validate([
            'id_orden' => 'required|exists:ordenes_tecnicas,id_orden',
            'estado_validacion' => 'required|string|in:Validada,Rechazada',
            'comentarios' => 'nullable|string|max:2000',
        ]);

        Validacion::create([
            'id_orden' => $request->id_orden,
            'estado_validacion' => $request->estado_validacion,
            'comentarios' => $request->comentarios,
            'id_supervisor' => auth()->user()->id, // O ajusta según relación con técnicos
        ]);

        // Opcional: actualizar estado en orden técnica
        $orden = OrdenTecnica::findOrFail($request->id_orden);
        $orden->estado = $request->estado_validacion === 'Validada' ? 'Validada' : 'Rechazada';
        $orden->supervisor_id = auth()->user()->id; // o id técnico supervisor
        $orden->save();

        return redirect()->route('validaciones.index')->with('success', 'Validación registrada correctamente.');
    }

    // Mostrar detalle de validación
    public function show(Validacion $validacion): View
    {
        $validacion->load(['orden', 'supervisor']);
        return view('validaciones.show', compact('validacion'));
    }
}
