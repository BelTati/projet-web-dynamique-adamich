<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Example Website' }}</title>
<link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">

    @yield('style')
  </head>
  <body>
   
     @include('include.header')
    
     <div class="d-flex justify-content-start">
        
     @include('include.aside')
  
     
     <main class="col-md-10">
    @include('include.slider') 
     
     
  @include('include.search')
     
      @yield('content')
   

  </div>

</main>
    </div>
      <footer>
    
    </footer>
  
    <script src="{{ asset('public/assets/js/bootstrap.min.js' ) }}></script>
  
</body>
</html>