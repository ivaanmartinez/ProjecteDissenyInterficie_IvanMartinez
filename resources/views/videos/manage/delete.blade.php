<x-videos-app-layout>
    <div class="container max-w-3xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-red-600">
                <h1 class="text-xl font-bold text-white">⚠️ Confirmar Eliminació</h1>
            </div>

            <div class="p-6">
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                Estàs a punt d'eliminar aquest vídeo. Aquesta acció no es pot desfer.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 border border-gray-200 rounded-md mb-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-2">Informació del vídeo</h2>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Títol</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $video->title }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Descripció</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $video->description }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">URL</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <a href="{{ $video->url }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">
                                    <i class="fas fa-external-link-alt mr-1"></i> Veure vídeo
                                </a>
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Data de publicació</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($video->published_at)->format('d/m/Y') }}</dd>
                        </div>
                    </dl>
                </div>

                <form action="{{ route('videos.manage.destroy', $video->id) }}" method="POST" data-qa="video-delete-form">
                    @csrf
                    @method('DELETE')

                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('videos.manage.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-times mr-2"></i> Cancel·lar
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <i class="fas fa-trash-alt mr-2"></i> Confirmar Eliminació
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-videos-app-layout>
