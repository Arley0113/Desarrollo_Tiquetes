<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $userId = $this->route('id_usuario'); // Para edición
        
        return [
            'primer_apellido' => 'required|string|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'segundo_apellido' => 'nullable|string|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'nombres' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'fecha_nacimiento' => 'required|date|before:today|after:1900-01-01',
            'genero' => 'required|in:M,F,Otro',
            'tipo_documento' => 'required|in:CC,CE,TI,Pasaporte',
            'documento' => [
                'required',
                'string',
                'max:30',
                'regex:/^[0-9A-Za-z]+$/',
                Rule::unique('usuarios', 'documento')->ignore($userId, 'id_usuario')
            ],
            'condicion_infante' => 'nullable|boolean',
            'celular' => 'required|string|max:20|regex:/^[0-9\+\-\s]+$/',
            'correo' => [
                'required',
                'email',
                'max:100',
                Rule::unique('usuarios', 'correo')->ignore($userId, 'id_usuario')
            ],
            'password' => $userId ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
            'id_rol' => 'nullable|integer|exists:rol,id_rol',
            'estado_usuario' => 'nullable|in:Activo,Inactivo'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'primer_apellido.required' => 'El primer apellido es obligatorio',
            'primer_apellido.regex' => 'El primer apellido solo debe contener letras',
            'segundo_apellido.regex' => 'El segundo apellido solo debe contener letras',
            'nombres.required' => 'Los nombres son obligatorios',
            'nombres.regex' => 'Los nombres solo deben contener letras',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy',
            'fecha_nacimiento.after' => 'Ingresa una fecha de nacimiento válida',
            'genero.required' => 'El género es obligatorio',
            'genero.in' => 'Selecciona un género válido',
            'tipo_documento.required' => 'El tipo de documento es obligatorio',
            'tipo_documento.in' => 'Tipo de documento inválido',
            'documento.required' => 'El número de documento es obligatorio',
            'documento.unique' => 'Este documento ya está registrado',
            'documento.regex' => 'El documento contiene caracteres inválidos',
            'celular.required' => 'El número de celular es obligatorio',
            'celular.regex' => 'El celular debe contener solo números',
            'correo.required' => 'El correo electrónico es obligatorio',
            'correo.email' => 'Ingresa un correo electrónico válido',
            'correo.unique' => 'Este correo ya está registrado',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'id_rol.exists' => 'El rol seleccionado no existe',
            'estado_usuario.in' => 'Estado de usuario inválido'
        ];
    }

    /**
     * Validaciones adicionales personalizadas
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validar edad para condición de infante
            if ($this->fecha_nacimiento && $this->condicion_infante) {
                $edad = now()->diffInYears($this->fecha_nacimiento);
                if ($edad > 12) {
                    $validator->errors()->add('condicion_infante', 'Solo menores de 12 años pueden ser infantes');
                }
            }
        });
    }
}