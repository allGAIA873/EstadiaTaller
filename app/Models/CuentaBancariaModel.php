<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuentaBancariaModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cuentas_bancarias';

    protected $fillable = [
        'cliente_id',
        'banco_id',
        'num_cuenta',
        'clabe',
    ];

    public function cliente()
    {
        return $this->belongsTo(ClientModel::class, 'cliente_id');
    }

    public function banco()
    {
        return $this->belongsTo(BancosModel::class, 'banco_id');
    }

    public function factura()
    {
        return $this->hasMany(FacturasModel::class, 'cuenta_id');
    }

    public function estadosCuenta()
    {
        return $this->hasMany(EstadosCuentaModel::class, 'cuenta_id');
    }
}
