<?php

namespace App\Http\Controllers;

use App\Models\BancosModel;
use App\Models\ClientModel;
use App\Models\EstadosCuentaModel;
use App\Models\UnidadNegocioModel;
use App\Services\ClientServices;
use Exception;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    protected $ClientServices;
    public function __construct(ClientServices $clientServices)
    {
        $this->ClientServices = $clientServices;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $resquest)
    {
        $unidades = UnidadNegocioModel::all();
        $search = $resquest['search'] ?? "";
        if ($search != "") {
            $listClients = ClientModel::where('nombre', 'LIKE', "%$search%")
                ->orWhere('razon_social', 'LIKE', "%$search%")
                ->orWhere('rfc', 'LIKE', "%$search%")
                ->orWhere->orWhereHas('unidad', function ($query) use ($search) {
                    $query->where('area', 'LIKE', "%$search%");
                })->get();
        } else {
            $listClients = ClientModel::with('unidades')->paginate(10);
        }
        $data = compact('listClients', 'search');
        return view('clientes.index', compact('listClients', 'unidades'))->with($data);
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
            $this->ClientServices->storeClient($request);
            return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bancos = BancosModel::all();
        $unidades = UnidadNegocioModel::all();
        $client = $this->ClientServices->showClient($id);

        return view('clientes.detalle', compact('client', 'bancos', 'unidades'));
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
        $this->ClientServices->updateClient($request, $id);

        // Actualizar el estado de los estados de cuenta relacionados con el cliente
        $estadosCuenta = EstadosCuentaModel::where('cliente_id', $id)->get();
        foreach ($estadosCuenta as $estadoCuenta) {
            $estadoCuenta->actualizarEstado();
        }

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente.');
    } catch (Exception $e) {
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}


public function updateSecondary(Request $request, string $id)
{
    try {
        $this->ClientServices->updateClient($request, $id);

        // Actualizar el estado de los estados de cuenta relacionados
        $estadosCuenta = EstadosCuentaModel::where('cliente_id', $id)->get();
        foreach ($estadosCuenta as $estadoCuenta) {
            $estadoCuenta->actualizarEstado();
        }

        return redirect('/clientes/' . $id . '/detalle')->with('success', 'Cliente actualizado exitosamente.');
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
            $this->ClientServices->deleteClient($id);
            return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente.');
        } catch (Exception $e) {
            return back()->withErrors(['errors' => $e->getMessage()]);
        }
    }

    public function destroySecondary(string $id)
    {
        try {
            $this->ClientServices->deleteClient($id);
            return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente.');
        } catch (Exception $e) {
            return back()->withErrors(['errors' => $e->getMessage()]);
        }
    }
}
