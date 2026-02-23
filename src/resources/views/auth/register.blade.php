@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<section class="section section--narrow">
  <div class="section__inner">
    <h2 class="heading heading--primary">会員登録</h2>
    <form action="/register" method="post" class="form">
      @csrf
      <div class="form__group">
        <label for="name">ユーザー名</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">
        <div class="form__error">
          @error('name')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="form__group">
        <label for="email">メールアドレス</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
        <div class="form__error">
          @error('email')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="form__group">
        <label for="password">パスワード</label>
        <input type="password" name="password" id="password">
        <div class="form__error">
          @error('password')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="form__group">
        <label for="password_confirmation">確認用パスワード</label>
        <input type="password" name="password_confirmation" id="password_confirmation">
        <div class="form__error">
          @error('password_confirmation')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="form__button">
        <button class="form__button-submit" type="submit">登録する</button>
      </div>
    </form>
    <p class="register__login"><a href="/login" class="register__login-link">ログインはこちら</a></p>
  </div>
</section>
@endsection
