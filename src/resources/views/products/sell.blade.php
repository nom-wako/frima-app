@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<section class="section section--narrow">
  <div class="section__inner">
    <h2 class="heading heading--primary">商品の出品</h2>
    <form action="{{ route('product.store') }}" method="post" class="form" enctype="multipart/form-data">
      @csrf
      <div class="form__group">
        <label>商品画像</label>
        <div class="sell-img">
          <img src="" alt="" id="preview-image" style="display: none;">
          <label class="sell-img__button">
            画像を選択する
            <input type="file" name="img_url" class="sell-img__hidden" id="image-input" accept="image/*">
          </label>
        </div>
        <div class="form__error">
          @error('img_url')
          {{ $message }}
          @enderror
        </div>
      </div>
      <section class="sell-section">
        <h3 class="sell-section__heading">商品の詳細</h3>
        <div class="form__group">
          <label>カテゴリー</label>
          <ul class="sell-category">
            @foreach($categories as $category)
            <li class="sell-category__item">
              <input type="checkbox" name="categories[]" value="{{ $category->id }}" id="category-{{ $category->id }}" class="sell-category__input">
              <label for="category-{{ $category->id }}" class="sell-category__label">{{ $category->name }}</label>
            </li>
            @endforeach
          </ul>
          <div class="form__error">
            @error('categories')
            {{ $message }}
            @enderror
          </div>
        </div>
        <div class="form__group">
          <label for="condition_id">商品の状態</label>
          <div class="sell-select">
            <select name="condition_id" id="condition_id">
              <option value="" disabled selected>選択してください</option>
              @foreach($conditions as $condition)
              <option value="{{ $condition->id }}">{{ $condition->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form__error">
            @error('condition_id')
            {{ $message }}
            @enderror
          </div>
        </div>
      </section>
      <section class="sell-section">
        <h3 class="sell-section__heading">商品名と説明</h3>
        <div class="form__group">
          <label for="name">商品名</label>
          <input type="text" name="name" id="name" value="{{ old('name') }}">
          <div class="form__error">
            @error('name')
            {{ $message }}
            @enderror
          </div>
        </div>
        <div class="form__group">
          <label for="brand">ブランド名</label>
          <input type="text" name="brand" id="brand" value="{{ old('brand') }}">
          <div class="form__error">
            @error('brand')
            {{ $message }}
            @enderror
          </div>
        </div>
        <div class="form__group">
          <label for="description">商品の説明</label>
          <textarea name="description" id="description">{{ old('description') }}</textarea>
          <div class="form__error">
            @error('description')
            {{ $message }}
            @enderror
          </div>
        </div>
        <div class="form__group">
          <label for="price">販売価格</label>
          <input type="text" name="price" id="price" value="{{ old('price') }}">
          <div class="form__error">
            @error('price')
            {{ $message }}
            @enderror
          </div>
        </div>
      </section>
      <div class="form__button">
        <button class="form__button-submit" type="submit">出品する</button>
      </div>
    </form>
  </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('js/sell.js') }}"></script>
@endpush
