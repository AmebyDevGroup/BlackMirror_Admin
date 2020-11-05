@extends('layouts.auth')

@section('content')
    <div class="d-flex vh-100">
        <div class="d-flex w-100 justify-content-center align-self-center">
            <div class="container">
                <div class="darkblue-panel">
                    <div class="darkblue-header">
                        <h5>{{ __('Panel logowania') }}</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right logtex ">{{ __('Adres E-Mail') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control formlog @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" required autocomplete="email"
                                           autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right logtex">{{ __('Hasło:') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control formlog @error('password') is-invalid @enderror"
                                           name="password"
                                           required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="zapamietaj">
                                    <input class="form-check-input" type="checkbox"
                                           name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label  " for="remember">Zapamiętaj mnie</label>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="zaloguj">
                                    <button type="submit" class="btn btn-zaloguj">{{ __('ZALOGUJ') }}</button>
                                    <div class="row text-nowrap">
                                        @if (Route::has('password.request'))
                                            <div class="col">
                                                <a class="btn link" href="{{ route('password.request') }}">
                                                    {{ __('Zapomniałem hasła') }}
                                                </a>
                                            </div>
                                        @endif
                                        @if (Route::has('register'))
                                            <div class="col">
                                                <a class="btn link" href="{{ route('register') }}">
                                                    {{ __('Utwórz konto') }}
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
