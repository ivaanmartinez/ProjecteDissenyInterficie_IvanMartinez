<?php

namespace App\Http\Controllers;

use App\Models\Serie;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * Mostrar una llista de totes les sèries.
     *
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $series = Serie::all(); // Obtenim totes les sèries
        return view('series.index', compact('series'));
    }

    /**
     * Mostrar els detalls d'una sèrie específica.
     *
     * @param  int  $id
     * @return Factory|View|Application
     */
    public function show($id): Factory|View|Application
    {
        $serie = Serie::findOrFail($id); // Busquem la sèrie pel seu id
        return view('series.show', compact('serie'));
    }

    public function create(): Factory|View|Application
    {
        return view('series.create'); // Retornem la vista per crear una sèrie
    }
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'release_date' => 'required|date',
            // Afegiu altres camps segons sigui necessari
        ]);

        Serie::create($request->all()); // Creem la sèrie amb les dades del formulari

        return redirect()->route('series.index')->with('success', 'Sèrie creada correctament.'); // Redirigim a la llista de sèries
    }
}
