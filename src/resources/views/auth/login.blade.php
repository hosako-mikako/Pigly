@extends('layouts.app')

@section('title', 'ログイン画面')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register-login.css') }}">
@endsection

@section('body-class', 'bg-register-login')

@section('content')
<div class="auth-content">
    <form action="{{ route('login') }}" method="post" class="form-content" novalidate>
        @csrf
        <div class="title-content">
            <h1 class="site-title">PiGLy</h1>
            <h2 class="page-title">ログイン</h2>
        </div>
        <div class="form-group">
            <label for="email" class="form-email">メールアドレス</label>
            <div class="form-input">
                <input type="text" id="email" name="email" value="{{ old('email') }}" class="input-text" placeholder="メールアドレスを入力" autocomplete="email">
                @error ('email')
                <div class="error-message">
                    <div>{{ $message }}</div>
                </div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="form-password">パスワード</label>
            <div class="form-input">
                <input type="password" id="password" name="password" class="input-text" placeholder="パスワードを入力" autocomplete="current-password">
                @error('password')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="button-group">
            <button type="submit" class="submit-button">ログイン</button>
            <a href="{{ route('register') }}" class="link-button">アカウント作成はこちら</a>
        </div>
    </form>
</div>
@endsection