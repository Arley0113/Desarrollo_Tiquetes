<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasajeroFormRequest extends FormRequest
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
            'id_vuelo' => 'required|integer|exists:vuelos,id_vuelo',
            'nombre' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'apellido' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'email' => 'required|email|max:100',
            'telefono' => 'required|string|max:20|regex:/^[0-9\+\-\s\(\)]+$/',
            'fecha_nacimiento' => 'required|date|before:today',
            'genero' => 'required|in:masculino,femenino,otro'
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
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.regex' => 'El nombre solo debe contener letras y espacios',
            'nombre.max' => 'El nombre no puede exceder 100 caracteres',
            'apellido.required' => 'El apellido es obligatorio',
            'apellido.regex' => 'El apellido solo debe contener letras y espacios',
            'apellido.max' => 'El apellido no puede exceder 100 caracteres',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Debe ser un correo electrónico válido',
            'telefono.required' => 'El teléfono es obligatorio',
            'telefono.regex' => 'El teléfono debe contener solo números, espacios, paréntesis, + y -',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
            'fecha_nacimiento.date' => 'Debe ser una fecha válida',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy',
            'genero.required' => 'Debes seleccionar un género',
            'genero.in' => 'El género seleccionado no es válido'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Limpiar espacios en blanco
        $this->merge([
            'nombre' => trim($this->nombre),
            'apellido' => trim($this->apellido),
            'email' => trim(strtolower($this->email)),
            'telefono' => trim($this->telefono)
        ]);
    }
}
