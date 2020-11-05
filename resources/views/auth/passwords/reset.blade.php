@extends('layouts.auth')

@section('content')
    <div class="d-flex vh-100">
        <div class="d-flex w-100 justify-content-center align-self-center">
            <div class="container">
                <div class="darkblue-panel">
                    <div class="darkblue-header">
                        <h5>{{ __('RESET HASŁA') }}</h5>
                    </div>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email"
                                   class="col-md-4 col-form-label text-md-right logtex">{{ __('Adres E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email"
                                       class="form-control formlog @error('email') is-invalid @enderror" name="email"
                                       value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                   class="col-md-4 col-form-label text-md-right logtex">{{ __('Password') }}</label>

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

                        <div class="form-group row mb-30">
                            <div class="col-md-6 offset-md-3">
                                <button type="submit" class="btn btn-zaloguj">
                                    {{ __('Zresetuj hasło') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
