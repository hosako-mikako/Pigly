<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWeightLogRequest extends FormRequest
{
    /**
     * 認可の判定
     */
    public function authorize()
    {
        return auth()->check() && $this->weightLog->user_id === auth()->id();
    }

    /**
     * バリデーションルール
     */
    public function rules()
    {
        return [
            'date' => 'required|date',
            'weight' => [
                'required',
                'numeric',
                'regex:/^\d{1,4}(\.\d{1})?$/',  // StoreWeightLogRequestと同様
            ],
            'calories' => 'required|integer|min:0',  // nullableを削除
            'exercise_time' => 'required',  // nullableを削除
            'exercise_content' => 'nullable|string|max:120',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を入力してください',
            'weight.required' => '体重を入力してください',
            'weight.numeric' => '数字で入力してください',
            'weight.regex' => '4桁までの数字で入力してください。小数点は1桁で入力してください',
            'calories.required' => '摂取カロリーを入力してください',
            'calories.integer' => '数字で入力してください',
            'exercise_time.required' => '運動時間を入力してください',
            'exercise_content.max' => '120文字以内で入力してください',
        ];
    }
}
