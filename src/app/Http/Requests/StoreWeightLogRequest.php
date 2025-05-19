<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWeightLogRequest extends FormRequest
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
            'date' => 'required|date',
            'weight' => [
                'required',
                'numeric',
                // 4桁以下のチェック
                function ($attribute, $value, $fail) {
                    if ((int)$value >= 10000) {
                        $fail('4桁までの数字で入力してください');
                    }
                },
                // 小数点1桁のチェック
                function ($attribute, $value, $fail) {
                    // 小数点以下の桁数をチェック
                    $decimalPart = explode('.', (string)$value);
                    if (isset($decimalPart[1]) && strlen($decimalPart[1]) > 1) {
                        $fail('小数点は1桁で入力してください');
                    }
                }
            ],
            'calories' => 'required|integer|min:0',
            'exercise_time' => 'required',
            'exercise_content' => 'nullable|string|max:120',
        ];
    }

    /**
     * カスタムエラーメッセージ
     */
    public function messages()
    {
        return [
            'date.required' => '日付を入力してください',
            'weight.required' => '体重を入力してください',
            'weight.numeric' => '数字で入力してください',
            'calories.required' => '摂取カロリーを入力してください',
            'calories.integer' => '数字で入力してください',
            'exercise_time.required' => '運動時間を入力してください',
            'exercise_content.max' => '120文字以内で入力してください',
        ];
    }
}
