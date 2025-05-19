@extends('layouts.app')

@section('title', '体重記録の登録')

@section('css')
<link rel="stylesheet" href="{{ asset('css/weight_logs.css') }}">
@endsection

@section('content')
<div class="container">
    <h1 class="page-title">体重記録の登録</h1>

    <div class="form-container">
        <form method="post" action="{{ route('weight_logs.store') }}">
            @csrf
            <div class="form-group">
                <label for="date">日付</label>
                <input type="date" id="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                @error('date')
                <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="weight">体重(kg)</label>
                <input type="number" id="weight" name="weight" class="form-control" step="0.1" required>
                @error('weight')
                <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="calories">摂取カロリー</label>
                <input type="number" id="calories" name="calories" class="form-control">
                @error('calories')
                <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="exercise_time">運動時間</label>
                <input type="time" id="exercise_time" name="exercise_time" class="form-control">
                @error('exercise_time')
                <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="exercise_content">運動内容</label>
                <textarea name="exercise_content" id="exercise_content" class="form-control" rows="3"></textarea>
                @error('exercise_content')
                <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-button">
                <button type="submit" class="btn-register">登録</button>
                <a href="{{ route('weight_logs.index') }}" class="btn-cancel">戻る</a>
            </div>
        </form>
    </div>
</div>
@endsection