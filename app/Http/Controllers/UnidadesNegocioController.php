<?php

namespace App\Http\Controllers;

use App\Models\UnidadNegocioModel;
use App\Services\UnidadesNegocioServices;
use Exception;

use Illuminate\Http\Request;

class UnidadesNegocioController extends Controller
{
    protected $UnidadesNegocioServices;
    public function __construct(UnidadesNegocioServices $UnidadesNegocioServices) {
        $this->UnidadesNegocioServices = $UnidadesNegocioServices;
    }
    public function index()
    {
        $udn = UnidadNegocioModel::all();
        $count = $udn->count();
        return view('unidades_negocio.index', compact('udn', 'count'));
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
        try {
            $this->UnidadesNegocioServices->storeUnidadesNegocio($request);
            return redirect()->route('unidades_negocio.index')->with('success', 'Unidad de negocio creada exitosamente.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $this->UnidadesNegocioServices->updateUnidadesNegocio($request, $id);
            return redirect()->route('unidades_negocio.index')->with('success', 'Unidad de negocio actualizada exitosamente.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->UnidadesNegocioServices->deleteUnidadesNegocio($id);
            return redirect()->route('unidades_negocio.index')->with('success', 'Unidad de negocio eliminada exitosamente.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
