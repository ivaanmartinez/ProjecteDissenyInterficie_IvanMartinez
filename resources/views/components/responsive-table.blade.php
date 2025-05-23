@props(['headers', 'data', 'actions' => null, 'formatters' => []])

<div class="overflow-hidden">
    <!-- Desktop Table -->
    <div class="hidden md:block overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-indigo-600 text-white">
            <tr>
                @foreach($headers as $key => $header)
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                        {{ $header }}
                    </th>
                @endforeach
                @if($actions)
                    <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">
                        ACCIONS
                    </th>
                @endif
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @forelse($data as $item)
                <tr class="hover:bg-gray-50">
                    @foreach($headers as $key => $header)
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            @if(isset($formatters[$key]))
                                {!! $formatters[$key]($item) !!}
                            @else
                                {!! $item->{$key} ?? $item[$key] ?? '-' !!}
                            @endif
                        </td>
                    @endforeach

                    @if($actions)
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            {!! $actions($item) !!}
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($headers) + ($actions ? 1 : 0) }}" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                        No hi ha elements per mostrar.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile List -->
    <div class="md:hidden space-y-4">
        @forelse($data as $item)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @foreach($headers as $key => $header)
                    <div class="p-3 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                        <div class="text-sm font-medium text-gray-700">{{ $header }}</div>
                        <div class="mt-1 text-sm text-gray-900">
                            @if(isset($formatters[$key]))
                                {!! $formatters[$key]($item) !!}
                            @else
                                {!! $item->{$key} ?? $item[$key] ?? '-' !!}
                            @endif
                        </div>
                    </div>
                @endforeach

                @if($actions)
                    <div class="bg-gray-100 px-4 py-3 border-t border-gray-200">
                        {!! $actions($item) !!}
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
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
</div>
