<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagoRequest extends FormRequest
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
        $rules = [
            'id_reserva' => 'required|integer|exists:reservas,id_reserva',
            'nombre_titular' => 'required|string|max:100|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            'tipo_documento' => 'required|in:CC,CE,TI,Pasaporte',
            'documento' => 'required|string|max:30|regex:/^[0-9A-Za-z]+$/',
            'correo' => 'required|email|max:100',
            'telefono' => 'required|string|max:20|regex:/^[0-9\+\-\s]+$/',
            'medio_pago' => 'required|in:Tarjeta de crédito,Tarjeta débito,PSE',
            'monto' => 'required|numeric|min:0.01'
        ];

        // Validaciones adicionales según el medio de pago
        if ($this->medio_pago === 'Tarjeta de crédito' || $this->medio_pago === 'Tarjeta débito') {
            $rules['numero_tarjeta'] = 'required|string|size:16|regex:/^[0-9]+$/';
            $rules['fecha_expiracion'] = 'required|string|regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/';
            $rules['cvv'] = 'required|string|size:3|regex:/^[0-9]+$/';
        }

        if ($this->medio_pago === 'PSE') {
            $rules['banco'] = 'required|string';
            $rules['tipo_persona'] = 'required|in:Natural,Juridica';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nombre_titular.required' => 'El nombre del titular es obligatorio',
            'nombre_titular.regex' => 'El nombre solo debe contener letras',
            'tipo_documento.required' => 'El tipo de documento es obligatorio',
            'tipo_documento.in' => 'Tipo de documento inválido',
            'documento.required' => 'El número de documento es obligatorio',
            'correo.required' => 'El correo electrónico es obligatorio',
            'correo.email' => 'Ingresa un correo electrónico válido',
            'telefono.required' => 'El teléfono es obligatorio',
            'telefono.regex' => 'El teléfono debe contener solo números',
            'medio_pago.required' => 'Selecciona un medio de pago',
            'medio_pago.in' => 'Medio de pago inválido',
            'monto.required' => 'El monto es obligatorio',
            'monto.min' => 'El monto debe ser mayor a 0',
            
            // Tarjetas
            'numero_tarjeta.required' => 'El número de tarjeta es obligatorio',
            'numero_tarjeta.size' => 'El número de tarjeta debe tener 16 dígitos',
            'numero_tarjeta.regex' => 'El número de tarjeta solo debe contener números',
            'fecha_expiracion.required' => 'La fecha de expiración es obligatoria',
            'fecha_expiracion.regex' => 'La fecha debe estar en formato MM/AA',
            'cvv.required' => 'El CVV es obligatorio',
            'cvv.size' => 'El CVV debe tener 3 dígitos',
            
            // PSE
            'banco.required' => 'Debes seleccionar un banco',
            'tipo_persona.required' => 'Debes seleccionar el tipo de persona'
        ];
    }

    /**
     * Validaciones adicionales personalizadas
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validar que la fecha de expiración no esté vencida
            if ($this->fecha_expiracion) {
                $fecha = explode('/', $this->fecha_expiracion);
                if (count($fecha) === 2) {
                    $mes = (int)$fecha[0];
                    $año = (int)('20' . $fecha[1]);
                    $fechaExpiracion = mktime(0, 0, 0, $mes, 1, $año);
                    $hoy = time();
                    
                    if ($fechaExpiracion < $hoy) {
                        $validator->errors()->add('fecha_expiracion', 'La tarjeta está vencida');
                    }
                }
            }
        });
    }
}