<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeightTargetRequest extends FormRequest
{
    /**
     * 認可の判定
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * バリデーションルール
     */
    public function rules()
    {
        return [
            'target_weight' => [
                'required',
                'numeric',
                'regex:/^\d{1,4}(\.\d{1})?$/',  // 4桁以下+小数点1桁
            ],
        ];
    }

    public function messages()
    {
        return [
            'target_weight.required' => '目標の体重を入力してください',
            'target_weight.numeric' => '数字で入力してください',
            'target_weight.regex' => '4桁までの数字で入力してください。小数点は1桁で入力してください',
        ];
    }
}
