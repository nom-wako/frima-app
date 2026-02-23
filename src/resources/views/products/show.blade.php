@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<section class="show-detail">
  <div class="show-detail__img"><img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}"></div>
  <div class="show-detail__content">
    <div class="show-header">
      <h2 class="show-name">{{ $product->name }}</h2>
      <p class="show-brand">{{ $product->brand }}</p>
      <p class="show-price">
        <span class="show-price__currency">¥</span>
        <span class="show-price__amount">{{ number_format($product->price) }}</span>
        <span class="show-price__tax">(税込)</span>
      </p>
    </div>
    <ul class="show-icons">
      <li class="show-icons__item"></li>
      <li class="show-icons__item"></li>
    </ul>
    <a href="/purchase/{{ $product->id }}" class="show-purchase">購入手続きへ</a>
    <section class="show-section">
      <h3 class="show-section__heading">商品説明</h3>
      <div class="show-description">{{ $product->description }}</div>
    </section>
    <section class="show-section">
      <h3 class="show-section__heading">商品の情報</h3>
      <dl class="show-info">
        <dt class="show-info__heading">カテゴリー</dt>
        <dd class="show-info__detail">
          <ul class="show-category">
            @foreach($product->categories as $category)
            <li class="show-category__item">{{ $category->name }}</li>
            @endforeach
          </ul>
        </dd>
        <dt class="show-info__heading">商品の状態</dt>
        <dd class="show-info__detail">{{ $product->condition->name }}</dd>
      </dl>
    </section>
    <section class="show-section">
      <h3 class="show-section__heading show-section__heading--comment">コメント(1)</h3>
      <div class="show-comment">
        <div class="show-comment__user">
          <div class="show-comment__user-img"></div>
          <p class="show-comment__user-name">admin</p>
        </div>
        <div class="show-comment__box">
          <p class="show-comment__text">こちらにコメントが入ります。</p>
        </div>
      </div>
      @auth
      <form action="" method="post" class="form">
        @csrf
        <div class="form__group">
          <label for="comment">商品へのコメント</label>
          <textarea name="comment" id="comment"></textarea>
        </div>
        <div class="form__button form__button--comment">
          <button type="submit" class="form__button-submit form__button-submit--comment">コメントを送信する</button>
        </div>
      </form>
      @endauth
    </section>
  </div>
</section>
@endsection
