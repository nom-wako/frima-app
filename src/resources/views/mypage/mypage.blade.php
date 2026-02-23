@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage-user">
  <div class="mypage-user__img">
    @if($user->img_url)
    <img src="{{ asset('storage/' . $user->img_url) }}" alt="">
    @endif
  </div>
  <p class="mypage-user__name">{{ $user->name }}</p>
  <a href="{{ route('profile.edit') }}" class="mypage-user__edit">プロフィールを編集</a>
</div>
<div class="tabs">
  <a href="/mypage?page=sell" class="tab-item {{ $page === 'sell' ? 'is-active' : '' }}">出品した商品</a>
  <a href="/mypage?page=buy" class="tab-item {{ $page === 'buy' ? 'is-active' : '' }}">購入した商品</a>
</div>
@if($products->isEmpty())
<p class="product-list__empty">商品はまだありません。</p>
@else
<ul class="product-list">
  @foreach ($products as $product)
  <li class="product-list__item">
    <a href="{{ route('products.show', ['product' => $product->id]) }}" class="product-list__link">
      <div class="product-list__img">
        <img src="{{ asset('storage/' . $product->image_path) }}" alt="">
        @if($product->is_sold)
        <p class="product-list__sold">Sold</p>
        @endif
      </div>
      <p class="product-list__name">{{ $product->name }}</p>
    </a>
  </li>
  @endforeach
</ul>
@endif
@endsection
