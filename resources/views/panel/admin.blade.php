@extends('layouts.app')

@section('content')
    <h4 class="header-main">INFORMACJE O PROJEKCIE</h4>
    <hr>
    <section id="tests">
            <div class="alert alert-warning" role="alert">
                Komunikacja między panelem administracyjnym (serwerem) a aplikacją kliencką (lustrem) odbywa się za pomocą technologii WebSocket.
                <div class="font-weight-bolder">
                    Aby przetestować komunikację przejdź <a href="{{route('admin.getWebsocketsTest')}}">TUTAJ</a>
                </div>
            </div>
    </section>
    <section id="config">
        <form method="POST">
            @csrf
            <div class="row bg-dark py-5">
                <h2 class="info">Zaloguj się do swojego konta, by móc korzystać z opcji konfiguracji:</h2>
                <div class="col-sm-6">
{{--                    <div class="btn fblogin">Zaloguj do fb</div>--}}
                    <div class="jumbotron">
                        <img
                            src="https://www.freepnglogos.com/uploads/microsoft-logo-microsoft-symbol-meaning-history-png-14.png"
                            alt="Microsoft" class="logo">
                        @if(isset($microsoft) && count($microsoft))
                            <h4>Witaj, {{ $microsoft['userName'] }}!</h4>
                            <a href="{{route('microsoft.signout')}}" class="animated-button2">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                Wyloguj</a>
                        @else
                            <h4>Zaloguj się do swojego konta:</h4>
                            <a href="{{route('microsoft.signin')}}" class="animated-button">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                Zaloguj</a>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="jumbotron">
                        <img src="https://www.freepnglogos.com/uploads/google-logo-png-hd-11.png" alt="Google"
                             class="logo">
                        @if(isset($google) && count($google))
                            <h4>Welcome {{ $google['userName'] }}!</h4>
                            <a href="{{route('google.signout')}}" class="animated-button2">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                Wyloguj</a>
                        @else
                            <h4>Zaloguj się do swojego konta:
                            </h4>
                            <a href="{{route('google.signin')}}" class="animated-button">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                                Zaloguj</a>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="title d-flex justify-content-between">
                        <span>KONFIGURACJA</span>
                        <button class="btn-secondary2" type="submit"><i style="font-size:20px"
                                                                        class="fa">&#xf0c7;</i><span> ZAPISZ</span>
                        </button>
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex flex-wrap align-items-stretch item">
                        <label class="switch">
                            <input type="hidden" name="tasks[enabled]" value="0">
                            <input type="checkbox" name="tasks[enabled]" value="1"
                                   @if(($config['tasks']??false) && $config['tasks']->active??false) checked @endif>
                            <span class="slider"></span>
                        </label>
                        <span class="object_title">Lista zadań</span>
                        <span class="flex-grow-1"></span>
                        <div class="main-select">
                            <input type="hidden" name="tasks[provider]" value="false">
                            <select class="selectpicker" name="tasks[provider]">
                                <option value="microsoft"
                                        data-value="{{route('taskFolders',['provider'=>'microsoft'])}}"
                                        @if(($config['tasks']??false) && $config['tasks']->data['provider'] == 'microsoft') selected @endif>
                                    Microsoft To-Do
                                </option>
                                <option value="google" data-value="{{route('taskFolders',['provider'=>'google'])}}"
                                        @if(($config['tasks']??false) && $config['tasks']->data['provider'] == 'google') selected @endif>
                                    Google Tasks
                                </option>
                            </select>
                        </div>
                        <div class="second-select">
                            <input type="hidden" name="tasks[directory]" value="false">
                            <select class="selectpicker" name="tasks[directory]" disabled>
                                <option>Wybierz źródło</option>
                            </select>
                            <div class="loader tasks">
                                <div class="lds-ellipsis">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex flex-wrap align-items-stretch item">
                        <label class="switch">
                            <input type="hidden" name="calendar[enabled]" value="0">
                            <input type="checkbox" name="calendar[enabled]" value="1"
                                   @if(($config['calendar']??false) && $config['calendar']->active??false) checked @endif>
                            <span class="slider"></span>
                        </label>
                        <span class="object_title">Kalendarz</span>
                        <span class="flex-grow-1"></span>
                        <div class="main-select">
                            <select class="selectpicker" name="calendar[provider]">
                                <option value="microsoft">Microsoft Calendar</option>
                                <option value="google">Google Calendar</option>
                            </select>
                        </div>
                        {{--                        <div class="second-select">--}}
                        {{--                            <select class="selectpicker" disabled>--}}
                        {{--                                <option>Wybierz źródło</option>--}}
                        {{--                            </select>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex flex-wrap align-items-stretch item">
                        <label class="switch">
                            <input type="hidden" name="news[enabled]" value="0">
                            <input type="checkbox" name="news[enabled]" value="1"
                                   @if(($config['news']??false) && $config['news']->active??false) checked @endif>
                            <span class="slider"></span>
                        </label>
                        <span class="object_title">Wiadomości</span>
                        <span class="flex-grow-1"></span>
                        <input type="hidden" name="news[rss]" value="false">
                        <div class="main-select">
                            <select class="selectpicker" name="news[rss]">
                                @foreach($rss as $channel_url => $channel_title)
                                    <option value="{{$channel_url}}" @if(($config['news']??false)
                                        && $config['news']->data['rss'] == $channel_url)
                                    selected
                                        @php
                                            $news_selected = true;
                                        @endphp
                                        @endif>{{$channel_title}}
                                    </option>
                                @endforeach
                                <option value="-1" @if(($config['news']??false)
                                        && $config['news']->data['rss'] != '' && !($news_selected??false)) selected @endif >
                                    Inne
                                </option>
                            </select>
                        </div>
                        <div class="second-select">
                            <input type="text" class="form-control rss-input" name="news[rss]"
                                   @if(($config['news']??false)
                                        && $config['news']->data['rss'] != '' && !($news_selected??false))
                                   value="{{$config['news']->data['rss']}}" @endif disabled>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex flex-wrap align-items-stretch item">
                        <label class="switch">
                            <input type="hidden" name="weather[enabled]" value="0">
                            <input type="checkbox" name="weather[enabled]" value="1"
                                   @if(($config['weather']??false) && $config['weather']->active??false) checked @endif>
                            <span class="slider"></span>
                        </label>
                        <span class="object_title">Pogoda</span>
                        <span class="flex-grow-1"></span>
                        <div class="main-select">
                            <input type="hidden" name="weather[city]" value="false">
                            <select class="selectpicker" data-live-search="true" name="weather[city]">
                                @foreach($weather_cities as $city)
                                    <option value="{{$city['ext_id']}}"
                                            @if(($config['weather']??false) && $config['weather']->data['city'] == $city['ext_id']) selected @endif>
                                        {{$city['name']}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex flex-wrap align-items-stretch item">
                        <label class="switch">
                            <input type="hidden" name="air[enabled]" value="0">
                            <input type="checkbox" name="air[enabled]" value="1"
                                   @if(($config['air']??false) && $config['air']->active??false) checked @endif>
                            <span class="slider"></span>
                        </label>
                        <span class="object_title">AirQuality</span>
                        <span class="flex-grow-1"></span>
                        <div class="main-select">
                            <input type="hidden" name="air[station]" value="false">
                            <select class="selectpicker" name="air[station]" data-url="{{route('air.getStations')}}"
                                    data-live-search="true" disabled>
                                <option>Wybierz miasto</option>
                            </select>
                            <div class="loader air">
                                <div class="lds-ellipsis">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="d-flex flex-wrap align-items-stretch item">
                        <label class="switch">
                            <input type="hidden" name="covid[enabled]" value="0">
                            <input type="checkbox" name="covid[enabled]" value="1"
                                   @if(($config['covid']??false) && $config['covid']->active??false) checked @endif>
                            <span class="slider"></span>
                        </label>
                        <span class="object_title">Statystyka Covid19</span>
                        <span class="flex-grow-1"></span>
                        <div class="main-select">
                            <input type="hidden" name="covid[type]" value="false">
                            <select class="selectpicker" name="covid[type]">
                                    <option value="1"
                                            @if(($config['covid']??false) && $config['covid']->data['type'] == 1) selected @endif>
                                        Globalne
                                    </option>
                                    <option value="2"
                                            @if(($config['covid']??false) && $config['covid']->data['type'] == 2) selected @endif>
                                        Polska
                                    </option>
                                    <option value="3"
                                            @if(($config['covid']??false) && $config['covid']->data['type'] == 3) selected @endif>
                                        Obie statystyki
                                    </option>
                            </select>
                            <div class="loader">
                                <div class="lds-ellipsis">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection

@section('scripts-before')
    <script>
        let config = {
            @foreach($config as $json_config)
            '{{$json_config->name}}': {
                @foreach($json_config->data as $key => $value)
                '{{$key}}': '{{$value}}',
                @endforeach
            },
            @endforeach
        }
    </script>
@endsection

@section('scripts-after')
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId            : '2234454740181521',
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v5.0'
            });
            $(document).on('click', '.fblogin', function() {
                FB.login(function(response) {
                    if (response.authResponse) {
                        console.log('Welcome!  Fetching your information.... ');
                        FB.api('/me', function(response) {
                            console.log('Good to see you, ' + response.name + '.');
                        });
                    } else {
                        console.log('User cancelled login or did not fully authorize.');
                    }
                });
            })
        };
    </script>
    <script async defer src="https://connect.facebook.net/pl_PL/sdk.js"></script>

@endsection
