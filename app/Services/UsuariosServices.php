<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UsuariosServices
{
    public function getUsuarios()
    {
        return User::all();
    }

    public function getUsuariosPaginated($perPage = 5)
    {
        return User::paginate($perPage);
    }

    public function storeUsuarios(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->whereNull('deleted_at')],
            'udn' => 'required',
            'password' => ['required', 'confirmed', 'min:5', 'max:20']
        ], [
            'email.unique' => 'Este correo ya se encuentra en uso.',
            'udn.required' => 'El campo unidad de negocio es obligatorio'
        ]);

        $usuarios = new User();
        $usuarios->nombre = $request->input('nombre');
        $usuarios->email = $request->input('email');
        $usuarios->udn = $request->input('udn');
        $usuarios->email_verified_at = date('Y-m-d H:i:s');
        $usuarios->password = Hash::make($request->input('password'));

        $usuarios->save();
    }

    public function updateUsuarios(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)->whereNull('deleted_at')],
            'udn'=> 'required',
            'password' => ['nullable', 'confirmed', 'min:5', 'max:20']
        ], [
             'email.unique' => 'Este correo ya se encuentra en uso.',
             'udn.required' => 'El campo unidad de negocio es obligatorio'
        ]);

        $usuario = User::find($id);
        $usuario->nombre = $request->input('nombre');
        $usuario->email = $request->input('email');
        $usuario->udn = $request->input('udn');

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->input('password'));
        }

        $usuario->save();

    }

    public function deleteUsuarios(string $id)
    {
        $usuarios = User::findOrFail($id);

        $usuarios->delete();
    }
}
