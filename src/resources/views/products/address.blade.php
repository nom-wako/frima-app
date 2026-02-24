@extends('layouts.app')

@section('css')
@endsection

@section('content')
<section class="section section--narrow">
  <div class="section__inner">
    <h2 class="heading heading--primary">住所の変更</h2>
    <form action="{{ route('address.update', ['product' => $product->id]) }}" method="post" class="form">
      @csrf
      <div class="form__group">
        <label for="post_code">郵便番号</label>
        <input type="text" name="post_code" id="post_code" value="{{ old('post_code') }}">
        <div class="form__error">
          @error('post_code')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="form__group">
        <label for="address">住所</label>
        <input type="text" name="address" id="address" value="{{ old('address') }}">
        <div class="form__error">
          @error('address')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="form__group">
        <label for="building">建物名</label>
        <input type="text" name="building" id="building" value="{{ old('building') }}">
        <div class="form__error">
          @error('building')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="form__button">
        <button class="form__button-submit" type="submit">更新する</button>
      </div>
    </form>
  </div>
</section>
@endsection
