<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Manual BlackMirror</title>
    <meta name="author" content="WerVa" />
    <meta name="Resource-type" content="Document" />

    <link rel="stylesheet" type="text/css" href="{{asset('css/fullpage.min.css')}}" />
{{--    <link rel="stylesheet" type="text/css" href="examples.css" />--}}
    <style>

        /* Style for our header texts
        * --------------------------------------- */
        h1{
            font-size: 5em;
            font-family: 'Montserrat', Arial, sans-serif;
            color: #fff;
            margin:0;
            text-transform: uppercase;
        }
        .intro p{
            color: #00D7C3;
            font-size:2em;
        }

        h2 {
            font-size: 4em;
            text-transform: uppercase;
            font-family: 'Montserrat', Arial, sans-serif;
            color: #000;
            margin: 0;
        }
        .slide p{
            color: #000;
            font-size:1.5em;
        }
        /* Centered texts in each section
        * --------------------------------------- */
        .section{
            text-align:center;
        }
        .accordion {
            color: #000;
            cursor: pointer;
            padding: 1.3em;
            width: 100%;
            border: 1px solid black;
            text-align: left;
            outline: none;
            font-size: 1em;
            transition: 0.4s;
            background-color:#00D7C3;
        }

        .panel {
            padding: 0 1.3em;
            display: none;
            background-color: white;
            overflow: hidden;
            border: 1px solid black;
        }
        .panel p
        {
            color:#000;
            font-size:1.2em;
        }
        ul
        {
           list-style: none;
            font-size:1.2em;
        }
        .wrap {
            width: 500px;
            height: 800px;
            padding: 0;
            overflow: hidden;
            margin: auto;
        }
        .frame {
            width: 1050px;
            height: 1680px;
            border: 0;
            -ms-transform: scale(0.5);
            -moz-transform: scale(0.5);
            -o-transform: scale(0.5);
            -webkit-transform: scale(0.5);
            transform: scale(0.5);

            -ms-transform-origin: 0 0;
            -moz-transform-origin: 0 0;
            -o-transform-origin: 0 0;
            -webkit-transform-origin: 0 0;
            transform-origin: 0 0;
        }
        a
        {
            text-decoration: none;
            color: white;
        }
    </style>

    <!--[if IE]>
    <script type="text/javascript">
        var console = { log: function() {} };
    </script>
    <![endif]-->
</head>
<body>

<div id="fullpage">
    <div class="section " id="section0">
        <div class="intro">
            <h1>Instrukcja obsługi</h1>
            <h1>BlackMirror</h1>
            <p>Poniżej najdziesz instrukcję krok po korku jak skonfigurować swoje magiczne lustro oraz jak go używac!</p>
        </div>
    </div>
    <div class="section" id="section1">
        <div class="slide" id="slide1">
            <div class="intro">
                <h2>1.Podłącz lustro do prądu</h2>
                <h2>oraz włącz przyciskiem na spodzie</h2><br/>
                <img src="assets/img/switch.png"/>
            </div>
        </div>

        <div class="slide" id="slide2">
            <h2>2.Po uruchomieniu lustra podłącz je do swojego Wifi </h2>
            <p>Pobierz aplikacje BerryLan i podążaj za instrukcją w aplikacji:</p>
            <a href="https://apps.apple.com/us/app/berrylan/id1436156018"><img src="assets/img/app-store.svg" alt="App-Store"></a>
            <a href="https://play.google.com/store/apps/details?id=io.guh.berrylan"><img src="assets/img/google-play.svg" alt="GooglePlay"></a></br>
            <img src="assets/img/overview.gif" width="250em">
        </div>
        <div class="slide" id="slide3">
            <h2>3.Zaloguj do panelu klikając na obrazek</h2>
            <p>Zaloguj się do panelu konfiguracyjnego BlackMirror:</p>
            <p>Dane do logowania - Adres E-Mail: admin@admin.pl | Hasło: dupa.dupa</p><br/>
            <a href="https://blackmirror.best/login"><img src="assets/img/config.png" alt="Config"width="10%"></a>
        </div>
        <div class="slide" id="slide4">
            <h2>3.Skonfiguruj wyświetlane dane pod siebie </h2>
            <ul>
                <li>1.Zaloguj się do swojego konta Microsoft lub Google w celu korzystania z synchronizacji kalendarza oraz listy zadań</li>
                <li>2.Lista zadań pozwala na wyświetlanie swoich zadań z Microsoft Todo </li>
                <li>3.Kalendarz wyświetla zbliżające się wydarzenia w opraciu o synchronizacje z MS lub Google </li>
                <li>4.Wiadomości - możliwośc wyboru kanału RSS lub dodanie własnego, który wyświetli pobrane informacje na dole lustra </li>
                <li>5.Pogoda - pozwala na ręczne wybranie miejscowości, dla której będą wyświetlane dane pogodowe </li>
                <li>6.AirQuality - pozwala na wybranie czujnika w Twojej okolicy w celu wyświetlania informacji o jakości potwierza </li>
                <li>7.Przycisk Zapisz pozwala zapisać bierzącą konfigurację </li>
                <li>8.Przycisk synchronizuj wysyła zapisane dane do Lustra</li>
            </ul>
            <img src="assets/img/BM.png" alt="Config" width="650em">
        </div>
        <div class="slide" id="slide5">
            <h2>4.Ciesz się działającym lustrem! </h2> <br/>
            <img src="assets/img/lustro.png" width="600em">
        </div>
    </div>
    <div class="section" id="section2">
        <div class="intro">
            <h1>Najczęściej zadawane pytania:</h1></br>
            <button class="accordion"><b>Pytanie Pierwsze?</b> </button>
            <div class="panel">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>

            <button class="accordion"><b>Pytanie drugie?</b></button>
            <div class="panel">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>

            <button class="accordion"><b>Pytanie trzecie?</b></button>
            <div class="panel">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            </div>

        </div>
    </div>
    <div class="section" id="section3">
        <div class="intro">
            <h1>Podlgąd twojego lustra:</h1></br>
                <div class="wrap">
                <object class="frame"  type="text/html" data="https://transfer.spiszcz.org/"></object>
            </div>
            <a href="http://86.63.86.150/mirror/" >Kliknij tutaj </a>
        </div>
    </div>
</div>


<script type="text/javascript" src="{{asset('js/fullpage.min.js')}}"></script>
<script type="text/javascript">
    var myFullpage = new fullpage('#fullpage', {
        anchors: ['POMOC', 'INSTRUKCJA', 'FAQ', 'PODGLAD'],
        sectionsColor: ['#000000', '#00D7C3', '#000', '#000'],
        responsiveHeight: 600,
        afterResponsive: function(isResponsive){

        }
    });

</script>
<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>
</body>
</html>
