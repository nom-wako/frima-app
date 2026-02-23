@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="tabs">
  <a href="/" class="tab-item {{ request('tab') !== 'mylist' ? 'is-active' : '' }}">おすすめ</a>
  <a href="/?tab=mylist" class="tab-item {{ request('tab') === 'mylist' ? 'is-active' : '' }}">マイリスト</a>
</div>
@if($products->isEmpty())
<p class="product-list__empty">お気に入り登録した商品はまだありません。</p>
@else
<ul class="product-list">
  @foreach ($products as $product)
  <li class="product-list__item">
    <a href="{{ route('products.show', ['product' => $product->id]) }}" class="product-list__link">
      <div class="product-list__img"><img src="{{ asset('storage/' . $product->image_path) }}" alt=""></div>
      <p class="product-list__name">{{ $product->name }}</p>
    </a>
  </li>
  @endforeach
</ul>
@endif
@endsection
