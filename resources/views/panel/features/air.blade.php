@php
    //http://api.gios.gov.pl/pjp-api/rest/station/findAll
    $client = new GuzzleHttp\Client();
    $response = $client->request('GET', 'http://api.gios.gov.pl/pjp-api/rest/station/findAll');
    $available_stations = collect(json_decode($response->getBody()->getContents()))->sortBy('stationName');
    $current_station = $config->data['station']??'';
@endphp
<form action="{{route('configuration.sendConfigurationForm', [$feature])}}" method="POST" class="send_configuration">
    @csrf
    <div class="form-group pmd-textfield pmd-textfield-floating-label">
        <input type="hidden" name="data[station]" value="false">
        <select class="form-control zrodlo selectpicker" name="data[station]" data-live-search="true">
            <option disabled selected>Wybierz miasto</option>
            @foreach($available_stations as $station)
                <option value="{{$station->id}}" @if($current_station == $station->id) selected @endif>
                    {{$station->stationName}}
                </option>
            @endforeach
        </select>
    </div>
    <div class="config">
        <button type="submit" class="link savebtn">
            <i class="fa fa-save"></i> <span> ZAPISZ </span>
        </button>
    </div>
</form>
