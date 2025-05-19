@extends('layouts.app')

@section('title', '会員登録 - ステップ2')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register-login.css') }}">
@endsection

@section('body-class', 'bg-register-login')

@section('content')
<div class="auth-content">
    <form action="{{ route('register.complete') }}" method="post" class="form-content">
        @csrf
        <div class="title-content">
            <h1 class="site-title">PiGLy</h1>
            <h2 class="page-title">新規会員登録</h2>
        </div>
        <h3 class="step-title">STEP2 詳細情報の登録</h3>

        <div class="form-group">
            <label for="current_weight" class="form-name">現在の体重</label>
            <div class="form-input">
                <input type="number" id="current_weight" name="current_weight" class="input-text" placeholder="現在の体重を入力" step="0.1" value="{{ old('current_weight') }}" autocomplete="off"><span class="unit">kg</span>
                @error('current_weight')
                <div class="error-message">
                    @foreach ($errors->get('current_weight') as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="target_weight" class="form-name">目標の体重</label>
            <div class="form-input">
                <input type="number" id="target_weight" name="target_weight" class="input-text" placeholder="目標の体重を入力" step="0.1" value="{{ old('target_weight') }}" autocomplete="off"><span class="unit">kg</span>
                @error('target_weight')
                <div class="error-message">
                    @foreach ($errors->get('target_weight') as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
                @enderror
            </div>
        </div>

        <div class="button-group">
            <button type="submit" class="submit-button">アカウント作成</button>
        </div>
    </form>
</div>
@endsection