@if(!Auth::check())
  <script type="text/javascript">
    window.location = "{{ secure_url('/auction-admin/login') }}";//here double curly bracket
</script>
@else
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
          <script type="text/javascript" src="{{URL::asset('/js/chart.js')}}"></script>
        @show
    </head>
    <body>
        <div class="cover">
          <div class="side-wrap">
            <ul id="slide-out" class="side-nav" style="transform: translateX(0px);">
              <li><div class="userView">
                <div class="background" style="background-color:#19B5FE;">
                  {{-- <img src="http://materializecss.com/images/office.jpg"> --}}
                </div>
                <a href="#!user"><img class="circle" src="http://materializecss.com/images/yuna.jpg"></a>
                <a href="#!name"><span class="white-text name">John Doe</span></a>
                <a href="#!email"><span class="white-text email">jdandturk@gmail.com</span></a>
              </div></li>
              <li><a href="{{ secure_url('/auction-admin/home') }}"><i class="material-icons">dashboard</i>Dashboard</a></li>
              <li><a href="{{ secure_url('/auction-admin/auction/config') }}"><i class="material-icons">gavel</i>Auction Configuration</a></li>
              <li><a href="{{ secure_url('/auction-admin/user/config/index') }}"><i class="material-icons">supervisor_account</i>User Manager</a></li>
              @if (Auth::user()->role_id == 1)
              <li><a href="{{ secure_url('/auction-admin/admin/config/index') }}"><i class="material-icons">accessibility</i>Admin Manager <span class=" red darken-1 badge text-white">SA only</span></a></li>
              @endif
              <li><a href="{{ secure_url('/auction-admin/bid/report') }}"><i class="material-icons">content_paste</i>Bid Reports</a></li>
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
                      <li style="position:relative;"><a href="#" data-activates='dropdown-profile' class="dropdown-button text-black grey lighten-4"><i class="material-icons left">face</i> {{Auth::user()->email}}</a></li>
                      <li><a href="{{ secure_url('/auction-admin/logout') }}" class="text-white grey darken-4"> <i class="material-icons right">lock</i> logout</a></li>
                    </ul>
                    <ul id='dropdown-profile' class='dropdown-content' style="width:100%;top:100% !important;">
                      <li><a href="#!"><i class="material-icons" style="display:inline-block">vpn_key</i>Change Password</a></li>
                    </ul>
                    <script type="text/javascript">
                    $('.dropdown-button').dropdown({
                        inDuration: 300,
                        outDuration: 225,
                        constrainWidth: false, // Does not change width of dropdown to that of the activator
                        hover: true, // Activate on hover
                        gutter: 0, // Spacing from edge
                        belowOrigin: true, // Displays dropdown below the button
                        alignment: 'left', // Displays dropdown with edge aligned to the left of button
                        stopPropagation: false // Stops event propagation
                      }
                    );
                    </script>
                  </div>
              </nav>
            @show
            @yield('content')
          </div>
        </div>
    </body>
</html>
@endif
