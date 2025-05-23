<x-videos-app-layout>
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $video->title }}</h1>

                    @php
                        preg_match("/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^\"&?\/\s]{11})/", $video->url, $matches);
                        $videoId = $matches[1] ?? null;
                        $embedUrl = $videoId ? "https://www.youtube.com/embed/{$videoId}" : '';
                    @endphp

                    @if($embedUrl)
                        <div class="aspect-w-16 aspect-h-9 mb-6">
                            <iframe
                                src="{{ $embedUrl }}"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                class="w-full h-full rounded-lg"
                            ></iframe>
                        </div>
                    @else
                        <div class="bg-gray-100 p-8 rounded-lg text-center mb-6">
                            <i class="fas fa-film text-4xl text-gray-400 mb-4"></i>
                            <p class="text-gray-500">No s'ha pogut carregar el vídeo. Comprova que l'URL sigui correcte.</p>
                        </div>
                    @endif

                    <div class="prose max-w-none mb-4">
                        <p class="text-gray-600">{{ $video->description }}</p>
                    </div>

                    <div class="flex flex-wrap gap-1 mb-4">
                        @if(isset($video->categories) && count($video->categories) > 0)
                            @foreach($video->categories as $category)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#5a5aff]/10 text-[#5a5aff]">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                Sense categories
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-500 mb-1">Data de publicació</h3>
                            <p class="text-base font-medium">{{ \Carbon\Carbon::parse($video->published_at)->format('d/m/Y') }}</p>
                        </div>

                        @if($video->series_id)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-500 mb-1">Sèrie</h3>
                                <p class="text-base font-medium">
                                    <a href="{{ route('series.show', $video->series_id) }}" class="text-[#5a5aff] hover:text-[#4747cc]">
                                        {{ $serie->title ?? 'Veure sèrie' }}
                                    </a>
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center text-sm text-gray-500 mb-6">
                        @if(isset($video->created_at))
                            <span class="mr-4">
                                <i class="fas fa-calendar-alt mr-1"></i> {{ $video->created_at->format('d/m/Y') }}
                            </span>
                        @endif
                        @if(isset($video->user))
                            <span>
                                <i class="fas fa-user mr-1"></i> {{ $video->user->name ?? 'Usuari desconegut' }}
                            </span>
                        @endif
                    </div>

                    <!-- Navegació entre vídeos -->
                    <div class="flex justify-between items-center border-t border-gray-200 pt-6">
                        @if($video->previous)
                            <a href="{{ route('videos.show', $video->previous) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5a5aff]">
                                <i class="fas fa-arrow-left mr-2"></i> Vídeo anterior
                            </a>
                        @else
                            <div></div>
                        @endif

                        @if($video->next)
                            <a href="{{ route('videos.show', $video->next) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5a5aff]">
                                Vídeo següent <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        @else
                            <div></div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Accions d'administració -->
            @auth
                @if(auth()->id() === $video->user_id || auth()->user()->can('manage videos'))
                    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Accions d'administració</h2>
                        </div>

                        <div class="p-6">
                            <div class="flex space-x-3">
                                <a href="{{ route('videos.manage.edit', $video->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-edit mr-2"></i> Editar
                                </a>

                                <form action="{{ route('videos.manage.destroy', $video->id) }}" method="POST" onsubmit="return confirm('Estàs segur que vols esborrar aquest vídeo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <i class="fas fa-trash-alt mr-2"></i> Esborrar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endauth

            <!-- Mensaje si no se encuentra el video -->
            @if(!isset($video))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                No s'ha trobat el vídeo sol·licitat.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-videos-app-layout>
