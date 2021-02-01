@extends('layouts.app')

@section('content')
    <h4 class="header-main">DZIENNIK ZMIAN</h4>
    <hr>
    <div class="dbp-p row">
        @foreach($commits as $app => $commits)
            <div class="col-12 col-sm-6 col-md-4">
                <div class="darkblue-panel">
                    <div class="darkblue-header">
                        <h5>{{ $app }}</h5>
                    </div>
                    @foreach($commits as $commit)
                        <div class="desc">
                            <div class="thumb">
                                <span class="badge bg-theme"><i class="fa fa-history"></i><muted> {{\Carbon\Carbon::parse($commit->author->date)->format('Y-m-d H:i:s')}}</muted></span>
                            </div>
                            <div class="details">
                                <a href="{{$commit->url}}">{{$commit->author->name}} {{$commit->message}}</a><br/>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        <hr class="m-15">
        <a href="https://github.com/KrzychuW/BlackMirror/commits/master" target="_blank">
            <button class="btn btn-info btn-test">Zobacz pełną historię zmian</button>
        </a>
    </div>
@endsection
