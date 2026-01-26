@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<section class="section">
  <div class="section__inner">
    <h2 class="heading heading--primary">ログイン</h2>
    <form action="/login" method="post" class="auth-form">
      @csrf
      <div class="auth-form__group">
        <label for="email">メールアドレス</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
        <div class="auth-form__error">
          @error('email')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="auth-form__group">
        <label for="password">パスワード</label>
        <input type="password" name="password" id="password">
        <div class="auth-form__error">
          @error('password')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="auth-form__button">
        <button class="auth-form__button-submit" type="submit">ログインする</button>
      </div>
    </form>
    <p class="login__register"><a href="/register" class="login__register-link">会員登録はこちら</a></p>
  </div>
</section>
@endsection
