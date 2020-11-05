@extends('layouts.app')

@section('content')
    <h4 class="header-main">KONTAKT</h4>
    <hr>
    <div class="dbp-p">
        Nieprzerwanie pracujemy nad rozwojem projektu, więc jeżeli znalazłeś jakiś błąd lub po prostu chcesz
        o coś zapytać to skontaktuj się z nami za pomocą formularza kontaktowego poniżej lub napisz do nas na
        <a href="mailto:kontakt@myblackmirror.pl">kontakt@myblackmirror.pl</a>.
        <br/><br/>
        Postaramy się odpowiedzieć na Twoje zgłoszenie tak szybko jak będzie to możliwe.

        @if(session('flash.message'))
            <div class="alert alert-dark alert-dismissible fade show" role="alert">
                {{session('flash.message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-6">
                <form action="" method="POST" class="contact-form">
                    <div class="darkblue-panel">
                        <div class="darkblue-header">
                            <h5>Formularz kontaktowy</h5>
                        </div>
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="text" class="form-control form-control-lg zrodlo" placeholder="Imie" name="name" required>
                            </div>
                            <div class="col-sm-6">
                                <input type="email" class="form-control form-control-lg zrodlo" placeholder="Adres e-mail" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="text" class="form-control form-control-lg zrodlo" placeholder="Temat wiadomości" name="subject" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea class="form-control form-control-lg zrodlo" placeholder="Treść wiadomości..." name="message"></textarea>
                            </div>
                        </div>
                        <div class="term">
                            Wysyłając formularz wyrażam zgodę na przetwarzanie danych osobowych przez Ameby DEV Group.
                            Przyjmuję równocześnie do wiadomości, że dane będą przetwarzane w celu obsługi zgłoszenia.
                            Osoba, której dane dotyczą, ma prawo dostępu do treści swoich danych oraz prawo ich poprawiania oraz
                            wniesienia
                            sprzeciwu w przypadku przetwarzania danych w innych celach. Podanie danych jest dobrowolne, lecz
                            niezbędne do wysłania zgłoszenia.
                        </div>
                        <button type="submit" class="link savebtn">
                            <i class="fa fa-paper-plane"></i> <span> WYŚLIJ </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
