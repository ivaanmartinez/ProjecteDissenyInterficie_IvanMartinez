<x-videos-app-layout>
    <div class="container mx-auto px-4">
        @if(isset($serie))
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="md:flex">
                    <div class="md:w-1/3 bg-gray-100">
                        @if(isset($serie->image) && $serie->image)
                            <img src="{{ asset('storage/' . $serie->image) }}" class="w-full h-full object-cover md:h-64 lg:h-auto" alt="{{ $serie->title }}">
                        @else
                            <div class="w-full h-64 flex items-center justify-center bg-gray-200">
                                <i class="fas fa-film text-6xl text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                    <div class="md:w-2/3 p-6">
                        <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $serie->title }}</h1>
                        <p class="text-gray-600 mb-4">{{ $serie->description }}</p>

                        <div class="flex flex-wrap gap-1 mb-4">
                            @if(isset($serie->categories) && count($serie->categories) > 0)
                                @foreach($serie->categories as $category)
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

                        <div class="flex items-center text-sm text-gray-500">
                            <span class="mr-4">
                                <i class="fas fa-calendar-alt mr-1"></i> {{ isset($serie->created_at) ? $serie->created_at->format('d/m/Y') : 'Sense data' }}
                            </span>
                            <span>
                                <i class="fas fa-user mr-1"></i> {{ isset($serie->user) ? $serie->user->name : 'Usuari desconegut' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accions d'administració -->
            @auth
                @if(auth()->id() === $serie->user_id || auth()->user()->can('manage series'))
                    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Accions d'administració</h2>
                        </div>

                        <div class="p-6">
                            <div class="flex space-x-3">
                                <a href="{{ route('series.manage.edit', $serie->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <i class="fas fa-edit mr-2"></i> Editar
                                </a>

                                <form action="{{ route('series.manage.destroy', $serie->id) }}" method="POST" onsubmit="return confirm('Estàs segur que vols esborrar aquesta sèrie?')">
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

            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <i class="fas fa-play-circle mr-2 text-[#5a5aff]"></i> Vídeos d'aquesta sèrie
            </h2>

            @if(isset($serie->videos) && $serie->videos->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($serie->videos as $video)
                        <x-video-card :video="$video" />
                    @endforeach
                </div>
            @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Aquesta sèrie encara no té vídeos associats.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            No s'ha trobat la sèrie sol·licitada.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-videos-app-layout>
