@php
    $default_rss_channels = [
        'https://www.tvn24.pl/najnowsze.xml' => 'TVN24 - najnowsze',
        'https://www.tvn24.pl/wiadomosci-z-kraju,3.xml' => 'TVN24 - kraj',
        'https://www.tvn24.pl/wiadomosci-ze-swiata,2.xml' => 'TVN24 - świat',
        'https://joemonster.org/backend.php' => 'JoeMonster',
        'https://www.gazetaprawna.pl/rss.xml' => 'GazetaPrawna',
        'https://asta24.pl/feed' => 'Asta24 - powiat pilski',
        'https://www.gry-online.pl/rss/news.xml' => 'GryOnline',
    ];
    $current_rss = $config->data['rss']??'';
@endphp
<form action="{{route('configuration.sendConfigurationForm', [$feature])}}" method="POST" class="send_configuration">
    @csrf
    <input type="hidden" name="data[rss]" value="">
    <div class="form-group pmd-textfield pmd-textfield-floating-label">
        <select class="form-control zrodlo selectpicker" name="data[rss]">
            <option disabled selected>Wybierz źródło</option>
            @foreach($default_rss_channels as $channel_url => $channel_title)
                <option value="{{$channel_url}}" @if($current_rss == $channel_url)
                selected
                        @php
                            $news_selected = true;
                        @endphp
                        @endif>{{$channel_title}}
                </option>
            @endforeach
            <option value="-1" @if($current_rss != '' && !($news_selected??false)) selected @endif >
                Inne
            </option>
        </select>
    </div>
    <input type="text" class="form-control zrodlo" placeholder="Podaj własne źródło"
           name="data[rss]"
           @if($current_rss != '' && !($news_selected??false))
           value="{{$current_rss}}" @else disabled @endif>

    <div class="config">
        <button type="submit" class="link savebtn">
            <i class="fa fa-save"></i> <span> ZAPISZ </span>
        </button>
    </div>
</form>
