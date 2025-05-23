<x-videos-app-layout>
    <div class="container">
        <h1>🎬 Totes les Sèries</h1>

        <!-- Search Bar -->
        <div class="search-bar mb-4">
            <form action="{{ route('series.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Cerca sèries..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Cercar
                    </button>
                    @if(request('search'))
                        <a href="{{ route('series.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Netejar
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Series Listing -->
        <div class="row">
            @foreach($series as $serie)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 series-card">
                        @if($serie->image)
                            <img src="{{ asset('storage/' . $serie->image) }}" class="card-img-top" alt="{{ $serie->title }}">
                        @else
                            <div class="card-img-top no-image">
                                <i class="fas fa-film"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $serie->title }}</h5>
                            <p class="card-text">{{ Str::limit($serie->description, 100) }}</p>
                            <div class="categories mb-2">
                                @if($serie->categories && count($serie->categories) > 0)
                                    @foreach($serie->categories as $category)
                                        <span class="badge bg-secondary">{{ $category->name }}</span>
                                    @endforeach
                                @else
                                    <span class="badge bg-light text-dark">Sense categories</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-transparent">
                            <a href="{{ route('series.show', $serie->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-play"></i> Veure vídeos ({{ $serie->videos_count }})
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .container {
            padding: 30px;
            max-width: 1200px;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 25px;
            text-align: center;
            color: #333;
        }

        .search-bar {
            max-width: 600px;
            margin: 0 auto;
        }

        .series-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .series-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .no-image {
            height: 200px;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 3rem;
        }

        .card-title {
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .card-text {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .badge {
            margin-right: 5px;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .card-footer {
            border-top: none;
            padding: 1rem 1.25rem;
        }

        @media (max-width: 768px) {
            .col-md-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</x-videos-app-layout>
