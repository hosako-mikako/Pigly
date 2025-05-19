<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterStepTwoRequest;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /**
     * 初期目標体重登録フォーム表示
     */
    public function showStep2Form(Request $request)
    {

        // 認証済みユーザーのみアクセス可能
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインが必要です');
        }

        // Fortifyを使用した登録後は、新規ユーザーであればステップ1を完了したとみなす
        // 既存のWeightTargetがないことで新規ユーザーかどうかを判断
        $hasTarget = WeightTarget::where('user_id', Auth::id())->exists();
        if ($hasTarget) {
            return redirect()->route('weight_logs.index');
        }

        return view('register.step2');
    }

    /**
     * 会員登録ステップ2の処理
     */
    public function processStep2(RegisterStepTwoRequest $request)
    {
        // リクエストは自動的にバリデーションされる

        // 現在の体重を記録
        WeightLog::create([
            'user_id' => Auth::id(),
            'date' => now()->format('Y-m-d'),
            'weight' => $request->current_weight,
        ]);

        // 目標体重を設定
        WeightTarget::create([
            'user_id' => Auth::id(),
            'target_weight' => $request->target_weight,
        ]);

        return redirect()->route('weight_logs.index')
            ->with('success', '会員登録が完了しました！');
    }
}
