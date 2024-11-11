<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content=" IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="base-url" content="{{ asset('') }}">
  <meta name="product-search-url" content="{{ route('product.search') }}">
  <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
  <title>@yield('title')</title>
  @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script> let baseUrl = $('meta[name="base-url"]').attr('content');</script>
  
</head>
<body>
  <div class="container">
    @yield('content')
  </div>
</body>
</html>