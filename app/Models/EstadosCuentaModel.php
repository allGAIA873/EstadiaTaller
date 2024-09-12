<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadosCuentaModel extends Model
{
    use HasFactory;

    protected $table = 'estados_cuenta';

    protected $fillable = [
        'estado',
        'banco_id',
        'cuenta_id',
        'fecha_emision',
        'descripcion_detallada',
        'concepto',
        'deposito',
        'retiro',
        'folio',
        'complemento_pago',
    ];

    public function cuentasBancarias()
    {
        return $this->belongsTo(CuentaBancariaModel::class, 'cuenta_id');
    }

    public function banco()
    {
        return $this->belongsTo(BancosModel::class, 'banco_id');
    }

    public function unidades()
{
    return $this->cuentasBancarias->cliente->unidades ?? collect();
}

    public function actualizarEstado()
    {
        $esCompleto = true;

        if (!$this->banco_id || !$this->cuenta_id) {
            $esCompleto = false;
        }

        $this->estado = $esCompleto ? 'completo' : 'incompleto';
        $this->save();
    }
}
