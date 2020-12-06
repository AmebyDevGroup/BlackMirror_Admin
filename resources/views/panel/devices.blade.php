@extends('layouts.app')
@section('content')
    <h4 class="header-main">URZĄDZENIA</h4>
    <hr>
    <section id="devices">
        <h4 class="header-main">DODAJ URZĄDZENIE</h4>
        <div class="d-flex justify-content-center table-responsive">
            <table class="col-md-10 darkblue-panel pn">
                <thead class="darkblue-header">
                <tr>
                    <th class="w-25">NAZWA</th>
                    <th class="w-25">NUMER SERYJNY</th>
                    <th class="w-25">STAN</th>
                    <th class="w-25">AKCJA</th>
                </tr>
                </thead>
        </div>
        <tbody>
        <tr>
            <td class="w-25"><input type="text" class="form-control  devi" placeholder="WPISZ NAZWĘ" name="name"
                                    required></td>
            <td class="w-25"><input type="text" class="form-control  devi" placeholder="WPISZ SN" name="name" required>
            </td>
            <td class="w-25"><input type="checkbox" class="set-feature-active" data-toggle="toggle" data-on="ON"
                                    data-off="OFF"
                                    data-onstyle="info" data-offstyle="danger"
                                    data-href="" value="1"></td>
            <td class="w-25"><i class="fa fa-plus"></i> DODAJ</td>
        </tr>
        </tbody>
        </table>
        </div>
        <h4 class="header-main">TWOJE URZĄDZENIA</h4>
        <div class="d-flex justify-content-center table-responsive">
            <table class="col-md-10  darkblue-panel pn">
                <thead class="darkblue-header">
                <tr>
                    <th class="w-25">NAZWA</th>
                    <th class="w-25">NUMER SERYJNY</th>
                    <th class="w-25">STAN</th>
                    <th class="w-25">AKCJA</th>
                </tr>
                </thead>
        </div>
        <tbody>
        @foreach($devices as $device)
            <tr>
                <td class="w-25">{{ $device->name }}</td>
                <td class="w-25">{{ $device->serial }}</td>
                <td class="w-25"><input type="checkbox" class="set-feature-active" data-toggle="toggle" data-on="ON"
                                        data-off="OFF"
                                        data-onstyle="info" data-offstyle="danger"
                                        data-href="" value="1"></td>
                <td class="w-25"><i class="fa fa-save"></i> ZAPISZ <br><br> <i class="fa fa-trash"></i> USUN</td>
            </tr>
        @endforeach
        </tbody>
        </table>
        </div>
    </section>
@endsection
