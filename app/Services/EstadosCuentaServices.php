<?php

namespace App\Services;

use App\Exports\EstadosCuentaExport;
use App\Imports\EstadosCuentaImport;
use App\Models\EstadosCuentaModel;
use Illuminate\Http\Request;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class EstadosCuentaServices
{
    public function getEstadosCuenta()
    {
        return EstadosCuentaModel::all();
    }

    public function getEstadosCuentaPaginated($perPage = 10)
    {
        return EstadosCuentaModel::with('cuentasBancarias.banco')
                             ->orderByRaw("FIELD(estado, 'incompleto', 'completo')")
                             ->paginate($perPage);
    }

    public function storeEstadosCuenta(Request $request)
    {
        $file = $request->file('document_csv');

        if (!$file || !$file->isValid()) {
            throw new Exception('Archivo no válido o no proporcionado.');
        }

        try {
            Excel::import(new EstadosCuentaImport, $file);
        } catch (Exception $e) {
            throw new Exception('Error al procesar el archivo: ' . $e->getMessage());
        }
    }

    public function updateEstadosCuenta($id)
{
    $estadoCuenta = EstadosCuentaModel::findOrFail($id);

    // Accede a la cuenta bancaria asociada
    $cuentaBancaria = $estadoCuenta->cuentasBancarias;

    // Verifica si hay un número de cuenta o CLABE presente
    if ($cuentaBancaria && ($cuentaBancaria->num_cuenta || $cuentaBancaria->clabe)) {
        $estadoCuenta->estado = 'completo';
    } else {
        $estadoCuenta->estado = 'incompleto';
    }

    $estadoCuenta->save();
}


    public function exportEstadosCuenta()
    {
        $date = now()->format('d-m-Y');
        $fileName = 'estados-cuenta-' . $date . '.csv';
        return Excel::download(new EstadosCuentaExport, $fileName, \Maatwebsite\Excel\Excel::CSV);
    }
    public function showEstadosCuenta(string $id)
    {
        return EstadosCuentaModel::with('cuentasBancarias.cliente.unidades')->findOrFail($id);
    }
}
