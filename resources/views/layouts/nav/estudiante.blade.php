@php
$items = [
    ["route"=>"estudiante.dashboard", "label"=>"Mi rendimiento", "icon"=>"grid"],
    ["route"=>"#",                    "label"=>"Mis notas",      "icon"=>"edit"],
    ["route"=>"#",                    "label"=>"Mi asistencia",  "icon"=>"calendar"],
    ["route"=>"#",                    "label"=>"Comunicados IA", "icon"=>"cpu"],
];
@endphp
@foreach($items as $item)
<a href="{{ $item["route"]=="#" ? "#" : route($item["route"]) }}"
   @if($item["route"]!=="#") wire:navigate @endif
   class="nav-link {{ $item["route"]!=="#" && request()->routeIs($item["route"]."*") ? "active" : "" }}">
    @include("layouts.nav.icon", ["name"=>$item["icon"]])
    {{ $item["label"] }}
</a>
@endforeach
