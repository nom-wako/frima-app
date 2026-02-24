@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<meta name="stripe-key" content="{{ config('services.stripe.key') }}">
<form action="{{ route('purchase.store', $product) }}" method="post" id="purchase-form" class="purchase-form">
  @csrf
  <div class="purchase-form__input">
    <div class="purchase-product">
      <div class="purchase-product__img"><img src="{{ asset('storage/' . $product->img_url) }}" alt=""></div>
      <div class="purchase-product__detail">
        <h2 class="purchase-product__name">{{ $product->name }}</h2>
        <p class="purchase-product__price">
          <span class="purchase-product__currency">¥</span>
          <span class="purchase-product__amount">{{ number_format($product->price) }}</span>
        </p>
      </div>
    </div>
    <div class="purchase-payment">
      <label for="payment-method" class="purchase-section__heading">支払い方法</label>
      <div class="purchase-payment__select">
        <select name="payment_method" id="payment-method">
          <option value="" disabled selected>選択してください</option>
          <option value="1">コンビニ払い</option>
          <option value="2">カード払い</option>
        </select>
      </div>
      <div id="card-info-area" class="purchase-stripe">
        <p class="purchase-stripe__heading">カード情報</p>
        <div id="card-element"></div>
        <div id="card-errors" role="alert" class="purchase-stripe__error"></div>
      </div>
    </div>
    <div class="purchase-address">
      <p class="purchase-section__heading">配送先</p>
      <a href="{{ route('address.edit', $product) }}" class="purchase-address__edit">変更する</a>
      <p class="purchase-address__content">〒 {{ $address->post_code }}<br>{{ $address->address }}{{ $address->building }}</p>
      <input type="hidden" name="address_id" value="{{ $address->id }}">
    </div>
  </div>
  <div class="purchase-form__confirm">
    <table class="purchase-table">
      <tr>
        <th>商品代金</th>
        <td>
          <span class="purchase-table__currency">¥</span>
          <span class="purchase-table__amount">{{ number_format($product->price) }}</span>
        </td>
      </tr>
      <tr>
        <th>支払い方法</th>
        <td id="display-payment-method">未選択</td>
      </tr>
    </table>
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="purchase-form__button">
      <button type="submit" class="purchase-form__button-submit" id="buy-button">購入する</button>
    </div>
  </div>
</form>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ asset('js/purchase.js') }}"></script>
@endpush
