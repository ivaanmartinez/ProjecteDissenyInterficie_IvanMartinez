@props(['variant' => 'primary', 'size' => 'md', 'icon' => null])

@php
    $baseClasses = 'inline-flex items-center justify-center font-bold rounded transition-all';

    $variantClasses = [
        'primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white',
        'secondary' => 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white',
        'success' => 'bg-green-500 hover:bg-green-600 text-white',
        'warning' => 'bg-yellow-500 hover:bg-yellow-600 text-dark',
        'info' => 'bg-blue-600 hover:bg-blue-700 text-white',
        'light' => 'bg-gray-100 hover:bg-gray-200 text-dark',
        'dark' => 'bg-gray-800 hover:bg-gray-900 text-white',
        'edit' => 'bg-blue-600 hover:bg-blue-700 text-white',
        'delete' => 'bg-red-600 hover:bg-red-700 text-white',
        'view' => 'bg-indigo-600 hover:bg-indigo-700 text-white',
        'cancel' => 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50',
        'create' => 'bg-indigo-600 hover:bg-indigo-700 text-white',
        'update' => 'bg-indigo-600 hover:bg-indigo-700 text-white',
    ];

    $sizeClasses = [
        'sm' => 'text-xs px-2 py-1',
        'md' => 'text-sm px-4 py-2',
        'lg' => 'text-base px-6 py-3',
        'icon' => 'h-10 w-10',
    ];

    $classes = $baseClasses . ' ' . $variantClasses[$variant] . ' ' . $sizeClasses[$size];
@endphp

<button {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <i class="fas fa-{{ $icon }} mr-2"></i>
    @endif
    {{ $slot }}
</button>
