<html>
    <head>
        <title>Auction Admin - @yield('title')</title>
        @section('embed-css')
          <link rel="stylesheet" href="//{{URL::asset('/css/materialize.min.css')}}">
          <link rel="stylesheet" href="//{{URL::asset('/css/materialize-icon.css')}}">
          <link rel="stylesheet" href="//{{URL::asset('/css/style.css')}}">
        @show

        @section('embed-js')
          <script type="text/javascript" src="//{{URL::asset('/js/jquery.min.js')}}"></script>
          <script type="text/javascript" src="//{{URL::asset('/js/materialize.min.js')}}"></script>
        @show
    </head>
    <body>
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
