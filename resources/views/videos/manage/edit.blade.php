<x-videos-app-layout>
    <div class="container max-w-3xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-indigo-600">
                <h1 class="text-xl font-bold text-white">✏️ Editar Vídeo</h1>
            </div>

            <div class="p-6">
                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p class="font-bold">S'han produït errors:</p>
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('videos.manage.update', $video->id) }}" method="POST" data-qa="video-edit-form">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-6">
                        <div class="col-span-1">
                            <label for="title" class="block text-sm font-medium text-gray-700">📌 Títol</label>
                            <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('title', $video->title) }}" required>
                        </div>

                        <div class="col-span-1">
                            <label for="description" class="block text-sm font-medium text-gray-700">📝 Descripció</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $video->description) }}</textarea>
                        </div>

                        <div class="col-span-1">
                            <label for="url" class="block text-sm font-medium text-gray-700">🔗 URL</label>
                            <input type="url" name="url" id="url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('url', $video->url) }}" required>
                            <p class="mt-1 text-xs text-gray-500">Introdueix l'URL del vídeo de YouTube o una altra plataforma.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="published_at" class="block text-sm font-medium text-gray-700">📅 Data de publicació</label>
                                <input type="date" name="published_at" id="published_at" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('published_at', \Carbon\Carbon::parse($video->published_at)->format('Y-m-d')) }}" required>
                            </div>

                            <div>
                                <label for="series_id" class="block text-sm font-medium text-gray-700">🎬 Sèrie</label>
                                <select name="series_id" id="series_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">-- Cap sèrie --</option>
                                    @foreach ($series as $serie)
                                        <option value="{{ $serie->id }}" {{ old('series_id', $video->series_id) == $serie->id ? 'selected' : '' }}>{{ $serie->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="previous" class="block text-sm font-medium text-gray-700">⏪ Vídeo anterior</label>
                                <input type="text" name="previous" id="previous" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('previous', $video->previous) }}">
                                <p class="mt-1 text-xs text-gray-500">Identificador del vídeo anterior (opcional).</p>
                            </div>

                            <div>
                                <label for="next" class="block text-sm font-medium text-gray-700">⏩ Vídeo següent</label>
                                <input type="text" name="next" id="next" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('next', $video->next) }}">
                                <p class="mt-1 text-xs text-gray-500">Identificador del vídeo següent (opcional).</p>
                            </div>
                        </div>

                        <!-- Botones del formulario con estilos específicos -->
                        <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                            <a href="{{ route('videos.manage.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="mr-2">×</span> Cancel·lar
                            </a>
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-save mr-2"></i> Actualitzar Vídeo
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Vista previa del vídeo -->
        <div class="mt-8 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Vista prèvia</h2>
            </div>

            <div class="p-6">
                @php
                    preg_match("/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^\"&?\/\s]{11})/", $video->url, $matches);
                    $videoId = $matches[1] ?? null;
                    $embedUrl = $videoId ? "https://www.youtube.com/embed/{$videoId}" : '';
                @endphp

                @if ($embedUrl)
                    <div class="aspect-w-16 aspect-h-9">
                        <iframe
                            src="{{ $embedUrl }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            class="w-full h-full rounded-lg"
                        ></iframe>
                    </div>
                @else
                    <div class="bg-gray-100 p-4 rounded-lg text-center">
                        <p class="text-gray-500">No s'ha pogut generar la vista prèvia. Comprova que l'URL sigui correcte.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-videos-app-layout>
