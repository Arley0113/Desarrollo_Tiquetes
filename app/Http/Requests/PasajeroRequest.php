<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasajeroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nombre_pasajero' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'documento' => 'required|string|max:30|regex:/^[0-9]+$/',
            'es_acompanante' => 'boolean'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nombre_pasajero.required' => 'El nombre completo del pasajero es obligatorio',
            'nombre_pasajero.regex' => 'El nombre solo debe contener letras y espacios',
            'nombre_pasajero.max' => 'El nombre no puede exceder 100 caracteres',
            'documento.required' => 'El número de documento es obligatorio',
            'documento.regex' => 'El documento solo debe contener números',
            'documento.max' => 'El documento no puede exceder 30 caracteres'
        ];
    }
}