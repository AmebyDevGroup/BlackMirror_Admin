@extends('layouts.auth')

@section('content')
    <div class="d-flex vh-100">
        <div class="d-flex w-100 justify-content-center align-self-center">
            <div class="container">
                <div class="darkblue-panel">
                    <div class="darkblue-header">
                        <h5>{{ __('RESET HASŁA') }}</h5>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right logtex">{{ __('Adres E-Mail') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control formlog @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-30">
                                <div class="zaloguj">
                                    <button type="submit" class="btn btn-zaloguj">
                                        {{ __('Wyślij link do zresetowania hasła') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
