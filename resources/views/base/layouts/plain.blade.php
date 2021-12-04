<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ config('backpack.base.html_direction') }}">
<head>
    @include(backpack_view('inc.head'))
</head>
<body class="app flex-row align-items-center  bg-image" style="background-image: url({{ asset('images/background/background.jpg') }})">

  @yield('header')

  <div class="container" style="background-image: url(images/background/background.jpg)">
      @yield('content')
  </div>
  

  {{-- <footer class="app-footer sticky-footer">
    @include('backpack::inc.footer')
  </footer> --}}

  @yield('before_scripts')
  @stack('before_scripts')

  @include(backpack_view('inc.scripts'))

  @yield('after_scripts')
  @stack('after_scripts')

</body>
</html>
