@php
    $available_providers = [
        'microsoft' => 'Microsoft Calendar',
        'google' => 'Google Calendar',
    ];
    $current_provider = $config->data['provider']??'';
@endphp
<form action="{{route('configuration.sendConfigurationForm', [$feature])}}" method="POST" class="send_configuration">
    @csrf
    <div class="form-group pmd-textfield pmd-textfield-floating-label">
        <input type="hidden" name="data[provider]" value="">
        <select class="form-control zrodlo selectpicker" name="data[provider]">
            @foreach($available_providers as $provider => $provider_name)
            <option value="{{$provider}}" @if($current_provider == $provider) selected @endif>{{$provider_name}}</option>
            @endforeach
        </select>
    </div>
    <div class="config">
        <button type="submit" class="link savebtn">
            <i class="fa fa-save"></i> <span> ZAPISZ </span>
        </button>
    </div>
</form>
