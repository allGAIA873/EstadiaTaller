<?php

namespace App\Services;

use App\Models\ClientModel;
use Exception;
use Illuminate\Http\Request;

class ClientServices
{
    public function getClients()
    {
        return ClientModel::all();
    }

    public function storeClient(Request $request)
    {
        $messages = [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'razon_social.required' => 'El campo razón social es obligatorio.',
            'rfc.required' => 'El campo rfc es obligatorio.',
            'rfc.min' => 'El campo RFC debe tener al menos 12 caracteres.',
            'rfc.max' => 'El campo RFC no debe exceder los 13 caracteres.',
            'unidad_id.required' => 'El campo unidad de negocio es obligatorio'
        ];

        $request->validate([
            'nombre' => 'required|string|max:255',
            'razon_social' => 'required|string|max:255',
            'rfc' => 'required|string|min:12|max:13',
            'unidad_id' => 'required|array',
            'unidad_id.*' => 'exists:unidad_negocio,id',
        ], $messages);

        try {
            $client = new ClientModel();
            $client->fill($request->only(['nombre', 'razon_social', 'rfc']));
            $client->save();

            $client->unidades()->sync($request->input('unidad_id'));

        } catch (Exception $e) {
            throw new Exception("Error al guardar el cliente: " . $e->getMessage());
        }
    }

    public function showClient(string $id)
    {
        return ClientModel::with('cuentasBancarias', 'unidades')->findOrFail($id);
    }

    public function updateClient(Request $request, string $id)
    {
        $messages = [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'razon_social.required' => 'El campo razón social es obligatorio.',
            'rfc.required' => 'El campo rfc es obligatorio.',
            'rfc.min' => 'El campo RFC debe tener al menos 12 caracteres.',
            'rfc.max' => 'El campo RFC no debe exceder los 13 caracteres.',
            'unidad_id.required' => 'El campo unidad de negocio es obligatorio'
        ];

        $request->validate([
            'nombre' => 'required|string|max:255',
            'razon_social' => 'required|string|max:255',
            'rfc' => 'required|string|min:12|max:13',
            'unidad_id' => 'required|array',
            'unidad_id.*' => 'exists:unidad_negocio,id',
        ], $messages);

        try {
            $client = ClientModel::find($id);
            $client->fill($request->only(['nombre', 'razon_social', 'rfc']));
            $client->save();

            $client->unidades()->sync($request->input('unidad_id'));

        } catch (Exception $e) {
            throw new Exception("Error al actualizar cliente: " . $e->getMessage());
        }
    }


    public function deleteClient(string $id)
    {
        try {
            $client = ClientModel::find($id);
            $client->delete();
        } catch (Exception $e) {
            throw new Exception("Error al eliminar cliente" . $e->getMessage());
        }
    }
}
