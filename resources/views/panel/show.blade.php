@extends('layouts.app')

@section('content')
    <h4 class="header-main">PODGLĄD LUSTRA</h4>
    <hr>
    <style>
        #frame {
            -ms-zoom: 0.50
            -moz-transform: scale(0.30);
            -o-transform: scale(0.30);
            -webkit-transform: scale(0.30);
            transform: scale(0.30);


            -ms-transform-origin: top center;
            -moz-transform-origin: top center;
            -o-transform-origin: top center;
            -webkit-transform-origin: top center;
            transform-origin: top center;
            margin-bottom: -1344px;
            padding-top: 70px;
        }

        p.mobile {
            display: none
        }

        @media screen and (max-width: 940px) {
            #frame {
                display: none;
            }

            p.mobile {
                display: block;
                margin-top: 50%;
                font-size: 20px;
            }

            p.desktop {
                display: none
            }
        }
    </style>
    <center>
        <embed id="frame" src="https://show.myblackmirror.pl/show.html"
               width=1080
               height=1920
               onerror="alert('Error Loading');"
        <br>
        <a href="https://show.myblackmirror.pl" class="link savebtn">
            <p class="desktop"><i class="fa fa-expand"></i>&nbsp;&nbsp;POWIĘKSZ</p>
            <p class="mobile"><i class="fa fa-expand"></i>&nbsp;&nbsp;Kliknij aby zobaczyć podgląd</p>
        </a>
    </center>
@endsection
