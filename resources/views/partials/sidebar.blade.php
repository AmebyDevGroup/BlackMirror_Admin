@php
    $menu = [
        'admin.getConfiguration' => ['name' => 'Elementy na lustrze', 'icon' => 'fa fa-tachometer-alt'],
        'admin.getExternalAccounts' => ['name' => 'Zewnętrzne konta', 'icon' => 'fa fa-user-circle'],
        'admin.getWebsocketsTest' => ['name' => 'Test API', 'icon' => 'fa fa-cogs'],
        'admin.getHelp' => ['name' => 'Instrukcja', 'icon' => 'fa fa-book'],
        'admin.info' => ['name' => 'Informacje', 'icon' => 'fa fa-info-circle'],
        'admin.getChangelog' => ['name' => 'Dziennik zmian', 'icon' => 'fa fa-tasks'],
        'admin.contactUs' => ['name' => 'Kontakt', 'icon' => 'fa fa-envelope']
    ];
    $currentRoute = Route::currentRouteName();
@endphp
@auth
<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            @foreach($menu as $route => $info)
            <li>
                <a @if($currentRoute == $route) class="active" @endif href="{{route($route)}}">
                    <i class="{{$info['icon']}}"></i>
                    <span>{{$info['name']}}</span>
                </a>
            </li>
            @endforeach
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
@endauth
