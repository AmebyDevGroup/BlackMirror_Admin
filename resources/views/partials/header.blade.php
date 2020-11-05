<header class="header black-bg">
    @if(Str::startsWith(request()->getPathInfo(), '/admin'))
        @auth
            <div class="sidebar-toggle-box">
                <div class="fa fa-times tooltips"></div>
            </div>
        @endauth
    @endif
<!--logo start-->
    @if(Str::startsWith(request()->getPathInfo(), '/admin'))
        <a href="{{route('admin.getConfiguration')}}" class="logo"><b>Black<span>Mirror</span></b></a>
    @else
        <a href="{{url('/')}}" class="logo"><b>Black<span>Mirror</span></b></a>
    @endif

<!--logo end-->
    @auth
        <div class="d-flex flex-row-reverse bd-highlight">
            @auth
                <div onclick="setPageMode('{{route('configuration.setPageMode')}}')" class="night">
                    @if((auth()->user()->params['page-mode']??false) && auth()->user()->params['page-mode'] == 'dark-mode')
                        <div class="ico far fa-lightbulb"></div>
                    @else
                        <div class="ico fas fa-lightbulb"></div>
                    @endif
                </div>
            @endauth

            <a id="mobi" class="logout hid pull-right" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"></a>
            {{-- Ukryty formularz - NIE USUWAC --}}
            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                  style="display: none;">
                @csrf
            </form>
        </div>

    @endauth
    @guest
        @if(!request()->routeIs('login'))
            <div class="d-flex flex-row-reverse bd-highlight">
                <a class="logout pull-right" href="{{ route('login') }}">ZALOGUJ</a>
            </div>
        @endif
    @endguest

</header>

