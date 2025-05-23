@props(['type' => 'default', 'message' => null, 'icon' => null, 'action' => null, 'actionUrl' => null])

@php
    $defaultMessages = [
        'default' => 'No hi ha elements per mostrar.',
        'series' => 'No hi ha sèries disponibles.',
        'videos' => 'No hi ha vídeos disponibles.',
        'users' => 'No hi ha usuaris disponibles.',
    ];

    $defaultIcons = [
        'default' => 'fas fa-info-circle',
        'series' => 'fas fa-film',
        'videos' => 'fas fa-play-circle',
        'users' => 'fas fa-users',
    ];

    $message = $message ?? $defaultMessages[$type] ?? $defaultMessages['default'];
    $icon = $icon ?? $defaultIcons[$type] ?? $defaultIcons['default'];
@endphp

<div class="bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded-md">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="{{ $icon }} text-yellow-600"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm text-yellow-800">
                {{ $message }}
            </p>
            @if($action && $actionUrl)
                <div class="mt-4">
                    <a href="{{ $actionUrl }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ $action }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
