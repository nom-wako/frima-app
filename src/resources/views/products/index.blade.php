@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="product__content">
  <ul class="product-list">
    @foreach ($products as $product)
    <li class="product-list__item">
      <a href="{{ route('products.show', $product) }}" class="product-list__link">
        <div class="product-list__img"><img src="{{ asset('storage/' . $product->image_path) }}" alt=""></div>
        <p class="product-list__name">{{ $product->name }}</p>
      </a>
    </li>
    @endforeach
  </ul>
</div>
@endsection
