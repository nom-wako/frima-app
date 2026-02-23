<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>COACHTECH</title>
  <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <div class="header-logo">
        <a href="/" class="header-logo__link"><img src="{{ asset('img/common/logo.svg') }}" alt="COACHTECH"></a>
      </div>
      <div class="header-search">
        <input type="text" name="search">
      </div>
      <nav>
        <ul class="header-nav">
          @if (Auth::check())
          <li class="header-nav__item">
            <form action="/logout" method="post">
              @csrf
              <button class="header-nav__logout">ログアウト</button>
            </form>
          </li>
          @else
          <li class="header-nav__item">
            <a href="/login" class="header-nav__link">ログイン</a>
          </li>
          @endif
          <li class="header-nav__item">
            <a href="#" class="header-nav__link">マイページ</a>
          </li>
          <li class="header-nav__item">
            <a href="#" class="header-nav__link header-nav__link--sell">出品</a>
          </li>
        </ul>
      </nav>
    </div>
  </header>
  <main>
    @yield('content')
  </main>
  @stack('scripts')
</body>

</html>
