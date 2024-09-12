<?php

namespace App\Imports;

use App\Models\BancosModel;
use App\Models\ClientModel;
use App\Models\CuentaBancariaModel;
use App\Models\EstadosCuentaModel;
use App\Models\FacturasModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class EstadosCuentaImport implements ToCollection, WithHeadingRow, WithCustomCsvSettings
{
    public function collection(Collection $collection)
    {
        $patternBanco = '/BCO:\s*([0-9]+)/';
        $patternCuenta = '/(?:CLABE:\s*|CLABE\s*|CUENTA:\s*|CTA\/CLABE:\s*)\s*([0-9]+)/i';
        $patternRFCnoSpace = '/RFC:?\s([A-Z0-9]*)/';
        $patternRFCspace = '/RFC:\s*([A-Z0-9]+)\s*([A-Z0-9]*)/i';
        $patternCliente = '/CLIENTE\s([\w\s]+)/';

        foreach ($collection as $row) {
            $fecha = $row['fecha'] ?? null;
            $concepto = $row['descripcion'] ?? null;
            $descripcionDetallada = $row['descripcion_detallada'] ?? null;
            $deposito = $row['depositos'] ?? null;
            $retiro = $row['retiros'] ?? null;
            $folio = $row['movimiento'] ?? null;
            $complemento_pago = $row['comp_pago'] ?? null;
            $cliente = $row['razon_social'] ?? null;
            $rfc = $row['rfc'] ?? null;

            $banco = null;
            $num_cuenta = null;

            if ($descripcionDetallada && preg_match($patternBanco, $descripcionDetallada, $matchesBanco)) {
                $banco = trim($matchesBanco[1] ?? null);
            }

            if ($descripcionDetallada && preg_match($patternCuenta, $descripcionDetallada, $matchesCuenta)) {
                $num_cuenta = trim($matchesCuenta[1] ?? null);
            }

            if ($descripcionDetallada && preg_match($patternRFCspace, $descripcionDetallada, $matchesRFC)) {
                $rfc = trim($matchesRFC[1] . trim($matchesRFC[2]));
            } elseif ($descripcionDetallada && preg_match($patternRFCnoSpace, $descripcionDetallada, $matchesRFC)) {
                $rfc = trim($matchesRFC[1]);
            }

            if ($descripcionDetallada && preg_match($patternCliente, $descripcionDetallada, $matchesCliente)) {
                $cliente = trim($matchesCliente[1] ?? null);
            }

            $bancoModel = BancosModel::where('clave', $banco)->first();
            $bancoId = $bancoModel ? $bancoModel->id : null;

            $clienteModel = ClientModel::firstOrCreate(
                [
                    'razon_social' => $cliente,
                    'rfc' => $rfc,
                ]
            );
            $clienteID = $clienteModel->id;

            $cuentaModel = CuentaBancariaModel::firstOrCreate(
                [
                    'num_cuenta' => $num_cuenta,
                    'cliente_id' => $clienteID,
                    'banco_id' => $bancoId,
                ]
            );
            $cuentaID = $cuentaModel->id;

            $estado = 'incompleto';

            if ($bancoId && $num_cuenta && ($retiro || ($deposito && $complemento_pago)) && $clienteID) {
                $estado = 'completo';
            }

            $tipo_factura = null;
            if ($deposito) {
                $tipo_factura = $complemento_pago ? 'PPD' : 'PUE';
            }

            $estadoCuenta = EstadosCuentaModel::updateOrCreate(
                [
                    'estado' => $estado,
                    'cuenta_id' => $cuentaID,
                    'fecha_emision' => $fecha,
                    'folio' => $folio,
                ],
                [
                    'descripcion_detallada' => $descripcionDetallada,
                    'concepto' => $concepto,
                    'deposito' => $deposito,
                    'retiro' => $retiro,
                    'complemento_pago' => $complemento_pago,
                ]
            );

            FacturasModel::updateOrCreate(
                [
                    'cuenta_id' => $cuentaID,
                    'concepto' => $concepto,
                    'folio' => $folio,
                ],
                [
                    'deposito' => $deposito,
                    'retiro' => $retiro,
                    'detalle' => $descripcionDetallada,
                    'tipo_factura' => $tipo_factura,
                    'complemento_pago' => $complemento_pago,
                ]
            );
        }
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ',',
            'enclosure' => '"',
            'escape' => '\\',
        ];
    }
}
