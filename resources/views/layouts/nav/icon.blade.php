@php
    $icons = [
        'grid'     => '<rect x="2" y="2" width="5" height="5" rx="1"/><rect x="9" y="2" width="5" height="5" rx="1"/><rect x="2" y="9" width="5" height="5" rx="1"/><rect x="9" y="9" width="5" height="5" rx="1"/>',
        'book'     => '<path d="M3 2h8a1 1 0 011 1v10a1 1 0 01-1 1H3"/><path d="M3 2a1 1 0 00-1 1v10a1 1 0 001 1"/><line x1="8" y1="6" x2="11" y2="6"/><line x1="8" y1="9" x2="11" y2="9"/>',
        'edit'     => '<path d="M11 2l3 3-8 8H3v-3l8-8z"/>',
        'calendar' => '<rect x="2" y="3" width="12" height="11" rx="1"/><path d="M5 3V1M11 3V1M2 7h12"/>',
        'cpu'      => '<rect x="4" y="4" width="8" height="8" rx="1"/><path d="M6 4V2M10 4V2M6 14v-2M10 14v-2M4 6H2M4 10H2M14 6h-2M14 10h-2"/>',
        'users'    => '<circle cx="6" cy="5" r="2.5"/><path d="M1 13c0-2.5 2-4 5-4s5 1.5 5 4"/><circle cx="12" cy="5" r="2"/><path d="M12 9c1.5 0 3 .8 3 3"/>',
        'link'     => '<path d="M6 8a3 3 0 004.24 0l2-2a3 3 0 00-4.24-4.24l-1 1"/><path d="M10 8a3 3 0 00-4.24 0l-2 2a3 3 0 004.24 4.24l1-1"/>',
        'chart'    => '<path d="M2 12l4-4 3 3 5-6"/>',
    ];
    $path = $icons[$name] ?? '';
@endphp

@if($path)
    <svg xmlns="http://www.w3.org/2000/svg"
         viewBox="0 0 16 16"
         fill="none"
         stroke="currentColor"
         stroke-width="1.5"
         class="w-5 h-5 flex-shrink-0"
         style="width: 20px !important; height: 20px !important; min-width: 20px; display: inline-block;">
        {!! $path !!}
    </svg>
@endif
