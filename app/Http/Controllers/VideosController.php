<?php

namespace App\Http\Controllers;

use App\Events\VideoCreated;
use App\Helpers\DefaultVideoHelper;
use App\Models\Serie;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Event;


class VideosController extends Controller
{
    public function index()
    {
        $videos = Video::where('user_id', Auth::id())->paginate(10);

        /** @var view-string $view */
        $view = 'videos.index';
        return view($view, compact('videos'));
    }

    public function create()
    {
        /** @var array $series */
        $series = Serie::all();
        $view = 'videos.manage.create';
        return view($view, compact('series'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|url',
        ]);

        $validated['user_id'] = Auth::id();

        $video = Video::create($validated);

        Event::dispatch(new VideoCreated($video)); // Use Laravel's Event facade
        return redirect()->route('videos.index')->with('success', 'Video created successfully.');
    }

    public function edit($id) // Cambia Video $video por $id
    {
        $video = Video::findOrFail($id); // Busca el video o devuelve 404
        $series = Serie::all();
        return view('videos.manage.edit', compact('video'), compact('series'));
    }

    public function update(Request $request, Video $video)
    {
        $this->authorize('update', $video);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|url',
        ]);

        $video->update($validated);

        return redirect()->route('videos.index')->with('success', 'Video updated successfully.');
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return redirect()->route('videos.index')->with('success', 'Video deleted successfully.');
    }
    // app/Http/Controllers/VideosController.php
    public function show($id)
    {
        $video = Video::findOrFail($id); // Busca el video o devuelve 404
        return view('videos.show', compact('video'));
    }

    private function authorize(string $ability, $model = null): void
    {
        if (!Gate::allows($ability, $model)) {
            abort(403);
        }
    }

}
