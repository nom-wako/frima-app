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
    </div>
  </header>
  <main>
    @yield('content')
  </main>
</body>

</html>
