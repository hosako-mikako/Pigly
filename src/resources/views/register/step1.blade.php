@extends('layouts.app')

@section('title', '会員登録 - ステップ１')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register-login.css') }}">
@endsection

@section('body-class', 'bg-register-login')

@section('content')
<div class="auth-content">
    <form action="{{ route('register') }}" method="post" class="form-content">
        @csrf
        <div class="title-content">
            <h1 class="site-title">PiGLy</h1>
            <h2 class="page-title">新規会員登録</h2>
        </div>
        <h3 class="step-title">STEP1 アカウント情報の登録</h3>
        <div class="form-group">
            <label for="name" class="form-name">お名前</label>
            <div class="form-input">
                <input type="text" id="name" name="name" class="input-text" placeholder="名前を入力" autocomplete="name" value="{{ old('name') }}">
                @error('name')
                <div class="error-message">
                    @foreach ($errors->get('name') as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="form-email">メールアドレス</label>
            <div class="form-input">
                <input type="text" id="email" name="email" class="input-text" placeholder="メールアドレスを入力" autocomplete="email" value="{{ old('email') }}">
                @error('email')
                <div class="error-message">
                    @foreach ($errors->get('email') as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="form-password">パスワード</label>
            <div class="form-input">
                <input type="password" id="password" name="password" class="input-text" placeholder="パスワードを入力" autocomplete="new-password">
                @error('password')
                <div class="error-message">
                    @foreach ($errors->get('password') as $error)
                    <div>{{ $error }}</div>
                    @endforeach
                </div>
                @enderror
            </div>
        </div>
        <div class="button-group">
            <button type="submit" class="submit-button">次に進む</button>
            <a href="{{ route('login') }}" class="link-button">ログインはこちら</a>
        </div>
    </form>
</div>
@endsection