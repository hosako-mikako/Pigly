<?php

namespace App\Http\Controllers;

use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Http\Request;
use App\Http\Requests\StoreWeightLogRequest;
use App\Http\Requests\UpdateWeightLogRequest;
use App\Http\Requests\WeightTargetRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WeightLogController extends Controller
{
    /**
     * コンストラクタ - 認証が必要
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * トップページ（管理画面）
     */
    public function index()
    {
        // ログインユーザーの情報取得
        $user = Auth::user();

        // 目標体重を取得
        $targetWeight = WeightTarget::where('user_id', Auth::id())->value('target_weight') ?? 0;

        // 最新の体重記録を取得
        $latestWeight = WeightLog::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->value('weight') ?? 0;

        // 目標までの差分を計算
        $weightDifference = $latestWeight - $targetWeight;

        // 全ての体重記録を8件ごとにページネーション
        $weightLogs = WeightLog::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->paginate(8);

        return view('weight_logs.index', compact(
            'targetWeight',
            'latestWeight',
            'weightDifference',
            'weightLogs'
        ));
    }

    /**
     * 体重検索
     */
    public function search(Request $request)
    {
        // 目標体重を取得
        $targetWeight = WeightTarget::where('user_id', Auth::id())->value('target_weight') ?? 0;

        //  最新の体重を取得
        $latestWeight = WeightLog::where('user_id', Auth::id())
            ->orderBy('date', 'desc')
            ->value('weight') ?? 0;

        // 目標までの差分を計算
        $weightDifference = $latestWeight - $targetWeight;

        // 検索条件
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // 体重ログを検索
        $query = WeightLog::where('user_id', Auth::id());

        if ($startDate) {
            $query->where('date', '>=', $startDate);
        }

        if ($endDate) {
            $query->where('date', '<=', $endDate);
        }

        $weightLogs = $query->orderBy('date', 'desc')->paginate(8);

        return view('weight_logs.index', compact(
            'targetWeight',
            'latestWeight',
            'weightDifference',
            'weightLogs',
            'startDate',
            'endDate'
        ));
    }

    /**
     * 体重記録の保存
     */
    public function store(StoreWeightLogRequest $request)
    {

        // バリデーション
        $validated = $request->validated();

        // データベースに保存
        WeightLog::create([
            'user_id' => Auth::id(),
            'date' => $validated['date'],
            'weight' => $validated['weight'],
            'calories' => $validated['calories'],
            'exercise_time' => $validated['exercise_time'],
            'exercise_content' => $validated['exercise_content'],
        ]);

        
        return redirect()->route('weight_logs.index')
            ->with('success', '体重を記録しました！');
    }


    /**
     * 体重登録フォーム表示
     */
    public function create()
    {
        return view('weight_logs.create');
    }

    

    
    /**
     * 体重詳細表示
     */
    public function show(WeightLog $weightLog)
    {
        // 自分の記録以外は見れない
        if ($weightLog->user_id !== Auth::id()) {
            abort(403);
        }

        return view('weight_logs.show', compact('weightLog'));
    }

    /**
     * 体重更新フォーム表示
     */
    public function edit($id)
    {
        $weightLog = WeightLog::findOrFail($id);

        // 自分の記録以外は編集できない
        if ($weightLog->user_id !== Auth::id()) {
            abort(403);
        }

        return view('weight_logs.edit', compact('weightLog'));
    }

    /**
     * 体重記録の更新
     */
    public function update(UpdateWeightLogRequest $request, WeightLog $weightLog)
    {

        // 自分の記録以外は更新できない
        if ($weightLog->user_id !== Auth::id()) {
            abort(403);
        }


        $validated = $request->validated();

        $weightLog->update([
            'date' => $validated['date'],
            'weight' => $validated['weight'],
            'calories' => $validated['calories'] ?? null,
            'exercise_time' => $validated['exercise_time'] ?? null,
            'exercise_content' => $validated['exercise_content'] ?? null,
        ]);

        return redirect()->route('weight_logs.index', $weightLog)
            ->with('success', '体重記録を更新しました！');
    }

    /**
     * 体重記録の削除
     */
    public function destroy(WeightLog $weightLog)
    {

        // 自分の記録以外は削除できない
        if ($weightLog->user_id !== Auth::id()) {
            abort(403);
        }

        $weightLog->delete();

        return redirect()->route('weight_logs.index')
            ->with('success', '体重記録を削除しました。');
    }

    /**
     * 目標設定フォーム表示
     */
    public function goalSetting()
    {
        $target = WeightTarget::where('user_id', Auth::id())->first();

        return view('weight_logs.goal_setting', compact('target'));
    }

    /**
     * 目標体重の保存
     */
    public function saveGoal(WeightTargetRequest $request)
    {
        $validated = $request->validated();

        $target = WeightTarget::where('user_id', Auth::id())->first();

        if (!$target) {
            $target = new WeightTarget();
            $target->user_id = Auth::id();
        }

        $target->target_weight = $validated['target_weight'];
        $target->save();

        return redirect()->route('weight_logs.index')
            ->with('success', '目標体重を設定しました！');
    }
}
