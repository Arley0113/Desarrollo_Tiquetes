<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuscarVueloRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cualquiera puede buscar vuelos
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id_origen' => 'required|integer|exists:lugares,id_lugar',
            'id_destino' => 'required|integer|exists:lugares,id_lugar|different:id_origen',
            'fecha_vuelo' => 'required|date|after_or_equal:today',
            'tipo_viaje' => 'required|in:ida,ida_vuelta',
            'fecha_regreso' => 'nullable|required_if:tipo_viaje,ida_vuelta|date|after:fecha_vuelo',
            'cantidad_pasajeros' => 'required|integer|min:1|max:9'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'id_origen.required' => 'Debes seleccionar un lugar de origen',
            'id_origen.exists' => 'El lugar de origen no existe',
            'id_destino.required' => 'Debes seleccionar un lugar de destino',
            'id_destino.exists' => 'El lugar de destino no existe',
            'id_destino.different' => 'El destino debe ser diferente al origen',
            'fecha_vuelo.required' => 'Debes seleccionar una fecha de vuelo',
            'fecha_vuelo.after_or_equal' => 'La fecha de vuelo debe ser hoy o posterior',
            'tipo_viaje.required' => 'Debes seleccionar el tipo de viaje',
            'tipo_viaje.in' => 'El tipo de viaje debe ser ida o ida y vuelta',
            'fecha_regreso.required_if' => 'Debes seleccionar una fecha de regreso',
            'fecha_regreso.after' => 'La fecha de regreso debe ser posterior a la fecha de ida',
            'cantidad_pasajeros.required' => 'Debes indicar la cantidad de pasajeros',
            'cantidad_pasajeros.min' => 'Debe haber al menos 1 pasajero',
            'cantidad_pasajeros.max' => 'Máximo 9 pasajeros por reserva'
        ];
    }
}