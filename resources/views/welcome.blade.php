<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta property="og:title" content="BlackMirror - Inteligentne lustro">
    <meta property="og:site_name" content="BlackMirror">
    <meta property="og:url" content="https://myblackmirror.pl">
    <meta property="og:description" content="Strona Black Mirror - czyli inteligentnego lustra!">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://myblackmirror.pl/assets/img/tmb.jpg">
    <title>BlackMirror</title>
    <meta name="author" content="Ameby"/>
    <meta name="description" content="fullPage fixed full-screen backgrounds."/>
    <meta name="keywords" content="fullpage,jquery,demo,screen,fixed,fullscreen,backgrounds,full-screen"/>
    <meta name="Resource-type" content="Document"/>
    <!-- Favicon and Touch Icons
    ========================================================= -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link href="apple-touch-icon-144.png" rel="apple-touch-icon-precomposed" sizes="144x144">
    <link href="apple-touch-icon-114-precomposed.png" rel="apple-touch-icon-precomposed" sizes="114x114">
    <link href="apple-touch-icon-72-precomposed.png" rel="apple-touch-icon-precomposed" sizes="72x72">
    <link href="apple-touch-icon-57.png" rel="apple-touch-icon-precomposed">
    <link
            href="data:image/x-icon;base64,AAABAAEAEBAQAAEABAAoAQAAFgAAACgAAAAQAAAAIAAAAAEABAAAAAAAgAAAAAAAAAAAAAAAEAAAAAAAAAC7u7sAAAAAAERERACIiIgAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAEREREREREREREREREREREREREREREREREREzMzMzEREREzMDAAAxERETMzAwADERERMDMwMAMREREwAzMDAxERETAAMzAzERERMwADMwMREREwMAAzMxERETADAAMzEREREzMzMzEREREhEREREhERERIiIiIhERERERERERERHAAwAA//8AAPAPAADgBwAAwAMAAMADAADAAwAAwAMAAMADAADAAwAAwAMAAMADAADAAwAAwAMAAOAHAADwDwAA"
            rel="icon" type="image/x-icon"/>
    <!-- /Favicon
    ========================================================= -->

    <link rel="stylesheet" type="text/css" href="{{asset('css/fullpage.min.css')}}"/>
    <style>
        body {
            padding: 0;
            margin: 0;
        }

        /* Style for H1
        * --------------------------------------- */
        h1 {
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: calc(20px + 5vw);
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            text-shadow: 0 0 0.15em #1da9cc;
            user-select: none;
            white-space: nowrap;
            filter: blur(0.007em);
            margin: 0;
            padding: 0;
        }

        h1.bm {
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: calc(20px + 5vw);
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            text-shadow: 0 0 0.15em #1da9cc;
            user-select: none;
            white-space: nowrap;
            filter: blur(0.007em);
            animation: shake 2.5s linear forwards;
            margin: 0;
            padding: 0;
        }

        h1.bm span {
            position: absolute;
            left: 50;
            transform: translate(-50%, -50%);
            -webkit-clip-path: polygon(10% 0%, 44% 0%, 70% 100%, 55% 100%);
            clip-path: polygon(10% 0%, 44% 0%, 70% 100%, 55% 100%);
        }

        h1.bm::before,
        h1.bm::after {
            content: attr(data-text);
            position: absolute;
            left: 50;
        }

        h1.bm::before {
            animation: crack1 2.5s linear forwards;
            -webkit-clip-path: polygon(0% 0%, 10% 0%, 55% 100%, 0% 100%);
            clip-path: polygon(0% 0%, 10% 0%, 55% 100%, 0% 100%);
        }

        h1.bm::after {
            animation: crack2 2.5s linear forwards;
            -webkit-clip-path: polygon(44% 0%, 100% 0%, 100% 100%, 70% 100%);
            clip-path: polygon(44% 0%, 100% 0%, 100% 100%, 70% 100%);
        }

        @keyframes shake {
            5%, 15%, 25%, 35%, 55%, 65%, 75%, 95% {
                filter: blur(0.018em);
                transform: translateY(0.018em) rotate(0deg);
            }

            10%, 30%, 40%, 50%, 70%, 80%, 90% {
                filter: blur(0.01em);
                transform: translateY(-0.018em) rotate(0deg);
            }

            20%, 60% {
                filter: blur(0.03em);
                transform: translate(-0.018em, 0.018em) rotate(0deg);
            }

            45%, 85% {
                filter: blur(0.03em);
                transform: translate(0.018em, -0.018em) rotate(0deg);
            }

            100% {
                filter: blur(0.007em);
                transform: translate(0) rotate(-0.5deg);
            }
        }

        @keyframes crack1 {
            0%, 95% {
                transform: translate(-50%, -50%);
            }

            100% {
                transform: translate(-51%, -48%);
            }
        }

        @keyframes crack2 {
            0%, 95% {
                transform: translate(-50%, -50%);
            }

            100% {
                transform: translate(-49%, -53%);
            }
        }


        /* Centered texts in each section
        * --------------------------------------- */
        .section {
            text-align: center;
        }


        /* Backgrounds will cover all the section
        * --------------------------------------- */
        #section0,
        #section1,
        #section2,
        #section3,
        #slide1,
        #slide2 {
            background-size: cover;
            background-attachment: fixed;
        }

        /* Defining each sectino background and styles
        * --------------------------------------- */
        #section0 {
            background-image: url({{asset('img/bg1.jpg')}});
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        #section2 {
            background-image: url({{asset('img/bg1.jpg')}});
            padding: 6% 0 0 0;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .descrition {
            font-size: 100px;
            font-family: 'Montserrat', Arial, sans-serif;
            font-size: calc(10px + 1vw);
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            text-shadow: 0 0 0.15em #1da9cc;
            user-select: none;
            white-space: nowrap;
            filter: blur(0.007em);
            position: absolute;
            top: 50%;
            left: 50%;
            margin-right: -50%;
            transform: translate(-50%, -50%);

        }

        .button-1 {
            width: 250px;
            padding-top: 30px;
            padding-bottom: 30px;
            text-align: center;
            color: white;
            text-transform: uppercase;
            font-weight: 600;
            margin-left: 30px;
            margin-bottom: 30px;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
            background-color: #010100;
            border: 3px solid #00d7c3;
            border-radius: 50px;
            -webkit-transition: all .15s ease-in-out;
            transition: all .15s ease-in-out;
        }

        .button-1:hover {
            box-shadow: 0 0 10px 0 #00d7c3 inset, 0 0 20px 2px #00d7c3;
            border: 3px solid #00d7c3;
        }

        #fp-nav ul li a span {
            background-color: #fff;
        }

        #section01 a {
            padding-top: 60px;
            position: absolute;
            bottom: 20px;
            z-index: 2;
            display: inline-block;
            left: 50.5%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            color: #fff;
            font: normal 400 20px/1 'Josefin Sans', sans-serif;
            letter-spacing: .1em;
            text-decoration: none;
            transition: opacity .3s;
        }

        #section01 a span {
            position: absolute;
            top: 0;
            left: 50%;
            width: 30px;
            height: 30px;
            margin-left: -12px;
            border-left: 5px solid #fff;
            border-bottom: 5px solid #fff;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
            box-sizing: border-box;
        }

        #section02 a {
            padding-bottom: 60px;
            position: absolute;
            bottom: 20px;
            z-index: 2;
            display: inline-block;
            left: 50.5%;
            -webkit-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            color: #fff;
            font: normal 400 20px/1 'Josefin Sans', sans-serif;
            letter-spacing: .1em;
            text-decoration: none;
            transition: opacity .3s;
        }

        #section02 a span {
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 30px;
            height: 30px;
            margin-left: -12px;
            border-left: 5px solid #fff;
            border-bottom: 5px solid #fff;
            -webkit-transform: rotate(135deg);
            transform: rotate(135deg);
            box-sizing: border-box;
        }

        @media only screen
        and (min-device-width: 300px)
        and (max-device-width: 800px)
        and (orientation: portrait) {
            .button-1 {
                width: 100%;
                height: 100px;
                text-align: center;
                font-size: 50px;
                margin: 0 auto;
                padding-top: 70px;
            }

            .descrition2 {
                font-size: 50px;
                width: 80%;
            }

            .descrition {
                font-size: 40px;
                width: 80%;
            }

            h1 {
                font-size: 90px;
            }

            h1.bm {
                font-size: 110px;
            }
        }

    </style>

    <!--[if IE]>
    <script type="text/javascript">
        var console = {
            log: function () {
            }
        };
    </script>
    <![endif]-->
</head>
<body>

<div id="fullpage">
    <div class="section " id="section0">
        <body>
        <div class="descrition">
            <h1 class="bm" data-text="black mirror">
                <div style="opacity: 0;display: inline-block;width: 1px;transform: translate(-50%, -50%);">BLACK
                    MIRROR
                </div>
                <span>black mirror</span></h1>
            PROJEKT INTELGENTNEGO LUSTRA
            <div class="przycisk">
                </br>
                <a href="{{route('admin.getConfiguration')}}" class="button-1">LOGOWANIE</a>
            </div>
        </div>
        <script type="text/javascript" src="{{asset('js/fullpage.min.js')}}"></script>
        {{-- <script type="text/javascript" src="{{asset('js/examples.js')}}"></script> --}}

        <script type="text/javascript">
            var myFullpage = new fullpage('#fullpage', {
                verticalCentered: false,
                anchors: ['logowanie', 'autorzy'],
                navigation: true,
                navigationPosition: 'right',
                css3: false
            });
        </script>
        </body>
</html>
