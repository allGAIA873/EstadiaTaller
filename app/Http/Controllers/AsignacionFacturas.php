<?php

namespace App\Http\Controllers;

use App\Models\FacturasModel;
use App\Models\EstadosCuentaModel;
use App\Services\FacturasServices;
use Illuminate\Http\Request;

class AsignacionFacturas extends Controller
{
    protected $FacturasServices;
    public function __construct(FacturasServices $facturasServices)
    {
        $this->FacturasServices = $facturasServices;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$facturas = FacturasModel::with('cuenta_id');
        $facturas = $this->FacturasServices->getFacturasPaginated(10);
        return view('asignacion-facturas.index', compact('facturas'));
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
        //
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
        $factura = FacturasModel::findOrFail($id);

        // Actualiza la factura
        $factura->update([
            'tipo_factura' => $request->tipo_factura,
            'complemento_pago' => $request->complemento_pago,
        ]);

        // Actualiza el registro correspondiente en estados_cuenta
        $estadoCuenta = EstadosCuentaModel::where('cuenta_id', $factura->cuenta_id)
                                            ->where('folio', $factura->folio)
                                            ->first();

        if ($estadoCuenta) {
            // Determina el estado basado en el tipo de factura y complemento de pago
            if ($factura->tipo_factura === 'PUE' || ($factura->tipo_factura === 'PPD' && !empty($factura->complemento_pago))) {
                $estadoCuenta->estado = 'completo';
            } else {
                $estadoCuenta->estado = 'incompleto';
            }

            // Actualiza el registro de estado de cuenta
            $estadoCuenta->update([
                'complemento_pago' => $request->complemento_pago,
                'estado' => $estadoCuenta->estado,  // Asegúrate de que este campo esté en la tabla
            ]);
        }

        return redirect()->route('asignacion-facturas.index')->with('success', 'Factura y Estado de Cuenta actualizados.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
