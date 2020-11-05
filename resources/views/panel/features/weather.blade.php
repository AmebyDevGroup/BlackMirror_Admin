@php
    $available_cities = App\WeatherCity::orderBy('name')->get();
    $current_weather = $config->data['city']??'';
@endphp
<form action="{{route('configuration.sendConfigurationForm', [$feature])}}" method="POST" class="send_configuration">
    @csrf
    <div class="form-group pmd-textfield pmd-textfield-floating-label">
        <input type="hidden" name="data[city]" value="">
        <select class="form-control zrodlo selectpicker" data-live-search="true" name="data[city]">
            @foreach($available_cities as $city)
                <option value="{{$city['ext_id']}}"
                        @if($current_weather == $city['ext_id']) selected @endif>
                    {{$city['name']}}
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
