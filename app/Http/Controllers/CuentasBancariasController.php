<?php

namespace App\Http\Controllers;

use App\Models\BancosModel;
use App\Models\ClientModel;
use App\Models\CuentaBancariaModel;
use App\Models\EstadosCuentaModel;
use App\Services\CuentaBancariaServices;
use Exception;
use Illuminate\Http\Request;

class CuentasBancariasController extends Controller
{
    protected $CuentaBancariaService;

    public function __construct(CuentaBancariaServices $cuentaBancariaService)
    {
        $this->CuentaBancariaService = $cuentaBancariaService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $cuentas = CuentaBancariaModel::with(['cliente', 'banco'])
            ->when($search, function ($query, $search) {
                return $query->where('num_cuenta', 'like', "%{$search}%")
                    ->orWhere('clabe', 'like', "%{$search}%")
                    ->orWhereHas('cliente', function ($query) use ($search) {
                        $query->where('nombre', 'like', "%{$search}%");
                    })
                    ->orWhereHas('banco', function ($query) use ($search) {
                        $query->where('nombre', 'like', "%{$search}%");
                    });
            })->get();

        $bancos = BancosModel::all();
        $clientes = ClientModel::all();
        $cuentas = CuentaBancariaModel::paginate(10);
        return view('cuentas-bancarias.index', compact('cuentas', 'bancos', 'clientes', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cuentas = CuentaBancariaModel::all();
        $bancos = BancosModel::all();
        $clientes = ClientModel::all();
        return view('cuentas-bancarias.index', compact('cuentas', 'bancos', 'clientes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $clienteId)
    {
        try {
            $result = $this->CuentaBancariaService->storeCuenta($request, $clienteId);
            return redirect()->route('clientes.detalle', ['id' => $clienteId])->with('success', $result['message']);
        } catch (Exception $e) {
            return redirect()->route('clientes.detalle', ['id' => $clienteId])->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function storeGeneralView(Request $request)
    {
        try {
            $result = $this->CuentaBancariaService->storeCuentaGeneralView($request);
            return redirect('/cuentas-bancarias')->with('success', $result['message']);
        } catch (Exception $e) {
            return redirect('/cuentas-bancarias')->withErrors(['error' => $e->getMessage()]);
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
    public function edit($id)
    {
        $cuenta = CuentaBancariaModel::findOrFail($id);
        $bancos = BancosModel::all();
        $clientes = ClientModel::all();
        return view('cuentas-bancarias.edit', compact('cuenta', 'bancos', 'clientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $clienteId, $id)
{
    try {
        $result = $this->CuentaBancariaService->updateCuenta($request, $clienteId, $id);

        // Actualizar el estado de los estados de cuenta relacionados
        $estadosCuenta = EstadosCuentaModel::where('cuenta_id', $id)->get();
        foreach ($estadosCuenta as $estadoCuenta) {
            $estadoCuenta->actualizarEstado();
        }

        return redirect()->route('clientes.detalle', ['id' => $clienteId])->with('success', $result['message']);
    } catch (Exception $e) {
        return redirect()->route('clientes.detalle', ['id' => $clienteId])->withErrors(['error' => $e->getMessage()]);
    }
}

public function updateGeneralView(Request $request, $id)
{
    try {
        $result = $this->CuentaBancariaService->updateCuentaGeneralView($request, $id);

        // Actualizar el estado de los estados de cuenta relacionados
        $estadosCuenta = EstadosCuentaModel::where('cuenta_id', $id)->get();
        foreach ($estadosCuenta as $estadoCuenta) {
            $estadoCuenta->actualizarEstado();
        }

        return redirect('/cuentas-bancarias')->with('success', $result['message']);
    } catch (Exception $e) {
        return redirect('/cuentas-bancarias')->withErrors(['error' => $e->getMessage()]);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($clienteId, $id)
    {
        try {
            $result = $this->CuentaBancariaService->deleteCuenta($clienteId, $id);
            return redirect()->route('clientes.detalle', ['id' => $clienteId])->with('success', $result['message']);
        } catch (Exception $e) {
            return redirect()->route('clientes.detalle', ['id' => $clienteId])->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroyGeneralView($id)
    {
        try {
            $result = $this->CuentaBancariaService->deleteCuentaGeneralView($id);
            return redirect('/cuentas-bancarias')->with('success', $result['message']);
        } catch (Exception $e) {
            return redirect('/cuentas-bancarias')->withErrors(['error' => $e->getMessage()]);
        }
    }
}
