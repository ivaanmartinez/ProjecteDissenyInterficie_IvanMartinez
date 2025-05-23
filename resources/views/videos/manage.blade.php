<x-videos-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">🎮 Panel de Gestió de Vídeos</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Tarjeta de Gestión de Videos -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                <div class="p-6 bg-indigo-600 text-white">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold">Vídeos</h2>
                        <i class="fas fa-film text-3xl"></i>
                    </div>
                    <p class="mt-2 text-indigo-100">Gestiona tots els vídeos de la plataforma</p>
                </div>
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-2xl font-bold text-gray-700">{{ $totalVideos ?? 0 }}</span>
                        <span class="text-sm text-gray-500">Total de vídeos</span>
                    </div>
                    <a href="{{ route('videos.manage.index') }}" class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded text-center transition-colors">
                        <i class="fas fa-list-ul mr-2"></i> Veure tots els vídeos
                    </a>
                </div>
            </div>

            <!-- Tarjeta de Crear Video -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                <div class="p-6 bg-green-600 text-white">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold">Afegir Vídeo</h2>
                        <i class="fas fa-plus-circle text-3xl"></i>
                    </div>
                    <p class="mt-2 text-green-100">Crea un nou vídeo a la plataforma</p>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-4">Afegeix un nou vídeo amb títol, descripció, URL i més detalls.</p>
                    <a href="{{ route('videos.manage.create') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center transition-colors">
                        <i class="fas fa-plus mr-2"></i> Crear nou vídeo
                    </a>
                </div>
            </div>

            <!-- Tarjeta de Estadísticas -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-lg">
                <div class="p-6 bg-blue-600 text-white">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold">Estadístiques</h2>
                        <i class="fas fa-chart-bar text-3xl"></i>
                    </div>
                    <p class="mt-2 text-blue-100">Resum d'activitat recent</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-gray-700">{{ $recentVideos ?? 0 }}</span>
                            <span class="text-sm text-gray-500">Vídeos aquest mes</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-2xl font-bold text-gray-700">{{ $totalViews ?? 0 }}</span>
                            <span class="text-sm text-gray-500">Visualitzacions</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Acciones Rápidas -->
        <h2 class="text-2xl font-bold mb-4">⚡ Accions Ràpides</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <a href="{{ route('videos.manage.create') }}" class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow flex items-center space-x-3">
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-plus text-green-600"></i>
                </div>
                <span class="font-medium">Crear vídeo</span>
            </a>

            <a href="{{ route('series.manage.index') }}" class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow flex items-center space-x-3">
                <div class="bg-purple-100 p-3 rounded-full">
                    <i class="fas fa-film text-purple-600"></i>
                </div>
                <span class="font-medium">Gestionar sèries</span>
            </a>

            <a href="{{ route('videos.index') }}" class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow flex items-center space-x-3">
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-eye text-blue-600"></i>
                </div>
                <span class="font-medium">Veure pàgina pública</span>
            </a>

            <a href="#" class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow flex items-center space-x-3">
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fas fa-cog text-yellow-600"></i>
                </div>
                <span class="font-medium">Configuració</span>
            </a>
        </div>

        <!-- Sección de Videos Recientes -->
        <h2 class="text-2xl font-bold mb-4">🕒 Vídeos Recents</h2>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Títol</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sèrie</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Accions</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recentVideosList ?? [] as $video)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @php
                                            preg_match("/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^\"&?\/\s]{11})/", $video->url, $matches);
                                            $videoId = $matches[1] ?? null;
                                            $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/{$videoId}/default.jpg" : '';
                                        @endphp

                                        @if($thumbnailUrl)
                                            <img class="h-10 w-10 rounded-md object-cover" src="{{ $thumbnailUrl }}" alt="{{ $video->title }}">
                                        @else
                                            <div class="h-10 w-10 rounded-md bg-gray-100 flex items-center justify-center">
                                                <i class="fas fa-film text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $video->title }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($video->published_at)->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-500">{{ $video->series_id ? ($series[$video->series_id] ?? 'Sèrie '.$video->series_id) : 'Sense sèrie' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('videos.show', $video->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Veure</a>
                                <a href="{{ route('videos.manage.edit', $video->id) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                No hi ha vídeos recents per mostrar.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 text-right">
                <a href="{{ route('videos.manage.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900">
                    Veure tots els vídeos <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
    </div>
</x-videos-app-layout>
