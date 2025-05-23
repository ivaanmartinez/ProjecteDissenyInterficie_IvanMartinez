<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeriesManageController extends Controller
{

    public function index()
    {
        $series = Serie::orderBy('created_at', 'desc')->paginate(10);
        return view('series.manage.index', compact('series'));
    }
    public function create()
    {
        return view('series.manage.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|url',
        ]);

        $validated['user_name'] = Auth::user()->name;
        $validated['user_photo_url'] = Auth::user()->profile_photo_url ?? null;
        $validated['published_at'] = now();

        Serie::create($validated);

        return redirect()->route('series.manage.index')->with('success', 'Sèrie creada correctament.');
    }

    public function edit($id)
    {
        $serie = Serie::findOrFail($id);
        return view('series.manage.edit', compact('serie'));
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $serie = Serie::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|url',
        ]);

        $serie->update($validated);

        return redirect()->route('series.manage.index')->with('success', 'Sèrie actualitzada correctament.');
    }

    public function delete($id)
    {
        $serie = Serie::findOrFail($id);
        return view('series.manage.delete', compact('serie'));
    }

    public function destroy($id)
    {
        $serie = Serie::findOrFail($id);

        // Nul·lar l'enllaç dels vídeos abans de eliminar la sèrie
        $serie->videos()->update(['series_id' => null]);

        $serie->delete();

        return redirect()->route('series.manage.index')->with('success', 'Sèrie eliminada correctament i vídeos desvinculats.');
    }

}
