@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<section class="show-detail">
  <div class="show-detail__img">
    <img src="{{ asset('storage/' . $product->img_url) }}" alt="{{ $product->name }}">
  </div>
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
      <li class="show-icons__item">
        <div class="show-icons__icon">
          <form action="{{ $product->isFavoritedBy(auth()->user()) ? route('favorite.destroy', $product) : route('favorite.store', $product) }}" method="post">
            @csrf
            @if ($product->isFavoritedBy(auth()->user()))
            @method('DELETE')
            @endif
            <button type="submit" class="show-favorite {{ $product->isFavoritedBy(auth()->user()) ? 'is-active' : '' }}">
              <x-favorite-icon />
            </button>
          </form>
        </div>
        <p class="show-icons__num">{{ $product->favorited_by_count }}</p>
      </li>
      <li class="show-icons__item">
        <div class="show-icons__icon"><img src="{{ asset('img/show/comment.svg') }}" alt="コメント数"></div>
        <p class="show-icons__num">{{ $product->comments_count }}</p>
      </li>
    </ul>
    @if($product->is_sold)
    <p class="show-purchase is-sold">Sold</p>
    @else
    <a href="/purchase/{{ $product->id }}" class="show-purchase">購入手続きへ</a>
    @endif
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
      <h3 class="show-section__heading show-section__heading--comment">コメント({{ $product->comments_count }})</h3>
      @foreach($product->comments as $comment)
      <div class="show-comment">
        <div class="show-comment__user">
          <div class="show-comment__user-img">
            @if($comment->user->img_url)
            <img src="{{ asset('storage/' . $comment->user->img_url) }}" alt="">
            @endif
          </div>
          <p class="show-comment__user-name">{{ $comment->user->name }}</p>
        </div>
        <div class="show-comment__box">
          <p class="show-comment__text">{!! nl2br(e($comment->comment)) !!}</p>
        </div>
      </div>
      @endforeach
      @auth
      @if(!$product->is_sold)
      <form action="{{ route('comments.store', $product->id) }}" method="post" class="form">
        @csrf
        <div class="form__group">
          <label for="comment">商品へのコメント</label>
          <textarea name="comment" id="comment">{{ old('comment') }}</textarea>
          <div class="form__error">
            @error('comment')
            {{ $message }}
            @enderror
          </div>
        </div>
        <div class="form__button form__button--comment">
          <button type="submit" class="form__button-submit form__button-submit--comment">コメントを送信する</button>
        </div>
      </form>
      @endif
      @endauth
    </section>
  </div>
</section>
@endsection
