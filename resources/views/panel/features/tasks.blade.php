@php
    $available_providers = [
        'microsoft' => 'Microsoft To-Do',
        'google' => 'Google Tasks',
    ];
    $current_provider = $config->data['provider']??'';
    $current_directory = $config->data['directory']??'';
@endphp
<form action="{{route('configuration.sendConfigurationForm', [$feature])}}" method="POST" class="send_configuration tasks">
    @csrf
    <div class="form-group pmd-textfield pmd-textfield-floating-label">
        <input type="hidden" name="data[provider]" value="">
        <select class="form-control zrodlo selectpicker" name="data[provider]">
            @foreach($available_providers as $provider => $provider_name)
            <option data-value="{{route('configuration.getTaskFolders',['provider'=>$provider])}}" value="{{$provider}}"
                    @if($current_provider == $provider) selected @endif>{{$provider_name}}</option>
            @endforeach
        </select>

        <div class="second-select">
            <script>
                getTasksDirectory('{{$current_directory}}')
            </script>
            <input type="hidden" name="data[directory]" value="false">
            <select class="form-control zrodlo selectpicker" name="data[directory]" disabled>
                <option>Wybierz źródło</option>
            </select>
            <div class="loader tasks">
                <div class="lds-ellipsis">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
    </div>
    <div class="config">
        <button type="submit" class="link savebtn">
            <i class="fa fa-save"></i> <span> ZAPISZ </span>
        </button>
    </div>
</form>
