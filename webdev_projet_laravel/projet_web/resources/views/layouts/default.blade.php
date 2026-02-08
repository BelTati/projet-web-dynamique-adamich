<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Example Website' }}</title>
   
  <link rel="stylesheet"  href="assets/css/bootstrap.css">
    @yield('style')
  </head>
  <body>
   
     @include('include.header')
    <div class="d-flex justify-content-start">

      @include('include.aside')
      @yield('content')
   
    </div>
  
      <footer>
    
    </footer>
  
    <script src="{{ asset('public/assets/js/bootstrap.min.js' ) }}></script>
</body>
</html>