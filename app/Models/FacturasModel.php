<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FacturasModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'facturas';

    protected $fillable = [
        'cuenta_id',
        'concepto',
        'deposito',
        'retiro',
        'detalle',
        'folio',
        'tipo_factura',
        'complemento_pago'
    ];

    public function cuentasBancarias()
    {
        return $this->belongsTo(CuentaBancariaModel::class, 'cuenta_id');
    }
}
