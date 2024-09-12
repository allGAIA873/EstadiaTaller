<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadNegocioModel extends Model
{
    use HasFactory;
    protected $table = 'unidad_negocio';

    protected $fillable = [
        'area',
    ];

    public function clientes()
    {
        return $this->belongsToMany(ClientModel::class, 'cliente_unidad', 'unidad_id', 'cliente_id');
    }

    public function usuarios()
    {
        return $this->hasMany(User::class, 'udn');
    }

    public function estadosCuenta()
    {
        return $this->belongsToMany(EstadosCuentaModel::class, 'cliente_unidad', 'unidad_id', 'estado_cuenta_id');
    }
}
