@extends('layouts.auth')

@section('content')
    <div class="d-flex vh-100">
        <div class="d-flex w-100 justify-content-center align-self-center">
            <div class="container">
                <div class="darkblue-panel">
                    <div class="darkblue-header">
                        <h5>{{ __('Rejestracja') }}</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-right logtex">{{ __('Imię i Nazwisko') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control formlog @error('name') is-invalid @enderror"
                                           name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right logtex">{{ __('Adres E-Mail') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control formlog @error('email') is-invalid @enderror"
                                           name="email"
                                           value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right logtex">{{ __('Hasło') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control formlog @error('password') is-invalid @enderror"
                                           name="password"
                                           required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-right logtex">{{ __('Potwierdź hasło') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control formlog"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="zaloguj">
                                    <button type="submit" class="btn btn-zaloguj">
                                        {{ __('Rejestruj') }}
                                    </button>
                                    <div class="row text-nowrap">
                                        @if (Route::has('login'))
                                            <div class="col">
                                                <a class="btn link" href="{{ route('login') }}">
                                                    {{ __('Mam już konto') }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
