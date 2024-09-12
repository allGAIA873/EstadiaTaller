<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UsuariosServices;
use Exception;
use Illuminate\Http\Request;
use App\Models\UnidadNegocioModel;

class UsuariosController extends Controller
{
    protected $UsuariosServices;
    public function __construct(UsuariosServices $usuariosServices) {
        $this->UsuariosServices = $usuariosServices;
    }

    public function index(Request $request)
    {
        $unidades = UnidadNegocioModel::all();
        $search = $request->input('search');
        $usuarios = $this->UsuariosServices->getUsuariosPaginated(5);

        if ($search) {
            $usuarios = User::where('nombre', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('udn', 'LIKE', "%$search%")
                ->paginate(5);
        }

        return view('usuarios.index', compact('usuarios', 'search','unidades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->UsuariosServices->storeUsuarios($request);
            return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $this->UsuariosServices->updateUsuarios($request, $id);
            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function destroy(string $id)
    {
        try {
            $this->UsuariosServices->deleteUsuarios($id);
            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
