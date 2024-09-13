@extends('layouts.template')
@section('title','新規登録')
@section('content')

<div class="row">
    <div class="register__title">ユーザー新規登録画面</div>

    <div class="register_form">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="register_inputs">
                <div class="register_input">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="パスワード" autofocus>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="register_inputs">
                <div class="register_input">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="アドレス">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="new_register__back_btn">
                    <button type="submit" class="new_user_submit_btn">新規登録</button>
                    <button type="button" onclick="location.href='{{ route('product.list') }}'" class="register_back_btn">戻る</button>
            </div>
        </form>
    </div>
</div>

@endsection
