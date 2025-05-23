@props(['header' => null, 'footer' => null, 'hover' => true])

@php
    $hoverClass = $hover ? 'hover:-translate-y-1 hover:shadow-lg' : '';
@endphp

<div {{ $attributes->merge(['class' => "bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 {$hoverClass}"]) }}>
    @if($header)
        <div class="p-4 bg-gray-50 border-b border-gray-200">
            {{ $header }}
        </div>
    @endif

    <div class="p-4">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="p-4 bg-gray-50 border-t border-gray-200">
            {{ $footer }}
        </div>
    @endif
</div>
