@extends('layouts.app')

@section('content')
<h4 class="header-main">ZEWNĘTRZNE KONTA</h4>
<hr>
<section id="external-accounts">
    <div class="row justify-content-center">
        <!-- /col-md-4 -->
        <div class="col-lg-4 col-md-6 col-sm-6 mb dbp-p">
            <div class="darkblue-panel pn">
                <div class="darkblue-header">
                    <img class="loga" src="{{asset('img/Microsoft_logo_(2012).svg')}}" alt="Microsof"/>
                </div>
                @if($microsoft)
                    <h5>Witaj {{$microsoft['userName']}}</h5>
                    <a href="{{route('microsoft.signout')}}" class="btn btn-konta">WYLOGUJ <i class="fas fas fa-sign-in-alt pl-1"></i></a>
                    <footer class="des">Po wylogowaniu utracisz synchronizację z ToDo oraz kalendarzem Microsoft</footer>
                @else
                    <a href="{{route('microsoft.signin')}}" class="btn btn-konta"> ZALOGUJ <i class="fas fas fa-sign-in-alt pl-1"></i></a>
                    <footer class="des">Logując się do konta Microsoft, uzyskasz synchronizację z todo oraz kalendarzem</footer>
                @endif
            </div>
        </div>
        <!-- /col-md-4-->
        <div class="col-lg-4 col-md-6 col-sm-6 mb dbp-p">
            <div class="darkblue-panel pn">
                <div class="darkblue-header">
                    <img class="loga" src="{{asset('img/Google_2015_logo.svg')}}" alt="Google"/>
                </div>
                <a href="{{route('google.signin')}}" class="btn btn-konta"> ZALOGUJ <i class="fas fas fa-sign-in-alt pl-1"></i></a>
                <footer class="des">Logując się do konta Google, uzyskasz synchronizację z todo oraz kalendarzem</footer>
            </div>
        </div>
        <!-- /col-md-4 -->
        <div class="col-lg-4 col-md-6 col-sm-6 mb dbp-p">
            <div class="darkblue-panel pn">
                <div class="coming">
                    <p class="com">COMING SOON ...</p>
                </div>
                <div class="darkblue-header">
                    <img class="loga" src="{{asset('img/Facebook_Logo_(2015)_light.svg')}}" alt="Facebook"/>
                </div>

                <button class="btn btn-konta" disabled>ZALOGUJ <i class="fas fas fa-sign-in-alt pl-1"></i></button>
                <footer class="des" >Logowanie z facebookiem wkrótce</footer>
            </div>
        </div>
        <!-- /col-md-4 -->
    </div>
</section>
@endsection
