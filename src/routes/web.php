<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeightLogController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// トップページ（管理画面）
Route::get('/weight_logs', [WeightLogController::class, 'index'])->name('weight_logs.index')->middleware('auth');

// 体重登録
Route::get('/weight_logs/create', [WeightLogController::class, 'create'])->name('weight_logs.create')->middleware('auth');
Route::post('/weight_logs', [WeightLogController::class, 'store'])->name('weight_logs.store')->middleware('auth');

// 体重検索 
Route::get('/weight_logs/search', [WeightLogController::class, 'search'])->name('weight_logs.search')->middleware('auth');

// 目標設定 
Route::get('/weight_logs/goal_setting', [WeightLogController::class, 'goalSetting'])->name('weight_logs.goal_setting')->middleware('auth');
Route::post('/weight_logs/goal_setting', [WeightLogController::class, 'saveGoal'])->name('weight_logs.save_goal')->middleware('auth');

// 体重詳細 
Route::get('/weight_logs/{weightLog}', [WeightLogController::class, 'show'])->name('weight_logs.show')->middleware('auth');

// 体重更新
Route::get('/weight_logs/{weightLog}/update', [WeightLogController::class, 'edit'])->name('weight_logs.edit')->middleware('auth');
Route::put('/weight_logs/{weightLog}', [WeightLogController::class, 'update'])->name('weight_logs.update')->middleware('auth');

// 体重削除
Route::delete('/weight_logs/{weightLog}', [WeightLogController::class, 'destroy'])->name('weight_logs.destroy')->middleware('auth');

// Fortifyが処理する基本登録ルート:
Route::get('/register/step1', function () {
    return view('register.step1');
})->name('register.step1')->middleware('guest');


// 会員登録ステップ2のルート
Route::get('/register/step2', [RegisterController::class, 'showStep2Form'])
    ->name('register.step2');

Route::post('/register/step2', [RegisterController::class, 'processStep2'])
    ->name('register.complete')->middleware('auth');

// ログアウトページを表示するルート
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
