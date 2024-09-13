<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\App;

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
                'required',
                'email'
            ],
            'password' => [
               'required'
            ],
            'fcm_token' => [
               'required'
            ],
            'device_type' => [
               'required',
               Rule::in(['android', 'ios'])
            ],
            'lang' => [
               'required',
               Rule::in(['en', 'es'])
            ]
        ];

    }

    /**
     * Set the language before validation.
     */
    protected function prepareForValidation()
    {
        // Configura el idioma del sistema basado en el valor de `lang` del request
        if ($this->has('lang') && ($this->input('lang') === 'es' || $this->input('lang') === 'en'))
            App::setLocale($this->input('lang'));
        else
            App::setLocale('es');
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => __('auth.email_required'),
            'email.email' => __('auth.invalid_email_format'),
            'password.required' => __('auth.password_required'),
            'fcm_token.required' => __('auth.fcm_token_required'),
            'device_type.required' => __('auth.device_type_required'),
            'device_type.in' => __('auth.device_type_invalid'),
            'lang.required' => __('auth.lang_required'),
            'lang.in' => __('auth.lang_invalid')
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