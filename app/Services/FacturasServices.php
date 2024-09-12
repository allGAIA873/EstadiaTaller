<?php

namespace App\Services;

use App\Models\FacturasModel;

class FacturasServices
{
    public function getFacturas()
    {
        return FacturasModel::all();
    }

    public function getFacturasPaginated($perPage = 10)
    {
        return FacturasModel::paginate($perPage);
    }
    public function showEstadosCuenta(string $id)
    {

        return FacturasModel::findOrFail($id);
    }

    public function updateFactura(array $data, string $id)
    {
        $factura = FacturasModel::findOrFail($id);
        $factura->update($data);
        return $factura;
    }
}
