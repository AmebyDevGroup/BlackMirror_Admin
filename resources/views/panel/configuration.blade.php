@extends('layouts.app')

@section('content')
    <section id="configuration">
        <div class="row justify-content-center">
            @foreach($features as $feature)
                <div class="col-lg-4 col-md-6 col-sm-6 mb dbp-p">
                    <div class="darkblue-panel pn">
                        @if($feature->active == 0)
                        <div class="coming">
                            <p class="com">COMING SOON ...</p>
                        </div>
                        @endif
                        <div class="darkblue-header">
                            <h5>{{mb_strtoupper($feature->name)}}</h5>
                        </div>

                        <img class="icon" src="{{asset($feature->icon)}}" alt="{{$feature->name}}"/>

                        <p>
                            @php
                                $checked = '';
                                if($feature->config && $feature->config->active == 1){
                                    $checked = 'checked';
                                }
                            @endphp
                            <input type="checkbox" class="set-feature-active" data-toggle="toggle" data-on="ON"
                                   data-off="OFF"
                                   data-onstyle="info" data-offstyle="danger"
                                   data-href="{{route('configuration.setActive', [$feature])}}" value="1" {{$checked}}>
                        </p>
                        <div class="config">
                            <a href="{{route('configuration.getConfigurationForm', [$feature])}}" class="link start_configuration">
                                <i class="fa fa-cogs"></i> <span> KONFIGURUJ </span>
                            </a>
                        </div>
                        <div class="feature-configuration"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
