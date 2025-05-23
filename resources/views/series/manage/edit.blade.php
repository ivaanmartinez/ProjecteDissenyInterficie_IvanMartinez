<x-videos-app-layout>
    <div class="container max-w-3xl mx-auto px-4">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-[#5a5aff]">
                <h1 class="text-xl font-bold text-white">Editar Sèrie: {{ $serie->title }}</h1>
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

                <form action="{{ route('series.manage.update', $serie) }}" method="POST" enctype="multipart/form-data" data-qa="edit-series-form">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Títol</label>
                        <input type="text" name="title" id="title" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#5a5aff] focus:ring-[#5a5aff]" value="{{ old('title', $serie->title) }}" required data-qa="input-title">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripció</label>
                        <textarea name="description" id="description" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#5a5aff] focus:ring-[#5a5aff]" required data-qa="input-description">{{ old('description', $serie->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="categories" class="block text-sm font-medium text-gray-700 mb-1">Categories (opcional)</label>
                        <select name="categories[]" id="categories" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#5a5aff] focus:ring-[#5a5aff]" multiple data-qa="input-categories">
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', $serie->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Mantén premuda la tecla Ctrl (o Cmd en Mac) per seleccionar múltiples categories.</p>
                    </div>

                    <div class="mb-4">
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Data de publicació (opcional)</label>
                        <input type="date" name="published_at" id="published_at" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#5a5aff] focus:ring-[#5a5aff]" value="{{ old('published_at', $serie->published_at ? (is_string($serie->published_at) ? $serie->published_at : $serie->published_at->format('Y-m-d')) : '') }}" data-qa="input-published_at">
                    </div>

                    <div class="mb-6">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Imatge (Opcional)</label>
                        <div class="mt-1 flex items-center">
                            <span class="inline-block h-32 w-32 rounded-md overflow-hidden bg-gray-100">
                                @if($serie->image)
                                    <img src="{{ asset('storage/' . $serie->image) }}" class="h-full w-full object-cover" alt="{{ $serie->title }}">
                                @else
                                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                @endif
                            </span>
                            <div class="ml-5">
                                <input type="file" name="image" id="image" class="bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#5a5aff]" data-qa="input-image">
                                <p class="text-xs text-gray-500 mt-1">Formats acceptats: JPG, PNG. Mida màxima: 2MB.</p>
                                @if($serie->image)
                                    <div class="mt-2">
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="remove_image" class="rounded border-gray-300 text-[#5a5aff] shadow-sm focus:border-[#5a5aff] focus:ring-[#5a5aff]">
                                            <span class="ml-2 text-sm text-gray-600">Eliminar imatge actual</span>
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Botones del formulario con estilos específicos -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('series.manage.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="mr-2">×</span> Cancel·lar
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-save mr-2"></i> Actualitzar Sèrie
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Secció de vídeos associats -->
        <div class="mt-8 bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Vídeos associats</h2>
            </div>

            <div class="p-6">
                @if(isset($serie->videos) && $serie->videos->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Títol</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duració</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visualitzacions</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Accions</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($serie->videos as $video)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                @if(isset($video->thumbnail) && $video->thumbnail)
                                                    <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('storage/' . $video->thumbnail) }}" alt="{{ $video->title }}">
                                                @else
                                                    <div class="h-10 w-10 rounded-md bg-gray-100 flex items-center justify-center">
                                                        <i class="fas fa-play-circle text-gray-400"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $video->title }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $video->duration ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $video->views ?? 0 }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('videos.show', $video->id) }}" class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-indigo-600 text-white hover:bg-indigo-700 mr-2">
                                            <i class="fas fa-eye mr-1"></i> Veure
                                        </a>
                                        <a href="{{ route('videos.manage.edit', $video->id) }}" class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-blue-600 text-white hover:bg-blue-700">
                                            <i class="fas fa-edit mr-1"></i> Editar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
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

                    <div class="mt-4">
                        <a href="{{ route('videos.manage.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-plus mr-2"></i> Afegir vídeo
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Mostrar vista previa de la imagen seleccionada
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image');
            if (imageInput) {
                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const preview = document.querySelector('.inline-block');
                            if (preview) {
                                preview.innerHTML = `<img src="${e.target.result}" class="h-full w-full object-cover" />`;
                            }
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
</x-videos-app-layout>
