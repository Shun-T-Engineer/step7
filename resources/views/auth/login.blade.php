@extends('layouts.template')
@section('title','ログイン')
@section('content')

    <div class="row">
        <div class="login__title">ユーザーログイン画面</div>

        <div class="login_form">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="login_inputs">
                    <div class="login_input">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="パスワード" autocomplete="current-password" autofocus>

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="login_inputs">
                    <div class="login_input">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="アドレス" autocomplete="email" >

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                <div class="new_user__login_btn">
                    <button type="button" onclick="location.href='register'" class="new_user_btn">新規登録</button>
                    <button type="submit" class="login_submit_btn">ログイン</button>
                </div>
            </form>
        </div>
    </div>

@endsection
