@php
$items = [
    ["route"=>"docente.dashboard", "label"=>"Dashboard",   "icon"=>"grid"],
    ["route"=>"docente.materias",  "label"=>"Mis materias","icon"=>"book"],
    ["route"=>"#",                 "label"=>"Agente IA",   "icon"=>"cpu"],
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
