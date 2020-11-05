<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BlackMirror - projekt inteligentnego lustra</title>

    <!-- Favicons -->
    <link href="{{asset('img/favicon.ico')}}" rel="icon">

    <!-- Bootstrap core CSS -->
    <link href="{{asset('lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/bootstrap/css/bootstrap4-toggle.css')}}" rel="stylesheet">
    <!--external css-->
    <link href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/style-responsive.css')}}" rel="stylesheet">
    <!--external burger menu-->

</head>

<body>
    <!--header start-->
@include('partials.header')
<!--header end-->
    <!--sidebar start-->
    <!--sidebar end-->
    <!--main content start-->
                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        <p class="mb-3">{{ session('error') }}</p>
                        @if(session('errorDetail'))
                            <pre class="alert-pre border bg-light p-2"><code>{{ session('errorDetail') }}</code></pre>
                        @endif
                    </div>
                @endif

                @yield('content')
        <!-- /row -->
    <!--main content end-->
    <!--footer start-->
@include('partials.footer')
<!--footer end-->
<div aria-live="polite" aria-atomic="true">
    <div id="toast_container"></div>
</div>
<div class="base_toast d-none" role="alert" aria-live="assertive" aria-atomic="true" data-delay="5000">
    <div class="toast-header">
        <strong class="mr-auto"></strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@yield('scripts-before')
<script src="{{asset('lib/jquery/jquery.min.js')}}"></script>
<script src="{{asset('lib/bootstrap/js/bootstrap4-toggle.js')}}"></script>
<script src="{{asset('lib/bootstrap/js/bootstrap.bundle.js')}}"></script>
<script src="{{asset('lib/jquery.scrollTo.min.js')}}"></script>
<script src="{{asset('lib/jquery.nicescroll.js')}}" type="text/javascript"></script>
<script src="{{asset('lib/jquery.sparkline.js')}}"></script>
<!--common script for all pages-->
<script src="{{asset('lib/common-scripts.js')}}"></script>
@yield('scripts-after')
</body>
</html>
