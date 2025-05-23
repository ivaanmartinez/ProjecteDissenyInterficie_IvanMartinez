<x-videos-app-layout>
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <h1 class="text-2xl font-bold mb-4 md:mb-0">📹 Gestió de Vídeos</h1>

            <!-- Botó destacat per crear vídeo -->
            <a href="{{ route('videos.manage.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform transition-transform duration-200 hover:scale-105" data-qa="create-video">
                <i class="fas fa-plus mr-2"></i> Crear Vídeo
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Filtres i cerca -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <form action="{{ route('videos.manage.index') }}" method="GET" class="md:flex md:items-end md:space-x-4">
                <div class="flex-1 mb-4 md:mb-0">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cerca</label>
                    <input type="text" name="search" id="search" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Títol o descripció..." value="{{ request('search') }}">
                </div>

                <div class="mb-4 md:mb-0 md:w-1/4">
                    <label for="series_id" class="block text-sm font-medium text-gray-700 mb-1">Sèrie</label>
                    <select name="series_id" id="series_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Totes les sèries</option>
                        @foreach ($series ?? [] as $serie)
                            <option value="{{ $serie->id }}" {{ request('series_id') == $serie->id ? 'selected' : '' }}>{{ $serie->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex space-x-2">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-search mr-2"></i> Filtrar
                    </button>

                    <a href="{{ route('videos.manage.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <i class="fas fa-redo mr-2"></i> Reiniciar
                    </a>
                </div>
            </form>
        </div>

        <!-- Taula de vídeos -->
        @php
            $headers = [
                'title' => 'TÍTOL',
                'description' => 'DESCRIPCIÓ',
                'url' => 'URL',
                'published_at' => 'DATA DE PUBLICACIÓ',
                'previous' => 'ANTERIOR',
                'next' => 'SEGÜENT',
                'series_id' => 'SÈRIE',
            ];

            $formatters = [
                'description' => function($video) {
                    return \Str::limit($video->description, 50);
                },
                'url' => function($video) {
                    return '<a href="'.$video->url.'" target="_blank" class="text-indigo-600 hover:text-indigo-800"><i class="fas fa-link mr-1"></i> Enllaç</a>';
                },
                'published_at' => function($video) {
                    return \Carbon\Carbon::parse($video->published_at)->format('d-m-Y');
                },
                'previous' => function($video) {
                    return $video->previous ?? '—';
                },
                'next' => function($video) {
                    return $video->next ?? '—';
                },
                'series_id' => function($video) {
                    return $video->series_id ?? 'Sense sèrie';
                },
            ];

            $actions = function($video) {
                return '
                    <div class="flex space-x-2 justify-end">
                        <a href="'.route('videos.show', $video->id).'" class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-indigo-600 text-white hover:bg-indigo-700" data-qa="view-video-'.$video->id.'">
                            <i class="fas fa-eye mr-1"></i> Veure
                        </a>
                        <a href="'.route('videos.manage.edit', $video->id).'" class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-yellow-600 text-white hover:bg-blue-700" data-qa="edit-video-'.$video->id.'">
                            <i class="fas fa-edit mr-1"></i> Editar
                        </a>
                        <form action="'.route('videos.manage.destroy', $video->id).'" method="POST" class="inline" data-qa="delete-video-'.$video->id.'">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-red-600 text-white hover:bg-red-700" onclick="return confirm(\'Estàs segur que vols eliminar aquest vídeo?\')">
                                <i class="fas fa-trash-alt mr-1"></i> Eliminar
                            </button>
                        </form>
                    </div>
                ';
            };
        @endphp

        <x-responsive-table :headers="$headers" :formatters="$formatters" :data="$videos" :actions="$actions" />

        @if($videos->isEmpty())
            <div class="mt-6">
                <x-empty-state
                    type="videos"
                    message="No hi ha vídeos disponibles. Crea el teu primer vídeo!"
                    action="Crear Vídeo"
                    actionUrl="{{ route('videos.manage.create') }}"
                />
            </div>
        @else
            <!-- Pagination -->
            @if(isset($videos) && method_exists($videos, 'hasPages') && $videos->hasPages())
                <div class="mt-6">
                    {{ $videos->appends(request()->query())->links() }}
                </div>
            @endif
        @endif
    </div>
</x-videos-app-layout>
