<?php

namespace App\Http\Controllers;

use App\Models\BancosModel;
use App\Models\CuentaBancariaModel;
use App\Models\EstadosCuentaModel;
use Illuminate\Support\Facades\DB;
use App\Models\UnidadNegocioModel;
use App\Services\EstadosCuentaServices;
use Exception;
use Illuminate\Http\Request;

class EstadosCuentaController extends Controller
{
    protected $estadosCuentaServices;
    public function __construct(EstadosCuentaServices $estadosCuentaServices)
    {
        $this->estadosCuentaServices = $estadosCuentaServices;
    }

    /**
     * Display a listing of the resource.
     */


     public function index($perPage = 10)
     {
         try {
             $bancos = BancosModel::all();
             $estadosCuenta = $this->estadosCuentaServices->getEstadosCuentaPaginated($perPage);

             // Actualiza el estado de cuenta basado en la existencia del número de cuenta o CLABE
             foreach ($estadosCuenta as $estadoCuenta) {
                 $this->estadosCuentaServices->updateEstadosCuenta($estadoCuenta->id);
             }

             return view('estados-cuenta.index', compact('estadosCuenta', 'bancos'));
         } catch (Exception $e) {
             return response()->json(['error' => $e->getMessage()], 500);
         }
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('estados-cuenta.import');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->estadosCuentaServices->storeEstadosCuenta($request);
            return redirect()->route('estados-cuenta.index')->with('success', 'Estado de cuenta importado');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Hubo un problema al cargar el CSV: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $estadosCuenta = $this->estadosCuentaServices->showEstadosCuenta($id);

    if (!$estadosCuenta) {
        return redirect()->route('estados-cuenta.index')->with('error', 'Estado de cuenta no encontrado');
    }

    $cuentasBancarias = $estadosCuenta->cuentasBancarias;
    $cliente = $cuentasBancarias ? $cuentasBancarias->cliente : null;
    $unidadesAsociadas = $cliente ? $cliente->unidades->pluck('id')->toArray() : [];
    $todasUnidades = UnidadNegocioModel::all();

    return view('estados-cuenta.movimientos', compact('estadosCuenta', 'todasUnidades', 'unidadesAsociadas'));
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
        //
    }

    public function updateEstado(CuentaBancariaModel $cuentaBancariaModel)
{
    try {
        $cuentaBancaria = $cuentaBancariaModel->cuentasBancarias;

        // Verifica si la cuenta bancaria tiene número de cuenta, CLABE o banco asociado
        if ($cuentaBancaria && ($cuentaBancaria->num_cuenta || $cuentaBancaria->clabe) && $cuentaBancaria->banco_id) {
            // Aquí estamos verificando que el campo banco_id esté presente y sea válido
            $cuentaBancariaModel->estado = 'completo';
        } else {
            $cuentaBancariaModel->estado = 'incompleto';
        }

        $cuentaBancariaModel->save();

        return response()->json(['success' => true]);
    } catch (Exception $e) {
        return redirect()->back()->with('error', 'Hubo un problema al actualizar el estado de la cuenta bancaria: ' . $e->getMessage());
    }
}




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function export()
    {
        try {
            return $this->estadosCuentaServices->exportEstadosCuenta();
        } catch (Exception $e) {
            // Redirige a la página anterior con un mensaje de error
            return redirect()->back()->with('error', 'Hubo un problema al exportar el CSV: ' . $e->getMessage());
        }
    }
}
