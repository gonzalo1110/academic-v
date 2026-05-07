@php
$items = [
    ["route"=>"admin.dashboard", "label"=>"Dashboard",    "icon"=>"grid"],
    ["route"=>"admin.usuarios",  "label"=>"Usuarios",     "icon"=>"users"],
    ["route"=>"#",               "label"=>"Materias",     "icon"=>"book"],
    ["route"=>"#",               "label"=>"Periodos",     "icon"=>"calendar"],
    ["route"=>"#",               "label"=>"Asignaciones", "icon"=>"link"],
    ["route"=>"#",               "label"=>"Reportes",     "icon"=>"chart"],
];
@endphp

<div class="flex flex-col space-y-1">
    @foreach($items as $item)
    <a href="{{ $item['route'] == '#' ? '#' : route($item['route']) }}"
       @if($item['route'] !== "#") wire:navigate @endif
       class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors {{ $item['route'] !== '#' && request()->routeIs($item['route'].'*') ? 'bg-blue-50 text-blue-700 font-medium border-r-4 border-blue-700' : '' }}">

        @include("layouts.nav.icon", ["name" => $item["icon"]])

        <span>{{ $item["label"] }}</span>
    </a>
    @endforeach
</div>
