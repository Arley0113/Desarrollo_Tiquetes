<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiquete extends Model
{
    use HasFactory;

    protected $table = 'tiquetes';
    protected $primaryKey = 'id_tiquete';
    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'detalle_tiquete',
        'id_reserva',
        'id_vuelo',
        'id_asiento',
        'id_precio',
        'fecha_emision'
    ];

    protected $casts = [
        'fecha_emision' => 'datetime'
    ];

    // Relaciones
    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'id_reserva', 'id_reserva');
    }

    public function vuelo()
    {
        return $this->belongsTo(Vuelo::class, 'id_vuelo', 'id_vuelo');
    }

    public function asiento()
    {
        return $this->belongsTo(Asiento::class, 'id_asiento', 'id_asiento');
    }

    public function precio()
    {
        return $this->belongsTo(Precio::class, 'id_precio', 'id_precio');
    }

    // Métodos helper
    public function getPasajero()
    {
        // Asumiendo que cada tiquete corresponde a un pasajero en orden
        $posicion = $this->reserva->tiquetes()
            ->where('id_tiquete', '<=', $this->id_tiquete)
            ->count();
        
        return $this->reserva->pasajeros()->skip($posicion - 1)->first();
    }

    public function getDetalleCompleto()
    {
        $vuelo = $this->vuelo;
        return [
            'codigo' => $this->codigo,
            'origen' => $vuelo->origen->nombre_lugar,
            'destino' => $vuelo->destino->nombre_lugar,
            'fecha' => $vuelo->fecha_vuelo->format('d/m/Y'),
            'hora' => $vuelo->hora->format('H:i'),
            'asiento' => $this->asiento->numero_asiento,
            'avion' => $vuelo->avion->nombre_avion
        ];
    }
}