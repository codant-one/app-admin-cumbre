<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required'
            ],
            'password' => [
               'required'
            ],
            'fcm_token' => [
               'required'
            ],
            'device_type' => [
               'required'
            ],
            'lang' => [
               'required'
            ]
        ];

    }

    public function messages()
    {
        return [
            'email.required' => 'El correo electrónico es requerido.',
            'password.required' => 'La contraseña es requerida.',
            'fcm_token.required' => 'El token de firebase es requerido.',
            'device_type.required' => 'El tipo de dispositivo es requerido.',
            'lang.required' => 'El idioma es requerido.'
        ];
    }

    /**
    * Get the error messages for the defined validation rules.*
    * @return array
    */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'params_validation_failed',
            'errors' => $validator->errors()
        ], 400));
    }
}