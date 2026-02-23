@extends('layouts.app')

@section('css')
@endsection

@section('content')
<section class="section section--narrow">
  <div class="section__inner">
    <h2 class="heading heading--primary">プロフィール設定</h2>
    @if(session('status'))
    <p class="form__status">{{ session('status') }}</p>
    @endif
    <form action="{{ route('profile.update') }}" method="post" class="form" enctype="multipart/form-data">
      @csrf
      <div class="form__profile">
        <div class="form__profile-img">
          @if($user->img_url)
          <img src="{{ asset('storage/' . $user->img_url) }}" alt="" id="preview-image">
          @else
          <img src="" alt="" id="preview-image" style="display: none;">
          @endif
        </div>
        <label class="form__profile-button">
          画像を選択する
          <input type="file" name="img_url" class="form__profile-hidden" id="image-input" accept="image/*">
        </label>
      </div>
      <div class="form__group">
        <label for="name">ユーザー名</label>
        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}">
        <div class="form__error">
          @error('name')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="form__group">
        <label for="post_code">郵便番号</label>
        <input type="text" name="post_code" id="post_code" value="{{ old('post_code', $address?->post_code) }}">
        <div class="form__error">
          @error('post_code')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="form__group">
        <label for="address">住所</label>
        <input type="text" name="address" id="address" value="{{ old('address', $address?->address) }}">
        <div class="form__error">
          @error('address')
          {{ $message }}
          @enderror
        </div>
      </div>
      <div class="form__group">
        <label for="building">建物名</label>
        <input type="text" name="building" id="building" value="{{ old('building', $address?->building) }}">
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

@push('scripts')
<script src="{{ asset('js/profile.js') }}"></script>
@endpush
