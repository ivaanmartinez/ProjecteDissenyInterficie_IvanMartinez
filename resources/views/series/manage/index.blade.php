<x-videos-app-layout>
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="text-2xl font-bold mb-4 md:mb-0">Gestió de Sèries</h1>

            <!-- Botó destacat per crear sèrie -->
            <a href="{{ route('series.manage.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition-transform duration-200 hover:scale-105" data-qa="create-series">
                <i class="fas fa-plus mr-2"></i> Crear Sèrie
            </a>
        </div>

        <!-- Filtres i cerca -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <form action="{{ route('series.manage.index') }}" method="GET" class="md:flex md:items-end md:space-x-4">
                <div class="flex-1 mb-4 md:mb-0">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cerca</label>
                    <input type="text" name="search" id="search" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Títol o descripció..." value="{{ request('search') }}">
                </div>

                <div class="mb-4 md:mb-0 md:w-1/4">
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Ordenar per</label>
                    <select name="sort" id="sort" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="created_at_desc" {{ request('sort') == 'created_at_desc' ? 'selected' : '' }}>Data creació (més recent)</option>
                        <option value="created_at_asc" {{ request('sort') == 'created_at_asc' ? 'selected' : '' }}>Data creació (més antic)</option>
                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>Títol (A-Z)</option>
                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>Títol (Z-A)</option>
                    </select>
                </div>

                <div class="flex space-x-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-search mr-2"></i> Filtrar
                    </button>

                    <a href="{{ route('series.manage.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-redo mr-2"></i> Reiniciar
                    </a>
                </div>
            </form>
        </div>

        <!-- Taula de sèries -->
        @php
            $headers = [
                'id' => 'ID',
                'title' => 'TÍTOL',
                'description' => 'DESCRIPCIÓ',
                'videos_count' => 'VÍDEOS',
                'created_at' => 'DATA DE CREACIÓ',
            ];

            $formatters = [
                'description' => function($serie) {
                    return \Str::limit($serie->description, 50);
                },
                'videos_count' => function($serie) {
                    return isset($serie->videos_count) ? $serie->videos_count : (isset($serie->videos) ? count($serie->videos) : 0);
                },
                'created_at' => function($serie) {
                    return isset($serie->created_at) ? $serie->created_at->format('d/m/Y') : 'Sense data';
                },
            ];

            $actions = function($serie) {
                return '
                    <div class="flex space-x-2 justify-end">
                        <a href="'.route('series.show', $serie->id).'" class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-indigo-600 text-white hover:bg-indigo-700" data-qa="view-series-'.$serie->id.'">
                            <i class="fas fa-eye mr-1"></i> Veure
                        </a>
                        <a href="'.route('series.manage.edit', $serie->id).'" class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-yellow-600 text-white hover:bg-blue-700" data-qa="edit-series-'.$serie->id.'">
                            <i class="fas fa-edit mr-1"></i> Editar
                        </a>
                        <form action="'.route('series.manage.destroy', $serie->id).'" method="POST" class="inline" data-qa="delete-series-'.$serie->id.'">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-red-600 text-white hover:bg-red-700" onclick="return confirm(\'Estàs segur que vols eliminar aquesta sèrie? Els vídeos associats també seran desassignats.\')">
                                <i class="fas fa-trash-alt mr-1"></i> Eliminar
                            </button>
                        </form>
                    </div>
                ';
            };
        @endphp

        <x-responsive-table :headers="$headers" :formatters="$formatters" :data="$series" :actions="$actions" />

        @if($series->isEmpty())
            <div class="mt-6">
                <x-empty-state
                    type="series"
                    message="No hi ha sèries disponibles. Crea la teva primera sèrie!"
                    action="Crear Sèrie"
                    actionUrl="{{ route('series.manage.create') }}"
                />
            </div>
        @else
            <!-- Pagination -->
            @if(isset($series) && method_exists($series, 'hasPages') && $series->hasPages())
                <div class="mt-6">
                    {{ $series->appends(request()->query())->links() }}
                </div>
            @endif

            <!-- Estadístiques -->
            <div class="mt-6 bg-white rounded-lg shadow-md p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Estadístiques</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-indigo-100 p-4 rounded-lg">
                        <p class="text-sm text-gray-700">Total de sèries</p>
                        <p class="text-2xl font-bold text-indigo-700">{{ $series->total() ?? count($series) }}</p>
                    </div>
                    <div class="bg-indigo-100 p-4 rounded-lg">
                        <p class="text-sm text-gray-700">Sèries aquest mes</p>
                        <p class="text-2xl font-bold text-indigo-700">
                            {{ isset($seriesThisMonth) ? $seriesThisMonth : '0' }}
                        </p>
                    </div>
                    <div class="bg-indigo-100 p-4 rounded-lg">
                        <p class="text-sm text-gray-700">Total de vídeos</p>
                        <p class="text-2xl font-bold text-indigo-700">
                            {{ isset($totalVideos) ? $totalVideos : '0' }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-videos-app-layout>
