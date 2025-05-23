<x-videos-app-layout>
    <div class="container max-w-3xl mx-auto px-4">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-red-600">
                <h1 class="text-xl font-bold text-white">Eliminar Sèrie: {{ $serie->title }}</h1>
            </div>

            <div class="p-6">
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                Estàs a punt d'eliminar aquesta sèrie. Aquesta acció no es pot desfer.
                            </p>
                            <p class="text-sm text-red-700 mt-2">
                                <strong>Conseqüències:</strong>
                            </p>
                            <ul class="list-disc pl-5 text-sm text-red-700 mt-1">
                                <li>La sèrie serà eliminada permanentment.</li>
                                <li>Els vídeos associats a aquesta sèrie es desassignaran (no s'eliminaran).</li>
                                <li>Les categories associades a aquesta sèrie es desvincularan.</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-4 border border-gray-200 rounded-md mb-6">
                    <h2 class="text-lg font-medium text-gray-900 mb-2">Informació de la sèrie</h2>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Títol</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $serie->title }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Data de creació</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ isset($serie->created_at) ? $serie->created_at->format('d/m/Y H:i') : 'Desconeguda' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Descripció</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $serie->description }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Vídeos associats</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ isset($serie->videos) ? count($serie->videos) : 0 }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Categories</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                @if(isset($serie->categories) && count($serie->categories) > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($serie->categories as $category)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $category->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    Cap categoria
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <form action="{{ route('series.manage.destroy', $serie) }}" method="POST" data-qa="delete-series-form">
                    @csrf
                    @method('DELETE')

                    <div class="flex items-center justify-end">
                        <a href="{{ route('series.manage.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5a5aff] mr-3">
                            <i class="fas fa-arrow-left mr-2"></i> Cancel·lar
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
