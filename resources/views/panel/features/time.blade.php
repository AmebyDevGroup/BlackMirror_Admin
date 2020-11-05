@php
    $timezones = collect(\Carbon\CarbonTimeZone::listIdentifiers())->mapToGroups(function ($value, $key) {
        $exploded = explode('/', $value);
        if($exploded[1]??false) {
            return [
                $exploded[0] => [
                    'name' => $exploded[1],
                    'offset' => \Carbon\CarbonTimeZone::instance($value)->toOffsetName()
                    ]
            ];
        }
        return [$value => [
            'name' => $value,
            'offset' => \Carbon\CarbonTimeZone::instance($value)->toOffsetName()
            ]
        ];
    })->toArray();
    /*
     * $date_formats = [
     *   'Y-m-d' => 'YYYY-MM-DD',
     *   'd-m-Y' => 'DD-MM-YYYY',
     * ];
     */
    $date_formats = [
        'Y-m-d' => 'YYYY-MM-DD',
        'd-m-Y' => 'DD-MM-YYYY',
    ];
    $time_formats = [
        'HH:mm' => 'Format 24 godzinny',
        'hh:ii A' => 'Format 12 godzinny',
    ];
    $current_timezone = $config->data['timezone']??'';
    // $current_date_format = $config->data['date-format']??'';
    $current_time_format = $config->data['time-format']??'';
@endphp

<form action="{{route('configuration.sendConfigurationForm', [$feature])}}" method="POST" class="send_configuration">
    @csrf
    <div class="form-group pmd-textfield pmd-textfield-floating-label">
        <input type="hidden" name="data[timezone]" value="false">
{{--        <label for="data[timezone]" style="margin: 15px">Strefa czasowa</label>--}}
        <select class="form-control zrodlo selectpicker" name="data[timezone]" id="data[timezone]" data-live-search="true">
            @foreach($timezones as $region => $countries)
                @if($region != 'UTC')
                <optgroup label="{{$region}}">
                @endif
                    @foreach($countries as $country)
                    <option value="{{$region.'/'.$country['name']}}"
                            @if($current_timezone == $region.'/'.$country['name']) selected @endif>
                        {{$country['name']}} ({{$country['offset']}})
                    </option>
                    @endforeach
                @if($region != 'UTC')
                </optgroup>
                @endif
            @endforeach
        </select>

{{--            <input type="hidden" name="data[date-format]" value="false">--}}
{{--            <select class="form-control zrodlo selectpicker" name="data[date-format]" id="data[date-format]">--}}
{{--                @foreach($date_formats as $date_format => $date_format_name)--}}
{{--                    <option value="{{$date_format}}"--}}
{{--                            @if($current_date_format == $date_format) selected @endif>--}}
{{--                        {{$date_format_name}}--}}
{{--                    </option>--}}
{{--                @endforeach--}}
{{--            </select>--}}

        <input type="hidden" name="data[time-format]" value="false">
        <select class="form-control zrodlo selectpicker" name="data[time-format]" id="data[time-format]">
            @foreach($time_formats as $time_format => $time_format_name)
                <option value="{{$time_format}}"
                        @if($current_time_format == $time_format) selected @endif>
                    {{$time_format_name}}
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
