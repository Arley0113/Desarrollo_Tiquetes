<?php

namespace App\Services;

use App\Models\Pago;
use App\Models\Reserva;

class PagoService
{
    public function procesarPago($reservaId, $datos)
    {
        $reserva = Reserva::findOrFail($reservaId);

        return Pago::create([
            'id_reserva' => $reserva->id_reserva,
            'nombre_titular' => $datos['nombre_titular'],
            'tipo_documento' => $datos['tipo_documento'],
            'documento' => $datos['documento'],
            'correo' => $datos['correo'],
            'telefono' => $datos['telefono'],
            'medio_pago' => $datos['medio_pago'],
            'monto' => $datos['monto']
        ]);
    }
}
