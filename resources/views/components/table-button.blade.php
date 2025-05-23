@props(['variant' => 'primary', 'icon' => null])

@php
    $baseClasses = 'inline-flex items-center px-3 py-1 rounded-md text-xs font-medium transition-all duration-200';

    $variantClasses = [
        'primary' => 'bg-indigo-600 text-white hover:bg-indigo-700',
        'secondary' => 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        'success' => 'bg-green-500 text-white hover:bg-green-600',
        'warning' => 'bg-yellow-500 text-white hover:bg-yellow-600',
        'info' => 'bg-blue-600 text-white hover:bg-blue-700',
        'light' => 'bg-gray-100 text-gray-800 hover:bg-gray-200',
        'dark' => 'bg-gray-800 text-white hover:bg-gray-900',
        'edit' => 'bg-blue-600 text-white hover:bg-blue-700',
        'delete' => 'bg-red-600 text-white hover:bg-red-700',
        'view' => 'bg-indigo-600 text-white hover:bg-indigo-700',
    ];

    $classes = $baseClasses . ' ' . $variantClasses[$variant];
@endphp

<button {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <i class="fas fa-{{ $icon }} mr-1"></i>
    @endif
    {{ $slot }}
</button>
