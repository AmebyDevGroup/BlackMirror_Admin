@extends('layouts.app')

@section('content')
    <h4 class="header-main">DZIENNIK ZMIAN</h4>
    <hr>
    <div class="row">
        @foreach($commits as $app => $commits)
            <div class="col-12 col-md-6 col-lg-4 dbp-p">
                <div class="darkblue-panel">
                    <div class="darkblue-header">
                        <h5>{{ $app }}</h5>
                    </div>
                    <div class="px-3 py-0">
                        @foreach($commits as $commit)
                            <div class="desc text-left">
                                <div class="thumb">
                                    <span class="badge bg-theme">
                                        <i class="fa fa-history"></i>
                                        <muted> {{\Carbon\Carbon::parse($commit->author->date)->format('Y-m-d H:i:s')}}</muted>
                                    </span>
                                </div>
                                <div class="details">
                                    <a href="{{$commit->url}}">{{$commit->message}}</a><br/>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
