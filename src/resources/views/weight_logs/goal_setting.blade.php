@extends('layouts.app')

@section('title', '目標体重設定')

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
    <div class="modal-content__goal">
        <div class="modal-header__goal">
            <h2>目標体重設定</h2>
        </div>
        <form method="post" action="{{ route('weight_logs.save_goal') }}" novalidate>
            @csrf

            <div class="form-group">
                <div class="input-with-unit">
                    <input type="text" id="target_weight" name="target_weight"
                        class="form-input__goal" step="0.1" min="1" max="999.9"
                        value="{{ old('target_weight', $target->target_weight ?? '') }}" required
                        placeholder="50.0">
                    <span class="unit">kg</span>
                </div>
                @error('target_weight')
                <div class="validation-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-button__goal">
                <button type="button" class="btn-cansel" onclick="location.href='{{ route('weight_logs.index') }}'">戻る</button>
                <button type="submit" class="btn-register">更新</button>
            </div>
        </form>
    </div>
</div>
@endsection