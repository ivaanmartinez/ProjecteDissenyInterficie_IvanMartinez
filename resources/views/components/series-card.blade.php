@props(['serie', 'showActions' => false])

<div class="card">
    <div class="relative h-48 bg-gray-100">
        @if(isset($serie->image) && $serie->image)
            <img src="{{ asset('storage/' . $serie->image) }}" class="w-full h-full object-cover" alt="{{ $serie->title }}">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <i class="fas fa-film text-4xl text-gray-400"></i>
            </div>
        @endif
        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-4">
            <h3 class="text-white font-bold text-xl truncate">{{ $serie->title }}</h3>
        </div>
    </div>

    <div class="card-body">
        <p class="text-gray-600 text-sm mb-4 line-clamp-3 h-16">{{ Str::limit($serie->description, 100) }}</p>

        <div class="flex flex-wrap gap-1 mb-4">
            @if(isset($serie->categories) && count($serie->categories) > 0)
                @foreach($serie->categories as $category)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        {{ $category->name }}
                    </span>
                @endforeach
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                    Sense categories
                </span>
            @endif
        </div>

        <div class="flex justify-between items-center">
            <span class="text-sm text-gray-500">
                <i class="fas fa-video mr-1"></i> {{ $serie->videos_count ?? 0 }} vídeos
            </span>
            <a href="{{ route('series.show', $serie->id) }}" class="btn btn-primary">
                <i class="fas fa-play mr-1"></i> Veure sèrie
            </a>
        </div>

        @if($showActions)
            <div class="mt-4 pt-4 border-t border-gray-200 flex justify-end space-x-2">
                <a href="{{ route('series.manage.edit', $serie->id) }}" class="btn btn-secondary">
                    <i class="fas fa-edit mr-1"></i> Editar
                </a>
                <form action="{{ route('series.manage.destroy', $serie->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Estàs segur que vols eliminar aquesta sèrie?')">
                        <i class="fas fa-trash-alt mr-1"></i> Eliminar
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
