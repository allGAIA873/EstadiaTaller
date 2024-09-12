<?php

namespace App\Models;

use App\Models\CuentaBancariaModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BancosModel extends Model
{
    use HasFactory;

    protected $table = 'bancos';
    protected $fillable = [
        'clave',
        'nombre',
    ];

    public function cuentaBancaria()
    {
        return $this->hasMany(CuentaBancariaModel::class, 'banco_id');
    }

    public function cuentaBancarias()
    {
        return $this->hasMany(CuentaBancariaModel::class, 'banco_id');
    }


}
