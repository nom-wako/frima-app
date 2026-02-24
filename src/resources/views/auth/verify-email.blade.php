@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<section class="section">
  <div class="section__inner">
    <h1 class="verify-email__heading">登録していただいたメールアドレスに認証メールを送付しました。<br>メール認証を完了してください。</h1>
    <a href="{{ config('services.mail_dashboard.url') }}" target="_blank" rel="noopener noreferrer" class="verify-email__button">認証はこちらから</a>
    <form action="{{ route('verification.send') }}" method="post">
      @csrf
      <button type="submit" class="verify-email__resend">認証メールを再送する</button>
    </form>
  </div>
</section>
@endsection
