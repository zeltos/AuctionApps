@if(!Auth::check())
  <script type="text/javascript">
    window.location = "{ url('/auction-admin/login') }";//here double curly bracket
</script>
@endif
<html>
    <head>
        <title>@yield('title') - BO Auction</title>
        @section('embed-css')
          <link rel="stylesheet" href="{{URL::asset('/css/materialize.min.css')}}">
          <link rel="stylesheet" href="{{URL::asset('/css/materialize-icon.css')}}">
          <link rel="stylesheet" href="{{URL::asset('/css/dropzone.css')}}">
          <link rel="stylesheet" href="{{URL::asset('/css/style.css')}}">
        @show

        @section('embed-js')
          <script type="text/javascript" src="{{URL::asset('/js/jquery.min.js')}}"></script>
          <script type="text/javascript" src="{{URL::asset('/js/materialize.min.js')}}"></script>
          <script type="text/javascript" src="{{URL::asset('/js/dropzone.js')}}"></script>
        @show
    </head>
    <body>
        <div class="cover">
          <div class="side-wrap">
            <ul id="slide-out" class="side-nav" style="transform: translateX(0px);">
              <li><div class="userView">
                <div class="background">
                  <img src="http://materializecss.com/images/office.jpg">
                </div>
                <a href="#!user"><img class="circle" src="http://materializecss.com/images/yuna.jpg"></a>
                <a href="#!name"><span class="white-text name">John Doe</span></a>
                <a href="#!email"><span class="white-text email">jdandturk@gmail.com</span></a>
              </div></li>
              <li><a href="{{ url('/auction-admin/auction/config') }}"><i class="material-icons">gavel</i>Auction Configuration</a></li>
              <li><a href="#!"><i class="material-icons">supervisor_account</i>User Manager</a></li>
              <li><div class="divider"></div></li>
              <li><a class="subheader">Subheader</a></li>
              <li><a class="waves-effect" href="#!">Third Link With Waves</a></li>
            </ul>
          </div>
          <div class="main-wrap">
            @section('nav')
              <nav class="white text-black">
                  <div class="nav-wrapper">
                    <a href="#" class="brand-logo text-black">@yield('title-page')</a>
                    <ul id="nav-mobile" class="right hide-on-med-and-down">
                      <li><a href="badges.html" class="text-black grey lighten-4"><i class="material-icons left">face</i> {{Auth::user()->email}}</a></li>
                      <li><a href="{{ url('/auction-admin/logout') }}" class="text-white grey darken-4"> <i class="material-icons right">lock</i> logout</a></li>
                    </ul>
                  </div>
              </nav>
            @show
            @yield('content')
          </div>
        </div>        
    </body>
</html>
