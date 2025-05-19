<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterStepTwoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'current_weight' => [
                'required',
                'numeric',
                'regex:/^\d{1,4}(\.\d{0,1})?$/',
            ],
            'target_weight' => [
                'required',
                'numeric',
                'regex:/^\d{1,4}(\.\d{0,1})?$/',
            ],
        ];
    }

    public function messages()
    {
        return [
            'current_weight.required' => '現在の体重を入力してください',
            'current_weight.numeric' => '数値を入力してください',
            'current_weight.regex' => '4桁までの数字で、小数点は1桁で入力してください',

            'target_weight.required' => '目標の体重を入力してください',
            'target_weight.numeric' => '数値を入力してください',
            'target_weight.regex' => '4桁までの数字で、小数点は1桁で入力してください',
        ];
    }
}
