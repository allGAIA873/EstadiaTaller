<?php

namespace App\Services;

use App\Models\CuentaBancariaModel;
use Illuminate\Http\Request;
use Exception;

class CuentaBancariaServices
{
    public function getCuentas($clienteId)
    {
        return CuentaBancariaModel::where('cliente_id', $clienteId)->get();
    }

    public function storeCuenta(Request $request, $clienteId)
    {
        $request->validate([
            'banco_id' => 'required',
            'num_cuenta' => 'required',
            'clabe' => 'required|min:18|max:18'
        ]);

        try {
            $cuenta = new CuentaBancariaModel();
            $cuenta->banco_id = $request->input('banco_id');
            $cuenta->num_cuenta = $request->input('num_cuenta');
            $cuenta->clabe = $request->input('clabe');
            $cuenta->cliente_id = $clienteId;
            $cuenta->save();

            return ['success' => true, 'message' => 'Cuenta bancaria agregada exitosamente.'];
        } catch (Exception $e) {
            throw new Exception("Error al guardar la cuenta bancaria: " . $e->getMessage());
        }
    }

    public function storeCuentaGeneralView(Request $request)
    {
        $messages = [
            'num_cuenta.required' => 'El campo número de cuenta es obligatorio',
            'clabe.required' => 'El campo clabe es obligatorio',
            'clable.min' => 'El campo clabe debe tener 18 dígitos',
            'clabe.max' => 'El campo clabe debe tener 18 dígitos',
            'cliente_id' => 'El campo cliente es obligatorio',
            'banco_id.required' => 'El campo banco es obligatorio',
        ];

        $request->validate([
            'banco_id' => 'required',
            'num_cuenta' => 'required',
            'clabe' => 'required|min:18|max:18',
            'cliente_id' => 'required'
        ], $messages);

        try {
            $cuenta = new CuentaBancariaModel();
            $cuenta->banco_id = $request->input('banco_id');
            $cuenta->num_cuenta = $request->input('num_cuenta');
            $cuenta->clabe = $request->input('clabe');
            $cuenta->cliente_id = $request->input('cliente_id');
            $cuenta->save();

            return ['success' => true, 'message' => 'Cuenta bancaria agregada exitosamente.'];
        } catch (Exception $e) {
            throw new Exception("Error al guardar la cuenta bancaria: " . $e->getMessage());
        }
    }

    public function updateCuenta(Request $request, $clienteId, $id)
    {
        $request->validate([
            'banco_id' => 'required',
            'num_cuenta' => 'required',
            'clabe' => 'required|min:18|max:18'
        ]);

        try {
            $cuenta = CuentaBancariaModel::find($id);
            if (!$cuenta || $cuenta->cliente_id != $clienteId) {
                throw new Exception('Cuenta bancaria no encontrada.');
            }

            $cuenta->banco_id = $request->input('banco_id');
            $cuenta->num_cuenta = $request->input('num_cuenta');
            $cuenta->clabe = $request->input('clabe');
            $cuenta->save();

            return ['success' => true, 'message' => 'Cuenta bancaria actualizada exitosamente.'];
        } catch (Exception $e) {
            throw new Exception("Error al actualizar la cuenta bancaria: " . $e->getMessage());
        }
    }

    public function updateCuentaGeneralView(Request $request, $id)
    {
        $request->validate([
            'banco_id' => 'required',
            'num_cuenta' => 'required',
            'clabe' => 'required|min:18|max:18',
            'cliente_id' => 'required'
        ]);

        try {
            $cuenta = CuentaBancariaModel::find($id);
            if (!$cuenta) {
                throw new Exception('Cuenta bancaria no encontrada.');
            }

            $cuenta->banco_id = $request->input('banco_id');
            $cuenta->num_cuenta = $request->input('num_cuenta');
            $cuenta->clabe = $request->input('clabe');
            $cuenta->cliente_id = $request->input('cliente_id');
            $cuenta->save();

            return ['success' => true, 'message' => 'Cuenta bancaria actualizada exitosamente.'];
        } catch (Exception $e) {
            throw new Exception("Error al actualizar la cuenta bancaria: " . $e->getMessage());
        }
    }


    public function deleteCuenta($clienteId, $id)
    {
        try {
            $cuenta = CuentaBancariaModel::find($id);
            if (!$cuenta) {
                throw new Exception('Cuenta bancaria no encontrada.');
            }

            $cuenta->delete();

            return ['success' => true, 'message' => 'Cuenta bancaria eliminada exitosamente.'];
        } catch (Exception $e) {
            throw new Exception("Error al eliminar la cuenta bancaria: " . $e->getMessage());
        }
    }

    public function deleteCuentaGeneralView($id)
    {
        try {
            $cuenta = CuentaBancariaModel::find($id);
            if (!$cuenta) {
                throw new Exception('Cuenta bancaria no encontrada.');
            }

            $cuenta->delete();

            return ['success' => true, 'message' => 'Cuenta bancaria eliminada exitosamente.'];
        } catch (Exception $e) {
            throw new Exception("Error al eliminar la cuenta bancaria: " . $e->getMessage());
        }
    }
}
