<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asiento extends Model
{
    use HasFactory;

    protected $table = 'asientos';
    protected $primaryKey = 'id_asiento';
    public $timestamps = false;

    protected $fillable = [
        'numero_asiento',
        'fila',
        'columna',
        'tipo_asiento',
        'estado',
        'id_avion'
    ];

    protected $casts = [
        'fila' => 'integer',
    ];

    /**
     * Relación con ModeloAvion
     */
    public function avion()
    {
        return $this->belongsTo(ModeloAvion::class, 'id_avion', 'id_avion');
    }

    /**
     * Relación con Pasajeros
     */
    public function pasajeros()
    {
        return $this->hasMany(Pasajero::class, 'id_asiento', 'id_asiento');
    }

    /**
     * Relación con Tiquetes
     */
    public function tiquetes()
    {
        return $this->hasMany(Tiquete::class, 'id_asiento', 'id_asiento');
    }

    /**
     * Obtener el número completo del asiento (ej: 1A, 12F)
     */
    public function getNumeroCompletoAttribute()
    {
        return $this->fila . $this->columna;
    }

    /**
     * Verificar si el asiento está disponible
     */
    public function estaDisponible()
    {
        return $this->estado === 'disponible';
    }

    /**
     * Verificar disponibilidad para un vuelo específico
     */
    public function estaDisponibleParaVuelo($idVuelo)
    {
        if ($this->estado !== 'disponible') {
            return false;
        }

        // Verificar si ya está asignado en tiquetes para este vuelo
        return !Tiquete::where('id_asiento', $this->id_asiento)
            ->where('id_vuelo', $idVuelo)
            ->exists();
    }

    /**
     * Marcar asiento como ocupado
     */
    public function ocupar()
    {
        $this->estado = 'ocupado';
        $this->save();
    }

    /**
     * Liberar asiento
     */
    public function liberar()
    {
        $this->estado = 'disponible';
        $this->save();
    }

    /**
     * Obtener precio adicional según tipo de asiento
     */
    public function getPrecioAdicionalAttribute()
    {
        return match($this->tipo_asiento) {
            'extra' => 25000,
            'emergencia' => 15000,
            default => 0,
        };
    }

    /**
     * Scope para asientos disponibles
     */
    public function scopeDisponibles($query)
    {
        return $query->where('estado', 'disponible');
    }

    /**
     * Scope para asientos ocupados
     */
    public function scopeOcupados($query)
    {
        return $query->where('estado', 'ocupado');
    }

    /**
     * Scope para filtrar por avión
     */
    public function scopePorAvion($query, $idAvion)
    {
        return $query->where('id_avion', $idAvion);
    }

    /**
     * Scope para ordenar por fila y columna
     */
    public function scopeOrdenados($query)
    {
        return $query->orderBy('fila')->orderBy('columna');
    }
}