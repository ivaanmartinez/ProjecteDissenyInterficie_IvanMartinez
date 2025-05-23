<x-videos-app-layout>
    <div class="container max-w-3xl mx-auto px-4">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-indigo-600">
                <h1 class="text-xl font-bold text-white">Crear Nova Sèrie</h1>
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

                <form action="{{ route('series.manage.store') }}" method="POST" enctype="multipart/form-data" data-qa="create-series-form">
                    @csrf

                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Títol</label>
                        <input type="text" name="title" id="title" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('title') }}" required data-qa="input-title">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripció</label>
                        <textarea name="description" id="description" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required data-qa="input-description">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="categories" class="block text-sm font-medium text-gray-700 mb-1">Categories (opcional)</label>
                        <select name="categories[]" id="categories" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" multiple data-qa="input-categories">
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Mantén premuda la tecla Ctrl (o Cmd en Mac) per seleccionar múltiples categories.</p>
                    </div>

                    <div class="mb-4">
                        <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Data de publicació (opcional)</label>
                        <input type="date" name="published_at" id="published_at" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('published_at') }}" data-qa="input-published_at">
                    </div>

                    <div class="mb-6">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Imatge (Opcional)</label>
                        <div class="mt-1 flex items-center">
                            <span class="inline-block h-32 w-32 rounded-md overflow-hidden bg-gray-100">
                                <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </span>
                            <div class="ml-5">
                                <input type="file" name="image" id="image" class="bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-qa="input-image">
                                <p class="text-xs text-gray-500 mt-1">Formats acceptats: JPG, PNG. Mida màxima: 2MB.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Botones del formulario con estilos específicos -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                        <a href="{{ route('series.manage.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="mr-2">×</span> Cancel·lar
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-save mr-2"></i> Crear Sèrie
                        </button>
                    </div>
                </form>
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
