@php
    $available_types = [
        1 => 'Statystyki globalne',
        2 => 'Statystyki Polski',
        3 => 'Obie statystyki',
    ];
    $current_covid_type = $config->data['type']??'';
@endphp
<form action="{{route('configuration.sendConfigurationForm', [$feature])}}" method="POST" class="send_configuration">
    @csrf
    <div class="form-group pmd-textfield pmd-textfield-floating-label">
        <input type="hidden" name="data[type]" value="false">
        <select class="form-control zrodlo selectpicker" name="data[type]">
            @foreach($available_types as $value => $type)
            <option value="{{$value}}"
                    @if($current_covid_type == $value) selected @endif>
                {{$type}}
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
