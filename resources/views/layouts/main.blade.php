<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Choco Test Project</title>

  <link rel="stylesheet" href="{{ asset('library/styles/global.css?20H401') }}">

  @stack('styles')
</head>



<body>
  @include('partials.header')

  @yield('page')

  @include('partials.footer')


  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
  <script src="{{ asset('library/scripts/l2.js?21C201') }}"></script>
  <script src="{{ asset('library/scripts/common.js?20H401') }}"></script>

  @stack('scripts')
</body>
</html>
