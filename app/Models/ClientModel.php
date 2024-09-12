<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'razon_social',
        'rfc',
        'unidad_id',
    ];

    public function cuentasBancarias()
    {
        return $this->hasMany(CuentaBancariaModel::class, 'cliente_id');
    }

    public function unidades()
    {
        return $this->belongsToMany(UnidadNegocioModel::class, 'cliente_unidad', 'cliente_id', 'unidad_id');
    }
}
