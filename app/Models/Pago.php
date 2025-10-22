<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';
    protected $primaryKey = 'id_pago';
    public $timestamps = false;

    protected $fillable = [
        'id_reserva',
        'nombre_titular',
        'tipo_documento',
        'documento',
        'correo',
        'telefono',
        'medio_pago',
        'monto',
        'fecha_pago'
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_pago' => 'datetime'
    ];

    // Relaciones
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'id_reserva', 'id_reserva');
    }

    // Métodos helper
    public function esExitoso()
    {
        return $this->monto > 0;
    }

    public function formatearMonto()
    {
        return '$' . number_format($this->monto, 2, ',', '.');
    }
}