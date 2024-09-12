<?php

namespace App\Exports;

use App\Models\EstadosCuentaModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EstadosCuentaExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return EstadosCuentaModel::select([
            'estado',
            'banco_id',
            'cuenta_id',
            'fecha_emision',
            'descripcion_detallada',
            'concepto',
            'deposito',
            'retiro',
            'folio',
            'complemento_pago'
        ])->get();
    }

    public function headings(): array
    {
        return [
            'estado',
            'banco',
            'num_cuenta',
            'fecha_emision',
            'descripcion_detallada',
            'concepto',
            'deposito',
            'retiro',
            'folio',
            'complemento_pago'
        ];
    }
}