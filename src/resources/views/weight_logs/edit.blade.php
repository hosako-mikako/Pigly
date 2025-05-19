@extends('layouts.app')

@section('title', '体重記録の編集')

@section('css')
<link rel="stylesheet" href="{{ asset('css/weight_logs.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
@endsection

@section('content')
<div class="header">
    <h1 class="logo">PiGLy</h1>
    <div class="header-action">
        <a href="{{ route('weight_logs.goal_setting') }}" class="custom-button">
            <i class="bi bi-gear"></i>目標体重設定
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="custom-button">
                <i class="bi bi-box-arrow-right"></i>ログアウト
            </button>
        </form>
    </div>
</div>

<!-- モーダルと同じスタイルのコンテナ -->
<div class="modal-style-container">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Weight Log</h2>
        </div>
        <form method="post" action="{{ route('weight_logs.update', $weightLog->id) }}" novalidate>
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="date">日付</label>
                <input type="date" id="date" name="date" class="form-input" value="{{ old('date', $weightLog->date) }}" required>
                @error('date')
                <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="weight">体重(kg)</label>
                <input type="text" id="weight" name="weight" class="form-input" step="0.1" required value="{{ old('weight', $weightLog->weight) }}" placeholder="50.0">
                @error('weight')
                <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="calories">摂取カロリー</label>
                <input type="text" id="calories" name="calories" class="form-input" value="{{ old('calories', $weightLog->calories) }}" placeholder="1200">
                @error('calories')
                <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="exercise_time">運動時間</label>
                <input type="time" id="exercise_time" name="exercise_time" class="form-input" value="{{ old('exercise_time', $weightLog->exercise_time) }}">
                @error('exercise_time')
                <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="exercise_content">運動内容</label>
                <textarea name="exercise_content" id="exercise_content" class="form-textarea" placeholder="運動内容を追加">{{ old('exercise_content', $weightLog->exercise_content) }}</textarea>
                @error('exercise_content')
                <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-button">
                <button type="button" class="btn-cansel" onclick="location.href='{{ route('weight_logs.index')}}'">戻る</button>
                <button type="submit" class="btn-register">更新</button>
                <button type="button" class="btn-delete" onclick="event.preventDefault(); if(confirm('本当に削除しますか？')) document.getElementById('delete-form').submit();">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        </form>

        <!-- 削除用の隠しフォーム -->
        <form id="delete-form" action="{{ route('weight_logs.destroy', $weightLog->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection