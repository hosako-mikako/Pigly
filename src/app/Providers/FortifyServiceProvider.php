<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Requests\LoginRequest;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequests;

class FortifyServiceProvider extends ServiceProvider
{   
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // RegisterResponseのカスタマイズをより明示的に
        $this->app->singleton(
            \Laravel\Fortify\Contracts\RegisterResponse::class,
            \App\Responses\RegisterResponse::class
        );

        // 登録ビューとしてstep1を設定
        Fortify::registerView(function () {
            return view('register.step1');
        });

        // 登録後のリダイレクト先の設定
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                return redirect('/register/step2');
            }
        });

        // ログインビューの設定
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // ログイン後のリダイレクト先の設定
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                return redirect()->intended(RouteServiceProvider::HOME);
            }
        });

        // カスタムバリデーションメッセージとログイン認証設定
        Fortify::authenticateUsing(function (Request $request) {
            // バリテーション実行
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ], [
                'email.required' => 'メールアドレスを入力してください',
                'email.email' => 'メールアドレスは「ユーザー名@ドメイン」形式で入力してください',
                'password.required' => 'パスワードを入力してください',
            ]);

            // スロットリングキーを定義
            $throttleKey = Str::lower($request->email).'|'.$request->ip();

            // 認証を試みる
            if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
                RateLimiter::clear($throttleKey);
                return Auth::user();
            }

            // 認証失敗
            RateLimiter::hit($throttleKey);

            throw ValidationException::withMessages([
                'email' => 'メールアドレスまたはパスワードが正しくありません',
            ]);
        });

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

    }

    public function register()
    {
        // FortifyのLoginRequestを自作のLoginRequestで上書き
        $this->app->bind(
            \Laravel\Fortify\Http\Requests\LoginRequest::class,
            \App\Http\Requests\LoginRequest::class
        );
    }
}