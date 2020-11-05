@extends('layouts.app')

@section('content')

    <h4 class="header-main ">POMOC</h4>
    <hr>

    <div class="card bg-transparent">

        <form method="GET" action="?"><ul class="stepper horizontal">



                <li class="step done">
                    <div class="step-title waves-effect  waves-dark">Uruchomienie</div>
                    <div class="step-content" >

                        <div class="row">
                            <div class="card-image col-6 text-right">
                                <img class="mx-auto img-uruchomienie" src="{{ asset('img/wl.png') }}" alt="Google">
                            </div>
                            <div class="col-6 text-left ">
                                <ul>
                                    <li>1. Aby uruchomić urządzenie niezbędne jest zapewnienie źródła
                                        zalsilania urządzenia.
                                    </li>
                                    <li>2. Należy włączyć lustro przyciskiem, który znajduje się przy  jego dolnej
                                        krawędzi. Patrz rysunek.
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="step-actions">
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-original">Dalej</button>
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-mobile mx-auto"><i class="fas fa-chevron-down"></i></button>

                        </div>
                    </div>
                </li>

                <li class="step active">
                    <div class="step-title waves-effect waves-dark">Połączenie WiFi</div>
                    <div class="step-content" style="">
                        <div class="step-actions">
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-mobile mx-auto"><i class="fas fa-chevron-up"></i></button>

                        </div>

                        <div class="row">
                            <div class="card-image col-6 text-right">
                                <img class="mx-auto img-berry img-fluid" src="{{ asset('img/overview.gif') }}" alt="BerrLan">
                            </div>
                            <div class="col-6">
                                <ul>
                                    <li>1. Podłącz urządzenie do swojego WiFi
                                    </li>
                                    <li>2. Pobierz aplikację BerryLan (linki dostepne poniżej), a następnie postępuj zgodnie
                                        z instrukcją
                                        aplikacji. Patrz rysunek.
                                        <div class="row">
                                            <div class="col-6 d-inline text-left">
                                                <a class="d-inline" href="https://apps.apple.com/us/app/berrylan/id1436156018">
                                                    <img src="{{ asset('img/apppp.png') }}" alt="App-Store" style="width: 35%"></a>
                                                <a class="d-inline" href="https://play.google.com/store/apps/details?id=io.guh.berrylan">
                                                    <img src="{{ asset('img/googlep.png') }}" alt="GooglePlay" style="width: 35%"></a>

                                            </div>
                                            <div class="col-6">
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="step-actions">
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-original">Dalej</button>
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-mobile"><i class="fas fa-chevron-down"></i></button>
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-original">Wstecz
                            </button>
                        </div>

                    </div>
                </li>

                <li class="step">
                    <div class="step-title waves-effect waves-dark">Korzystanie z niektórych funkcji</div>
                    <div class="step-content">
                        <div class="step-actions">
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-mobile mx-auto"><i class="fas fa-chevron-up"></i></button>

                        </div>
                        <div class="row">
                            <div class="card-image col-6 text-right">
                                <img class="img-konta" src="{{ asset('img/MG.png') }}" alt="Google">
                            </div>
                            <div class="col-6 text-left">

                                <ul>
                                    <li>1. Do korzystania z niektórzych funkcji urządzenia należy zalogować się na jedno
                                        ze swoich kont Microsoft lub Google
                                    </li>
                                    <li>2. Jeśli uzytkownik nie posiada konta, w ten czas konieczne jest jego
                                        założenie poprzez strony: <a href="https://signup.live.com/signup?wa=wsignin1.0&amp;rpsnv=13&amp;rver=7.3.6963.0&amp;wp=MBI_SSL&amp;wreply=https%3a%2f%2fwww.microsoft.com%2fpl-pl%3f%26ef_id%3dCjwKCAjwkPX0BRBKEiwA7THxiCaMi9lterJX1iLNWF4AD-azndjiylwhlpIyHxwscBAN5vSJk1r5pRoCZ3gQAvD_BwE%3aG%3as%26s_kwcid%3dAL!4249!3!232284842847!e!!g!!microsoft%26ef_id%3dCjwKCAjwkPX0BRBKEiwA7THxiCaMi9lterJX1iLNWF4AD-azndjiylwhlpIyHxwscBAN5vSJk1r5pRoCZ3gQAvD_BwE%3aG%3as%26OCID%3dAID2000001_SEM_CjwKCAjwkPX0BRBKEiwA7THxiCaMi9lterJX1iLNWF4AD-azndjiylwhlpIyHxwscBAN5vSJk1r5pRoCZ3gQAvD_BwE%3aG%3as&amp;id=74335&amp;aadredir=1&amp;contextid=7781B38E60557056&amp;bk=1587401469&amp;uiflavor=web&amp;lic=1&amp;mkt=PL-PL&amp;lc=1045&amp;uaid=0fc534b992a344e7e499950f86991172">
                                            Microsoft</a> lub <a href="https://accounts.google.com/signup/v2/webcreateaccount?flowName=GlifWebSignIn&amp;flowEntry=SignUp">Google</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="step-actions">
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-original">Dalej</button>
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-mobile"><i class="fas fa-chevron-down"></i></button>
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-original">Wstecz
                            </button>
                        </div>
                    </div>
                </li>

                <li class="step">
                    <div class="step-title waves-effect waves-dark">Menu i sterowanie</div>
                    <div class="step-content">
                        <div class="step-actions">
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-mobile mx-auto"><i class="fas fa-chevron-up"></i></button>

                        </div>
                        <div class="row">

                            <div class="card-image col-6 text-right">
                                <img src="{{ asset('img/panel-1.png') }}" class="img-menu" alt="Panel">
                            </div>

                            <div class="col-6 text-left">
                                <ul>

                                    <li>1. "Elementy na lustrze" - Dostęp do sterowania poszczególnymi elementami lustra.
                                    </li>
                                    <li>2. "Zewnętrzne konta" - Logowanie do kont w celu synchornizacji z zewnętrzynch
                                        aplikacji.
                                    </li>
                                    <li>3. "Test API" - Informacje dla programistów z wywoływanych API.
                                    </li>
                                    <li>4. "Instrukcja użytkownia" - zasady użytkowania z urządzenia.
                                    </li>
                                    <li>5. "Informacje" - Informacje ogólne dotyczące BLACKMIRROR.
                                    </li>
                                    <li>6. "Dziennik zmina" - Zawiera historię zmian wprowadzonych przez zespół BLACKMIRROR.
                                    </li>
                                    <li>7-8. Przyciski "ON/OFF" służą do aktywacji lub dezaktywacji wyświetlania
                                        poszczególnych elementów na urządzeniu.
                                    </li>
                                    <li>9. "Konfiguruj" - przycisk do dodania własnych źródeł konfiguracyjnych i
                                        zatwierdzania zmian.
                                    </li>
                                    <li>10. "COMMING SOON..." - oznaczenie elementów, które są w trakcie implementacji.</li>
                                    <li>11. Przycisk obok elementu WYLOGUJ służy zmiany trybu wyświetlania panelu pomiędzy
                                        trybem nocnym i dziennym.
                                    </li>
                                </ul>


                            </div>

                        </div>
                        <div class="step-actions">
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-original">Dalej</button>
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-mobile"><i class="fas fa-chevron-down"></i></button>
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-original">Wstecz
                            </button>
                        </div>
                    </div>
                </li>

                <li class="step">
                    <div class="step-title waves-effect waves-dark">Elementy</div>
                    <div class="step-content">
                        <div class="step-actions">
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-mobile mx-auto"><i class="fas fa-chevron-up"></i></button>

                        </div>
                        <div class="row">

                            <div class="card-image text-right col-6">
                                <img src="{{ asset('img/elementy.png') }}" class="img-elementy" alt="Google">
                            </div>
                            <div class="col-6 text-left">
                                <ul >
                                    <li>1. "STATYSTYKI COVID-19" - Wyświetla aktualne statystyki pandemi w Polsce i na
                                        świecie.
                                    </li>
                                    <li>2. "WIADOMOŚCI" - pozwala na wybór lub dodanie kanału RSS, z którego mają zostac
                                        pobrane dane, a następnie wyświetlone na ekranie.
                                    </li>
                                    <li>3. "JAKOŚĆ POWIETRZA" - pozwala na wybranie najbliższego czujnika z Twojej okolicy w
                                        celu wyświetlenia jakości powietrza.
                                    </li>
                                    <li>4. "POGODA" - pozwala na wybranie miejscowośc dla, której mają zostać wyświetlane
                                        dane pogodowe.
                                    </li>
                                    <li>5. "LISTA ZADAŃ" - wyświetla zadań z Microsoft Todo. (Niezbędne jest zalogowanie się
                                        do konta. Patrz punkt 4)
                                    </li>
                                    <li>6. "KALENDARZ" - wyświetla zbliżające się wydarzenia w oparciu o synchronizację z
                                        Microsoft lub Google.(Niezbędne jest zalogowanie się do konta. Patrz punkt 4)
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="step-actions">
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-original">Dalej</button>
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-mobile"><i class="fas fa-chevron-down"></i></button>
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-original">Wstecz
                            </button>
                        </div>
                    </div>
                </li>

                <li class="step">
                    <div class="step-title waves-effect waves-dark">KONIEC</div>
                    <div class="step-content">
                        <div class="step-actions">
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-mobile mx-auto"><i class="fas fa-chevron-up"></i></button>

                        </div>
                        <div class="row ">
                            <div class="col-12 text-center">
                                <h5>BRAWO! TWOJE LUSTRO JEST GOTOWE DO DZIAŁANIA.</h5>
                                <h6><a href="http://86.63.86.150/mirror/" target="_blank">(Podgląd LIVE dostępny tutaj)</a>
                                </h6>
                            </div>
                        </div>
                        <div class="step-actions">

                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-original">Wstecz
                            </button>

                        </div>
                    </div>
                </li>


            </ul></form>
    </div>

@endsection
