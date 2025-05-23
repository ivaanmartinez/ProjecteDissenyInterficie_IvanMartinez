<x-videos-app-layout>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Vídeos</h2>
            <a href="{{ route('videos.create') }}" class="btn btn-success add-video-btn">+ Afegir Vídeo</a>
        </div>

        <div class="row">
            @foreach ($videos as $video)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card video-card" onclick="window.location='{{ route('videos.show', $video->id) }}'">
                        @php
                            preg_match("/embed\/([^?]*)/", $video->url, $matches);
                            $videoId = $matches[1] ?? null;
                            $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg" : '';
                        @endphp

                        @if ($thumbnailUrl)
                            <img class="card-img-top" src="{{ $thumbnailUrl }}" alt="Miniatura de {{ $video->title }}" style="height: 180px; object-fit: cover; border-radius: 10px; cursor: pointer;">
                        @else
                            <iframe class="card-img-top" width="560" height="315" src="{{ $video->url }}?autoplay=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen style="pointer-events: none;"></iframe>
                        @endif

                        <div class="card-body p-3">
                            <h5 class="card-title text-truncate" style="font-size: 14px; font-weight: 600;">{{ $video->title }}</h5>
                            <p class="card-text text-truncate" style="font-size: 12px; color: #606060;">{{ \Str::limit($video->description, 60) }}</p>
                            <a href="{{ route('videos.show', $video->id) }}" class="btn btn-outline-primary btn-sm video-detail-btn">Veure Detall</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .container {
            padding: 30px;
        }

        .video-card {
            display: flex;
            flex-direction: column;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .video-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
        }

        .card-img-top {
            border-radius: 12px;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .card-img-top:hover {
            transform: scale(1.05);
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 14px;
            color: #606060;
            margin-bottom: 15px;
        }

        .btn-outline-primary {
            border-color: #0069d9;
            color: #0069d9;
            font-size: 12px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: #0069d9;
            color: #fff;
        }

        .add-video-btn {
            padding: 8px 16px;
            font-size: 14px;
            text-transform: uppercase;
            border-radius: 25px;
            background-color: #28a745;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .add-video-btn:hover {
            background-color: #28a740;
            color: white;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        @media (max-width: 1200px) {
            .col-lg-3 {
                flex: 1 1 48%;
            }
        }

        @media (max-width: 992px) {
            .col-md-4 {
                flex: 1 1 48%;
            }
        }

        @media (max-width: 768px) {
            .col-sm-6 {
                flex: 1 1 48%;
            }
        }

        @media (max-width: 576px) {
            .col-sm-6 {
                flex: 1 1 100%;
            }

            .card-img-top {
                height: 160px;
            }

            .card-title {
                font-size: 13px;
            }

            .card-text {
                font-size: 11px;
            }
        }
    </style>
</x-videos-app-layout>
