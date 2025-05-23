@props(['video', 'showActions' => false])

<div class="card">
    <div class="relative h-48 bg-gray-100">
        @if(isset($video->thumbnail) && $video->thumbnail)
            <img src="{{ asset('storage/' . $video->thumbnail) }}" class="w-full h-full object-cover" alt="{{ $video->title }}">
        @else
            @php
                preg_match("/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^\"&?\/\s]{11})/", $video->url ?? '', $matches);
                $videoId = $matches[1] ?? null;
                $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg" : '';
            @endphp

            @if($thumbnailUrl)
                <img src="{{ $thumbnailUrl }}" class="w-full h-full object-cover" alt="{{ $video->title }}">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <i class="fas fa-play-circle text-4xl text-gray-400"></i>
                </div>
            @endif
        @endif
        @if(isset($video->duration))
            <div class="absolute bottom-2 right-2 bg-black bg-opacity-75 text-white text-xs px-2 py-1 rounded">
                {{ $video->duration }}
            </div>
        @endif
    </div>

    <div class="card-body">
        <h3 class="font-bold text-lg mb-2 line-clamp-1">{{ $video->title }}</h3>
        <p class="text-gray-600 text-sm mb-4 line-clamp-2 h-10">{{ Str::limit($video->description, 80) }}</p>

        <div class="flex justify-between items-center">
            <span class="text-sm text-gray-500">
                <i class="fas fa-eye mr-1"></i> {{ $video->views ?? 0 }} visualitzacions
            </span>
            <a href="{{ route('videos.show', $video->id) }}" class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-indigo-600 text-white hover:bg-indigo-700">
                <i class="fas fa-play mr-1"></i> Reproduir
            </a>
        </div>

        @if($showActions)
            <div class="mt-4 pt-4 border-t border-gray-200 flex justify-end space-x-2">
                <a href="{{ route('videos.manage.edit', $video->id) }}" class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-blue-600 text-white hover:bg-blue-700">
                    <i class="fas fa-edit mr-1"></i> Editar
                </a>
                <form action="{{ route('videos.manage.destroy', $video->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-red-600 text-white hover:bg-red-700" onclick="return confirm('Estàs segur que vols eliminar aquest vídeo?')">
                        <i class="fas fa-trash-alt mr-1"></i> Eliminar
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
