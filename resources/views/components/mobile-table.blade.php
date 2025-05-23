@props(['headers', 'data', 'actions' => null])

<div class="block md:hidden">
    @forelse($data as $item)
        <div class="bg-white rounded-lg shadow-md mb-4 overflow-hidden">
            @foreach($headers as $key => $header)
                <div class="p-3 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                    <div class="text-sm font-medium text-gray-500">{{ $header }}</div>
                    <div class="mt-1 text-sm text-gray-900">
                        @if(is_callable($key))
                            {!! $key($item) !!}
                        @else
                            {!! $item->{$key} ?? $item[$key] ?? '-' !!}
                        @endif
                    </div>
                </div>
            @endforeach

            @if($actions)
                <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
                    {!! $actions($item) !!}
                </div>
            @endif
        </div>
    @empty
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        No hi ha elements per mostrar.
                    </p>
                </div>
            </div>
        </div>
    @endforelse
</div>
