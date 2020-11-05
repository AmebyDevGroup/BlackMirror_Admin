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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

    <!--external css-->
    <link href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/style-responsive.css')}}" rel="stylesheet">
{{--    Stepper--}}
    <link href="{{asset('css/materializer.css')}}" rel="stylesheet">
    <link href="{{asset('css/mste.css')}}" rel="stylesheet">
    <!--external burger menu-->
</head>

<body @auth @if(auth()->user()->params['page-mode']??false) class="{{auth()->user()->params['page-mode']}}"  @endif @endauth>
    <section id="container" class="{{$exception??false?'error':''}} {{Str::startsWith(request()->getPathInfo(), '/admin')?'admin':''}}">
    <!--header start-->
        @include('partials.header')
    <!--header end-->
    <!--sidebar start-->
    @if(Str::startsWith(request()->getPathInfo(), '/admin'))
        @include('partials.sidebar')
    @endif
    <!--sidebar end-->
    <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <div class="row">
                    <div class="col-lg-12 main-chart">
                        @if(session('error'))
                            <div class="alert alert-danger" role="alert">
                                <p class="mb-3">{{ session('error') }}</p>
                                @if(session('errorDetail'))
                                    <pre class="alert-pre border bg-light p-2"><code>{{ session('errorDetail') }}</code></pre>
                                @endif
                            </div>
                        @endif
                        @auth
                            @if(!auth()->user()->hasVerifiedEmail())
                                <div class="not-verified">
                                    <span>Aby w pełni korzystać z serwisu potwierdź swój adres email!</span>
                                </div>
                            @endif
                        @endauth
                        @yield('content')
                    </div>
                </div>
                <!-- /row -->
            </section>
        </section>
    <!--main content end-->
    <!--footer start-->
        @include('partials.footer')
    <!--footer end-->
    </section>
    <div aria-live="polite" aria-atomic="true"><div id="toast_container"></div></div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
{{--    <script src="{{asset('js/materialize.js')}}"></script>--}}
    <script src="{{asset('js/mstepperr.js')}}"></script>

    <script src="{{asset('lib/jquery.scrollTo.min.js')}}"></script>
    <script src="{{asset('lib/jquery.nicescroll.js')}}" type="text/javascript"></script>
    <script src="{{asset('lib/jquery.sparkline.js')}}"></script>
    <!--common script for all pages-->
    <script src="{{asset('lib/common-scripts.js')}}"></script>
    <script>
        function anyThing(destroyFeedback) {
            setTimeout(function () {
                destroyFeedback(true);
            }, 1500);
        }

        function noThing(destroyFeedback) {
            setTimeout(function () {
                destroyFeedback(true);
            }, 10000);
        }

        var stepperDiv = document.querySelector('.stepper');
        console.log(stepperDiv);
        var stepper = new Mstepperr(stepperDiv);

    </script>
@yield('scripts-after')
</body>
</html>

