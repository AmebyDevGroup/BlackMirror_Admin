@extends('layouts.app')

@section('content')

    <h4 class="header-main ">POMOC</h4>
    <hr>

    <div class="card bg-transparent">

        <form method="GET" action="?">
            <ul class="stepper horizontal">


                <li class="step done">
                    <div class="step-title waves-effect  waves-dark">Uruchomienie</div>
                    <div class="step-content">

                        <div class="row">
                            <div class="card-image col-6 text-right">
                                <img class="mx-auto img-uruchomienie" src="{{ asset('img/uruchomienie.png') }}"
                                     alt="Uruchomienie">
                            </div>
                            <div class="col-6 text-left ">
                                <ul>
                                    <li>1. Aby uruchomić urządzenie niezbędne jest zapewnienie źródła
                                        zalsilania urządzenia w tym celu zaleca się użycie kabla zasilającego z wtykiem
                                        C13
                                    </li>
                                    <li>2. Należy włączyć lustro przyciskiem, który znajduje się w jego dolnej
                                        krawędzi. Patrz wizualizacje.
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="step-actions">
                            <button
                                class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-original">
                                Dalej
                            </button>
                            <button
                                class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-mobile mx-auto">
                                <i class="fas fa-chevron-down"></i></button>

                        </div>
                    </div>
                </li>

                <li class="step">
                    <div class="step-title waves-effect waves-dark">Połączenie WiFi</div>
                    <div class="step-content">
                        <div class="step-actions">
                            <button
                                class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-mobile mx-auto">
                                <i class="fas fa-chevron-up"></i></button>

                        </div>

                        <div class="row">
                            <div class="card-image col-6 text-right">
                                <img class="mx-auto img-berry img-fluid" src="{{ asset('img/overview.gif') }}"
                                     alt="BerrLan">
                            </div>
                            <div class="col-6">
                                <ul>
                                    <li>1. Podłącz urządzenie do swojego WiFi
                                    </li>
                                    <li>2. Pobierz aplikację BerryLan (linki dostepne poniżej), a następnie postępuj
                                        zgodnie
                                        z instrukcją
                                        aplikacji.
                                        <div class="row">
                                            <div class="col-6 d-inline text-left">
                                                <a class="d-inline"
                                                   href="https://apps.apple.com/us/app/berrylan/id1436156018">
                                                    <img src="{{ asset('img/apppp.png') }}" alt="App-Store"
                                                         style="width: 150px"></a>
                                                <a class="d-inline"
                                                   href="https://play.google.com/store/apps/details?id=io.guh.berrylan">
                                                    <img src="{{ asset('img/googlep.png') }}" alt="GooglePlay"
                                                         style="width: 150px"></a>

                                            </div>
                                            <div class="col-6">
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="step-actions">
                            <button
                                class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-original">
                                Dalej
                            </button>
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-mobile">
                                <i class="fas fa-chevron-down"></i></button>
                            <button
                                class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-original">
                                Wstecz
                            </button>
                        </div>

                    </div>
                </li>

                <li class="step">
                    <div class="step-title waves-effect waves-dark">Funkcjonalność dodatkowa</div>
                    <div class="step-content">
                        <div class="step-actions">
                            <button
                                class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-mobile mx-auto">
                                <i class="fas fa-chevron-up"></i></button>

                        </div>
                        <div class="row">
                            <div class="card-image col-6 text-right">
                                <img class="img-konta" src="{{ asset('img/MS.png') }}" alt="Google">
                            </div>
                            <div class="col-6 text-left">

                                <ul>
                                    <li>1. Do korzystania z funkcji kalendarza oraz listy zadań użytkownik musi
                                        zalogować się na swoje konto Microsoftu
                                    </li>
                                    <li>2. Jeśli uzytkownik nie posiada konta, może stworzyć je przez stronę:
                                        <a href="https://signup.live.com/signup?wa=wsignin1.0&amp;rpsnv=13&amp;rver=7.3.6963.0&amp;wp=MBI_SSL&amp;wreply=https%3a%2f%2fwww.microsoft.com%2fpl-pl%3f%26ef_id%3dCjwKCAjwkPX0BRBKEiwA7THxiCaMi9lterJX1iLNWF4AD-azndjiylwhlpIyHxwscBAN5vSJk1r5pRoCZ3gQAvD_BwE%3aG%3as%26s_kwcid%3dAL!4249!3!232284842847!e!!g!!microsoft%26ef_id%3dCjwKCAjwkPX0BRBKEiwA7THxiCaMi9lterJX1iLNWF4AD-azndjiylwhlpIyHxwscBAN5vSJk1r5pRoCZ3gQAvD_BwE%3aG%3as%26OCID%3dAID2000001_SEM_CjwKCAjwkPX0BRBKEiwA7THxiCaMi9lterJX1iLNWF4AD-azndjiylwhlpIyHxwscBAN5vSJk1r5pRoCZ3gQAvD_BwE%3aG%3as&amp;id=74335&amp;aadredir=1&amp;contextid=7781B38E60557056&amp;bk=1587401469&amp;uiflavor=web&amp;lic=1&amp;mkt=PL-PL&amp;lc=1045&amp;uaid=0fc534b992a344e7e499950f86991172">
                                            Microsoft</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="step-actions">
                            <button
                                class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-original">
                                Dalej
                            </button>
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-mobile">
                                <i class="fas fa-chevron-down"></i></button>
                            <button
                                class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-original">
                                Wstecz
                            </button>
                        </div>
                    </div>
                </li>

                <li class="step">
                    <div class="step-title waves-effect waves-dark">Menu i sterowanie</div>
                    <div class="step-content">
                        <div class="step-actions">
                            <button
                                class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-mobile mx-auto">
                                <i class="fas fa-chevron-up"></i></button>

                        </div>
                        <div class="row">

                            <div class="card-image col-6 text-right">
                                <img src="{{ asset('img/menu.png') }}" class="img-menu" alt="Panel">
                            </div>

                            <div class="col-6 text-left">
                                <ul>

                                    <li>1. <b>Elementy na lustrze</b> - Dostęp do sterowania poszczególnymi elementami
                                        lustra.
                                    </li>
                                    <li>2. <b>Zewnętrzne konta</b> - Logowanie do kont w celu synchornizacji z
                                        zewnętrzynch
                                        aplikacji.
                                    </li>
                                    <li>3. <b>Urządzenia</b> - Dostęp do informacji o swoich lustrach, tu też można
                                        zarządzać oświetleniem oraz aktulizacjami urządzeń.
                                    </li>
                                    <li>4. <b>Podgląd</b> - widok skonfigurowanego lustra
                                    </li>
                                    <li>5. <b>Instrukcja</b> - Instrukcja konfiguracji lustra krok po kroku
                                    </li>
                                    <li>6. <b>Informacje</b> - Informacje ogólne dotyczące <b>Black<span
                                                style="color:#4ECDC4">Mirror</span></b>
                                    </li>
                                    <li>7. <b>Dziennik zmina</b> - Zawiera historię zmian wprowadzonych przez zespół <b>Black<span
                                                style="color:#4ECDC4">Mirror</span></b>.
                                    </li>
                                    <li>8. <b>Kontakt</b> - Zakładka umożliwiająca kontakt oraz możliwość zgłaszania
                                        propozycji czy też błędów.
                                    </li>
                                    <li>9. <b>Przyciski "ON/OFF" </b> służą do aktywacji lub dezaktywacji wyświetlania
                                        poszczególnych elementów na urządzeniu.
                                    </li>
                                    <li>10. <b>Konfiguruj</b> - Przycisk umożliwiający dodatkową konfigurację danego
                                        elementu.
                                    </li>
                                    <li>11. <b>Wyloguj</b> - Przycisk wylogowujący użytkownika z panelu
                                    </li>
                                    <li>12. <b>Żarówka</b> - Przycisk umożliwiający zmianę motywu dzień/noc
                                    </li>
                                </ul>


                            </div>

                        </div>
                        <div class="step-actions">
                            <button
                                class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-original">
                                Dalej
                            </button>
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-mobile">
                                <i class="fas fa-chevron-down"></i></button>
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-original">Wstecz
                            </button>
                        </div>
                    </div>
                </li>

                <li class="step">
                    <div class="step-title waves-effect waves-dark">Elementy</div>
                    <div class="step-content">
                        <div class="step-actions">
                            <button
                                class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-mobile mx-auto">
                                <i class="fas fa-chevron-up"></i></button>

                        </div>
                        <div class="row">

                            <div class="card-image text-right col-6">
                                <img src="{{ asset('img/elementy1.png') }}" class="img-elementy" alt="Google">
                            </div>
                            <div class="col-6 text-left">
                                <ul>
                                    <li>1. <b>CZAS</b> - Wyświetla aktualną datę oraz godzinę - możliwość wyboru strefy
                                        czasowej oraz formatu wyświetlania godziny 12h lub 24h.
                                    </li>
                                    <li>2. <b>POGODA</b> - Wyświetla aktualne dane pogodowe - możliwość wyboru
                                        miejscowości.
                                    </li>
                                    <li>3. <b>CZUJNIKI WEWNĘTRZNE</b> - Wyświetla informacje o temperaturze, ciśnieniu
                                        oraz wilgotności z wbudowanego w urządzenie czujnika.
                                    </li>
                                    <li>4. <b>WIADOMOŚCI</b> - Wyświetla informacje z wybranych kanałów RSS lub podanego
                                        przez użytkownika źródła.
                                    </li>
                                    <li>5. <b>LISTA ZADAŃ</b> - Wyświetla listę zadań z Microsoft Todo. (Niezbędne jest
                                        zalogowanie się
                                        do konta. Patrz punkt 4)
                                    </li>
                                    <li>6. <b>KALENDARZ</b> - wyświetla zbliżające się wydarzenia w oparciu o
                                        synchronizację z kalendarzem
                                        Microsoft (Niezbędne jest zalogowanie się do konta. Patrz punkt 4)
                                    </li>
                                    <li>7. <b>Kamera</b> - Umożliwia wyświetlanie informacji na urządzeniu tylko po
                                        wykryciu twarzy.
                                    </li>
                                    <li>8. <b>JAKOŚĆ POWIETRZA</b> - Wyświetla informacje o jakości powietrza -
                                        możliwość wyboru czujnika z Twojej okolicy
                                    </li>
                                    <li>9. <b>STATYSTYKI COVID-19</b> - Wyświetla aktualne statystyki pandemi -
                                        możliwość wyboru statystyk z Polski lub Globalnych
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="step-actions">
                            <button
                                class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-original">
                                Dalej
                            </button>
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-mobile">
                                <i class="fas fa-chevron-down"></i></button>
                            <button
                                class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-original">
                                Wstecz
                            </button>
                        </div>
                    </div>
                </li>
                <li class="step">
                    <div class="step-title waves-effect waves-dark">Urządzenia</div>
                    <div class="step-content">
                        <div class="step-actions">
                            <button
                                class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-mobile mx-auto">
                                <i class="fas fa-chevron-up"></i></button>

                        </div>
                        <div class="row">

                            <div class="card-image text-right col-6">
                                <img src="{{ asset('img/devices.png') }}" class="img-elementy" alt="Google">
                            </div>
                            <div class="col-6 text-left">
                                <ul>
                                    <li>1. <b>NAZWA</b> - Wyświetla nazwę nadaną danemu urządzeniu.
                                    </li>
                                    <li>2. <b>NUMER SERYJNY</b> - Wyświetla numer seryjny dodanego urządzenia.
                                    </li>
                                    <li>3. <b>PODŚWIETLENIE</b> - Pozwala na włączenie podświetlenia lub wyłączenia w
                                        urządzeniu.
                                    </li>
                                    <li>4. <b>WI-FI</b> - Wyświetla jakość sygnału oraz nazwę sieci w urządzeniu.
                                    </li>
                                    <li>5. <b>STAN</b> - Wyświetla informacje o stanie włączenia użytkownika ikona biała
                                        - urządzenie włączone, ikona szara - urządzenie wyłączone lub brak łączności.
                                    </li>
                                    <li>6. <b>ZAPISZ</b>
                                    </li>
                                    <li>7. <b>USUŃ</b> - Usuwa urządzenie z profilu użytkownika.
                                    </li>
                                    <li>8. <b>AKTUALIZUJ</b> - Aktualizuje wyznaczone urządzenie.
                                    </li>
                                    <li>9. <b>DODAJ URZĄDZENIE</b> - Dodanie nowego urządzenia do profilu.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="step-actions">
                            <button
                                class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-original">
                                Dalej
                            </button>
                            <button class="waves-effect waves-dark btn-test btn-info btn btn-step next-step btn-mobile">
                                <i class="fas fa-chevron-down"></i></button>
                            <button
                                class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-original">
                                Wstecz
                            </button>
                        </div>
                    </div>
                </li>
                <li class="step">
                    <div class="step-title waves-effect waves-dark">KONIEC</div>
                    <div class="step-content">
                        <div class="step-actions">
                            <button
                                class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-mobile mx-auto">
                                <i class="fas fa-chevron-up"></i></button>

                        </div>
                        <div class="row ">
                            <div class="col-12 text-center">
                                <h5>BRAWO! TWOJE LUSTRO JEST GOTOWE DO DZIAŁANIA.</h5>
                                <h6><a href="https://myblackmirror.pl/admin/show" target="_blank">(Podgląd LIVE dostępny
                                        tutaj)</a>
                                </h6>
                            </div>
                        </div>
                        <div class="step-actions">

                            <button
                                class="waves-effect waves-dark btn-test btn-info btn btn-step previous-step btn-original">
                                Wstecz
                            </button>

                        </div>
                    </div>
                </li>


            </ul></form>
    </div>

@endsection
