<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTecnicoRequest;
use App\Http\Requests\UpdateTecnicoRequest;
use App\Models\Tecnico;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TecnicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $tecnicos = Tecnico::paginate(10);
        return response()->view('admin.tecnicos.index', compact('tecnicos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return response()->view('admin.tecnicos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTecnicoRequest $request): RedirectResponse
    {
        Tecnico::create($request->validated());

        return redirect()
            ->route('admin.tecnicos.index')
            ->with('success', 'Técnico creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tecnico $tecnico): Response
    {
        return response()->view('admin.tecnicos.show', compact('tecnico'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tecnico $tecnico): Response
    {
        return response()->view('admin.tecnicos.edit', compact('tecnico'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTecnicoRequest $request, Tecnico $tecnico): RedirectResponse
    {
        $tecnico->update($request->validated());

        return redirect()
            ->route('admin.tecnicos.index')
            ->with('success', 'Técnico actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tecnico $tecnico): RedirectResponse
    {
        $tecnico->delete();

        return redirect()
            ->route('admin.tecnicos.index')
            ->with('success', 'Técnico eliminado correctamente');
    }
}
