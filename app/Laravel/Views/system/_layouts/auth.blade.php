<!DOCTYPE html>
<html lang="en">
<head>
    @include('system._components.metas')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/lib/perfect-scrollbar/css/perfect-scrollbar.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/lib/material-design-icons/css/material-design-iconic-font.min.css')}}"/><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('assets/css/modified.css?v=1.1')}}" type="text/css"/>
    <style type="text/css">
      .bg-green {
        background-color: #4FB84D !important;
      }
      .text-green {
        color: #4FB84D !important;
      }
      .text-white {
        color: white !important;
      }
    </style>
  </head>
  <body class="be-splash-screen">
    @yield('content')
    <script src="{{asset('assets/lib/jquery/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/main.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/lib/bootstrap/dist/js/bootstrap.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
      	//initialize the javascript
      	App.init();
      });
      
    </script>
  </body>

</html>