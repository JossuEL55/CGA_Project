<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTecnicoRequest;
use App\Http\Requests\UpdateTecnicoRequest;
use App\Models\Tecnico;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TecnicoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:admin']);
    }

    public function index(): View
    {
        $tecnicos = Tecnico::orderBy('nombre')->paginate(10);
        return view('tecnicos.index', compact('tecnicos'));
    }

    public function create(): View
    {
        return view('tecnicos.create');
    }

    public function store(StoreTecnicoRequest $request): RedirectResponse
    {
        Tecnico::create($request->validated());
        return redirect()
            ->route('tecnicos.index')
            ->with('success', 'Técnico creado correctamente');
    }

 
    public function edit(Tecnico $tecnico): View
    {
        return view('tecnicos.edit', compact('tecnico'));
    }

    public function update(UpdateTecnicoRequest $request, Tecnico $tecnico): RedirectResponse
    {
        $tecnico->update($request->validated());
        return redirect()
            ->route('tecnicos.index')
            ->with('success', 'Técnico actualizado correctamente');
    }

    public function destroy(Tecnico $tecnico): RedirectResponse
    {
        $tecnico->delete();
        return redirect()
            ->route('tecnicos.index')
            ->with('success', 'Técnico eliminado correctamente');
    }
}
