<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vuelo extends Model
{
    use HasFactory;

    protected $table = 'vuelos';
    protected $primaryKey = 'id_vuelo';
    public $timestamps = false;

    protected $fillable = [
        'fecha_vuelo',
        'hora',
        'hora_llegada',
        'duracion',
        'directo',
        'wifi',
        'reembolsable',
        'codigo_vuelo',
        'id_origen',
        'id_destino',
        'id_avion',
        'id_precio'
    ];

    protected $casts = [
        'fecha_vuelo' => 'date',
        'hora' => 'datetime:H:i',
        'hora_llegada' => 'datetime:H:i',
        'directo' => 'boolean',
        'wifi' => 'boolean',
        'reembolsable' => 'boolean'
    ];

    // Relaciones
    public function origen()
    {
        return $this->belongsTo(Lugar::class, 'id_origen', 'id_lugar');
    }

    public function destino()
    {
        return $this->belongsTo(Lugar::class, 'id_destino', 'id_lugar');
    }

    public function avion()
    {
        return $this->belongsTo(ModeloAvion::class, 'id_avion', 'id_avion');
    }

    public function precio()
    {
        return $this->belongsTo(Precio::class, 'id_precio', 'id_precio');
    }

    public function tiquetes()
    {
        return $this->hasMany(Tiquete::class, 'id_vuelo', 'id_vuelo');
    }

    // Métodos helper
    public function asientosDisponibles()
    {
        if (!$this->avion) {
            return 0;
        }
        
        $capacidad = $this->avion->capacidad ?? 0;
        $ocupados = $this->tiquetes()->count();
        return max(0, $capacidad - $ocupados);
    }

    public function estaDisponible()
    {
        return $this->asientosDisponibles() > 0;
    }

    public function getAsientosLibres()
    {
        $asientosOcupados = $this->tiquetes()->pluck('id_asiento')->toArray();
        
        return Asiento::where('id_avion', $this->id_avion)
            ->whereNotIn('id_asiento', $asientosOcupados)
            ->get();
    }
}