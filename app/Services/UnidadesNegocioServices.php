<?php

namespace App\Services;

use App\Models\UnidadNegocioModel;
use Illuminate\Http\Request;

class UnidadesNegocioServices
{
    public function getUnidadesNegocio()
    {
        return UnidadNegocioModel::all();
    }

    public function storeUnidadesNegocio(Request $request)
    {
        $request->validate([
            'area' => 'required',
            ]);

        $udn = new UnidadNegocioModel();
        $udn->area = $request->input('area');

        $udn->save();
    }

    public function updateUnidadesNegocio(Request $request, $id)
    {
        $request->validate([
            'area' => 'required',
            ]);

        $udn_ = UnidadNegocioModel::find($id);
        $udn_->area = $request->input('area');

        $udn_->save();

    }

    public function deleteUnidadesNegocio(string $id)
    {
        $udn = UnidadNegocioModel::findOrFail($id);

        $udn->delete();
    }
}
