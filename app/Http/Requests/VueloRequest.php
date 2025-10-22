<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VueloRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Solo administradores pueden crear/editar vuelos
        return auth()->check() && auth()->user()->esAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'fecha_vuelo' => 'required|date|after_or_equal:today',
            'hora' => 'required|date_format:H:i',
            'id_origen' => 'required|integer|exists:lugares,id_lugar',
            'id_destino' => 'required|integer|exists:lugares,id_lugar|different:id_origen',
            'id_avion' => 'required|integer|exists:modelo_avion,id_avion',
            'id_precio' => 'required|integer|exists:precios,id_precio'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'fecha_vuelo.required' => 'La fecha del vuelo es obligatoria',
            'fecha_vuelo.after_or_equal' => 'La fecha del vuelo debe ser hoy o posterior',
            'hora.required' => 'La hora del vuelo es obligatoria',
            'hora.date_format' => 'El formato de hora debe ser HH:MM',
            'id_origen.required' => 'El origen es obligatorio',
            'id_origen.exists' => 'El lugar de origen no existe',
            'id_destino.required' => 'El destino es obligatorio',
            'id_destino.exists' => 'El lugar de destino no existe',
            'id_destino.different' => 'El destino debe ser diferente al origen',
            'id_avion.required' => 'Debes seleccionar un avión',
            'id_avion.exists' => 'El avión seleccionado no existe',
            'id_precio.required' => 'Debes seleccionar un precio',
            'id_precio.exists' => 'El precio seleccionado no existe'
        ];
    }
}