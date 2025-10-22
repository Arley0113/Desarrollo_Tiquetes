<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check(); // Solo usuarios autenticados
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id_vuelo' => 'required|integer|exists:vuelos,id_vuelo',
            'id_vuelo_regreso' => 'nullable|integer|exists:vuelos,id_vuelo',
            'tipo_viaje' => 'required|in:ida,ida_vuelta',
            
            // Validación de pasajeros (array)
            'pasajeros' => 'required|array|min:1',
            'pasajeros.*.nombre_pasajero' => 'required|string|max:100',
            'pasajeros.*.documento' => 'required|string|max:30',
            'pasajeros.*.es_acompanante' => 'boolean',
            
            // Validación de asientos
            'asientos' => 'required|array|min:1',
            'asientos.*' => 'required|integer|exists:asientos,id_asiento',
            
            'asientos_regreso' => 'nullable|array',
            'asientos_regreso.*' => 'nullable|integer|exists:asientos,id_asiento'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'id_vuelo.required' => 'Debes seleccionar un vuelo',
            'id_vuelo.exists' => 'El vuelo seleccionado no existe',
            'pasajeros.required' => 'Debes agregar al menos un pasajero',
            'pasajeros.*.nombre_pasajero.required' => 'El nombre del pasajero es obligatorio',
            'pasajeros.*.documento.required' => 'El documento del pasajero es obligatorio',
            'asientos.required' => 'Debes seleccionar los asientos',
            'asientos.*.exists' => 'Uno o más asientos no existen'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Asegurar que pasajeros sea un array
        if ($this->pasajeros && is_string($this->pasajeros)) {
            $this->merge([
                'pasajeros' => json_decode($this->pasajeros, true)
            ]);
        }
    }
}