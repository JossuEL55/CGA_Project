<?php

namespace App\Http\Controllers;

use App\Models\Validacion;
use Illuminate\Http\Request;

class ValidacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_orden' => 'required|exists:ordenes_tecnicas,id_orden',
            'estado_validacion' => 'required|string|max:50',
            'comentarios' => 'nullable|string|max:2000',
        ]);

        Validacion::create([
            'id_orden' => $request->id_orden,
            'estado_validacion' => $request->estado_validacion,
            'comentarios' => $request->comentarios,
            'id_supervisor' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Validación guardada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Validacion $validacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Validacion $validacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Validacion $validacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Validacion $validacion)
    {
        //
    }
}
