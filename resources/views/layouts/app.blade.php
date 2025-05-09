
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta http-equiv=“Content-Security-Policy” content=“default-src ‘self’ gap://ready file://* *; style-src ‘self’ ‘unsafe-inline’; script-src ‘self’ ‘unsafe-inline’ ‘unsafe-eval’”/>

    <title>Makisig Rescue 3121</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">

    <link href="{{ asset('css/style.css') }}?version=1.3" rel="stylesheet">
 
    <!-- Font-Awesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:900" rel="stylesheet">
    
    <!--
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol/dist/L.Control.Locate.min.js" charset="utf-8"></script>
    -->
    
    <link rel="stylesheet" href="{{ asset('css/tingle.css') }}">
    <script src="{{ asset('js/tingle.js') }}"></script>

    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.2/build/alertify.min.js"></script>
    <!--<script src="{{ asset('js/alertify.js') }}"></script>-->
    
    <link rel="stylesheet" href="{{ asset('css/alertify.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/default.css') }}" /> 
    <!--JQUERY-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!--<script src="{{ asset('js/jquery.js') }}"></script>-->

</head>
<body class="tingle-enabled">
    <div class="grid-container">
        <div class="menu">
            @include('includes.sidebar')
        </div>
        <div class="header">

            <div id="user">
                <div class="dropdown">
                    <button onclick="myFunction()" class="dropbtn">
                        <span class="fas fa-user"></span>
                        {{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}
                        <span class="fas fa-caret-down"></span>
                    </button>
                    <div id="myDropdown" class="dropdown-content">
                        <a href="{{ url('/logout') }}"> Logout </a>
                    </div>
                </div>
            </div>
            <!--
            <div class="alerts">
                <button><span class="fas fa-bell"></span></button>
            </div>
            -->
        </div>
        <div class="main">
            @yield('content')
        </div>
    </div>
    <script>
        /* When the user clicks on the button,
        toggle between hiding and showing the dropdown content */
        function myFunction() {
          document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
          if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
              var openDropdown = dropdowns[i];
              if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
              }
            }
          }
        }

    </script>
</body>
</html>
