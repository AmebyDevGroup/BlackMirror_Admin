@extends('layouts.app')
@section('content')
    <h4 class="header-main">TWOJE URZĄDZENIA</h4>
    <hr>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <section id="devices" class="dbp-p">
        <div class="table-responsive">
            <table class="darkblue-panel pn devices-table">
                <thead class="darkblue-header">
                <tr>
                    <th>NAZWA</th>
                    <th colspan="2">NUMER SERYJNY</th>
                    <th>PODŚWIETLENIE</th>
                    <th>Wi-Fi</th>
                    <th>STAN</th>
                    <th colspan="2">AKCJE</th>
                </tr>
                </thead>
                <tbody>
                @foreach($devices as $device)
                    <tr class="device-row @if(!($status[$device->serial]??false)) device-off @endif {{ $device->getWiFiConnectionQuality() }}">
                        <td>{{ $device->name }}</td>
                        <td colspan="2">{{ $device->serial }}</td>
                        <td>
                            @if($status[$device->serial]??false)
                                @if($device->getBacklightStatus())
                                    <a class="ico fas fa-lightbulb light-on"
                                       href="{{ route('admin.devices.backlight', [$device->serial, 'off']) }}"></a>
                                @else
                                    <a class="ico far fa-lightbulb"
                                       href="{{ route('admin.devices.backlight', [$device->serial, 'on']) }}"></a>
                                @endif
                            @else
                                <i class="ico far fa-lightbulb"></i>
                            @endif
                        </td>
                        <td>
                            <div>
                                <svg class="wifi-power" version="1.0" xmlns="http://www.w3.org/2000/svg"
                                     width="1280.000000pt" height="1280.000000pt" viewBox="0 0 1280.000000 1280.000000"
                                     preserveAspectRatio="xMidYMid meet">
                                    <g transform="translate(0.000000,1280.000000) scale(0.100000,-0.100000)"
                                       stroke="none">
                                        <path class="wifi-3" d="M5930 10719 c-231 -10 -379 -25 -660 -65 -106 -16 -600 -112 -720
                                            -140 -126 -30 -628 -192 -915 -294 -513 -183 -1101 -488 -1615 -838 -484 -329
                                            -1045 -811 -1128 -968 -84 -161 -80 -365 10 -537 38 -73 161 -201 232 -242
                                            172 -100 356 -107 531 -21 76 38 119 73 306 245 451 415 1062 823 1617 1080
                                            391 182 1056 407 1442 490 414 88 954 141 1440 141 520 0 861 -44 1515 -195
                                            433 -100 887 -263 1312 -472 625 -307 1138 -661 1656 -1141 121 -112 202 -160
                                            315 -187 136 -33 299 -4 423 76 128 83 228 217 264 355 9 34 15 101 15 165 0
                                            127 -21 206 -74 283 -59 85 -414 407 -691 627 -765 606 -1706 1084 -2660 1353
                                            -441 124 -735 184 -1130 231 -71 8 -184 22 -250 30 -290 34 -785 44 -1235 24z"/>
                                        <path class="wifi-2" d="M6095 8609 c-219 -11 -356 -27 -570 -66 -501 -91 -760 -158 -1093
                                            -282 -733 -275 -1433 -715 -1943 -1221 -150 -149 -178 -192 -206 -323 -31
                                            -148 0 -300 88 -432 94 -141 212 -226 367 -266 95 -24 159 -24 256 1 106 27
                                            163 60 274 160 375 338 582 493 897 675 657 380 1485 605 2225 605 256 0 642
                                            -41 915 -96 801 -163 1551 -552 2186 -1134 149 -137 212 -178 316 -205 122
                                            -32 284 -12 396 47 80 43 203 161 250 239 119 202 106 454 -33 634 -44 57
                                            -323 312 -470 429 -847 679 -1878 1098 -2985 1216 -262 27 -573 34 -870 19z"/>
                                        <path class="wifi-1" d="M6145 6494 c-102 -9 -344 -45 -460 -70 -511 -109 -994 -325 -1394
                                            -624 -151 -113 -382 -320 -448 -402 -166 -206 -172 -446 -18 -678 178 -268
                                            514 -348 770 -185 28 17 104 81 170 141 149 135 223 194 344 273 305 200 624
                                            318 992 366 153 20 494 20 641 -1 392 -54 775 -218 1123 -479 39 -29 130 -107
                                            203 -174 187 -171 270 -207 452 -199 155 7 274 60 386 173 185 184 234 440
                                            128 665 -30 64 -53 92 -157 195 -472 464 -1084 789 -1752 929 -256 53 -394 68
                                            -670 71 -143 1 -282 1 -310 -1z"/>
                                        <path class="wifi-0" d="M6255 4530 c-415 -59 -769 -316 -961 -697 -145 -287 -165 -642 -53
                                            -946 157 -425 547 -746 983 -806 99 -14 273 -14 373 0 448 62 867 437 998 894
                                            56 195 56 465 0 660 -147 508 -625 881 -1150 899 -71 3 -157 1 -190 -4z"/>
                                    </g>
                                </svg>
                                @if($status[$device->serial]??false)
                                    <div class="mt-1">{{ $device->getWiFiConnectionName() }}</div>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="ico fas fa-power-off ico-power"></div>
                        </td>
                        <td colspan="2">
                            <button class="btn link" title="Zapisz"><i class="fa fa-save"></i><span> Zapisz</span>
                            </button>
                            <button class="btn link" title="Usuń" data-toggle="modal" data-target="#deleteDeviceModal"
                                    data-action="{{ route('admin.removeDevice', [$device]) }}"
                                    data-name="{{$device->name}}"
                                    data-serial="{{$device->serial}}">
                                <i class="fa fa-trash"></i><span> Usuń</span>
                            </button>
                            <a href="{{ route('admin.devices.update', [$device->serial, 'true']) }}" class="btn link"
                               title="Aktualizuj"><i
                                    class="fa fa-download"></i><span> Aktualizuj</span></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <a type="button" class="link" data-toggle="modal" data-target="#newDeviceModal"
           style="float:right;margin-right:30px;padding-top:10px;font-size:15px;">
            <i class="fa fa-plus"></i> DODAJ URZĄDZENIE
        </a>
    </section>
    <div class="modal fade" id="newDeviceModal" tabindex="-1" role="dialog"
         aria-labelledby="newDeviceModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newDeviceModalTitle">NOWE URZĄDZENIE</h5>
                </div>
                <form method="POST" action="{{ route('admin.addDevice') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Nazwa:</label>
                            <input type="text" class="form-control devi" placeholder="WPISZ NAZWĘ" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Numer seryjny:</label>
                            <input type="text" class="form-control  devi" placeholder="WPISZ SN" name="serial" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                        <button type="submit" class="btn btn-info">Zapisz</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteDeviceModal" tabindex="-1" role="dialog" aria-labelledby="deleteDeviceModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newDeviceModalTitle">USUŃ URZĄDZENIE</h5>
                </div>
                <div class="modal-body">
                    Czy na pewno chcesz usunąć urządzenie "<span class="device-name"></span>" o numerze seryjnym "<span
                        class="device-serial"></span>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                    <form action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-info">Usuń</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
