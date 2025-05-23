<?php

namespace App\Http\Controllers\Api;

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Multimedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ApiMultimediaController extends Controller
{
    public function index()
    {
        // Obtenim els fitxers multimèdia de l'usuari loguejat
        $multimedia = Multimedia::all(); // Relació amb l'usuari autenticat
        return response()->json($multimedia);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'file_name' => 'required|string|max:255',
            'file_type' => 'required|string|max:50',
            'mime_type' => 'required|string|max:50',
        ]);

        $file = $request->file('file');
        $user = auth()->user();

        if (!$file) {
            return response()->json(['message' => 'No file uploaded'], 400);
        }

        $path = $file->store('multimedia', 'public');

        $fileName = $file->getClientOriginalName();
        $fileType = $file->getClientOriginalExtension();
        $mimeType = $file->getMimeType();

        $multimedia = new Multimedia();
        $multimedia->file_name = $fileName;
        $multimedia->file_type = $fileType;
        $multimedia->mime_type = $mimeType;
        $multimedia->file_path = $path;
        $multimedia->user_id = $user->id;
        $multimedia->save();

        return response()->json([
            'message' => 'Fitxer pujat correctament',
            'multimedia' => $multimedia
        ]);
    }


    public function show($userId)
    {
        // Obtenim tots els fitxers multimèdia de l'usuari amb el user_id passat
        $multimediaFiles = Multimedia::where('user_id', $userId)->get();

        // Si no hi ha fitxers per aquest usuari, retornem un missatge d'error
        if ($multimediaFiles->isEmpty()) {
            return response()->json(['error' => 'No hi ha fitxers per aquest usuari.'], 404);
        }

        // Retornem els fitxers trobats
        return response()->json($multimediaFiles);
    }

    public function destroy($id)
    {
        $multimedia = Multimedia::findOrFail($id);

        // Comprovem si l'usuari autenticat pot eliminar el fitxer (si és el seu)
        if ($multimedia->user_id !== Auth::id()) {
            return response()->json(['error' => 'No tens permís per eliminar aquest fitxer.'], 403);
        }

        // Eliminem el fitxer físicament
        Storage::delete($multimedia->file_path);
        $multimedia->delete();
        return response()->json(['message' => 'Fitxer eliminat correctament']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'file_name' => 'string|max:255',
        ]);

        $multimedia = Multimedia::findOrFail($id);

        if ($multimedia->user_id !== Auth::id()) {
            return response()->json(['error' => 'No tens permís per editar aquest fitxer.'], 403);
        }

        if ($request->has('file_name')) {
            $multimedia->file_name = $request->file_name;
        }

        $multimedia->save();

        return response()->json(['message' => 'Fitxer actualitzat correctament', 'multimedia' => $multimedia]);
    }

    public function showFile($id)
    {
        $multimedia = Multimedia::findOrFail($id);

        // Optional: Check if the user has permission to view this file
        if ($multimedia->user_id !== Auth::id()) {
            return response()->json(['error' => 'No tens permís per veure aquest fitxer.'], 403);
        }

        return response()->json($multimedia);
    }
}

