<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\App;

class QuestionRequest extends FormRequest
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
            'user_id' => [
                'integer',
                'required',
                'exists:App\Models\User,id'
            ],
            'talk_id' => [
                'integer',
                'required',
                'exists:App\Models\Talk,id'
            ],
            'question' => [
               'required'
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
            'user_id.required' => __('api.user_id_required'),
            'user_id.integer' => __('api.user_id_integer'),
            'user_id.exists' => __('api.user_id_exists'),
            'talk_id.required' => __('api.talk_id_required'),
            'talk_id.integer' => __('api.talk_id_integer'),
            'talk_id.exists' => __('api.talk_id_exists'),
            'question.required' => __('api.question_required'),
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