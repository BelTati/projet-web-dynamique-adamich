<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Example Website' }}</title>
    <link rel="stylesheet" type="text/html" href="{{asset('assets/css/bootstrap.min.css')}}">
 
    @yield('style')
  </head>
  <body class="d-flex align-items-center py-4 bg-body-tertiary">
    <nav>
      <h3>Welcome to my website</h3>
      <hr>
    </nav>
   
    
    @yield('content')
    <footer>
      <hr />
      © 2023 example.com
    </footer>
  
    <script src="{{ asset('public/assets/js/bootstrap.min.js' ) }}></script>
</body>
</html>