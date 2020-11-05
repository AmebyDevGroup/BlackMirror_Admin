@extends('layouts.app')

@section('content')
    <h4 class="header-main">TESTOWANIE KOMUNIKACJI WEBSOCKET</h4>
    <hr>
    <div class="row dbp-p">
        <div class="col-sm-12">
            <p>
                Korzystając z poniższych przycisków można wywołać pobranie danych z zewnętrznego systemu
                a następnie przekazanie ich za pomocą WebSocket do aplikacji klienckiej (lustra)
                <a href="https://show.myblackmirror.pl" target="_blank">(Podgląd LIVE dostępny tutaj)</a>.
                <br/><br/>
                Na potrzeby testowania komunikacji zarówno po stronie panelu jak i podglądu można podejrzeć
                przesyłane obiekty.
                Tutaj będą one wyświetlane pod kafelkami z dostępnymi funkcjonalnościami natomiast na podglądzie
                można śledzić otrzymywane pakiety w konsoli developera (F12 > Console).
                <br/><br/>
                Należy jednak pamiętać, że oprócz danych wysyłanych manualnie, system w ustalonych odstępach czasu
                automatycznie przesyła dane,
                więc ilość obiektów po stronie podglądu LIVE będzie znacznie większa.
                <br/><br/>
            <div class="text-center font-weight-bolder">
                Aby zwiększyć wygodę osób testujących odpowiedź jest wyświetlana w postaci interaktywnej
                tablicy.<br>W realnej komunikacji jest to JSON.<br/><br/>
                W razie jakichkolwiek problemów bądź pytań proszę o kontakt z członkami zespołu nr 3.
            </div>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 left-side-home-outer dbp-p">
            <div class="darkblue-panel pn">
                <div class="darkblue-header">
                    <h5>Wywołanie API</h5>
                </div>
                <div class="apiscroll">
                    @foreach($features as $feature)
                        <a href="{{route('testWebsocketsData', [$feature])}}"
                           data-name="{{trans('features.'.$feature->slug)}}"
                           class="btn btn-info btn-api init-ws">{{trans('features.'.$feature->slug)}}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6 left-side-home-outer  dbp-p">
            <div class="darkblue-panel pn">
                <div class="darkblue-header">
                    <h5 id="result-name">Odpowiedź serwera</h5>
                </div>
                <h5 id="result-name"></h5>
                <div class="test-ws-loader"></div>
                <div id="result"></div>
            </div>
        </div>
    </div>

@endsection


@section('scripts-after')
    <script>
        $(document).on('click', '.init-ws', function (e) {
            e.preventDefault();
            let $el = $(this);
            $('.test-ws-loader').addClass('spinner-border text-info');
            $("#result").html('');
            $("#result-name").html('');

            $.get($el.attr('href'), function (data) {
                console.log(data);
                $("#result").html(data);
                $("#result-name").html($el.data('name'));
                $('.test-ws-loader').removeClass('spinner-border text-info');
            });
        });
    </script>
    <style> pre.sf-dump {
            color: #fff;
            background-color: transparent;
            border: none;
            max-height: 187px;
            overflow-y: auto !important;
            outline: none !important;
        }

        pre.sf-dump .sf-dump-key {
            color: #4ECDC4;
        }
    </style>
@endsection
